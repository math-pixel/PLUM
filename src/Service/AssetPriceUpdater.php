<?php

namespace App\Service;

use App\Repository\AssetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;

class AssetPriceUpdater
{
    private HttpClientInterface $client;
    private AssetRepository $assetRepository;
    private EntityManagerInterface $em;
    private string $apiKey;
    private LoggerInterface $logger;

    public function __construct(HttpClientInterface $client, AssetRepository $assetRepository, EntityManagerInterface $em, LoggerInterface $logger, string $alphavantageApiKey)
    {
        $this->client = $client;
        $this->assetRepository = $assetRepository;
        $this->em = $em;
        $this->logger = $logger;
        $this->apiKey = $alphavantageApiKey;
    }

    public function updatePrices(): void
    {
        $assets = $this->assetRepository->findAll();

        foreach ($assets as $asset) {
            $symbol = $asset->getSymbol();
            if (!$symbol) {
                continue;
            }

            try {
                $response = $this->client->request('GET', 'https://www.alphavantage.co/query', [
                    'query' => [
                        'function' => 'TIME_SERIES_DAILY',
                        'symbol' => $symbol,
                        'apikey' => $this->apiKey,
                    ]
                ]);

                $data = $response->toArray(false); // use false to avoid automatic exceptions on 4xx/5xx

                if (!isset($data['Time Series (Daily)']) || empty($data['Time Series (Daily)'])) {
                    $this->logger->warning("No daily data for symbol: $symbol", $data);
                    continue;
                }

                $dailyData = $data['Time Series (Daily)'];
                $lastDate = array_key_first($dailyData);
                $lastClose = $dailyData[$lastDate]['4. close'] ?? null;

                if ($lastClose !== null) {
                    $asset->setCurrentValue((float) $lastClose);
                    $this->em->persist($asset);
                }
            } catch (\Throwable $e) {
                $this->logger->error("Error updating price for $symbol: " . $e->getMessage());
                continue;
            }
        }

        $this->em->flush();
    }
}
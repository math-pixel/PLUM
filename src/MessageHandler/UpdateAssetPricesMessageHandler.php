<?php

namespace App\MessageHandler;

use App\Message\UpdateAssetPricesMessage;
use App\Service\AssetPriceUpdater;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateAssetPricesMessageHandler
{
    public function __construct(private AssetPriceUpdater $updater) {}

    public function __invoke(UpdateAssetPricesMessage $message): void
    {
        $this->updater->updatePrices();
    }
}
<?php

namespace App\Command;

use App\Service\AssetPriceUpdater;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:update-asset-prices',
    description: 'Met à jour les prix des assets via l\'API Finnhub',
)]
class UpdateAssetPricesCommand extends Command
{
    private AssetPriceUpdater $updater;

    public function __construct(AssetPriceUpdater $updater)
    {
        parent::__construct();
        $this->updater = $updater;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('🔄 Mise à jour des prix des assets...');
        $this->updater->updatePrices();
        $output->writeln('✅ Mise à jour terminée.');

        return Command::SUCCESS;
    }
}
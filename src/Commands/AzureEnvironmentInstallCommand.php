<?php

namespace ChrisReedIO\SocialmentBastionAzure\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function base_path;
use function implode;

class AzureEnvironmentInstallCommand extends Command
{
    public $signature = 'azure:install:env';

    public $description = 'Installs the Azure Socialment .env parameters';

    public function handle(): int
    {
        // We need to inject these 4 lines into the .env and .env.example files
        $additionalLines = [
            '',
            '# Socialment - Azure Provider Variables',
            'AZURE_TENANT_ID=""',
            'AZURE_CLIENT_ID=""',
            'AZURE_CLIENT_SECRET=""',
            'AZURE_REDIRECT_URI="${APP_URL}/login/azure/callback"',
            '',
        ];

        $this->injectIntoEnv(base_path('.env'), $additionalLines);
        $this->injectIntoEnv(base_path('.env.example'), $additionalLines);

        return self::SUCCESS;
    }

    protected function injectIntoEnv(string $file, array $additionalLines, int $existingLineCheck = 1): bool
    {
        if (empty($additionalLines)) {
            return false;
        }

        $envContents = File::get($file);

        if (str_contains($envContents, $additionalLines[$existingLineCheck])) {
            $this->info("\t" . basename($file) . ' already patched.');

            return false;
        }

        $this->comment('Injecting Socialment - Azure Provider Environment Variables into the ' . basename($file) . ' file...');
        File::append($file, implode("\n", $additionalLines));
        $this->info("\t" . basename($file) . ' updated successfully.');

        return true;
    }
}

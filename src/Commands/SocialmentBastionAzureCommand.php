<?php

namespace ChrisReedIO\SocialmentBastionAzure\Commands;

use Illuminate\Console\Command;

class SocialmentBastionAzureCommand extends Command
{
    public $signature = 'azure:install';

    public $description = 'Installs the Azure Socialment driver';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

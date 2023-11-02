<?php

namespace ChrisReedIO\SocialmentBastionAzure\Commands;

use Illuminate\Console\Command;

class SocialmentBastionAzureCommand extends Command
{
    public $signature = 'socialment-bastion-azure';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

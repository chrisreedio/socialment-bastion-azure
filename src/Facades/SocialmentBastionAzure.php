<?php

namespace ChrisReedIO\SocialmentBastionAzure\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ChrisReedIO\SocialmentBastionAzure\SocialmentBastionAzure
 */
class SocialmentBastionAzure extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ChrisReedIO\SocialmentBastionAzure\SocialmentBastionAzure::class;
    }
}

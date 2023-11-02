<?php

namespace ChrisReedIO\SocialmentBastionAzure;

use ChrisReedIO\SocialmentBastionAzure\Commands\AzureEnvironmentInstallCommand;
use ChrisReedIO\SocialmentBastionAzure\Commands\SocialmentBastionAzureCommand;
use ChrisReedIO\SocialmentBastionAzure\Testing\TestsSocialmentBastionAzure;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use SocialiteProviders\Azure\AzureExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

use function config_path;
use function database_path;
use function file_exists;

class SocialmentBastionAzureServiceProvider extends PackageServiceProvider
{
    public static string $name = 'socialment-bastion-azure';

    public static string $viewNamespace = 'socialment-bastion-azure';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->startWith(function (InstallCommand $command) {
                        $command->comment('Publishing Socialment\'s Migrations...');
                        // $command->call('socialment:install');
                        $command->call('vendor:publish', [
                            '--provider' => 'ChrisReedIO\Socialment\SocialmentServiceProvider',
                            '--tag' => 'socialment-migrations',
                        ]);

                        $command->comment('Publishing Spatie\'s Migrations...');
                        $command->call('vendor:publish', [
                            '--provider' => 'Spatie\Permission\PermissionServiceProvider',
                            '--tag' => 'permission-migrations',
                        ]);

                        // $command->comment('Running Bastion\'s Install...');
                        // $command->call('bastion:install');
                        $command->comment('Publishing Bastion\'s Migrations...');
                        $command->call('vendor:publish', [
                            '--provider' => 'ChrisReedIO\Bastion\BastionServiceProvider',
                            '--tag' => 'bastion-migrations',
                        ]);

                        // if ($command->ask('Would you like to inject the Azure Socialment .env parameters?', 'yes')) {
                        $command->comment('Patching .env files...');
                        $command->call('azure:install:env');
                        // }

                        if ($command->ask('Publish the Azure Seeder?')) {
                            $command->comment('Publishing Bastion\'s Azure Seeders...');
                            $command->call('vendor:publish', [
                                // '--provider' => 'ChrisReedIO\SocialmentBastionAzure\SocialmentBastionAzureServiceProvider',
                                '--tag' => 'socialment-azure-seeder',
                                '--force' => false,
                            ]);
                        }

                        // if ($command->ask('Would you like to force publish the Services config file?')) {
                        //     // This will overwrite the config file even if it already exists
                        //     $command->comment('Publishing Socialment\'s service config file...');
                        //     $command->call('vendor:publish', [
                        //         // '--provider' => 'ChrisReedIO\Socialment\SocialmentServiceProvider',
                        //         '--tag' => 'socialment-bastion-azure-config',
                        //         '--force' => true,
                        //     ]);
                        // }
                    })
                    ->endWith(function (InstallCommand $command) {

                    });
                // ->publishConfigFile();
                // ->publishMigrations()
                // ->askToRunMigrations()
                // ->askToStarRepoOnGitHub('chrisreedio/socialment-bastion-azure');
            });

        $configFileName = 'services';

        if (file_exists($package->basePath('/../config'))) {
            $package->hasConfigFile(['services']);
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }

        if (file_exists($package->basePath('/../config/services.php'))) {
            $this->publishes([
                $package->basePath('/../config') => config_path(),
            ], 'socialment-azure-config');
        }

        // Override the base bastion seeder
        if (file_exists($package->basePath('/../database/seeders'))) {
            $this->publishes([
                $package->basePath('/../database/seeders') => database_path('seeders'),
            ], 'socialment-azure-seeder');
        }
    }

    public function packageRegistered(): void
    {
        // $this->mergeConfigFrom(__DIR__ . '/../config/services.php', 'services');
    }

    public function packageBooted(): void
    {
        $this->mergeListeners();
        // Asset Registration
        // FilamentAsset::register(
        //     $this->getAssets(),
        //     $this->getAssetPackageName()
        // );
        //
        // FilamentAsset::registerScriptData(
        //     $this->getScriptData(),
        //     $this->getAssetPackageName()
        // );

        // Icon Registration
        // FilamentIcon::register($this->getIcons());

        // Handle Stubs
        // if (app()->runningInConsole()) {
        //     foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
        //         $this->publishes([
        //             $file->getRealPath() => base_path("stubs/socialment-bastion-azure/{$file->getFilename()}"),
        //         ], 'socialment-bastion-azure-stubs');
        //     }
        // }

        // Testing
        // Testable::mixin(new TestsSocialmentBastionAzure());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'chrisreedio/socialment-bastion-azure';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('socialment-bastion-azure', __DIR__ . '/../resources/dist/components/socialment-bastion-azure.js'),
            // Css::make('socialment-bastion-azure-styles', __DIR__ . '/../resources/dist/socialment-bastion-azure.css'),
            // Js::make('socialment-bastion-azure-scripts', __DIR__ . '/../resources/dist/socialment-bastion-azure.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            SocialmentBastionAzureCommand::class,
            AzureEnvironmentInstallCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            // 'create_socialment-bastion-azure_table',
        ];
    }

    protected function mergeListeners(): void
    {
        // Retrieve the existing listeners
        $listen = $this->app['events']->getListeners(SocialiteWasCalled::class) ?? [];

        // Define your listener if it's not already present
        if (! in_array(AzureExtendSocialite::class . '@handle', $listen)) {
            $this->app['events']->listen(
                SocialiteWasCalled::class,
                AzureExtendSocialite::class . '@handle'
            );
        }
    }
}

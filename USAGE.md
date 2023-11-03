#  Socialment-Bastion-Azure Stack

This package takes care of adding Socialment (OAuth Login) and Bastion (Spatie Roles and Permissions) for Filament as well as preconfiguring them to work with Azure.

Also provided out of the box is functionality to sync the user's application roles to their Active Directory Groups via SSO Group name mapping.

This occurs upon every login of the user by hooking the Socialment pre-login callback.

## Getting Started

#### Install Laravel & Filament

Set up a new Laravel project and install Filament.

## Pre-Install

Set the `minimum-stability` in your `composer.json`  to `beta`.

## Install

Install the package via `composer`.

`composer require chrisreedio/socialment-bastion-azure:^3.0@beta`

## Post Install

### Generated Files

Now we need to perform the post package installation setup..

`php artisan socialment-bastion-azure:install`

This generates the migrations (and optional Role seeder).
It also injects the Azure AD variables into your `.env` and `.env.example`.

Answer `yes` to publishing the seeder.

You should now have migrations and a `RoleSeeder.php` added to your project.
### Role Seeder

Ensure the `RoleSeeder` is called in your `DatabaseSeeder.php`.

```php
$this->call([  
    RoleSeeder::class,  
]);
```

Edit the `RoleSeeder.php` and populate the appropriate Azure Active Directory Groups for each role.

### User HasRoles Trait

Add the `HasRoles` trait to the `User` model.

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable  
{  
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

	// ... The rest of the User model code...
}
```

### Database Migration & Seeding

At this point, you should be able to run the database migrations and seed the database.

`php artisan migrate:fresh --seed`

### Environment Variables

Edit the `.env` and populate the Azure Tenant ID, Client ID, and Client Secret variables.

### PanelProvider Configuration

Ensure you have the plugins being activated/called in your `PanelProvider`.
By default this will be in the `AdminPanelProvider.php`.

```php
->plugins([  
    \ChrisReedIO\Bastion\BastionPlugin::make()  
        ->superAdminRole('Developer'),  
    \ChrisReedIO\Socialment\SocialmentPlugin::make()  
        ->registerProvider('azure', 'fab-microsoft', 'Azure AD'),  
])
```

### Azure Configuration

#### Web Redirect URIs

Ensure you add your Azure Redirect URI to the Azure App Registration.

It should be in the format of `https://DOMAIN/login/azure/callback`

#### Azure API Permissions

You will need to grant your app registration the following permissions:

- `Directory.Read.All`
- `GroupMember.Read.All`
- `User.Read`
## Setup Complete!

At this point everything should be configured and working!

You should be able to navigate to your site at `https://domain/admin` and click the `Azure AD` button.

If you're already logged into your AD account in your browser you should log straight in as long as you have one of the configured roles via an Active Directory group.

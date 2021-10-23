![maguttiCms](https://www.magutti.com/public//website/images/logo.png)


## About maguttiCms
Open source multilingual Laravel 8.x Cms with shopping cart and social login.

## Version
Laravel 8.x

maguttiCms is released using Laravel 8.x, Vue 3 and  Boostrap 5.
maguttiCms requires PHP 7.4 or 8.0 .
### How to Install


Clone this repository and install the dependencies.

    $ git clone https://github.com/marcoax/maguttiCms.git
    $ composer install

On PHP8 if you have trouble try to run composer update

Configure your .env file. 

    $ rename env.example file to .env and set your db connection data

Import DB tables run

    $ php artisan magutticms::seed
    
in alternative you can create db tables importing **framework_base.sql** file located under the db folder.

The run the following  command

    $ php artisan key:generate
    $ npm install
    $ npm run production
    
 
 To access the admin panel (http://yourpath/admin)
 - email: cmsadmin@magutti.com
 - password: password
 
 For shared hosting you can set ASSET_PUBLIC_PATH in .env  file (eg ASSET_PUBLIC_PATH='public/')
   
### Features
 - Free and open source
 - Multi languages
 - Different Authentication for Admin panel and Front-end with user roles access permission
 - Social login with Socialite 
 - E-shop 
 - PayPal Express Checkout Payment integration
 - Customizable payment and shipping methods 
 - Seo friendly
 - Admin model form generator via artisan command **[magutticms:create-model](https://github.com/marcoax/maguttiCms/wiki/How-to-Create-a-New-Resource)**
  
### Server Requirements
 
 - PHP >= 7.4 | 8.0
 - BCMath PHP Extension
 - Ctype PHP Extension
 - Fileinfo PHP extension
 - JSON PHP Extension
 - Mbstring PHP Extension
 - OpenSSL PHP Extension
 - PDO PHP Extension
 - Tokenizer PHP Extension
 - XML PHP Extension

## User Guide
See **[Wiki](https://github.com/marcoax/maguttiCms/wiki/)**.

## Commands
## magutticms:create-model
Artisan helper to create a model and the related admin form configuration fields from a db table. 

License
=======
Code released under the MIT license.

Security Vulnerabilities
=======
If you discover a security vulnerability within maguttiCms, please send an e-mail to  at hello@magutti.com. All security vulnerabilities will be promptly addressed.




<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Requirements
- PHP 7.1 or higher
- Redis
- NodeJs
- MySql

## Set Up
- run composer install
- copy .env.example to your .env file and edit your database requirements
- run 'php artisan migrate'
- run 'php artisan db:seed' [for populating admin user and it's permission]
- default user 		: admin@sample.com
- default password 	: password123
- please run npm install on root_folder/socket
- run 'node socket.js' on root_foler/socket


## Info
- this is a sample code only
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About This App

This is a simple laravel app with admin pannel. It allows the admin to CRUD users and roles.

It allows users to CRUD events to calendar.

It has a public page that shows events for all users.

## To run the demo

There are 3 demo accounts

```
admin : admin@example.com
pass : admin

username : user@example.com
pass : user

username : user2@example.com
pass : user2
```


## To Run the Demo
```
php artisan migrate
```
```
php artisan db:seed
```
Copy .env.example to .env and edit values (if requried)

Note : Database name is : cal
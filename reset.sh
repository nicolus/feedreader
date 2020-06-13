#!/usr/bin/bash

rm ./public/storage/img/*
php artisan storage:link
php artisan migrate:refresh
#php artisan passport:install
php artisan db:seed
php artisan feeds:update
php artisan horizon

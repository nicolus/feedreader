#!/usr/bin/env bash

rm ./public/img/*
php artisan migrate:refresh
php artisan db:seed
php artisan feeds:update
php artisan horizon

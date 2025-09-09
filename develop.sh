#!/bin/bash

##
# Application path.
##
pwd_path=$(pwd)

##
# Install hosting directory structure.
##
$pwd_path/appcli cli:install
  
##
# Generate application key
##
php artisan key:generate

##
# Set database connection to database
##
touch $pwd_path/../hosting/config/database.sqlite
echo "DB_CONNECTION=sqlite" >> .env
echo "DB_DATABASE=$pwd_path/../hosting/config/database.sqlite" >> .env

##
#  artisan table creation 
##
php artisan session:table
php artisan migrate

##
#  Set up default site
##
php artisan cli:site:creation "examples.com"

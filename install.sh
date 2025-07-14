#!/bin/bash

# Install default packages.
sudo apt install git
sudo apt install php

# Install composer.
cd ~
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
composer update

# Create default env.
cp .env.example .env

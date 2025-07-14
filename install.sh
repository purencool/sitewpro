#!/bin/bash

# Install default packages.
sudo apt install git
sudo apt install php
sudo apt install php-curl -y
sudo apt install php-xml -y
sudo apt install p7zip-full p7zip-rar -y

# Install composer.
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
/usr/local/bin/composer update

# Create default env.
cp .env.example .env

#!/bin/bash

##
# Install bases packages on the host server.
##
if [[ "$1" == "debian" ]]; then
  # Update and upgrade the system.
  sudo apt-get update & sudo apt upgrade

  # Install default packages.
  sudo apt-get install git php php-cli php-curl php-xml p7zip-full p7zip-rar ca-certificates php-sqlite3 curl -y

  # Setup docker
  sudo install -m 0755 -d /etc/apt/keyrings
  sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
  sudo chmod a+r /etc/apt/keyrings/docker.asc

  # Add the repository to Apt sources:
  echo \
    "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
    $(. /etc/os-release && echo "${UBUNTU_CODENAME:-$VERSION_CODENAME}") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
  sudo apt-get update
  sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
  sudo docker run hello-world
  sudo usermod -aG docker $USER

  # Install composer.
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  php composer-setup.php
  php -r "unlink('composer-setup.php');"
  mv composer.phar /usr/local/bin/composer
fi

if [[ "$1" == "centos" ]]; then
  # Update and upgrade the system.
  sudo yum update -y & sudo yum upgrade -y    

  # Install default packages.
  sudo yum install git php php-cli php-curl php-xml p7zip p7zip-rar ca-certificates php-sqlite3 curl -y   

  # Setup docker
  sudo yum install -y yum-utils
  sudo yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
  sudo yum install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
  sudo systemctl start docker
  sudo docker run hello-world
  sudo usermod -aG docker $USER

  # Install composer.
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  php composer-setup.php
  php -r "unlink('composer-setup.php');"
  mv composer.phar /usr/local/bin/composer
fi

##
# Install application.
##
git clone https://github.com/purencool/sitewpro.git app
cd ./app
cp .env.example .env
/usr/local/bin/composer update

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
# Set database connection to sqlite
##
echo "Install sqlite for development purposes? (y/n)"
read install_sqlite
if [[ "$install_sqlite" == "y" || "$install_sqlite" == "Y" ]]; then
  touch $pwd_path/../hosting/config/database.sqlite
  chmod 777 $pwd_path/../hosting/database.sqlite
  echo "DB_CONNECTION=sqlite" >> .env
  echo "DB_DATABASE=$pwd_path/../hosting/config/database.sqlite" >> .env
else
  echo "Installation of a database was skipped."
fi

##
#  artisan table creation 
##
php artisan session:table
php artisan migrate

##
#  Set up default site
##
echo "Do you want to install examples.com as a test site now? (y/n)"
read install_site
if [[ "$install_site" == "y" || "$install_site" == "Y" ]]; then
  php artisan spro:site:creation "examples.com"
fi

echo "Run the following command `cd ./sitenpro/app && ./cli`."
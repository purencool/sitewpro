#!/bin/bash

##
# Install bases packages on the host server.
##
if [[ "$1" == "debian" ]]; then
  mkdir sitenpro
  cd sitenpro
  git clone https://github.com/purencool/sitewpro.git app

  sudo apt-get update & sudo apt upgrade

  # Install default packages.
  sudo apt-get install git php php-cli php-curl php-xml p7zip-full p7zip-rar ca-certificates curl -y

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

  ##
  # Install composer.
  ##
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  php composer-setup.php
  php -r "unlink('composer-setup.php');"
  sudo mv composer.phar /usr/local/bin/composer

  ##
  # Install application
  ##
  cd ./app
  cp .env.example .env
  /usr/local/bin/composer update

  echo "Do you want to install examples.com as a test site now? (y/n)"
  read install_site
  if [[ "$install_site" == "y" || "$install_site" == "Y" ]]; then
    php artisan spro:site:creation "examples.com"
  fi
else
    echo "Installation was not completed"
fi

echo "Installation completed successfully. Change directory to app and run './cli' to see all available commands."
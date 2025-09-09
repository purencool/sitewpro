#!/bin/bash

##
# Update host packages.
##
if [[ "$1" == "debian" ]]; then
  # Update and upgrade the system.
  sudo apt-get update & sudo apt upgrade

fi

if [[ "$1" == "centos" ]]; then
  # Update and upgrade the system.
  sudo yum update -y & sudo yum upgrade -y    
fi

composer self-update
git pull origin main

##
# Application path.
##
pwd_path=$(pwd)

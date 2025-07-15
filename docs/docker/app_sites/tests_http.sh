#!/bin/bash

# Declare an associative array
declare -A URLS
URLS=(
  [hotels]="http://localhost:8080"
  [houses]="http://localhost:8081"
  [nginx_hotels]="http://hotels.cfapp/"
  [nginx_houses]="http://houses.cfapp/"
)

for key in "${!URLS[@]}"; do
  url="${URLS[$key]}"
  status_code=$(curl -s -o /dev/null -w "%{http_code}" "$url")
  if [ "$status_code" -eq 200 ]; then
    echo "Front page is up! (HTTP 200) from $key: $url"
  else
    echo "Front page returned status $status_code from $key: $url"
  fi
done

#!/bin/bash

# Declare an associative array
declare -A URLS
URLS=(
  [html]="http://localhost:8080"
  [php]="http://localhost:8081"
  [node]="http://localhost:8082"
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

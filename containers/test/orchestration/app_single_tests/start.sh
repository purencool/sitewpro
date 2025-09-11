#!/bin/bash

docker compose -f docker-compose.default_html.yml \
               -f docker-compose.php_html.yml \
               -f docker-compose.node_html.yml \
               up -d

#!/bin/bash

docker compose -f docker-compose_http.yml \
     -f ./apps/shared/hotels_cfapp/compose/docker-compose.hotels_cfapp.yml \
     -f ./apps/shared/houses_cfapp/compose/docker-compose.houses_cfapp.yml \
               up -d

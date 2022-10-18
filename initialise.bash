#!/bin/bash

echo "Initialise docker environment"

docker-compose up -d

echo "Go in the container"

docker-compose exec --workdir /app php /bin/bash

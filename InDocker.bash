#!/bin/bash

echo "Install dependencies"

composer install

echo "Initialising database..."

php vendor/bin/doctrine orm:schema-tool:create

echo "Initialisation complete."

echo "Seeding..."

./vendor/bin/doctrine-migrations migrate

echo "Seeding complete."
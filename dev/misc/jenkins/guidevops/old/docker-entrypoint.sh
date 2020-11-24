#!/bin/bash

cd /var/tests_skeleton

# Install dependencies
composer clear-cache
composer config -g github-oauth.github.com 2b8e9c3f1dbb6d060d5ca85fe6d3c07cd3de10f0
composer install --no-interaction --prefer-source

# Launch Test
php ./bin/bs run Test/Project DemoCest.php

exec "$@"
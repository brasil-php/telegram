#!/usr/bin/env bash

composer clear-cache
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

curl -X DELETE "https://api.cloudflare.com/client/v4/zones/e94474edfacef19bc9202a2f2f886703/purge_cache" \
     -H "X-Auth-Email: wilcorrea@gmail.com" \
     -H "X-Auth-Key: ce68c7b989d316ab1d99e8792d42a63593885" \
     -H "Content-Type: application/json" \
     --data '{"purge_everything":true}'

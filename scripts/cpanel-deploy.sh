#!/usr/bin/env bash

set -Eeuo pipefail

PROJECT_PATH="${1:-}"

if [[ -z "$PROJECT_PATH" || "$PROJECT_PATH" == "/" ]]; then
    echo "A safe Laravel project path is required."
    exit 1
fi

cd "$PROJECT_PATH"

if [[ ! -f artisan ]]; then
    echo "No artisan file found in $PROJECT_PATH."
    exit 1
fi

if [[ ! -f .env ]]; then
    echo "Create $PROJECT_PATH/.env on the server before the first deployment."
    exit 1
fi

mkdir -p \
    bootstrap/cache \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

chmod -R ug+rwX bootstrap/cache storage

php artisan down --retry=60 || true

restore_application() {
    php artisan up || true
}
trap restore_application EXIT

php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
php artisan storage:link || true
php artisan up

trap - EXIT

echo "University deployment completed successfully."

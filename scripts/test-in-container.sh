#!/usr/bin/env bash
#
# Run the test suite in a Docker container against a specific Laravel version.
#
# This package depends on macsidigital/laravel-api-client, which in turn
# depends on macsidigital/laravel-oauth2-client. Both live as sibling forks
# of this repo; we resolve them via composer path repositories so local
# changes are picked up without round-tripping through packagist.
#
# Usage:
#   scripts/test-in-container.sh [laravel-major] [-- ...phpunit args]
#
# Env:
#   API_CLIENT_PATH      Absolute path to sibling laravel-api-client.
#                        (defaults to ../laravel-api-client)
#   OAUTH2_PATH          Absolute path to sibling laravel-oauth2-client.
#                        (defaults to ../laravel-oauth2-client)
#   COMPOSER_IMAGE       Docker image to use (default: composer:2.8).

set -euo pipefail

LARAVEL="${1:-11}"
if [[ $# -gt 0 ]]; then shift; fi
COMPOSER_IMAGE="${COMPOSER_IMAGE:-composer:2.8}"

case "$LARAVEL" in
    9)  TESTBENCH="^7.0"; PHPUNIT="^9.5" ;;
    10) TESTBENCH="^8.0"; PHPUNIT="^10.0" ;;
    11) TESTBENCH="^9.0"; PHPUNIT="^10.5" ;;
    *)  echo "Unsupported Laravel major: $LARAVEL (supported: 9, 10, 11)" >&2; exit 2 ;;
esac

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
API_CLIENT_PATH="${API_CLIENT_PATH:-$(cd "$PROJECT_ROOT/../laravel-api-client" 2>/dev/null && pwd || true)}"
OAUTH2_PATH="${OAUTH2_PATH:-$(cd "$PROJECT_ROOT/../laravel-oauth2-client" 2>/dev/null && pwd || true)}"

for dep in "API_CLIENT_PATH:$API_CLIENT_PATH" "OAUTH2_PATH:$OAUTH2_PATH"; do
    name="${dep%%:*}"; path="${dep#*:}"
    if [[ -z "$path" || ! -d "$path" ]]; then
        echo "$name not found. Set it or clone the fork to a sibling directory." >&2
        exit 3
    fi
done

WORK_DIR="$(mktemp -d -t laravel-zoho-subscriptions-test.XXXXXX)"
trap 'rm -rf "$WORK_DIR"' EXIT

echo ">> Staging in $WORK_DIR (Laravel $LARAVEL)"
cp -r "$PROJECT_ROOT"      "$WORK_DIR/zoho-subscriptions"
cp -r "$API_CLIENT_PATH"   "$WORK_DIR/api-client"
cp -r "$OAUTH2_PATH"       "$WORK_DIR/oauth2-client"
rm -rf "$WORK_DIR/zoho-subscriptions/vendor" "$WORK_DIR/zoho-subscriptions/composer.lock"
rm -rf "$WORK_DIR/api-client/vendor"         "$WORK_DIR/api-client/composer.lock"
rm -rf "$WORK_DIR/oauth2-client/vendor"      "$WORK_DIR/oauth2-client/composer.lock"

run_composer () {
    docker run --rm \
        -v "$WORK_DIR:/work" -w "/work/zoho-subscriptions" \
        -u "$(id -u):$(id -g)" \
        -e COMPOSER_HOME=/tmp/composer-cache -e COMPOSER_ALLOW_SUPERUSER=1 \
        "$COMPOSER_IMAGE" "$@"
}

echo ">> Rewriting composer repositories to use local paths"
# Start from a clean repositories list so we override the git VCS entries.
run_composer config --unset repositories.0 || true
run_composer config --unset repositories.1 || true
run_composer config repositories.api-client-path   '{"type":"path","url":"../api-client","options":{"symlink":false}}'
run_composer config repositories.oauth2-path       '{"type":"path","url":"../oauth2-client","options":{"symlink":false}}'

echo ">> Pinning framework to ^$LARAVEL.0 / testbench $TESTBENCH / phpunit $PHPUNIT"
run_composer require --dev --no-interaction --no-update \
    "laravel/framework:^${LARAVEL}.0" \
    "orchestra/testbench:${TESTBENCH}" \
    "phpunit/phpunit:${PHPUNIT}"

echo ">> composer update"
run_composer update --prefer-stable --prefer-dist --no-interaction

echo ">> Running PHPUnit"
docker run --rm \
    -v "$WORK_DIR:/work" -w "/work/zoho-subscriptions" \
    -u "$(id -u):$(id -g)" \
    --entrypoint php \
    "$COMPOSER_IMAGE" \
    vendor/bin/phpunit "$@"

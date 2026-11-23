#!/bin/sh
set -eu

WP_PATH="${WP_PATH:-/var/www/html}"
SEED_FILE="${SEED_FILE:-/seed/seed.sql}"
SITE_URL="${SITE_URL%/}"
SEED_URL="${SEED_URL%/}"

cd "$WP_PATH"

fail() {
    echo "setup: $1" >&2
    exit 1
}

case "$ADMIN_PASSWORD" in
    ""|change-me|password|admin) fail "set a real ADMIN_PASSWORD in .env" ;;
esac
if [ "${#ADMIN_PASSWORD}" -lt 12 ]; then
    fail "ADMIN_PASSWORD must be at least 12 characters"
fi

tries=0
until [ -f wp-config.php ]; do
    tries=$((tries + 1))
    [ "$tries" -gt 90 ] && fail "wp-config.php was not created by the wordpress container"
    sleep 2
done

tries=0
until wp db query "SELECT 1" >/dev/null 2>&1; do
    tries=$((tries + 1))
    [ "$tries" -gt 60 ] && fail "cannot reach the database"
    sleep 2
done

if ! wp core is-installed >/dev/null 2>&1; then
    [ -f "$SEED_FILE" ] || fail "seed file $SEED_FILE not found"
    echo "setup: importing the Passive Web database"
    wp db import "$SEED_FILE"
    if [ "$SEED_URL" != "$SITE_URL" ]; then
        wp search-replace "$SEED_URL" "$SITE_URL" --all-tables-with-prefix --precise --report-changed-only
    fi
fi

wp option update home "$SITE_URL" >/dev/null
wp option update siteurl "$SITE_URL" >/dev/null

if ! wp user get "$ADMIN_USER" --field=ID >/dev/null 2>&1; then
    echo "setup: creating admin user $ADMIN_USER"
    wp user create "$ADMIN_USER" "$ADMIN_EMAIL" --role=administrator --user_pass="$ADMIN_PASSWORD" >/dev/null
fi

ADMIN_ID="$(wp user get "$ADMIN_USER" --field=ID)"
wp db query "UPDATE wp_posts SET post_author = ${ADMIN_ID} WHERE post_author NOT IN (SELECT ID FROM wp_users)" >/dev/null
wp option update admin_email "$ADMIN_EMAIL" >/dev/null
wp rewrite structure '/%postname%/' >/dev/null
wp rewrite flush >/dev/null

echo "setup: done, open $SITE_URL (admin: $SITE_URL/wp-admin)"

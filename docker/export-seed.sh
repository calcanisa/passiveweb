#!/bin/sh
set -eu

WP_PATH="${WP_PATH:-/var/www/html}"
OUT_FILE="${OUT_FILE:-/seed-out/seed.sql}"
SITE_URL="${SITE_URL%/}"
SEED_URL="${SEED_URL%/}"
SOURCE_DB="${WORDPRESS_DB_NAME}"
SCRATCH_DB="seed_export"
DB_HOST="${WORDPRESS_DB_HOST}"

fail() {
    echo "export: $1" >&2
    exit 1
}

[ -n "${DB_ROOT_PASSWORD:-}" ] || fail "DB_ROOT_PASSWORD is not set"
[ "$SOURCE_DB" != "$SCRATCH_DB" ] || fail "source and scratch database names must differ"

cd "$WP_PATH"

root_sql() {
    MYSQL_PWD="$DB_ROOT_PASSWORD" mysql -h "$DB_HOST" -u root "$@"
}

cleanup() {
    root_sql -e "DROP DATABASE IF EXISTS \`${SCRATCH_DB}\`" >/dev/null 2>&1 || true
}
trap cleanup EXIT

root_sql -e "DROP DATABASE IF EXISTS \`${SCRATCH_DB}\`; CREATE DATABASE \`${SCRATCH_DB}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
MYSQL_PWD="$DB_ROOT_PASSWORD" mysqldump -h "$DB_HOST" -u root --single-transaction --no-tablespaces --default-character-set=utf8mb4 "$SOURCE_DB" | root_sql "$SCRATCH_DB"

export WORDPRESS_DB_NAME="$SCRATCH_DB"
export WORDPRESS_DB_USER=root
export WORDPRESS_DB_PASSWORD="$DB_ROOT_PASSWORD"

if [ "$SITE_URL" != "$SEED_URL" ]; then
    wp search-replace "$SITE_URL" "$SEED_URL" --all-tables-with-prefix --precise --report-changed-only
fi

wp db query "DELETE FROM wp_options WHERE option_name LIKE '\\_transient\\_%' OR option_name LIKE '\\_site\\_transient\\_%' OR option_name IN ('rewrite_rules', 'recovery_keys', 'auto_updater.lock', 'core_updater.lock')"
wp db query "UPDATE wp_options SET option_value = 'admin@example.com' WHERE option_name IN ('admin_email', 'new_admin_email')"
wp db query "TRUNCATE TABLE wp_users"
wp db query "TRUNCATE TABLE wp_usermeta"
wp db query "UPDATE wp_comments SET comment_author_IP = ''"

TMP_FILE="${OUT_FILE}.tmp"
MYSQL_PWD="$DB_ROOT_PASSWORD" mysqldump -h "$DB_HOST" -u root --single-transaction --no-tablespaces --skip-dump-date --skip-comments --default-character-set=utf8mb4 "$SCRATCH_DB" > "$TMP_FILE"
mv "$TMP_FILE" "$OUT_FILE"

echo "export: wrote $OUT_FILE"

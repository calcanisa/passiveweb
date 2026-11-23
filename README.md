# Passive Web

The full passiveweb.co.za WordPress site, run locally with Docker.

## What is in the repo

- `wp-content/themes/passiveweb`: the theme
- `wp-content/plugins/passiveweb-core`: the core plugin (quote form, SEO, security headers)
- `wp-content/uploads`: media files
- `db/seed.sql`: the site database (pages and Customizer settings), with no users or passwords
- `docker-compose.yml` and `docker/setup.sh`: the local environment

WordPress core comes from the official `wordpress` Docker image, so it is not stored in the repo.

## First run

1. Copy `.env.example` to `.env`.
2. In `.env`, set `HOST_UID` and `HOST_GID` to the output of `id -u` and `id -g`, and set real values for `DB_PASSWORD`, `DB_ROOT_PASSWORD`, `ADMIN_USER`, `ADMIN_EMAIL` and `ADMIN_PASSWORD` (at least 12 characters).
3. Start everything:

   ```
   docker compose up -d
   docker compose logs -f setup
   ```

4. When setup prints `done`, open http://localhost:8080 and log in at http://localhost:8080/wp-admin.

The `setup` container imports `db/seed.sql` the first time only, then creates your admin user from `.env`. It is safe to run again.

## Everyday use

- Start: `docker compose up -d`
- Stop: `docker compose down`
- Run WP-CLI: `docker compose run --rm --entrypoint wp setup plugin list`
- Start over with a fresh database: `docker compose down -v`, then `docker compose up -d`
- PHP errors are logged to `wp-content/debug.log` (ignored by git)

Theme and plugin files are mounted from this folder, so edits show up straight away.

## Saving database changes to the repo

After changing Customizer settings or pages locally, write them back to `db/seed.sql`:

```
docker compose --profile tools run --rm seed-export
```

This exports a copy of your local database with users, passwords, your email address and cached data removed, so it is safe to commit.

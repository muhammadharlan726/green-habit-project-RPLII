Deployment notes — PHP 8.4 (Railway / Docker)

- Recommended: Deploy using the repository `Dockerfile` so the build runs on PHP 8.4.
- Alternative: regenerate `composer.lock` on a machine running PHP 8.2 and commit the updated lock.

Railway using Dockerfile:

1. In Railway, create a new service and choose "Deploy from Dockerfile" (or configure existing service to use Dockerfile in repo root).
2. Railway will build the image using the `Dockerfile` and run the container. Ensure environment variables are set (database, `APP_KEY`, etc.).

Local quick test:

```bash
docker build -t greenhabit .
docker run --rm -it -p 8000:8000 greenhabit bash -c "php artisan serve --host=0.0.0.0 --port=8000"
```

If you cannot use Docker / PHP 8.4 on the server:

- Regenerate lockfile for PHP 8.2 locally and push:

```bash
# ensure your local PHP is 8.2.x
composer update --with-all-dependencies
git add composer.lock
git commit -m "Regenerate composer.lock for PHP 8.2"
git push
```

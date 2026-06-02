# Деплой на Railway

## Сервіси

- **Web** — Docker (`Dockerfile`, `start.sh`)
- **PostgreSQL** — `DATABASE_URL` через Reference у Web-сервісі

## Змінні (Web)

| Змінна | Значення |
|--------|----------|
| `DB_CONNECTION` | `pgsql` |
| `DATABASE_URL` | Reference → PostgreSQL |
| `APP_KEY` | з локального `.env` |
| `APP_URL`, `ASSET_URL` | URL проєкту на Railway |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `SESSION_DRIVER` | `file` |
| `CACHE_STORE` | `file` |
| `SEED_ON_START` | `true` (перший деплой), далі `false` |

Порт домену: **8080**.

## Старт контейнера

1. `migrate --force`
2. `catalog:sync-media` — файли з `database/media/`
3. `db:seed --class=CatalogImportSeeder` — якщо `SEED_ON_START` не `false`

## Оновлення даних локально

```powershell
cd c:\OSPanel\home\diploma.local\shop
php scripts/export-site-data.php
php scripts/sync-media-to-repo.php
git add database/data/catalog.json database/media
git commit -m "Оновлення каталогу"
git push
```

## Адмін після seed

- Email: `yanapampukha2006@gmail.com`
- Пароль: `qwerty1234`

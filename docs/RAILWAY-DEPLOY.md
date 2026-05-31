# Деплой Artbook Shop на Railway

## Архітектура

| Сервіс | Роль |
|--------|------|
| **Web** | Laravel у Docker-контейнері (`Dockerfile` + `start.sh`) |
| **PostgreSQL** | Окрема база; Railway дає `DATABASE_URL` |

---

## 1. Підключення бази даних

### Кроки в Railway

1. **New Project** → **Deploy from GitHub** → репозиторій `artbook_shop`
2. **+ New** → **Database** → **PostgreSQL**
3. У **Web-сервісі** → **Variables** → **Add Reference** → PostgreSQL → `DATABASE_URL`

### Змінні середовища (Web)

| Змінна | Значення |
|--------|----------|
| `DB_CONNECTION` | `pgsql` |
| `DATABASE_URL` | Reference → PostgreSQL (авто) |
| `APP_KEY` | `php artisan key:generate --show` локально |
| `APP_URL` | `https://ваш-проєкт.up.railway.app` |
| `ASSET_URL` | те саме, що `APP_URL` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `SESSION_DRIVER` | `database` |
| `CACHE_STORE` | `database` |
| `QUEUE_CONNECTION` | `database` |
| `LOG_CHANNEL` | `stderr` |
| `SEED_ON_START` | `true` (перший деплой; потім `false`) |

Laravel читає `DATABASE_URL` у `config/database.php` — окремо `DB_HOST` / `DB_PASSWORD` не потрібні.

### Networking

**Settings → Networking → Generate Domain**, порт **8080**.

---

## 2. Що відбувається при старті (`start.sh`)

```bash
php artisan storage:link --force
php artisan migrate --force
php artisan catalog:sync-media      # фото + відео з database/media/
php artisan db:seed --class=CatalogImportSeeder --force   # якщо SEED_ON_START=true
php artisan serve --host=0.0.0.0 --port=$PORT
```

- **`migrate --force`** — створює/оновлює таблиці
- **`catalog:sync-media`** — копіює зображення та відео з репозиторію (Railway не має постійного диска)
- **`CatalogImportSeeder`** — імпортує 30 товарів, категорії, відео з `database/data/catalog.json`

Після першого успішного деплою встановіть `SEED_ON_START=false`, якщо не хочете перезаписувати каталог при кожному redeploy.

---

## 3. Як працюють зображення

### Три типи шляхів (клас `App\Support\MediaUrl`)

| Шлях у БД | Результат |
|-----------|-----------|
| `https://...` | Браузер завантажує напряму (як Brickset у BrickShop) |
| `images/...` | Статика з `public/` |
| `products/...` | Локальний файл → `/storage/products/...` |

Компонент `<x-product-image />` і accessor `$product->image_url` підтримують усі три варіанти.

### Чому не сірі блоки на картках

Раніше картки завжди будували `asset('storage/' . $path)`, навіть для `https://`.  
Тепер `MediaUrl::resolve()` перевіряє протокол перед побудовою URL.

### Медіафайли на Railway

Файли в `storage/` **не зберігаються** після перезапуску контейнера.  
Тому фото та відео лежать у **`database/media/`** у git і копіюються при кожному старті через `catalog:sync-media`.

Для **нових завантажень через адмінку** на production краще:
- Cloudinary / S3, або
- Railway Volume на `/app/storage/app/public`

---

## 4. Docker

Railway збирає образ з `Dockerfile`:

- PHP 8.3 + `pdo_pgsql`
- Node.js 22 → `npm run build` (Vite/Tailwind)
- `PORT=8080` (Railway підставляє свій порт)

---

## 5. Оновлення каталогу локально

```powershell
# 1. Запустити OSPanel (MySQL)
cd c:\OSPanel\home\diploma.local\shop
php scripts/export-from-mysql.php
php scripts/sync-media-to-repo.php

# 2. Закомітити
git add database/data/catalog.json database/media
git commit -m "Оновлення каталогу"
git push
```

Railway перебудує Docker і оновить БД автоматично.

---

## 6. Адмін після seed

| Email | Пароль |
|-------|--------|
| `yanapampukha2006@gmail.com` | `qwerty1234` |

Вхід: `/login` → `/admin/dashboard`

**Змініть пароль після першого входу.**

---

## 7. Чеклист з нуля

- [ ] GitHub → Railway → Deploy repo
- [ ] Додати PostgreSQL, прив'язати `DATABASE_URL`
- [ ] Змінні: `DB_CONNECTION`, `APP_KEY`, `APP_URL`, `ASSET_URL`, `SESSION_DRIVER=database`
- [ ] `SEED_ON_START=true` → redeploy → перевірити сайт
- [ ] Generate Domain, порт 8080
- [ ] Перевірити головну, каталог, відео розпаковок
- [ ] `SEED_ON_START=false` (опційно)
- [ ] Змінити пароль адміна

---

## Коротко

PostgreSQL дає `DATABASE_URL`, Docker запускає `start.sh` з migrate + sync media + seed.  
Товари в `database/data/catalog.json`, фото/відео в `database/media/`.  
`MediaUrl` коректно показує і локальні файли, і зовнішні `https://` URL.

# laravel11-api

https://github.com/MilesWuCode/laravel11-api

## 啓動

```bash
cp .env.example .env

php artisan k:g

touch database/database.sqlite

php artisan migrate
```

## 常用指令

```bash
# 安裝 Laravel Sanctum
php artisan install:api

# schedule 清單
php artisan schedule:list

# 用 tinker 建立一個指定用戶,密碼password
php artisan tiner
# User::factory()->create(['name' => 'miles','email' => 'miles@email.com'])

# 全部測試
php artisan test

# Feature 測試
php artisan test --testsuite=Feature --stop-on-failure

# 指定測試
php artisan test ./tests/Feature/SanctumTest.php

# 填加UserController
php artisan make:controller UserController --api --requests --pest --model=User

# 填加MeController
php artisan make:controller MeController --api --requests --pest --model=User

# Laravel Facades 自動產生 PHPDoc
php artisan ide-helper:generate
php artisan ide-helper:models -RW

# transformation json
php artisan make:resource UserResource
php artisan make:resource UserCollection

# model
php artisan make:model Todo --all

# storage/app/public 軟連結 public/storage
php artisan storage:link

# Repository
php artisan make:interface /Interfaces/PostRepositoryInterface
php artisan make:class /Repositories/PostRepository
php artisan make:provider RepositoryServiceProvider
php artisan make:class /Services/PostService

# 跨網域設定
php artisan config:publish cors

# 路由快取
php artisan route:cache

# 開發時清空
php artisan migrate:rollback

# 測試用docker容器
docker run --name laravel11-api \
-p 8000:8000 \
-v $(pwd):/var/www/html \
--network public-network \
--restart unless-stopped \
-d php:fpm php artisan serve --host=0.0.0.0


# larastan
./vendor/bin/phpstan analyse --memory-limit=2G


# rector觀看
vendor/bin/rector --dry-run
# rector覆寫
vendor/bin/rector

# scramble
# http://localhost:8000/docs/api
# http://localhost:8000/docs/api.json
```

## wip

-   https://github.com/dedoc/scramble
-   https://github.com/knuckleswtf/scribe
-   https://github.com/lorisleiva/laravel-actions
-   https://github.com/bavix/laravel-wallet

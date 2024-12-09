# laravel11-api

## 指令

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
```

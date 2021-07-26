# CHANGE LOG
主要是我的更新日誌和一些心得

## Version 0.0.1 / 2021-07-26
### `Initial project`
這邊專注在後端的部分，所以前端使用`laravel`提供的套件，做簡易版的就好了。也使用它提供的註冊登入功能

* 指令紀錄:
```bash
# 建立laravel專案
composer create-project laravel/laravel video-platform
# 使用laravel的bootstrap ui建立前端
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev
# 新增資料表
php artisan migrate
```

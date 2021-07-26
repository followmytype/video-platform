# CHANGE LOG
主要是我的更新日誌和一些心得

## Version 0.0.2 / 2021-07-26
### `Channel Table`建立
每個使用者都會有屬於自己的頻道，現在的設計是一人一個
#### 資料表架構
|名稱|型態|說明|
|-|-|-|
|id|id|id，不需要太多解釋|
|uuid|string|頻道的uuid，想利用它作為後端儲存檔案的名字參考|
|user_id|unsignedBigInteger|用來關聯users的id|
|name|string|頻道名稱|
|slug|string|頻道的網址名|
|description|text|頻道簡介|
|image|string|頻道圖片的儲存位置|
#### `Model`更動
1. 增加`Channel`與`User`彼此的關聯（`belongsTo`, `hasOne`）
2. `Channel`這邊使用`getRouteKeyName`，這是我第一次用，功能是在`Route`那邊可以改成使用指定的欄位去找到對應的資料紀錄，舉例：`Route::get('/posts/{slug}')`
#### 註冊頁面更動
* 增加頻道名稱欄位
#### `Controller`更動
1. 新增`Channel`的`Controller`
2. 修改`RegisterController`的驗證及註冊功能：增加頻道名稱的驗證、註冊功能內在新增玩一個使用者後，一起新增他的頻道

## Version 0.0.1 / 2021-07-26
### `Initial project`
這邊專注在後端的部分，所以前端使用`laravel`提供的套件，做簡易版的就好了。也使用它提供的註冊登入功能

* 指令紀錄：
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

# CHANGE LOG
主要是我的更新日誌和一些心得

## Version 0.0.3 / 2021-07-27
### `Channel Update`頻道更新
### 做法描述
這邊使用`livewire`來做前後端的處理，他會產生出後端的資料處理頁面以及前端的顯示頁面，產生出的後端頁面會去渲染剛產生出來的前端頁面，而前端頁面會跟這個後端頁面不斷聯繫（`ajax`），所以一組`livewire`做的事情會比較單一，這次的範例就是修改頻道內容，資料驗證、認證功能、儲存檔案、壓縮圖片、修改資料表都會在這個檔案內完成。
### 額外筆記
1. 這次使用到了`livewire`這個新工具，他的詳細內容我有記錄在我的`note`上，他的前端用法跟`Vue`很像，所以上手不會太難。
2. 另外這次用到了`Policy`這個認證機制，第一次用過，先建立一個`ModelPolicy`，裡面負責管理`Model`各種操作的授權行為，然後到`AuthServiceProvider.php`去做註冊，讓`laravel`知道這個`policy`是對應哪個`model`，然後在要執行的`function`裡呼叫他就好了。他與`middleware`目前還不是用很明白，但是`middleware`的用途是授權進入某個地方，而`policy`則是授權執行某件事
3. 在更新頻道內容時，用到`laravel`的資料驗證，這邊的邏輯是頻道名稱跟網址是不能重複的，所以用到`unique`這個方法，而又因為我們每次發送更新的資料時，是一整包發送的，所以會有我只單獨更新名稱沒有更新網址的類似情況出現，這時候如果只單一使用`unique`的話會出現網址重複的錯誤訊息，所以這邊我們要忽略自己，就像這樣：
    ```php
    // unique的第一個是要檢查的table，第二個是要檢查的table欄位，第三個是要忽略的id
    ['email' => 'unique:users,email_address,10'];
    ```
4. 圖片改成在資料表只儲存圖片名稱，有建立新的`link`，使用方法如下：
    ```php
    // config/filesystems.php
    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('images') => storage_path('app/images'),
    ],
    // http://url/storage => /storage/app/public/
    // http://url/images => /storage/app/images/
    ```
5. `intervention/image`是這邊用到的壓縮圖片外部套件，沒用到太深，所以先不說明

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
2. `Channel`這邊使用`getRouteKeyName`，這是我第一次用，功能是在`Route`那邊可以改成使用指定的欄位去找到對應的`Model`資料紀錄
#### 註冊頁面更動
* 增加頻道名稱欄位
#### `Controller`更動
1. 新增`Channel`的`Controller`
2. 修改`RegisterController`的驗證及註冊功能：增加頻道名稱的驗證，註冊功能在新增完一個使用者後，同時新增他的頻道

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

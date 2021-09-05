# CHANGE LOG
主要是我的更新日誌和一些心得

## version 0.0.10 2021-09-05
留言功能製作，資料表結構很簡單，有點特別的地方是他有一個`reply_id`，對應的是留言的`id`，因為有回覆功能，所以每個留言都會有對誰回應的紀錄，欄位可以為空。`Video model`對留言的關聯有做篩選，這邊比較特殊的是在顯示留言的部分用到了遞迴，在輪遍留言時只要遇到有回覆的，就重複呼叫顯示留言的元件

## version 0.0.9 2021-09-04
### 製作訂閱功能
會員可以訂閱頻道，新增訂閱資料表，紀錄使用者`id`和頻道`id`，`User`和`Channel model`新增關聯和判斷，使用者訂閱了哪些頻道，使用者有沒有訂閱這個頻道，頻道的訂閱數等等。新增`livewire`做訂閱的功能，作法跟點讚差不多
1. `create_subscriptions_table`
2. `Subscription.php`
> 頻道訂閱這件事情在未登入的情況下會導去登入頁，登入完後應該要返回剛剛的頁面，這邊跟按讚倒讚都可以再改善。

## version 0.0.8 2021-08-28
### 製作點讚功能
喜歡與不喜歡後面邏輯比較簡單，建立兩張資料表，一張紀錄喜歡影片的`user_id`和`video_id`，另一張紀錄不喜歡影片的`user_id`和`video_id`，並且建立他們的`Model`，與`Video`彼此加上關聯
1. `create_likes_table.php`
2. `create_dislikes_table.php`
3. `Like.php`
4. `Dislike.php`
    > 因為這兩張資料表用來做單純紀錄的功能，所以不需要使用時戳，而`Model`那邊也記得要將時戳功能關掉。  
    `public $timestamps = false;`
5. `Video.php`新增關聯外也新增判斷當前使用者是否點過讚或是倒過讚的功能
6. 新增點讚功能的`livewire`（`Voting.php`），並實作點讚倒讚的方法
7. 調整`blade`檔案

## Version 0.0.7 2021-08-18
使用`video.js`的套件做影片播放器
1. 新增影片播放頁面，稍微佈置一下頁面排版，使用[這個套件](https://videojs.com/)
2. 製作觀看次數的功能，新增觀看次數的欄位在影片資料表中，觀看計次邏輯比較簡單，只要看到大於三秒就加一
3. 這邊用到`livewire`的事件監聽功能，主要是可以在`livewire`新增一個監聽事件名稱以及對應的行為，可以讓`js`在前台去呼叫他，
4. 使用到`wire:ignore`這個屬性，因為`livewire`其實是從後端傳一整個`html`讓前端重新渲染，而當標籤加上這個屬性時，更新時會忽略這個標籤的內容，例如：有時一些標籤會讓第三方`js`套件操作，而為了不讓`livewire`在更新時刪除或覆蓋掉第三方套件自己產生的內容，就會使用這個屬性，這次播放影片的`video`標籤就是這個情況
```html
<div wire:ignore><!-- 原先的標籤，因為他的內部有第三方套件自己產生的內容，為了不影響他，所以將ignore屬性放在這裡  -->
    <div><!-- 第三方套件自己產生的標籤 -->
        <video /><!-- 這次套用第三方套件的標籤 -->
    </div>
</div>
```

## Version 0.0.6.1 2021-08-02
檔案轉換即時顯示、刪除影片暫存檔案
1. 原先影片上傳完畢後，直接跳到編輯影片的頁面，同時會在後台慢慢執行產生預覽圖跟串流檔的動作，而編輯影片的頁面使用`livewire`的`poll`功能，達到`ajax`的效果，可以不用刷新頁面也能即時更新進度。
2. 影片完成後刪除放在`video-temp`裡的暫存檔案，並且寫`log`日誌，紀錄後台`job`的行為

## Version 0.0.6 2021-08-02
### 影片刪除功能
影片刪除功能顯示在影片列表那邊，所以功能實作在`AllVideo.php`這個檔案裡面。另外影片刪除也需要權限問題，所以也新增了`VideoPolicy`，主要檢查當前登入者的`id`有沒有與影片的相符。刪除影片的功能很簡單，刪除掉紀錄也刪掉在`storage`裡的檔案。`User.php`新增一個是否為影片主人的功能。

## Version 0.0.5.1 2021-08-01
### 產生我的影片列表
這邊踩雷的點是：
1. 如果已經用`storage:link`在`public`目錄產生資料夾，那要注意`route`的檔案(`web.php`, `api.php`)不能用那個資料夾的根做路徑，會有衝突
2. 這邊用`laravel`原生的換頁功能，在要用的`collection`裡呼叫`pagiante($page)`就能得到資料的集合和頁數換頁的`view`資訊

## Version 0.0.5 2021-07-30
### 進行影片上傳功能part2-產生串流檔
完成產生串流檔的動作，在使用者上傳圖片後，在背後同時執行，並顯示在前端

## Version 0.0.4.4 2021-07-29
### 進行影片上傳功能part1-產生預覽圖片
影片上傳的邏輯：使用者上傳他的影片時，將原始影片儲存在暫存資料夾中，當上傳完畢後就創建一筆影片的紀錄，這時用`queue`去執行產生影片預覽圖以及產生影片的串流檔案，這裡用到`ffmpeg`以及他的`laravel`套件去執行。
### 修改項目
1. `config/livewire.php`裡修改檔案上傳的大小限制，當然修改這邊不會就沒有問題，伺服器的環境上也要更改`php.ini`的檔案上傳限制。
2. `config/filesystem.php`的`disks`新增我們儲存的目錄，讓`ffmpeg`產生的直接指定目錄儲存，然後`link`他們。
3. `job/CreateThumbnailFromVideo.php`: 執行產生影片預覽圖
4. `job/ConvertVideoForStreaming.php`: 執行產生影片串流檔案，但還沒實作
5. `CreateVideo.php`: 在產生一筆資料紀錄後，呼叫`job`去執行產生預覽跟串流檔
### 補充
新增一個`command`去執行`ffmpeg`產生串流檔測試  
`Commands/VideoEncode.php`

## Version 0.0.4.1 2021-07-29
### 安裝`ffmpeg`
因為這邊會需要用到影片處理軟體，所以在部屬的環境上需要有`ffmpeg`這個軟體，然後我們使用`ffmpeg-laravel`的套件去使用它，環境上的`ffmpeg`安裝這邊就不說明了，只是我們這邊需要知道安裝後的路徑在哪裡，因為我們的`.env`檔內需要去讀取他絕對路徑
### 用到的指令
```
composer require pbmedia/laravel-ffmpeg
// 產生他的配置檔案
php artisan vendor:publish --provider="ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider"
```

## Version 0.0.4 / 2021-07-28
### 新增、編輯影片
### 做法描述
這次實作了頻道新增影片功能，邏輯內容雖然簡單，但跟頻道的操作還是有差異，之前的流程是從路由檔經過`controller`再到`view`，而那個`view`有引用到`livewire`產生的`class`檔案去另外顯示所屬的`view`視圖。但這次的流程改成跳過`controller`，直接在路由檔這邊去呼叫`livewire`的`class`檔，在他那邊做視圖的渲染。做法上只是更換流程而已，沒有太複雜的關係，目前影片只有新增跟編輯兩個功能。

另外這邊有新增`job queue table`，不過還沒實際用到
```
php artisan queue:table
```
### Video Table
|名稱|型態|說明|
|-|-|-|
|id|id|id，不需要太多解釋|
|uid|string|頻道的uid，想利用它作為後端儲存檔案的名字參考|
|channel_id|unsignedBigInteger|用來關聯channels的id|
|title|string|影片標題|
|description|text|影片簡介|
|path|string|頻道圖片的儲存位置|
|visibility|string|影片觀看權限，公開、私人、限制觀看|

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
### 指令紀錄
```
# 安裝livewire並建立配置檔案
composer require livewire/livewire
php artisan livewire:publish --config
# 安裝intervention/image並建立配置檔案
composer require intervention/image
php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravelRecent"
```

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

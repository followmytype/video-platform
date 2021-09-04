<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    // Model的黑名單，相對於$fillable（白名單）規定可以填入哪些欄位，這個則是限制不能填入哪些欄位
    protected $guarded = [];

    // 在route的時候就能直接用slug來取資料，例如：Route::get('/posts/{post}')，他就會用post的slug欄位去拿Post
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscribers()
    {
        return $this->subscriptions()->count();
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'uid';
    }

    public function getThumbnailAttribute()
    {
        if ($this->thumbnail_image) {
            return '/videos/' . $this->uid . '/' . $this->thumbnail_image;
        } else {
            return 'default.png';
        }
    }

    public function getUploadDateAttribute()
    {
        $d = new Carbon($this->created_at);
        return $d->toFormattedDateString();
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}

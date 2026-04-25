<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoAccessReq extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video_access_time()
    {
        return $this->hasOne(VideoAccessTime::class);
    }

    public function isAccessible()
    {
         return $this->status === 'diizinkan' &&
           now()->between(Carbon::parse($this->video_access_time->start_date), Carbon::parse($this->video_access_time->end_date));
    }
}

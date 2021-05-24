<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuseumNews extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'user_id',
        'is_published',
        'content_raw',
        'content_html'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function news_info()
    {
        return $this->hasOne(MuseumNewsInfo::class,'news_id','id');
    }
}

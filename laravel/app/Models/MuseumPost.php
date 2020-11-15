<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class MuseumPost extends Model
{
    //protected $fillable = ['category_id'];
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'coordinates',
        'inventory_number',
        'excerpt',
        'content_raw',
        'content_html',
        'is_published',
        'published_at',
        'author',
        'collection_date',
        'user_id',
        'category_id'
    ];

    protected $casts = [
        'coordinates' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(MuseumCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

//    public function getCreatedAtAttribute($value)
//    {
//        return Carbon::createFromTimestamp(strtotime($value))
//            ->timezone('Europe/Samara')
//            ->toDateTimeString();
//    }
}

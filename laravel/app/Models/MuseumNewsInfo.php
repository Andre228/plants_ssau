<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 23.05.2021
 * Time: 12:20
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MuseumNewsInfo extends Model
{

    protected $fillable = [
        'news_id',
        'likes'
    ];

    public function news()
    {
        return $this->belongsTo(MuseumNews::class, 'news_id');
    }

    public function news_comments()
    {
        return $this->hasMany(MuseumNewsComment::class,'news_info_id','id');
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 23.05.2021
 * Time: 12:22
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MuseumNewsComment extends Model
{

    protected $fillable = [
        'news_info_id',
        'news_id',
        'reply_id',
        'user_id',
        'comment',
        'username'
    ];

    public function news_info()
    {
        return $this->belongsTo(MuseumNewsInfo::class, 'news_info_id');
    }

    public function reply() {

        return $this->belongsTo(MuseumNewsComment::class, 'reply_id', 'id');

    }

}
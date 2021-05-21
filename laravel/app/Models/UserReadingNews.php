<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 22.05.2021
 * Time: 0:01
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserReadingNews extends Model
{

    protected $fillable = [
        'user_id',
        'news_id'
    ];

    public function user_reading()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
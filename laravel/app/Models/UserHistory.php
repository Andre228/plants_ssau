<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.05.2021
 * Time: 11:49
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{

    protected $fillable = [
        'user_id',
        'post_id'
    ];

    public function user_favorites()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
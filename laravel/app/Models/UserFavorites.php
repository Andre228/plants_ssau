<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.05.2021
 * Time: 22:43
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserFavorites extends Model
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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuseumPost extends Model
{
    //protected $fillable = ['category_id'];
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo(MuseumCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

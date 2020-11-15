<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuseumImage extends Model
{
    protected $fillable = [
        'post_id',
        'name',
        'alias',
    ];


    public function image()
    {
        return $this->belongsTo(MuseumImage::class);
    }
}

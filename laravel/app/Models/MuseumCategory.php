<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuseumCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'description'
    ];

    public function parentCategory() {
        return $this->belongsTo(MuseumCategory::class, 'parent_id', 'id');
    }
}

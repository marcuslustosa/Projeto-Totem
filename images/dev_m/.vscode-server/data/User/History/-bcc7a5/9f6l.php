<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'small_thumb',
        'medium_thumb',
        'video',
        'logo_color',
        'x_position',
        'y_position',
        'logo_width',
        'logo_height',
        'type',
        'description',
        'post_category_id'

    ];

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = [
        'category_name',
        'category_slug',
        'category_desc'
    ];

    public function posts():BelongsToMany
    {
        return $this->BelongsToMany(Post::class, 'category_posts', 'category_id');
    }
}


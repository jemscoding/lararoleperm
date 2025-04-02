<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    //
    protected $fillable =
    [
        'tag_name',
        'tag_slug',
        'tag_desc',
    ];


    public function posts(): BelongsToMany
    {
        return $this->BelongsToMany(Post::class, 'post_tags');
    }
}

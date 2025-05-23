<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'ft_image',
        'slug',
        'content',
        'user_id',
        'is_published',
        'published_at',
        'categories',
        'tags'
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_published' => 'boolean'
    ];

    // Automatically generate slug sa post
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = strtolower(Str::slug($value));
    }

    //Establish relationship sang author, tags kag categories
    public function author() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_posts', 'post_id', 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }

    // Scope sa published posts
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    // Scope sa drafts
    public function scopeDrafts($query)
    {
        return $query->where('is_published', false);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * @var array<string> $fillable
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'published_at',
        'featured_image',
    ];

    /**
     * @var array<string> $casts
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * @var array<string> $with
     */
    protected $with = [
        'user',
    ];

    /**
     * @var array<string> $appends
     */
    protected $appends = [
        'published',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Comment>
     */
    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return bool
     */
    public function getPublishedAttribute(): bool
    {
        return $this->published_at !== null;
    }
}

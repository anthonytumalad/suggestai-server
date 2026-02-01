<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Form extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'forms';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'is_active',
        'img_path',
        'user_id',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * Scope: Filter forms by user
     */
    public function scopeOfUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Only active forms
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Automatically generate slug from title
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    /**
     * Get full image URL
     */
    public function getImgUrlAttribute()
    {
        return empty($this->img_path) ? null : asset($this->img_path);
    }

    /**
     * Relationship: User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Suggestions
     */
    public function suggestions()
    {
        return $this->hasMany(Suggestion::class);
    }
}

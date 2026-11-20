<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'stock', 'image_path', 'is_featured',
    ];

    protected function casts(): array
    {
        return ['price' => 'decimal:2', 'is_featured' => 'boolean'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image_path) {
            return asset('images/coffee-placeholder.svg');
        }

        return Str::startsWith($this->image_path, ['http://', 'https://'])
            ? $this->image_path
            : Storage::disk('public')->url($this->image_path);
    }
}

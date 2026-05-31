<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'name_en', 'name_de', 'slug', 'author', 'author_en', 'author_de', 'description', 'description_en', 'description_de',
        'price', 'sale_price', 'stock', 'pages', 'language', 'publisher', 'age_limit', 'cover_type', 'image', 'gallery', 'is_new', 'is_popular'
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_new' => 'boolean',
        'is_popular' => 'boolean',
    ];

    public function getTranslatedNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && $this->name_en) return $this->name_en;
        if ($locale === 'de' && $this->name_de) return $this->name_de;
        return $this->name;
    }

    public function getTranslatedAuthorAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && $this->author_en) return $this->author_en;
        if ($locale === 'de' && $this->author_de) return $this->author_de;
        return $this->author;
    }

    public function getTranslatedDescriptionAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && $this->description_en) return $this->description_en;
        if ($locale === 'de' && $this->description_de) return $this->description_de;
        return $this->description;
    }

    public function getPriceWithDiscountAttribute()
    {
        if ($this->hasDiscount()) {
            return (float) $this->sale_price;
        }
        return (float) $this->price;
    }

    public function getConvertedPriceAttribute()
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return (float) $this->price;
        }

        $currency = session('currency', 'UAH');
        $price = $this->hasDiscount() ? (float) $this->sale_price : (float) $this->price;

        return match ($currency) {
            'USD' => $price / 40,
            'EUR' => $price / 42,
            default => $price,
        };
    }

    public function hasDiscount(): bool
    {
        return $this->sale_price !== null && (float) $this->sale_price >= 0 && (float) $this->sale_price < (float) $this->price;
    }

    public function getFormattedPriceAttribute()
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return number_format($this->price, 2) . ' грн';
        }

        $currency = session('currency', 'UAH');
        $price = $this->converted_price;

        return match ($currency) {
            'USD' => '$' . number_format($price, 2),
            'EUR' => '€' . number_format($price, 2),
            default => number_format($price, 2) . ' грн',
        };
    }

    public function getFormattedOldPriceAttribute()
    {
        if (!$this->hasDiscount()) {
            return null;
        }
        $currency = session('currency', 'UAH');
        $price = (float) $this->price;
        $rate = match ($currency) {
            'USD' => 40,
            'EUR' => 42,
            default => 1,
        };
        $converted = $currency === 'UAH' ? $price : $price / $rate;
        return match ($currency) {
            'USD' => '$' . number_format($converted, 2),
            'EUR' => '€' . number_format($converted, 2),
            default => number_format($converted, 2) . ' грн',
        };
    }

    public function getImageUrlAttribute(): ?string
    {
        return MediaUrl::resolve($this->image);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

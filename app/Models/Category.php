<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'name_en', 'name_de', 'slug'];

    public function getTranslatedNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && $this->name_en) return $this->name_en;
        if ($locale === 'de' && $this->name_de) return $this->name_de;
        return $this->name;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

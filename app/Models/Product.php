<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while(self::where('slug', $slug)->exists()){
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}

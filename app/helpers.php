<?php

namespace App\Helpers;

use Illuminate\Support\Str;

if (! function_exists('generateSequentialNumber')) {
    function generateUniqueSlug(string $model, string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;
    
        while($model('slug', $slug)->exists()){
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
        return $slug;
    }
}

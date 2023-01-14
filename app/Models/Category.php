<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    protected $casts = [
        'created_at' => 'datetime:d M Y H:i',
    ];

    public function story(): HasMany
    {
        return $this->hasMany(Story::class);
    }
}

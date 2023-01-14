<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Story extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','user_id','name', 'slug', 'image', 'content'];

    protected $appends = ['image_url'];

    protected function imageUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->image ? asset('storage/story/'. $this->image) : "https://t4.ftcdn.net/jpg/02/51/95/53/360_F_251955356_FAQH0U1y1TZw3ZcdPGybwUkH90a3VAhb.jpg",
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

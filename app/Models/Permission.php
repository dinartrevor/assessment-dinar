<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug'];
    protected $casts = [
        'created_at' => 'datetime:d M Y H:i',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class,'role_permissions');
    }
}

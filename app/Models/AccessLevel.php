<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLevel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'level'
    ];

    public function users()
    {
        return $this->hasMany(User::class, "access_level", "level");
    }
}

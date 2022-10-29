<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elector extends Model
{
    use HasFactory;
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = ['id', 'name', 'class', 'room', 'vote', 'vote_party', 'created_at', 'updated_at'];
    protected $casts = [
        'id' => 'string',
    ];
}

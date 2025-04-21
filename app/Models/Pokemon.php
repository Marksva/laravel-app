<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemons';

    protected $fillable = [
        'user_id',
        'pokeapi_id',
        'name',
        'type',
        'sprite',
        'hp',
        'attack',
        'defense',
        'speed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

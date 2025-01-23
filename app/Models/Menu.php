<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- Poprawiony namespace
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;
    use HasFactory; // <-- Użycie HasFactory

    protected $fillable = ['name', 'description', 'price', 'category_id', 'is_available'];
}

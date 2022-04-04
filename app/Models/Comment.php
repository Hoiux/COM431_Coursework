<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'code',
        'feedback',
        'type',
        'author_name',
        'author_email',
        'selected'
    ];
}

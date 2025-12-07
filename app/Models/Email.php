<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory; 

    protected $fillable = [
        'sender',
        'recipient',
        'subject',
        'body',
        'read',
        'attachments',
    ];

    protected $casts = [
        'read' => 'boolean',
        'attachments' => 'array',
    ];
}

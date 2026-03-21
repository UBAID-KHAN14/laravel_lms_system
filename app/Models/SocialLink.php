<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $table = 'social_links';

    protected $fillable = [
        'name',
        'url',
        'icon_class',
        'image',
        'status',
    ];
}

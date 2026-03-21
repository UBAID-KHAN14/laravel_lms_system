<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermAndPrivacy extends Model
{
    protected $table = 'term_and_privacies';
    protected $fillable = [
        'type',
        'heading',
        'body',
        'sort_order',
        'status',
    ];
}

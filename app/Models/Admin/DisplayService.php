<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisplayService extends Model
{
    use HasFactory;
	
	protected $table = 'display_services';
	
	    protected $fillable = [
        'url',
        'title',
        'status',
        'keywords',
        'body',
        'image',
    ];
}

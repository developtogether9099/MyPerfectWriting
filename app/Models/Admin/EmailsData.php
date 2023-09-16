<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EmailsData extends Model
{
    use HasFactory;
    use Notifiable;
    protected $table = "emails_data";
    protected $fillable = [
        'firstname','lastname','email'
    ];
}

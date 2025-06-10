<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $dates = ['start_date', 'end_date'];
    protected $fillable = ['user_id', 'start_date', 'end_date', 'send_to_accountant'];
}

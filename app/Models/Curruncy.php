<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Curruncy extends Authenticatable
{

    protected $fillable = [
        'id',
        'curr_id',
        'date',
        'name',
        'NumCode',
        'CharCode',
        'Nominal',
        'CurrName',
        'Value',
    ];
protected $table = 'currencies';
}

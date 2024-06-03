<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeftList extends Model
{
    use HasFactory;

    protected $table = 'leftlist';

    protected $fillable = [
        'region', // string
        'courier', // id
        'start', //date
        'toregion', // date
        'back' // str of date like
    ];

    public $timestamps = false;
}

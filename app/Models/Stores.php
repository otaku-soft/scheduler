<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Stores extends Model
{
    use HasFactory;
    use SoftDeletes;
    const PAGINATE_DEFAULT = 10;

    static $rules =
    [
        'name' => 'required',
        'address' => 'required'
    ];
}

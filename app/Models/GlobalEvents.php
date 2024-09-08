<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalEvents extends Model
{
    use HasFactory;
    public function event()
    {
        return $this->hasOne("App\Models\Events","id","event_id");
    }
}

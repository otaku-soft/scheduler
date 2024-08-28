<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomStoreLink extends Model
{
    use HasFactory;
    public function store()
    {
        return $this->hasOne("App\Models\Stores","id","store_id");
    }
    public function room()
    {
        return $this->hasOne("App\Models\Rooms","id","room_id");
    }

    public function prices()
    {
        return $this->hasMany("App\Models\RoomStoreLinkPrices","storeLinkId","id");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType_Mod extends Model
{
    protected $fillable = [];
	protected $table = 'room_type';
	protected $primaryKey = 'type_id';
	public $timestamps = false;
}

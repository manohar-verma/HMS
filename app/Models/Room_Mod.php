<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room_Mod extends Model
{
    protected $fillable = [];
	protected $table = 'rooms';
	protected $primaryKey = 'room_id';
	public $timestamps = false;

	public function get_hotel()
	{
		return $this->hasOne('App\Models\hotel_mod','hotel_id','hotel_id');
	}

	public function get_type()
	{
		return $this->hasOne('App\Models\RoomType_Mod','type_id','room_type_id');
	}

	

}

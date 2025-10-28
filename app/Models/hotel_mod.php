<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hotel_mod extends Model
{
    protected $fillable = [];
	protected $table = 'hotels';
	protected $primaryKey = 'hotel_id';
	public $timestamps = false;

	public function get_state()
	{
		return $this->hasOne('App\Models\State_Mod','id','state');
	}

	public function get_country()
	{
		return $this->hasOne('App\Models\Country_Mod','id','country');
	}
}

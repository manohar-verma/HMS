<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State_Mod extends Model
{
     protected $fillable = [];
	protected $table = 'indian_states';
	protected $primaryKey = 'id';
	public $timestamps = false;
}

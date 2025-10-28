<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country_Mod extends Model
{
     protected $fillable = [];
	protected $table = 'countries';
	protected $primaryKey = 'id';
	public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenities_Mod extends Model
{
    protected $fillable = [];
	protected $table = 'amenities';
	protected $primaryKey = 'id';
	public $timestamps = false;
}

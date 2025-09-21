<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class vulnerable_mod extends Model {
	protected $fillable = [];
	protected $table = 'vulnerable_profiles';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
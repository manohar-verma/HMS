<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class users_mod extends Model {
	protected $fillable = [];
	protected $table = 'users';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
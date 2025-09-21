<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class settings_mod extends Model {
	protected $fillable = [];
	protected $table = 'settings';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
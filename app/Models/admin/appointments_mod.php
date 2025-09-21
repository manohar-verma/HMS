<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class appointments_mod extends Model {
	protected $fillable = [];
	protected $table = 'appointments';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
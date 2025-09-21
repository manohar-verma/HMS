<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class tips_mod extends Model {
	protected $fillable = [];
	protected $table = 'health_tips';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
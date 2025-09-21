<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class pricing_mod extends Model {
	protected $fillable = [];
	protected $table = 'pricing_plans';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
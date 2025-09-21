<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class banner_mod extends Model {
	protected $fillable = [];
	protected $table = 'site_banner';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
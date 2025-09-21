<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class gallery_mod extends Model {
	protected $fillable = [];
	protected $table = 'gallery';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
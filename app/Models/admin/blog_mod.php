<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class blog_mod extends Model {
	protected $fillable = [];
	protected $table = 'blogs';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
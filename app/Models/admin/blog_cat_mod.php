<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class blog_cat_mod extends Model {
	protected $fillable = [];
	protected $table = 'blog_cat';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
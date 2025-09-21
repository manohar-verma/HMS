<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class testimonials_mod extends Model {
	protected $fillable = [];
	protected $table = 'testimonial';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
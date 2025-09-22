<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class blog_mod extends Model {
	protected $fillable = [];
	protected $table = 'bookings';
	protected $primaryKey = 'booking_id';
	public $timestamps = false;
}
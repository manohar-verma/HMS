<?php namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class payments_mod extends Model {
	protected $fillable = [];
	protected $table = 'payments';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
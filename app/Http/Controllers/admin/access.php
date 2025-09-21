<?php

namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use View;
use Validator;
use Redirect;
use App\Models\Admin;
use Auth;
use DB;
use Session;
use Cookie;
use Hash;
use Config;
use Mail;

class access extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
			 $user = Auth::guard('admin')->user();
			 if ($user['status'] == '1') {
			    return Redirect::intended('admin/dashboard');
			 }
		}
         $SettingData = DB::table('settings')->first();
		$data['settings'] =$SettingData;
		return View::make('admin.access.index',$data);
    }
	function doAuth()
	{
		$rules = [
		    'email' => 'required',
		    'password' => 'required'
		];
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
            $email = $data['email'];
            $pass   =$data['password']; 
            $remember = (isset($data['rememberme'])) ? true : null;
		$active_user  = Admin::whereEmail($email)->select('email', 'status')->where('status','1')->first();
		
       
		if(!$active_user) {
           
		    $attempt = false;
		} else {
			
		    $attempt = Auth::guard('admin')->attempt(array('email' => $active_user->email, 'password' =>$pass),$remember);
		} 
		if ($attempt)
		{
            if($remember=='1'){
                Cookie::queue('remember_admin_admin','1',365*24);
                Cookie::queue('remember_admin_username',$email,365*24);
                Cookie::queue('remember_admin_password',$pass,365*24);
            }
            else{
                Cookie::queue('remember_admin_admin', null, -1);
            }
			$user = Auth::guard('admin')->user();
		    
		    if ($user['status'] == '1') {
				Session::put('success', 'You have logged in successfully..');
		    	return Redirect::intended('admin/dashboard');
		    }
		    
		}
         Session::put('error', 'Incorrect Email/Password. Please try again');
		return Redirect::back()->withInput()->withFlashMessage('Incorrect Email/Password. Please try again.');
	}
	public function logout() {
		Auth::guard('admin')->logout();
		Session::put('success', 'Logged out successfully..');
       return Redirect::intended('admin');
	}
	function dashboard()
    {
        if (Auth::guard('admin')->check())
        {
           $user = Auth::guard('admin')->user();
		    if ($user['status'] == '1') {
            return View::make('admin.include.dashboard');
			}
			else
			{
				return Redirect::intended('admin');
			}
        }
        else
        {
            return Redirect::intended('admin');
        }
        
    }
}

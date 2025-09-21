<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag; 
use App\Models\admin\settings_mod; // Fetch value from Aircraft Table
use App\library\fn_image_resize; // Get custom function
use App\library\get_site_details; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use View;
use Validator;
use Input;
use App\Models\User;
use Auth;
use Cookie;
use Config;
use Mail;

class room extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
         $this->_myFunImage = new Fn_image_resize;
         $this->_myFunUserRole = new get_site_details;
    }
    
    function index()
    {
        $user = auth()->guard('admin')->user();
        $userAccess = $this->_myFunUserRole->getUserAccess($user->id);
        $accessRole=(explode(",",$userAccess));
        if(!in_array("all-booking", $accessRole))
        {
             Session::put('error', 'Access denied to this page');
            return redirect(ADMIN_URL.'/dashboard');
        } 

        return view('admin.room.index');
    }
  
    function inventory(){
        $user = auth()->guard('admin')->user();
        $userAccess = $this->_myFunUserRole->getUserAccess($user->id);
        $accessRole=(explode(",",$userAccess));
        if(!in_array("room-inventory", $accessRole))
        {
             Session::put('error', 'Access denied to this page');
            return redirect(ADMIN_URL.'/dashboard');
        } 
        return view('admin.room.inventory');
    }
    function availability(){
        $user = auth()->guard('admin')->user();
        $userAccess = $this->_myFunUserRole->getUserAccess($user->id);
        $accessRole=(explode(",",$userAccess));
        if(!in_array("availability", $accessRole))
        {
             Session::put('error', 'Access denied to this page');
            return redirect(ADMIN_URL.'/dashboard');
        } 
        return view('admin.room.availability');
    }
    function ratePlans(){
        $user = auth()->guard('admin')->user();
        $userAccess = $this->_myFunUserRole->getUserAccess($user->id);
        $accessRole=(explode(",",$userAccess));
        if(!in_array("rate-plans", $accessRole))
        {
             Session::put('error', 'Access denied to this page');
            return redirect(ADMIN_URL.'/dashboard');
        } 
        return view('admin.room.rate');
    }

}
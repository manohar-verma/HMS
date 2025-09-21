<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag; 
use Illuminate\Http\Request;
use App\library\get_site_details; // Get custom function
use Session;
use Redirect;
use DB;
use Hash;
use View;
use Validator;
use Input;
use App\Models\Admin;
use Auth;
use Cookie;
use Config;
use Mail;

class changePassword extends BaseController {
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new get_site_details;
    }
    
    function index()
    {
        $user = auth()->guard('admin')->user();
        $checkUserAccess = $this->_myFun->getUserAccess($user->id);
        $roles=(explode(",",$checkUserAccess));
        if(!in_array("change-password", $roles))
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }  
        
        $table_data=Admin::where('id',$user->id)->first();
        return view('admin.changePassword.index')->with('UserData',$table_data);
    }
    
   
    function savePassword(Request $request)
    {
       
        $user = auth()->guard('admin')->user();
        $checkUserAccess = $this->_myFun->getUserAccess($user->id);
        $roles=(explode(",",$checkUserAccess));
        if(!in_array("change-password", $roles))
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }  
        
        $oldPassword = trim($request->input('old_password'));
        $newPassword = trim($request->input('new_password'));
        if (!Hash::check($oldPassword, $user->password)) 
        {
            Session::put('error',"Old Password Doesn't match!");
            return redirect(ADMIN_URL.'/change-password');
        }
        // Current password and new password same
        if (strcmp($oldPassword, $newPassword) == 0) 
        {
            Session::put('error',"New Password cannot be same as your current password.");
            return redirect(ADMIN_URL.'/change-password');
        }
        $user =  Admin::find($user->id);
        $user->password =  Hash::make($newPassword);
        $updateUser = $user->save();   
        if($updateUser){
            Session::put('success', 'Password changed successfully');
            return redirect(ADMIN_URL.'/change-password');
        }
        else{
            Session::put('error','Failed to update Password');
            return redirect(ADMIN_URL.'/change-password');
        }
    }
}
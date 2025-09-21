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

class settings extends BaseController {
    
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
        if(!in_array("hotel-profile", $accessRole))
        {
             Session::put('error', 'Access denied to this page');
            return redirect(ADMIN_URL.'/dashboard');
        } 
        $table_data=Settings_mod::where('id','1')->first();
        return view('admin.setting.index')->with('settings',$table_data);
    }
    
   
    function save_setting(Request $request)
    {
        $user = auth()->guard('admin')->user();
        $userAccess = $this->_myFunUserRole->getUserAccess($user->id);
        $accessRole=(explode(",",$userAccess));
        if(!in_array("hotel-profile", $accessRole))
        {
             Session::put('error', 'Access denied to this page');
            return redirect(ADMIN_URL.'/dashboard');
        } 
        $site_name = trim($request->input('site_name'));
        $admin_ph_no = trim($request->input('admin_ph_no'));
        $site_phone_number = trim($request->input('site_phone_number'));
        
        $copy_right = trim($request->input('copy_right'));
        $controller_email = trim($request->input('controller_email'));
        $site_url = trim($request->input('site_url'));
        $facebook_url = trim($request->input('facebook_url'));
        $twitter_url = trim($request->input('twitter_url'));
        $instagram_url = trim($request->input('instagram_url'));
        $address = trim($request->input('address'));
        $slogan_text = trim($request->input('slogan_text'));
        $meta_description = trim($request->input('meta_description'));
        $meta_keywords = trim($request->input('meta_keywords'));
        $site_title = trim($request->input('site_title'));
        $pinstar_url = trim($request->input('pinstar_url'));
        
                $dataUpdate = array(
                'site_name'=>$site_name,
                'address'=>$address,
                'copy_right'=>$copy_right,
                'slogan_text'=>$slogan_text,
                'twitter_url'=>$twitter_url,
                'pinstar_url'=>$pinstar_url,
                'facebook_url'=>$facebook_url,
                'instagram_url'=>$instagram_url, 
                'site_url'=>$site_url,
                'controller_email'=>$controller_email,
                'site_phone_number'=>$site_phone_number,
                'admin_ph_no'=>$admin_ph_no,
                'meta_description'=>$meta_description,
                'meta_keywords'=>$meta_keywords,
                'site_title'=>$site_title
            );
            
             $updateUser = Settings_mod::where('id', '1')->update($dataUpdate);           
            if($updateUser){
                Session::put('success', 'Setting updated successfully');
                return redirect(ADMIN_URL.'/setting/hotel-profile');
            }
            else{
                Session::put('error', 'Failed to Setting');
                return redirect(ADMIN_URL.'/setting/hotel-profile');
            }
    }
    function domainAndBrand(){
        $user = auth()->guard('admin')->user();
        $userAccess = $this->_myFunUserRole->getUserAccess($user->id);
        $accessRole=(explode(",",$userAccess));
        if(!in_array("domain-and-brand", $accessRole))
        {
             Session::put('error', 'Access denied to this page');
            return redirect(ADMIN_URL.'/dashboard');
        } 
        return view('admin.setting.brand');
    }
    function businessInfo(){
        $user = auth()->guard('admin')->user();
        $userAccess = $this->_myFunUserRole->getUserAccess($user->id);
        $accessRole=(explode(",",$userAccess));
        if(!in_array("business-info", $accessRole))
        {
             Session::put('error', 'Access denied to this page');
            return redirect(ADMIN_URL.'/dashboard');
        } 
        return view('admin.setting.business');
    }
    function securitySetting(){
        $user = auth()->guard('admin')->user();
        $userAccess = $this->_myFunUserRole->getUserAccess($user->id);
        $accessRole=(explode(",",$userAccess));
        if(!in_array("security-setting", $accessRole))
        {
             Session::put('error', 'Access denied to this page');
            return redirect(ADMIN_URL.'/dashboard');
        } 
        return view('admin.setting.security');
    }
}
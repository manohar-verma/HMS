<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag; 
use App\library\my_functions;
use App\library\get_site_details; // Get custom function
use App\Models\admin\booking_mod; 
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

class booking extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
        $this->_myFunUser = new get_site_details;
    }
    
    function index(Request $request)
    {
        $user = auth()->guard('admin')->user();
        $checkUserAccess = $this->_myFun->validateUserAccess('all-booking','view');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('all-booking','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('all-booking','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('all-booking','delete');
        $status = $request->input('status');
        $date = $request->input('date');
        $name = $request->input('name');
        $page   = $request->input('page');
        $orderby = $request->input('orderby');
        $sortval = $request->input('sortval');
        $searchResults = DB::table('bookings')
        ->join('users', 'bookings.guest_id', '=', 'users.id')
        ->join('hotels', 'bookings.hotel_id', '=', 'hotels.hotel_id')
        ->select('users.name','users.phone','hotels.name as hotal_name', 'bookings.*');
       
            if($name != ''){
                $searchResults->where('name','LIKE', '%'.$name.'%');
            }
            if($status != ''){
                $searchResults->where('booking_status','LIKE', '%'.$status.'%');
            }
            if($date != ''){
                $searchResults->where('check_in_date','LIKE', '%'.$date.'%');
            }
            
           $PerPage = ADMIN_PER_PAGE;
           $currentPage = $page? $page : 1;
           if((!is_numeric($currentPage)) || ($currentPage < 1) ){
                $currentPage = 1;
            }
            $startpoint = (floor($currentPage) * $PerPage) - $PerPage;
        
         $orderByArray = array('booking_id');
         $orderTypeArray = array('ASC','DESC');
          
        $orderBy = 'booking_id';
        $ordertype = 'DESC';
        
        $orderby = $request->input('orderby');
        $sortval = $request->input('sortval');
        if (($orderby != '') && (in_array($orderby, $orderByArray))){
            $orderBy = $orderby;
        }
        if (($sortval != '') && (in_array($sortval, $orderTypeArray))){
            $ordertype = $sortval;
        }
        
        $totlaResult = $searchResults->get()->count();
        $searchResultsList = $searchResults->take($PerPage)->offset($startpoint)->orderBy($orderBy, $ordertype)->get();
        
        $data['list'] = $searchResultsList;
        $data['pagination'] = ($this->_myFun->myPaginationAjax($totlaResult,ADMIN_PER_PAGE,$currentPage,''));

        return view('admin.booking.index',$data);
    }
  
    function newBooking(){
        $user = auth()->guard('admin')->user();
        $checkUserAccess = $this->_myFun->validateUserAccess('new-booking','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        return view('admin.booking.new');
    }
    function calendarView(){
        $user = auth()->guard('admin')->user();
       
        $checkUserAccess = $this->_myFun->validateUserAccess('calendar-view','view');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        return view('admin.booking.calendar');
    }

}
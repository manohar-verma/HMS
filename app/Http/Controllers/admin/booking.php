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
        
        $searchTerm = $request->input('searchTerm');
        $page   = $request->input('page');
        $orderby = $request->input('orderby');
        $sortval = $request->input('sortval');
        $searchResults = DB::table('bookings')
        ->join('users', 'bookings.guest_id', '=', 'users.id')
        ->select('users.name','users.phone', 'bookings.*');
       
            if($searchTerm != ''){
                $searchResults->where('users.name','LIKE', '%'.$searchTerm.'%')
                 ->orWhere('bookings.booking_id', 'LIKE', '%' . $searchTerm . '%');
            }
           
           $PerPage = ADMIN_PER_PAGE;
           $currentPage = $page? $page : 1;
           if((!is_numeric($currentPage)) || ($currentPage < 1) ){
                $currentPage = 1;
            }
            $startpoint = (floor($currentPage) * $PerPage) - $PerPage;
        
         $orderByArray = array('booking_id','check_in_date','check_out_date','booking_status');
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
        $data['guest'] = DB::table('users')->where('is_deleted','0')->where('status','1')->get();
        $data['hotels'] = DB::table('hotels')->where('status','1')->get();

        $data['availableRooms'] = [];
        return view('admin.booking.new',$data);
    }
    function editBooking($booking_id){
        $user = auth()->guard('admin')->user();
        $checkUserAccess = $this->_myFun->validateUserAccess('all-booking','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $bookingData = DB::table('bookings')->where('booking_id',$booking_id)->first();
        if(!empty($bookingData)){
            $data['guest'] = DB::table('users')->where('is_deleted','0')->where('status','1')->get();
            $data['hotels'] = DB::table('hotels')->where('status','1')->get();
            $data['bookedRoomInfo'] = DB::table('booking_rooms')->where('booking_id',$booking_id)->get();
            $data['paymentInfo'] = DB::table('payments')->where('booking_id',$booking_id)->first();
            $data['bookingData'] = $bookingData;
            $data['bookingDays'] = $this->calculateStayDays($bookingData->check_in_date, $bookingData->check_out_date);
            $data['availableRooms'] = [];
            //echo "<pre>"; print_r($data);die;
            return view('admin.booking.edit',$data);
        }else{
            Session::put('error', 'Sorry booking not found');
            return redirect(ADMIN_URL.'/booking/all-booking');
        }
    }
    function checkAvailableRooms(Request $request)
    {
     try {
       $checkIn   = date('Y-m-d',strtotime($request->input('checkin')));
       $checkOut  = date('Y-m-d',strtotime($request->input('checkout')));
       $hotel_id   = $request->input('hotel_id');
         $availableRooms = DB::table('rooms')
        ->where('is_active', '1')
        ->where('hotel_id', $hotel_id)
        ->whereNotIn('room_id', function ($query) use ($checkIn, $checkOut) {
            $query->select('room_id')
                ->from('booking_rooms')
                ->join('bookings', 'booking_rooms.booking_id', '=', 'bookings.booking_id')
                ->where(function ($subQuery) use ($checkIn, $checkOut) {
                    $subQuery->where('bookings.check_in_date', '<', $checkOut)
                            ->where('bookings.check_out_date', '>', $checkIn);
                });
        })->get()->toArray();
        if(count($availableRooms)>0){
           
            foreach($availableRooms as $key=>$room){
               $roomTypeData = DB::table('room_type')->where('type_id',$room->room_type_id)->where('status','1')->first();
               if(!empty($roomTypeData)){
                  $availableRooms[$key]->room_type = $roomTypeData->title;
               }else{
                  $availableRooms[$key]->room_type = '';
               }
            }
            return $availableRooms;
        }else{
            return [];
        }
        } catch (\Exception $e) {
            Log::error('Error fetching available rooms: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch available rooms //'], 500);
        }
    }
    function calculateStayDays($checkinDate, $checkoutDate)
    {
        if ($checkinDate && $checkoutDate) {
            $checkin = Carbon::parse(trim($checkinDate));
            $checkout = Carbon::parse(trim($checkoutDate));

            // Calculate difference in days
            $daysDiff = $checkin->diffInDays($checkout, false); // false allows negative values
           
            // Ensure at least 1 day
            $numDays = $daysDiff > 0 ? $daysDiff : 1;

            return $numDays;
        }

        return null; // or handle missing dates as needed
    }
    function bookingSubmit(Request $request){
     try {
       $hotel_id  = $request->input('hotels'); 
       $available_rooms  = $request->input('available_rooms');
       $checkIn   = date('Y-m-d',strtotime($request->input('checkIn')));
       $checkOut  = date('Y-m-d',strtotime($request->input('checkOut')));
       $getRoomInfo  = DB::table('rooms')->where('hotel_id',$hotel_id)->whereIn('room_id',$available_rooms)->where('is_active','1')->get();
       $bookingDays  = $this->calculateStayDays($checkIn, $checkOut);
       $guest_id  = $request->input('guest');
       $num_guests  = $request->input('num_guests');
       $payment_method  = $request->input('payment_method');
       $payment_ref  = $request->input('payment_ref');
        if($getRoomInfo->count()>0){
            $total_amount = 0;
            foreach ($getRoomInfo as $item) {
                $total_amount += $item->base_price * $bookingDays;
            }
            $total_amount = number_format($total_amount, 2, '.', '');
           $booking_id = DB::transaction(function  () use ($guest_id, $num_guests, $payment_method, $payment_ref, $total_amount, $getRoomInfo, $checkIn, $checkOut,  $hotel_id) { 
                
                // Insert into booking table
                DB::table('bookings')->insert([
                    'guest_id' => $guest_id,
                    'hotel_id' => $hotel_id,
                    'booking_ref' => 'admin_'.time(),
                    'check_in_date' =>$checkIn,
                    'check_out_date'=>$checkOut,
                    'num_guests'=>$num_guests,
                    'total_amount'=>$total_amount,
                    'booking_status'=>'success',
                    'created_at'=>date('Y-m-d'),
                    'updated_at'=>date('Y-m-d')
                ]);
                 $booking_id = DB::getPdo()->lastInsertId(); 
                // Insert into booking_rooms table
                foreach ($getRoomInfo as $item) {
                    DB::table('booking_rooms')->insert([
                        'booking_id' => $booking_id, // or use Eloquent's
                        'room_id' => $item->room_id,
                        'room_count'=>1,
                        'room_base_price'=>$item->base_price
                    ]);
                }
                // Insert into payments table
                DB::table('payments')->insert([
                    'booking_id' => $booking_id,
                    'payment_ref' => $payment_ref,
                    'payment_method'=> $payment_method,
                    'amount'=>$total_amount,
                    'status'=>'paid',
                    'paid_at'=>date('Y-m-d')
                ]);
               return $booking_id;
            });
             Session::put('success', 'Booked successfully');
             return redirect(ADMIN_URL.'/booking/all-booking/'.$booking_id);
        }else{
            Log::error('failed to fetch room data: ' . $hotel_id.'/'.$rooms_id);
            Session::put('error','Some thing went wrong please try again');
            return redirect(ADMIN_URL.'/booking/new-booking');
        }
       } catch (\Exception $e){
          // Rollback happens automatically
          Log::error('booking Transaction failed: ' . $e->getMessage());
          Session::put('error','Some thing went wrong please try again');
          return redirect(ADMIN_URL.'/booking/new-booking');
       }
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
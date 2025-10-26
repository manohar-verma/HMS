<?php

namespace App\Http\Controllers\admin;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\Models\Room_Mod; // Fetch value from Aircraft Table
use App\Models\hotel_mod;
use App\Models\RoomType_Mod;
use App\Models\Amenities_Mod;
use App\library\my_functions; // Get custom function
use App\library\fn_image_resize; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use Auth;
use Config;

class room_controller extends BaseController
{
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
        $this->_myFunImage = new Fn_image_resize;
    }
    
    function index(Request $request)
    {
            $checkUserAccess = $this->_myFun->validateUserAccess('room','view');
            if($checkUserAccess == false)
            {
                Session::put('error',ACCESS_DENIED_ALERT);
                return redirect(ADMIN_URL.'/dashboard');
            }  
            $search = $request->input('search');
            $page   = $request->input('page');
            
            $orderby = $request->input('orderby');
            $sortval = $request->input('sortval');
            $searchResults = Room_Mod::
            where(function($query) use ($search) {
                if($search != ''){
                    $query->where('name','LIKE', '%'.$search.'%');
                }
            });
           $PerPage = ADMIN_PER_PAGE;
           $currentPage = $page? $page : 1;
           if((!is_numeric($currentPage)) || ($currentPage < 1) ){
                $currentPage = 1;
            }
            $startpoint = (floor($currentPage) * $PerPage) - $PerPage;
        
         $orderByArray = array('room_id');
         $orderTypeArray = array('ASC','DESC');
          
        $orderBy = 'room_id';
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
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('room','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('room','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('room','delete');
        
        return view('admin.room.list',$data);
    }
    function create()
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('room','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }  
        $data['hotel']=hotel_mod::where('status','1')->get(); 
        $data['type']=RoomType_Mod::where('status','true')->get();
        $data['amenities']=Amenities_Mod::where('status','1')->get();
        return view('admin.room.add',$data);
    }
    function store( Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('room','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
        $hotel_id= $request->input('hotel_id');
        $room_number= $request->input('room_number');
        $room_type_id= $request->input('room_type_id');
        $max_guests= $request->input('max_guests');
        $description= $request->input('description');
        $base_price= $request->input('base_price');
        $amenities= json_encode($request->input('amenities'));
        $is_active= $request->input('is_active');
       
            $dataInsert=array(
                    'hotel_id'=>$hotel_id,
                    'room_number'=>$room_number,
                    'room_type_id'=>$room_type_id,
                    'description'=>$description,
                    'max_guests'=>$max_guests,
                    'base_price'=>$base_price,
                    'amenities'=>$amenities,
                    'is_active'=>$is_active,
                    'created_at'=>date('Y-m-d h:i:s'),
                   
            );
            
    
            $isInserted=Room_Mod::insert($dataInsert);
            if($isInserted)
            {
                Session::put('success', 'inserted successfully');
                return redirect(ADMIN_URL.'/room');
            }
            else{
                Session::put('error', 'Failed to add ');
                return redirect(ADMIN_URL.'/room/create');
            }
    }
    function edit($Id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('room','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
        $findData= Room_Mod::where('room_id',$Id)->first();
        if(empty($findData))
        {
            Session::put('error', 'Room Not found');
            return redirect(ADMIN_URL.'/room');
        }
        else
        {
            $data['editData'] = Room_Mod::find($Id); 
            $data['hotel'] =hotel_mod::where('status','1')->get();    
            $data['type']=RoomType_Mod::where('status','true')->get();
            $data['amenities']=Amenities_Mod::where('status','1')->get();
            return view('admin.room.edit',$data);
        }
    }
    function update(Request $request,$id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('room','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
        $hotel_id= $request->input('hotel_id');
        $room_number= $request->input('room_number');
        $room_type_id= $request->input('room_type_id');
        $max_guests= $request->input('max_guests');
        $description= $request->input('description');
        $base_price= $request->input('base_price');
        $amenities= json_encode($request->input('amenities'));
        $is_active= $request->input('is_active');
       
            $dataUpdate=array(
                    'hotel_id'=>$hotel_id,
                    'room_number'=>$room_number,
                    'room_type_id'=>$room_type_id,
                    'description'=>$description,
                    'max_guests'=>$max_guests,
                    'base_price'=>$base_price,
                    'amenities'=>$amenities,
                    'is_active'=>$is_active,
                    'created_at'=>date('Y-m-d h:i:s'),
                   
            );

       
        $updateTeam = Room_Mod::where('room_id', $id)->update($dataUpdate);
     
         if($updateTeam){
          
                Session::put('success', 'updated successfully');
                return redirect(ADMIN_URL.'/room');
            }
            else{
                Session::put('error', 'Failed to update ');
                return redirect(ADMIN_URL.'/room/'.$id.'/edit');
            }
        
     }
     function delete($conId)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('room','delete');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        } 
        if($conId !='' && (!empty($conId)))
        {
            $Data=Room_Mod::where('room_id',$conId)->delete();
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/room');
        }
        else{
             return redirect(ADMIN_URL.'/room');
        }
        
     }
     function dostatuschange($id)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('room','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $Data = Room_Mod::find($id);
        if(($id != '') && (!empty($Data))){
            $status = $Data->status;
            if($status == true){
                $updateStatus = false;
            }
            else{
                $updateStatus = true;
            }
            $dataUpdate = array(
                'is_active'=>$updateStatus
            );
            $updateUser = Room_Mod::where('room_id', $id)->update($dataUpdate);
            echo $updateStatus;
        }
     }
}

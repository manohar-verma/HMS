<?php

namespace App\Http\Controllers\admin;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\Models\RoomType_Mod; // Fetch value from Aircraft Table
use App\Models\hotel_mod;
use App\library\my_functions; // Get custom function
use App\library\fn_image_resize; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use Auth;
use Config;

class room_type extends BaseController
{
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
        $this->_myFunImage = new Fn_image_resize;
    }
    
    function index(Request $request)
    {
            $checkUserAccess = $this->_myFun->validateUserAccess('room-type','view');
            if($checkUserAccess == false)
            {
                Session::put('error',ACCESS_DENIED_ALERT);
                return redirect(ADMIN_URL.'/dashboard');
            }  
            $search = $request->input('search');
            $page   = $request->input('page');
            
            $orderby = $request->input('orderby');
            $sortval = $request->input('sortval');
            $searchResults = RoomType_Mod::
            where(function($query) use ($search) {
                if($search != ''){
                    $query->where('title','LIKE', '%'.$search.'%');
                }
            });
           $PerPage = ADMIN_PER_PAGE;
           $currentPage = $page? $page : 1;
           if((!is_numeric($currentPage)) || ($currentPage < 1) ){
                $currentPage = 1;
            }
            $startpoint = (floor($currentPage) * $PerPage) - $PerPage;
        
         $orderByArray = array('type_id');
         $orderTypeArray = array('ASC','DESC');
          
        $orderBy = 'type_id';
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
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('room-type','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('room-type','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('room-type','delete');
        
        return view('admin.room_type.list',$data);
    }
    function create()
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('room-type','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }  
        $data['hotel']=hotel_mod::where('status','1')->get(); 
        return view('admin.room_type.add',$data);
    }
    function store( Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('room-type','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
        $title= $request->input('title');
        $status= $request->input('status');
      
       
            $dataInsert=array(
                    'title'=>$title,
                    'status'=>$status,
                    
                   
            );
            
    
            $isInserted=RoomType_Mod::insert($dataInsert);
            if($isInserted)
            {
                Session::put('success', 'inserted successfully');
                return redirect(ADMIN_URL.'/room-type');
            }
            else{
                Session::put('error', 'Failed to add ');
                return redirect(ADMIN_URL.'/room-type/create');
            }
    }
    function edit($Id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('room-type','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
        $findData= RoomType_Mod::where('type_id',$Id)->first();
        if(empty($findData))
        {
            Session::put('error', 'Room Not found');
            return redirect(ADMIN_URL.'/room');
        }
        else
        {
            $data['editData'] = RoomType_Mod::find($Id); 
            $data['hotel'] =hotel_mod::where('status','1')->get();    
            return view('admin.room_type.edit',$data);
        }
    }
    function update(Request $request,$id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('room-type','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
         $title= $request->input('title');
        $status= $request->input('status');
      
       
            $dataUpdate=array(
                    'title'=>$title,
                    'status'=>$status,
                    
                   
            );

       
        $updateTeam = RoomType_Mod::where('type_id', $id)->update($dataUpdate);
     
         if($updateTeam){
          
                Session::put('success', 'updated successfully');
                return redirect(ADMIN_URL.'/room-type');
            }
            else{
                Session::put('error', 'Failed to update ');
                return redirect(ADMIN_URL.'/room-type/'.$id.'/edit');
            }
        
     }
     function delete($conId)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('room-type','delete');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        } 
        if($conId !='' && (!empty($conId)))
        {
            $Data=RoomType_Mod::where('type_id',$conId)->delete();
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/room-type');
        }
        else{
             return redirect(ADMIN_URL.'/room-type');
        }
        
     }
     function dostatuschange($id)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('room-type','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $Data = RoomType_Mod::where('type_id',$id)->first();
        if(($id != '') && (!empty($Data))){
            $status = $Data->status;
            if($status == true){
                $updateStatus = false;
            }
            else{
                $updateStatus = true;
            }
            $dataUpdate = array(
                'status'=>$updateStatus
            );
            $updateUser = RoomType_Mod::where('type_id', $id)->update($dataUpdate);
            echo $updateStatus;
        }
     }
}
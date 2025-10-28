<?php

namespace App\Http\Controllers\admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\Models\Amenities_Mod; // Fetch value from Aircraft Table
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

class amenities extends BaseController
{
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
        $this->_myFunImage = new Fn_image_resize;
    }
    
    function index(Request $request)
    {
            $checkUserAccess = $this->_myFun->validateUserAccess('amenities','view');
            if($checkUserAccess == false)
            {
                Session::put('error',ACCESS_DENIED_ALERT);
                return redirect(ADMIN_URL.'/dashboard');
            }  
            $search = $request->input('search');
            $page   = $request->input('page');
            
            $orderby = $request->input('orderby');
            $sortval = $request->input('sortval');
            $searchResults = Amenities_Mod::
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
        
         $orderByArray = array('id');
         $orderTypeArray = array('ASC','DESC');
          
        $orderBy = 'id';
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
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('amenities','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('amenities','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('amenities','delete');
        
        return view('admin.amenities.list',$data);
    }
    function create()
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('amenities','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }  
       
        return view('admin.amenities.add');
    }
    function store( Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('amenities','add-new');
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
            
    
            $isInserted=Amenities_Mod::insert($dataInsert);
            if($isInserted)
            {
                Session::put('success', 'inserted successfully');
                return redirect(ADMIN_URL.'/amenities');
            }
            else{
                Session::put('error', 'Failed to add ');
                return redirect(ADMIN_URL.'/amenities/create');
            }
    }
    function edit($Id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('amenities','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
        $findData= Amenities_Mod::where('id',$Id)->first();
        if(empty($findData))
        {
            Session::put('error', 'amenities Not found');
            return redirect(ADMIN_URL.'/amenities');
        }
        else
        {
            $data['editData'] = Amenities_Mod::find($Id); 
            
            return view('admin.amenities.edit',$data);
        }
    }
    function update(Request $request,$id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('amenities','update');
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

       
        $updateTeam = Amenities_Mod::where('id', $id)->update($dataUpdate);
     
         if($updateTeam){
          
                Session::put('success', 'updated successfully');
                return redirect(ADMIN_URL.'/amenities');
            }
            else{
                Session::put('error', 'Failed to update ');
                return redirect(ADMIN_URL.'/amenities/'.$id.'/edit');
            }
        
     }
     function delete($conId)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('amenities','delete');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        } 
        if($conId !='' && (!empty($conId)))
        {
            $Data=Amenities_Mod::where('id',$conId)->delete();
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/amenities');
        }
        else{
             return redirect(ADMIN_URL.'/amenities');
        }
        
     }
     function dostatuschange($id)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('amenities','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $Data = Amenities_Mod::find($id);
        if(($id != '') && (!empty($Data))){
            $status = $Data->status;
            if($status == 1){
                $updateStatus = 0;
            }
            else{
                $updateStatus = 1;
            }
            $dataUpdate = array(
                'status'=>$updateStatus
            );
            $updateUser = Amenities_Mod::where('id', $id)->update($dataUpdate);
            echo $updateStatus;
        }
     }
}

<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\Models\hotel_mod;
use App\Models\Country_Mod;  // Fetch value from Aircraft Table
use App\Models\State_Mod; 
use App\library\my_functions; // Get custom function
use App\library\fn_image_resize; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use Auth;
use Config; 

class hotel extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
        $this->_myFunImage = new Fn_image_resize;
    }
    
    function index(Request $request)
    {
            $checkUserAccess = $this->_myFun->validateUserAccess('hotel','view');
            if($checkUserAccess == false)
            {
                Session::put('error',ACCESS_DENIED_ALERT);
                return redirect(ADMIN_URL.'/dashboard');
            }  
            $search = $request->input('search');
            $page   = $request->input('page');
            
            $orderby = $request->input('orderby');
            $sortval = $request->input('sortval');
            $searchResults = hotel_mod::
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
        
         $orderByArray = array('hotel_id');
         $orderTypeArray = array('ASC','DESC');
          
        $orderBy = 'hotel_id';
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
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('hotel','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('hotel','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('hotel','delete');
        
        return view('admin.hotel.list',$data);
    }
    function create()
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('hotel','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }  
        $data['country']=Country_Mod::get(); 
         $data['state']=State_Mod::get(); 
        return view('admin.hotel.add',$data);
    }
    function store( Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('hotel','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
        $name= $request->input('name');
        $description= $request->input('description');
        $address= $request->input('address');
        $city= $request->input('city');
        $state=trim($request->input('state'));
        $country=trim($request->input('country'));
        $zip_code=trim($request->input('zip_code'));
        $phone=trim($request->input('phone'));
        $email=trim($request->input('email'));
        $star_rating=trim($request->input('star_rating'));
            $dataInsert=array(
                    'name'=>$name,
                    'description'=>$description,
                    'address'=>$address,
                    'city'=>$city,
                    'state'=>$state,
                    'country'=>$country,
                    'zip_code'=>$zip_code,
                    'phone'=>$phone,
                    'email'=>$email,
                    'star_rating'=>$star_rating,
                    'status' => 1,
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'created_at'=>date('Y-m-d h:i:s'),
                   
            );
            
    
            $isInserted=hotel_mod::insert($dataInsert);
            if($isInserted)
            {
                Session::put('success', 'inserted successfully');
                return redirect(ADMIN_URL.'/hotel');
            }
            else{
                Session::put('error', 'Failed to add ');
                return redirect(ADMIN_URL.'/hotel/create');
            }
    }
    function edit($Id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('hotel','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
        $findData= hotel_mod::where('hotel_id',$Id)->first();
        if(empty($findData))
        {
            Session::put('error', 'hotel Not found');
            return redirect(ADMIN_URL.'/hotel');
        }
        else
        {
            $data['hotelData'] = hotel_mod::find($Id);    
             
            $data['country']=Country_Mod::get(); 
            $data['state']=State_Mod::get(); 
            return view('admin.hotel.edit',$data);
        }
    }
    function update(Request $request,$id)
    {
         
        $checkUserAccess = $this->_myFun->validateUserAccess('hotel','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
       
         $name= $request->input('name');
        $description= $request->input('description');
        $address= $request->input('address');
        $city= $request->input('city');
        $state=trim($request->input('state'));
        $country=trim($request->input('country'));
        $zip_code=trim($request->input('zip_code'));
        $phone=trim($request->input('phone'));
        $email=trim($request->input('email'));
        $star_rating=trim($request->input('star_rating'));
            $dataUpdate=array(
                     'name'=>$name,
                    'description'=>$description,
                    'address'=>$address,
                    'city'=>$city,
                    'state'=>$state,
                    'country'=>$country,
                    'zip_code'=>$zip_code,
                    'phone'=>$phone,
                    'email'=>$email,
                    'star_rating'=>$star_rating,
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'created_at'=>date('Y-m-d h:i:s'),
            );

       
        $updateTeam = hotel_mod::where('hotel_id', $id)->update($dataUpdate);
     
         if($updateTeam){
          
                Session::put('success', 'updated successfully');
                return redirect(ADMIN_URL.'/hotel');
            }
            else{
                Session::put('error', 'Failed to update ');
                return redirect(ADMIN_URL.'/hotel/'.$id.'/edit');
            }
        
     }
     function delete($conId)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('hotel','delete');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        } 
        if($conId !='' && (!empty($conId)))
        {
            $Data=hotel_mod::where('hotel_id',$conId)->delete();
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/hotel');
        }
        else{
             return redirect(ADMIN_URL.'/hotel');
        }
        
     }
     function dostatuschange($id)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('hotel','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $Data = hotel_mod::find($id);
        if(($id != '') && (!empty($Data))){
            $status = $Data->status;
            if($status == 1){
                $updateStatus = '0';
            }
            else{
                $updateStatus = '1';
            }
            $dataUpdate = array(
                'status'=>$updateStatus
            );
            $updateUser = hotel_mod::where('hotel_id', $id)->update($dataUpdate);
            echo $updateStatus;
        }
     }

}
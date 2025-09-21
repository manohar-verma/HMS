<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\Models\admin\users_mod; // Fetch value from Aircraft Table
use App\library\my_functions; // Get custom function
use App\library\fn_image_resize; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Auth;
use Config;
use Hash; 

class users extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
        $this->_myFunImage = new Fn_image_resize;
    }
    
    function index(Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('guest','view');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
            $search = $request->input('search');
            $page   = $request->input('page');
            $name   = $request->input('name');
            $phone   = $request->input('phone');
            $orderby = $request->input('orderby');
            $sortval = $request->input('sortval');
            $searchResults = users_mod::
            where(function($query) use ($phone,$name) {
                if($name != ''){
                    $query->where('name','LIKE', '%'.$name.'%');
                }
                if($phone != ''){
                    $query->where('phone','LIKE', '%'.$phone.'%');
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
        
        $totlaResult = $searchResults->where('is_deleted','0')->get()->count();
        $searchResultsList = $searchResults->take($PerPage)->offset($startpoint)->orderBy($orderBy, $ordertype)->get();
        
        $data['list'] = $searchResultsList;
        $data['pagination'] = ($this->_myFun->myPaginationAjax($totlaResult,ADMIN_PER_PAGE,$currentPage,''));
        
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('guest','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('guest','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('guest','delete');
        return view('admin.users.list',$data);
    }
    function create()
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('guest','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        return view('admin.users.add');
    }
    function store( Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('guest','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        
        $name= $request->input('name');
        $email= $request->input('email');
        $phone = $request->input('phone');
        $dob = $request->input('dob');
        $address = $request->input('address');
        $gender = $request->input('gender');
        $status=trim($request->input('status'));
        $userPass = substr($phone,4).str_replace('-','',$dob);
        $password = Hash::make($userPass);

            $dataInsert=array(
                    'name'=>$name,
                    'email'=>$email,
                    'phone'=>$phone,
                    'dob'=>$dob,
                    'address'=>$address,
                    'gender'=>$gender,
                    'password'=>$password,
                    'status'=>$status
            );
           if($_FILES["image"]["name"] != ''){
            $fileName = $_FILES["image"]["name"];
            $extensionArray = explode(".",$fileName);
            $extension = $extensionArray[count($extensionArray)-1];
            $tmp_name = $_FILES["image"]["tmp_name"];
            $file_type = $_FILES["image"]["type"];
            $new_file_name=rand(0000,9999).time().'.'.$extension;
            $uploaddir_normal = ABSOLUTE_PATH."upload/user/normal/";
          
            if(move_uploaded_file($tmp_name, $uploaddir_normal.$new_file_name))
            {
                $dataInsert['image'] = $new_file_name;
            }
        }
            $isInserted=users_mod::insert($dataInsert);
            if($isInserted)
            {
                Session::put('success', 'inserted successfully');
                return redirect(ADMIN_URL.'/users/guest');
            }
            else{
                Session::put('error', 'Failed to add ');
                return redirect(ADMIN_URL.'/users/create/guest');
            }
    }
    function edit($Id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('guest','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $findData= DB::table('users')->where('is_deleted','0')->where('id',$Id)->first();
        if(empty($findData))
        {
            Session::put('error', 'users Not found');
            return redirect(ADMIN_URL.'/users/guest');
        }
        else
        {
            $data = users_mod::find($Id);    
            $data['usersData'] = $data;
            return view('admin.users.edit',$data);
        }
    }
    function update(Request $request,$id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('guest','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $name= $request->input('name');
        $email= $request->input('email');
        $phone = $request->input('phone');
        $dob = $request->input('dob');
        $address = $request->input('address');
        $gender = $request->input('gender');
        $status=trim($request->input('status'));
        $userPass = substr($phone,4).str_replace('-','',$dob);
        $password = Hash::make($userPass);

            $dataUpdate=array(
                    'name'=>$name,
                    'email'=>$email,
                    'phone'=>$phone,
                    'dob'=>$dob,
                    'address'=>$address,
                    'gender'=>$gender,
                    'password'=>$password,
                    'status'=>$status
            );
       if($_FILES["image"]["name"] != ''){
            $fileName = $_FILES["image"]["name"];
            $extensionArray = explode(".",$fileName);
            $extension = $extensionArray[count($extensionArray)-1];
            $tmp_name = $_FILES["image"]["tmp_name"];
            $file_type = $_FILES["image"]["type"];
            $new_file_name=rand(0000,9999).time().'.'.$extension;
            $uploaddir_normal = ABSOLUTE_PATH."upload/user/normal/";
          
            if(move_uploaded_file($tmp_name, $uploaddir_normal.$new_file_name))
            {
                $settData = users_mod::find($id);
                 $pic = $settData['image'];
                 @unlink(ABSOLUTE_PATH."upload/user/normal/".$pic);
                
                $dataUpdate['image'] = $new_file_name;
            }
        }
         $updateTeam = users_mod::where('id', $id)->update($dataUpdate);
     
         if($updateTeam){
          
                Session::put('success', 'updated successfully');
                return redirect(ADMIN_URL.'/users/guest');
            }
            else{
                Session::put('error', 'Failed to update ');
                return redirect(ADMIN_URL.'/users/guest/'.$id.'/edit');
            }
        
     }
     function delete($conId)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('guest','delete');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        if($conId !='' && (!empty($conId)))
        {
            $Data=users_mod::where('id',$conId)->update(['is_deleted'=>'1']);
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/users/guest');
        }
        else{
             return redirect(ADMIN_URL.'/users/guest');
        }
        
     }
     function dostatuschange($id)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('guest','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $Data = users_mod::find($id);
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
            $updateUser = users_mod::where('id', $id)->update($dataUpdate);
            echo $updateStatus;
        }
     }

}
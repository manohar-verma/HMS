<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\library\my_functions; // Get custom function
use App\library\get_site_details; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use App\Models\Admin;
use Auth;
use Config; 

class subAdmin extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
        $this->_myFunUser = new get_site_details;
    }
    function index(Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('sub-admin','view');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $search = $request->input('search');
        $page   = $request->input('page');
        $orderby = $request->input('orderby');
        $sortval = $request->input('sortval');
        $searchResults = Admin::
        where(function($query) use ($search) {
            if($search != ''){
                $query->where('name','LIKE', '%'.$search.'%')
                ->orWhere('email','LIKE', '%'.$search.'%');
                
            }
        })->where('id','!=',1);
        $PerPage = ADMIN_PER_PAGE;
        $currentPage = $page? $page : 1;
        if((!is_numeric($currentPage)) || ($currentPage < 1) ){
            $currentPage = 1;
        }
        $startpoint = (floor($currentPage) * $PerPage) - $PerPage;

         $orderByArray = array('id','first_name');
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
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('sub-admin','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('sub-admin','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('sub-admin','delete');
        $data['pagination'] = ($this->_myFun->myPaginationAjax($totlaResult,ADMIN_PER_PAGE,$currentPage,''));
        
        
        return view('admin.subAdmin.list',$data);
    }
    function create(){
        $checkUserAccess = $this->_myFun->validateUserAccess('sub-admin','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $reportList = $this->_myFunUser->getUserAccess(1);
        $ArrayAccess=explode(",",$reportList);
        $data['accessData']=$ArrayAccess;
        return view('admin.subAdmin.add',$data);
  }
  function store( Request $request)
  {
     
    $checkUserAccess = $this->_myFun->validateUserAccess('sub-admin','add-new');
    if($checkUserAccess == false)
    {
        Session::put('error',ACCESS_DENIED_ALERT);
        return redirect(ADMIN_URL.'/dashboard');
    }
     $name= $request->input('name');
     $email= $request->input('email');
     $allAccess= $request->input('allAccess');
     $allAccessLevel= $request->input('allAccessLevel');
     if(isset($allAccess))
     {
        array_push($allAccess,'change-password');
        $userAccessArray = implode(",",$allAccess);
     }
     else
     {
        $userAccessArray = 'change-password';        
     }
     $password= $request->input('password');
     $status=trim($request->input('status'));
     $password = Hash::make($password);
     $userData= DB::table('admins')->where('is_deleted','0')->where('email', '=',$email)->first();
     if(!empty($userData))
     {
      Session::put('error', 'Email already exist');
      return redirect(ADMIN_URL.'/users/sub-admin/create');
    }
    else
    {
         $dataInsert=array(
            'name'=>$name,
            'email'=>$email,
            'password'=>$password,
            'status'=>$status
            );
        $isInserted=Admin::insertGetId($dataInsert);
        if($isInserted)
        {
            $accessExist = DB::table('user_access')->where('user_id',$isInserted)->first();
            if(empty($accessExist)){
            $arrayAccessAdd = array(
                'user_id'=>$isInserted,
                'allowed_access'=>$userAccessArray
            );    
             $addAccess = DB::table('user_access')->insert($arrayAccessAdd);
              if($addAccess)
              {
                Session::put('success', 'Access added');
              }
              else
              {
                Session::put('error', 'Failed to add access');
              }
            }
            else
            {
                Session::put('error', 'Access already exist');
            }
            if(isset($allAccessLevel))
            {
               foreach($allAccessLevel as $keyName=>$accessLevel)
               {
                    foreach($accessLevel as $accessType)
                    {
                        $arrayOption=array(
                            'user_id'=>$isInserted,
                            'report_name'=>$keyName,
                            'access_type'=>$accessType,
                          );
                          $validateAccess = DB::table('reportaccesslevel')->where('user_id',$isInserted)->where('report_name',$keyName)->where('access_type',$accessType)->first();
                          if(empty($validateAccess)){
                            $addAccessLevel = DB::table('reportaccesslevel')->insert($arrayOption);
                            if($addAccessLevel)
                            {
                                Session::put('success','Access level added');
                            }
                            else
                            {
                                Session::put('error','Failed to add access level');
                            }
                          }
                          else
                          {
                            Session::put('error','Failed to update access level');
                          }
                    }
               }
            }
            Session::put('success', 'Sub admin'.SUCCESS_ALERT_A_ADD);
            return redirect(ADMIN_URL.'/users/sub-admin');
        }
        else
        {
            Session::put('error',FAILED_ALERT_A_ADD.'sub admin');
            return redirect(ADMIN_URL.'/users/sub-admin/create');
        }
    }
   
  }
  function edit($id)
  {
    $checkUserAccess = $this->_myFun->validateUserAccess('sub-admin','update');
    if($checkUserAccess == false)
    {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
    }
      $UserData = Admin::find($id);
      $data['userData'] = $UserData;
      $accessList = $this->_myFunUser->getUserAccess(1);
      $arrayAccess=explode(",",$accessList);
      $data['accessData']=$arrayAccess;
      $userAccessData = $this->_myFunUser->getUserAccess($UserData->id);
      $userAccessList = $rolls=(explode(",",$userAccessData));
      $data['userAccessList']=$userAccessList;
      $accessTypeList = array();
      foreach($arrayAccess as $access)
      {
        $accessLevel = DB::table('reportaccesslevel')->where('user_id',$id)->where('report_name',$access)->get();
        $subLevelAccess =array();
        foreach($accessLevel as $level)
        {
           array_push($subLevelAccess,$level->access_type);
        }
        $accessTypeList[$access] = $subLevelAccess;
      }
      $data['accessTypeList']=$accessTypeList;
      return view('admin.subAdmin.edit',$data);
  }
  function update(Request $request,$id)
  {
    $checkUserAccess = $this->_myFun->validateUserAccess('sub-admin','update');
    if($checkUserAccess == false)
    {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
    }
     $name= $request->input('name');
     $email= $request->input('email');
     $allAccess= $request->input('allAccess');
     $allAccessLevel= $request->input('allAccessLevel');
     if(isset($allAccess))
     {
        array_push($allAccess,'change-password');
        $userAccessArray = implode(",",$allAccess);
     }
     else
     {
        $userAccessArray = 'change-password';        
     }
     $password = $request->input('password');
     $status=trim($request->input('status'));

     $dataUpdate=array(
        'name'=>$name,
        'email'=>$email,
        'status'=>$status
        );
    if(!empty($password))
    {
        $dataUpdate['password'] = $password = Hash::make($password);
    }
    $arrayAccessUpdate = array('allowed_access'=>$userAccessArray);
    $updateAccess = DB::table('user_access')->where('user_id',$id)->update($arrayAccessUpdate);    
    $updateUser = Admin::where('id', $id)->update($dataUpdate);
       
      if($updateUser || $updateAccess)
      {
        if(isset($allAccessLevel))
            {
               DB::table('reportaccesslevel')->where('user_id',$id)->delete();
               foreach($allAccessLevel as $keyName=>$accessLevel)
               {
                    foreach($accessLevel as $accessType)
                    {
                        $arrayOption=array(
                            'user_id'=>$id,
                            'report_name'=>$keyName,
                            'access_type'=>$accessType,
                          );
                          $validateAccess = DB::table('reportaccesslevel')->where('user_id',$id)->where('report_name',$keyName)->where('access_type',$accessType)->first();
                          if(empty($validateAccess)){
                            $updateAccessLevel= DB::table('reportaccesslevel')->insert($arrayOption);
                          }
                    }
               }
            }
            Session::put('success', 'Sub admin'.SUCCESS_ALERT_A_UPDATE);
            return redirect(ADMIN_URL.'/users/sub-admin');
        }
        else
        {
            Session::put('error',FAILED_ALERT_A_UPDATE.'sub admin');
            return redirect(ADMIN_URL.'/users/sub-admin/'.$id.'/edit');
        }
    
  }
  function doStatusChange($id)
  {
    $checkUserAccess = $this->_myFun->validateUserAccess('sub-admin','update');
    if($checkUserAccess == false)
    {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
    }
    $UserData = Admin::find($id);
    if(($id != '') && (!empty($UserData))){
        $status = $UserData->status;
        if($status == 1){
            $updateStatus = '0';
        }
        else{
            $updateStatus = '1';
        }
        $dataUpdate = array(
            'status'=>$updateStatus
        );
        $updateUser = Admin::where('id', $id)->update($dataUpdate);
        echo $updateStatus;
       }
  }

    function doDelete($id){
        $checkUserAccess = $this->_myFun->validateUserAccess('sub-admin','delete');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        } 
        $UserData = Admin::find($id);
        if(($id != '') && (!empty($UserData))){
            $UserData = Admin::where('id', $id)->update(['is_deleted'=>'1','status'=>'0']);
            Session::put('success', ' deleted successfully');
            return redirect(ADMIN_URL.'/users/sub-admin');
        }
        else{
            return redirect(ADMIN_URL.'/users/sub-admin');
        }
    }
}
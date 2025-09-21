<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\Models\admin\banner_mod; // Fetch value from Aircraft Table
use App\library\my_functions; // Get custom function
use App\library\fn_image_resize; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use Auth;
use Config; 

class banner extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
        $this->_myFunImage = new Fn_image_resize;
    }
    
    function index(Request $request)
    {
            $checkUserAccess = $this->_myFun->validateUserAccess('banner','view');
            if($checkUserAccess == false)
            {
                Session::put('error',ACCESS_DENIED_ALERT);
                return redirect(ADMIN_URL.'/dashboard');
            }  
            $search = $request->input('search');
            $page   = $request->input('page');
            
            $orderby = $request->input('orderby');
            $sortval = $request->input('sortval');
            $searchResults = banner_mod::
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
        
        $totlaResult = $searchResults->where('is_deleted','0')->get()->count();
        $searchResultsList = $searchResults->take($PerPage)->offset($startpoint)->orderBy($orderBy, $ordertype)->get();
        
        $data['list'] = $searchResultsList;
        $data['pagination'] = ($this->_myFun->myPaginationAjax($totlaResult,ADMIN_PER_PAGE,$currentPage,''));
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('banner','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('banner','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('banner','delete');
        
        return view('admin.banner.list',$data);
    }
    function create()
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('banner','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
        return view('admin.banner.add');
    }
    function store( Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('banner','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
        $slider_text= $request->input('slider_text');
        $type= $request->input('type');
        $title= $request->input('title');
        $redirection_url= $request->input('redirection_url');
        $status=trim($request->input('status'));
            $dataInsert=array(
                    'slider_text'=>$slider_text,
                    'title'=>$title,
                    'type'=>$type,
                    'redirection_url'=>$redirection_url?$redirection_url:'',
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'created_at'=>date('Y-m-d h:i:s'),
                    'status'=>$status
            );
            if($_FILES["slider_name"]["name"] != ''){
                $fileName = $_FILES["slider_name"]["name"];
                $extensionArray = explode(".",$fileName);
                $extension = $extensionArray[count($extensionArray)-1];
                $tmp_name = $_FILES["slider_name"]["tmp_name"];
                $file_type = $_FILES["slider_name"]["type"];
                $new_file_name=rand(0000,9999).time().'.'.$extension;
                $uploaddir_normal = ABSOLUTE_PATH."upload/banner/normal/";
                $uploaddir_thumb = ABSOLUTE_PATH."upload/banner/thumb/";
                if(move_uploaded_file($tmp_name, $uploaddir_normal.$new_file_name))
                {
                   // $this->_myFunImage->createThumb($uploaddir_normal.$new_file_name,$uploaddir_thumb.$new_file_name,$file_type,360,180,''); // for thumb image
                    $dataInsert['slider_name'] = $new_file_name;
                }
               } 
    
            $isInserted=banner_mod::insert($dataInsert);
            if($isInserted)
            {
                Session::put('success', 'inserted successfully');
                return redirect(ADMIN_URL.'/banner');
            }
            else{
                Session::put('error', 'Failed to add ');
                return redirect(ADMIN_URL.'/banner/create');
            }
    }
    function edit($Id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('banner','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
        $findData= DB::table('site_banner')->where('id',$Id)->first();
        if(empty($findData))
        {
            Session::put('error', 'slider Not found');
            return redirect(ADMIN_URL.'/banner');
        }
        else
        {
            $data = banner_mod::find($Id);    
            $data['bannerData'] = $data;
            return view('admin.banner.edit',$data);
        }
    }
    function update(Request $request,$id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('banner','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }   
        $slider_text= $request->input('slider_text');
        $redirection_url= $request->input('redirection_url');
        $type= $request->input('type');
        $title= $request->input('title');
        $status=trim($request->input('status'));
            $dataUpdate=array(
                    'slider_text'=>$slider_text,
                    'type'=>$type,
                    'title'=>$title,
                    'redirection_url'=>$redirection_url?$redirection_url:'',
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'created_at'=>date('Y-m-d h:i:s'),
                    'status'=>$status
            );

        if($_FILES["slider_name"]["name"] != ''){
                $fileName = $_FILES["slider_name"]["name"];
                $extensionArray = explode(".",$fileName);
                $extension = $extensionArray[count($extensionArray)-1];
                $tmp_name = $_FILES["slider_name"]["tmp_name"];
                $file_type = $_FILES["slider_name"]["type"];
                $new_file_name=rand(0000,9999).time().'.'.$extension;
                $uploaddir_normal = ABSOLUTE_PATH."upload/banner/normal/";
                $uploaddir_thumb = ABSOLUTE_PATH."upload/banner/thumb/";
                if(move_uploaded_file($tmp_name, $uploaddir_normal.$new_file_name))
                {
                   // $this->_myFunImage->createThumb($uploaddir_normal.$new_file_name,$uploaddir_thumb.$new_file_name,$file_type,360,180,''); // for thumb image
                   
                    $settData = banner_mod::find($id);
                     $pic = $settData['slider_name'];
                     @unlink(ABSOLUTE_PATH."upload/banner/normal/".$pic);
                     @unlink(ABSOLUTE_PATH."upload/banner/thumb/".$pic);
                     
                    $dataUpdate['slider_name'] = $new_file_name;
                }
            }
        $updateTeam = banner_mod::where('id', $id)->update($dataUpdate);
     
         if($updateTeam){
          
                Session::put('success', 'updated successfully');
                return redirect(ADMIN_URL.'/banner');
            }
            else{
                Session::put('error', 'Failed to update ');
                return redirect(ADMIN_URL.'/banner/'.$id.'/edit');
            }
        
     }
     function delete($conId)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('banner','delete');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        } 
        if($conId !='' && (!empty($conId)))
        {
            $Data=banner_mod::where('id',$conId)->update(['is_deleted'=>'1']);
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/banner');
        }
        else{
             return redirect(ADMIN_URL.'/banner');
        }
        
     }
     function dostatuschange($id)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('banner','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $Data = banner_mod::find($id);
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
            $updateUser = banner_mod::where('id', $id)->update($dataUpdate);
            echo $updateStatus;
        }
     }

}
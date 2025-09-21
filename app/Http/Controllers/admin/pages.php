<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\Models\admin\pages_mod; // Fetch value from Aircraft Table
use App\library\my_functions; // Get custom function
use App\library\fn_image_resize; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use App\Models\User;
use Auth;
use Config; 

class pages extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
        $this->_myFunImage = new Fn_image_resize;
    }
    
    function index(Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('page','view');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
            $search = $request->input('search');
            $page   = $request->input('page');
            $pageType   = $request->input('pageType');
            $orderby = $request->input('orderby');
            $sortval = $request->input('sortval');
            $searchResults = pages_mod::
            where(function($query) use ($search,$pageType) {
                if($search != ''){
                    $query->where('title','LIKE', '%'.$search.'%');
                }
                if($pageType != ''){
                    $query->where('page_category',$pageType);
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
        
        $pageCategory = DB::table('page_category')->where('is_deleted','0')->where('status','1')->get();
        $data['pageCategory'] = $pageCategory;
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('page','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('page','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('page','delete');
        return view('admin.pages.list',$data);
    }
    function create()
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('page','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $pageCategory = DB::table('page_category')->where('is_deleted','0')->where('status','1')->get();
        $data['pageCategory'] = $pageCategory;
        return view('admin.pages.add',$data);
    }
    function store( Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('page','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $title= $request->input('title');
        $page_category= $request->input('page_category');
        $meta_description= $request->input('meta_description');
        $meta_keyword= $request->input('meta_keyword');
        $description=$request->input('description');
        $short_description=$request->input('short_description');
        $status=trim($request->input('status'));

        $arra1 = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');
            $arra2 = array('-','-','-','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');

            $fialias=str_replace($arra1,$arra2,strtolower($title));
            $ValidateAlias = DB::table('cms')->where('alias',$fialias)->first();
            if(!empty($ValidateAlias))
            {
            $fialias=$fialias.'-'.rand();
            }
            $dataInsert=array(
                    'title'=>$title,
                    'page_category'=>$page_category,
                    'meta_description'=>$meta_description?$meta_description:'',
                    'meta_keyword'=>$meta_keyword?$meta_keyword:'',
                    'description'=>$description?$description:'',
                    'short_description'=>$short_description?$short_description:'',
                    'date_time'=>date('Y-m-d h:i:s'),
                    'alt_tag'=>'',
                    'alias'=>$fialias,
                    'status'=>$status
            );
            if($_FILES["image"]["name"] != ''){
                $fileName = $_FILES["image"]["name"];
                $extensionArray = explode(".",$fileName);
                $extension = $extensionArray[count($extensionArray)-1];
                $tmp_name = $_FILES["image"]["tmp_name"];
                $file_type = $_FILES["image"]["type"];
                $new_file_name=rand(0000,9999).time().'.'.$extension;
                $uploaddir_normal = ABSOLUTE_PATH."upload/pages/normal/";
                $uploaddir_thumb = ABSOLUTE_PATH."upload/pages/thumb/";
                $uploaddir_crop = ABSOLUTE_PATH."upload/pages/crop/";
                $thumb_crop=ABSOLUTE_PATH."upload/pages/thumb_crop/";
                if(move_uploaded_file($tmp_name, $uploaddir_normal.$new_file_name))
                {
                    $this->_myFunImage->createThumb($uploaddir_normal.$new_file_name,$uploaddir_thumb.$new_file_name,$file_type,360,180,''); // for thumb image
                    $this->_myFunImage->createCrop($uploaddir_normal.$new_file_name,$uploaddir_crop.$new_file_name,$file_type,360,180); // for crop image
                    $this->_myFunImage->createThumb($uploaddir_normal.$new_file_name,$thumb_crop.$new_file_name,$file_type,'','',61); // for thumb_crop
                    $dataInsert['image'] = $new_file_name;
                }
               } 
    
            $isInserted=pages_mod::insert($dataInsert);
            if($isInserted)
            {
                Session::put('success', 'inserted successfully');
                return redirect(ADMIN_URL.'/pages');
            }
            else{
                Session::put('error', 'Failed to add ');
                return redirect(ADMIN_URL.'/pages/create');
            }
    }
    function edit($Id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('page','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $findData= DB::table('cms')->where('is_deleted','0')->where('id',$Id)->first();
        if(empty($findData))
        {
            Session::put('error', 'page Not found');
            return redirect(ADMIN_URL.'/pages');
        }
        else
        {
            $data = pages_mod::find($Id);    
            $data['pageData'] = $data;
            $pageCategory = DB::table('page_category')->where('is_deleted','0')->where('status','1')->get();
            $data['pageCategory'] = $pageCategory;
            return view('admin.pages.edit',$data);
        }
    }
    function update(Request $request,$id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('page','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $title= $request->input('title');
        $page_category= $request->input('page_category');
        $meta_description= $request->input('meta_description');
        $meta_keyword= $request->input('meta_keyword');
        $description=$request->input('description');
        $short_description=$request->input('short_description');
        $status=trim($request->input('status'));

        $arra1 = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');
        $arra2 = array('-','-','-','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
        $fialias=str_replace($arra1,$arra2,strtolower($title));
        $ValidateAlias = DB::table('cms')->where('alias',$fialias)->where('id','!=',$id)->first();
        if(!empty($ValidateAlias))
        {
          $fialias=$fialias.'-'.rand();
        }
        $dataUpdate=array(
            'title'=>$title,
            'page_category'=>$page_category,
            'meta_description'=>$meta_description?$meta_description:'',
            'meta_keyword'=>$meta_keyword?$meta_keyword:'',
            'description'=>$description?$description:'',
            'short_description'=>$short_description?$short_description:'',
            'date_time'=>date('Y-m-d h:i:s'),
            'alt_tag'=>'',
            'alias'=>$fialias,
            'status'=>$status
        );
        if($_FILES["image"]["name"] != ''){
                $fileName = $_FILES["image"]["name"];
                $extensionArray = explode(".",$fileName);
                $extension = $extensionArray[count($extensionArray)-1];
                $tmp_name = $_FILES["image"]["tmp_name"];
                $file_type = $_FILES["image"]["type"];
                $new_file_name=rand(0000,9999).time().'.'.$extension;
                $uploaddir_normal = ABSOLUTE_PATH."upload/pages/normal/";
                $uploaddir_thumb = ABSOLUTE_PATH."upload/pages/thumb/";
                $uploaddir_crop = ABSOLUTE_PATH."upload/pages/crop/";
                $thumb_crop=ABSOLUTE_PATH."upload/pages/thumb_crop/";
                if(move_uploaded_file($tmp_name, $uploaddir_normal.$new_file_name))
                {
                    $this->_myFunImage->createThumb($uploaddir_normal.$new_file_name,$uploaddir_thumb.$new_file_name,$file_type,360,180,''); // for thumb image
                    $this->_myFunImage->createCrop($uploaddir_normal.$new_file_name,$uploaddir_crop.$new_file_name,$file_type,360,180); // for crop image
                    $this->_myFunImage->createThumb($uploaddir_normal.$new_file_name,$thumb_crop.$new_file_name,$file_type,'','',61); // for thumb_crop
                    $settData = pages_mod::find($id);
                     $pic = $settData['image'];
                     @unlink(ABSOLUTE_PATH."upload/pages/normal/".$pic);
                     @unlink(ABSOLUTE_PATH."upload/pages/thumb/".$pic);
                     @unlink(ABSOLUTE_PATH."upload/pages/crop/".$pic);
                     @unlink(ABSOLUTE_PATH."upload/pages/thumb_crop/".$pic);
                     $dataUpdate['image'] = $new_file_name;
                }
            }
         $updateTeam = pages_mod::where('id', $id)->update($dataUpdate);
     
         if($updateTeam){
          
                Session::put('success', 'updated successfully');
                return redirect(ADMIN_URL.'/pages');
            }
            else{
                Session::put('error', 'Failed to update ');
                return redirect(ADMIN_URL.'/pages/'.$id.'/edit');
            }
        
     }
     function delete($conId)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('page','delete');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        if($conId !='' && (!empty($conId)))
        {
            $Data=pages_mod::where('id',$conId)->update(['is_deleted'=>'1']);
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/pages');
        }
        else{
             return redirect(ADMIN_URL.'/pages');
        }
        
     }
     function dostatuschange($id)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('page','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $Data = pages_mod::find($id);
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
            $updateUser = pages_mod::where('id', $id)->update($dataUpdate);
            echo $updateStatus;
        }
     }

}
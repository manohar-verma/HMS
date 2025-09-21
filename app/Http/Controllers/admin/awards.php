<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\Models\admin\awards_mod; // Fetch value from Aircraft Table
use App\library\my_functions; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use App\Models\User;
use Auth;
use Config; 

class awards extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
    }
    
    function index(Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('awards','view');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
            $search = $request->input('search');
            $page   = $request->input('page');
            $orderby = $request->input('orderby');
            $sortval = $request->input('sortval');
            $searchResults = awards_mod::
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
        
       
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('awards','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('awards','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('awards','delete');
        return view('admin.awards.list',$data);
    }
    function create()
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('awards','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        
        return view('admin.awards.add');
    }
    function store( Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('awards','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $title= $request->input('title');
        $year= $request->input('year');
        $award_by= $request->input('award_by');
        $description=$request->input('description');
        $status=trim($request->input('status'));

        $arra1 = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');
            $arra2 = array('-','-','-','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');

            $fialias=str_replace($arra1,$arra2,strtolower($title));
            $ValidateAlias = DB::table('awards')->where('alias',$fialias)->first();
            if(!empty($ValidateAlias))
            {
            $fialias=$fialias.'-'.rand();
            }
            $dataInsert=array(
                    'title'=>$title,
                    'year'=>$year,
                    'award_by'=>$award_by,
                    'description'=>$description?$description:'',
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
                    $uploaddir_normal = ABSOLUTE_PATH."upload/awards/normal/";
                   
                    if(move_uploaded_file($tmp_name, $uploaddir_normal.$new_file_name))
                    {
                        $dataInsert['image'] = $new_file_name;
                    }
            }

            $isInserted=awards_mod::insert($dataInsert);
            if($isInserted)
            {
                Session::put('success', 'inserted successfully');
                return redirect(ADMIN_URL.'/awards');
            }
            else{
                Session::put('error', 'Failed to add ');
                return redirect(ADMIN_URL.'/awards/create');
            }
    }
    function edit($Id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('awards','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $findData= DB::table('awards')->where('is_deleted','0')->where('id',$Id)->first();
        if(empty($findData))
        {
            Session::put('error', 'awards Not found');
            return redirect(ADMIN_URL.'/awards');
        }
        else
        {
            $data = awards_mod::find($Id);    
            $data['awardsData'] = $data;
           
            return view('admin.awards.edit',$data);
        }
    }
    function update(Request $request,$id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('awards','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $title= $request->input('title');
        $year= $request->input('year');
        $award_by= $request->input('award_by');
        $description=$request->input('description');
        $status=trim($request->input('status'));
       
        $status=trim($request->input('status'));

        $arra1 = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');
        $arra2 = array('-','-','-','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
        $fialias=str_replace($arra1,$arra2,strtolower($title));
        $ValidateAlias = DB::table('awards')->where('alias',$fialias)->where('id','!=',$id)->first();
        if(!empty($ValidateAlias))
        {
          $fialias=$fialias.'-'.rand();
        }
        $dataUpdate=array(
            'title'=>$title,
            'year'=>$year,
            'award_by'=>$award_by,
            'description'=>$description?$description:'',
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
                    $uploaddir_normal = ABSOLUTE_PATH."upload/awards/normal/";
                   
                    if(move_uploaded_file($tmp_name, $uploaddir_normal.$new_file_name))
                    {
                        $settData = awards_mod::find($id);
                        $pic = $settData['image'];
                        @unlink(ABSOLUTE_PATH."upload/awards/normal/".$pic);
                        $dataUpdate['image'] = $new_file_name;
                    }
            }
          
         $updateTeam = awards_mod::where('id', $id)->update($dataUpdate);
     
         if($updateTeam){
          
                Session::put('success', 'updated successfully');
                return redirect(ADMIN_URL.'/awards');
            }
            else{
                Session::put('error', 'Failed to update ');
                return redirect(ADMIN_URL.'/awards/'.$id.'/edit');
            }
        
     }
     function delete($conId)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('awards','delete');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        if($conId !='' && (!empty($conId)))
        {
            $Data=awards_mod::where('id',$conId)->update(['is_deleted'=>'1']);
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/awards');
        }
        else{
             return redirect(ADMIN_URL.'/awards');
        }
        
     }
     function doStatusChange($id)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('awards','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $Data = awards_mod::find($id);
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
            $updateUser = awards_mod::where('id', $id)->update($dataUpdate);
            echo $updateStatus;
        }
     }

}
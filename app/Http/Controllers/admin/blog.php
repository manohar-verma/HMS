<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\Models\admin\blog_mod; // Fetch value from Aircraft Table
use App\library\my_functions; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use Auth;
use Config; 

class blog extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
    }
    
    function index(Request $request)
    {
            $checkUserAccess = $this->_myFun->validateUserAccess('blog','view');
            if($checkUserAccess == false)
            {
                Session::put('error',ACCESS_DENIED_ALERT);
                return redirect(ADMIN_URL.'/dashboard');
            }
            $search = $request->input('search');
            $page   = $request->input('page');
            
            $orderby = $request->input('orderby');
            $sortval = $request->input('sortval');
            $searchResults = blog_mod::
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
        
         $orderByArray = array('id','title','author','date');
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
        
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('blog','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('blog','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('blog','delete');
        return view('admin.blog.list',$data);
    }
    function create()
    {
        $blog_cat= DB::table('blog_cat')->where('status','1')->get();
        $team=DB::table('team')->where('status','1')->get();
        $data['blog_cat'] = $blog_cat; 
        $data['team'] = $team; 
        return view('admin.blog.add',$data);
    }
    function store( Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('blog','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $title= $request->input('title');
        $author= $request->input('author');
        $category= $request->input('category');
        $tags= $request->input('tags');
        $short_description=$request->input('short_description');
        
        
        $alternate_text=$request->input('alternate_text');
        $date=$request->input('date');
        $meta_description=$request->input('meta_description');
        $meta_keyword=$request->input('meta_keyword');
        $status=$request->input('status');
       
        
            $arra1 = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');
            $arra2 = array('-','-','-','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');

            $fialias=str_replace($arra1,$arra2,strtolower($title));
            $ValidateAlias = DB::table('blogs')->where('alias',$fialias)->first();
            if(!empty($ValidateAlias))
            {
            $fialias=$fialias.'-'.rand();
            }
            $dataInsert=array(
                            'title'=>$title,
                            'alias'=>$fialias,
                            'author'=>$author,
                            'catagory'=>$category,
                            'tags'=>$tags,
                            'description'=>$short_description,
                            'text'=>$alternate_text,
                            'meta_description'=>$meta_description,
                            'meta_keyword'=>$meta_keyword,
                            'status'=>$status,
                            'date'=>$date?date('Y-m-d',strtotime($date)):date('Y-m-d'),
                            );
                if($_FILES["image"]["name"] != ''){
                    $fileName = $_FILES["image"]["name"];
                    $extensionArray = explode(".",$fileName);
                    $extension = $extensionArray[count($extensionArray)-1];
                    $tmp_name = $_FILES["image"]["tmp_name"];
                    $file_type = $_FILES["image"]["type"];
                    $new_file_name=rand(0000,9999).time().'.'.$extension;
                    $uploaddir_normal = ABSOLUTE_PATH."upload/blog/normal/";
                   
                    if(move_uploaded_file($tmp_name, $uploaddir_normal.$new_file_name))
                    {
                        $dataInsert['image'] = $new_file_name;
                    }
                    }
    
            $isInserted=blog_mod::insert($dataInsert);
            if($isInserted)
            {
                Session::put('success', 'inserted successfully');
                return redirect(ADMIN_URL.'/blog');
            }
            else{
                Session::put('error', 'Failed to add ');
                return redirect(ADMIN_URL.'/blog/create');
            }
       
     
    }
    function edit($Id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('blog','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $findData= DB::table('blogs')->where('id',$Id)->first();
        if(empty($findData))
        {
            Session::put('error', 'Blog Not found');
            return redirect(ADMIN_URL.'/blog');
        }
        else
        {
            $data = blog_mod::find($Id);    
            $data['blogData'] = $data;
            $blog_cat= DB::table('blog_cat')->where('status','1')->get();
            $team=DB::table('team')->where('status','1')->get();
            $data['blog_cat'] = $blog_cat; 
            $data['team'] = $team; 
            return view('admin.blog.edit',$data);
        }
    }
    function update(Request $request,$id)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('blog','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }

        $title= $request->input('title');
        $author= $request->input('author');
        $category= $request->input('category');
        $tags= $request->input('tags');
        $short_description=$request->input('short_description');
        
        
        $alternate_text=$request->input('alternate_text');
        $date=$request->input('date');
        $meta_description=$request->input('meta_description');
        $meta_keyword=$request->input('meta_keyword');
        $status=trim($request->input('status'));
        $arra1 = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');
        $arra2 = array('-','-','-','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
        $fialias=str_replace($arra1,$arra2,strtolower($title));
        $ValidateAlias = DB::table('blogs')->where('alias',$fialias)->where('id','!=',$id)->first();
        if(!empty($ValidateAlias))
        {
          $fialias=$fialias.'-'.rand();
        }
   
      $dataUpdate=array(
        'title'=>$title,
        'alias'=>$fialias,
        'author'=>$author,
        'catagory'=>$category,
        'tags'=>$tags,
        'description'=>$short_description,
        'text'=>$alternate_text,
        'meta_description'=>$meta_description,
        'meta_keyword'=>$meta_keyword,
        'status'=>$status,
        'date'=>$date?date('Y-m-d',strtotime($date)):date('Y-m-d'),
        );
        
        if($_FILES["image"]["name"] != ''){
            $fileName = $_FILES["image"]["name"];
            $extensionArray = explode(".",$fileName);
            $extension = $extensionArray[count($extensionArray)-1];
            $tmp_name = $_FILES["image"]["tmp_name"];
            $file_type = $_FILES["image"]["type"];
            $new_file_name=rand(0000,9999).time().'.'.$extension;
            $uploaddir_normal = ABSOLUTE_PATH."upload/blog/normal/";
          
            if(move_uploaded_file($tmp_name, $uploaddir_normal.$new_file_name))
            {
                $settData = blog_mod::find($id);
                 $pic = $settData['image'];
                 @unlink(ABSOLUTE_PATH."upload/blog/normal/".$pic);
                
                $dataUpdate['image'] = $new_file_name;
            }
        }
        $updateTeam = blog_mod::where('id', $id)->update($dataUpdate);
     
         if($updateTeam){
          
                Session::put('success', 'updated successfully');
                return redirect(ADMIN_URL.'/blog');
            }
            else{
                Session::put('error', 'Failed to update ');
                return redirect(ADMIN_URL.'/blog/'.$id.'/edit');
            }
        
     }
     function delete($conId)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('blog','delete');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        if($conId !='' && (!empty($conId)))
        {
            $Data=blog_mod::where('id',$conId)->delete();
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/blog');
        }
        else{
             return redirect(ADMIN_URL.'/blog');
        }
        
     }
     function doStatusChange($id)
     { 
        $checkUserAccess = $this->_myFun->validateUserAccess('blog','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $Data = blog_mod::find($id);
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
            $updateUser = blog_mod::where('id', $id)->update($dataUpdate);
            echo $updateStatus;
        }
     }

}
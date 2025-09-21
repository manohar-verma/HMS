<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\Models\admin\blog_cat_mod; // Fetch value from Aircraft Table
use App\library\my_functions; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use Auth;
use Config; 

class blog_cat extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
    }
    
    function index(Request $request)
    {
            $checkUserAccess = $this->_myFun->validateUserAccess('blog-cat','view');
            if($checkUserAccess == false)
            {
                Session::put('error',ACCESS_DENIED_ALERT);
                return redirect(ADMIN_URL.'/dashboard');
            }
            $search = $request->input('search');
            $page   = $request->input('page');
            
            $orderby = $request->input('orderby');
            $sortval = $request->input('sortval');
            $searchResults = blog_cat_mod::
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
        
         $orderByArray = array('id','name');
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
        
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('blog-cat','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('blog-cat','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('blog-cat','delete');
        return view('admin.blog_cat.list',$data);
    }
    function create()
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('blog-cat','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        return view('admin.blog_cat.add');
    }
    function store( Request $request)
    {
         $checkUserAccess = $this->_myFun->validateUserAccess('blog-cat','add-new');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $name= $request->input('name');
        $status=$request->input('status');
            $dataInsert=array(
                            'name'=>$name,
                            'status'=>$status,
                            );
    
            $isInserted=blog_cat_mod::insert($dataInsert);
            if($isInserted)
            {
                Session::put('success', 'inserted successfully');
                return redirect(ADMIN_URL.'/blog-cat');
            }
            else{
                Session::put('error', 'Failed to add ');
                return redirect(ADMIN_URL.'/blog-cat/create');
            }
       
     
    }
    function edit($Id)
    {
         $checkUserAccess = $this->_myFun->validateUserAccess('blog-cat','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $findData= DB::table('blog_cat')->where('id',$Id)->first();
        if(empty($findData))
        {
            Session::put('error', 'Blog Not found');
            return redirect(ADMIN_URL.'/blog-cat');
        }
        else
        {
            $data = blog_cat_mod::find($Id);    
            $data['blogCat'] = $data;
            return view('admin.blog_cat.edit',$data);
        }
    }
    function update(Request $request,$id)
    {
         $checkUserAccess = $this->_myFun->validateUserAccess('blog-cat','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }

        $name= $request->input('name');
        $status=$request->input('status');
        $dataUpdate=array(
            'name'=>$name,
            'status'=>$status,
            );
        
        $updateTeam = blog_cat_mod::where('id', $id)->update($dataUpdate);
     
         if($updateTeam){
          
                Session::put('success', 'updated successfully');
                return redirect(ADMIN_URL.'/blog-cat');
            }
            else{
                Session::put('error', 'Failed to update ');
                return redirect(ADMIN_URL.'/blog-cat/'.$id.'/edit');
            }
        
     }
     function delete($conId)
     {
         $checkUserAccess = $this->_myFun->validateUserAccess('blog-cat','delete');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        if($conId !='' && (!empty($conId)))
        {
            $Data=blog_cat_mod::where('id',$conId)->delete();
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/blog-cat');
        }
        else{
             return redirect(ADMIN_URL.'/blog-cat');
        }
        
     }
     function doStatusChange($id)
     { 
         $checkUserAccess = $this->_myFun->validateUserAccess('blog-cat','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $Data = blog_cat_mod::find($id);
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
            $updateUser = blog_cat_mod::where('id', $id)->update($dataUpdate);
            echo $updateStatus;
        }
     }

}
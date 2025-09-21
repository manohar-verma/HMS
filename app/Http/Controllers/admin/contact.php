<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\Models\admin\contact_mod; // Fetch value from Aircraft Table
use App\library\my_functions; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use App\Models\User;
use Auth;
use Config; 

class contact extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
    }
    
    function index(Request $request)
    {
            $checkUserAccess = $this->_myFun->validateUserAccess('contact','view');
            if($checkUserAccess == false)
            {
                Session::put('error',ACCESS_DENIED_ALERT);
                return redirect(ADMIN_URL.'/dashboard');
            }  
            $search = $request->input('search');
            $page   = $request->input('page');
            
            $orderby = $request->input('orderby');
            $sortval = $request->input('sortval');
            $searchResults = Contact_mod::
            where(function($query) use ($search) {
                if($search != ''){
                    $query->where('name','LIKE', '%'.$search.'%')
                    ->orWhere('email','LIKE', '%'.$search.'%');
                  
                }
            });
           $PerPage = ADMIN_PER_PAGE;
           $currentPage = $page? $page : 1;
           if((!is_numeric($currentPage)) || ($currentPage < 1) ){
                $currentPage = 1;
            }
            $startpoint = (floor($currentPage) * $PerPage) - $PerPage;
        
         $orderByArray = array('id','conatct');
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
        
        
        return view('admin.contact.list',$data);
    }
    function multi_delete(Request $request)
    {
        $checkUserAccess = $this->_myFun->validateUserAccess('contact','delete');
            if($checkUserAccess == false)
            {
                Session::put('error',ACCESS_DENIED_ALERT);
                return redirect(ADMIN_URL.'/dashboard');
            }  
        $ids = $request->input('multi_delete');

        if(!empty($ids))
        {
            $UserData=Contact_mod::whereIn('id',$ids)->update(['is_deleted'=>'1']);
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/contact');
        }
        else{
            Session::put('error', 'Failed to delete someting went wrong');
             return redirect(ADMIN_URL.'/contact');
        }
    }
     function doDeletecontact($conId)
     {
        $checkUserAccess = $this->_myFun->validateUserAccess('contact','delete');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }  
        $UserData=Contact_mod::find($conId);
        if($conId !='' && (!empty($conId)))
        {
            $NewsletterData = Contact_mod::find($conId);
            $UserData=Contact_mod::where('id',$conId)->update(['is_deleted'=>'1']);
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/contact');
        }
        else{
             return redirect(ADMIN_URL.'/contact');
        }
        
     }
   
 

}
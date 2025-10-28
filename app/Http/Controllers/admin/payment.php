<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag; 
use App\library\get_site_details; // Get custom function
use App\library\my_functions;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use View;
use Validator;
use Input;
use App\Models\User;
use Auth;
use Cookie;
use Config;
use Mail;

class payment extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
         $this->_myFun = new My_functions;
         $this->_myFunUserRole = new get_site_details;
    }
    
    function index(Request $request)
    {
        $user = auth()->guard('admin')->user();
        $userAccess = $this->_myFunUserRole->getUserAccess($user->id);
        $accessRole=(explode(",",$userAccess));
        if(!in_array("payments-list", $accessRole))
        {
             Session::put('error', 'Access denied to this page');
            return redirect(ADMIN_URL.'/dashboard');
        } 
        $data['accessAddNew'] = $this->_myFun->validateUserAccess('payments-list','add-new');
        $data['accessUpdate'] = $this->_myFun->validateUserAccess('payments-list','update');
        $data['accessDelete'] = $this->_myFun->validateUserAccess('payments-list','delete');
        
        $searchTerm = $request->input('searchTerm');
        $page   = $request->input('page');
        $orderby = $request->input('orderby');
        $sortval = $request->input('sortval');
        $searchResults = DB::table('payments')
        ->select('payments.*');
       
            if($searchTerm != ''){
                $searchResults->where('booking_id','LIKE', '%'.$searchTerm.'%')
                 ->orWhere('payment_ref', 'LIKE', '%' . $searchTerm . '%');
            }
           
           $PerPage = ADMIN_PER_PAGE;
           $currentPage = $page? $page : 1;
           if((!is_numeric($currentPage)) || ($currentPage < 1) ){
                $currentPage = 1;
            }
            $startpoint = (floor($currentPage) * $PerPage) - $PerPage;
        
         $orderByArray = array('payment_id','paid_at','status');
         $orderTypeArray = array('ASC','DESC');
          
        $orderBy = 'payment_id';
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
        return view('admin.payment.index',$data);
    }
  
    function invoices(Request $request){
        $user = auth()->guard('admin')->user();
        $userAccess = $this->_myFunUserRole->getUserAccess($user->id);
        $accessRole=(explode(",",$userAccess));
        if(!in_array("invoices", $accessRole))
        {
             Session::put('error', 'Access denied to this page');
            return redirect(ADMIN_URL.'/dashboard');
        } 
        return view('admin.payment.invoices');
    }
    function invoicesSearch(Request $request){
       $checkUserAccess = $this->_myFun->validateUserAccess('invoices','update');
        if($checkUserAccess == false)
        {
            Session::put('error',ACCESS_DENIED_ALERT);
            return redirect(ADMIN_URL.'/dashboard');
        }
        $invoice_search = $request->input('invoice_search');
         $searchResults = DB::table('payments');
       if($invoice_search != ''){
        $searchResults->where('booking_id',$invoice_search)->orWhere('payment_id',$invoice_search);
        }
        $resultData =  $searchResults->first();
        if(!empty($resultData)){
            return redirect(ADMIN_URL.'/invoices/'.$resultData->payment_id);
        }else{
            Session::put('error', 'Invoice not found !');
            return redirect(ADMIN_URL.'/invoices');
        }    
    }
    function printInvoice($paymentId){
       $data[''] ='';   
      return view('admin.payment.print',$data);
    }
    function settings(){
        $user = auth()->guard('admin')->user();
        $userAccess = $this->_myFunUserRole->getUserAccess($user->id);
        $accessRole=(explode(",",$userAccess));
        if(!in_array("gateway-settings", $accessRole))
        {
             Session::put('error', 'Access denied to this page');
            return redirect(ADMIN_URL.'/dashboard');
        } 
        return view('admin.payment.settings');
    }

}
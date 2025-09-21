<?php
namespace App\Http\Controllers\admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use App\Models\admin\testimonials_mod; // Fetch value from Aircraft Table
use App\library\my_functions; // Get custom function
use App\library\fn_image_resize; // Get custom function
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Hash;
use Auth;
use Config; 

class testimonial extends BaseController {
    
    protected $_myFun;
    
    function __construct(){
        $this->_myFun = new My_functions;
        $this->_myFunImage = new Fn_image_resize;
    }
    
    function index(Request $request)
    {
            $search = $request->input('search');
            $page   = $request->input('page');
            
            $orderby = $request->input('orderby');
            $sortval = $request->input('sortval');
            $searchResults = testimonials_mod::
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
        
        $totlaResult = $searchResults->get()->count();
        $searchResultsList = $searchResults->take($PerPage)->offset($startpoint)->orderBy($orderBy, $ordertype)->get();
        
        $data['list'] = $searchResultsList;
        $data['pagination'] = ($this->_myFun->myPaginationAjax($totlaResult,ADMIN_PER_PAGE,$currentPage,''));
        
        
        return view('admin.testimonial.list',$data);
    }
    function create()
    {
       
        return view('admin.testimonial.add');
    }
    function store( Request $request)
    {
        $title= $request->input('title');
        $description=$request->input('description');
        $alt_tag=$request->input('alt_tag');
        $client_name=$request->input('client_name');
        $status=$request->input('status');
       
        
           
            $dataInsert=array(
                            'title'=>$title,
                            'description'=>$description,
                            'alt_tag'=>$alt_tag,
                            'status'=>$status,
                            'client_name'=>$client_name,
                           
                            );
                if($_FILES["image"]["name"] != ''){
                    $fileName = $_FILES["image"]["name"];
                    $extensionArray = explode(".",$fileName);
                    $extension = $extensionArray[count($extensionArray)-1];
                    $tmp_name = $_FILES["image"]["tmp_name"];
                    $file_type = $_FILES["image"]["type"];
                    $new_file_name=rand(0000,9999).time().'.'.$extension;
                    $uploaddir_normal = ABSOLUTE_PATH."upload/testimonial/normal/";
                    $uploaddir_thumb = ABSOLUTE_PATH."upload/testimonial/thumb/";
                    $uploaddir_crop = ABSOLUTE_PATH."upload/testimonial/crop/";
                    $thumb_crop=ABSOLUTE_PATH."upload/testimonial/thumb_crop/";
                    if(move_uploaded_file($tmp_name, $uploaddir_normal.$new_file_name))
                    {
                        $this->_myFunImage->createThumb($uploaddir_normal.$new_file_name,$uploaddir_thumb.$new_file_name,$file_type,360,180,''); // for thumb image
                        $this->_myFunImage->createCrop($uploaddir_normal.$new_file_name,$uploaddir_crop.$new_file_name,$file_type,360,180); // for crop image
                        $this->_myFunImage->createThumb($uploaddir_normal.$new_file_name,$thumb_crop.$new_file_name,$file_type,'','',61); // for thumb_crop
                        $dataInsert['image'] = $new_file_name;
                    }
                    }
    
            $isInserted=testimonials_mod::insert($dataInsert);
            if($isInserted)
            {
                Session::put('success', 'inserted successfully');
                return redirect(ADMIN_URL.'/testimonials');
            }
            else{
                Session::put('error', 'Failed to add ');
                return redirect(ADMIN_URL.'/testimonials/create');
            }
       
     
    }
    function edit($Id)
    {
        $findData= DB::table('testimonial')->where('id',$Id)->first();
        if(empty($findData))
        {
            Session::put('error', 'testimonial Not found');
            return redirect(ADMIN_URL.'/testimonials');
        }
        else
        {
            $data = testimonials_mod::find($Id);    
            $data['testimonialData'] = $data;
            return view('admin.testimonial.edit',$data);
        }
    }
    function update(Request $request,$id)
    {

        $title= $request->input('title');
        $description=$request->input('description');
        $alt_tag=$request->input('alt_tag');
        $client_name=$request->input('client_name');
        $status=$request->input('status');
   
      $dataUpdate=array(
                    'title'=>$title,
                    'description'=>$description,
                    'alt_tag'=>$alt_tag,
                    'status'=>$status,
                    'client_name'=>$client_name,
                    
        );
        
        if($_FILES["image"]["name"] != ''){
            $fileName = $_FILES["image"]["name"];
            $extensionArray = explode(".",$fileName);
            $extension = $extensionArray[count($extensionArray)-1];
            $tmp_name = $_FILES["image"]["tmp_name"];
            $file_type = $_FILES["image"]["type"];
            $new_file_name=rand(0000,9999).time().'.'.$extension;
            $uploaddir_normal = ABSOLUTE_PATH."upload/testimonial/normal/";
            $uploaddir_thumb = ABSOLUTE_PATH."upload/testimonial/thumb/";
            $uploaddir_crop = ABSOLUTE_PATH."upload/testimonial/crop/";
            $thumb_crop=ABSOLUTE_PATH."upload/testimonial/thumb_crop/";
            if(move_uploaded_file($tmp_name, $uploaddir_normal.$new_file_name))
            {
                $this->_myFunImage->createThumb($uploaddir_normal.$new_file_name,$uploaddir_thumb.$new_file_name,$file_type,360,180,''); // for thumb image
                $this->_myFunImage->createCrop($uploaddir_normal.$new_file_name,$uploaddir_crop.$new_file_name,$file_type,360,180); // for crop image
                $this->_myFunImage->createThumb($uploaddir_normal.$new_file_name,$thumb_crop.$new_file_name,$file_type,'','',61); // for thumb_crop
                $settData = testimonials_mod::find($id);
                 $pic = $settData['image'];
                 @unlink(ABSOLUTE_PATH."upload/testimonial/normal/".$pic);
                 @unlink(ABSOLUTE_PATH."upload/testimonial/thumb/".$pic);
                 @unlink(ABSOLUTE_PATH."upload/testimonial/crop/".$pic);
                 @unlink(ABSOLUTE_PATH."upload/testimonial/thumb_crop/".$pic);
                $dataUpdate['image'] = $new_file_name;
            }
        }
        $updateTeam = testimonials_mod::where('id', $id)->update($dataUpdate);
     
         if($updateTeam){
          
                Session::put('success', 'updated successfully');
                return redirect(ADMIN_URL.'/testimonials');
            }
            else{
                Session::put('error', 'Failed to update ');
                return redirect(ADMIN_URL.'/testimonials/'.$id.'/edit');
            }
        
     }
     function delete($conId)
     {
        if($conId !='' && (!empty($conId)))
        {
            $Data=testimonials_mod::where('id',$conId)->delete();
            Session::put('success', 'Deleted successfully!!');
            return redirect(ADMIN_URL.'/testimonials');
        }
        else{
             return redirect(ADMIN_URL.'/testimonials');
        }
        
     }
     function dostatuschange($id)
     { 
        $Data = testimonials_mod::find($id);
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
            $updateUser = testimonials_mod::where('id', $id)->update($dataUpdate);
            echo $updateStatus;
        }
     }

}
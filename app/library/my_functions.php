<?php namespace App\library {
use DB;
class My_functions{

    public function myPagination($total=0,$per_page=10,$page=1,$url='?')
    {
    $total = $total;
    
    $adjacents = "2"; 
      
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $lastlabel = "Last &rsaquo;&rsaquo;";
      
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
      
    $prev = $page - 1;                          
    $next = $page + 1;
      
    $lastpage = ceil($total/$per_page);

    if($lastpage < 2){
        return '';
    }
    $lpm1 = $lastpage - 1; // //last page minus 1
      
    $pagination = "";
    if($lastpage > 1){   
        $pagination .= "<ul class='pagination'>";
        $pagination .= "<li class='page_info'><span>Page {$page} of {$lastpage}</span></li>";
              
            if ($page > 1) $pagination.= "<li><a href='{$url}/page/{$prev}' id='GoSearchPagi' page='{$prev}'>{$prevlabel}</a></li>";
              
        if ($lastpage < 7 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li><a class='current'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}/page/{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
            }
          
        } elseif($lastpage > 5 + ($adjacents * 2)){
              
            if($page < 1 + ($adjacents * 2)) {
                  
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}/page/{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>...</li>";
                $pagination.= "<li><a href='{$url}/page/{$lpm1}' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}/page/{$lastpage}' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";  
                      
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                  
                $pagination.= "<li><a href='{$url}' id='GoSearchPagi' page='1'>1</a></li>";
                $pagination.= "<li><a href='{$url}/page/2' id='GoSearchPagi' page='2'>2</a></li>";
                $pagination.= "<li class='dot'>...</li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}/page/{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>..</li>";
                $pagination.= "<li><a href='{$url}/page/{$lpm1}' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}/page/{$lastpage}' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";      
                  
            } else {
                  
                $pagination.= "<li><a href='{$url}' id='GoSearchPagi' page='1'>1</a></li>";
                $pagination.= "<li><a href='{$url}/page/2' id='GoSearchPagi' page='2'>2</a></li>";
                $pagination.= "<li class='dot'>..</li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}/page/{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
                }
            }
        }
          
            if ($page < $counter - 1) {
                $pagination.= "<li><a href='{$url}/page/{$next}' id='GoSearchPagi' page='{$next}'>{$nextlabel}</a></li>";
                $pagination.= "<li><a href='{$url}/page/{$lastpage}' id='GoSearchPagi' page='{$lastpage}'>{$lastlabel}</a></li>";
            }
          
        $pagination.= "</ul>";        
    }
      
    return $pagination;
    }


    public function myPaginationAjax($total=0,$per_page=10,$page=1,$url='?')
    {
    $total = $total;
    
    $adjacents = "2"; 
      
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $lastlabel = "Last &rsaquo;&rsaquo;";
      
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
      
    $prev = $page - 1;                          
    $next = $page + 1;
      
    $lastpage = ceil($total/$per_page);

    if($lastpage < 2){
        return '';
    }
    $lpm1 = $lastpage - 1; // //last page minus 1
      
    $pagination = "";
    if($lastpage > 1){   
        $pagination .= "<ul class='pagination'>";
        $pagination .= "<li class='page_info'><span>Page {$page} of {$lastpage}</span></li>";
              
            if ($page > 1) $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='{$prev}'>{$prevlabel}</a></li>";
              
        if ($lastpage < 7 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li><a class='current'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
            }
          
        } elseif($lastpage > 5 + ($adjacents * 2)){
              
            if($page < 1 + ($adjacents * 2)) {
                  
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>...</li>";
                $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";  
                      
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                  
                $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='1'>1</a></li>";
                $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='2'>2</a></li>";
                $pagination.= "<li class='dot'>...</li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>..</li>";
                $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";      
                  
            } else {
                  
                $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='1'>1</a></li>";
                $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='2'>2</a></li>";
                $pagination.= "<li class='dot'>..</li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
                }
            }
        }
          
            if ($page < $counter - 1) {
                $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='{$next}'>{$nextlabel}</a></li>";
                $pagination.= "<li><a href='javascript:void(0);' id='GoSearchPagi' page='{$lastpage}'>{$lastlabel}</a></li>";
            }
          
        $pagination.= "</ul>";        
    }
      
    return $pagination;
    }
    
    function active_sort($uriArray = array(), $keyvalue=''){
        $value = 'ui-icon-carat-2-n-s';
        if($keyvalue != ''){
            if((array_key_exists('orderby',$uriArray)) && ($uriArray['orderby'] == $keyvalue)){
                
                if((array_key_exists('sortval',$uriArray)) && (strtolower($uriArray['sortval']) == 'asc')){
                    $value = 'ui-icon-triangle-1-n';
                }
                if((array_key_exists('sortval',$uriArray)) && (strtolower($uriArray['sortval']) == 'desc')){
                    $value = 'ui-icon-triangle-1-s';
                }
            }
        }
        return $value;
    }
    
    function get_search_values($uriArray = array(), $keyName=''){
        $value = '';
        if($keyName != ''){
            if(array_key_exists($keyName,$uriArray)){
                $value = $uriArray[$keyName];
            }
        }
        return $value;
    }
    
    function randomPassword($len = 10) {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        
        return implode($pass);
    }
    function validateUserAccess($reportName,$accessLevel = '')
    {
        $user = auth()->guard('admin')->user();
        $accessData = '';
        $userData = DB::table('user_access')->where('user_id',$user->id)->first();
        if(!empty($userData)){
            $accessData = $userData->allowed_access;
         }
        $roles=(explode(",",$accessData));
        $accessPass = false;
        if($user->id==1){
         $accessPass = true;
          return $accessPass;
        }
        else
        {
            if(in_array($reportName, $roles))
            {
             if(!empty($accessLevel))
             {
                $validateAccessType = DB::table('reportaccesslevel')->where('user_id',$user->id)->where('report_name',$reportName)->where('access_type',$accessLevel)->first();
                if(!empty($validateAccessType))
                {
                    $accessPass = true;
                    return $accessPass;
                }
             }
             else
             {
                $accessPass = true;
                return $accessPass;
             }  
            }
        }
        return $accessPass;
    } 
           
}
}
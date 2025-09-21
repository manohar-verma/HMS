<?php namespace App\library {
use Session;
use DB;
use Hash;
use Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\library\my_functions;

use DateTime;
    class get_site_details {

         protected $_myFun;
      
         function __construct(){
            $this->_myFun = new My_functions;
         }
        public function get_site_data()
        {
                $siteData = DB::table('settings')->first();
                return $siteData;
        }
        function getUserAccess($user_id)
        {
          $userData = DB::table('user_access')->where('user_id',$user_id)->first();
          if(!empty($userData)){
              return $userData->allowed_access;
          }else{
              return '';
          }
        }
        public function loggedUserInfo()
        {
           $user = Auth::user();
           return $user;
        }
        public function getUserData($user_id)
        {
           $userData = DB::table('users')->where('id',$user_id)->first();
           return $userData;
        }
       public function getParentMenuData($id)
       {
         $menuData = DB::table('menu')->where('id',$id)->first();
         return $menuData;
       }
       public function opensslEncrypted($encString)
       {
         
         // Store a string into the variable which
         // need to be Encrypted
         $simple_string = $encString;
         
         // Store the cipher method
         $ciphering = "AES-128-CTR";
         
         // Use OpenSSl Encryption method
         $iv_length = openssl_cipher_iv_length($ciphering);
         $options = 0;
         
         // Non-NULL Initialization Vector for encryption
         $encryption_iv = '1205199191011198';
         
         // Store the encryption key
         $encryption_key = "Manohar@Xigma#esolz$78";
         
         // Use openssl_encrypt() function to encrypt the data
         $encryption = openssl_encrypt($simple_string, $ciphering,
                     $encryption_key, $options, $encryption_iv);
           
         return $encryption;
       }
       public function opensslDecryption($decString)
       {
         $newdecString = base64_decode($decString);
         $ciphering = "AES-128-CTR";
         
         // Use OpenSSl Encryption method
         $iv_length = openssl_cipher_iv_length($ciphering);
         $options = 0;
         // Non-NULL Initialization Vector for decryption
         $decryption_iv = '1205199191011198';
         
         // Store the decryption key
         $decryption_key = "Manohar@Xigma#esolz$78";
         
         // Use openssl_decrypt() function to decrypt the data
         $decryption=openssl_decrypt ($newdecString, $ciphering, 
               $decryption_key, $options, $decryption_iv);
  
         return $decryption;
       }
       public function getPageCategory($id)
       {
         $categoryData = DB::table('page_category')->where('id',$id)->first();
         return $categoryData;
       }
       public function getNewType($id)
       {
         $categoryData = DB::table('news_type')->where('id',$id)->first();
         return $categoryData;
       }
      
       public function get_user_data($id)
       {
        $usersData = DB::table('users')->where('id',$id)->first();
        return $usersData;
       }
       function get_site_page_data($id){
        $cmsData = DB::table('cms')->where('page_category',$id)->where('is_deleted','0')->where('status','1')->first();
        return $cmsData;
       }
       function getBlogCat($id){
        $typeData = DB::table('blog_cat')->where('id',$id)->first();
        return $typeData;
       }
       function getAuthor($id){
        $authData = DB::table('team')->where('id',$id)->first();
        return $authData;
       }
       function getServiceInfo($id){
        $servicesData = DB::table('services')->where('id',$id)->first();
        return $servicesData;
       }
       function getPlanInfo($id){
        $planData = DB::table('pricing_plans')->where('id',$id)->first();
        return $planData;
       }
      function convert12($str)
      {
            // Get Hours
            $h1 = $str[0] - '0';
            $h2 = $str[1] - '0';

            $hh = $h1 * 10 + $h2;

            // Finding out the Meridien 
            // of time ie. AM or PM
            $Meridien;
            if ($hh < 12) 
            {
                $Meridien = "AM";
            }
            else
                $Meridien = "PM";

            $hh %= 12;

            // Handle 00 and 12 
            // case separately
            if ($hh == 0) 
            {
                echo "12";

                // Printing minutes and seconds
                for ($i = 2; $i < 8; ++$i)
                {
                    echo $str[$i];
                }
            }
            else
            {
                echo $hh;
                
                // Printing minutes and seconds
                for ($i = 2; $i < 8; ++$i) 
                {
                    echo $str[$i];
                }
            }

            // After time is printed
            // cout Meridien
            echo " " , $Meridien;
      }
  }
}
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
       
       public function get_user_data($id)
       {
        $usersData = DB::table('users')->where('id',$id)->first();
        return $usersData;
       }
       function getRoomInfo($booking_id){
          $roomBookingData = DB::table('booking_rooms')->where('booking_id',$booking_id)->first();
          if(!empty($roomBookingData)){
             $roomData = DB::table('rooms')->where('room_id',$roomBookingData->room_id)->first();
             if(!empty($roomData)){
                 $roomTypeData = DB::table('room_type')->where('type_id',$roomData->room_type_id)->first();
                return !empty($roomTypeData)?$roomTypeData:[];
             }else{ 
              return [];
             }
          }else{
            return [];
          }
       }
       function getPaymentInfo($booking_id){
          $paymentData = DB::table('payments')->where('booking_id',$booking_id)->first();
          return !empty($paymentData)?$paymentData:[];
       }
       function getRoomType($id){
          $roomTypeData = DB::table('room_type')->where('type_id',$id)->first();
          return !empty($roomTypeData)?$roomTypeData:[];
       }
  }
}
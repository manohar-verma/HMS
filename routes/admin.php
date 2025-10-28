
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\access;
use App\Http\Controllers\admin\settings;
use App\Http\Controllers\admin\changePassword;
use App\Http\Controllers\admin\subAdmin;
use App\Http\Controllers\admin\users;
use App\Http\Controllers\admin\booking;
use App\Http\Controllers\admin\payment;
use App\Http\Controllers\admin\report;
use App\Http\Controllers\admin\notifications;
use App\Http\Controllers\admin\logs;
use App\Http\Controllers\admin\hotel;
use App\Http\Controllers\admin\room_controller;
use App\Http\Controllers\admin\room_type;
use App\Http\Controllers\admin\amenities;



Route::get('/', [access::class,'index']);
Route::get('/auth', [access::class,'index']);
Route::post('/do-auth',[access::class,'doAuth']);
Route::middleware('AdminAuthentication')->group( function () {

    Route::get('/dashboard', [access::class,'dashboard']);
    Route::get('/logout', [access::class,'logout']);

    Route::get('/hotel-profile', [settings::class,'index']);
    Route::post('/setting/doAdd', [settings::class,'save_setting']);
    Route::get('/domain-and-brand', [settings::class,'domainAndBrand']);
    Route::get('/business-info', [settings::class,'businessInfo']);
    Route::get('/security-setting', [settings::class,'securitySetting']);

    Route::get('/change-password', [changePassword::class,'index']);
    Route::post('/password/do-update', [changePassword::class,'savePassword']);

    Route::resource('/sub-admin',subAdmin::class);
    Route::get('/sub-admin/delete/{id}', [subAdmin::class,'doDelete']);
    Route::post('/sub-admin/changeStatus/{id}', [subAdmin::class,'doStatusChange']);

    Route::resource('/guest',users::class);
    Route::get('/users/delete/{id}', [users::class,'delete']);
    Route::post('users/changeStatus/{id}',[users::class,'dostatuschange']);

    Route::get('/all-booking', [booking::class,'index']);
    Route::get('/new-booking', [booking::class,'newBooking']);
    Route::get('/calendar-view', [booking::class,'calendarView']);
    Route::post('/available-rooms', [booking::class,'checkAvailableRooms']);
    Route::post('/booking/new', [booking::class,'bookingSubmit']);
    Route::get('/all-booking/{id}', [booking::class,'editBooking']);

    
    Route::get('/availability', [room::class,'availability']);
    Route::get('/rate-plans', [room::class,'ratePlans']);


    Route::get('/payments-list', [payment::class,'index']);
    Route::get('/invoices', [payment::class,'invoices']);
    Route::get('/gateway-settings', [payment::class,'settings']);
    Route::post('/invoicesSearch', [payment::class,'invoicesSearch']);
    Route::get('/invoices/{payment_id}', [payment::class,'printInvoice']);

    Route::get('/occupancy', [report::class,'index']);
    Route::get('/revenue', [report::class,'revenue']);
    Route::get('/cancellation', [report::class,'cancellation']);
    Route::get('/booking-sources', [report::class,'bookingSources']);

    Route::get('/email-templates', [notifications::class,'index']);
    Route::get('/sms-templates', [notifications::class,'smsTemp']);
    Route::get('/push', [notifications::class,'pushNotif']);

    Route::get('/logs', [logs::class,'index']);

    Route::resource('/hotel',hotel::class);
    Route::get('/hotel-delete/{id}', [hotel::class,'delete']);
    Route::post('/hotel-status-change/{id}', [hotel::class,'doStatusChange']);

    Route::resource('/room',room_controller::class)->except('show');
    Route::get('/room/delete/{id}', [room_controller::class,'delete']);
    Route::post('/room/changeStatus/{id}', [hotel::class,'doStatusChange']);

    Route::resource('/room-type',room_type::class)->except('show');
    Route::get('/room-type/delete/{id}', [room_type::class,'delete']);
    Route::POST('/room-type/changeStatus/{id}', [room_type::class,'doStatusChange']);

    Route::resource('/amenities',amenities::class)->except('show');
    Route::get('/amenities/delete/{id}', [amenities::class,'delete']);
    Route::POST('/amenities/changeStatus/{id}', [amenities::class,'doStatusChange']);

});
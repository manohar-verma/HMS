
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\access;
use App\Http\Controllers\admin\settings;
use App\Http\Controllers\admin\changePassword;
use App\Http\Controllers\admin\subAdmin;
use App\Http\Controllers\admin\users;
use App\Http\Controllers\admin\booking;
use App\Http\Controllers\admin\room;
use App\Http\Controllers\admin\payment;
use App\Http\Controllers\admin\report;
use App\Http\Controllers\admin\notifications;
use App\Http\Controllers\admin\logs;

Route::get('/', [access::class,'index']);
Route::get('/auth', [access::class,'index']);
Route::post('/do-auth',[access::class,'doAuth']);
Route::middleware('AdminAuthentication')->group( function () {

    Route::get('/dashboard', [access::class,'dashboard']);
    Route::get('/logout', [access::class,'logout']);

    Route::get('/setting/hotel-profile', [settings::class,'index']);
    Route::post('/setting/doAdd', [settings::class,'save_setting']);
    Route::get('/setting/domain-and-brand', [settings::class,'domainAndBrand']);
    Route::get('/setting/business-info', [settings::class,'businessInfo']);
    Route::get('/setting/security-setting', [settings::class,'securitySetting']);

    Route::get('/change-password', [changePassword::class,'index']);
    Route::post('/password/do-update', [changePassword::class,'savePassword']);

    Route::resource('/users/sub-admin',subAdmin::class);
    Route::get('/sub-admin/delete/{id}', [subAdmin::class,'doDelete']);
    Route::post('/sub-admin/changeStatus/{id}', [subAdmin::class,'doStatusChange']);

    Route::resource('/users/guest',users::class);
    Route::get('/users/delete/{id}', [users::class,'delete']);
    Route::post('users/changeStatus/{id}',[users::class,'dostatuschange']);

    Route::get('/booking/all-booking', [booking::class,'index']);
    Route::get('/booking/new-booking', [booking::class,'newBooking']);
    Route::get('/booking/calendar-view', [booking::class,'calendarView']);
    Route::post('/booking/available-rooms', [booking::class,'checkAvailableRooms']);
    Route::post('/booking/new', [booking::class,'bookingSubmit']);

    Route::get('/room/room-types', [room::class,'index']);
    Route::get('/room/room-inventory', [room::class,'inventory']);
    Route::get('/room/availability', [room::class,'availability']);
    Route::get('/room/rate-plans', [room::class,'ratePlans']);

    Route::get('/payment/payments-list', [payment::class,'index']);
    Route::get('/payment/invoices', [payment::class,'invoices']);
    Route::get('/payment/gateway-settings', [payment::class,'settings']);

    Route::get('/report/occupancy', [report::class,'index']);
    Route::get('/report/revenue', [report::class,'revenue']);
    Route::get('/report/cancellation', [report::class,'cancellation']);
    Route::get('/report/booking-sources', [report::class,'bookingSources']);

    Route::get('/notifications/email-templates', [notifications::class,'index']);
    Route::get('/notifications/sms-templates', [notifications::class,'smsTemp']);
    Route::get('/notifications/push', [notifications::class,'pushNotif']);

    Route::get('/logs', [logs::class,'index']);

});
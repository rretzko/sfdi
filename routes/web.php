<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/** turned OFF verify 25-Jan-21 as it was causing too many confusion problems on re-logging in */
Auth::routes(['verify' => false]);

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

/** CUSTOM LOGIN CONTROLLERS */
Route::post('sfdi/login', 'SfdiAuths\LoginController@update')->name('sfdi.login.update');
Route::post('sfdi/logout', 'SfdiAuths\LoginController@destroy')->name('sfdi.login.destroy');
Route::get('sfdi/password_request', 'SfdiAuths\PasswordController@create')->name('sfdi.password_request.create');
Route::post('sfdi/password_request/update', 'SfdiAuths\PasswordController@update')->name('sfdi.password_request.update');
Route::get('sfdi/resetPassword/{token}', 'SfdiAuths\PasswordResetController@store')->name('sfdi.resetPassword');

/** STUDENT REGISTRATION */
Route::post('sfdi/register', 'SfdiAuths\RegisterController@store')->name('sfdi.register');

/** DUPLICATE STUDENT */
Route::get('duplicate/student', 'SfdiAuths\DuplicatestudentController@show')->name('sfdi.duplicatestudent');
Route::get('current/student/{user_id}','SfdiAuths\DuplicatestudentController@edit')->name('sfdi.currentStudent');
Route::get('current/student/reset','SfdiAuths\DuplicatestudentController@index')->name('sfdi.currentStudentReset');

/** Guest Pitch Files */
//Guest can access pitch files
Route::get('/guest/pitchfiles/', function() {
    return view('pitchfiles');
})->name('guest.pitch_files');

/** SPROUT VIDEO CONFIRMATIONS */
////https://thedirectorsroom.com/fileserver/confirmation/651234/99/98/97
Route::get('fileserver/confirmation/{registrant}/{filecontenttype}/{person}/{folder_id}', 'Fileservers\FileserverController@store');

Route::get('/registrant/approve/{registrant}/{filecontenttype}', [FileapprovalController::class,'approve'])->name('fileupload.approve');
Route::get('/registrant/reject/{registrant}/{filecontenttype}', [FileapprovalController::class,'reject'])->name('fileupload.reject');


/** EMAIL VERIFICATION */
Route::get('pending_verification', function(){

    return view('pages.pending_verification');

})->name('pending_verification');

/** PAYPAL LINKS */
Route::post('paypal/pppayment', 'Paypals\PaymentReturnController');
Route::post('paypal/ppipn', 'Paypals\PaypalIpnController');
//Route::post('webhook/paypal/ipn', '')->name('webhook.paypal.ipn');

/** Electronic Application */
Route::get('eApplication', 'EapplicationController@index')->name('eapplication');
Route::get('eApplication/edit/{registrant}', 'EapplicationController@edit')->name('eapplication.edit');
Route::post('eApplication/show/{student}', 'EapplicationController@show')->name('eapplication.show');
Route::post('eApplication/update/{registrant}', 'EapplicationController@update')->name('eapplication.update');

/** API LINK FROM SproutVideo */
Route::get('/videoserver/confirmation/{registrant}/{videotype}/{user}', 'Videos\VideoController@apiconfirmation')->name('video.confirmation');

/** SIGNED ROUTES */
Route::get('accepted/{student}/{teacher}', 'Signeds\StudentacceptedController')->name('studentaccepted');
Route::get('rejected/{student}/{teacher}', 'Signeds\StudentrejectedController')->name('studentrejected');

/** UTILITIES */
Route::get('verifyEmailApi/{token}', 'EmailVerificationController@update');
Route::post('resetRequest', 'PasswordResetRequestController@store')->name('resetRequest');
//Route::get('resetPassword/{token}', 'PasswordResetController@store')->name('resetPassword');
Route::post('confirm', 'ConfirmPasswordController@store')->name('confirm');
Route::get('usernameRequest', function(){
    return view('pages.username.username_request');
})->name('usernameRequest.edit');
Route::post('usernameRequest/update', 'UsernameRequestController@update')->name('usernameRequest.update');

/** EMAIL VERIFICATION */
Route::get('user/verify/{token}', 'Auth\RegisterController@verifyUser');
Route::get('verifyEmail/{email}','VerifyEmailController@update')->name('verifyEmail');
Route::get('email/verify/{token}', 'EmailVerificationController@update');

/** EVENTS */
Route::get('event', 'EventController@index')->name('event');
Route::get('events', 'EventsController@index')->name('events');

/** MESSAGES */
Route::get('log', 'MissiveController@index')->name('log');
Route::get('missive/{missive}', 'MissiveController@show')->name('missive');

/** PARENTGUARDIANS */
Route::get('parent', 'ParentguardianController@index')->name('parent');
Route::get('parent/add', 'ParentguardianController@create')->name('addParent');
Route::get('parent/edit/{parentguardian}', 'ParentguardianController@edit')->name('editParent');
//Route::get('parent/{id}', 'ParentguardianController@show')->name('showParent');
Route::post('parent/store', 'ParentguardianController@store')->name('storeParent');
Route::post('parent/update/{parentguardian}', 'ParentguardianController@update')->name('updateParent');

Route::get('parents', 'ParentguardiansController@index')->name('parents');

/** PDFS */
Route::get('/pdf/application/{registrant}','Pdfs\ApplicationController')->name('pdf.application');
Route::get('/pdf/eapplication/{registrant}','Pdfs\EapplicationController')->name('pdf.eapplication');
Route::post('/registrant/{registrant}/eapplication','Registrants\RegistrantApplicationController@update')->name('registrant.eapplication');

/** PROFILE */
Route::get('profile', 'ProfileController@index')->name('profile');
Route::post('profile/update', 'ProfileController@update')->name('profile.update');

/** REGISTRANTS */
Route::get('registrant/profile/{eventversion}', 'Registrants\RegistrantController@edit')->name('registrant.profile.edit');
Route::get('registrant/profile/{eventversion}/{registrant}/inperson', 'Registrants\InpersonauditionController@update')->name('registrant.profile.store.inperson');
Route::get('registrant/pitchfiles/{eventversion}', 'Registrants\PitchfilesController@index')->name('pitchfiles');
//Route::get('registrant/profile/{registrant}', 'Registrants\RegistrantController@show')->name('registrant.profile.edit');
//Route::get('registrant/profile/edit/{registrant}', 'Registrants\ProfileController@edit')->name('registrant.profile.show');
Route::post('registrant/update/{registrant}', 'Registrants\RegistrantController@update')->name('registrant.update');
Route::post('registrant/optional/update/{registrant}', 'Registrants\OptionalController@update')->name('registrant.optional.update');
Route::post('registrant/profile/update/{registrant}', 'Registrants\ProfileController@update')->name('registrant.profile.update');

/** SCHOOLS */
Route::get('schools', 'SchoolsController@index')->name('schools');
Route::get('school', 'SchoolController@index')->name('school');
Route::get('school/add', 'SchoolController@create')->name('addSchool');
Route::post('school/store', 'SchoolController@store')->name('storeSchool');

/** AJAX */
Route::post('DuplicateStudentRegistrationCheck', 'DuplicateStudentRegistrationCheckController@index')->name('DuplicateStudentRegistrationCheck');
Route::post('Notifications', 'NotificationsController@index')->name('Notifications');
Route::post('TeachersFromSchool', 'TeachersFromSchoolController@index')->name('TeachersFromSchool');
Route::post('AjaxVideoRemoval', 'AjaxController@videoRemoval');
Route::post('AjaxLogStudentPayment', 'AjaxController@logStudentPayment');


Route::get('credentials', 'HomeController@credentials',['as' => 'HomeCredentials'])->name('credentials');
Route::get('home', 'HomeController@index');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('student_Destroy_Parent/{id}', 'StudentAddParentController@destroy');

Route::get('updateParent/{id}', 'ParentguardianController@index');
Route::get('version/{id}', 'VersionController@index');

Route::patch('credentials/{id}', 'CredentialsController@update');

Route::post('/student/ajaxupdate', 'AjaxController@updateOptionsTeachers');
Route::post('addParentForm', 'StudentAddParentController@index');
 Route::post('student_Add_School', 'StudentAddSchoolController@store');
Route::post('student_Add_Parent', 'StudentAddParentController@store');
Route::post('student_Update_Parent', 'StudentAddParentController@update');
Route::post('version', 'VersionController@store');

Route::resource('persons', 'PersonsController');
Route::resource('students', 'StudentsController');

/** ADMIN */
Route::get('/admin', 'Admins\AdminController@index')->name('admin');
Route::post('/impersonate', 'Admins\AdminController@show')->name('impersonate.login');

//Route::get('addSchoolForm', 'StudentAddSchoolController@index')->name('addSchool');
//Route::get('student', 'HomeController@student');
//Route::get('student_Add_School', 'StudentAddSchoolController@index');
//Route::get('school', 'HomeController@school',['as' => 'school'])->name('school');
//Route::post('addSchoolForm', 'StudentAddSchoolController@index');
//Route::get('addParentForm', 'StudentAddParentController@index')->name('addParent');



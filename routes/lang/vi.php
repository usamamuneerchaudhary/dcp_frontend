<?php
/** Copyright (c) 2018-2019 Qualcomm Technologies, Inc.
All rights reserved.
Redistribution and use in source and binary forms, with or without modification, are permitted (subject to the limitations in the disclaimer below) provided that the following conditions are met:
Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
Neither the name of Qualcomm Technologies, Inc. nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
The origin of this software must not be misrepresented; you must not claim that you wrote the original software. If you use this software in a product, an acknowledgment is required by displaying the trademark/log as per the details provided here: https://www.qualcomm.com/documents/dirbs-logo-and-brand-guidelines
Altered source versions must be plainly marked as such, and must not be misrepresented as being the original software.
This notice may not be removed or altered from any source distribution.
NO EXPRESS OR IMPLIED LICENSES TO ANY PARTY'S PATENT RIGHTS ARE GRANTED BY THIS LICENSE. THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.*/
Route::prefix( 'vi' )->group( function () {

	Route::get( 'logout', function () {
		\Session::forget( 'user' );
		\Session::forget( 'token' );
		\Session::flush();

		return view( 'auth.login' );
	} )->middleware( 'revalidate' );
	Route::get( '/', 'Auth\LoginController@index' )->name( 'login' );
	Route::post( '/', 'Auth\LoginController@login' );
	Route::get( 'login', function () {

		if ( ! \Session::has( 'token' ) ) {
			return view( 'auth.login' );
		}

		return redirect( '/' );
	} );

//Register Routes
	Route::get( 'register', 'Auth\RegisterController@showRegistrationForm' )->name( 'register' );
	Route::post( 'register', 'Auth\RegisterController@register' );


	Route::post( 'logout', 'Auth\LoginController@logout' )->name( 'logout' );

	Route::get( 'password/recover', 'Auth\ForgotPasswordController@showLinkRequestForm' )->name( 'password/recover' );
	Route::post( 'password/recover', 'Auth\ForgotPasswordController@recover' );
//Route::post('password/email', 'Auth\AuthController@sendResetLinkEmail')->name('password.email');
	Route::get( 'password/reset/{token}', 'Auth\ResetPasswordController@showResetForm' )->name( 'password.reset' );
	Route::post( 'password/reset', 'Auth\ResetPasswordController@reset' )->name( 'password.reset.post' );


//license agreement routes

	Route::get( '/user-licenses/{id}', 'Auth\LicenseController@getUserLicenses' );


	Route::get( 'user-license/{user}', 'Auth\LicenseController@showUserLicense' )->name( 'user-license' );
	Route::get( 'update-user-license/{id}', 'Auth\LicenseController@updateUserLicense' )->name( 'update.user.license' );

	Route::put( 'update-user-app-license/{id}', 'Auth\LicenseController@updateUserAppLicense' )->name( 'update-user-app-license' );



//auth routes

//admin routes
//	Route::group( [ 'middleware' => 'admin' ], function () {
		/** Feedback Index */

		Route::get( 'admin/system-feedbacks', 'Admin\FeedbackController@index' )->name( 'admin/system-feedbacks' );
		Route::get( 'admin/reports', 'Admin\ReportsController@index' )->name( 'admin/reports' );
		Route::get( 'admin', 'Admin\AdminController@index' )->name( 'admin' );

//	Route::get('admin/{user}/tasks/{task}/', 'UserController@getTasks')->name('users-task');
		Route::resource( 'admin/users', 'Admin\UserController', [
			'names' => [
				'index'  => 'admin/users',
				'create' => 'admin/users/create',
				'edit'   => 'admin/users'
			]
		] );
//Route::resource('admin/imei', 'Admin\IMEIController');
		Route::get( 'admin/profile', 'Admin\ProfileController@index' )->name( 'admin/profile' );
		Route::get( 'admin/profile/{id}/edit', 'Admin\ProfileController@getProfile' )->name( 'admin/profile/edit' );
		Route::put( 'admin/profile/{id}/edit', 'Admin\ProfileController@editProfile' )->name( 'admin.profile' );
		Route::get( 'admin/profile/{id}/password', 'Admin\ProfileController@getPassword' )->name( 'admin.profile.password' );
		Route::put( 'admin/profile/{id}/password', 'Admin\ProfileController@editPassword' );

		Route::get( 'admin/app-download', 'Admin\AdminController@appDownload' )->name( 'admin/app-download' );

		Route::get( 'admin/imei', 'Admin\IMEIController@index' )->name( 'admin/imei' );
		Route::post( 'admin/imei', 'Admin\IMEIController@imeiLookup' );

//	Route::get( 'admin/imei-bulk-lookup', 'Admin\BulkImeiController@bulkLookup' )->name( 'admin/imei-bulk-lookup' );
//	Route::post( 'admin/imei-bulk-lookup', 'Admin\BulkImeiController@showFileUpload' );

		Route::get( 'admin/counterfiet-devices/{id}', 'Admin\CounterfietDevicesController@view_image' )->name( 'admin/counterfiet-devices/' );

		Route::get( 'admin/users-activity', 'Admin\UsersActivity@index' )->name( 'admin/users-activity' );
		Route::get( 'admin/my-activity', 'Admin\UsersActivity@myActivity' )->name( 'admin/my-activity' );

		Route::get( 'admin/counterfiet-devices', 'Admin\CounterfietDevicesController@index' )->name( 'admin/counterfiet-devices' );

		Route::get( 'admin/matched-records', 'Admin\UsersActivity@matchedRecords' )->name( 'admin/matched-records' );
		Route::get( 'admin/not-matched-records', 'Admin\UsersActivity@notMatchedRecords' )->name( 'admin/not-matched-records' );

		Route::post( 'admin/report-imei', 'Admin\CounterfietDevicesController@report' );


		//Activate/Deactivate Staff Routes
		Route::get( 'activate-staff/{id}', 'Admin\AdminController@activateStaff' )->name( 'staff-activate' );
		Route::get( 'deactivate-staff/{id}', 'Admin\AdminController@deactivateStaff' )->name( 'staff-deactivate' );

		//Results_matched Routes
		Route::get( 'imei/lookup/matched/{imei}', [
			'as'   => 'imei-results.matched',
			'uses' => 'Common\IMEIController@ImeiResultsMatched'
		] );

		Route::get( 'admin/imei/{imei}', [
			'uses' => 'Admin\IMEIController@ImeiResultsNotMatched'
		] );
//	} );


//staff routes


	Route::group( [ 'prefix' => 'staff','middleware'=>'staff' ], function () {

		Route::get( '/', 'Staff\StaffController@index' )->name( 'staff' );

		Route::get( '/profile', 'Staff\ProfileController@index' )->name( 'staff/profile' );
		Route::get( '/profile/{id}/edit', 'Staff\ProfileController@getProfile' )->name( 'staff.profile.edit' );
		Route::put( '/profile/{id}/edit', 'Staff\ProfileController@editProfile' );

		Route::get( '/profile/{id}/password', 'Staff\ProfileController@getPassword' )->name( 'staff.profile.password' );
		Route::put( '/profile/{id}/password', 'Staff\ProfileController@editPassword' );

		Route::get( '/my-activity', 'Admin\UsersActivity@myActivity' )->name( 'staff/my-activity' );
		Route::get( '/app-download', 'Staff\StaffController@appDownload' )->name( 'staff/app-download' );

		Route::get( '/feedback', 'Staff\FeedbackController@index' )->name( 'staff/feedback' );
		Route::post( '/feedback', 'Staff\FeedbackController@postFeedback' )->name( 'staff.feedback' );

		Route::get( '/imei', 'Staff\IMEIController@index' )->name( 'staff/imei' );
		Route::post( '/imei', 'Staff\IMEIController@imeiLookup' );

		Route::get( '/imei/{imei}', [
			'uses' => 'Staff\IMEIController@ImeiResultsNotMatched'
		] );
	} );


	/**
	 * Super Admin Route Group
	 */

	Route::group( [ 'prefix' => 'super-admin','middleware'=>'superadmin' ], function () {
		Route::get( '/', 'SuperAdmin\SuperAdminController@index' )->name( 'super-admin' );

		Route::get( '/system-feedbacks', 'SuperAdmin\FeedbackController@index' )->name( 'super-admin/system-feedbacks' );


		Route::get( '/license-agreements', 'SuperAdmin\LicenseAgreementsController@index' )->name( 'super-admin/license-agreements' );

		Route::get( '/license-agreements/create', 'SuperAdmin\LicenseAgreementsController@create' )->name( 'super-admin/license-agreements/create' );
		Route::post( '/license-agreements', 'SuperAdmin\LicenseAgreementsController@store' )->name( 'license.store' );
		Route::get( '/license-agreement/{id}', 'SuperAdmin\LicenseAgreementsController@show' )->name( 'license.show' );


		Route::get( '/all-users', 'SuperAdmin\UserController@index' )->name('super-admin/all-users');
		Route::get( '/users/create', 'SuperAdmin\UserController@create' )->name( 'super-admin/users/create' );
		Route::post( '/all-users', 'SuperAdmin\UserController@store' );

		Route::get( '/users/{id}/edit', 'SuperAdmin\UserController@edit' );
		Route::put( '/users/{id}', 'SuperAdmin\UserController@update' );
		Route::get( '/profile', 'SuperAdmin\ProfileController@index' )->name( 'super-admin/profile' );
		Route::get( '/profile/{id}/edit', 'SuperAdmin\ProfileController@getProfile' )->name( 'superadmin.profile.edit' );
		Route::put( '/profile/{id}/edit', 'SuperAdmin\ProfileController@editProfile' );
		Route::get( '/profile/{id}/password', 'SuperAdmin\ProfileController@getPassword' )->name( 'superadmin.profile.password' );
		Route::put( '/profile/{id}/password', 'SuperAdmin\ProfileController@editPassword' );
		Route::get( '/app-download', 'Admin\AdminController@appDownload' )->name( 'super-admin/app-download' );

		Route::get( '/imei', 'SuperAdmin\IMEIController@index' )->name( 'super-admin/imei' );
		Route::post( '/imei', 'SuperAdmin\IMEIController@imeiLookup' );

		Route::get( '/counterfiet-devices/{id}', 'Admin\CounterfietDevicesController@view_image' )->name( 'super-admin/counterfiet-devices/' );

		Route::get( '/users-activity', 'Admin\UsersActivity@index' )->name( 'super-admin/users-activity' );

		Route::get( '/my-activity', 'Admin\UsersActivity@myActivity' )->name( 'super-admin/my-activity' );
		Route::get( '/counterfiet-devices', 'Admin\CounterfietDevicesController@index' )->name( 'super-admin/counterfiet-devices' );

		Route::get( '/matched-records', 'Admin\UsersActivity@matchedRecords' )->name( 'super-admin/matched-records' );

		Route::get( '/not-matched-records', 'Admin\UsersActivity@notMatchedRecords' )->name( 'super-admin/not-matched-records' );

		Route::get( '/imei/{imei}', [
			'uses' => 'SuperAdmin\IMEIController@ImeiResultsNotMatched'
		] );
	} );


} );
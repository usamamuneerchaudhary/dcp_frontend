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
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;

class ProfileController extends Controller {
	protected $response;
	protected $client;

	/**
	 * ProfileController constructor.
	 */
	public function __construct() {
		$this->client = new Client( [
			'base_uri'    => config( 'app.api_url' ),
			'http_errors' => false
		] );

	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function index() {


		$result = $this->client->get( "api/profile", [
			'headers' => [
				'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
				'x-localization' => App::getLocale()
			]
		] );
		if ( $result->getStatusCode() == '500' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->back();
		}

		$data = \GuzzleHttp\json_decode( $result->getBody() );

		if ( isset( $data->errors->root ) ) {
			return redirect()->route( 'login' );
		}

		if ( \Session::has( 'token' ) ) {
			$user  = $data->data->user;
			$roles = $data->data->roles;

			return view( 'superadmin.profile.index', compact( 'user', 'roles' ) );
		}

		return redirect()->to( 'logout' );

	}


	/**
	 * @param $id
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function getProfile( $id ) {

		$result = $this->client->get( "api/profile/" . $id . "/edit", [
			'headers' => [
				'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
				'x-localization' => App::getLocale()
			]
		] );
		if ( $result->getStatusCode() == '500' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );


			return redirect()->back();
		}
		$data = \GuzzleHttp\json_decode( $result->getBody() );

		if ( isset( $data->errors->root ) ) {
			return redirect()->route( 'login' );
		}

		if ( \Session::has( 'token' ) ) {
			$user  = $data->data->user;
			$roles = $data->data->roles;

			return view( 'superadmin.profile.edit', compact( 'user', 'roles' ) );
		}

		return redirect()->to( 'logout' );
	}


	/**
	 * @param $id
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function editProfile( $id ) {

		$result = $this->client->put( "api/profile/" . $id . "/edit", [
			'form_params' => [
				'first_name' => Input::get( 'first_name' ),
				'last_name'  => Input::get( 'last_name' ),
				'email'      => Input::get( 'email' )
			],
			'headers'     => [
				'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
				'content-type'   => 'application/x-www-form-urlencoded',
				'x-localization' => App::getLocale()
			]
		] );
		if ( $result->getStatusCode() == '500' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->back();
		}
		$data = \GuzzleHttp\json_decode( $result->getBody() );


		if ( isset( $data->errors ) ) {


			alert()->error( trans( 'messages.errors.form_has_Errors' ), trans( 'messages.errors.update_failed' ) )->persistent( trans( 'close' ) )->autoclose( false );

			return redirect()->back()->withErrors( $data->errors->root )->withInput();
		}
		alert()->success( trans( 'profile.profile_update.updated' ), trans( 'profile.profile_update.update_Success' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

		return redirect()->to( App::getLocale() . '/super-admin/profile' );

	}

	/**
	 * @param $id
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function getPassword( $id ) {


		$result = $this->client->get( "api/profile/" . $id . "/password", [
			'headers' => [
				'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
				'x-localization' => App::getLocale()
			]
		] );
		if ( $result->getStatusCode() == '500' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->back();
		}
		$data = \GuzzleHttp\json_decode( $result->getBody() );

		if ( isset( $data->errors->root ) ) {
			return redirect()->to( 'logout' );
		}

		if ( \Session::has( 'token' ) ) {
			$user  = $data->data->user;
			$roles = $data->data->roles;

			return view( 'superadmin.profile.password', compact( 'user', 'roles' ) );
		}

		return redirect()->to( 'logout' );
	}

	/**
	 * @param $id
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function editPassword( $id ) {

		$result = $this->client->put( "api/profile/" . $id . "/password", [
			'form_params' => [
				'old_password'          => Input::get( 'old_password' ),
				'password'              => Input::get( 'password' ),
				'password_confirmation' => Input::get( 'password_confirmation' )

			],
			'headers'     => [
				'authorization'  => 'Bearer ' . \Session::get( 'token' ),
				'content-type'   => 'application/x-www-form-urlencoded',
				'x-localization' => App::getLocale()
			]
		] );
		if ( $result->getStatusCode() == '500' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->back();
		}
		$data = \GuzzleHttp\json_decode( $result->getBody() );

		if ( isset( $data->errors ) ) {

			alert()->error( trans( 'messages.errors.form_has_Errors' ), trans( 'messages.errors.update_failed' ) )->persistent( trans( 'close' ) )->autoclose( false );

			return redirect()->back()->withErrors( $data->errors->root )->withInput();
		}

		alert()->success( trans( 'profile.profile_update.password_update' ), trans( 'profile.profile_update.password_update_success' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

		return redirect()->to( App::getLocale() . '/super-admin/profile' );

	}
}

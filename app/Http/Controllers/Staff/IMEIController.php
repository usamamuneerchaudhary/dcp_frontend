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
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;

class IMEIController extends Controller {

	protected $response;
	protected $client;

	/**
	 * IMEIController constructor.
	 */
	public function __construct() {
		$this->client = new Client( [
			'base_uri'    => config( 'app.api_url' ),
			'http_errors' => false
		] );

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$user = \Session::get( 'user' );

		if ( \Session::has( 'token' ) ) {
			return view( 'staff.imei.index', compact( 'user' ) );
		} else {
			return redirect()->route( 'login' );
		}
	}

	/**
	 * @return mixed
	 */
	public function getRealIpAddr() {
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) //to check ip passed from proxy
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = @$_SERVER['REMOTE_ADDR'];

		}

		return $ip;
	}

	/**
	 * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function imeiLookup() {


		$result = $this->client->post( "api/lookup/web/manual", [
			'form_params' => [
				'imei' => Input::get( 'inputImei' ),
				'ip'   => $this->getRealIpAddr()
			],
			'headers'     =>
				[
					'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
					'x-localization' => App::getLocale()
				]
		] );


		if ( $result->getStatusCode() == '500' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->back();
		}

		$data = \GuzzleHttp\json_decode( $result->getBody() );
		$user = \Session::get( 'user' );


		return $this->imeiValidation( $result, $data, $user );
	}

	/**
	 * @param $result
	 * @param $data
	 * @param $user
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	protected function imeiValidation( $result, $data, $user ) {


		if ( isset( $data->errors ) || $data->error === true ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->back();
		}


		if ( ! empty( $result ) && $data->success ) {

			$all_data = $data->data;


			if ( \Session::has( 'token' ) ) {


				return view( 'staff.imei.index', compact( 'user', 'all_data' ) );


			} else {
				return redirect()->to( 'logout' );
			}

		} elseif ( ! $data->success ) {
			if ( \Session::has( 'token' ) ) {
				$message = $data->message;

				return view( 'staff.imei.index', compact( 'user', 'message' ) );

			} else {
				return redirect()->to( 'logout' );

			}
		}
	}

	/**
	 * @param $imei
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function ImeiResultsMatched( $imei ) {


		$result = $this->client->put( "api/results-matched/" . $imei, [
			'headers' =>
				[
					'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
					'x-localization' => App::getLocale()
				]
		] );

		if ( $result->getStatusCode() == '500' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->back();
		}

		$data = \GuzzleHttp\json_decode( $result->getBody() );
		if ( isset( $data ) && $data->success === true ) {
			$user = \Session::get( 'user' );

			if ( isset( $user ) && \Session::has( 'token' ) ) {
				alert()->success( $data->message )->persistent( 'Ok' )->autoclose( false );

				return redirect()->back();
			}

		}


	}


	/**
	 * @param $notMatchedImei
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function ImeiResultsNotMatched( $notMatchedImei ) {
		if ( ! is_numeric( $notMatchedImei ) || strlen( $notMatchedImei ) < 14 || strlen( $notMatchedImei ) > 16 ) {
			abort( '404' );
		}


		$result = $this->client->put( "api/results-not-matched/" . $notMatchedImei, [
			'headers' =>
				[
					'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
					'x-localization' => App::getLocale()
				]
		] );
		if ( $result->getStatusCode() == '500' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->back();
		}

		$data = \GuzzleHttp\json_decode( $result->getBody() );

		if ( isset( $data ) && $data->success === false ) {
			$user = \Session::get( 'user' );

			//return view to modal
			if ( isset( $user ) && \Session::has( 'token' ) ) {

				return view( 'staff.imei.index', compact( 'user', 'notMatchedImei' ) );
			}

			return redirect()->to( App::getocale() . '/logout' );
		}


	}


}

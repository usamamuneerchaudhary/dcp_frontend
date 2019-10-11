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

class StaffController extends Controller {

	/**
	 * @var $response
	 */
	protected $response;
	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * StaffController constructor.
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
		$user   = \Session::get( 'user' );
		$result = $this->client->get( 'api/get-user-info/' . $user->id, [
			'headers' => [
				'Authorization' => "Bearer " . \Session::get( 'token' )
			]
		] );
		\Session::forget( 'user' );
		$data = \GuzzleHttp\json_decode( $result->getBody() );

		\Session::put( 'user', $data->user );

		$user = \Session::get( 'user' );
		if ( $user->agreement === 'Not Agreed' ) {
			return redirect()->back();
		}

		if ( \Session::has( 'token' ) ) {
			return view( 'staff.imei.index', compact( 'user' ) );
		} else {
			return redirect()->route( 'login' );
		}

	}


	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getProfile() {
		$user = \Session::get( 'user' );

		if ( \Session::has( 'token' ) ) {
			return view( 'staff.profile.index', compact( 'user' ) );
		} else {
			return redirect()->route( 'login' );
		}
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function imeiLookup() {
		$user = \Session::get( 'user' );

		if ( \Session::has( 'token' ) ) {
			return view( 'staff.imei.index', compact( 'user' ) );
		} else {
			return redirect()->route( 'login' );
		}
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function imeiBulkLookup() {
		$user = \Session::get( 'user' );

		if ( \Session::has( 'token' ) ) {
			return view( 'staff.index', compact( 'user' ) );
		} else {
			return redirect()->to( 'logout' );
		}
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function appDownload() {
		$user = \Session::get( 'user' );
		if ( isset( $user ) && \Session::has( 'token' ) ) {

			$result = $this->client->get( "api/get-user-license/" . $user->id, [
				'headers' => [
					'Authorization' => "Bearer " . \Session::get( 'token' )
				]
			] );
			if ( $result->getStatusCode() == '500' ) {
				alert()->error( 'Server not responding, Please contact your system administrator', 'Internal Server Error' )->persistent( 'Close' )->autoclose( false );

				return redirect()->back();
			}
			$data = \GuzzleHttp\json_decode( $result->getBody() );


			return view( 'app.download' )->with( [
				'user'    => $data->user,
				'license' => $data->license
			] );
		}
		if ( request()->is( 'en/*' ) ) {
			return redirect()->to( 'en/logout' );
		} elseif ( request()->is( 'vi/*' ) ) {
			return redirect()->to( 'vi/logout' );
		}


	}


}

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

namespace App\Http\Controllers\Auth;

use Alert;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RegisterController extends Controller {

	/**
	 * @var $response
	 */
	protected $response;


	protected $redirectTo = '/register';

	protected $client;

	public function __construct() {
		$this->client = new Client( [
			'base_uri'    => config( 'app.api_url' ),
			'http_errors' => false
		] );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showRegistrationForm() {
		return view( 'auth.register' );
	}

	/**
	 *
	 * @param Request $request
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function register( Request $request ) {

		$result = $this->client->post( "api/register", [
			'form_params' => [
				'first_name'            => $request->get( 'first_name' ),
				'last_name'             => $request->get( 'last_name' ),
				'email'                 => $request->get( 'email' ),
				'password'              => $request->get( 'password' ),
				'password_confirmation' => $request->get( 'password_confirmation' )
			],
			'headers'     => [
				'x-localization' => App::getLocale(),
				'Accept'         => 'application/json',
			]
		] );

		if ( $result->getStatusCode() === '500' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->back();
		}
		if ( $result->getStatusCode() === '403' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->back();
		}
		$data = \GuzzleHttp\json_decode( $result->getBody() );
		if ( isset( $data->errors ) ) {

			alert()->error( trans( 'auth.register_form.error' ), trans( 'auth.register_form.failed' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->route( 'register' )->withErrors( $data->errors )->withInput();
		}

		if ( isset( $data->data ) && ! empty( $result ) ) {

			if ( $data->registered->original->redirect == true ) {
				$user        = $data->data;
				$success_msg = $data->registered->original->success;
				alert()->success( trans( 'auth.register_form.email' ), trans( 'auth.register_form.success' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

				return redirect()->route( 'login' );
			}
		}
	}
}

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LicenseAgreementsController extends Controller {

	protected $client;

	/**
	 * LicenseAgreementsController constructor.
	 */
	public function __construct() {
		$this->client = new Client( [
			'base_uri'    => config( 'app.api_url' ),
			'http_errors' => false
		] );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {

		$user = \Session::get( 'user' );

		if ( isset( $user ) && $user->roles[0]->slug == 'superadmin' ) {
			return view( 'superadmin.license.index', compact( 'user' ) );
		} else {
			return redirect()->route( 'login' );
		}
	}


	public function create() {

		$user = \Session::get( 'user' );

		return view( 'superadmin.license.create', [
			'user' => $user
		] );


	}

	/**
	 * @param Request $request
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function store( Request $request ) {


		$version = $request->version;
		$content = $request->licenseAgreementContent;

		$dom = new \domdocument();
		$dom->loadHtml( $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );

		$images = $dom->getelementsbytagname( 'img' );

		if ( isset( $images ) ) {

			foreach ( $images as $k => $img ) {
				$data = $img->getattribute( 'src' );

				list( $type, $data ) = explode( ';', $data );
				list( , $data ) = explode( ',', $data );

				$data       = base64_decode( $data );
				$image_name = time() . $k . '.png';
				$path       = public_path() . '/' . $image_name;

				file_put_contents( $path, $data );

				$img->removeattribute( 'src' );
				$img->setattribute( 'src', $image_name );
			}
		}

		$content = $dom->savehtml();

		$result = $this->client->post( "api/license-agreement", [
			'form_params' => [
				'content' => $content,
				'version' => $version
			],
			'headers'     => [
				'Authorization'  => "Bearer " . \Session::get( 'token' ),
				'x-localization' => App::getLocale()
			]
		] );

		if ( $result->getStatusCode() == '500' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->back();
		}

		$data = \GuzzleHttp\json_decode( $result->getBody() );


		if ( isset( $data->error ) ) {
			alert()->error( trans( 'messages.errors.form_has_Errors' ), trans( 'messages.errors.request_failed' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );


			return redirect()->back()->withErrors( $data->error )->withInput();
		} elseif ( isset( $data->data ) ) {

			alert()->success( trans( 'messages.licenses.create.success' ), trans( 'messages.licenses.create.created' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );


			return redirect()->to( App::getLocale() . '/super-admin/license-agreements' );

		}
	}

	/**
	 * @param $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function show( $id ) {


		$result = $this->client->get( "api/license-agreement/" . $id, [
			'headers' => [
				'Authorization'  => "Bearer " . \Session::get( 'token' ),
				'x-localization' => App::getLocale()
			]
		] );


		if ( $result->getStatusCode() == '500' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( 'Close' )->autoclose( false );

			return redirect()->back();
		}

		$data = \GuzzleHttp\json_decode( $result->getBody() );

		$license = $data->data->license;
		$user    = \Session::get( 'user' );

		if ( isset( $data->data ) && isset( $license ) && isset( $user ) ) {
			return view( 'superadmin.license.show', [
				'license' => $license,
				'user'    => $user
			] );
		}


	}
}

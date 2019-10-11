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

class CounterfietDevicesController extends Controller {

	protected $client;

	/**
	 * CounterfietDevicesController constructor.
	 */
	public function __construct() {

		$this->client = new Client( [
			'base_uri'    => config( 'app.api_url' ),
			'http_errors' => false
		] );
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index( Request $request ) {
		if ( \Session::has( 'token' ) ) {
			return view( 'admin.counter.counterfiet' );
		} else {
			return redirect()->route( 'login' );
		}
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function view_image( Request $request ) {


		$result = $this->client->get( "api/search_counter/" . $request->id, [
			'headers' =>
				[
					'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
					'x-localization' => App::getLocale()
				]
		] );


		$data = \GuzzleHttp\json_decode( $result->getBody() );

		if ( isset( $data->errors ) ) {
			return redirect()->route( 'login' );
		}
		if ( ! isset( $data->data ) ) {
			abort( 404 );
		}
		$counterDetails = $data->data;
		$images         = explode( '|', $data->data->image_path );
		$disk           = \Storage::disk( 's3' );
		$aws_images     = array();
		foreach ( $images as $value ) {
			if ( $disk->exists( $value ) ) {
				$command      = $disk->getDriver()->getAdapter()->getClient()->getCommand( 'GetObject', [
					'Bucket' => \Config::get( 'filesystems.disks.s3.bucket' ),
					'Key'    => $value,
				] );
				$aws_images[] = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest( $command, '+1 minutes' );
			}
		}


		if ( isset( $aws_images ) && isset( $counterDetails ) ) {

			return view( 'admin.counter.view', compact( 'aws_images', 'counterDetails' ) );
		}
		abort( 404 );
	}


	/**
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function report( Request $request ) {

		$images = \request()->all();

		$request->validate( [
			'brand_name'  => 'required|max:255',
			'model_name'  => 'required|max:255',
			'description' => 'required|max:255',
			'address'     => 'required|max:255',
			'store_name'  => 'required|max:255',
		] );

		$output = [];

		if ( isset( $images['counterImage'] ) ) {
			foreach ( $images['counterImage'] as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$output[] = [
						'name'     => 'counterImage[]',
						'contents' => fopen( $value->getPathname(), 'r' ),
						'filename' => $value->getClientOriginalName()
					];
					continue;
				}

				foreach ( $value as $multiKey => $multiValue ) {
					$multiName = $key . '[' . $multiKey . ']' . ( is_array( $multiValue ) ? '[' . key( $multiValue ) . ']' : '' ) . '';
					$output[]  = [
						'name'     => 'counterImage[]',
						'contents' => ( is_array( $multiValue ) ? reset( $multiValue ) : $multiValue )
					];
				}
			}

			$output [] =
				[
					'name'     => 'brand_name',
					'contents' => \request()->get( 'brand_name' )
				];

			$output [] = [
				'name'     => 'model_name',
				'contents' => \request()->get( 'model_name' )
			];
			$output [] = [
				'name'     => 'description',
				'contents' => \request()->get( 'description' )
			];
			$output [] = [
				'name'     => 'address',
				'contents' => \request()->get( 'address' )
			];
			$output [] = [
				'name'     => 'store_name',
				'contents' => \request()->get( 'store_name' )
			];
			$output [] = [
				'name'     => 'imei_number',
				'contents' => \request()->get( 'imei_number' )
			];
		} elseif ( ! isset( $images['counterImage'] ) ) {
			$output [] =
				[
					'name'     => 'brand_name',
					'contents' => \request()->get( 'brand_name' )
				];

			$output [] = [
				'name'     => 'model_name',
				'contents' => \request()->get( 'model_name' )
			];
			$output [] = [
				'name'     => 'description',
				'contents' => \request()->get( 'description' )
			];
			$output [] = [
				'name'     => 'address',
				'contents' => \request()->get( 'address' )
			];
			$output [] = [
				'name'     => 'store_name',
				'contents' => \request()->get( 'store_name' )
			];
			$output [] = [
				'name'     => 'imei_number',
				'contents' => \request()->get( 'imei_number' )
			];
		}


		$response = $this->client->request( 'POST', 'api/counterfiet', [
			'headers'   => [
				'Authorization'  => 'bearer ' . \Session::get( 'token' ),
				'x-localization' => App::getLocale()
			],
			//indicates multipart form
			'multipart' => $output

		] );


		if ( $response->getStatusCode() == '500' ) {
			alert()->error( trans( 'messages.server_error' ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->back();
		}

		$data = \GuzzleHttp\json_decode( $response->getBody() );

		$message = $data->message;
		if ( ! isset( $data ) ) {

			abort( 404 );
		} elseif ( isset( $data ) && $data->success ) {

			alert()->success( $message, trans( 'messages.success.device_reported' ) )->persistent( trans( 'messages.success.ok' ) )->autoclose( false );
			$user = \Session::get( 'user' );
			if ( $user->roles[0]->slug === 'admin' ) {
				return redirect()->to( App::getLocale() . '/admin/imei' );


			} elseif ( $user->roles[0]->slug === 'staff' ) {
				return redirect()->to( App::getLocale() . '/staff/imei' );
			}


		} elseif ( isset( $data ) && ! $data->success ) {
			alert()->success( $message, trans( 'messages.success.device_reported' ) )->persistent( trans( 'messages.success.ok' ) )->autoclose( false );

			$user = \Session::get( 'user' );
			if ( $user->roles[0]->slug === 'admin' ) {
				return redirect()->to( App::getLocale() . '/admin/imei' );

			} elseif ( $user->roles[0]->slug === 'staff' ) {
				return redirect()->to( App::getLocale() . '/staff/imei' );
			}

		} elseif ( isset( $data->success ) && ! $data->success ) {

			alert()->success( $message, trans( 'messages.success.device_reported' ) )->persistent( trans( 'messages.success.ok' ) )->autoclose( false );

			$user = \Session::get( 'user' );
			if ( $user->roles[0]->slug === 'admin' ) {
				return redirect()->to( App::getLocale() . '/admin/imei' );

			} elseif ( $user->roles[0]->slug === 'staff' ) {
				return redirect()->to( App::getLocale() . '/staff/imei' );
			}

		}


	}
}

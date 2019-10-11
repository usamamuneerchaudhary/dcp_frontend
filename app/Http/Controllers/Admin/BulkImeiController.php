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
namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use League\Flysystem\FileNotFoundException;

class BulkImeiController extends Controller {

	/**
	 * @var $response
	 */
	protected $response;
	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * BulkImeiController constructor.
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
	public function bulkLookup() {
		$user = \Session::get( 'user' );

		if ( \Session::has( 'token' ) ) {
			return view( 'admin.imei.bulk-search', compact( 'user' ) );
		} else {
			return redirect()->to( 'login' );
		}
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function showFileUpload( Request $request ) {

		$file = Input::file( 'imei' );

		$imagePath = $file->getPathName();
		$tmp       = tempnam( sys_get_temp_dir(), 'php' );


		$result = $this->client->post( 'api/bulk-lookup', [

			'form_params' =>
				[
					'imei'     => $tmp,
					'name'     => $file,
					'contents' => file_put_contents( $tmp, file_get_contents( $imagePath ) ),
//				'contents'=> fopen( $file->getPathname(), 'r' ),
					'filename' => $file
				],
			'headers'     =>
				[
					'Authorization' => 'Bearer ' . \Session::get( 'token' )
				]
		] );


		if ( ! isset( $result ) ) {
			alert()->error( 'Please upload file as instructed', 'File Error' )->persistent( 'Ok' )->autoclose( false );

			return redirect()->back();
		}


		//if status code matches 500 or file size exceeds 3mb limit
		if ( $result->getStatusCode() == '500' || $request->file( 'imei' )->getClientSize() >= '3000' || $request->file( 'imei' )->getMimeType() != 'text/plain' ) {

			alert()->error( 'Please upload the valid file to continue', 'File Error' )->persistent( 'Ok' )->autoclose( false );

			return redirect()->back();
		}

		$results = \GuzzleHttp\json_decode( $result->getBody() );


		return $this->setupFileContents( $request, $results );

	}

	/**
	 * @param $csv
	 *
	 * @return mixed
	 */
	public function getDownload( $csv ) {

		$file = storage_path() . '/' . $csv;

		$headers = array(
			'Content-Type: application/csv',
		);

		// Notification: Notify System users that attachment is downloaded by current user
		return \Response::download( $file, $csv, $headers );
	}

	/**
	 * @param Request $request
	 * @param $results
	 *
	 * @return \Illuminate\Http\RedirectResponse|mixed
	 */
	protected function setupFileContents( Request $request, $results ) {


		try {

			if ( isset( $results->none_found ) ) {
				alert()->error( 'No IMEIs matched our records, please upload valid IMEIs & try again.', 'File Error' )->persistent( 'Ok' )->autoclose( false );

				return redirect()->back();
			}


			if ( isset( $results->results ) && isset( $results->not_found ) ) {

				$handle = fopen( storage_path() . '/imei.csv', 'w' );
				fputcsv( $handle, array(
					'TAC',
					'GSMA: Marketing Name',
					'GSMA: Manufacturer',
					'GSMA: Allocation Date',
					'GSMA: Model Name',
					'GSMA: Bands',
					'GSMA: Device Type',
					'Year Released',
					'Diagonal Screen Size'
				) );


				foreach ( $results->results as $result ) {

					$marketing_name       = "GSMA: Marketing Name";
					$manufacturer         = "GSMA: Manufacturer";
					$allocation_date      = "GSMA: Allocation Date";
					$model_name           = "GSMA: Model Name";
					$bands                = "GSMA: Bands";
					$device_type          = "GSMA: Device Type";
					$year_released        = "Year Released";
					$diagonal_screen_size = "Diagonal Screen Size";

					$csv_array = array(
						'TAC'                  => $result->TAC,
						'Marketing Name'       => $result->$marketing_name,
						'Manufacturer'         => $result->$manufacturer,
						'Allocation Date'      => $result->$allocation_date,
						'Model Name'           => $result->$model_name,
						'GSMA Bands'           => $result->$bands,
						'Device Type'          => $result->$device_type,
						'Year Released'        => $result->$year_released,
						'Diagonal Screen Size' => $result->$diagonal_screen_size
					);

					if ( isset( $result ) ) {

						fputcsv( $handle, (array) $csv_array );

					}
				}
				foreach ( $results->not_found as $not_found ) {

					$csv_array = array(
						'TAC'       => $not_found,
						'Not Found' => 'Not Found'

					);

					if ( isset( $not_found ) ) {

						fputcsv( $handle, (array) $csv_array );

					}
				}

			}

			fclose( $handle );

			return $this->getDownload( 'imei.csv' );
		} catch ( FileNotFoundException $exception ) {
			return redirect()->route( 'admin.imei.bulk-search' );
		}
	}

}

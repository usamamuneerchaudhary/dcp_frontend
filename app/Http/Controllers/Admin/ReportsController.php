<?php
/**
 * SPDX-License-Identifier: BSD-4-Clause-Clear
 *
 * Copyright (c) 2018-2019 Qualcomm Technologies, Inc.
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are permitted (subject to the
 * limitations in the disclaimer below) provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice, this list of conditions and the following
 * disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the
 * following disclaimer in the documentation and/or other materials provided with the distribution.
 * - All advertising materials mentioning features or use of this software, or any deployment of this software,
 * or documentation accompanying any distribution of this software, must display the trademark/logo as per the
 * details provided here: https://www.qualcomm.com/documents/dirbs-logo-and-brand-guidelines
 * - Neither the name of Qualcomm Technologies, Inc. nor the names of its contributors may be used to endorse or
 * promote products derived from this software without specific prior written permission.
 *
 *
 *
 * SPDX-License-Identifier: ZLIB-ACKNOWLEDGEMENT
 *
 * Copyright (c) 2018-2019 Qualcomm Technologies, Inc.
 *
 * This software is provided 'as-is', without any express or implied warranty. In no event will the authors be held liable
 * for any damages arising from the use of this software. Permission is granted to anyone to use this software for any
 * purpose, including commercial applications, and to alter it and redistribute it freely, subject to the following
 * restrictions:
 *
 * - The origin of this software must not be misrepresented; you must not claim that you wrote the original software.
 * If you use this software in a product, an acknowledgment is required by displaying the trademark/logo as per the
 * details provided here: https://www.qualcomm.com/documents/dirbs-logo-and-brand-guidelines
 * - Altered source versions must be plainly marked as such, and must not be misrepresented as being the original
 * software.
 * - This notice may not be removed or altered from any source distribution.
 *
 * NO EXPRESS OR IMPLIED LICENSES TO ANY PARTY'S PATENT RIGHTS ARE GRANTED BY THIS LICENSE. THIS SOFTWARE IS PROVIDED BY
 * THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR
 * BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use GuzzleHttp\Client;

class ReportsController extends Controller {
	/**
	 * ReportsController constructor.
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
		$user = \Session::get( 'user' );

		return $this->getChart( $user );
	}


	/**
	 * @return array|\Illuminate\Http\RedirectResponse
	 */
	public function getReports() {
		$result = $this->client->get( "api/get_users_activity", [
			'headers' =>
				[
					'Authorization' => 'Bearer ' . \Session::get( 'token' )
				]
		] );


		if ( $result->getStatusCode() == '500' ) {
			alert()->error( 'Server not responding, Please contact your system administrator', 'Internal Server Error' )->persistent( 'Close' )->autoclose( false );

			return redirect()->back();
		}

		$data = \GuzzleHttp\json_decode( $result->getBody() );


		if ( isset( $data->errors->root ) ) {
			return redirect()->route( 'login' );
		}


		list( $users_activity,
			$found,
			$not_found,
			$created_imei,
			$visitor_traffic,
			$visitor_reports,
			$totalIMEI,
			$totalUsers,
			$totalCounterFeitDevices,
			$deactivatedUsers,
			$totalNotMatchedImeis,
			$totalMatchedImeis,
			$latLongIMEIHeatMapSearches,
			$counterfeitHeatMapSearches,
			$imeiByDate,
			$counterFeitByDate,
			$imeifoundByCreatedAt,
			$imeiNotFoundByCreatedAt,
			$imeiFilterByCountry ) = $this->dataSet( $data );


		return array(
			'users_activity'             => $users_activity,
			'found'                      => $found,
			'not_found'                  => $not_found,
			'created_imei'               => $created_imei,
			'visitor_searches'           => $visitor_traffic,
			'visitor_reports'            => $visitor_reports,
			'totalIMEI'                  => $totalIMEI,
			'totalUsers'                 => $totalUsers,
			'totalCounterFeitDevices'    => $totalCounterFeitDevices,
			'deactivatedUsers'           => $deactivatedUsers,
			'totalNotMatchedImeis'       => $totalNotMatchedImeis,
			'totalMatchedImeis'          => $totalMatchedImeis,
			'latLongIMEIHeatMapSearches' => $latLongIMEIHeatMapSearches,
			'counterfeitHeatMapSearches' => $counterfeitHeatMapSearches,
			'imeiByDate'                 => $imeiByDate,
			'counterFeitByDate'          => $counterFeitByDate,
			'imeifoundByCreatedAt'       => $imeifoundByCreatedAt,
			'imeiNotFoundByCreatedAt'    => $imeiNotFoundByCreatedAt,
			'imeiFilterByCountry'        => $imeiFilterByCountry,


		);
	}

	/**
	 * @param $user
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	protected function getChart( $user ) {
		$users_activity = $this->getReports();

		if ( array_key_exists( 'users_activity', $users_activity ) ) {


			if ( isset( $users_activity['visitor_searches'] ) || isset( $users_activity['visitor_reports'] ) ) {


				$imeifoundByCreatedAt    = $users_activity['imeifoundByCreatedAt'];
				$imeiNotFoundByCreatedAt = $users_activity['imeiNotFoundByCreatedAt'];

				$imeiFilterByCountry = $users_activity['imeiFilterByCountry'];

				$imeiByDate      = $users_activity['imeiByDate'];
				$counterByDate   = $users_activity['counterFeitByDate'];
				$visitor_traffic = $users_activity['visitor_searches'];
				$visitor_reports = $users_activity['visitor_reports'];
				$jan             = "01";
				$feb             = "02";
				$mar             = "03";
				$apr             = "04";
				$may             = "05";
				$jun             = "06";
				$jul             = "07";
				$ags             = "08";
				$sep             = "09";
				$oct             = "10";
				$nov             = "11";
				$dec             = "12";
			}

			if ( \Session::has( 'token' ) ) {
				if ( $user->roles[0]->slug === 'admin' ) {

					if ( \request()->is( 'en/*' ) ) {
						$labels = [
							'January',
							'February',
							'March',
							'April',
							'May',
							'June',
							'July',
							'August',
							'September',
							'October',
							'November',
							'December'
						];
					} elseif ( \request()->is( 'vi/*' ) ) {
						$labels = [
							trans( 'dashboard.months.january', [], 'vi' ),
							trans( 'dashboard.months.february', [], 'vi' ),
							trans( 'dashboard.months.march', [], 'vi' ),
							trans( 'dashboard.months.april', [], 'vi' ),
							trans( 'dashboard.months.may', [], 'vi' ),
							trans( 'dashboard.months.june', [], 'vi' ),
							trans( 'dashboard.months.july', [], 'vi' ),
							trans( 'dashboard.months.august', [], 'vi' ),
							trans( 'dashboard.months.september', [], 'vi' ),
							trans( 'dashboard.months.october', [], 'vi' ),
							trans( 'dashboard.months.november', [], 'vi' ),
							trans( 'dashboard.months.december', [], 'vi' ),
						];
					}


					if ( \request()->is( 'en/*' ) ) {
						$label = "IMEI Searches";
					} elseif ( \request()->is( 'vi/*' ) ) {
						$label = trans( 'dashboard.imei_searches', [], 'vi' );
					}
					/**
					 * @line @chart for
					 * All IMEI and Reported Devices
					 */

					$line_chart = app()->chartjs
						->name( 'IMEISearches' )
						->type( 'line' )
						->size( [ 'width' => 500, 'height' => 225 ] )
						->labels( $labels )
						->datasets( [
							[
								"label"                     => $label,
								'backgroundColor'           => "rgba(38, 185, 154, 0.31)",
								'borderColor'               => "rgba(38, 185, 154, 0.7)",
								"pointBorderColor"          => "rgba(38, 185, 154, 0.7)",
								"pointBackgroundColor"      => "rgba(38, 185, 154, 0.7)",
								"pointHoverBackgroundColor" => "#fff",
								"pointHoverBorderColor"     => "rgba(220,220,220,1)",
								'data'                      => [
									isset( $visitor_traffic->$jan ) ? count( $visitor_traffic->$jan ) : '',
									isset( $visitor_traffic->$feb ) ? count( $visitor_traffic->$feb ) : '',
									isset( $visitor_traffic->$mar ) ? count( $visitor_traffic->$mar ) : '',
									isset( $visitor_traffic->$apr ) ? count( $visitor_traffic->$apr ) : '',
									isset( $visitor_traffic->$may ) ? count( $visitor_traffic->$may ) : '',
									isset( $visitor_traffic->$jun ) ? count( $visitor_traffic->$jun ) : '',
									isset( $visitor_traffic->$jul ) ? count( $visitor_traffic->$jul ) : '',
									isset( $visitor_traffic->$ags ) ? count( $visitor_traffic->$ags ) : '',
									isset( $visitor_traffic->$sep ) ? count( $visitor_traffic->$sep ) : '',
									isset( $visitor_traffic->$oct ) ? count( $visitor_traffic->$oct ) : '',
									isset( $visitor_traffic->$nov ) ? count( $visitor_traffic->$nov ) : '',
									isset( $visitor_traffic->$dec ) ? count( $visitor_traffic->$dec ) : '',
								],
							],
							[
								"label"                     => 'Reported Devices',
								'backgroundColor'           => "rgba(128,0,0,0.6)",
								'borderColor'               => "rgba(128,0,0,0.6)",
								"pointBorderColor"          => "rgba(128,0,0,0.6)",
								"pointBackgroundColor"      => "rgba(128,0,0,0.6)",
								"pointHoverBackgroundColor" => "#fff",
								"pointHoverBorderColor"     => "rgba(220,220,220,1)",
								'data'                      => [
									isset( $visitor_reports->$jan ) ? count( $visitor_reports->$jan ) : '',
									isset( $visitor_reports->$feb ) ? count( $visitor_reports->$feb ) : '',
									isset( $visitor_reports->$mar ) ? count( $visitor_reports->$mar ) : '',
									isset( $visitor_reports->$apr ) ? count( $visitor_reports->$apr ) : '',
									isset( $visitor_reports->$may ) ? count( $visitor_reports->$may ) : '',
									isset( $visitor_reports->$jun ) ? count( $visitor_reports->$jun ) : '',
									isset( $visitor_reports->$jul ) ? count( $visitor_reports->$jul ) : '',
									isset( $visitor_reports->$ags ) ? count( $visitor_reports->$ags ) : '',
									isset( $visitor_reports->$sep ) ? count( $visitor_reports->$sep ) : '',
									isset( $visitor_reports->$oct ) ? count( $visitor_reports->$oct ) : '',
									isset( $visitor_reports->$nov ) ? count( $visitor_reports->$nov ) : '',
									isset( $visitor_reports->$dec ) ? count( $visitor_reports->$dec ) : '',
								],
							]
						] )
						->options( [] );


					if ( \request()->is( 'en/*' ) ) {
						$validSearches   = 'Valid Searches';
						$InvalidSearches = 'Invalid Searches';
					} elseif ( \request()->is( 'vi/*' ) ) {
						$validSearches   = trans( 'dashboard.valid_searches', [], 'vi' );
						$InvalidSearches = trans( 'dashboard.invalid_searches', [], 'vi' );
					}

					$pie_chart = app()->chartjs
						->name( 'ValidInvalidSearches' )
						->type( 'pie' )
						->size( [ 'width' => 400, 'height' => 400 ] )
						->labels( [ $validSearches, $InvalidSearches ] )
						->datasets( [
							[
								'backgroundColor'      => [ 'green', '#004590' ],
								'hoverBackgroundColor' => [ '#000', '#00acc1' ],
								'data'                 => [ $users_activity['found'], $users_activity['not_found'] ]
							]
						] )
						->options( [] );


					//NEW CHARTS

					/**
					 * @chart for
					 * "Sum of IMEI & Counterfeit searches"
					 */

					$imeid   = array();
					$imeiSum = array();

					if ( ! empty( $imeiByDate ) ) {
						foreach ( $imeiByDate as $item ) {
							$imeid[]   = Carbon::parse( $item->date )->formatLocalized( '%d %b' );
							$imeiSum[] = $item->sum;

						}
					}

					$counterD   = array();
					$counterSum = array();


					if ( ! empty( $counterFeitByDate ) ) {
						foreach ( $counterByDate as $item ) {
							$counterD[]   = Carbon::parse( $item->date )->formatLocalized( '%d %b' );
							$counterSum[] = $item->sum;

						}
					}

					$sum_bar_chart = app()->chartjs
						->name( 'IMEICounterfeitSumCount' )
						->type( 'bar' )
						->size( [ 'width' => 500, 'height' => 225 ] )
						->labels( $imeid )
						->datasets( [
							[
								"label"                     => 'Sum of IMEI Seaches',
								'backgroundColor'           => "rgba(38, 185, 154, 0.31)",
								'borderColor'               => "rgba(38, 185, 154, 0.7)",
								"pointBorderColor"          => "rgba(38, 185, 154, 0.7)",
								"pointBackgroundColor"      => "rgba(38, 185, 154, 0.7)",
								"pointHoverBackgroundColor" => "#fff",
								"pointHoverBorderColor"     => "rgba(220,220,220,1)",
								'data'                      => $imeiSum
							],
							[
								"label"                     => 'Sum of Reported Devices',
								'backgroundColor'           => "rgba(128,0,0,0.6)",
								'borderColor'               => "rgba(128,0,0,0.6)",
								"pointBorderColor"          => "rgba(128,0,0,0.6)",
								"pointBackgroundColor"      => "rgba(128,0,0,0.6)",
								"pointHoverBackgroundColor" => "#fff",
								"pointHoverBorderColor"     => "rgba(220,220,220,1)",
								'data'                      => $counterSum
							]
						] )
						->options( [] );

					/**
					 * @chart for
					 * "Sum of Valid/Invalid Searches
					 */

					$sum_valid_invalid_searches = app()->chartjs
						->name( 'sumOfValidInvalidSearches' )
						->type( 'bar' )
						->size( [ 'width' => 400, 'height' => 400 ] )
						->labels( [ $validSearches, $InvalidSearches ] )
						->datasets( [
							[
								"label"                     => 'Sum of Valid Seaches',
								'backgroundColor'           => "rgba(38, 185, 154, 0.31)",
								'borderColor'               => "rgba(38, 185, 154, 0.7)",
								"pointBorderColor"          => "rgba(38, 185, 154, 0.7)",
								"pointBackgroundColor"      => "rgba(38, 185, 154, 0.7)",
								"pointHoverBackgroundColor" => "#fff",
								"pointHoverBorderColor"     => "rgba(220,220,220,1)",
								'data'                      => [ $users_activity['found'] ]
							],
							[
								"label"                     => 'Sum of Invalid Searches',
								'backgroundColor'           => "rgba(128,0,0,0.6)",
								'borderColor'               => "rgba(128,0,0,0.6)",
								"pointBorderColor"          => "rgba(128,0,0,0.6)",
								"pointBackgroundColor"      => "rgba(128,0,0,0.6)",
								"pointHoverBackgroundColor" => "#fff",
								"pointHoverBorderColor"     => "rgba(220,220,220,1)",
								'data'                      => [ $users_activity['not_found'] ]
							]
						] )
						->options( [] );


					/**
					 * @chart for
					 * "Sum of IMEI & Counterfeit searches per dates"
					 */

					$imeiFd   = array();
					$imeiFSum = array();
					if ( ! empty( $imeifoundByCreatedAt ) ) {
						foreach ( $imeifoundByCreatedAt as $item ) {
							$imeiFd[]   = Carbon::parse( $item->date )->formatLocalized( '%d %b' );
							$imeiFSum[] = $item->sum;

						}
					}


					$imNfD  = array();
					$imNotF = array();

					if ( ! empty( $imeiNotFoundByCreatedAt ) ) {
						foreach ( $imeiNotFoundByCreatedAt as $item ) {


							$imNfD[]  = Carbon::parse( $item->date )->formatLocalized( '%d %b' );
							$imNotF[] = $item->sum;

						}
					}


					$sum_bar_chart_per_date = app()->chartjs
						->name( 'IMEICounterfeitSumCountPerDate' )
						->type( 'bar' )
						->size( [ 'width' => 500, 'height' => 225 ] )
						->labels( $imeid )
						->datasets( [
							[
								"label"                     => 'Valid Seaches',
								'backgroundColor'           => "rgba(38, 185, 154, 0.31)",
								'borderColor'               => "rgba(38, 185, 154, 0.7)",
								"pointBorderColor"          => "rgba(38, 185, 154, 0.7)",
								"pointBackgroundColor"      => "rgba(38, 185, 154, 0.7)",
								"pointHoverBackgroundColor" => "#fff",
								"pointHoverBorderColor"     => "rgba(220,220,220,1)",
								'data'                      => $imeiFSum
							],
							[
								"label"                     => 'Invalid Searches',
								'backgroundColor'           => "rgba(128,0,0,0.6)",
								'borderColor'               => "rgba(128,0,0,0.6)",
								"pointBorderColor"          => "rgba(128,0,0,0.6)",
								"pointBackgroundColor"      => "rgba(128,0,0,0.6)",
								"pointHoverBackgroundColor" => "#fff",
								"pointHoverBorderColor"     => "rgba(220,220,220,1)",
								'data'                      => $imNotF
							]
						] )
						->options( [] );


					/**
					 * @chart for
					 * IMEI sum per country search
					 */


					$cImeis = array();
					$cTitle = array();
					if ( ! empty( $imeiFilterByCountry ) ) {
						foreach ( $imeiFilterByCountry as $item ) {
							$cTitle[] = $item->city;
							$cImeis[] = $item->sum;
						}
					}

					$color      = array();
					$hoverColor = array();
					foreach ( $cTitle as $c ) {
						$color[]      = '#' . $this->random_color();
						$hoverColor[] = '#' . $this->random_color();
					}


					$imei_sum_per_country_chart = app()->chartjs
						->name( 'IMEISearchesPerCountry' )
						->type( 'pie' )
						->size( [ 'width' => 500, 'height' => 225 ] )
						->labels( $cTitle )
						->datasets( [
							[
								'backgroundColor'      => $color,
								'hoverBackgroundColor' => $hoverColor,
								'data'                 => $cImeis
							],
						] )
						->options( [] );


					return view( 'admin.reports.index', compact(
						'user',
						'line_chart',
						'sum_bar_chart',
						'pie_chart',
						'sum_valid_invalid_searches',
						'sum_bar_chart_per_date',
						'imei_sum_per_country_chart',
						'users_activity' ) );
				} else {
					abort( 404, 'Restricted Area' );
				}
			} else {
				return redirect()->route( 'login' );
			}
		} else {
			return redirect()->route( 'login' );
		}
	}

	/**
	 * @return string
	 */
	function random_color_part() {
		return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT );
	}

	/**
	 * @return string
	 */
	function random_color() {
		return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	protected function dataSet( $data ) {

		isset( $data->data->activity->data ) ? $users_activity = $data->data->activity->data : $users_activity = '';
		isset( $data->data->found ) ? $found = $data->data->found : $found = '';
		isset( $data->data->not_found ) ? $not_found = $data->data->not_found : $not_found = '';
		isset( $data->data->imei_created_at ) ? $created_imei = $data->data->imei_created_at : $created_imei = '';
		isset( $data->data->visitor_traffic ) ? $visitor_traffic = $data->data->visitor_traffic : $visitor_traffic = '';
		isset( $data->data->visitorReports ) ? $visitor_reports = $data->data->visitorReports : $visitor_reports = '';
		isset( $data->data->totalIMEI ) ? $totalIMEI = $data->data->totalIMEI : $totalIMEI = '';
		isset( $data->data->totalUsers ) ? $totalUsers = $data->data->totalUsers : $totalUsers = '';
		isset( $data->data->totalCounterFeitDevices ) ? $totalCounterFeitDevices = $data->data->totalCounterFeitDevices : $totalCounterFeitDevices = '';
		isset( $data->data->deactivatedUsers ) ? $deactivatedUsers = $data->data->deactivatedUsers : $deactivatedUsers = '';
		isset( $data->data->totalNotMatchedImeis ) ? $totalNotMatchedImeis = $data->data->totalNotMatchedImeis : $totalNotMatchedImeis = '';
		isset( $data->data->totalMatchedImeis ) ? $totalMatchedImeis = $data->data->totalMatchedImeis : $totalMatchedImeis = '';
		isset( $data->data->latLongIMEIHeatMapSearches ) ? $latLongIMEIHeatMapSearches = $data->data->latLongIMEIHeatMapSearches : $latLongIMEIHeatMapSearches = '';
		isset( $data->data->counterfeitHeatMapSearches ) ? $counterfeitHeatMapSearches = $data->data->counterfeitHeatMapSearches : $counterfeitHeatMapSearches = '';
		isset( $data->data->imeiByDate ) ? $imeiByDate = $data->data->imeiByDate : $imeiByDate = '';
		isset( $data->data->counterFeitByDate ) ? $counterFeitByDate = $data->data->counterFeitByDate : $counterFeitByDate = '';
		isset( $data->data->imeifoundByCreatedAt ) ? $imeifoundByCreatedAt = $data->data->imeifoundByCreatedAt : $imeifoundByCreatedAt = '';
		isset( $data->data->imeiNotFoundByCreatedAt ) ? $imeiNotFoundByCreatedAt = $data->data->imeiNotFoundByCreatedAt : $imeiNotFoundByCreatedAt = '';
		isset( $data->data->imeiFilterByCountry ) ? $imeiFilterByCountry = $data->data->imeiFilterByCountry : $imeiFilterByCountry = '';

		return array(
			$users_activity,
			$found,
			$not_found,
			$created_imei,
			$visitor_traffic,
			$visitor_reports,
			$totalIMEI,
			$totalUsers,
			$totalCounterFeitDevices,
			$deactivatedUsers,
			$totalNotMatchedImeis,
			$totalMatchedImeis,
			$latLongIMEIHeatMapSearches,
			$counterfeitHeatMapSearches,
			$imeiByDate,
			$counterFeitByDate,
			$imeifoundByCreatedAt,
			$imeiNotFoundByCreatedAt,
			$imeiFilterByCountry
		);
	}
}

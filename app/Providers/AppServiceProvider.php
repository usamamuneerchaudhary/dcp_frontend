<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {

//		$this->client   = new Client( [
//			'base_uri'    => config( 'app.api_url' ),
//			'http_errors' => false
//		] );
//
//
//		$response = $this->client->get( 'api/user-count-notify',
//			[
//				'headers' =>
//					[
//						'Authorization' => 'Bearer ' . \Session::get( 'token' )
//					]
//			]
//		);
//
////		dd($response);
//		$data     = \GuzzleHttp\json_decode( $response->getBody() );
////		dd($data);
//
//		view()->share( 'count', $data->inactive_count );

	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}

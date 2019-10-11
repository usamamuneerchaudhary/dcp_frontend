<?php

namespace Tests\Unit\SuperAdmin;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Tests\CreatesApplication;
use Tests\FakeGuzzleResponseHandler;
use Tests\TestCase;

class FeedbacksTest extends TestCase {

	use CreatesApplication, FakeGuzzleResponseHandler;

	protected $client;

	public function setUp() {
		parent::setUp();

		$this->client = new Client( [
			'base_uri'    => config( 'app.api_url' ),
			'http_errors' => false
		] );

		//admin login
		$login_response = $this->client->post( "api/login", [
			'form_params' => [
				'email'    => 'super@3gca.org',
				'password' => 'Admin@1234'
			],
			'header'      => [
				'x-localization' => App::getLocale(),
				'Accept'         => 'application/json'
			]
		] );
		$data           = \GuzzleHttp\json_decode( $login_response->getBody() );

		\Session::put( 'token', $data->meta->token );
		\Session::put( 'user', $data->data );


	}

	public function tearDown() {
		parent::tearDown();
		$this->client->get( '/api/db-refresh' );
	}


	/**
	 * @test
	 */
	public function canViewTUsersFeedback() {


		$result = $this->client->get( "api/datatable/feedback", [
			'headers' => [
				'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
				'x-localization' => App::getLocale()
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 200;
		$this->createMockResponse( $responseData, $statusCode );
		$this->assertTrue( true );
		$this->assertEquals( $result->getStatusCode(), $statusCode );
		$this->assertEquals( 200, $result->getStatusCode() );
		$contentType = $result->getHeaders()["Content-Type"][0];
		$this->assertEquals( "application/json", $contentType );

	}

	/**
	 * @test
	 */
	public function canViewFeedbackCountNotify() {

		$result = $this->client->get( "api/feedback-count-notify", [
			'headers' => [
				'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
				'x-localization' => App::getLocale()
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 200;
		$this->createMockResponse( $responseData, $statusCode );
		$this->assertTrue( true );
		$this->assertEquals( $result->getStatusCode(), $statusCode );
		$this->assertEquals( 200, $result->getStatusCode() );
		$contentType = $result->getHeaders()["Content-Type"][0];
		$this->assertEquals( "application/json", $contentType );

	}

	/**
	 * @test
	 */
	public function canResetFeedbackCountByID() {

		$staff_login = $this->client->post( "api/login", [
			'form_params' => [
				'email'    => 'usama@3gca.org',
				'password' => 'Admin@1234'
			],
			'header'      => [
				'x-localization' => App::getLocale(),
				'Accept'         => 'application/json'
			]
		] );

		$staff_data = \GuzzleHttp\json_decode( $staff_login->getBody() );

		\Session::put( 'staff_token', $staff_data->meta->token );
		$this->client->post( "api/feedback", [
			'form_params' => [
				'message' => 'test message'
			],

			'headers' => [
				'Authorization'  => "Bearer " . \Session::get( 'staff_token' ),
				'x-localization' => App::getLocale()
			]
		] );

		$result = $this->client->put( "api/feedback-count-reset/1", [
			'headers' => [
				'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
				'x-localization' => App::getLocale()
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 200;
		$this->createMockResponse( $responseData, $statusCode );
		$this->assertTrue( true );
		$this->assertEquals( $result->getStatusCode(), $statusCode );
		$this->assertEquals( 200, $result->getStatusCode() );
		$contentType = $result->getHeaders()["Content-Type"][0];
		$this->assertEquals( "application/json", $contentType );

	}


}

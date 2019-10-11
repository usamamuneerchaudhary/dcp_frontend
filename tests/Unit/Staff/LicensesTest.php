<?php

namespace Tests\Unit\Staff;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Tests\CreatesApplication;
use Tests\FakeGuzzleResponseHandler;
use Tests\TestCase;

class LicensesTest extends TestCase {

	use CreatesApplication, FakeGuzzleResponseHandler;

	protected $client;

	public function setUp() {
		parent::setUp();

		$this->client = new Client( [
			'base_uri'    => config( 'app.api_url' ),
			'http_errors' => false
		] );
//staff login
		$login_response = $this->client->post( "api/login", [
			'form_params' => [
				'email'    => 'usama@3gca.org',
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
	public function canUpdateUserLicenseAgreementByUserID() {

		$user = \Session::get( 'user' );

		$result       = $this->client->put( "api/update-user-license/" . $user->id, [
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

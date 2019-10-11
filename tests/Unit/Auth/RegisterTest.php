<?php

namespace Tests\Unit\Auth;

use GuzzleHttp\Client;
use Tests\CreatesApplication;
use Tests\FakeGuzzleResponseHandler;
use Tests\TestCase;

class RegisterTest extends TestCase {

	use CreatesApplication, FakeGuzzleResponseHandler;

	protected $client;

	public function setUp() {
		parent::setUp();

		$this->client = new Client( [
			'base_uri'    => config( 'app.api_url' ),
			'http_errors' => false
		] );


	}

	public function tearDown() {
		parent::tearDown();
		$this->client->get( '/api/db-refresh' );
	}


	/**
	 * Staff Can Login
	 * @test
	 * @return void
	 */
	public function StaffCanRegisterAsNewUser() {

		$result = $this->client->post( "api/register", [
			'form_params' => [
				'first_name'            => 'test',
				'last_name'             => 'test',
				'email'                 => 'test@3gca.org',
				'password'              => 'Admin@1234',
				'password_confirmation' => 'Admin@1234'
			],
			'header'      => [
				'Accept'         => 'application/json',
				'x-localization' => 'en'
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 200;

		if ( isset( $responseData->data ) && ! empty( $result ) ) {
			alert()->success( 'Please check your Email to activate your account', 'Registration Successful' )->persistent( "Ok" )->autoclose( false );

			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 200, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );

		}

	}

}

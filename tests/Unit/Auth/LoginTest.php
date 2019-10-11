<?php

namespace Tests\Unit\Auth;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Tests\CreatesApplication;
use Tests\FakeGuzzleResponseHandler;
use Tests\TestCase;

class LoginTest extends TestCase {

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
	public function StaffCanLogin() {

		$result = $this->client->post( "api/login", [
			'form_params' => [
				'email'    => 'usama@3gca.org',
				'password' => 'Admin@1234'
			],
			'header'      => [
				'x-localization' => App::getLocale(),
				'Accept'         => 'application/json'
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 200;
		$user         = $responseData->data;


		if ( isset( $user ) && $user->roles[0]->slug === 'staff' ) {

			if ( isset( $responseData->data ) && ! empty( $responseData->licenses ) ) {

				$user_licenses = $responseData->licenses;


				if ( isset( $user_licenses ) ) {
					\Session::put( 'token', $responseData->meta->token );
					\Session::put( 'user', $responseData->data );
					$this->createMockResponse( $responseData, $statusCode );
					$this->assertTrue( true );
					$this->assertEquals( $result->getStatusCode(), $statusCode );
					$this->assertEquals( 200, $result->getStatusCode() );
					$contentType = $result->getHeaders()["Content-Type"][0];
					$this->assertEquals( "application/json", $contentType );
				}
			}
		}

	}


	/**
	 * Staff Can not login with wrong credentials
	 * @test
	 * @return void
	 */
	public function StaffCannotLoginwithWrongCredentials() {


		$result = $this->client->post( "api/login", [
			'form_params' => [
				'email'    => 'usama@3gca.org',
				'password' => 'lorem@1234'
			],
			'header'      => [
				'x-localization' => App::getLocale(),
				'Accept'         => 'application/json'
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 401;

		if ( isset( $responseData->errors ) ) {
			alert()->error( trans( 'messages.wrong_creds' ), trans( 'messages.login_failed' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );
			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 401, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );
		}
	}

	/**
	 * Staff can not login if the server is down
	 * @test
	 * @return void
	 */
	public function StaffCannotLoginIfTheServerIsDown() {
		$result = $this->client->post( "api/loginlogin", [
			'form_params' => [
				'email'    => 'usama@3gca.org',
				'password' => 'lorem@1234'
			],
			'header'      => [
				'x-localization' => App::getLocale(),
				'Accept'         => 'application/json'
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 403;

		if ( isset( $responseData->error ) && $responseData->error === true ) {
			alert()->error( trans( $responseData->message ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );
			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 403, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );
		}
	}

	/**
	 * Admin Can Login
	 * @test
	 * @return void
	 */
	public function AdminCanLogin() {

		$result = $this->client->post( "api/login", [
			'form_params' => [
				'email'    => 'admin@3gca.org',
				'password' => 'Admin@1234'
			],
			'header'      => [
				'x-localization' => App::getLocale(),
				'Accept'         => 'application/json'
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$user         = $responseData->data;

		$statusCode = 200;

		if ( isset( $user ) && $user->roles[0]->slug === 'admin' ) {


			\Session::put( 'token', $responseData->meta->token );
			\Session::put( 'user', $responseData->data );

			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 200, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );

		}

	}


	/**
	 * Admin can not login with wrong credentials
	 * @test
	 * @return void
	 */
	public function AdminCannotLoginwithWrongCredentials() {


		$result = $this->client->post( "api/login", [
			'form_params' => [
				'email'    => 'admin@3gca.org',
				'password' => 'lorem@1234'
			],
			'header'      => [
				'x-localization' => App::getLocale(),
				'Accept'         => 'application/json'
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 401;

		if ( isset( $responseData->errors ) ) {
			alert()->error( trans( 'messages.wrong_creds' ), trans( 'messages.login_failed' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );
			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 401, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );
		}
	}

	/**
	 * Admin cannot login if the server is down
	 * @test
	 * @return void
	 */
	public function AdminCannotLoginIfTheServerIsDown() {
		$result = $this->client->post( "api/loginlogin", [
			'form_params' => [
				'email'    => 'admin@3gca.org',
				'password' => 'lorem@1234'
			],
			'header'      => [
				'x-localization' => App::getLocale(),
				'Accept'         => 'application/json'
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 403;


		if ( isset( $responseData->error ) && $responseData->error === true ) {
			alert()->error( trans( $responseData->message ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );
			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 403, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );
		}
	}


	/**
	 * Super Admin Can Login
	 * @test
	 * @return void
	 */
	public function superAdminCanLogin() {

		$result = $this->client->post( "api/login", [
			'form_params' => [
				'email'    => 'super@3gca.org',
				'password' => 'Admin@1234'
			],
			'header'      => [
				'x-localization' => App::getLocale(),
				'Accept'         => 'application/json'
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$user         = $responseData->data;
		$statusCode   = 200;

		if ( isset( $user ) && $user->roles[0]->slug === 'superadmin' ) {


			\Session::put( 'token', $responseData->meta->token );
			\Session::put( 'user', $responseData->data );

			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 200, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );


		}

	}


	/**
	 * Super Admin can not login with wrong credentials
	 * @test
	 * @return void
	 */
	public function SuperAdminCannotLoginwithWrongCredentials() {


		$result = $this->client->post( "api/login", [
			'form_params' => [
				'email'    => 'super@3gca.org',
				'password' => 'lorem@1234'
			],
			'header'      => [
				'x-localization' => App::getLocale(),
				'Accept'         => 'application/json'
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 401;

		if ( isset( $responseData->errors ) ) {
			alert()->error( trans( 'messages.wrong_creds' ), trans( 'messages.login_failed' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );
			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 401, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );
		}
	}

	/**
	 * superAdmin cannot login if the server is down
	 * @test
	 * @return void
	 */
	public function SuperAdminCannotLoginIfTheServerIsDown() {
		$result = $this->client->post( "api/loginlogin", [
			'form_params' => [
				'email'    => 'super@3gca.org',
				'password' => 'lorem@1234'
			],
			'header'      => [
				'x-localization' => App::getLocale(),
				'Accept'         => 'application/json'
			]
		] );

		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 403;

		if ( isset( $responseData->error ) && $responseData->error === true ) {
			alert()->error( trans( $responseData->message ), trans( 'messages.internal_server' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );
			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 403, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );
		}
	}

}

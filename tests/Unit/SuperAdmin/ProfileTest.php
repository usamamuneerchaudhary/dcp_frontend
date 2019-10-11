<?php

namespace Tests\Unit\SuperAdmin;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Tests\CreatesApplication;
use Tests\FakeGuzzleResponseHandler;
use Tests\TestCase;

class ProfileTest extends TestCase {

	use CreatesApplication, FakeGuzzleResponseHandler;

	protected $client;

	public function setUp() {
		parent::setUp();

		$this->client = new Client( [
			'base_uri'    => config( 'app.api_url' ),
			'http_errors' => false
		] );

		//superadmin login
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
	public function canViewTheirProfile() {

		$result       = $this->client->get( "api/profile", [
			'headers' => [
				'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
				'x-localization' => App::getLocale()
			]
		] );
		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 200;

		if ( isset( $responseData ) && \Session::has( 'token' ) ) {
			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 200, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );
		}

	}

	/**
	 * @test
	 */
	public function canViewTheirProfileByID() {

		$user = \Session::get( 'user' );

		$result       = $this->client->get( "api/profile/" . $user->id . "/edit", [
			'headers' => [
				'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
				'x-localization' => App::getLocale()
			]
		] );
		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 200;
		if ( isset( $responseData ) && \Session::has( 'token' ) ) {
			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 200, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );
		}

	}

	/**
	 * @test
	 */
	public function canEditTheirProfileByID() {

		$user = \Session::get( 'user' );

		$result       = $this->client->put( "api/profile/" . $user->id . "/edit",
			[
				'form_params' => [
					'first_name' => 'lorem',
					'last_name'  => 'ipsum',
					'email'      => 'super@3gca.org'
				],
				'headers'     => [
					'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
					'content-type'   => 'application/x-www-form-urlencoded',
					'x-localization' => App::getLocale()
				]
			] );
		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 200;
		if ( isset( $responseData ) && \Session::has( 'token' ) ) {
			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 200, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );
		}

	}

	/**
	 * @test
	 */
	public function canViewTheirProfilePasswordPageByID() {

		$user = \Session::get( 'user' );

		$result       = $this->client->get( "api/profile/" . $user->id . "/password", [
			'headers' => [
				'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
				'x-localization' => App::getLocale()
			]
		] );
		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 200;
		if ( isset( $responseData ) && \Session::has( 'token' ) ) {
			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 200, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );
		}

	}

	/**
	 * @test
	 */
	public function canEditTheirProfilePasswordByID() {

		$user = \Session::get( 'user' );

		$result       = $this->client->put( "api/profile/" . $user->id . "/password",
			[
				'form_params' => [
					'old_password'          => 'Admin@1234',
					'password'              => 'Admin@1234',
					'password_confirmation' => 'Admin@1234'
				],
				'headers'     => [
					'Authorization'  => 'Bearer ' . \Session::get( 'token' ),
					'content-type'   => 'application/x-www-form-urlencoded',
					'x-localization' => App::getLocale()
				]
			] );
		$responseData = \GuzzleHttp\json_decode( $result->getBody() );
		$statusCode   = 200;
		if ( isset( $responseData ) && \Session::has( 'token' ) ) {
			$this->createMockResponse( $responseData, $statusCode );
			$this->assertTrue( true );
			$this->assertEquals( $result->getStatusCode(), $statusCode );
			$this->assertEquals( 200, $result->getStatusCode() );
			$contentType = $result->getHeaders()["Content-Type"][0];
			$this->assertEquals( "application/json", $contentType );
		}

	}

}

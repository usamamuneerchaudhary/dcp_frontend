<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

trait FakeGuzzleResponseHandler {

	/**
	 * @param $responseData
	 * @param $statusCode
	 *
	 * @return Response
	 */
	public function createMockResponse( $responseData, $statusCode ) {
		$headers = [
			'Content-Type'   => 'application/json',
			'Accept'         => 'application/json',
			'x-localization' => 'en'
		];
		$body    = json_encode( $responseData );

		$response = new Response( $statusCode, $headers, $body );

		$mock = new MockHandler( [
			$response
		] );

		$handler = HandlerStack::create( $mock );
		$client  = new Client( [
			'handler' => $handler
		] );

		$this->app->instance( Client::class, $client );

		return $response;
	}
}
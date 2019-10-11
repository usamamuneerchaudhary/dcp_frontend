<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;

class ResetPasswordController extends Controller {
	protected $response;

	/**
	 * Where to redirect users after resetting their password.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	protected $client;

	public function __construct() {
		$this->client = new Client( [
			'base_uri'    => config( 'app.api_url' ),
			'http_errors' => false
		] );

	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * If no token is present, display the link request form.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param string|null $token
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showResetForm( Request $request, $token = null ) {
		return view( 'auth.passwords.reset' )->with(
			[ 'token' => $token, 'email' => $request->email ]
		);
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function reset() {

		$result = $this->client->post( "api/reset", [
			'form_params' => [
//				'email'                 => Input::get( 'email' ),
				'password'              => Input::get( 'password' ),
				'password_confirmation' => Input::get( 'password_confirmation' ),
				'token'                 => \request()->token
			],
			'headers'     => [
				'Accept'         => 'application/json',
				'x-localization' => App::getLocale()
			]
		] );
		$data   = \GuzzleHttp\json_decode( $result->getBody() );

		if ( $data->error === true ) {
			alert()->error( trans( 'auth.password_reset.token_mismatch' ) )->persistent( trans( 'messages.success.close' ) )->autoclose( false );

			return redirect()->route( 'password/recover' );
		} else if ( $data->error === false ) {
			alert()->success( trans( 'auth.password_reset.success' ) );

			return redirect()->route( 'login' );

		}
	}
}

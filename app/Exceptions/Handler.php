<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class Handler extends ExceptionHandler {
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		\Illuminate\Auth\AuthenticationException::class,
		\Illuminate\Auth\Access\AuthorizationException::class,
		\Symfony\Component\HttpKernel\Exception\HttpException::class,
		\Illuminate\Database\Eloquent\ModelNotFoundException::class,
		\Illuminate\Validation\ValidationException::class,
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception $exception
	 *
	 * @return void
	 */
	public function report( Exception $exception ) {

		parent::report( $exception );
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Exception $exception
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function render( $request, Exception $exception ) {

		if ( ! \Session::has( 'token' ) ) {


			return redirect()->to( 'en/login' );
		}

		if ( ! \Session::has( 'user' ) ) {

			return redirect()->to( 'en/login' );
		}


		if ( $exception instanceof FatalThrowableError ) {
//			return redirect()->back();
			return response()->view( 'custom.404' );

		}

		if ( config( 'app.debug' ) ) {

			if ( $exception->getStatusCode() == '404' ) {

				return redirect()->back();

				return response()->view( 'custom.404' );
			}

//			\Log::error( $exception );
//			return response()->view( 'custom.404' );
		}


		if ( $this->isHttpException( $exception ) ) {

			switch ( $exception->getStatusCode() ) {

				case '404':

					\Log::error( $exception );


					return response()->view( 'custom.404' );
					break;

				case '500':
					\Log::error( $exception );

					return \Response::view( 'custom.500' );
					break;

				default:
					return $this->renderHttpException( $exception );
					break;
			}

		} else {
			return parent::render( $request, $exception );
		}
//		if ( $e instanceof HttpResponseException ) {
//			return $e->getResponse();
//		} elseif ( $e instanceof ModelNotFoundException ) {
//			$e = new NotFoundHttpException( $e->getMessage(), $e );
//		} elseif ( $e instanceof AuthenticationException ) {
//			return $this->unauthenticated( $request, $e );
//		} elseif ( $e instanceof AuthorizationException ) {
//			$e = new HttpException( 403, $e->getMessage() );
//		} elseif ( $e instanceof ValidationException && $e->getResponse() ) {
//			return $e->getResponse();
//		}
//
//		if ( $this->isHttpException( $e ) ) {
//			return $this->toIlluminateResponse( $this->renderHttpException( $e ), $e );
//		} else {
//			return $this->toIlluminateResponse( $this->convertExceptionToResponse( $e ), $e );
//		}

	}
}

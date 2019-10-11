<?php

namespace App\Http;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\Localization;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\StaffMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {
	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = [
		\App\Http\Middleware\SetLocale::class,
		\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
		\Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
//
		\App\Http\Middleware\TrimStrings::class,
		\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
		\App\Http\Middleware\TrustProxies::class,
		\Illuminate\Session\Middleware\StartSession::class,
		\Illuminate\View\Middleware\ShareErrorsFromSession::class,
	];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [
		'web' => [
			\App\Http\Middleware\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
//            \Illuminate\Session\Middleware\StartSession::class,
			// \Illuminate\Session\Middleware\AuthenticateSession::class,
//            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
//            \App\Http\Middleware\VerifyCsrfToken::class,

			\Illuminate\Routing\Middleware\SubstituteBindings::class,
			Localization::class,
		],

		'api' => [
			'throttle:60,1',
			'bindings',
		],
	];

	/**
	 * The application's route middleware.
	 *
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array
	 */

	protected $routeMiddleware = [
		'auth'         => \Illuminate\Auth\Middleware\Authenticate::class,
		'auth.basic'   => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'bindings'     => \Illuminate\Routing\Middleware\SubstituteBindings::class,
		'can'          => \Illuminate\Auth\Middleware\Authorize::class,
		'guest'        => \App\Http\Middleware\RedirectIfAuthenticated::class,
		'throttle'     => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		'jwt.auth'     => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
		'role'         => RoleMiddleware::class,
		'revalidate'   => \App\Http\Middleware\RevalidateBackHistory::class,
		'localization' => Localization::class,
		'superadmin'    => SuperAdminMiddleware::class,
		'admin'         => AdminMiddleware::class,
		'staff'         => StaffMiddleware::class,
	];
}

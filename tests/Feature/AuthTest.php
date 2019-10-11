<?php

namespace Tests\Feature;


use Tests\CreatesApplication;
use Tests\TestCase;

class AuthTest extends TestCase {

	use CreatesApplication;

	public function setUp() {
		parent::setUp();
	}

	/**
	 * The login form can be displayed.
	 *
	 * @return void
	 */
	public function testLoginFormDisplayed() {

		$this->get( route( 'login' ) )
		     ->assertStatus( 200 )
		     ->assertSee( trans( 'common.DCP' ) )
		     ->assertSeeText( trans( 'auth.login_page.signin_text' ) )
		     ->assertSee( trans( 'auth.login_page.email' ) )
		     ->assertSee( trans( 'auth.login_page.password' ) )
		     ->assertSee( trans( 'auth.forgot_your_password' ) )
		     ->assertSee( trans( 'auth.login_page.login' ) )
		     ->assertSee( trans( 'auth.register_now' ) );
	}

	/**
	 * The registration form can be displayed.
	 *
	 * @return void
	 */
	public function testRegisterFormDisplayed() {
		$this->get( route( 'register' ) )
		     ->assertStatus( 200 )
		     ->assertSee( trans( 'common.DCP' ) )
		     ->assertSeeText( trans( 'auth.create_account' ) )
		     ->assertSee( trans( 'auth.first_name' ) )
		     ->assertSee( trans( 'auth.last_name' ) )
		     ->assertSee( trans( 'auth.login_page.email' ) )
		     ->assertSee( trans( 'auth.confirm_password' ) )
		     ->assertSee( trans( 'auth.register' ) );

	}

	/**
	 * Displays the form to reset a password.
	 *
	 * @return void
	 */
	public function testDisplaysPasswordResetForm() {
		$this->get( route( 'password.reset', 'token' ) )
		     ->assertStatus( 200 )
		     ->assertSee( trans( 'common.DCP' ) )
		     ->assertSee( trans( 'auth.enter_new_password' ) )
		     ->assertSee( trans( 'auth.login_page.email' ) )
		     ->assertSee( trans( 'auth.login_page.password' ) )
		     ->assertSee( trans( 'auth.confirm_password' ) )
		     ->assertSee( trans( 'auth.reset_password' ) );
	}

	/**
	 * Displays the form to recover a password.
	 *
	 * @return void
	 */
	public function testDisplaysPasswordRecoverForm() {
		$this->get( route( 'password/recover' ) )
		     ->assertStatus( 200 )
		     ->assertSee( trans( 'auth.enter_email_to_reset_password' ) )
		     ->assertSee( trans( 'auth.login_page.email' ) )
		     ->assertSee( trans( 'auth.send_password_reset_link' ) )
		     ->assertSee( trans( 'auth.login_page.login' ) );
	}

}

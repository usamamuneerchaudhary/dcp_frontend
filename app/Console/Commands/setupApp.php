<?php
/** Copyright (c) 2018-2019 Qualcomm Technologies, Inc.
All rights reserved.
Redistribution and use in source and binary forms, with or without modification, are permitted (subject to the limitations in the disclaimer below) provided that the following conditions are met:
Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
Neither the name of Qualcomm Technologies, Inc. nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
The origin of this software must not be misrepresented; you must not claim that you wrote the original software. If you use this software in a product, an acknowledgment is required by displaying the trademark/log as per the details provided here: https://www.qualcomm.com/documents/dirbs-logo-and-brand-guidelines
Altered source versions must be plainly marked as such, and must not be misrepresented as being the original software.
This notice may not be removed or altered from any source distribution.
NO EXPRESS OR IMPLIED LICENSES TO ANY PARTY'S PATENT RIGHTS ARE GRANTED BY THIS LICENSE. THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.*/
namespace App\Console\Commands;

use Illuminate\Console\Command;

class setupApp extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'setup:app {--composer} {--npm} ';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup basics for application';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {


		$this->info( 'Hey, Welcome to DCP APP!' );
		$this->line( '--------------------------------------------------------------------------------------------------------------' );
		$this->line( '--------------------------------------------------------------------------------------------------------------' );

		if ( $this->confirm( 'Do you wish to create sample .env file?' ) ) {
			$this->comment( 'You can update configurations in your .env later.' );
			$this->line( '--------------------------------------------------------------------------------------------------------------' );
			if ( file_exists( '.env.example' ) ) {
				shell_exec( 'mv .env.example .env' );
			}
		}

		$api_url = $this->ask( 'Please enter your API URL' );
		if ( $this->confirm( 'Do you wish to continue with the selected API URL?' ) ) {
			app( 'config' )->write( [ 'app.api_url' => $api_url ] );
		}

		$this->comment( 'API URL now updated' );

		$this->comment( 'You may change it later in config/app.php' );
		$this->line( '--------------------------------------------------------------------------------------------------------------' );

		$compose_update = $this->option( 'npm' );

		if ( $compose_update ) {
			$this->comment( 'Initializing Node Package Manager' );
			shell_exec( 'npm install' );
			$this->comment( 'Node Dependencies installed Successfully' );
			$this->line( '--------------------------------------------------------------------------------------------------------------' );
		}


		$compose_update = $this->option( 'composer' );

		if ( $compose_update ) {
			$this->comment( 'Initializing Composer' );
			shell_exec( 'composer install' );
			$this->comment( 'Dependencies installed Successfully' );
			$this->line( '--------------------------------------------------------------------------------------------------------------' );
		}

		$this->comment( 'Composer Auto-loading files are being re-generated' );
		shell_exec( 'composer du' );
		$this->comment( 'AutoLoading files Re-generated successfully' );
		$this->line( '--------------------------------------------------------------------------------------------------------------' );

		$this->call( 'cache:clear' );
		$this->comment( 'Application cache cleared successfully' );
		$this->line( '--------------------------------------------------------------------------------------------------------------' );

		$this->call( 'config:clear' );
		$this->comment( 'Application configurations cleared successfully' );
		$this->line( '--------------------------------------------------------------------------------------------------------------' );

		$this->call( 'key:generate' );
		$this->comment( 'Application Key generated successfully' );
		$this->line( '--------------------------------------------------------------------------------------------------------------' );


	}


}

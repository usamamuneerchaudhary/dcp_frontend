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
return [

	/*
	|--------------------------------------------------------------------------
	| Authentication Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are used during authentication for various
	| messages that we need to display to the user. You are free to modify
	| these language lines according to your application's requirements.
	|
	*/


	'forgot_your_password'          => 'Quên mật khẩu?',
	'dont_have_an_account'          => 'Bạn không có tài khoản?',
	'register_now'                  => 'Đăng ký ngay bây giờ',
	'register'                      => 'Ghi danh',
	'first_name'                    => 'Tên đầu tiên',
	'last_name'                     => 'Họ',
	'confirm_password'              => 'Xác nhận mật khẩu',
	'already_have_an_account'       => 'Bạn co săn san để tạo một tai khoản?',
	'reset_password'                => 'Đặt lại mật khẩu',
	'send_password_reset_link'      => 'Gửi Liên kết Đặt lại Mật khẩu',
	'create_account'                => 'Tạo tài khoản DCP của bạn',
	'enter_new_password'            => 'Nhập mật khẩu mới của bạn',
	'enter_email_to_reset_password' => 'Nhập email của bạn để đặt lại mật khẩu',
	'logout'                        => 'đăng xuất',

	'failed'   => 'Những chứng chỉ này không khớp với hồ sơ của chúng tôi.',
	'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

	'login_page'     => [
		'signin_text' => 'Đăng nhập để bắt đầu phiên của bạn',
		'login'       => 'đăng nhập',
		'email'       => 'Địa chỉ email',
		'password'    => 'Mật khẩu'
	],
	'register_form'  => [
		'error'            => 'Biểu mẫu của bạn có lỗi',
		'failed'           => 'Đăng ký thất bại',
		'email'            => 'Hãy kiểm tra email của bạn để kích hoạt tài khoản của bạn',
		'success'          => 'Đăng ký thành công',
		'validation_rules' => [
			'required'                  => [
				'first_name'            => 'Tên là bắt buộc',
				'last_name'             => 'Họ là bắt buộc',
				'email'                 => 'Địa chỉ e-mail là bắt buộc',
				'password'              => 'Mật khẩu là bắt buộc',
				'password_confirmation' => 'Xác nhận mật khẩu là bắt buộc',
				'old_password'          => 'Mật khẩu cũ là bắt buộc'
			],
			'email'                     => 'Vui lòng nhập địa chỉ email hợp lệ',
			'email_validation_regex'    => 'Vui lòng nhập Địa chỉ Email hợp lệ, ví dụ: tên người dùng@3gca.org',
			'password_validation_regex' => 'Vui lòng tạo một mật khẩu mạnh (Mật khẩu phải chứa ít nhất một chữ cái viết hoa / chữ thường, một số và một ký tự đặc biệt)',
			'min_length'                => 'Mật khẩu của bạn phải dài ít nhất 8 ký tự',
			'password'                  => [
				'equal_to' => 'làm ơn hãy nhập mật mã giống như ở trên'
			]
		]
	]
	,
	'password_reset' => [
		'token_mismatch' => 'Mã thông báo không khớp, vui lòng thử lại',
		'success'        => 'Mật khẩu của bạn đã thay đổi thành công, Vui lòng đăng nhập để tiếp tục',
	]


];

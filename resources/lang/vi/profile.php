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

	'profile'      => 'Hồ sơ',
	'user_details' => 'Chi tiết người dùng',
	'edit'         => 'chỉnh sửa',

	'fields' => [
		'first_name'          => 'Tên đầu tiên',
		'last_name'           => 'Họ',
		'email_address'       => 'Địa chỉ email',
		'role'                => 'Vai trò"',
		'old_password'        => 'Mật khẩu cũ',
		'new_password'        => 'mật khẩu mới',
		'retype_new_password' => 'Gõ lại mật khẩu mới',
		'confirm_password'    => 'Xác nhận mật khẩu',
	],

	'buttons' => [

		'edit_details'    => 'Chỉnh sửa chi tiết',
		'change_password' => 'Đổi mật khẩu',
		'back'            => 'trở lại',
		'update'          => 'cập nhật',
		'add'             => 'thêm vào',

	],


	'user_administration' => 'Quản lý người dùng',
	'add_user'            => 'Thêm người dùng',
	'all_users_details'   => 'tất cả chi tiết người dùng',
	'my_activities'       => 'các hoạt động của tôi',

	'tooltips' => [
		'enter_first_name_of_the_user_to_be_Added'                     => 'Nhập tên của người dùng để được thêm vào',
		'enter_last_name_of_the_user_to_be_Added'                      => 'Nhập họ của người dùng được thêm vào',
		'enter_Valid_email_address_of_the_user_to_be_Added'            => 'Nhập địa chỉ email hợp lệ của người dùng được thêm vào',
		'enter_minimum_of_six_digit_password_for_the_user_to_be_Added' => 'Nhập mật khẩu tối thiểu 6 chữ số cho người dùng để được thêm vào',
		're_enter_password_for_the_user_to_be_added'                   => 'Nhập lại mật khẩu cho người dùng được thêm vào',
		'enter_first_name_of_the_user_to_be_edited'                    => 'Nhập tên cho người dùng được chỉnh sửa',
		'enter_last_name_of_the_user_to_be_edited'                     => 'Nhập họ của người dùng cần chỉnh sửa',
		'enter_email_address_of_the_user_to_be_edited'                 => 'Nhập địa chỉ email để người dùng chỉnh sửa',
		'enter_old_password_for_the_user_to_be_edited'                 => 'Nhập mật khẩu cũ để người dùng chỉnh sửa',
		'enter_new_password_for_the_user_to_be_edited'                 => 'Nhập mật khẩu mới để người dùng chỉnh sửa',
		're_enter_new_password_for_the_user_to_be_edited'              => 'Nhập lại Mật khẩu mới cho người dùng được chỉnh sửa',

	],
	'update'   => [
		'edit_dcp_text'     => 'Chỉnh sửa hồ sơ DCP Việt Nam của bạn',
		'edit_dcp_password' => 'Thay đổi mật khẩu DCP Việt Nam của bạn'
	],

	'profile_update' => [
		'updated'                 => 'Thông tin của bạn đã được cập nhật',
		'update_Success'          => 'Cập nhật thành công',
		'password_update'         => 'Bạn đã thay đổi thành công mật khẩu của bạn',
		'password_update_success' => 'Mật khẩu đã thay đổi thành công'
	]


];
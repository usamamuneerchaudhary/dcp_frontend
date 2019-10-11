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

	'users_administration' => 'Quản trị người dùng',
	'users'                => [
		'first_name'                  => 'Tên đầu tiên',
		'last_name'                   => 'Họ',
		'email'                       => 'Địa chỉ email',
		'licenses_information'        => 'Thông tin giấy phép',
		'deactive_title'              => 'Nhấn vào đây để hủy kích hoạt người dùng',
		'active_title'                => 'Nhấn vào đây để kích hoạt Người dùng',
		'edit_title'                  => 'Người dùng biên tập',
		'view_user_licenses'          => 'Xem giấy phép người dùng',
		'add_new'                     => 'Thêm người dùng mới',
		'new_dcp_user'                => 'Thêm người dùng DCP Việt Nam mới',
		'user_deactivated'            => 'Người dùng đã hủy kích hoạt',
		'user_deactivated_success'    => 'Người dùng đã hủy kích hoạt thành công.',
		'user_activated_success'      => 'Người dùng kích hoạt thành công.',
		'user_activated'              => 'Kích hoạt người dùng',
		'are_you_sure_to_delete_user' => 'Bạn có chắc chắn xóa Người dùng này?',
		'user_deleted'                => 'Người dùng đã xóa',
		'user_deleted_successfully'   => 'Người dùng đã xóa thành công.',
		'ok_button_text'              => 'được',

	],

	'licenses' => [

		'head'                         => "Mẫu Thỏa thuận cấp phép người dùng cuối ('Thỏa thuận')",
		'body'                         => "Vui lòng đọc kỹ Thỏa thuận cấp phép người dùng cuối ('Thỏa thuận') này trước khi nhấp vào nút 'Tôi đồng ý', tải xuống hoặc sử dụng Hệ thống xác minh thiết bị ('Ứng dụng'). Bằng cách nhấp vào nút 'Tôi đồng ý', tải xuống hoặc sử dụng Ứng dụng, bạn đồng ý bị ràng buộc bởi các điều khoản và điều kiện của Thỏa thuận này. Nếu bạn không đồng ý với các điều khoản của Thỏa thuận này, đừng nhấp vào nút 'Tôi đồng ý' và không tải xuống hoặc sử dụng Ứng dụng.",
		'license'                      => 'Giấy phép',
		'accept'                       => 'Tôi chấp nhận thỏa thuận cấp phép để tải xuống ứng dụng di động',
		'sr_no'                        => 'Số điện thoại',
		'license_version'              => 'Phiên bản cấp phép',
		'agreed_on'                    => 'Nhất trí về',
		'type'                         => 'Kiểu',
		'enter_license_no_to_be_added' => 'Nhập số giấy phép sẽ được thêm',
		'license_version_format'       => 'Định dạng phiên bản phải giống như 1.0 hoặc 2.1, v.v',
		'enter_license_version'        => 'Nhập phiên bản Giấy phép cho thỏa thuận',
		'license_content'              => 'Nội dung cấp phép',
		'license_required'             => 'Nội dung giấy phép là bắt buộc.',
		'add_agreement'                => 'Thêm thỏa thuận cấp phép'
	],

	'no_license_found'             => 'Không tìm thấy giấy phép',
	'cancel'                       => 'hủy bỏ',
	'imei_verification_text'       => 'Vui lòng xác minh số IMEI bạn đã nhập. Nhấn Tìm kiếm để tiếp tục hoặc Huy Bo để nhập lại',
	'enter_imei_number_text'       => 'Nhập số IMEI 14-16 số',
	'search'                       => 'Tìm kiếm',
	'download_bulk_file_Text'      => 'Tải về tệp mẫu. Xin lưu ý rằng hệ thống chỉ hỗ trợ TXT File &amp; IMEIs nên được phân cách bằng dấu phẩy (,)',
	'browse'                       => 'Duyệt',
	'display_records'              => 'Hiển thị hồ sơ',
	'quick_search_current_results' => 'Tìm kiếm nhanh kết quả hiện tại',

	'table'                           => [
		'user_device'     => 'Thiết bị người dùng',
		'checking_method' => 'Phương pháp kiểm tra',
		'imei_number'     => 'Số IMEI',
		'result'          => 'Kết quả',
		'results_matched' => 'Kết quả phù hợp',
		'user_name'       => 'Tên người dùng',
		'created_at'      => 'dấu thời gian',
		'brand_name'      => 'Tên thương hiệu',
		'model_name'      => 'Tên mô hình',
		'store_name'      => 'Tên mô hình',
		'description'     => 'Sự miêu tả',
		'operations'      => 'Các hoạt động',
		'email_address'   => 'Địa chỉ email',
		'data_time_added' => 'Ngày / giờ được thêm',
		'user_roles'      => 'Vai trò Người dùng',
		'status'          => 'Trạng thái',
		'submit'          => 'Gửi đi',
		'upload_image'    => 'Tải hình lên',
		'address'         => 'Địa chỉ',
		'action'          => 'Hành động',
		'message'         => 'Thông điệp',
		'feedback'        => 'Phản hồi',
		'licenses'        => 'Thông điệp',
		'version'         => 'Phiên bản',
		'created_by'      => 'Được tạo bởi',
		'content'         => 'Nội dung cấp phép',
		'no_data_found'   => 'Không tìm thấy dữ liệu nào',
		'select_role'     => 'Chọn vai trò',
		'admin'           => 'quản trị viên',
		'staff'           => 'Cán bộ',
		'gsma_status'     => 'Tình trạng GSMA'
	],
	'license_agreement_checkbox_text' => 'Tôi chấp nhận thỏa thuận cấp phép để tải ứng dụng di động',
	'download_application'            => 'Tải ứng dụng',
	'counterfiet_details'             => 'Chi tiết counterfiet',

	'results_found' => 'Kết quả tìm thấy',

	'gsma_table'             => [
		'device_id'           => 'ID thiết bị',
		'manufacturer'        => 'nhà chế tạo',
		'equipment_type'      => 'Loại thiết bị',
		'brand_name'          => 'Thương hiệu',
		'model_name'          => 'Tên người mẫu',
		'marketing_name'      => 'Tên tiếp thị',
		'internal_model_name' => 'Tên mẫu nội bộ',
		'tac_approved_date'   => 'Ngày phê duyệt TAC',
		'device_certify_body' => 'Thiết bị xác nhận thân máy',
		'radio_interface'     => 'Giao diện vô tuyến',
		'operating_system'    => 'Hệ điều hành',
		'sim_support'         => 'Hỗ trợ SIM',
		'nfc_support'         => 'Hỗ trợ NFC',
		'bluetooth_support'   => 'Hỗ trợ Bluetooth',
		'wlan_support'        => 'Hỗ trợ WLAN',
	],
	'add_counterfeit_device' => 'Thêm thiết bị giả mạo',
	'all_users_activity'     => 'Tất cả người dùng Hoạt động',
	'my_activities'          => 'Hoạt động của tôi',
	'counterfeit_devices'    => 'Báo cáo giả',
	'matched_devices'        => 'Báo cáo trùng khớp',
	'mis_matched_devices'    => 'Báo cáo sai',
	'system_feedbacks'       => 'Tất cả các phản hồi hệ thống',
	'add_new_license'        => 'Thêm giấy phép mới',


	'report_mobile_phone'               => 'Báo cáo Điện thoại di động?',
	'report_mobile_phn'                 => 'Báo cáo Điện thoại di động',
	'imei_not_found'                    => 'IMEI Không tìm thấy!',
	'are_the_Results_match_your_device' => 'Kết quả phù hợp với thiết bị của bạn?',
	'not_matched'                       => 'Không phù hợp!',

	'supported_formats_Are_png_jpeg_gif' => 'Định dạng được hỗ trợ là .png, .jpg, .jpeg, .gif',

	'tooltips' => [
		'imei_number_should_be_between_14_to_16_digits'             => 'Độ dài số IMEI nên từ 14 đến 16 chữ số',
		'enter_the_valid_brand_name_of_your_device'                 => 'Nhập tên thương hiệu hợp lệ của thiết bị của bạn.',
		'enter_the_valid_store_name_of_your_device'                 => 'Nhập tên cửa hàng hợp lệ của thiết bị của bạn.',
		'enter_the_valid_model_name_of_your_device'                 => 'Nhập tên mô hình hợp lệ của thiết bị của bạn.',
		'enter_the_Valid_address_where_device_is_located'           => 'Nhập địa chỉ hợp lệ nơi thiết bị được đặt.',
		'add_description_for_your_device'                           => 'Thêm mô tả cho thiết bị của bạn',
		'upload_valid_image_file_of_your_device'                    => 'Tải lên tệp hình ảnh hợp lệ của thiết bị của bạn',
		'system_only_supports_txt_files_with_comma_separated_imeis' => 'Hệ thống chỉ hỗ trợ tệp TXT và csv và IMEI nên được phân cách bằng dấu phẩy.',
		'active_user'                                               => 'Nhấn vào đây để kích hoạt người dùng.',
		'deactive_user'                                             => 'Nhấn vào đây để hủy kích hoạt người dùng.',
		'edit_user'                                                 => 'Chỉnh sửa người dùng này.',
		'delete_user'                                               => 'Xóa người dùng này.',
		'view_license'                                              => 'Xem giấy phép này.',
	],

	'buttons' => [
		'yes' => 'Vâng',
		'no'  => 'Không'
	],

	'datatable_search' => [
		'all_matched_devices'     => 'Tìm kiếm tất cả các thiết bị phù hợp',
		'all_user_activities'     => 'Tìm kiếm tất cả các hoạt động của người dùng',
		'my_activities'           => 'Tìm kiếm hoạt động của tôi',
		'all_mismatched_devices'  => 'Tìm kiếm tất cả các thiết bị phù hợp với Mis',
		'all_counterfeit_devices' => 'Tìm kiếm tất cả các thiết bị giả',
		'all_feedbacks'           => 'Tìm kiếm tất cả thông tin phản hồi',
		'all_licenses'            => 'Tìm kiếm tất cả thông tin phản hồi',
		'users'                   => 'Tìm kiếm tất cả người dùng',
		'imei_search'             => 'Tìm kiếm số IMEI'
	],

	'export_text' => [
		'export_activity_logs'    => 'Xuất nhật ký hoạt động',
		'export_counterfeit_logs' => 'Xuất nhật ký giả'
	],

	'feedbacks'         => [
		'mark_as_read'    => 'Chưa đọc',
		'marked_as_read'  => 'Đọc',
		'marked_success'  => 'Phản hồi được đánh dấu là đã đọc thành công',
		'feedback'        => 'Phản hồi',
		'submit_feedback' => 'Gửi phản hồi',
		'required_field'  => 'Lĩnh vực này là bắt buộc.'
	],
	'counter_datatable' => [
		'view_counterfeit'            => 'Xem hàng giả này',
		'delete_countrefeit'          => 'xóa hàng giả này',
		'sure_to_delete_counterfeit'  => 'Bạn có chắc chắn xóa Bản ghi giả này không?',
		'counterfeit_deleted'         => 'Đã xóa hàng giả',
		'counterfeit_deleted_success' => 'Đã xóa hàng giả thành công.',

	],
	'404_page'          => [
		'page_not_found' => 'Không tìm thấy trang',
		'whoops_message' => 'Rất tiếc !! có vẻ như đã xảy ra sự cố Trang bạn đang cố truy cập không tồn tại hoặc không truy cập được.',
		'back_staff'     => 'Quay lại hồ sơ',
		'back_admin'     => 'Quay lại Bảng điều khiển'

	],
	'counterfeit_form'  => [
		'validation_rules' => [
			'required' => [
				'brand_name'  => 'Tên thương hiệu là bắt buộc',
				'model_name'  => 'Tên mẫu là bắt buộc',
				'store_name'  => 'Tên cửa hàng là bắt buộc',
				'address'     => 'Địa chỉ là bắt buộc',
				'description' => 'Mô tả là bắt buộc',
			],
			'image'    => [
				'file_size_title'          => 'Tệp quá lớn',
				'file_size_description'    => 'Các tệp được tải lên không thể lớn hơn 20 MB',
				'image_limit_text'         => 'Vượt quá giới hạn hình ảnh tối đa',
				'image_limit_description'  => 'Chỉ có thể chọn 5 hình ảnh cho mỗi báo cáo',
				'format_error_text'        => 'Định dạng không được hỗ trợ',
				'format_error_description' => 'Các định dạng được hỗ trợ là .png, .jpg, .jpeg, .gif'
			]
		]
	],

];
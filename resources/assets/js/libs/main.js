///**
//  * SPDX-License-Identifier: BSD-4-Clause-Clear
//
// Copyright (c) 2018-2019 Qualcomm Technologies, Inc.
//
// All rights reserved.
//
// Redistribution and use in source and binary forms, with or without modification, are permitted (subject to the
// limitations in the disclaimer below) provided that the following conditions are met:
//
// - Redistributions of source code must retain the above copyright notice, this list of conditions and the following
// disclaimer.
// - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the
// following disclaimer in the documentation and/or other materials provided with the distribution.
// - All advertising materials mentioning features or use of this software, or any deployment of this software,
// or documentation accompanying any distribution of this software, must display the trademark/logo as per the
// details provided here: https://www.qualcomm.com/documents/dirbs-logo-and-brand-guidelines
// - Neither the name of Qualcomm Technologies, Inc. nor the names of its contributors may be used to endorse or
// promote products derived from this software without specific prior written permission.
//
//
//
// SPDX-License-Identifier: ZLIB-ACKNOWLEDGEMENT
//
// Copyright (c) 2018-2019 Qualcomm Technologies, Inc.
//
// This software is provided 'as-is', without any express or implied warranty. In no event will the authors be held liable
// for any damages arising from the use of this software. Permission is granted to anyone to use this software for any
// purpose, including commercial applications, and to alter it and redistribute it freely, subject to the following
// restrictions:
//
// - The origin of this software must not be misrepresented; you must not claim that you wrote the original software.
// If you use this software in a product, an acknowledgment is required by displaying the trademark/logo as per the
// details provided here: https://www.qualcomm.com/documents/dirbs-logo-and-brand-guidelines
// - Altered source versions must be plainly marked as such, and must not be misrepresented as being the original
// software.
// - This notice may not be removed or altered from any source distribution.
//
// NO EXPRESS OR IMPLIED LICENSES TO ANY PARTY'S PATENT RIGHTS ARE GRANTED BY THIS LICENSE. THIS SOFTWARE IS PROVIDED BY
// THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
// THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
// COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
// DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR
// BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
// (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
// POSSIBILITY OF SUCH DAMAGE.
//  */
// IE 10 only
var b = document.documentElement;
b.setAttribute('data-useragent', navigator.userAgent);
b.setAttribute('data-platform', navigator.platform);

// IE 10 == Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)

$(document).ready(function () {
    //  Activate the tooltips
    $('[rel="tooltip"]').tooltip();


    $('#imeiField').keyup(function () {
        var val = this.value;
        var length = val.length;
        // console.log(length);
        // var thetext = $(this).val();
        if (length >= 14) {
            $('#subBtn').removeAttr('disabled');
        } else {
            $('#subBtn').attr('disabled', 'disabled');
        }
    });

    var onlyIEorEdge = navigator.appName == 'Microsoft Internet Explorer' || (navigator.appName == "Netscape" && navigator.appVersion.indexOf('Edge') > -1) || (navigator.appName == "Netscape" && navigator.appVersion.indexOf('Trident') > -1);
    if (onlyIEorEdge == true) {
        $('#inputImeiField').keyup(function () {
            var val = this.value;
            var length = val.length;
            if (length >= 14) {
                $('.btn[type="submit"]').removeAttr('disabled');
            } else {
                $('.btn[type="submit"]').attr('disabled', 'disabled');
            }
        });
    }

    $('#imeiform').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    // $("#app-checkbox input:checkbox").change(function () {
    //     var ischecked = $(this).is(':checked');
    //     if (ischecked) {
    //         $(".app-btn").css("display", "block")
    //     } else {
    //         $(".app-btn").css("display", "none")
    //     }
    // });

    $("#license-checkbox input:checkbox").change(function () {
        var ischecked = $(this).is(':checked');
        // console.log(ischecked);
        if (ischecked) {
            $(".license-btn").css("display", "block")
        } else {
            $(".license-btn").css("display", "none")
        }
    });

    $('#counterImgUpload').checkFileType({
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        success: function () {

        },
        error: function () {
            var flen = $('#counterImgUpload')[0].files.length;
            if (flen > 0) {
                if (navigator.appVersion.indexOf("MSIE 10") !== -1) {
                } else {
                    swal({
                        title: trans('pages.counterfeit_form.validation_rules.image.format_error_text'),
                        text: trans('pages.counterfeit_form.validation_rules.image.format_error_description'),
                        type: "error",
                        confirmButtonColor: "#004590",
                        confirmButtonText: "Ok"
                    });
                }

                var $el = $("#counterImgUpload");
                $el.wrap('<form>').closest('form').get(0).reset();
                $el.unwrap();
            }
        }
    });

    $('#counterImgUpload').change(function () {
        var flen = $('#counterImgUpload')[0].files.length;
        if (flen > 5) {
            swal({
                title: trans('pages.counterfeit_form.validation_rules.image.image_limit_text'),
                text: trans('pages.counterfeit_form.validation_rules.image.image_limit_description'),
                type: "error",
                confirmButtonColor: "#004590",
                confirmButtonText: "Ok"
            });
            var $el = $("#counterImgUpload");
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();

        }

    });

    $('#counterBtn').click(function (e) {
        //check whether browser fully supports all File API
        if (window.File && window.FileReader && window.FileList && window.Blob) {

            // var extension = $('#counterImgUpload')[0].val().split('.').pop().toLowerCase();
            // console.log(extension);
            // if ($.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) === -1) {
            //     alert('Sorry, invalid extension.');
            //     return false;
            // }

            // var control = document.getElementById("counterImgUpload");
            // control.addEventListener("change", function(event) {
            //     // When the control has changed, there are new files
            //     var files = control.files
            //         for (var i = 0; i < files.length; i++) {
            //         console.log("Filename: " + files[i].name);
            //         console.log("Type: " + files[i].type);
            //         console.log("Size: " + files[i].size + " bytes");
            //     }
            // }, false);


            var flen = $('#counterImgUpload')[0].files.length;
            if (flen > 0) {
                var fsize = $('#counterImgUpload')[0].files[0].size / 1024 / 1024;
            }
            // var ftype = $('#counterImgUpload')[0].files[0]
            // console.log(ftype);
            // if($.inArray(ftype, ['gif', 'png', 'jpg', 'jpeg']) === -1){
            //
            //     e.preventDefault();
            //     swal({
            //         title: trans('pages.counterfeit_form.validation_rules.image.file_size_title'),
            //         text: trans('pages.counterfeit_form.validation_rules.image.file_size_description'),
            //         type: "error",
            //         confirmButtonColor: "#004590",
            //         confirmButtonText: "Ok"
            //     })
            //
            // }


            if (fsize > 20) { //do something if file size more than 1 mb (1048576)
                e.preventDefault();
                swal({
                    title: trans('pages.counterfeit_form.validation_rules.image.file_size_title'),
                    text: trans('pages.counterfeit_form.validation_rules.image.file_size_description'),
                    type: "error",
                    confirmButtonColor: "#004590",
                    confirmButtonText: "Ok"
                })
            }
        } else {
            alert("Please upgrade your browser, because your current browser lacks some new features we need!");
        }


    });

    //regex for password:
    $.validator.addMethod('password_validation_regex', function (value) {
        var reg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/;
        return reg.test(value);   //
    });

    // regex for email like :
    $.validator.addMethod('email_validation_regex', function (value) {
        var reg = /(.*)@3gca\.org$/;
        return reg.test(value);   //
    });

    $("#update-user-form-super").validate({
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent().parent());
        },
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email: {
                required: true,
                email_validation_regex: true,
                email: true
            },

        },
        messages: {
            first_name: {
                required: trans('auth.register_form.validation_rules.required.first_name')
            },
            last_name: {
                required: trans('auth.register_form.validation_rules.required.last_name')
            },
            email: {
                required: trans('auth.register_form.validation_rules.required.email'),
                email: trans('auth.register_form.validation_rules.email'),
                email_validation_regex: trans('auth.register_form.validation_rules.required.email_validation_regex')
            },

        }
    });

    $("#register-form,#create-user-form").validate({
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent().parent());
        },
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email: {
                required: true,
                email_validation_regex: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8,
                password_validation_regex: true
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
        },
        messages: {
            first_name: {
                required: trans('auth.register_form.validation_rules.required.first_name')
            },
            last_name: {
                required: trans('auth.register_form.validation_rules.required.last_name')
            },
            email: {
                required: trans('auth.register_form.validation_rules.required.email'),
                email: trans('auth.register_form.validation_rules.email'),
                email_validation_regex: trans('auth.register_form.validation_rules.required.email_validation_regex')
            },
            password: {
                required: trans('auth.register_form.validation_rules.required.password'),
                password_validation_regex: trans('auth.register_form.validation_rules.password_validation_regex'),
                minlength: trans('auth.register_form.validation_rules.min_length')
            },
            password_confirmation: {
                required: trans('auth.register_form.validation_rules.required.password_confirmation'),
                minlength: trans('auth.register_form.validation_rules.min_length'),
                equalTo: trans('auth.register_form.validation_rules.password.equal_to')

            }

        }
    });

    $(".password-edit").validate({
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent().parent());
        },
        rules: {
            old_password: {
                required: true,
            },
            password: {
                required: true,
                minlength: 8,
                password_validation_regex: true
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
        },
        messages: {
            old_password: {
                required: trans('auth.register_form.validation_rules.required.old_password'),
            },
            password: {
                required: trans('auth.register_form.validation_rules.required.password'),
                password_validation_regex: trans('auth.register_form.validation_rules.password_validation_regex'),
                minlength: trans('auth.register_form.validation_rules.min_length'),
            },
            password_confirmation: {
                required: trans('auth.register_form.validation_rules.required.password_confirmation'),
                minlength: trans('auth.register_form.validation_rules.min_length'),
                equalTo: trans('auth.register_form.validation_rules.password.equal_to'),

            }

        }
    });

    $("#PswdResetForm").validate({
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent().parent());
        },
        rules: {
            email: {
                required: true,
                email: true,
                email_validation_regex: true,
            },
            password: {
                required: true,
                minlength: 8,
                password_validation_regex: true
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
        },
        messages: {
            email: {
                required: trans('auth.register_form.validation_rules.required.email'),
                email: trans('auth.register_form.validation_rules.email'),
                email_validation_regex: trans('auth.register_form.validation_rules.email_validation_regex'),

            },
            password: {
                required: trans('auth.register_form.validation_rules.required.password'),
                password_validation_regex: trans('auth.register_form.validation_rules.password_validation_regex'),
                minlength: trans('auth.register_form.validation_rules.min_length'),
            },
            password_confirmation: {
                required: trans('auth.register_form.validation_rules.required.password_confirmation'),
                minlength: trans('auth.register_form.validation_rules.min_length'),
                equalTo: trans('auth.register_form.validation_rules.password.equal_to'),

            }

        }
    });

    $("#counterForm").validate({

        errorPlacement: function (error, element) {
            error.insertAfter(element.parent().parent());
        },
        rules: {
            brand_name: {
                required: true,
            },
            model_name: {
                required: true,
            },
            description: {
                required: true,
            },
            address: {
                required: true,
            },
            store_name: {
                required: true,
            },

        },
        messages: {
            brand_name: {
                required: trans('pages.counterfeit_form.validation_rules.required.brand_name'),
            },
            model_name: {
                required: trans('pages.counterfeit_form.validation_rules.required.model_name'),
            },
            store_name: {
                required: trans('pages.counterfeit_form.validation_rules.required.store_name'),
            },
            address: {
                required: trans('pages.counterfeit_form.validation_rules.required.address'),
            },
            description: {
                required: trans('pages.counterfeit_form.validation_rules.required.description'),
            },


        }
    });

    $(".submitImei").click(function () {
        var inputOne = $("#imeiField");
        var inputTwo = $("#inputImeiField");
        inputTwo.val(inputOne.val());
    })
});

(function ($) {
    $.fn.checkFileType = function (options) {

        var defaults = {
            allowedExtensions: [],
            success: function () {
            },
            error: function () {
            }
        };
        options = $.extend(defaults, options);

        return this.each(function () {

            $(this).on('change', function () {
                var value = $(this).val(),
                    file = value.toLowerCase(),
                    extension = file.substring(file.lastIndexOf('.') + 1);

                if ($.inArray(extension, options.allowedExtensions) == -1) {
                    options.error();
                    $(this).focus();
                } else {
                    options.success();

                }

            });

        });

    };

})(jQuery);
$(function () {

    $('.inputFile').uniform();
    $(document).on('change', 'input[type=file].inputFile', function () {
        var $input = $(this),
            filenames = $.map($input[0].files, function (file) {
                return file.name;
            });

        if (filenames.length) {

            if (navigator.appVersion.indexOf("MSIE 10") !== -1) {
                console.log(filenames.join('\n'));
                $input.parent().find('.filename').html(filenames.join('\n'));
            } else {
                $input.siblings('.filename').html(filenames.join('<br>'));
            }

        } else {
            $input.siblings('.filename').html('No file selected');
        }
    });


});

var addSerialNumber = function () {
    $('.table_srno tbody tr').each(function (index) {
        $(this).find('td:nth-child(1)').html(index + 1);
    });
};

addSerialNumber();
$(document).ajaxStop(function () {
    window.location.reload();
});





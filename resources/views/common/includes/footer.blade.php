
</div>
</div>
<script>
    var token =
            {!! json_encode(\Session::get('token')) !!}
    var Jwttoken =
            {!! json_encode(\Session::get('token')) !!}
    var csrf_token =
            {!! json_encode(csrf_token()) !!}
    var locale = {!! json_encode(\App::getLocale()) !!}

            var translations = {!! \Cache::get('translations') !!};

</script>



<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/all.js') }}"></script>

@if(request()->is(
App::getLocale().'/admin/imei',
App::getLocale().'/admin/imei/*',
App::getLocale().'/staff/imei',
App::getLocale().'/staff/imei/*',
App::getLocale().'/super-admin/imei',
App::getLocale().'/super-admin/imei/*'

))

    <script>

        $(window).on('load', function () {
            $('#myModal').modal('show');
            $('#notMatchModal').modal('show');
        });

    </script>


@endif

@if(request()->is([
App::getLocale().'/super-admin/license-agreements/create']))
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script>

        $(document).ready(function () {
            var summerNoteEle = $('#licenseagreement');
            var max = 1000;
            summerNoteEle.summernote(
                {
                    toolbar: [
                        // [groupName, [list of button]]
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']]
                    ],
                    height: 250,   //set editable area's height

                    callbacks: {
                        onChange: function (contents, $editable) {
                            // Note that at this point, the value of the `textarea` is not the same as the one
                            // you entered into the summernote editor, so you have to set it yourself to make
                            // the validation consistent and in sync with the value.
                            summerNoteEle.val(summerNoteEle.summernote('isEmpty') ? "" : contents);

                            // You should re-validate your element after change, because the plugin will have
                            // no way to know that the value of your `textarea` has been changed if the change
                            // was done programmatically.
                            summernoteValidator.element(summerNoteEle);
                        },
                        onKeydown: function (e) {
                            var t = e.currentTarget.innerText;
                            if (t.trim().length >= max) {
                                //delete key
                                if (e.keyCode != 8)
                                    e.preventDefault();
                                // add other keys ...
                                if (e.keyCode === 32)
                                    e.preventDefault();
                            }
                        },
                        onKeyup: function (e) {
                            var t = e.currentTarget.innerText;
                            if (typeof callbackMax == 'function') {
                                callbackMax(max - t.trim().length);
                            }
                        },
                        onPaste: function (e) {
                            var t = e.currentTarget.innerText;
                            var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                            e.preventDefault();
                            var all = t + bufferText;
                            document.execCommand('insertText', false, all.trim().substring(0, 20000));
                            if (typeof callbackMax == 'function') {
                                callbackMax(max - t.length);
                            }
                        }
                    }

                }
            );

            $.validator.addMethod(
                "regex",
                function (value, element, regexp) {
                    var check = false;
                    return this.optional(element) || regexp.test(value);
                },
                ""
            );

            var summernoteValidator = $('#formCreateLicense').validate({
                errorElement: "div",
                //errorClass: 'is-invalid',
                //validClass: 'is-valid',
                ignore: ':hidden:not(#licenseagreement),.note-editable',
                errorPlacement: function (error, element) {
                    // Add the `help-block` class to the error element
                    error.addClass("form-error");
                    //console.log(element);
                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.siblings("label").parent());
                    } else if (element.hasClass("licenseagreement")) {
                        error.insertAfter(element.siblings(".note-editor").parent());
                    } else {
                        error.insertAfter(element.parent());
                    }
                },
                rules: {
                    version: {
                        required: true,
                        minlength: 3,
                        maxlength: 8,
                        regex: /^(\d+\.)?(\d+)$/
                    },
                    licenseAgreementContent: {
                        required: true,
                        maxlength: 20000,
                    }
                },
                messages: {
                    version: {
                        required: '{{trans("validation.forms.license_version_is_required")}}',
                        minlength: '{{trans("validation.forms.version_no_min_charater")}}',
                        maxlength: '{{trans("validation.forms.version_no_max_charater")}}',
                        regex: '{{trans("validation.forms.version_no_format")}}'
                    },
                    licenseAgreementContent: {
                        required: '{{trans("validation.forms.license_content_required")}}',
                        maxlength: '{{trans("validation.forms.license_content_max_charater")}}',
                    }
                }
            });

        });
    </script>
@endif

@if(request()->is([
App::getLocale().'/staff/feedback']))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script>
        $('#feedbackForm').validate({
            errorElement: "div",
            errorClass: 'is-invalid',
            errorPlacement: function (error, element) {
                error.addClass("help-block");
                error.insertAfter(element.parent());
            },
            rules: {
                message: {
                    required: true,
                    maxlength: 255,
                }
            },
            messages: {
                message: {
                    required: '{{trans("validation.forms.this_field_required")}}',
                    maxlength: '{{trans("validation.forms.message_max_charater")}}',
                }
            }
        });
    </script>
@endif

@include('sweet::alert')
@if(request()->is([
App::getLocale().'/super-admin']) || request()->is([
App::getLocale().'/admin']))
    <script>
        var map1, map2, heatmap1, heatmap2;

        function initMap() {
            map1 = new google.maps.Map(document.getElementById('imeiMap'), {
                zoom: 1,
                center: {lat: 0, lng: 0},
                mapTypeId: 'roadmap'
            });

            heatmap1 = new google.maps.visualization.HeatmapLayer({
                data: getIMEIPoints(),
                map: map1
            });
//        console.log(getIMEIPoints());

            map2 = new google.maps.Map(document.getElementById('counterfeitMap'), {
                zoom: 1,
                center: {lat: 0, lng: 0},
                mapTypeId: 'roadmap'
            });

            heatmap2 = new google.maps.visualization.HeatmapLayer({
                data: getCounterfeitPoints(),
                map: map2
            });

        }

        function getIMEIPoints() {

            var data =
                    {!!  json_encode($users_activity['latLongIMEIHeatMapSearches']) !!}

            var mapHeat = [];
            for (var i = 0; i < data.length; i++) {
                mapHeat[i] = new google.maps.LatLng(data[i].latitude, data[i].longitude);
            }
            return mapHeat;

        }

        function getCounterfeitPoints() {

            var data =
                    {!!  json_encode($users_activity['counterfeitHeatMapSearches']) !!}

            var mapHeat = [];
            for (var i = 0; i < data.length; i++) {
                mapHeat[i] = new google.maps.LatLng(data[i].latitude, data[i].longitude);
            }
            return mapHeat;
        }

        // Charts
        var line_ctx = document.getElementById('lineChart').getContext('2d');
        var pie_ctx = document.getElementById('pieChart').getContext('2d');
        var lineChartData = {!! json_encode($line_chart) !!};
        var pieChartData = {!! json_encode($pie_chart) !!};
        var lineChart = new Chart(line_ctx, lineChartData);
        var pieChart = new Chart(pie_ctx, pieChartData);

    </script>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaHnpfARH9tMBMUJo0AU4BrYJoChU90BY&libraries=visualization&callback=initMap"></script>
    @endif
    </body>
    </html>
{{--/** Copyright (c) 2018-2019 Qualcomm Technologies, Inc.
All rights reserved.
Redistribution and use in source and binary forms, with or without modification, are permitted (subject to the limitations in the disclaimer below) provided that the following conditions are met:
Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
Neither the name of Qualcomm Technologies, Inc. nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
The origin of this software must not be misrepresented; you must not claim that you wrote the original software. If you use this software in a product, an acknowledgment is required by displaying the trademark/log as per the details provided here: https://www.qualcomm.com/documents/dirbs-logo-and-brand-guidelines
Altered source versions must be plainly marked as such, and must not be misrepresented as being the original software.
This notice may not be removed or altered from any source distribution.
NO EXPRESS OR IMPLIED LICENSES TO ANY PARTY'S PATENT RIGHTS ARE GRANTED BY THIS LICENSE. THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.*/--}}
<div id="notMatchModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title"><i
                            class="fa fa-exclamation-circle"></i>&nbsp;<strong>{{$notMatchedImei}}</strong>
                    {{trans('pages.not_matched')}}
                </h1>
            </div>
            {{ Form::open(array( 'action' => '\App\Http\Controllers\Admin\CounterfietDevicesController@report', 'method' => 'post' ,'files'=>'true', 'enctype'=>'multipart/form-data','id' => 'counterForm')) }}
            <div class="modal-body">
                <h4>
                    <strong>
                        {{trans('pages.report_mobile_phn')}}
                    </strong>
                </h4>
                {{csrf_field()}}
                {{--IMEI Field--}}
                <input type="hidden" value="{{$notMatchedImei}}" name="imei_number">
                {{--IMEI Field --- END--}}
                <div class="row">
                    <div class="col-xs-6">
                        {{--Brand name field--}}
                        <div class="form-group">
                            <div class="inputbox ion-control">

                                <i class="ion material-icons" rel="tooltip"
                                   title="{{trans('pages.tooltips.enter_the_valid_brand_name_of_your_device')}}">help_outline</i>

                                {{ Form::text('brand_name', '', array('class' => 'form-control','required', 'autocomplete' => 'off', 'placeholder' => trans('pages.table.brand_name'))) }}
                            </div>
                            @if ($errors->has('brand_name'))
                                <span class="help-block"><strong>{{ $errors->first('brand_name') }}</strong></span>
                            @endif
                        </div>
                        {{--Brand Name Field --- END--}}
                    </div>
                    <div class="col-xs-6">
                        {{--Model Name field--}}
                        <div class="form-group">

                            <div class="inputbox ion-control">
                                <i class="ion material-icons" rel="tooltip"
                                   title="{{trans('pages.tooltips.enter_the_valid_model_name_of_your_device')}}">help_outline</i>
                                {{ Form::text('model_name', '', array('class' => 'form-control','required', 'autocomplete' => 'off', 'placeholder' => trans('pages.gsma_table.model_name'))) }}
                            </div>
                            @if ($errors->has('model_name'))
                                <span class="help-block"><strong>{{ $errors->first('model_name') }}</strong></span>
                            @endif
                        </div>
                        {{--Model Name field --- END --}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        {{--Store Name Field--}}
                        <div class="form-group">

                            <div class="inputbox ion-control">
                                <i class="ion material-icons" rel="tooltip"
                                   title="{{trans('pages.tooltips.enter_the_valid_store_name_of_your_device')}}">help_outline</i>
                                {{ Form::text('store_name', '', array('class' => 'form-control','required', 'autocomplete' => 'off', 'placeholder' => trans('pages.table.store_name'))) }}
                            </div>
                            @if ($errors->has('store_name'))
                                <span class="help-block"><strong>{{ $errors->first('store_name') }}</strong></span>
                            @endif
                        </div>
                        {{--Store Name Field ---END --}}
                    </div>
                    <div class="col-xs-6">
                        {{--Address field--}}
                        <div class="form-group">

                            <div class="inputbox ion-control">

                                <i class="ion material-icons" rel="tooltip"
                                   title="{{trans('pages.tooltips.enter_the_Valid_address_where_device_is_located')}}">help_outline</i>

                                {{ Form::text('address', '', array('class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => trans('pages.table.address'))) }}
                            </div>
                            @if ($errors->has('address'))
                                <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
                            @endif
                        </div>
                        {{--Address field --- END --}}
                    </div>

                </div>

                <div class="row">
                    <div class="col-xs-12">
                        {{--Description Field--}}
                        <div class="form-group">

                            <div class="inputbox ion-control">

                                <i class="ion material-icons" rel="tooltip"
                                   title="{{trans('pages.tooltips.add_description_for_your_device')}}">help_outline</i>
                                {{ Form::textarea('description', '', array('class' => 'form-control','required', 'autocomplete' => 'off', 'rows' => '3', 'placeholder' => trans('pages.table.description'))) }}
                            </div>
                            @if ($errors->has('description'))
                                <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
                            @endif
                        </div>
                        {{--Description Field --- END--}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        {{--File Field --}}
                        <div class="form-group file-field">

                            <div class="inputbox ion-control uploadbox">

                                <i class="ion material-icons" rel="tooltip"
                                   title="{{trans('pages.tooltips.upload_valid_image_file_of_your_device')}}">help_outline</i>

                                <input class="inputFile" type="file" name="counterImage[]" id="counterImgUpload"
                                       accept="image/*" multiple>
                            </div>

                            <p class="infor"><span
                                        class="asterisk">*</span> {{trans('pages.supported_formats_Are_png_jpeg_gif')}}
                            </p>

                        </div>
                        {{--File Feild --- END --}}
                    </div>
                </div>
            </div>
            <div class="modal-footer singleBtn">
                {{ Form::submit(trans('pages.table.submit'), array('class' => 'btn blue-btn','id'=>'counterBtn')) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>


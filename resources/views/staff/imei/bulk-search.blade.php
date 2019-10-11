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
@extends('common.layouts.base')
@section('content')
    @include('common.partials.nav')
        <div class="content">
            <div class="container-fluid">
                @include('layouts.partials.alerts')
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h1><i class="material-icons">subject</i>
                            @if(request()->is('en/*'))
                                Bulk IMEI Search
                            @elseif(request()->is('vi/*'))
                                {{trans('dashboard.bulk_imei_search',[],'vi')}}
                            @endif
                        </h1>
                    </div>
                    <div class="card-content" ptb30>
                        @if(request()->is('en/*'))
                            <p>Download the <a href="{{asset('bulk_test.txt')}}" download>Sample File</a>. Please note that the system only supports TXT File &amp; IMEIs should be separated by comma(,).<i class="material-icons" rel="tooltip" title="System only supports TXT and csv files & IMEIs should be separated by commas.">help_outline</i>
                            </p>
                        @elseif(request()->is('vi/*'))
                            <p>{{trans('pages.download_bulk_file_Text',[],'vi')}} <i class="material-icons" rel="tooltip" title="{{trans('pages.tooltips.system_only_supports_txt_files_with_comma_separated_imeis',[],'vi')}}">help_outline</i>
                            </p>
                        @endif

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                @if(request()->is('en/*'))
                                    {{ Form::open(array('url' => 'en/staff/imei-bulk-lookup','files'=>'true','enctype'=>'multipart/form-data')) }}
                                @elseif(request()->is('vi/*'))
                                    {{ Form::open(array('url' => 'vi/staff/imei-bulk-lookup','files'=>'true','enctype'=>'multipart/form-data')) }}
                                @endif
                                {{csrf_field()}}
                                <div class="form-group">
                                    <div class="inputbox ion-control">
                                        @if(request()->is('en/*'))
                                            <i class="ion material-icons" rel="tooltip" title="Upload valid image file of your device">live_help</i>
                                        @elseif(request()->is('vi/*'))
                                            <i class="ion material-icons" rel="tooltip" title="{{trans('pages.tooltips.upload_valid_image_file_of_your_device',[],'vi')}}">live_help</i>
                                        @endif
                                        <div class="uploadbox">
                                            <input class="inputFile" type="file" name="imei" id="imeiFileUpload" accept="text/plain,application/csv">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                    @if(request()->is('en/*'))
                                        {{ Form::submit('Search', array('class' => 'btn blue-btn',
                                    'onClick'=>'return empty()')) }}
                                    @elseif(request()->is('vi/*'))
                                        {{ Form::submit(trans('pages.search',[],'vi'), array('class' => 'btn blue-btn',
                                        'onClick'=>'return empty()')) }}
                                    @endif
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('common.partials.footer')
    </div>
@endsection
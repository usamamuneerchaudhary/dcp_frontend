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
	<?php

	$user = \Session::get( 'user' );
	?>
    <div class="content">
        <div class="container-fluid">
            @include('common.partials.nav')
            <div class="col-lg-12 col-md-6 col-sm-6 margin-logo">
                <h1><i class="fa fa-search"></i>
                    @if(request()->is('en/*'))
                        IMEI Search
                    @elseif(request()->is('vi/*'))
                        {{trans('dashboard.imei_search',[],'vi')}}
                    @endif
                </h1>

                {{ Form::open(array('route' => 'admin.imei','name'=>'imei-form','id'=>'imeiform','onsubmit' => 'return submit()')) }}
                {{csrf_field()}}
                <div class="form-group is-focused">
                    @if(request()->is('en/*'))
                        {{ Form::label('imei', 'Enter 14-16 digit IMEI Number') }}
                        <i class="fa fa-question-circle-o"
                           title="IMEI number length should be between 14 to 16 digits."></i>

                    @elseif(request()->is('vi/*'))
                        {{ Form::label('imei', trans('pages.enter_imei_number_text',[],'vi')) }}
                        <i class="fa fa-question-circle-o"
                           title="IMEI number length should be between 14 to 16 digits."></i>
                    @endif
                    {{ Form::text('imei', '', array('class' => 'form-control','maxlength'=>'16','minlength'=>'14' ,'pattern' => '[0-9.]+','id'=> 'imeiField','onkeypress'=>'return isNumberKey(event)','autofocus'=>'focused','autocomplete'=>'off')) }}

                </div>
                @if(request()->is('en/*'))
                    {{ Form::submit('Search', array('class' => 'btn btn-primary blue-btn submitImei','onClick'=>'return empty()','id'=>'subBtn','disabled')) }}
                @elseif(request()->is('vi/*'))
                    {{ Form::submit(trans('pages.search',[],'vi'), array('class' => 'btn btn-primary blue-btn submitImei','onClick'=>'return empty()','id'=>'subBtn','disabled')) }}
                @endif


                {{ Form::close() }}

                @if(isset($imei))
                    @include('common.partials.not-matched-modal')
                @endif

            </div>
        </div>

    </div>


@endsection
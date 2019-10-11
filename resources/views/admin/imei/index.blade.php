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
@section('title',trans('titles.admin.imei_search'))
@section('content')
    <div id="app">
        @include('common.partials.nav')
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header" data-background-color="sitebg">
                        <h1><i class="material-icons">search</i>
                            {{trans('dashboard.imei_search')}}
                        </h1>
                    </div>
                    <div class="card-content">

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                {{ Form::open(array('url' => App::getLocale().'/admin/imei','name'=>'imei-form','id'=>'imeiform','onsubmit' => 'return submit()')) }}
                                {{csrf_field()}}
                                <div class="form-group">
                                    {{ Form::label('imei', trans('pages.enter_imei_number_text')) }}
                                    <div class="inputbox ion-control">

                                        <i class="ion material-icons" rel="tooltip"
                                           title="{{trans('pages.tooltips.imei_number_should_be_between_14_to_16_digits')}}">search</i>

                                        {{ Form::text('inputImei', '', array('class' => 'form-control input-lg','maxlength'=>'16','minlength'=>'14' ,'pattern' => '[0-9.]+','id'=> 'imeiField','onkeypress'=>'return isNumberKey(event)','autofocus'=>'focused','autocomplete'=>'off')) }}
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                    {{ Form::button((trans('pages.search')), array('class' => 'btn blue-btn submitImei','onClick'=>'return empty()','id'=>'subBtn','disabled','data-toggle'=>'modal','data-target'=>'#imeiSModal')) }}
                                </div>
                                <!-- Modal -->
                                @include('admin.imei.partials.confirmation_modal')
                            <!-- /Modal -->
                                {{ Form::close() }}
                            </div>
                        </div>
                        @if(isset($all_data))
                            <h2>
                                {{trans('pages.results_found')}}
                            </h2>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                    @include('common.imei.results')
                                    </tbody>
                                </table>
                            </div>
                            <p>
                                {{trans('pages.are_the_Results_match_your_device')}}
                                <a href="{{route('imei-results.matched',request()->get( 'inputImei' ))}}">
                                    <button class="btn blue-btn">
                                        {{trans('pages.buttons.yes')}}
                                    </button>
                                </a>

                                <a href="{{url(App::getLocale().'/admin/imei/'.request()->get('inputImei'))}}">
                                    <button class="btn red-btn">
                                        {{trans('pages.report_mobile_phone')}}
                                    </button>
                                </a>
                            </p>
                        @elseif(isset($message))
                            @include('admin.imei.partials.modal')
                        @elseif(isset($notMatchedImei))
                            @include('common.partials.not-matched-modal')
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @include('common.partials.footer')
    </div>
    </div>
@endsection
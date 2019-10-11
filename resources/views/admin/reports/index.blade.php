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
    <div id="app">
        @include('common.partials.nav')
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header" data-background-color="sitebg">
                        <h1><i class="material-icons">dashboard</i>
                            @if(request()->is('en/*'))
                                Reports
                            @elseif(request()->is('vi/*'))
                                {{trans('dashboard.dashboard',[],'vi')}}
                            @endif
                        </h1>
                    </div>
                    <div class="card-content">
                        <p></p>
                    </div>
                </div>

                {{--//NEW CHARTS--}}

                <div class="row hide-ie10">
                <div class="col-md-8">
                <div class="card">
                <div class="card-header card-chart" data-background-color="red">
                {!! $sum_bar_chart->render() !!}
                </div>
                <div class="card-content">
                <h4 class="title">
                @if(request()->is('en/*'))
                IMEI Searches & Reported Devices
                @elseif(request()->is('vi/*'))
                {{trans('dashboard.all_imei_searches',[],'vi')}}
                @endif
                </h4>
                </div>
                </div>
                </div>
                <div class="col-md-4">
                <div class="card">
                <div class="card-header card-chart" data-background-color="red">
                {!! $sum_valid_invalid_searches->render() !!}
                </div>
                <div class="card-content">
                <h4 class="title">
                @if(request()->is('en/*'))
                Sum of Valid / Invalid IMEI Searches
                @elseif(request()->is('vi/*'))
                {{trans('dashboard.all_imei_searches',[],'vi')}}
                @endif
                </h4>
                </div>
                </div>
                </div>

                </div>

                {{--@include('admin/dashboard/heatmap/imei-search')--}}

                <div class="row hide-ie10">
                <div class="col-md-12">
                <div class="card">
                <div class="card-header card-chart" data-background-color="red">
                {!! $sum_bar_chart_per_date->render() !!}
                </div>
                <div class="card-content">
                <h4 class="title">
                @if(request()->is('en/*'))
                IMEI Searches & Reported Devices
                @elseif(request()->is('vi/*'))
                {{trans('dashboard.all_imei_searches',[],'vi')}}
                @endif
                </h4>
                </div>
                </div>
                </div>

                </div>

                <div class="row hide-ie10">
                <div class="col-md-12">
                <div class="card">
                <div class="card-header card-chart" data-background-color="red">
                {!! $imei_sum_per_country_chart->render() !!}
                </div>
                <div class="card-content">
                <h4 class="title">
                @if(request()->is('en/*'))
                IMEI Searches By Countries
                @elseif(request()->is('vi/*'))
                {{trans('dashboard.all_imei_searches',[],'vi')}}
                @endif
                </h4>
                </div>
                </div>
                </div>

                </div>


                {{--//NEW CHARTS--}}


            </div>


        </div>
        @include('common.partials.footer')
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>

@endsection
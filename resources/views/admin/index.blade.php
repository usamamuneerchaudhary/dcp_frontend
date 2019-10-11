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
@section('title',trans('titles.admin.index'))
@section('content')
    <div id="app">
        @include('common.partials.nav')
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header" data-background-color="sitebg">
                        <h1><i class="material-icons">dashboard</i>
                            {{trans('dashboard.dashboard')}}
                        </h1>
                    </div>

                </div>
                @include('admin.partials.dash-components')
                <div class="row hide-ie10">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header card-chart" data-background-color="red">
                                <canvas id="pieChart" width="400" height="400"></canvas>
                            </div>
                            <div class="card-content">
                                <h4 class="title">
                                    {{trans('dashboard.valid_invalid_searches')}}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header card-chart" data-background-color="red">
                                <canvas id="lineChart" width="500" height="225"></canvas>
                            </div>
                            <div class="card-content">
                                <h4 class="title">
                                    {{trans('dashboard.all_imei_searches')}}
                                </h4>
                            </div>
                        </div>
                    </div>

                </div>


                @if(isset($users_activity['users_activity']))
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">
                                {{trans('dashboard.all_users_activity')}}
                            </h4>
                            <p class="category">
                                {{trans('dashboard.imei_searches')}}
                            </p>
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                    <th>
                                        {{trans('dashboard.user_device')}}
                                    </th>
                                    <th>
                                        {{trans('dashboard.checking_method')}}
                                    </th>
                                    <th>
                                        {{trans('dashboard.imei_number')}}
                                    </th>
                                    <th>
                                        {{trans('dashboard.result')}}
                                    </th>
                                    <th>
                                        {{trans('dashboard.user_name')}}
                                    </th>
                                    <th>
                                        {{trans('dashboard.user_ip')}}
                                    </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($users_activity['users_activity']))
                                        @foreach($users_activity['users_activity'] as $key => $value)

                                            <tr>
                                                <td>{{ $value->user_device}}</td>
                                                <td>{{ $value->checking_method}}</td>
                                                <td>{{ $value->imei_number}}</td>
                                                <td>{{ $value->result}}</td>
                                                <td>{{$value->user_name}}</td>
                                                <td>{{ $value->visitor_ip}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    <tr>
                                        <td colspan="6" class="text-right"><a
                                                    href="{{url(App::getLocale().'/admin/users-activity')}}"
                                                    class="bold-text">
                                                {{trans('dashboard.view_all_activities')}}
                                            </a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <h4>
                        {{trans('dashboard.no_data_found')}}
                    </h4>
                @endif

                @include('admin/dashboard/heatmap/imei-search')

            </div>

        </div>
        @include('common.partials.footer')
    </div>

@endsection
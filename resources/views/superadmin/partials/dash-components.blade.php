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
@if(isset($users_activity['users_activity']))
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="green">
                    <i class="material-icons">search</i>
                </div>
                <div class="card-content" rel="tooltip"
                     title="{{trans('dashboard.titles.total_number_ofimes_searched')}}">
                    <p class="category">
                        {{trans('dashboard.total_searches')}}
                    </p>
                    <h3 class="title">
                        {{$users_activity['totalIMEI']}}
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">search</i>
                        <a href="{{url('/'.App::getLocale().'/super-admin/users-activity')}}">
                            {{trans('dashboard.view_activity_logs')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="purple">
                    <i class="material-icons">check_circle</i>
                </div>
                <div class="card-content" rel="tooltip"
                     title="{{trans('dashboard.titles.matched_records')}}">
                    <p class="category">
                        {{trans('dashboard.matched_searches')}}
                    </p>
                    <h3 class="title">
                        {{$users_activity['totalMatchedImeis']}}
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">check_circle</i>
                        <a href="{{url('/'.App::getLocale().'/super-admin/matched-records')}}">
                            {{trans('dashboard.view_activity_logs')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="orange">
                    <i class="material-icons">report_problem</i>
                </div>
                <div class="card-content" rel="tooltip"
                     title="{{trans('dashboard.titles.mismatched_records')}}">
                    <p class="category">
                        {{trans('dashboard.mis_matched_searches')}}
                    </p>
                    <h3 class="title">
                        {{$users_activity['totalNotMatchedImeis']}}

                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">report_problem</i>

                        <a href="{{url('/'.App::getLocale().'/super-admin/not-matched-records')}}">
                            {{trans('dashboard.view_activity_logs')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="blue">
                    <i class="material-icons">info_outline</i>
                </div>
                <div class="card-content" rel="tooltip"
                     title="{{trans('dashboard.titles.counterfeit')}}">
                    <p class="category" >
                        {{trans('dashboard.devices_reported')}}
                    </p>
                    <h3 class="title">
                        {{$users_activity['totalCounterFeitDevices']}}
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">info_outline</i>
                        <a href="{{url('/'.App::getLocale().'/super-admin/counterfiet-devices')}}">
                            {{trans('dashboard.view_all_counterfeit_devices')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif



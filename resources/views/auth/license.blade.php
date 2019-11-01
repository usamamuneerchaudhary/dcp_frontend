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
@extends('layouts.base')
@section('content')
    <div class="content">
        <div class="container">
            @include('layouts.partials.alerts')
            <div class="check_screen">
                <div class="error"></div>
                <div class="card">
                    <div class="card-header" data-background-color="sitebg">
                        <h1 class="dvs-heading">DCP Vietnam</h1>
                    </div>
                    <div class="card-content">
                        <h2>{{trans('license.heading')}}</h2>
                        <p>{{trans('license.last_updated')}}
                            : {{ Carbon\Carbon::parse($license->created_at)->diffForHumans()}}</p>
                        <p>{{trans('license.sample_text')}}</p>
                        <h3>1. {{trans('license.headings.use_of_application')}}</h3>
                        <p>{{trans('license.content.use_of_application')}}</p>

                        <h3>2. {{trans('license.headings.proprietary_rights')}}</h3>
                        <p>{{trans('license.content.proprietary_rights')}}</p>

                        <h3>3. {{trans('license.headings.company_privacy_policy')}}</h3>
                        <p>{{trans('license.content.company_privacy_policy')}}</p>

                        <h3>4. {{trans('license.headings.restricted_rights')}}</h3>
                        <p>{{trans('license.content.restricted_rights')}}</p>

                        <h3>5. {{trans('license.headings.export_restrictions')}}</h3>
                        <p>{{trans('license.content.export_restrictions')}}</p>

                        <h3>6. {{trans('license.headings.termination')}}</h3>
                        <p>{{trans('license.content.termination')}}</p>

                        <h3>7. {{trans('license.headings.indemnity')}}</h3>
                        <p>{{trans('license.content.indemnity')}}</p>

                        <h3>8. {{trans('license.headings.disclaimer_of_warranty')}}</h3>
                        <p>{{trans('license.content.disclaimer_of_warranty')}}</p>

                        <h3>9. {{trans('license.headings.limitation_of_liability')}}</h3>
                        <p>{{trans('license.content.limitation_of_liability')}}</p>

                        <h3>10. {{trans('license.headings.miscellaneous')}}</h3>
                        <p>{{trans('license.content.miscellaneous')}}</p>
                        {{--                        <h3>{{trans('license.license')}}</h3>--}}
                        {{--                        <p>{!! $license->content!!}</p>--}}
                        <div id="license-checkbox">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> {{trans('license.accept')}}
                                </label>
                            </div>
                            <div id="license-btn-box" mt20>
                                <a href="{{route('update.user.license',$user->id)}}" rel="tooltip" title="Continue"
                                   class="btn blue-btn license-btn"
                                   style="display: none;">{{trans('license.continue')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

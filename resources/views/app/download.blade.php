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
@section('title',trans('pages.download_application'))
@section('content')
    @include('common.partials.nav')
    <div class="content" id="app">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header" data-background-color="sitebg">
                    <h1><i class="material-icons">android</i>
                        {{trans('pages.download_application')}}
                    </h1>
                </div>

                @if(!isset($license))

                    <div class="card-content">
                        <p>{{trans('pages.no_license_found')}}</p>
                    </div>
                @else

                    <div class="card-content">
{{--                        <h2>{{trans('pages.licenses.head')}}</h2>--}}
{{--                        <p>{{\Carbon\Carbon::parse($license->created_at)->diffForHumans()}}</p>--}}
{{--                        <p>{{trans('pages.licenses.body')}}</p>--}}
{{--                        <h3>{{trans('pages.licenses.license')}}</h3>--}}
{{--                        <p>{!! $license->content!!}</p>--}}
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

                        <app-download endpoint="{{config('app.api_url')}}api/update-user-app-license/{{$user->id}}"
                                      :trans="{{json_encode(\Lang::get('pages'))}}"
                                      :is_eng="{{json_encode(request()->is('en/*'))}}"
                                      :is_viet="{{json_encode(request()->is('vi/*'))}}"></app-download>


                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('common.partials.footer')
    </div>
@endsection
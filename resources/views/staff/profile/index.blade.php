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
@section('title',trans('titles.staff.home'))
@section('content')
    @include('common.partials.nav')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header" data-background-color="sitebg">
                    <h1 class="text-center"><i class="material-icons">person</i>
                        <strong>{{$user->first_name}} {{$user->last_name}}</strong>'s
                        {{trans('profile.profile')}}

                    </h1>
                </div>
                <div class="card-content profile-holder">
                    <div class="form-group" mt20>
                        <div class="row">
                            <div class="col-sm-5 col-md-3 text-sm-right">
                                <i class="description material-icons">perm_identity</i>
                                <strong>
                                    {{trans('profile.fields.first_name')}} :
                                </strong>
                            </div>
                            <div class="col-sm-7 col-md-9">{{$user->first_name}}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-5 col-md-3 text-sm-right">
                                <i class="description material-icons">perm_identity</i>
                                <strong>
                                    {{trans('profile.fields.last_name')}} :
                                </strong>
                            </div>
                            <div class="col-sm-7 col-md-9">{{$user->last_name}}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-5 col-md-3 text-sm-right">
                                <i class="description material-icons">mail_outline</i>
                                <strong>
                                    {{trans('profile.fields.email_address')}} :
                                </strong>
                            </div>
                            <div class="col-sm-7 col-md-9">{{$user->email}}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-5 col-md-3 text-right">
                                <a href="{{ route('staff.profile.edit', $user->id) }}"
                                   class="btn dark-btn">{{trans('profile.buttons.edit_details')}}</a>
                            </div>
                            <div class="col-sm-7 col-md-9 text-xs-right">
                                <a href="{{ route('staff.profile.password', $user->id) }}"
                                   class="btn blue-btn">{{trans('profile.buttons.change_password')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('common.partials.footer')
    </div>
@endsection
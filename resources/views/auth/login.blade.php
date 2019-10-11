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
@section('title',trans('titles.common.login'))
@section('content')

    <section class="bgreg">
        <div class="regbox">
            <div class="card">
                <div class="card-header" data-background-color="sitebg">
                    <h3 class="text-center dvs-heading">
                        {{trans('common.DCP')}}
                    </h3>
                    <h6 class="text-center">{{trans('auth.login_page.signin_text')}}</h6>
                </div>
                @include('layouts.partials.alerts')
                <div class="check_screen">
                    <div class="error"></div>

                    <div class="form loginBox">
                        <form method="POST" action="{{action('Auth\LoginController@login')}}" accept-charset="UTF-8">
                            {{ csrf_field() }}
                            <fieldset>

                                <div class="fieldbox">

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} ">
                                        <div class="inputbox ion-control">
                                            <i class="ion material-icons">mail_outline</i>
                                            <input id="email" class="form-control" type="email" name="email"
                                                   placeholder="{{trans('auth.login_page.email')}}"
                                                   value="{{ old('email') }}" required>
                                        </div>
                                    </div>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="fieldbox">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} ">

                                        <div class="inputbox ion-control">
                                            <i class="ion material-icons">lock_outline</i>
                                            <input id="password" type="password" class="form-control" name="password"
                                                   placeholder="{{trans('auth.login_page.password')}}" required>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="clearfix txt-xxs-center form-group">
                                    <a class="forgot-link" href="{{ url('/'.App::getLocale(). '/password/recover') }}">
                                        {{trans('auth.forgot_your_password')}}
                                    </a>

                                    <button type="submit" class="btn pull-right login-btn">
                                        {{trans('auth.login_page.login')}}&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="material-icons">navigate_next</i>
                                    </button>
                                </div>
                                <div class="text-center form-group">
                                    <p>
                                        {{trans('auth.dont_have_an_account')}}
                                        <a href="{{ url('/' .App::getLocale(). '/register') }}">
                                            <strong>{{trans('auth.register_now')}}</strong>
                                        </a>
                                    </p>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

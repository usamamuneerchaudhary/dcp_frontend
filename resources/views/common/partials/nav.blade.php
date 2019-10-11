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
<div class="main-panel">
    <div class="show-ie10">Your <b>current browser</b> lacks some new <b>features</b> we need! It is recommended to <b>upgrade</b>
        your browser for better user experience.
    </div>
    <nav class="navbar navbar-transparent">
        <div class="container-fluid">
            <div class="navbar-header" prl15>
                <button type="button" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- <a class="navbar-brand" href="#"> </a> -->
                <h1 class="logo-text">
                    {{trans('common.DCP')}}&nbsp;&nbsp;<small class="version">v1.2.5</small>
                </h1>
            </div>
			<?php $headerClass = '';
			if ( session()->has( 'user' ) ) {
				$headerClass = "dashboard-header";
			} ?>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right pronav">
                    <li class="dropdown lang">

                        <div class="langflags">
                            @if(request()->route('id')!== null)
                                <div></div>
                            @else
                                <a href="{{url('/en')}}/{{request()->route()->getName()}}"
                                   {{ (Request::is('en','en/*') ? 'class=active' : '') }} rel="tooltip"
                                   title="{{trans('common.tooltips.select_english')}}" data-placement="bottom">
                                    <img src="{{ asset('img/flg_en.jpg') }}" alt=""/>
                                </a>
                                <a href="{{url('/vi')}}/{{request()->route()->getName()}}"
                                   {{ (Request::is('vi','vi/*') ? 'class=active' : '') }} rel="tooltip"
                                   title="{{trans('common.tooltips.select_vietnamese')}}" data-placement="bottom">
                                    <img src="{{ asset('img/flg_vi.jpg') }}" alt=""/>
                                </a>
                            @endif


                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle bold-text" data-toggle="dropdown"
                           role="button" aria-expanded="false" style="background: #fff;">
                            <i class="material-icons">person</i>
                            <p class="hidden-lg hidden-md"> {{ ucwords($user->first_name) }}</p>
                        </a>

                        <ul class="dropdown-menu">
							<?php $user = \Session::get( 'user' ); ?>



                            @if(isset($user) && $user->roles[0]->slug == 'admin')
                                <li>
                                    <a href="{{url(App::getLocale().'/admin/profile')}}">{{trans('profile.profile')}}</a>
                                </li>
                            @elseif(isset($user) && $user->roles[0]->slug == 'superadmin')
                                <li>
                                    <a href="{{url(App::getLocale().'/super-admin/profile')}}">{{trans('profile.profile')}}</a>
                                </li>
                            @elseif(isset($user) && $user->roles[0]->slug == 'staff')
                                <li>
                                    <a href="{{url(App::getLocale().'/staff/profile')}}">{{trans('profile.profile')}}</a>
                                </li>
                            @endif


                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{trans('auth.logout')}}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">{{ csrf_field() }}</form>
                            </li>
                        </ul>
                    </li>

                </ul>
                <form class="navbar-form navbar-right" hidden>
                    <input type="hidden" name="" id="">
                </form>
            </div>
        </div>
    </nav>
    

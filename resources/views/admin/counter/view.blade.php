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
@section('title',trans('titles.admin.counterfeit_single'))
@section('content')
	<?php $user = \Session::get( 'user' ); ?>
    @include('common.partials.nav')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header" data-background-color="sitebg">
                    <h1><i class="material-icons">feedback</i>
                        {{trans('pages.counterfiet_details')}}
                    </h1>
                </div>
                <div class="card-content">
                    <div class="table-responsive" mt20>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>{{trans('pages.table.imei_number')}}</th>
                                {{--<th>{{trans('pages.table.result')}}</th>--}}
                                <th>{{trans('pages.table.user_name')}}</th>
                                <th>{{trans('pages.table.brand_name')}}</th>
                                <th>{{trans('pages.table.model_name')}}</th>
                                <th>{{trans('pages.table.store_name')}}</th>
                                <th>{{trans('pages.table.status')}}</th>
                                <th>{{trans('pages.table.description')}}</th>
                                <th>{{trans('pages.table.created_at')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>{{$counterDetails->imei_number}}</td>
                                {{--<td>{{$counterDetails->result}}</td>--}}
                                <td>{{$counterDetails->user_name}}</td>
                                <td>{{$counterDetails->brand_name}}</td>
                                <td>{{$counterDetails->model_name}}</td>
                                <td>{{$counterDetails->store_name}}</td>
                                <td>{{$counterDetails->status}}</td>
                                <td>{{$counterDetails->description}}</td>
                                <td>{{$counterDetails->created_at}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    @if(count($local_images) > 0)
                    <ul class="imglist counterfiet_img_list">
                        @foreach($local_images as $image)
                            <li class="imgcol">
                                <div>
                                    <a data-toggle="lightbox" data-gallery="multiimages"
                                       data-remote="{{ $image }}" class="imgbox">
                                        <img src="{{$image }}" class="small-img" data-lightbox-type="image">
                                    </a>
                                </div>
                                <div id="" class="lightbox fade"
                                     tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class='lightbox-dialog'>
                                        <div class='lightbox-content'>
                                            <img src="{{$image}}">
                                            <div class='lightbox-caption'>
                                                {{$counterDetails->brand_name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @else
                    <ul class="imglist counterfiet_img_list">
                        @foreach($aws_images as $image)
                            <li class="imgcol">
                                <div>
                                    <a data-toggle="lightbox"
                                       href="#lightbox-{{substr($image->getUri()->getPath(),1,13)}}" class="imgbox">
                                        <img src="{{$image->getUri() }}" class="small-img">
                                    </a>
                                </div>
                                <div id="lightbox-{{substr($image->getUri()->getPath(),1,13)}}" class="lightbox fade"
                                     tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class='lightbox-dialog'>
                                        <div class='lightbox-content'>
                                            <img src="{{$image->getUri()}}">
                                            <div class='lightbox-caption'>
                                                {{$counterDetails->brand_name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="text-center" mt20>
                        @if($user->roles[0]->slug === 'admin')
                            <a href="{{URL::to(App::getLocale().'/admin/counterfiet-devices')}}">
                                <i class="material-icons">keyboard_backspace</i>&nbsp;&nbsp;{{trans('profile.buttons.back')}}
                            </a>
                        @elseif($user->roles[0]->slug==='superadmin')
                            <a href="{{URL::to(App::getLocale().'/super-admin/counterfiet-devices')}}">
                                <i class="material-icons">keyboard_backspace</i>&nbsp;&nbsp;{{trans('profile.buttons.back')}}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
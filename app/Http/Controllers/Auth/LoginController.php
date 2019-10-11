<?php
/**
 * SPDX-License-Identifier: BSD-4-Clause-Clear
 *
 * Copyright (c) 2018-2019 Qualcomm Technologies, Inc.
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are permitted (subject to the
 * limitations in the disclaimer below) provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice, this list of conditions and the following
 * disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the
 * following disclaimer in the documentation and/or other materials provided with the distribution.
 * - All advertising materials mentioning features or use of this software, or any deployment of this software,
 * or documentation accompanying any distribution of this software, must display the trademark/logo as per the
 * details provided here: https://www.qualcomm.com/documents/dirbs-logo-and-brand-guidelines
 * - Neither the name of Qualcomm Technologies, Inc. nor the names of its contributors may be used to endorse or
 * promote products derived from this software without specific prior written permission.
 *
 *
 *
 * SPDX-License-Identifier: ZLIB-ACKNOWLEDGEMENT
 *
 * Copyright (c) 2018-2019 Qualcomm Technologies, Inc.
 *
 * This software is provided 'as-is', without any express or implied warranty. In no event will the authors be held liable
 * for any damages arising from the use of this software. Permission is granted to anyone to use this software for any
 * purpose, including commercial applications, and to alter it and redistribute it freely, subject to the following
 * restrictions:
 *
 * - The origin of this software must not be misrepresented; you must not claim that you wrote the original software.
 * If you use this software in a product, an acknowledgment is required by displaying the trademark/logo as per the
 * details provided here: https://www.qualcomm.com/documents/dirbs-logo-and-brand-guidelines
 * - Altered source versions must be plainly marked as such, and must not be misrepresented as being the original
 * software.
 * - This notice may not be removed or altered from any source distribution.
 *
 * NO EXPRESS OR IMPLIED LICENSES TO ANY PARTY'S PATENT RIGHTS ARE GRANTED BY THIS LICENSE. THIS SOFTWARE IS PROVIDED BY
 * THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR
 * BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace App\Http\Controllers\Auth;

use Alert;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
    /**
     * @var $response
     */
    protected $response;

    /**
     * @var Client
     */
    protected $client;

    /**
     * LoginController constructor.
     */
    public function __construct()
    {

        $this->client = new Client([
            'base_uri' => config('app.api_url'),
            'http_errors' => false
        ]);


    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        $user = \Session::get('user');
        if (\Session::has('token')) {
            if (isset($user) && $user->roles[0]->slug == 'admin') {

                return redirect()->route('admin');
            } elseif (isset($user) && $user->roles[0]->slug == 'superadmin') {
                return redirect()->route('super-admin');
            } elseif (isset($user) && $user->roles[0]->slug == 'staff') {
                return redirect()->route('staff');
            }


            return view('auth.login');
        }

        return view('auth.login');


    }

    /**
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login()
    {

        $result = $this->client->post("api/login", [
            'form_params' => [
                'email' => Input::get('email'),
                'password' => Input::get('password')
            ],
            'header' => [
                'x-localization' => App::getLocale(),
                'Accept' => 'application/json'
            ]
        ]);



        if ($result->getStatusCode() == '500') {
            alert()->error(trans('messages.could_not_signin'), trans('messages.internal_server'))->persistent(trans('messages.success.close'))->autoclose(false);

            return redirect()->back();
        } elseif ($result->getStatusCode() == '401') {
            $data = \GuzzleHttp\json_decode($result->getBody());

            alert()->error(trans('messages.could_not_signin'), trans('messages.login_failed'))->persistent(trans('messages.success.close'))->autoclose(false);
            \Session::put('is_ie', $data->is_ie);

            return redirect()->back()->with(
                'is_ie', $data->is_ie
            );
        }


        $data = \GuzzleHttp\json_decode($result->getBody());


        if (isset($data->error) && $data->error === true) {

            alert()->error(trans($data->message), trans('messages.internal_server'))->persistent(trans('messages.success.close'))->autoclose(false);

            return redirect()->back();
        }
        if (isset($data->errors)) {

            alert()->error(trans('messages.wrong_creds'), trans('messages.login_failed'))->persistent(trans('messages.success.close'))->autoclose(false);

            return redirect()->route('login')->withErrors($data->errors->root)->withInput();
        }


        $user = $data->data;


        /*
         * If user role is not admin, continue
         * For STAFF role
         * */
        if (isset($user) && $user->roles[0]->slug === 'staff') {


            if (isset($data->data) && empty($data->licenses)) {
                \Session::put('token', $data->meta->token);
                \Session::put('user', $data->data);
                \Session::put('current_license', $data->current_active_license);
                if (isset($data->current_active_license)) {
                    alert()->info(trans('messages.please_accept_license_agreement'), trans('messages.welcometo_DCP'))->persistent(trans('messages.success.close'))->autoclose(false);

                    return redirect()->route('user-license', $user->id);

                }


            } elseif (isset($data->data) && !empty($data->licenses)) {

                $user_licenses = $data->licenses;

                if (isset($user_licenses)) {

                    $last_array = end($user_licenses);

                    if (isset($last_array) && $last_array->version != $data->current_active_license->version) {

                        \Session::put('token', $data->meta->token);
                        \Session::put('user', $data->data);
                        alert()->info(trans('messages.please_accept_license_agreement'), trans('messages.welcometo_DCP'))->persistent(trans('messages.success.close'))->autoclose(false);
                        return redirect()->route('user-license', $user->id);

                    }
                }
            }


        }
        /*
        * end for staff User
        */

        \Session::put('token', $data->meta->token);
        \Session::put('user', $user);


        return $this->getChartData($user);

    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        \Session::remove('token');
        \Session::remove('user');

        return redirect()->route('login');
    }


    /**
     * @param $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    protected function getChartData($user)
    {
        if (\Session::has('token')) {
            if (isset($user->roles[0]) && ($user->roles[0]->slug === 'admin' || $user->roles[0]->slug === 'superadmin')) {

                if ($user->roles[0]->slug === 'admin') {
                    return redirect()->route('admin');
                } elseif ($user->roles[0]->slug === 'superadmin') {
                    return redirect()->route('super-admin');
                } else {
                    abort(404, 'Restricted Area');
                }

            } else {
                return redirect()->route('login');
            }

        } else {
            return redirect()->route('login');
        }

    }

}

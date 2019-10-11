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
@if(isset($all_data->deviceId) && !empty($all_data->deviceId))
    <tr>
        <th><strong>{{trans('pages.gsma_table.device_id')}}</strong></th>
        <td>{{$all_data->deviceId}}</td>
    </tr>
@endif
@if(isset($all_data->manufacturer) && !empty($all_data->manufacturer))
    <tr>
        <th><strong>{{trans('pages.gsma_table.manufacturer')}}</strong></th>
        <td>{{$all_data->manufacturer}}</td>
    </tr>
@endif
@if(isset($all_data->equipmentType) && !empty($all_data->equipmentType))
    <tr>
        <th><strong>{{trans('pages.gsma_table.equipment_type')}}</strong></th>
        <td>{{$all_data->equipmentType}}</td>
    </tr>
@endif
@if(isset($all_data->brandName) && !empty($all_data->brandName))
    <tr>
        <th><strong>{{trans('pages.gsma_table.brand_name')}}</strong></th>
        <td>{{$all_data->brandName}}</td>
    </tr>
@endif
@if(isset($all_data->modelName) && !empty($all_data->modelName))
    <tr>
        <th><strong>{{trans('pages.gsma_table.model_name')}}</strong></th>
        <td>{{$all_data->modelName}}</td>
    </tr>
@endif
@if(isset($all_data->marketingName) && !empty($all_data->marketingName))
    <tr>
        <th><strong>{{trans('pages.gsma_table.marketing_name')}}</strong></th>
        <td>{{$all_data->marketingName}}</td>
    </tr>
@endif
@if(isset($all_data->internalModelName) && !empty($all_data->internalModelName))
    <tr>
        <th><strong>{{trans('pages.gsma_table.internal_model_name')}}</strong></th>
        <td>{{$all_data->internalModelName}}</td>
    </tr>
@endif
@if(isset($all_data->tacApprovedDate) && !empty($all_data->tacApprovedDate))
    <tr>
        <th><strong>{{trans('pages.gsma_table.tac_approved_date')}}</strong></th>
        <td>{{$all_data->tacApprovedDate}}</td>
    </tr>
@endif

@if(isset($all_data->deviceCertifybody) && !empty($all_data->deviceCertifybody))
    <tr>
        <th><strong>{{trans('pages.gsma_table.device_certify_body')}}</strong></th>

        @foreach($all_data->deviceCertifybody as $item)
            <td>{{$item}}</td>
        @endforeach
    </tr>
@endif
@if(isset($all_data->radioInterface) && !empty($all_data->radioInterface))
    <tr>
        <th><strong>{{trans('pages.gsma_table.radio_interface')}}</strong></th>
        @foreach($all_data->radioInterface as $item)
            <td>{{$item}}</td>
        @endforeach
    </tr>
@endif
@if(isset($all_data->operatingSystem) && !empty($all_data->operatingSystem) )
    <tr>
        <th><strong>{{trans('pages.gsma_table.operating_system')}}</strong></th>
        @foreach($all_data->operatingSystem as $item)
            <td>{{$item}}</td>
        @endforeach
    </tr>
@endif
@if(isset($all_data->simSupport) && !empty($all_data->simSupport))
    <tr>
        <th><strong>{{trans('pages.gsma_table.sim_support')}}</strong></th>
        <td>{{$all_data->simSupport}}</td>
    </tr>
@endif
@if(isset($all_data->nfcSupport) && !empty($all_data->nfcSupport))
    <tr>
        <th><strong>{{trans('pages.gsma_table.nfc_support')}}</strong></th>
        <td>{{$all_data->nfcSupport}}</td>
    </tr>
@endif
@if(isset($all_data->blueToothSupport) && !empty($all_data->blueToothSupport))
    <tr>
        <th><strong>{{trans('pages.gsma_table.bluetooth_support')}}</strong></th>
        <td>{{$all_data->blueToothSupport}}</td>
    </tr>
@endif
@if(isset($all_data->wlanSupport) && !empty($all_data->wlanSupport))
    <tr>
        <th><strong>{{trans('pages.gsma_table.wlan_support')}}</strong></th>
        <td>{{$all_data->wlanSupport}}</td>
    </tr>
@endif

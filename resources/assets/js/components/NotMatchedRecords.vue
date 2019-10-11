<!--/** Copyright (c) 2018-2019 Qualcomm Technologies, Inc.
All rights reserved.
Redistribution and use in source and binary forms, with or without modification, are permitted (subject to the limitations in the disclaimer below) provided that the following conditions are met:
Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
Neither the name of Qualcomm Technologies, Inc. nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
The origin of this software must not be misrepresented; you must not claim that you wrote the original software. If you use this software in a product, an acknowledgment is required by displaying the trademark/log as per the details provided here: https://www.qualcomm.com/documents/dirbs-logo-and-brand-guidelines
Altered source versions must be plainly marked as such, and must not be misrepresented as being the original software.
This notice may not be removed or altered from any source distribution.
NO EXPRESS OR IMPLIED LICENSES TO ANY PARTY'S PATENT RIGHTS ARE GRANTED BY THIS LICENSE. THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.*/-->
<template>
    <div>
        <div class="card">
            <div class="card-header" data-background-color="sitebg">
                <h1><i class="material-icons">group_work</i> {{this.trans.mis_matched_devices}}
                </h1>
            </div>
            <div class="card-content">
                <div class="row">


                    <div pt20></div>
                    <div v-show="loading" class="loadthis">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <vue-good-table
                            mode="remote"
                            :columns="columns"
                            :rows="rows"
                            :globalSearch="true"
                            :search-options="{
                                enabled: true,
                                skipDiacritics: true,
                                placeholder: this.trans.datatable_search.imei_search
                             }"
                            @on-search="onSearch"
                            styleClass="table table-hover table-bordered table-responsive">
                        <template slot="table-row" slot-scope="props">
                        <span v-if="props.column.field === 'S.No'">
                         {{ (activities.per_page * (activities.current_page - 1)) + (props.index + 1)
                          }}
                        </span>
                            <span v-else>
                    {{props.formattedRow[props.column.field]}}
                  </span>
                        </template>
                        <div slot="emptystate" class="vgt-center-align vgt-text-disabled">
                            {{trans.table.no_data_found}}
                        </div>
                    </vue-good-table>
                    <vue-pagination :pagination="activities"
                                    @paginate="getRecords()"
                                    :offset="4">
                    </vue-pagination>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import Vue from 'vue';
    import VueGoodTable from 'vue-good-table';
    import queryString from 'query-string';
    import VuePagination from './Paginator';
    // import the styles
    import 'vue-good-table/dist/vue-good-table.css'

    Vue.use(VueGoodTable);
    export default {
        props: ['endpoint', 'baseuri', 'trans', 'locale'],
        data() {
            return {
                activities: {
                    searchTerm: '',
                    total: 0,
                    per_page: 10,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                offset: 4,
                loading: false,
                csrf_token:csrf_token,
                token: token,
                columns: [
                    {
                        label: 'S.No',
                        field: 'S.No'
                    },
                    {
                        label: this.trans.table.user_device,
                        field: 'user_device',
                        filterable: true
                    },
                    {
                        label: this.trans.table.checking_method,
                        field: 'checking_method',
                        filterable: true
                    },
                    {
                        label: this.trans.table.imei_number,
                        field: 'imei_number',
                        filterable: true
                    },
                    {
                        label: this.trans.table.result,
                        field: 'result',
                        filterable: true
                    },
                    {
                        label: this.trans.table.results_matched,
                        field: 'results_matched',
                        filterable: true
                    },
                    {
                        label: this.trans.table.user_name,
                        field: 'user_name',
                        filterable: true
                    },
                    {
                        label: this.trans.table.created_at,
                        field: 'created_at',
                        filterable: true
                    },
//
                ],
                rows: []
            }
        },
        components: {
            VuePagination,
        },
        created() {
            this.getRecords()
        },
        methods: {
            getExport(){
                axios({
                    url: this.baseuri + "api/admin/activity-logs-export",
                    method: 'GET',
                    responseType: 'blob', // important
                })
                    .then((response) => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'activity_logs.xlsx');
                        document.body.appendChild(link);
                        link.click();
                    });
                ;

            },
            getRecords(){
                this.loading = true;

                return axios.get(`${this.endpoint}?token=${this.token}&csrf_token=${this.csrf_token}&page=${this.activities.current_page}&per_page=${this.activities.per_page}&searchTerm=${this.activities.searchTerm}`,{
                    headers: {
                        'x-localization': locale
                    }
                }).then((response) => {
                    this.rows = response.data.activity.data
                    this.activities = response.data.activity
                    this.loading = false;
                })
            },
            updateParams(newProps) {
                this.activities = Object.assign({}, this.activities, newProps);
            },
            onSearch: _.debounce(function(params) {
                this.updateParams(params);
                this.getRecords();
                return false;
            }, 500),

        }
    }
</script>


<style lang="scss">
    .sortable {
        cursor: pointer;
    }

    .arrow {
        display: inline-block;
        vertical-align: middle;
        width: 0;
        height: 0;
        margin-left: 5px;
        opacity: .6;

        &--asc {
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-bottom: 4px solid #222;
        }
        &--desc {
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 4px solid #222;
        }
    }
</style>
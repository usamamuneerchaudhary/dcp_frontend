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
                <h1><i class="material-icons">warning</i> {{this.trans.counterfeit_devices}}
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
                        <template slot="table-actions" v-if="user.roles[0].slug ==='superadmin'">

                            <div class="text-right">
                                <button class="btn blue-btn" type="button" v-on:click="getExport">
                                    {{this.trans.export_text.export_counterfeit_logs}}
                                </button>
                                <button class="btn blue-btn" type="button" v-on:click="getGSMAExport">
                                    Comparision Logs
                                </button>
                            </div>
                        </template>


                        <template slot="table-row" slot-scope="props">
                            <td v-if="props.column.field == 'S.No'">
                                {{ (activities.per_page * (activities.current_page - 1)) + (props.index + 1)
                                }}
                            </td>
                            <td v-if="props.column.field === 'action'" class="text-right">
                               <span v-if="user.roles[0].slug ==='superadmin'">
                                <a


                                        href="#"
                                        @click.prevent="deleteRecord(props.row)"
                                        role="button"
                                        class="ionremove"
                                        v-tooltip.top="trans.counter_datatable.delete_countrefeit">
                                    <i class="material-icons">delete</i>
                                </a>
                                   </span>

                                <span v-if="user.roles[0].slug ==='superadmin'">
                                <a
                                        :href="'/'+this.locale+'/super-admin/counterfiet-devices/'+props.row.id"
                                        role="button"
                                        v-tooltip.top="trans.counter_datatable.view_counterfeit"
                                        class="ionview">
                                    <i class="material-icons">visibility</i>
                                </a>
                                    </span>
                                <span v-else="user.roles[0].slug ==='admin'">
                                <a
                                        :href="'/'+this.locale+'/admin/counterfiet-devices/'+props.row.id"
                                        role="button"
                                        v-tooltip.top="trans.counter_datatable.view_counterfeit"
                                        class="ionview">
                                    <i class="material-icons">visibility</i>
                                </a>
                                </span>

                                <span v-if="user.roles[0].slug ==='superadmin'">

                                <span v-if="props.row.image_path">
                                <a :href="'/'+this.locale+'/super-admin/counterfiet-devices/'+props.row.id"
                                   role="button"
                                   v-tooltip.top="trans.counter_datatable.view_counterfeit"
                                   class="ionview">
                                    <i class="material-icons">image</i>
                                </a>
                                    </span>
                                </span>
                                <span v-else="user.roles[0].slug ==='admin'">
                                <span v-if="props.row.image_path">
                                <a :href="'/'+this.locale+'/admin/counterfiet-devices/'+props.row.id"
                                   role="button"
                                   v-tooltip.top="trans.counter_datatable.view_counterfeit"
                                   class="ionview">
                                    <i class="material-icons">image</i>
                                </a>
                                    </span>
                                </span>
                            </td>
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
    import 'vue-good-table/dist/vue-good-table.css'
    import VuePagination from './Paginator';

    Vue.use(VueGoodTable);
    export default {
        props: ['endpoint', 'baseuri', 'trans', 'img_endpoint', 'locale', 'user'],
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
                img_path: '',
                token: token,
                columns: [
                    {
                        label: 'S.No',
                        field: 'S.No'
                    },
                    {
                        label: this.trans.table.imei_number,
                        field: 'imei_number',
                        filterable: true
                    },
                    {
                        label: this.trans.table.user_name,
                        field: 'user_name',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        filterable: true
                    },
                    {
                        label: this.trans.table.brand_name,
                        field: 'brand_name',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        filterable: true
                    },
                    {
                        label: this.trans.table.model_name,
                        field: 'model_name',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        filterable: true
                    },
                    {
                        label: this.trans.table.status,
                        field: 'status',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        filterable: true
                    },
                    {
                        label: this.trans.table.created_at,
                        field: 'created_at',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        filterable: true
                    },
                    {
                        // field: this.trans.table.action,
                        // label: 'Actions',
                        label: this.trans.table.action,
                        field: 'action',
                        filterable: false,
                        sortable: false,
                        html: true,

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
            getExport() {
                axios({
                    url: this.baseuri + "api/counterfeit-logs-export?token=" + this.token,
                    method: 'GET',
                    responseType: 'blob',
                    headers: {
                        'x-localization': locale
                    }
                })
                    .then((response) => {
                        var blob = new Blob([response.data]);
                        if (window.navigator && window.navigator.msSaveOrOpenBlob) { // for IE
                            window.navigator.msSaveOrOpenBlob(blob, 'counterfeit_logs.xlsx');
                        } else {
                            const url = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = url;
                            link.setAttribute('download', 'counterfeit_logs.xlsx');
                            document.body.appendChild(link);
                            link.click();
                        }
                    }).catch(error => {
                        console.log(error);
                    })

            },
            getGSMAExport() {
                axios({
                    url: this.baseuri + "api/gsma-logs?token=" + this.token,
                    method: 'GET',
                    responseType: 'blob',
                    headers: {
                        'x-localization': locale
                    }
                })
                    .then((response) => {
                        var blob = new Blob([response.data]);
                        if (window.navigator && window.navigator.msSaveOrOpenBlob) { // for IE
                            window.navigator.msSaveOrOpenBlob(blob, 'gsma_logs.xlsx');
                        } else {
                            const url = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = url;
                            link.setAttribute('download', 'gsma_logs.xlsx');
                            document.body.appendChild(link);
                            link.click();
                        }
                    }).catch(error => {
                    console.log(error);
                })

            },

            getRecords() {
                this.loading = true;

                return axios.get(`${this.endpoint}?token=${this.token}&csrf_token=${this.csrf_token}&page=${this.activities.current_page}&per_page=${this.activities.per_page}&searchTerm=${this.activities.searchTerm}`, {
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

            deleteRecord(record) {
                if (!confirm(this.trans.counter_datatable.sure_to_delete_counterfeit)) {
                    return false;
                }
                axios.delete(`${this.baseuri}api/counterfiet/${record.id}?token=${this.token}&x-localization=${locale}`, {
                    headers: {
                        'x-localization': locale
                    }
                })

                    .then((response) => {

                        if (response.data) {
                            const indexToDelete = this.rows.findIndex(row => row.id === record.id)
                            if (indexToDelete !== -1) {
                                swal({
                                    title: this.trans.counter_datatable.counterfeit_deleted,
                                    text: this.trans.counter_datatable.counterfeit_deleted_success,
                                    type: "success",
                                    confirmButtonColor: "#004590",
                                    cancelButtonColor: '#ef5350',
                                    confirmButtonText: this.trans.users.ok_button_text
                                });
                                this.rows.splice(indexToDelete, 1)
                            }
                        }
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }

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

    .vgt-global-search {
        padding: 10px 15px;
    }

    .vgt-global-search__input {
        padding-left: 30px;
    }

    .vgt-global-search__input .input__icon .magnifying-glass {
        margin-top: 0px;
        margin-left: 0px;
    }

    .vgt-input, .vgt-select {
        height: 42px;
    }

    .vue-tooltip {
        background-color: white;
        color: rgba(0, 0, 0, 0.9);
        text-shadow: none;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        line-height: 1.42857143;
        font-size: 12px;
        border: none;
        border-radius: 3px;
        -webkit-box-shadow: 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.2);
        box-shadow: 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.2);
    }

    .vue-tooltip .tooltip-arrow {
        border-color: white;
    }

    .vue-tooltip[x-placement^="top"] .tooltip-arrow {
        border-color: white;
    }
    .vue-tooltip[x-placement^="right"] .tooltip-arrow {
        border-color: white;
    }
    .vue-tooltip[x-placement^="bottom"] .tooltip-arrow {
        border-color: white;
    }
    .vue-tooltip[x-placement^="left"] .tooltip-arrow {
        border-color: white;
    }
</style>
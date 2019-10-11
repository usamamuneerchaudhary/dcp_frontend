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
                <h1><i class="material-icons">subject</i> {{this.trans.table.licenses}}
                </h1>
            </div>

            <div class="card-content">
                <div class="row">

                    <div pt20></div>
                    <div v-show="loading" class="loadthis">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>

                    <vue-good-table
                            :columns="columns"
                            :rows="rows"
                            :search-options="{
                                enabled: true,
                                skipDiacritics: true,
                                placeholder: this.trans.datatable_search.all_licenses,
                             }"
                            styleClass="table table-hover table-bordered table-responsive">
                        <template slot="table-actions" slot-scope="props">
                            <div class="text-right">

                                <a :href="'/'+this.locale+'/super-admin/license-agreements/create/'">
                                    <button class="btn blue-btn" type="button">
                                        {{trans.add_new_license}}
                                    </button>
                                </a>
                            </div>
                        </template>
                        <template slot="table-row" slot-scope="props">
                        <td v-if="props.column.field == 'S.No'">
                         {{ (licenses.per_page * (licenses.current_page - 1)) + (props.index + 1)
                          }}
                        </td>
                            <td v-if="props.column.field === 'action'" class="text-center">

                                <a :href="'/'+this.locale+'/super-admin/license-agreement/'+props.row.id"
                                v-tooltip.top="trans.tooltips.view_license">
                                    <i class="material-icons">visibility</i>
                                </a>

                            </td>
                            <span v-else>
                    {{props.formattedRow[props.column.field]}}
                  </span>

                        </template>


                        <div slot="emptystate" class="vgt-center-align vgt-text-disabled">
                            {{trans.table.no_data_found}}
                        </div>

                    </vue-good-table>
                    <vue-pagination :pagination="licenses"
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
    import VuePagination from './Paginator';
    // import the styles
    import 'vue-good-table/dist/vue-good-table.css'

    Vue.use(VueGoodTable);
    export default {
        props: ['deactivate_endpoint', 'activate_endpoint', 'endpoint', 'baseuri', 'trans', 'locale', 'is_role'],
        data() {
            return {
                licenses: {
                    total: 0,
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                offset: 4,
                loading: false,
                token: token,
                csrf_token:csrf_token,
                columns: [
                    {
                        label: 'S.No',
                        field: 'S.No'
                    },
                    {
                        label: this.trans.table.version,
                        field: 'version',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        filterable: true
                    },
                    {
                        label: this.trans.table.created_by,
                        field: 'user_name',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        filterable: true
                    },
                    {
                        label: this.trans.table.data_time_added,
                        field: 'created_at',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        filterable: true
                    },

                    {
                        label: this.trans.table.action,
                        field: 'action',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        filterable: true
                    }
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
            getRecords() {
                this.loading = true;
                return axios.get(`${this.endpoint}?token=${this.token}&csrf_token=${this.csrf_token}&page=${this.licenses.current_page}`,{
                    headers: {
                        'x-localization': locale
                    }
                }).then((response) => {
                    this.rows = response.data.licenses.data
                    this.licenses = response.data.licenses
                    this.loading = false;

                })
            },

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
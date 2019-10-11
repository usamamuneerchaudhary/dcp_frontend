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

        {{locale}}
        <div class="card">
            <div class="card-header" data-background-color="sitebg">
                <h1><i class="material-icons">account_box</i> {{this.trans.users_administration}}
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
                                placeholder: this.trans.datatable_search.users
                             }"
                            @on-search="onSearch"
                            styleClass="table table-hover table-bordered table-responsive">


                        <template slot="table-row" slot-scope="props">
                            <td v-if="props.column.field == 'S.No'">
                                {{ (users.per_page * (users.current_page - 1)) + (props.index + 1)
                                }}
                            </td>
                            <td v-if="props.column.field === 'action'">
                            <span class="text-center"
                                  v-for="role in props.row.roles"
                                  v-if="user.roles[0].slug ==='superadmin'">


                                <span v-if="role.slug === 'staff' ">
                                <a v-if="props.row.active===true"
                                   class="ionactive"
                                   role="button"
                                   @click.prevent="deactivateUser(props.row.id)"
                                   href="#" v-tooltip.top="trans.tooltips.deactive_user"
                                ><i class="material-icons">lock_open</i></a>

                                <a v-else="props.row.active===false"
                                   class="iondeactive"
                                   @click.prevent="activateUser(props.row.id)"
                                   role="button"
                                   href="#" v-tooltip.top="trans.tooltips.active_user"
                                ><i class="material-icons">lock</i></a>
                                </span>
                                
                                <a
                                        class="ionedit" role="button"
                                        :href="'/'+ this.locale +'/super-admin/users/'+props.row.id+'/edit'"
                                        v-tooltip.top="trans.tooltips.edit_user"
                                        data-placement="left"><i class="material-icons">mode_edit</i></a>

                                <a class="ionremove" href="#" @click.prevent="destroy(props.row.id)"
                                   v-tooltip.top="trans.tooltips.delete_user"
                                   role="button"><i
                                        class="material-icons">delete</i>
                                </a>
                            </span>
                            </td>

                            <td class="text-center"
                                v-if="props.row.licenses.length && props.column.field === 'license'">

                            <span v-if="user.roles[0].slug ==='admin' || user.roles[0].slug ==='superadmin'">
                                <a :href="'/'+ this.locale +'/user-licenses/'+props.row.id">
                                    {{trans.users.view_user_licenses}}
                                </a>
                            </span>

                            </td>


                            <span v-else>
                    {{props.formattedRow[props.column.field]}}
                  </span>

                        </template>

                        <template slot="table-actions" slot-scope="props">


                            <div class="text-right" v-if="user.roles[0].slug === 'superadmin'">

                                <a :href="'/'+this.locale+'/super-admin/users/create'">
                                    <button class="btn blue-btn" type="button">

                                        {{trans.users.add_new}}
                                    </button>
                                </a>
                            </div>
                        </template>


                        <div slot="emptystate" class="vgt-center-align vgt-text-disabled">
                            {{trans.table.no_data_found}}
                        </div>
                    </vue-good-table>
                    <vue-pagination :pagination="users"
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
    // import the styles
    import 'vue-good-table/dist/vue-good-table.css'
    import './MembersNotificationComponent'
    import {EventBus} from "./EventBus";
    import VuePagination from './Paginator';


    Vue.use(VueGoodTable);
    export default {
        props: ['user', 'locale', 'members_count_endpoint', 'deactivate_endpoint', 'activate_endpoint', 'endpoint', 'baseuri', 'trans'],
        data() {
            return {
                users: {
                    searchTerm: '',
                    total: 0,
                    per_page: 10,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                offset: 4,
                loading: false,
                csrf_token: csrf_token,
                token: token,
                count: '',
                columns: [
                    {
                        label: 'S.No',
                        field: 'S.No'
                    },
                    {
                        label: this.trans.users.first_name,
                        field: 'first_name',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        filterable: true
                    },
                    {
                        label: this.trans.users.last_name,
                        field: 'last_name',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        filterable: true,

                    },
                    {
                        label: this.trans.users.email,
                        field: 'email',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        filterable: true
                    },
                    {
                        label: this.trans.table.data_time_added,
                        field: 'created_at',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                    },
                    {
                        label: this.trans.table.action,
                        field: 'action',
                        thClass: 'center-align',
                        tdClass: 'center-align',
                        hidden: this.hiddenActionColumn()
                    },
                    {
                        label: this.trans.users.licenses_information,
                        field: 'license',
                        thClass: 'center-align',
                        tdClass: 'center-align',
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
        mounted() {
            this.getMembersCount();
            this.hiddenActionColumn();
        },
        methods: {
            hiddenActionColumn() {
                return this.user.roles[0].slug == 'admin' ? true : false
            },
            destroy(id) {

                if (!confirm(this.trans.users.are_you_sure_to_delete_user)) {
                    return false;
                }
                axios.delete(`${this.baseuri}api/delete-user/${id}?token=${this.token}&csrf_token=${this.csrf_token}&x-localization=${locale}`, {
                    headers: {
                        'x-localization': locale
                    }
                })
                    .then((response) => {

                        if (response.data) {
                            const indexToDelete = this.rows.findIndex(row => row.id === id)
                            if (indexToDelete !== -1) {

                                swal({
                                    title: this.trans.users.user_deleted,
                                    text: this.trans.users.user_deleted_successfully,
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


            },
            getMembersCount() {

                return axios.get(`${this.members_count_endpoint}?token=${this.token}&csrf_token=${this.csrf_token}`).then((response) => {
                    this.count = response.data.data.inactive_count;
                })
            },
            deactivateUser(id) {
                this.loading = true;
                return axios.put(`${this.deactivate_endpoint}${id}?token=${this.token}&csrf_token=${this.csrf_token}`, {
                    headers: {
                        'x-localization': locale
                    }
                }).then(() => {

                    this.getRecords();
                    // this.getMembersCount();
                    EventBus.$emit('updated-user', 1);
                    this.loading = false;
                    swal({
                        title: this.trans.users.user_deactivated,
                        text: this.trans.users.user_deactivated_success,
                        type: "success",
                        confirmButtonColor: "#004590",
                        cancelButtonColor: '#ef5350',
                        confirmButtonText: this.trans.users.ok_button_text
                    });

                });

            },
            activateUser(id) {
                this.loading = true;
                return axios.put(`${this.activate_endpoint}${id}?token=${this.token}&csrf_token=${this.csrf_token}`, {
                    headers: {
                        'x-localization': locale
                    }
                }).then(() => {
                    this.getRecords();
                    // this.getMembersCount();
                    this.loading = false;

                    EventBus.$emit('updated-user', -1);
                    swal({
                        title: this.trans.users.user_activated,
                        text: this.trans.users.user_activated_success,
                        type: "success",
                        confirmButtonColor: "#004590",
                        cancelButtonColor: '#ef5350',
                        confirmButtonText: this.trans.users.ok_button_text
                    });

                });
            },

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
                return axios.get(`${this.endpoint}?token=${this.token}&csrf_token=${this.csrf_token}&page=${this.users.current_page}&per_page=${this.users.per_page}&searchTerm=${this.users.searchTerm}`, {
                    headers: {
                        'x-localization': locale
                    }
                }).then((response) => {
                    this.rows = response.data.users.data
                    this.users = response.data.users
                    this.loading = false;

                })
            },
            updateParams(newProps) {
                this.users = Object.assign({}, this.users, newProps);
            },
            onSearch: _.debounce(function (params) {
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
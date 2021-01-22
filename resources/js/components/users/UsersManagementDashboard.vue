<template>
    <div>
        <div class="card mt-3" v-if="active.dashboard">
            <div class="card-body">
                <h3>Manage Users <button class="btn btn-sm btn-outline-success float-right" @click="setActive('createUser')"><i class="fas fa-plus"></i> User</button></h3>

                <div v-if="success_message != ''" class="alert alert-info">
                    {{ success_message }}
                </div>

                <div class="alert alert-danger" v-if="unauthorized_message != ''">
                    {{ unauthorized_message }}
                </div>

                <paginator v-if="results !== null" :results="data" v-on:getPage="getPage"></paginator>

                <PaginatorDetail v-if="results !== null" :results="data"></PaginatorDetail>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Since</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="results">
                        <tr v-for="user in results" :key="user.id">
                            <td>{{user.name }}</td>
                            <td>{{user.email }}</td>
                            <td>{{user.user_since }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-secondary" title="View User Logs" @click="viewUserLogs(user)">
                                        <i class="fas fa-list-alt"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" title="Edit User" @click="editUser(user)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-secondary" title="Edit User" @click="editPassword(user)">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" @click="deleteUser(user)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <paginator v-if="results !== null" :results="data" v-on:getPage="getPage"></paginator>

            </div>
        </div>

        <CreateUser v-if="active.createUser" v-on:dashboard="setActive('dashboard')" v-on:create-user-success-info="createUserSuccessFlashMessage"></CreateUser>
        <UserLogs v-if="active.userLogs" :user="user" v-on:dashboard="setActive('dashboard')"></UserLogs>
        <EditUser v-if="active.editUser" v-on:dashboard="setActive('dashboard')" :user="user" v-on:edit-user-success-info="updateUserSuccessFlashMessage"></EditUser>
        <EditUserPassword v-if="active.editPassword" v-on:dashboard="setActive('dashboard')" :user="user" v-on:edit-user-password-success-info="updateUserSuccessFlashMessage" v-on:send-reset-link="updateUserSuccessFlashMessage"></EditUserPassword>
    </div>
</template>

<script>
import Paginator from '../utilities/pagination/Paginator.vue';
import PaginatorDetail from '../utilities/pagination/PaginatorDetail.vue';
import CreateUser from './CreateUser.vue';
import UserLogs from './logs/UserLogs.vue';
import EditUser from './EditUser.vue';
import EditUserPassword from './EditUserPassword.vue';

export default {
    name: 'UsersManagementDashboard',
    components: {
        Paginator, PaginatorDetail, CreateUser, UserLogs, EditUser, EditUserPassword
    },
    data() {
        return {
            results: null,
            params: {
                page: 1
            },
            data: null,
            active: {
                dashboard: true,
                createUser: false,
                userLogs: false,
                editUser: false,
                editPassword: false
            },
            success_message: '',
            unauthorized_message: '',
            user: {}
        }
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        getUsers() {
            axios.get('/data/users', {params: this.params})
                .then(response => {
                    // console.log(response.data.results.data);
                    this.results = response.data.results.data;
                    this.data = response.data.results;
                })
                .catch(errors => {
                    console.log(errors);
                });
        },
        getPage(event)
        {
            this.params.page = event;
            this.getUsers();
            window.scroll(0,0);
        },
        setActive(component)
        {
            Object.keys(this.active).forEach((key) => this.active[key] = false);
            this.active[component] = true;
        },
        createUserSuccessFlashMessage(message)
        {
            this.flashMessageIntervals(message);
            this.getUsers();
        },
        updateUserSuccessFlashMessage(message)
        {
            this.flashMessageIntervals(message);
            this.getUsers();
        },
        flashMessageIntervals(message)
        {
            this.success_message = message;
            setTimeout(() => {
                this.success_message = '';
            }, 5000);
        },
        deleteUser(user)
        {
            let r = confirm('Are you sure want to delete ' + user.name + ' from the system');
            if(r)
            {
                axios.delete('/data/users/'+user.id)
                    .then((response) => {
                        this.flashMessageIntervals('Successfully deleted user');
                        this.getUsers();
                    })
                    .catch((errors) => {
                        if(errors.response.status === 403)
                        {
                           this.flashDanger('Unauthorized to access!'); 
                        }
                    });
            }
        },
        flashDanger(message)
        {
            this.unauthorized_message = message;
            setTimeout(() => {
                this.unauthorized_message = '';
            }, 5000)
        },
        viewUserLogs(user)
        {
            this.user = user;
            this.setActive('userLogs');
        },
        editUser(user)
        {
            this.user = user;
            this.setActive('editUser');
        },
        editPassword(user)
        {
            this.user = user;
            this.setActive('editPassword');
        }
    }
}
</script>

<style>

</style>
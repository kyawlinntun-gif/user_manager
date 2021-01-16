<template>
    <div>
        <div class="card mt-3" v-if="active.dashboard">
            <div class="card-body">
                <h3>Manage Users <button class="btn btn-sm btn-outline-success float-right" @click="setActive('createUser')"><i class="fas fa-plus"></i> User</button></h3>

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
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <paginator v-if="results !== null" :results="data" v-on:getPage="getPage"></paginator>

            </div>
        </div>

        <CreateUser v-if="active.createUser" v-on:dashboard="setActive('dashboard')"></CreateUser>
    </div>
</template>

<script>
import Paginator from '../utilities/pagination/Paginator.vue';
import PaginatorDetail from '../utilities/pagination/PaginatorDetail.vue';
import CreateUser from './CreateUser.vue';

export default {
    name: 'UsersManagementDashboard',
    components: {
        Paginator, PaginatorDetail, CreateUser
    },
    data() {
        return {
            results: null,
            params: {
                page: 1
            },
            data: null,
            active: {
                dashboard: false,
                createUser: true
            }
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
        }
    }
}
</script>

<style>

</style>
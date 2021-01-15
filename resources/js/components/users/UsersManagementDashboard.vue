<template>
    <div class="card mt-3">
        <div class="card-body">
            <h3>Manage Users</h3>

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
                        <td>{{user.created_at }}</td>
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
        </div>
    </div>
</template>

<script>
export default {
    name: 'UsersManagementDashboard',
    data() {
        return {
            results: null,
            params: {
                page: 1
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
                })
                .catch(errors => {
                    console.log(errors);
                });
        }
    }
}
</script>

<style>

</style>
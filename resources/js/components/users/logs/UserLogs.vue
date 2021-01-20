<template>
    <div class="card mt-3">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <button class="btn btn-secondary mr-2" @click="$emit('dashboard')"><i class="fas fa-chevron-left"></i></button><h1 class="mr-2">User Logs</h1> <span>{{ user.name }}</span>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Log Type</th>
                        <th>Message</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody v-if="results != null">
                    <tr v-for="log in results" :key="log.id">
                        <td>{{ log.slug }}</td>
                        <td>{{ log.message }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UserLogs',
    props: [
        'user'
    ],
    data() {
        return {
            params: {
                page: 1
            },
            results: null
        }
    },
    methods: {
        getUserLogs() {
            axios.get('/data/users/logs/' + this.user.id, {params: this.params})
                .then(response => {
                    this.results = response.data.userLogs.data;
                })
                .catch(errors => {
                    console.log(errors);
                });
        }
    },
    mounted() {
        this.getUserLogs();
    }
}
</script>

<style>

</style>
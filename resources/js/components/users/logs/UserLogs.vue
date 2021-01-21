<template>
    <div class="card mt-3">
        <div class="card-body">

            <div class="d-flex align-items-center">
                <button class="btn btn-outline-primary mr-2" @click="$emit('dashboard')"><i class="fas fa-chevron-left"></i> Back</button><h1 class="mr-2">User Logs</h1> <span>{{ user.name }}</span>
            </div>

            <paginator v-if="results !== null" :results="data" v-on:getPage="getPage"></paginator>

            <PaginatorDetail v-if="results !== null" :results="data"></PaginatorDetail>

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

            <paginator v-if="results !== null" :results="data" v-on:getPage="getPage"></paginator>

        </div>
    </div>
</template>

<script>
import Paginator from '../../utilities/pagination/Paginator.vue';
import PaginatorDetail from '../../utilities/pagination/PaginatorDetail.vue';

export default {
    name: 'UserLogs',
    props: [
        'user'
    ],
    components: {
        Paginator, PaginatorDetail
    },
    data() {
        return {
            params: {
                page: 1
            },
            results: null,
            data: null
        }
    },
    methods: {
        getUserLogs() {
            axios.get('/data/users/logs/' + this.user.id, {params: this.params})
                .then(response => {
                    this.data = response.data.userLogs;
                    this.results = response.data.userLogs.data;
                })
                .catch(errors => {
                    console.log(errors);
                });
        },

        getPage(event)
        {
            this.params.page = event;
            this.getUserLogs();
            window.scroll(0,0);
        },
    },
    mounted() {
        this.getUserLogs();
    }
}
</script>

<style>

</style>
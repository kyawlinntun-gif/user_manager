<template>
    <div>
        <div class="card mt-3" v-if="active.dashboard">
            <div class="card-body">
                <h3>Account Settings</h3>

                <table class="table table-hover table-borderless">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td>{{ user.name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ user.email }} <span class="ml-3 badge badge-warning" style="cursor: pointer;" @click="setActive('updatedEmail')">Update</span></td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>{{ user.role }}</td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td>********** <span class="ml-3 badge badge-primary">Send Reset Link</span></td>
                        </tr>
                        <tr>
                            <th>User Since</th>
                            <td>{{ user.user_since }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <UpdatedEmail v-if="active.updatedEmail" :user="user" v-on:dashboard="setActive('dashboard')"></UpdatedEmail>
    </div>
</template>

<script>
import UpdatedEmail from './UpdatedEmail.vue';

export default {
    name: 'UserAccountSettings',
    components: {
        UpdatedEmail
    },
    mounted() {
        this.getUser();
    },
    data() {
        return {
            user: [],
            active: {
                dashboard: true,
                updatedEmail: false,
            }
        }
    },
    methods: {
        getUser() {
            axios.get('/data/accounts/user').then(response => this.user = response.data.user);
        },
        setActive(component)
        {
            Object.keys(this.active).forEach(key => {
                this.active[key] = false;
            });
            this.active[component] = true;
        }
    }
}
</script>

<style>

</style>
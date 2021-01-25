<template>
    <div>
        <div class="card mt-3" v-if="active.dashboard">
            <div class="card-body">
                <h3>Account Settings</h3>

                <hr>

                <div v-if="success_message != ''" class="alert alert-info">
                    {{ success_message }}
                </div>

                <div v-if="errors.length > 0" class="alert alert-danger">
                    <ul v-for="error in errors" :key="error">
                        <li>{{ error }}</li>
                    </ul>
                </div>

                <table class="table table-hover table-borderless">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td v-if="updated_name"><span v-if="updated_name">{{ user.name }}</span><span class="ml-3 badge badge-warning" style="cursor:pointer;" @click="updatedNameForm">Update</span></td>
                            <td v-if="!updated_name">
                                <input type="text" class="form-control-sm" v-model="form.name">
                                <button class="ml-3 badge badge-primary" style="cursor:pointer;" @click="updatedName">Update</button>
                                <button class="ml-3 badge badge-danger" style="cursor:pointer;" @click="cancelName">Cancel</button>
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ user.email }} <span class="ml-3 badge badge-warning" style="cursor: pointer;" @click="setActive('updatedEmail')">Update</span></td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>{{ user.role | capitalize }}</td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td>********** <span class="ml-3 badge badge-primary" @click="passwordReset" style="cursor:pointer;">Send Reset Link</span></td>
                        </tr>
                        <tr>
                            <th>User Since</th>
                            <td>{{ user.user_since }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <UpdatedEmail v-if="active.updatedEmail" :user="user" v-on:dashboard="setActive('dashboard')" v-on:updated-email="updatedEmailFlashMessage"></UpdatedEmail>
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
            },
            success_message: '',
            updated_name: true,
            form: {
                name: ''
            },
            errors: []
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
        },
        updatedEmailFlashMessage(message)
        {
            this.flashMessageIntervals(message);
            this.getUser();
        },
        flashMessageIntervals(message)
        {
            this.success_message = message;
            setTimeout(() => {
                this.success_message = '';
            }, 5000);
        },
        updatedNameForm()
        {
            this.updated_name = false;
            this.form.name = this.user.name;
        },
        updatedName()
        {
            axios.put('/data/accounts/updates/name/' + this.user.id, this.form)
                .then(response => {
                    this.cancelName();
                    this.getUser();
                    this.flashMessageIntervals('Successfully updated name');
                })
                .catch( errors => {
                    if(errors.response.status === 403)
                    {
                        this.errors = ["Not autorized to change this data. Please verfiy your password is corret"];
                    }
                    if(errors.response.status === 422)
                    {
                        this.flashErrors(errors.response.data.errors);
                    }
                });

            // console.log(this.user.id);
        },
        cancelName()
        {
            this.updated_name = true;
            this.errors = [];
        },
        flashErrors(errors)
        {
            for(const [key, value] of Object.entries(errors))
            {
                for(let item in value)
                {
                    this.errors.push(value[item]);
                }
            }
        },
        passwordReset() {
            axios.post('/data/users/updated/send-reset-link/' + this.user.id)
                .then((response) => {
                    this.flashMessageIntervals('Successfully sent reset link to' + response.data.user.name);
                });
        }
    },
    filters: {
        capitalize: function (value) {
            if (!value) return ''
            value = value.toString()
            return value.charAt(0).toUpperCase() + value.slice(1)
        }
    }
}
</script>

<style>

</style>
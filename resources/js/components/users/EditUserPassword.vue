<template>
    <div class="card mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h3><button class="btn btn-sm btn-outline-success" @click="$emit('dashboard')"><i class="fas fa-chevron-left"></i> Back</button> Change User Password</h3>

                <div>
                    <button class="btn btn-sm btn-outline-primary" @click.prevent="passwordReset">Send Reset Link</button>
                </div>
            </div>

            <hr>

            <div class="alert alert-warning" role="alert" v-if="errors.length > 0">
                <ul v-for="error in errors" :key="error">
                    <li>{{ error }}</li>
                </ul>
            </div>

            <form @submit.prevent="editUserPassword">
                <div class="form-group row">
                    <label for="password" class="col-3">Password</label>
                    <div class="col-9">
                        <input type="password" class="form-control" v-model="form.password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="confirm_password" class="col-3">Confirm Password</label>
                    <div class="col-9">
                        <input type="password" class="form-control" v-model="form.confirm_password">
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Update Password</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EditUserPassword',
    props: [
        'user'
    ],
    data() {
        return {
            form: {
                password: '',
                confirm_password: ''
            },
            errors: [],
        }
    },
    mounted() {
        this.assignUserToForm();
    },
    watch: {
        user () {
            this.assignUserToForm();
        }
    },
    created() {
        this.resetForm();
    },
    methods: {
        assignUserToForm() {
            Object.keys(this.form).forEach((key) => this.form[key] = this.user[key]);
        },
        editUserPassword()
        {
            this.errors = [];
            axios.put('/data/users/updated/password/' + this.user.id, this.form)
                .then(response => {
                    this.resetForm();
                    this.$emit('dashboard');
                    this.$emit('edit-user-password-success-info', response.data.user.name + "'s password has been updated");
                })
                .catch(errors => {
                    if(errors.response.status === 422)
                    {
                        this.flashErrors(errors.response.data.errors);
                    }
                    else if(errors.response.status === 403)
                    {
                        this.errors = ["You are not authorized to create users"];
                    }
                });
        },
        flashErrors(errors)
        {
            // for(const [key, value] of Object.entries(errors))
            // {
            //     this.errors.push(value);
            // }
            // console.log(this.errors);

            for(const [key, value] of Object.entries(errors))
            {
                for(let item in value)
                {
                    this.errors.push(value[item]);
                }
            }
        },
        resetForm() {
            this.form.password = '';
            this.form.confirm_password = '';
        },
        passwordReset() {
            axios.post('/data/users/updated/send-reset-link/' + this.user.id)
                .then((response) => {
                    this.$emit('dashboard');
                    this.$emit('send-reset-link', 'Successfully sent reset link to' + response.data.user.name);
                });
        }
    }
}
</script>

<style>

</style>
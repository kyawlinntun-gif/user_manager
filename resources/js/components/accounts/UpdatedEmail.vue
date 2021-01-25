<template>
    <div class="card mt-3">
        <div class="card-body">
            <h3><button class="btn btn-sm btn-outline-success" @click="$emit('dashboard')"><i class="fas fa-chevron-left"></i> Back</button> Updated Email {{ user.email }}</h3>

            <hr>

            <div class="alert alert-warning" role="alert" v-if="errors.length > 0">
                <ul v-for="error in errors" :key="error">
                    <li>{{ error }}</li>
                </ul>
            </div>

            <form @submit.prevent="updatedEmail">
                <div class="form-group row">
                    <label for="email" class="col-3">Email</label>
                    <div class="col-9">
                        <input type="email" class="form-control" v-model="form.email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-3">Password</label>
                    <div class="col-9">
                        <input type="password" class="form-control" v-model="form.password">
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Updated Email</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UpdatedEmail',
    props: [
        'user'
    ],
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            errors: []
        }
    },
    mounted() {
        this.form.email = this.user.email;
    },
    methods: {
        updatedEmail() {
            axios.put('/data/accounts/updates/user/' + this.user.id, this.form)
                .then(response => {
                    this.resetForm();
                    this.$emit('dashboard');
                    this.$emit('updated-email', 'Successfully updated the email for ' + response.data.user.name);
                })
                .catch(errors => {
                    if(errors.response.status === 422)
                    {
                        this.flashErrors(errors.response.data.errors);
                    }
                    else if(errors.response.status === 403)
                    {
                        this.errors = ["Not autorized to change this data. Please verfiy your password is corret"];
                    }
                });
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
        resetForm()
        {
            this.form.email = '';
            this.form.password = '';
        }
    }
}
</script>

<style>

</style>
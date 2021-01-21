<template>
    <div class="card mt-3">
        <div class="card-body">
            <h3><button class="btn btn-sm btn-outline-success" @click="$emit('dashboard')"><i class="fas fa-chevron-left"></i> Back</button> Edit New User</h3>

            <hr>

            <div class="alert alert-warning" role="alert" v-if="errors.length > 0">
                <ul v-for="error in errors" :key="error">
                    <li>{{ error }}</li>
                </ul>
            </div>

            <form @submit.prevent="editUser">
                <div class="form-group row">
                    <label for="name" class="col-3">Name</label>
                    <div class="col-9">
                        <input type="text" class="form-control" v-model="form.name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-3">Email</label>
                    <div class="col-9">
                        <input type="email" class="form-control" v-model="form.email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="role" class="col-3">Role</label>
                    <div class="col-9">
                        <select name="role" class="form-control" v-model="form.role">
                            <option :value="'user'">User</option>
                            <option :value="'admin'">Admin</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Update User</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EditUser',
    props: [
        'user'
    ],
    data() {
        return {
            form: {
                name: '',
                email: '',
                role: 'user'
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
        editUser()
        {
            this.errors = [];
            axios.put('/data/users/' + this.user.id, this.form)
                .then(response => {
                    this.resetForm();
                    this.$emit('dashboard');
                    this.$emit('edit-user-success-info', response.data.user.name + "'s profile has been updated");
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
            this.form.name = '';
            this.form.email = '';
        }
    }
}
</script>

<style>

</style>
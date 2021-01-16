<template>
    <div class="card mt-3">
        <div class="card-body">
            <h3><button class="btn btn-sm btn-outline-success" @click="$emit('dashboard')"><i class="fas fa-chevron-left"></i> Back</button> Create New User</h3>

            <hr>

            <form @submit.prevent="storeUser">
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
                <button class="btn btn-primary" type="submit">Create User</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CreateUser',
    data() {
        return {
            form: {
                name: '',
                email: '',
                role: 'user',
                password: '',
                confirm_password: ''
            }
        }
    },
    methods: {
        storeUser()
        {
            axios.post('/data/users', this.form)
                .then(response => {
                    console.log(response);
                })
                .catch(errors => {
                    console.log(errors)
                });
        }
    }
}
</script>

<style>

</style>
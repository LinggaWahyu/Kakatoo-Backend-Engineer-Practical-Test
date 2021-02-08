<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h3><b>Login</b></h3>
                    </div>
                    <div class="card-body">
                        <form action="#" method="post" @submit.prevent="login">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input
                                    type="text"
                                    v-model="form.username"
                                    class="form-control"
                                    id="username"
                                />
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input
                                    type="password"
                                    v-model="form.password"
                                    class="form-control"
                                    id="password"
                                />
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Login
                                <template v-if="loading">
                                    <img src="/Spinner-1s-200px.svg" />
                                </template>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                username: "",
                password: ""
            },
            theErrors: "",
            loading: false
        };
    },
    mounted() {},
    methods: {
        async login() {
            this.loading = true;
            try {
                let response = await axios.post("/api/auth/login", this.form);
                if (response.status === 200) {
                    this.form.username = "";
                    this.form.password = "";
                    this.theErrors = "";

                    this.loading = false;

                    this.$toasted.show("login successfully", {
                        type: "success",
                        duration: 5000
                    });

                    this.$router.push({
                        path: "home",
                        query: { token: response.data.token }
                    });
                }
            } catch (e) {
                this.loading = false;
                this.form.password = "";
                this.$toasted.show(`${e.response.data.message}`, {
                    type: "error",
                    duration: 5000
                });
                this.theErrors = e.response.data.message;
            }
        }
    }
};
</script>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div v-if="auth" class="col-12 mb-4">
                <h5>Board Home Page</h5>
                <button
                    ref="logout"
                    @click="logout"
                    type="button"
                    class="btn btn-danger btn-sm float-right"
                >
                    Logout
                </button>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Register User
                    </div>
                    <div class="card-body">
                        <form
                            action="#"
                            method="post"
                            @submit.prevent="register"
                        >
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input
                                    type="text"
                                    v-model="form.name"
                                    id="name"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input
                                    type="email"
                                    v-model="form.email"
                                    id="email"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input
                                    type="text"
                                    v-model="form.username"
                                    id="username"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input
                                    type="password"
                                    v-model="form.password"
                                    id="password"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation"
                                    >Password Confirmation</label
                                >
                                <input
                                    type="password"
                                    v-model="form.password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="profile_id">Profile</label>
                                <select
                                    v-model="form.profile_id"
                                    id="profile_id"
                                    class="form-control"
                                    required
                                >
                                    <option
                                        v-for="profile in profiles"
                                        :key="profile.id"
                                        :value="profile.id"
                                    >
                                        {{ profile.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="skill">Skill</label>
                                <select
                                    v-model="form.skill_id"
                                    id="skill"
                                    class="form-control"
                                >
                                    <option
                                        v-for="skill in skills"
                                        :key="skill.id"
                                        :value="skill.id"
                                    >
                                        {{ skill.skill_name }}
                                    </option>
                                </select>
                            </div>
                            <button
                                type="submit"
                                class="btn btn-primary d-flex align-items-center"
                            >
                                Save
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
                name: "",
                email: "",
                username: "",
                password: "",
                password_confirmation: "",
                profile_id: "",
                skill_id: ""
            },
            loading: false,
            auth: false,
            profiles: [],
            skills: []
        };
    },
    mounted() {
        this.checkUser();
        this.getProfiles();
        this.getSkills();
    },
    methods: {
        async checkUser() {
            try {
                let response = await axios.get("/api/auth/user", {
                    headers: {
                        Authorization: this.$route.query.token
                    }
                });

                if (response.status == 200) {
                    if (response.data.profile == "board") {
                        this.auth = true;
                    } else {
                        this.auth = false;

                        this.$toasted.show(
                            `You don't have access to this page`,
                            {
                                type: "error",
                                duration: 5000
                            }
                        );

                        this.$router.push({
                            path: `/${response.data.profile}/home`,
                            query: { token: this.$route.query.token }
                        });
                    }
                }
            } catch (error) {
                this.$toasted.show(`You must login to access that page`, {
                    type: "error",
                    duration: 5000
                });

                this.$router.push({
                    path: "/"
                });
            }
        },
        async getProfiles() {
            let response = await axios.get("/api/profiles", {
                headers: {
                    Authorization: this.$route.query.token
                }
            });
            if (response.status === 200) {
                this.profiles = response.data;
            }
        },
        async getSkills() {
            let response = await axios.get("/api/skills", {
                headers: {
                    Authorization: this.$route.query.token
                }
            });
            if (response.status === 200) {
                this.skills = response.data;
            }
        },
        async register() {
            this.loading = true;
            try {
                let response = await axios.post("/api/user", this.form, {
                    headers: {
                        Authorization: this.$route.query.token
                    }
                });
                if (response.status === 200) {
                    this.form.name = "";
                    this.form.email = "";
                    this.form.username = "";
                    this.form.password = "";
                    this.form.password_confirmation = "";

                    this.loading = false;

                    this.$toasted.show(response.data.message, {
                        type: "success",
                        duration: 5000
                    });
                }
            } catch (e) {
                this.loading = false;
                this.$toasted.show("Something went wrong.", {
                    type: "error",
                    duration: 5000
                });
            }
        },
        async logout() {
            let q = window.confirm("Are you sure ?");

            if (q == true) {
                let response = await axios.get("/api/auth/logout", {
                    headers: {
                        Authorization: this.$route.query.token
                    }
                });

                if (response.status == 200) {
                    this.$toasted.show(response.data.message, {
                        type: "success",
                        duration: 5000
                    });

                    this.auth = false;

                    this.$router.push({
                        name: "login"
                    });
                }
            }
        }
    }
};
</script>

<template>
    <div class="container">
        <div class="row">
            <div v-if="auth" class="col-12 mb-4">
                <h5>Expert Create Activity</h5>
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
                        New Activity
                    </div>
                    <div class="card-body">
                        <form action="#" method="post" @submit.prevent="store">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input
                                    type="text"
                                    v-model="form.title"
                                    id="title"
                                    class="form-control"
                                />
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea
                                    v-model="form.description"
                                    id="description"
                                    class="form-control"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="startdate">Start Date</label>
                                <input
                                    type="date"
                                    v-model="form.startdate"
                                    id="startdate"
                                    class="form-control"
                                />
                            </div>
                            <div class="form-group">
                                <label for="enddate">End Date</label>
                                <input
                                    type="date"
                                    v-model="form.enddate"
                                    id="enddate"
                                    class="form-control"
                                />
                            </div>
                            <div class="form-group">
                                <label for="skill">Skill</label>
                                <select
                                    v-model="form.skill_id"
                                    id="skill"
                                    class="form-control"
                                    @change="getUsers"
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
                            <div class="form-group">
                                <div
                                    class="form-check"
                                    v-for="user in users"
                                    :key="user.id"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        :value="user.id"
                                        v-model="form.participans"
                                        :id="user.id"
                                    />
                                    <label
                                        class="form-check-label"
                                        :for="user.id"
                                    >
                                        {{ user.name }}
                                    </label>
                                </div>
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
                skill_id: "",
                title: "",
                description: "",
                startdate: "",
                enddate: "",
                participans: []
            },
            auth: false,
            loading: false,
            skills: [],
            users: []
        };
    },
    mounted() {
        this.checkUser();
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
                    if (response.data.profile == "expert") {
                        this.auth = true;
                    } else {
                        this.auth = false;

                        this.$toasted.show(
                            `You don't have access to that page`,
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
                this.$toasted.show(`You must login to access this page`, {
                    type: "error",
                    duration: 5000
                });

                this.$router.push({
                    path: "/"
                });
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
        async getUsers() {
            try {
                let response = await axios.get(
                    `/api/users/${this.form.skill_id}`,
                    {
                        headers: {
                            Authorization: this.$route.query.token
                        }
                    }
                );
                if (response.status === 200) {
                    this.users = response.data;
                }
            } catch (error) {}
        },
        async store() {
            this.loading = true;
            try {
                let response = await axios.post("/api/activity", this.form, {
                    headers: {
                        Authorization: this.$route.query.token
                    }
                });
                if (response.status === 200) {
                    this.form.title = "";
                    this.form.description = "";
                    this.form.startdate = "";
                    this.form.enddate = "";
                    this.form.skill_id = "";
                    this.form.participans = "";

                    this.loading = false;

                    this.$toasted.show(response.data.message, {
                        type: "success",
                        duration: 5000
                    });

                    this.$router.push({
                        path: "/expert/home",
                        query: { token: this.$route.query.token }
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

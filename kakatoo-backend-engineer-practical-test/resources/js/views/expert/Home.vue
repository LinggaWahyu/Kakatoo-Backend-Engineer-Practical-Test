<template>
    <div class="container">
        <div class="row justify-content-center">
            <div v-if="auth" class="col-12 mb-4">
                <h5>Expert Home Page</h5>
                <router-link
                    :to="{
                        name: 'activity.create',
                        query: { token: this.$route.query.token }
                    }"
                    class="btn btn-primary"
                >
                    + Create Activity
                </router-link>
                <button
                    ref="logout"
                    @click="logout"
                    type="button"
                    class="btn btn-danger btn-sm float-right"
                >
                    Logout
                </button>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h3><b>List of Activities</b></h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Participans</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(activity, index) in activities"
                                    :key="index"
                                >
                                    <td>{{ activity.title }}</td>
                                    <td>{{ activity.description }}</td>
                                    <td>{{ activity.startdate }}</td>
                                    <td>{{ activity.enddate }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                            data-toggle="modal"
                                            :data-target="
                                                `#listParticipans-${index}`
                                            "
                                        >
                                            See List Participans
                                        </button>
                                        <div
                                            class="modal fade"
                                            :id="`listParticipans-${index}`"
                                            tabindex="-1"
                                            aria-labelledby="listParticipantsLabel"
                                            aria-hidden="true"
                                        >
                                            <div
                                                class="modal-dialog modal-dialog-centered"
                                            >
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5
                                                            class="modal-title"
                                                            id="staticBackdropLabel"
                                                        >
                                                            List of Participans
                                                            <b>{{
                                                                activity.title
                                                            }}</b>
                                                        </h5>
                                                        <button
                                                            type="button"
                                                            class="close"
                                                            data-dismiss="modal"
                                                            aria-label="Close"
                                                        >
                                                            <span
                                                                aria-hidden="true"
                                                                >&times;</span
                                                            >
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th
                                                                        scope="col"
                                                                    >
                                                                        Name
                                                                    </th>
                                                                    <th
                                                                        scope="col"
                                                                    >
                                                                        Profile
                                                                    </th>
                                                                    <th
                                                                        scope="col"
                                                                    >
                                                                        Skill
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr
                                                                    v-for="participan in activity.participans"
                                                                    :key="
                                                                        participan.id
                                                                    "
                                                                >
                                                                    <td>
                                                                        {{
                                                                            participan.name
                                                                        }}
                                                                    </td>
                                                                    <td>
                                                                        {{
                                                                            participan.profile
                                                                        }}
                                                                    </td>
                                                                    <td>
                                                                        {{
                                                                            participan.skill
                                                                        }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <router-link
                                            :to="{
                                                name: 'activity.edit',
                                                query: {
                                                    token: token
                                                },
                                                params: { id: activity.id }
                                            }"
                                            class="btn btn-success"
                                        >
                                            Edit
                                        </router-link>
                                        <delete-activity
                                            :endpoint="activity.id"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DeleteActivity from "./Delete";

export default {
    components: {
        DeleteActivity
    },
    data() {
        return {
            activities: [],
            auth: false,
            token: this.$route.query.token
        };
    },
    mounted() {
        this.checkUser();
        this.getListActivities();
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
        async getListActivities() {
            let responseActivities = await axios.get(`/api/activities`, {
                headers: {
                    Authorization: this.$route.query.token
                }
            });
            this.activities = responseActivities.data;
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

                    this.$router.push({
                        name: "login"
                    });
                }
            }
        }
    }
};
</script>

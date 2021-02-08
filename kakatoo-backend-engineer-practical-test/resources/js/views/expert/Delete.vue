<template>
    <button
        class="btn btn-danger"
        ref="destroyActivity"
        @click="destroyActivity"
    >
        Delete
    </button>
</template>

<script>
export default {
    props: ["endpoint"],
    methods: {
        async destroyActivity() {
            let q = window.confirm("Are you sure ?");

            if (q == true) {
                let response = await axios.delete(
                    `/api/activity/${this.endpoint}`,
                    {
                        headers: {
                            Authorization: this.$route.query.token
                        }
                    }
                );

                if (response.status == 200) {
                    this.$toasted.show(response.data.message, {
                        type: "success",
                        duration: 5000
                    });

                    this.$refs.destroyActivity.parentNode.parentNode.remove();
                }
            }
        }
    }
};
</script>

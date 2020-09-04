<template>
    <div>

        <section v-if="alert.status">
            <div class="alert my-3" :class="[alert.type, alert.dismissible ? 'alert-dismissible fade show' : '']"  role="alert">
                {{alert.text}}
                <!--
                <button v-if="alert.dismissible" type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                -->
            </div>
        </section>

    </div>
</template>

<script>
export default {
    props: {
        alert:{
            type: Object,
            required: true
        }
    }
}
</script>

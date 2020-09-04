<template>
    <div>

        <div id="capa" class="flex-center full-height position-absolute">
            <div class="spinner-border text-success" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
    #capa {
        width: 100%;
        top: 0;
        left: 0;
        background-color: #d1f4da96;
        z-index: 1;
    }
    .flex-center{
        align-items: center;
        display: flex;
        justify-content: center;
    }
    .full-height {
        height: 100vh;
    }

</style>

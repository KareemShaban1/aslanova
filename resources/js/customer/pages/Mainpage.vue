<template>
    <div class="main-sec">
        <div class="overlay">
            <div class="content">
                <h1 class="text-light">Hello in our website</h1>
                <div>
                    <router-link to="/dashboard/categories" class="btn btn-primary">Our category</router-link>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {

}
</script>

<style scoped>
.main-sec {
    background-image: url(/img/website/sofa.webp);
    width: 100%;
    height: 50vh;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    border-radius: 15px;
    /* Adding rounded corners to the main section */
    overflow: hidden;
    /* Ensures the background image respects the border radius */
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    /* Adjust the transparency here */
    display: flex;
    justify-content: center;
    align-items: center;
}

.main-sec .content {
    position: relative;
    text-align: center;
}

.main-sec .content h1 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.main-sec .content .btn {
    padding: 0.75rem 1.5rem;
    font-size: 1.25rem;
}
</style>
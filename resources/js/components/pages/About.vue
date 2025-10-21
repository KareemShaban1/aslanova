<template>
    <div>
        <!-- Start Hero Section -->
        <div class="hero">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-5">
                        <div class="intro-excerpt">
                            <h1>{{ $t('aboutUs') }}</h1>
                            <p class="mb-4">{{ $t('sectionDescription') }}</p>
                            <p>
                                <a href="#" class="btn btn-secondary me-2">{{ $t('shop_now') }}</a>
                                <a href="#" class="btn btn-white-outline">{{ $t('explore') }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="hero-img-wrap">
                            <img src="./images/couch.png" alt="Stylish couch" class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Hero Section -->

        <!-- Start Why Choose Us Section -->
        <div class="why-choose-section">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-6">
                        <h2 class="section-title">{{ $t('whyChooseUs') }}</h2>
                        <p>{{ $t('sectionDescription') }}</p>
                        <div class="row my-5">
                            <div v-for="feature in features" :key="feature.id" class="col-6">
                                <div class="feature-item">
                                    <h3>{{ feature.title }}</h3>
                                    <p>{{ feature.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="img-wrap">
                            <img src="./images/why-choose-us-img.jpg" alt="Reasons to choose us" class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Why Choose Us Section -->

        <!-- Start Team Section -->
        <div class="untree_co-section">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-lg-5 mx-auto text-center">
                        <h2 class="section-title">{{ $t('ourTeam') }}</h2>
                    </div>
                </div>
                <div class="row">
                    <div v-for="member in teamMembers" :key="member.id" class="col-lg-4 text-center">
                        <img :src="member.photo" :alt="member.name" class="img-fluid rounded-circle" />
                        <h5>{{ member.name }}</h5>
                        <p>{{ member.position }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Team Section -->

        <!-- Start Testimonial Slider -->
        <div class="testimonial-section before-footer-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 mx-auto text-center">
                        <h2 class="section-title">{{ $t('testimonials') }}</h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="testimonial-slider-wrap text-center">
                            <div id="testimonial-nav">
                                <span class="prev" data-controls="prev">{{ $t('testimonialPrev') }}</span>
                                <span class="next" data-controls="next">{{ $t('testimonialNext') }}</span>
                            </div>
                            <div class="testimonial-slider">
                                <div v-for="testimonial in testimonials" :key="testimonial.id" class="testimonial-item">
                                    <p>{{ testimonial.message }}</p>
                                    <h5>- {{ testimonial.author }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Testimonial Slider -->
    </div>
</template>

<script>

export default {
    name: 'About',
    data() {
        return {
            features: [
                { id: 1, title: this.$t('feature1Title'), description: this.$t('feature1Description') },
                { id: 2, title: this.$t('feature2Title'), description: this.$t('feature2Description') },
                // Add more features as needed
            ],
            teamMembers: [
                { id: 1, name: this.$t('member1Name'), position: this.$t('member1Position'), photo: '/images/person_1.jpg' },
                { id: 2, name: this.$t('member2Name'), position: this.$t('member2Position'), photo: '/images/person_2.jpg' },
                // Add more members as needed
            ],
            testimonials: [
                { id: 1, message: this.$t('testimonial1Message'), author: this.$t('testimonial1Author') },
                { id: 2, message: this.$t('testimonial2Message'), author: this.$t('testimonial2Author') },
                // Add more testimonials as needed
            ],
        };
    },
}
</script>

<style scoped>
/* Add your custom styles here */
</style>

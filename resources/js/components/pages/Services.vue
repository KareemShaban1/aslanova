<template>
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>{{ $t('services') }}</h1>
                        <p class="mb-4">{{ $t('hero_description') }}</p>
                        <p>
                            <a href="" class="btn btn-secondary me-2">{{ $t('shop_now') }}</a>
                            <a href="#" class="btn btn-white-outline">{{ $t('explore') }}</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="hero-img-wrap">
                        <img src="./images/couch.png" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->
    
    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section">
        <div class="container">
            <div class="row my-5">
                <div class="col-6 col-md-6 col-lg-3 mb-4">
                    <div class="feature">
                        <div class="icon">
                            <img src="./images/truck.svg" alt="Image" class="imf-fluid">
                        </div>
                        <h3>{{ $t('fast_and_free_shipping') }}</h3>
                        <p>{{ $t('fast_and_free_shipping_description') }}</p>
                    </div>
                </div>
    
                <div class="col-6 col-md-6 col-lg-3 mb-4">
                    <div class="feature">
                        <div class="icon">
                            <img src="./images/bag.svg" alt="Image" class="imf-fluid">
                        </div>
                        <h3>{{ $t('easy_to_shop') }}</h3>
                        <p>{{ $t('easy_to_shop_description') }}</p>
                    </div>
                </div>
    
                <div class="col-6 col-md-6 col-lg-3 mb-4">
                    <div class="feature">
                        <div class="icon">
                            <img src="./images/support.svg" alt="Image" class="imf-fluid">
                        </div>
                        <h3>{{ $t('support_24_7') }}</h3>
                        <p>{{ $t('support_24_7_description') }}</p>
                    </div>
                </div>
    
                <div class="col-6 col-md-6 col-lg-3 mb-4">
                    <div class="feature">
                        <div class="icon">
                            <img src="./images/return.svg" alt="Image" class="imf-fluid">
                        </div>
                        <h3>{{ $t('hassle_free_returns') }}</h3>
                        <p>{{ $t('hassle_free_returns_description') }}</p>
                    </div>
                </div>
    
                <!-- Repeat the above blocks for additional features as needed -->
            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->
    
    <!-- Start Product Section -->
    <div class="product-section pt-0">
        <div class="container">
            <div class="row">
                <!-- Start Column 1 -->
                <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
                    <h2 class="mb-4 section-title">{{ $t('crafted_with_material') }}</h2>
                    <p class="mb-4">{{ $t('crafted_with_material_description') }}</p>
                    <p><a href="#" class="btn">{{ $t('explore') }}</a></p>
                </div>
                <!-- End Column 1 -->
    
                <!-- Start Column 2 -->
                <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                    <a class="product-item" href="#">
                        <img src="./images/product-1.png" class="img-fluid product-thumbnail">
                        <h3 class="product-title">{{ $t('nordic_chair') }}</h3>
                        <strong class="product-price">{{ $t('price', { value: 50 }) }}</strong>
                        <span class="icon-cross">
                            <img src="./images/cross.svg" class="img-fluid">
                        </span>
                    </a>
                </div>
                <!-- End Column 2 -->
    
                <!-- Start Column 3 -->
                <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                    <a class="product-item" href="#">
                        <img src="./images/product-2.png" class="img-fluid product-thumbnail">
                        <h3 class="product-title">{{ $t('kruzo_aero_chair') }}</h3>
                        <strong class="product-price">{{ $t('price', { value: 78 }) }}</strong>
                        <span class="icon-cross">
                            <img src="./images/cross.svg" class="img-fluid">
                        </span>
                    </a>
                </div>
                <!-- End Column 3 -->
    
                <!-- Start Column 4 -->
                <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                    <a class="product-item" href="#">
                        <img src="./images/product-3.png" class="img-fluid product-thumbnail">
                        <h3 class="product-title">{{ $t('ergonomic_chair') }}</h3>
                        <strong class="product-price">{{ $t('price', { value: 43 }) }}</strong>
                        <span class="icon-cross">
                            <img src="./images/cross.svg" class="img-fluid">
                        </span>
                    </a>
                </div>
                <!-- End Column 4 -->
            </div>
        </div>
    </div>
    <!-- End Product Section -->
    
    <!-- End Product Section -->
</template>

<script>
export default {
    name: 'Services',
};
</script>

<style scoped>
.hero.page-inner.overlay {
    position: relative;
    background-size: cover;
    background-position: center;
    height: 300px;
    color: white;
}

.section {
    padding: 50px 0;
}

.service {
    text-align: center;
    margin-bottom: 30px;
}

.icon-service {
    font-size: 50px;
    color: #ffcc00;
    margin-bottom: 20px;
}

h3 {
    font-size: 24px;
    margin-bottom: 20px;
}

.readmore {
    color: #ffcc00;
    text-decoration: none;
}

.readmore:hover {
    text-decoration: underline;
}
</style>
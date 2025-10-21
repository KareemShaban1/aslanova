<template>
    <div class="ecommerce-application">
        <div class="content-overlay"></div>
        <div ></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">
                                Checkout
                            </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <router-link to="/categories"
                                            >eCommerce</router-link
                                        >
                                    </li>
                                    <li class="breadcrumb-item active">
                                        Checkout
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none"
                >
                    <div class="mb-1 breadcrumb-right">
                        <div class="dropdown">
                            <button
                                class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >
                                <i data-feather="grid"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="app-todo.html"
                                    ><i
                                        class="me-1"
                                        data-feather="check-square"
                                    ></i
                                    ><span class="align-middle">Todo</span></a
                                ><a class="dropdown-item" href="app-chat.html"
                                    ><i
                                        class="me-1"
                                        data-feather="message-square"
                                    ></i
                                    ><span class="align-middle">Chat</span></a
                                ><a class="dropdown-item" href="app-email.html"
                                    ><i class="me-1" data-feather="mail"></i
                                    ><span class="align-middle">Email</span></a
                                ><a
                                    class="dropdown-item"
                                    href="app-calendar.html"
                                    ><i class="me-1" data-feather="calendar"></i
                                    ><span class="align-middle"
                                        >Calendar</span
                                    ></a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="bs-stepper checkout-tab-steps">
                    <div class="bs-stepper-content">
                        <!-- Checkout Place order starts -->
                        <div
                            id="step-cart"
                            class="content"
                            role="tabpanel"
                            aria-labelledby="step-cart-trigger"
                        >
                            <div
                                id="place-order"
                                class="list-view product-checkout"
                            >
                                <div class="checkout-items">
                                    <div class="card ecommerce-card">
                                        <div class="item-img">
                                            <a
                                                href="app-ecommerce-details.html"
                                            >
                                                <img
                                                    src="/1.png"
                                                    alt="img-placeholder"
                                                />
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="item-name">
                                                <h6 class="mb-0">
                                                    <a
                                                        href="#"
                                                        class="text-body"
                                                        >Loft</a
                                                    >
                                                </h6>
                                                <div class="item-rating">
                                                    <ul
                                                        class="unstyled-list list-inline"
                                                    >
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <span class="text-success mb-1"
                                                >In Stock</span
                                            >
                                            <div class="item-quantity">
                                                <span class="quantity-title"
                                                    >Qty:</span
                                                >
                                                <div
                                                    class="quantity-counter-wrapper"
                                                >
                                                    <div class="input-group">
                                                        <input
                                                            type="text"
                                                            class="quantity-counter"
                                                            value="1"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <span
                                                class="delivery-date text-muted"
                                                >Delivery by, Wed Apr 24</span
                                            >
                                            <span class="text-success"
                                                >7% off 1 offers Available</span
                                            >
                                        </div>
                                        <div class="item-options text-center">
                                            <div class="item-wrapper">
                                                <div class="item-cost">
                                                    <h4 class="item-price">
                                                        $4999.99
                                                    </h4>
                                                    <p
                                                        class="card-text shipping"
                                                    >
                                                        <span
                                                            class="badge rounded-pill badge-light-success"
                                                            >Free Shipping</span
                                                        >
                                                    </p>
                                                </div>
                                            </div>
                                            <button
                                                type="button"
                                                class="btn btn-light mt-1 remove-wishlist"
                                            >
                                                <i
                                                    data-feather="x"
                                                    class="align-middle me-25"
                                                ></i>
                                                <span>Remove</span>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-primary btn-cart move-cart"
                                            >
                                                <i
                                                    data-feather="heart"
                                                    class="align-middle me-25"
                                                ></i>
                                                <span class="text-truncate"
                                                    >Add to Wishlist</span
                                                >
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card ecommerce-card">
                                        <div class="item-img">
                                            <a
                                                href="app-ecommerce-details.html"
                                            >
                                                <img
                                                    src="/2.png"
                                                    alt="img-placeholder"
                                                />
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="item-name">
                                                <h6 class="mb-0">
                                                    <a
                                                        href="#"
                                                        class="text-body"
                                                        >Sultan</a
                                                    >
                                                </h6>
                                                <div class="item-rating">
                                                    <ul
                                                        class="unstyled-list list-inline"
                                                    >
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="unfilled-star"
                                                            ></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <span class="text-success mb-1"
                                                >In Stock</span
                                            >
                                            <div class="item-quantity">
                                                <span class="quantity-title"
                                                    >Qty:</span
                                                >
                                                <div
                                                    class="quantity-counter-wrapper"
                                                >
                                                    <div class="input-group">
                                                        <input
                                                            type="text"
                                                            class="quantity-counter"
                                                            value="1"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <span
                                                class="delivery-date text-muted"
                                                >Delivery by, Wed Apr 27</span
                                            >
                                            <span class="text-success"
                                                >3% off 1 offers Available</span
                                            >
                                        </div>
                                        <div class="item-options text-center">
                                            <div class="item-wrapper">
                                                <div class="item-cost">
                                                    <h4 class="item-price">
                                                        $4499.99
                                                    </h4>
                                                </div>
                                            </div>
                                            <button
                                                type="button"
                                                class="btn btn-light mt-1 remove-wishlist"
                                            >
                                                <i
                                                    data-feather="x"
                                                    class="align-middle me-25"
                                                ></i>
                                                <span>Remove</span>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-primary btn-cart move-cart"
                                            >
                                                <i
                                                    data-feather="heart"
                                                    class="align-middle me-25"
                                                ></i>
                                                <span class="text-truncate"
                                                    >Add to Wishlist</span
                                                >
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card ecommerce-card">
                                        <div class="item-img">
                                            <a
                                                href="app-ecommerce-details.html"
                                            >
                                                <img
                                                    src="/3.png"
                                                    alt="img-placeholder"
                                                />
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="item-name">
                                                <h6 class="mb-0">
                                                    <a
                                                        href="#"
                                                        class="text-body"
                                                        >Bella</a
                                                    >
                                                </h6>
                                                <div class="item-rating">
                                                    <ul
                                                        class="unstyled-list list-inline"
                                                    >
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="unfilled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="unfilled-star"
                                                            ></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <span class="text-success mb-1"
                                                >In Stock</span
                                            >
                                            <div class="item-quantity">
                                                <span class="quantity-title"
                                                    >Qty:</span
                                                >
                                                <div
                                                    class="quantity-counter-wrapper"
                                                >
                                                    <div class="input-group">
                                                        <input
                                                            type="text"
                                                            class="quantity-counter"
                                                            value="1"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <span
                                                class="delivery-date text-muted"
                                                >Delivery by, Wed Apr 29</span
                                            >
                                            <span class="text-success"
                                                >5% off 2 offers Available</span
                                            >
                                        </div>
                                        <div class="item-options text-center">
                                            <div class="item-wrapper">
                                                <div class="item-cost">
                                                    <h4 class="item-price">
                                                        $599.99
                                                    </h4>
                                                    <p
                                                        class="card-text shipping"
                                                    >
                                                        <span
                                                            class="badge rounded-pill badge-light-success"
                                                            >Free Shipping</span
                                                        >
                                                    </p>
                                                </div>
                                            </div>
                                            <button
                                                type="button"
                                                class="btn btn-light mt-1 remove-wishlist"
                                            >
                                                <i
                                                    data-feather="x"
                                                    class="align-middle me-25"
                                                ></i>
                                                <span>Remove</span>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-primary btn-cart move-cart"
                                            >
                                                <i
                                                    data-feather="heart"
                                                    class="align-middle me-25"
                                                ></i>
                                                <span class="text-truncate"
                                                    >Add to Wishlist</span
                                                >
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card ecommerce-card">
                                        <div class="item-img">
                                            <a
                                                href="app-ecommerce-details.html"
                                            >
                                                <img
                                                    src="/4.png"
                                                    alt="img-placeholder"
                                                />
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="item-name">
                                                <h6 class="mb-0">
                                                    <a
                                                        href="#"
                                                        class="text-body"
                                                        >Dekor</a
                                                    >
                                                </h6>
                                                <div class="item-rating">
                                                    <ul
                                                        class="unstyled-list list-inline"
                                                    >
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="filled-star"
                                                            ></i>
                                                        </li>
                                                        <li
                                                            class="ratings-list-item"
                                                        >
                                                            <i
                                                                data-feather="star"
                                                                class="unfilled-star"
                                                            ></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <span class="text-success mb-1"
                                                >In Stock</span
                                            >
                                            <div class="item-quantity">
                                                <span class="quantity-title"
                                                    >Qty:</span
                                                >
                                                <div
                                                    class="quantity-counter-wrapper"
                                                >
                                                    <div class="input-group">
                                                        <input
                                                            type="text"
                                                            class="quantity-counter"
                                                            value="1"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <span
                                                class="delivery-date text-muted"
                                                >Delivery by, Wed Apr 30</span
                                            >
                                            <span class="text-success"
                                                >3% off 1 offers Available</span
                                            >
                                        </div>
                                        <div class="item-options text-center">
                                            <div class="item-wrapper">
                                                <div class="item-cost">
                                                    <h4 class="item-price">
                                                        $649.99
                                                    </h4>
                                                    <p
                                                        class="card-text shipping"
                                                    >
                                                        <span
                                                            class="badge rounded-pill badge-light-success"
                                                            >Free Shipping</span
                                                        >
                                                    </p>
                                                </div>
                                            </div>
                                            <button
                                                type="button"
                                                class="btn btn-light mt-1 remove-wishlist"
                                            >
                                                <i
                                                    data-feather="x"
                                                    class="align-middle me-25"
                                                ></i>
                                                <span>Remove</span>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-primary btn-cart move-cart"
                                            >
                                                <i
                                                    data-feather="heart"
                                                    class="align-middle me-25"
                                                ></i>
                                                <span class="text-truncate"
                                                    >Add to Wishlist</span
                                                >
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Checkout Place Order Left ends -->

                                <!-- Checkout Place Order Right starts -->
                                <div class="checkout-options">
                                    <div class="card">
                                        <div class="card-body">
                                            <label
                                                class="section-label form-label mb-1"
                                                >Options</label
                                            >
                                            <div
                                                class="coupons input-group input-group-merge"
                                            >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Coupons"
                                                    aria-label="Coupons"
                                                    aria-describedby="input-coupons"
                                                />
                                                <span
                                                    class="input-group-text text-primary ps-1"
                                                    id="input-coupons"
                                                    >Apply</span
                                                >
                                            </div>
                                            <hr />
                                            <div class="price-details">
                                                <h6 class="price-title">
                                                    Price Details
                                                </h6>
                                                <ul class="list-unstyled">
                                                    <li class="price-detail">
                                                        <div
                                                            class="detail-title"
                                                        >
                                                            Total MRP
                                                        </div>
                                                        <div class="detail-amt">
                                                            $598
                                                        </div>
                                                    </li>
                                                    <li class="price-detail">
                                                        <div
                                                            class="detail-title"
                                                        >
                                                            Bag Discount
                                                        </div>
                                                        <div
                                                            class="detail-amt discount-amt text-success"
                                                        >
                                                            -25$
                                                        </div>
                                                    </li>
                                                    <li class="price-detail">
                                                        <div
                                                            class="detail-title"
                                                        >
                                                            Estimated Tax
                                                        </div>
                                                        <div class="detail-amt">
                                                            $1.3
                                                        </div>
                                                    </li>
                                                    <li class="price-detail">
                                                        <div
                                                            class="detail-title"
                                                        >
                                                            EMI Eligibility
                                                        </div>
                                                        <a
                                                            href="#"
                                                            class="detail-amt text-primary"
                                                            >Details</a
                                                        >
                                                    </li>
                                                    <li class="price-detail">
                                                        <div
                                                            class="detail-title"
                                                        >
                                                            Delivery Charges
                                                        </div>
                                                        <div
                                                            class="detail-amt discount-amt text-success"
                                                        >
                                                            Free
                                                        </div>
                                                    </li>
                                                </ul>
                                                <hr />
                                                <ul class="list-unstyled">
                                                    <li class="price-detail">
                                                        <div
                                                            class="detail-title detail-total"
                                                        >
                                                            Total
                                                        </div>
                                                        <div
                                                            class="detail-amt fw-bolder"
                                                        >
                                                            $574
                                                        </div>
                                                    </li>
                                                </ul>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary w-100 btn-next place-order"
                                                >
                                                    Place Order
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Checkout Place Order Right ends -->
                                </div>
                            </div>
                            <!-- Checkout Place order Ends -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {};
</script>

<style scoped>
.content-body {
    margin: 0;
    padding: 0;
}
</style>

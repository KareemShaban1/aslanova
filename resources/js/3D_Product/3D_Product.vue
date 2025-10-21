<template>
	<div class="page">
		<div class="main container-fluid bg-white">
			<ModelFrame ref="frame" :related-products="relatedProducts" @data-change="dataChange"
				@product-selected="productSelected" @error="showError">
				<div class="right buttons-action">
					<div class="add-to-cart button btn btn-danger" @click="fetchProductData()">
						{{ $t("reset") }}
					</div>

					<div class="add-to-cart button btn btn-primary" @click="addToCart3d(productValue)">
						{{ $t("Add to cart") }}
					</div>
				</div>
			</ModelFrame>

			<div class="container1">
				<div class="info-card" v-if="productValue">
					<div class="section1">
						<div class="name">{{ productValue.name }} <span>{{ productValue.price }}<i
									class="fa-solid fa-euro-sign"></i></span></div>
						<div class="description"
							v-if="productValue.desc && productValue.desc.trim() !== '' && productValue.desc.trim().toLowerCase() !== 'null'">
							{{ productValue.desc }}
						</div>
					</div>
					<div class="info-details">
						<div class="parts-section">
							<h4>{{ $t('Parts details') }}:</h4>
							<ul>
								<li v-for="part in partsBreakdown" :key="part.name">
									<span class="item-name">{{ part.name }}</span>
									<span class="item-price">{{ part.price }} <i
											class="fa-solid fa-euro-sign"></i></span>
								</li>
							</ul>
						</div>

						<div class="textures-section">
							<h4>{{ $t('Texture details') }}:</h4>
							<ul>
								<li v-for="texture in texturesBreakdown" :key="texture.name">
									<span class="item-name">{{ texture.name }}</span>
									<span class="item-price">{{ texture.price }} <i
											class="fa-solid fa-euro-sign"></i></span>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div v-if="hasMedia" class="card-body realated-media">
					<div class="mt-4 mb-2 text-center">
						<h4>Product Media</h4>
					</div>
					<div class="swiper-container">
						<div class="swiper-wrapper">

							<!-- عرض الفيديو إذا كان موجودًا -->
							<div class="swiper-slide" v-if="productValue.video"
								@click="openModal(productValue.video, 'video')">
								<div class="video-container">
									<video :src="getVideo(productValue.video)" controls class="img-fluid"></video>
								</div>
							</div>

							<!-- عرض الصور إذا كانت موجودة -->
							<div class="swiper-slide" v-for="(image, index) in parsedImages" :key="index"
								@click="openModal(image, 'image')">
								<div class="img-container w-50 mx-auto py-75">
									<img :src="getUserImageSrc(image)" class="img-fluid" alt="image" />
								</div>
							</div>

						</div>

						<!-- أزرار التنقل -->
						<!-- <div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div> -->
					</div>
				</div>
				<!-- إذا لم يكن هناك فيديو أو صور، لا يظهر أي شيء -->
				<div v-else class="text-center">
					<h5 class="text-primary"></h5>
				</div>

				<div class="modal fade text-start show-prod-page " id="large" tabindex="-1"
					aria-labelledby="myModalLabel17" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-lg">
						<div class="modal-content">
							<!-- <div class="modal-header">
								<h4 class="modal-title" id="myModalLabel17">media</h4>
								<button type="button" class="btn-close" data-bs-dismiss="modal"
									aria-label="Close"></button>
							</div> -->
							<div class="modal-body text-center">
								<button class="btn btn-primary modal-btn prev-btn" @click="prevMedia">
									<i class="fa-solid fa-circle-chevron-left fs-1"></i>
								</button>
								<!-- عرض الصورة أو الفيديو داخل المودال -->
								<template v-if="modalType === 'image'">
									<img :src="getUserImageSrc(modalContent)" class="modal-media img-fluid" />
								</template>

								<template v-else-if="modalType === 'video'">
									<video :src="getVideo(modalContent)" controls class="modal-media img-fluid"></video>
								</template>
								<button class="btn btn-primary modal-btn next-btn" @click="nextMedia">
									<i class="fa-solid fa-circle-chevron-right fs-1"></i>
								</button>

							</div>
						</div>
					</div>
				</div>

				<div class="grid-view">
					<div v-for="(item, index) in product3dSib" :key="index">
						<div class="card ecommerce-card h-100" @click="Product3d(item.id)">
							<img class="card-img-top img-fluid" :src="getUserImageSrc(item.file)" :alt="item.name">
							<div class="card-body d-flex flex-column">
								<h5 class="card-title">{{ item.name }}</h5>
								<div class="mt-auto">
									<button class="btn btn-primary w-100">تفاصيل المنتج</button>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
</template>

<script>
import ModelFrame from './views/ModelFrame.vue';
import { useCartStore } from '../components/cart/cartStore'
import { fromApiToNodeConfig, fromApiToMaterialConfig } from './modules/convertors';
import axios from 'axios';
import { useRoute } from "vue-router";
import Swiper from "swiper";
import "swiper/css/swiper.css"; // Import Swiper styles
export default {
	components: {
		ModelFrame,
	},

	data() {
		const product3d_id = useRoute().params.id;

		return {
			addToCart: useCartStore().addToCart,
			product3d_id,
			relatedProducts: [],
			materials: [],
			productValue: null,
			product3dSib: [],
			price: 0,
			partsBreakdown: [],
			texturesBreakdown: [],
			modalContent: null,
			modalType: null,
			currentIndex: 0
		};
	},
	computed: {
		parsedImages() {
			// فصل النص JSON إلى مصفوفة من أسماء الصور فقط
			return this.productValue.images ? JSON.parse(this.productValue.images).map(image => image.split('/').pop()) : [];
		},
		hasMedia() {
			return this.productValue.video || (this.parsedImages && this.parsedImages.length > 0);
		},
		allMedia() {
			let media = [];
			if (this.productValue.video) {
				media.push({ type: "video", content: this.productValue.video });
			}
			if (this.parsedImages.length > 0) {
				this.parsedImages.forEach((image) => {
					media.push({ type: "image", content: image });
				});
			}
			return media;
		},

	},

	methods: {
		openModal(content, type) {
			this.modalContent = content;
			this.modalType = type;
			this.currentIndex = this.allMedia.findIndex((item) => item.content === content);
			let modal = new bootstrap.Modal(document.getElementById("large"));
			modal.show();
		},
		nextMedia() {
			if (this.currentIndex < this.allMedia.length - 1) {
				this.currentIndex++;
			} else {
				this.currentIndex = 0;
			}
			this.updateModalContent();
		},
		prevMedia() {
			if (this.currentIndex > 0) {
				this.currentIndex--;
			} else {
				this.currentIndex = this.allMedia.length - 1;
			}
			this.updateModalContent();
		},
		updateModalContent() {
			this.modalContent = this.allMedia[this.currentIndex].content;
			this.modalType = this.allMedia[this.currentIndex].type;
		},
		getVideo(video) {
			if (video) {
				return `/storage/${video}`;
			} else {
				return '/img/load.png';
			}
		},
		initSwiper() {
			new Swiper(".swiper-container", {
				slidesPerView: 1, // Default to 1 slide per view
				spaceBetween: 30,
				// navigation: {
				//     nextEl: ".swiper-button-next",
				//     prevEl: ".swiper-button-prev",
				// },
				breakpoints: {
					1000: { // For medium screens (e.g., tablets)
						slidesPerView: 3, // 2 slides per view
					},
					768: { // For medium screens (e.g., tablets)
						slidesPerView: 2, // 2 slides per view
					},
					576: { // For small screens (e.g., mobile)
						slidesPerView: 2, // 1 slide per view
					},
				},
			});
		},
		dataChange(data) {
			this.data = data;
			this.calculateTotalPrice(data)
		},
		calculateTotalPrice(data) {
			let partsTotal = 0;
			let texturesTotal = 0;
			let partsBreakdown = [];
			let texturesBreakdown = [];

			if (data && typeof data === 'object') {
				if (Array.isArray(data.parts)) {
					data.parts.forEach(part => {
						const price = parseFloat(part.price) || 0;
						partsTotal += price;
						partsBreakdown.push({ name: part.name || 'مكون غير مسمى', price: price });
					});
				}

				if (Array.isArray(data.textures)) {
					data.textures.forEach(texture => {
						if (texture.texture && "price" in texture.texture) {
							const price = parseFloat(texture.texture.price) || 0;
							texturesTotal += price;
							texturesBreakdown.push({
								name: texture.texture.name || 'نسيج غير مسمى',
								price: price
							});
						}
					});
				}
			}

			// حساب السعر الكلي (يمكن استخدامه للعرض في الواجهة إذا لزم الأمر)
			const basePrice = this.productValue ? parseFloat(this.productValue.price) || 0 : 0;
			const totalPrice = basePrice + partsTotal + texturesTotal;

			this.price = totalPrice; // تخزين السعر الكلي
			this.partsBreakdown = partsBreakdown;
			this.texturesBreakdown = texturesBreakdown;
		},

		addToCart3d(item) {
			console.log(item)
			if (!item) return;

			// حساب السعر الكلي (سعر المنتج الأساسي + أسعار القطع المختارة)
			const basePrice = parseFloat(item.price) || 0;
			const partsTotal = this.partsBreakdown.reduce((sum, part) => sum + (parseFloat(part.price) || 0), 0);
			const texturesTotal = this.texturesBreakdown.reduce((sum, texture) => sum + (parseFloat(texture.price) || 0), 0);
			const totalPrice = basePrice + partsTotal + texturesTotal;

			const currentItems = JSON.parse(localStorage.getItem('cartItems')) || {};

			if (item.model_id) {
				const existingItem = currentItems[item.model_id];

				if (existingItem) {
					const partsMatch = JSON.stringify(existingItem.partsBreakdown) === JSON.stringify(this.partsBreakdown);
					const texturesMatch = JSON.stringify(existingItem.texturesBreakdown) === JSON.stringify(this.texturesBreakdown);

					if (partsMatch && texturesMatch) {
						existingItem.quantity += 1;
						const newItemId = `${item.model_id}`;
						this.addToCart({
							...item,
							id: newItemId,
							quantity: existingItem.quantity,
							partsBreakdown: this.partsBreakdown,
							texturesBreakdown: this.texturesBreakdown,
							price: totalPrice, // استخدام السعر الكلي بدلاً من سعر القطع فقط
							basePrice: basePrice // إضافة سعر المنتج الأساسي
						});
					} else {
						const newItemId = `${item.model_id}-${Date.now()}`;
						this.addToCart({
							...item,
							id: newItemId,
							quantity: 1,
							partsBreakdown: this.partsBreakdown,
							texturesBreakdown: this.texturesBreakdown,
							price: totalPrice,
							basePrice: basePrice
						});
					}
				} else {
					const newItemId = `${item.model_id}`;
					this.addToCart({
						...item,
						id: newItemId,
						quantity: 1,
						partsBreakdown: this.partsBreakdown,
						texturesBreakdown: this.texturesBreakdown,
						price: totalPrice,
						basePrice: basePrice
					});
				}
			}
		}
		,


		productSelected(product) {
			console.log(product);
		},

		showError(err) {
			console.log(err);
		},

		Product3d(id) {
			this.$router.push(`/dashboard/product-3d/${id}`);
		},

		getUserImageSrc(photo) {
			if (photo) {
				return `/storage/${photo}`;
			} else {
				return '/img/load.png'
			}
		},

		async fetchProductData() {
			try {
				const [productRes, materialsRes] = await Promise.all([
					axios.get(`/api/products_3d/${this.product3d_id}`),
					axios.get('/api/materials')
				]);

				this.productValue = productRes.data.product;
				this.materials = materialsRes.data.data;
				this.$nextTick(() => {
					this.initSwiper();
				});

				if (this.productValue?.category3d_id) {
					const categoryRes = await axios.get(
						`/api/Categorys_3d/${this.productValue.category3d_id}/products_3d`
					);
					this.product3dSib = categoryRes.data.products;
				}

				const nodeConfig = fromApiToNodeConfig(this.productValue);
				const materialConfig = fromApiToMaterialConfig(this.materials, this.productValue);

				if (this.$refs.frame && this.productValue.model_id) {
					this.$refs.frame.startTheFrame(this.productValue.model_id, nodeConfig, materialConfig);
				}
			} catch (error) {
				this.showError(error);
			}
		}
	},

	watch: {
		'$route.params.id': {
			handler(newId) {
				this.product3d_id = newId;
				this.fetchProductData();
			},
			immediate: true
		}
	},

	mounted() {
		this.fetchProductData();
	}
};
</script>

<style lang="scss">
* {
	padding: 0;
	margin: 0;
	box-sizing: border-box;
}

body {
	background-color: #f2f2f2;
}

.right {
	width: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 10px;

	.button {
		margin-bottom: 10px;
		background-color: var(--mainColor);
		color: white;
		cursor: pointer;
		padding: 10px;
		border-radius: 15px;
		width: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: all 1s ease;

		&:hover {
			box-shadow: 0 3px 10px #00000091;
		}
	}
}

.page {
	display: flex;

	.navbar {
		width: 300px;
		background-color: #ccc;
		height: 100vh;

		@media (max-width: 1000px) {
			width: 0;
		}
	}

	.main {
		flex: 1;
		padding: 1rem;
		margin: 20px;
	}
}

.info-card {
	border-radius: 1rem;
	box-shadow: 0 0 1rem #0003;
	background-color: white;
	padding: 1rem 2rem;
	display: flex;
	flex-direction: column;
	gap: 10px;
	margin-bottom: 10px;

	.section1 {
		width: 100%;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;

		@media (max-width: 768px) {
			text-align: center;
			flex-direction: column;
			justify-content: center;
			align-items: center;
		}

	}

	.info-details {
		display: flex;
		justify-content: space-between;
		gap: 20px;

		@media (max-width: 768px) {
			flex-direction: column;
		}

		.parts-section,
		.textures-section {
			flex: 1;
			padding: 15px;
			background-color: #f9f9f9;
			border-radius: 8px;

			h4 {
				margin-bottom: 10px;
				font-size: 1.2rem;
				color: #333;
				border-bottom: 2px solid #e0e0e0;
				padding-bottom: 5px;
			}

			ul {
				list-style-type: none;
				padding: 0;
				margin: 0;

				li {
					font-size: 1rem;
					color: #555;
					margin-bottom: 8px;
					display: flex;
					justify-content: space-between;
					padding: 5px 0;
					border-bottom: 1px solid #e0e0e0;

					&:last-child {
						border-bottom: none;
					}

					.item-name {
						flex: 1;
					}

					.item-price {
						flex: 0 0 auto;
						margin-left: 10px;
						font-weight: bold;
					}
				}
			}
		}
	}
}

.container1 {
	width: 100% !important;
	margin-top: 10px;
	justify-content: center !important;
	align-items: center !important;

}

.ecommerce-card {
	border: none;
	border-radius: 10px;
	transition: transform 0.3s, box-shadow 0.3s;
}

.ecommerce-card:hover {
	transform: translateY(-5px);
	box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.card-img-top {
	border-top-left-radius: 10px;
	border-top-right-radius: 10px;
	width: 100%;
}

.card-body {
	display: flex;
	flex-direction: column;
	justify-content: space-between;
	padding: 1.5rem;
}


.grid-view {
	padding-top: 15px;
	gap: 10px;
}

.realated-media img,
.realated-media video {
	// width: 200px;
	height: 200px;
	object-fit: cover;
}


/* تنسيقات Swiper */
.swiper-container {
	width: 100%;
	height: 400px;
	/* ارتفاع ثابت */
	margin-bottom: 20px;
}

.swiper-slide {
	display: flex;
	justify-content: center;
	align-items: center;
	border-radius: 8px;
	/* زوايا مدورة */
	overflow: hidden;
	/* لمنع تجاوز المحتوى */
}

.video-container,
.img-container {
	width: 100%;
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
}

.video-container video,
.img-container img {
	max-width: 100%;
	max-height: 100%;
	object-fit: contain;
	/* عرض المحتوى بحجمه الأصلي */
	border-radius: 8px;
	/* زوايا مدورة */
}

/* أزرار التنقل */
.swiper-button-next,
.swiper-button-prev {
	border-radius: 50%;
	/* جعل الأزرار دائرية */
	width: 40px;
	/* عرض الأزرار */
	height: 40px;
	/* ارتفاع الأزرار */
	display: flex;
	justify-content: center;
	align-items: center;
	transition: background-color 0.3s ease;
	/* تأثير انتقالي */
}

/* تنسيقات المودال */
.show-prod-page .modal-content {
	padding: 0 !important;
	border-radius: 0 !important;
	max-width: 90%;
	max-height: 90vh;
	overflow: auto;
	display: flex;
	justify-content: center;
	align-items: center;
	border: none !important;
	/* إزالة الحدود */
}

.modal-media {
	max-width: 100%;
	max-height: 80vh;
	border-radius: 8px;
	object-fit: contain;
}


.model .modal-backdrop {
	z-index: 999 !important;
}


.modal-btn {
	position: absolute;
	top: 50%;
	transform: translateY(-50%);
	z-index: 1001;
	width: 50px;
	height: 50px;
	border-radius: 50% !important;
	display: flex;
	align-items: center;
	justify-content: center;
	opacity: 0.7;
	transition: opacity 0.3s ease;
}

.modal-btn:hover {
	opacity: 1;
}

.prev-btn {
	left: 10px;
}

.next-btn {
	right: 10px;
}

@media screen and (max-width: 500px) {
	.buttons-action {
		padding-top: 50px;
	}
}
</style>

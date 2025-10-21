<template>
	<div
		class="container1"
		:class="{ mobile: isMobile }"
		:style="`--3d-active-color: ${activeColor};`">
		<div class="section frame-section">
			<div class="card frame">
				<Loader v-if="loading < 0" />
				<iframe
					v-show="loading >= 0"
					ref="frame"
					width="800"
					height="700"
					src=""
					id="api-frame"
					allow="autoplay; fullscreen; accelerometer;  xr-spatial-tracking; gyroscope;"
					xr-spatial-tracking
					execution-while-out-of-viewport
					execution-while-not-rendered
					web-share
					allowfullscreen
					mozallowfullscreen="true"
					webkitallowfullscreen="true"></iframe>

				<div
					v-if="nodeHandler?.haveRotatable"
					v-show="loading >= 0"
					class="rotation">
					<div>Rotation</div>
					<input
						type="range"
						min="0"
						max="1000"
						value="0"
						@input="rotate" />
				</div>

				<div
					v-show="loading >= 0"
					class="related-products">
					<div
						class="related-products__image"
						v-for="(product, i) in relatedProducts"
						:key="i"
						@click="$emit('product-selected', product)">
						<img
							:src="product.img"
							alt="" />
					</div>
				</div>

				<div
					class="controller-drawer"
					:class="{ open: openController }"
					@click="openController = !openController">
					<div></div>
				</div>
			</div>
		</div>

		<div
			class="section control-section"
			:class="{ open: openController }">
			<div class="card control">
				<Loader v-if="loading < 0" />
				<template v-else>
					<slot></slot>
					<Expander :name="texturesTitle">
						<Dropdown
							v-for="([key, value], i) in Object.entries(materials).sort(
								(a, b) =>
									materialHandler.getMaterialName(a[0]).order -
									materialHandler.getMaterialName(b[0]).order,
							)"
							:key="i + '-material'"
							:name="materialHandler.getMaterialName(key).name"
							:loading="updatingLoader">
							<Category
								:selectedTexture="selectedTextures[value.name]"
								:handler="materialHandler"
								:material="value"
								@texture-selected="textureSelected" />
						</Dropdown>
					</Expander>
					<Expander :name="partsTitle">
						<Dropdown
							v-for="([key, value], i) in Object.entries(nodes.lists)"
							:key="i + '-lists'"
							:name="nodeHandler.getListName(key)">
							<div class="part-list">
								<div
									class="part-item"
									:class="{
										active:
											selectedNodes[key] === itemKey ||
											(!selectedNodes[key] && i === 0),
									}"
									@click="toggleListNodes(value, subValue, key, itemKey)"
									v-for="([itemKey, subValue], i) in Object.entries(value)"
									:key="i + '-item'">
									<img
										v-if="nodeHandler.getNodeName(subValue).url"
										:src="nodeHandler.getNodeName(subValue).url" />
									<span v-else>
										{{ nodeHandler.getNodeName(subValue).name }}
									</span>
								</div>
							</div>
						</Dropdown>
					</Expander>
				</template>
			</div>
		</div>
	</div>
</template>

<script>
import Expander from './inners/Expander.vue';
import Dropdown from './inners/Dropdown.vue';
import Category from './inners/Category.vue';
import Loader from './inners/Loader.vue';

import Sketchfab from '../modules/lib';
import control_options from '../modules/control_options.mjs';
import nodeHandler from '../modules/nodeHandler';
import materialHandler from '../modules/materialHandler';
import { materialConfigValidation } from '../modules/materialValidation';
import { nodeConfigValidation } from '../modules/nodeValidation';

import '../modules/helpers';

export default {
	props: {
		texturesTitle: { type: String, default: 'Textures' },
		partsTitle: { type: String, default: 'Parts' },
		activeColor: { type: String, default: '#e65c00' },
		breakpoint: { type: String, default: '1000px' },
		relatedProducts: { type: Array },
	},

	data() {
		return {
			data: { textures: [], parts: [] },

			loading: -2,
			updatingLoader: false, // will update from the materialHandler

			nodeHandler: null,
			materialHandler: null,

			nodes: null,
			materials: null,

			selectedNodes: {},
			selectedTextures: {}, // will update from the materialHandler

			openController: false,
			isMobile: false,
			eventListener: null,
		};
	},

	watch: {
		data: {
			handler() {
				this.$emit('data-change', this.data);
			},
			deep: true,
		},
	},

	components: {
		Expander,
		Dropdown,
		Category,
		Loader,
	},

	methods: {
		startTheFrame(modelId, nodeConfig, materialConfig) {
			try {
				materialConfigValidation(materialConfig);
				nodeConfigValidation(nodeConfig);
				this.startSketchfab(modelId, nodeConfig, materialConfig);
			} catch (err) {
				this.$emit('error', err);
			}
		},

		startSketchfab(modelId, nodeConfig, materialConfig) {
			console.log('starting the frame ...');
			this.loading = -2;

			let sketchfabInstance = new Sketchfab('1.12.1', this.$refs.frame);

			sketchfabInstance.init(modelId, {
				success: (api) => {
					window.api = api;
					api.start();

					api.addEventListener('viewerready', () => {
						console.log('viewer ready ...');

						this.nodeHandler = new nodeHandler(nodeConfig, api, this.initNodes, this);
						this.materialHandler = new materialHandler(
							materialConfig,
							api,
							this.initMaterials,
							this,
						);
					});
				},
				error: (err) => {
					this.$emit('error', err);
				},
				...control_options,
			});
		},
		initNodes(res) {
			this.nodes = res;
			this.loading++;
		},
		initMaterials(res) {
			this.materials = res;
			this.loading++;
		},

		textureSelected(t) {
			const old = this.data.textures.find((e) => e.material?.name === t.material.name);
			if (old) {
				old.texture = t.texture;
			} else {
				this.data.textures.push(t);
			}
		},
		partSelected(nodes) {
			const listNodes = nodes
				.filter((e) => e.name[0] === 'C')
				.map((e) => ({ ...e, name: e.name.slice(2) }));

			const data = listNodes.filter((e) => e.shown).map((e) => this.nodeHandler.config.naming[e.name]);

			this.data.parts = data;
		},

		toggleListNodes(list, item, listKey, itemKey) {
			this.selectedNodes[listKey] = itemKey;

			for (let [_, ele] of Object.entries(list)) {
				this.nodeHandler.hideNode(ele);
			}

			this.nodeHandler.showNode(item);
		},
		rotate(e) {
			this.nodeHandler.rotateNodes(e.target.value);
		},
	},

	mounted() {
		this.eventListener = () => {
			this.isMobile = window.matchMedia(`(max-width: ${this.breakpoint})`).matches;
		};
		this.eventListener();

		window.addEventListener('resize', this.eventListener);
	},

	unmounted() {
		window.removeEventListener('resize', this.eventListener);
	},
};
</script>

<style lang="scss" scoped>
.container1 {
	width: 100%;
	display: flex;
	flex-wrap: wrap;
	.section {
		padding: 0.5rem;
	}
	.frame-section {
		width: 70%;
	}
	.control-section {
		width: 30%;
	}
}

.card {
	overflow: hidden;
	border-radius: 1rem;
	box-shadow: 0 0 1rem #0003;
	background-color: white;
	padding: 1rem;
	height: 600px;
	&.frame {
		padding: 0;
		position: relative;
		iframe {
			width: 100%;
			height: 100%;
			border: none;
		}
	}
	&.control {
		overflow: auto;
	}
}

.part-list {
	display: flex;
	flex-wrap: wrap;
	padding: 1rem 0;
	.part-item {
		margin: 5px;
		width: 5rem;
		height: 3rem;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		border: 1px solid #ccc;
		border-radius: 5px;
		padding: 0;
		overflow: hidden;
		img {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}
		&.active {
			outline: 4px solid var(--3d-active-color);
		}
	}
}

.rotation {
	position: absolute;
	bottom: 2rem;
	left: 2rem;
	background-color: #fff;
	border-radius: 0.5rem;
	padding: 1rem 2rem;
	box-shadow: 0 0 15px #0002;
	opacity: 0.2;
	transition: 0.2s;
	@media (max-width: 700px) {
		opacity: 0.5;
		bottom: 5rem;
		left: 50%;
		transform: translateX(-50%);
		padding: 0.3rem 1rem;
	}
	&:hover {
		opacity: 1;
	}

	input[type='range'] {
		-webkit-appearance: none;
		appearance: none;
		background: transparent;
		cursor: pointer;
		width: 10rem;
	}

	input[type='range']::-webkit-slider-runnable-track {
		background-color: #dadada;
		border-radius: 0.5rem;
		height: 0.5rem;
	}
	input[type='range']::-webkit-slider-thumb {
		-webkit-appearance: none;
		appearance: none;
		margin-top: -4px;
		background-color: var(--3d-active-color);
		height: 1rem;
		width: 1rem;
		border-radius: 50%;
	}

	/******** Firefox styles ********/
	input[type='range']::-moz-range-track {
		background-color: #dadada;
		border-radius: 0.5rem;
		height: 0.3rem;
	}

	/* slider thumb */
	input[type='range']::-moz-range-thumb {
		border: none;
		border-radius: 50%;
		background-color: var(--3d-active-color);
		height: 1rem;
		width: 1rem;
	}
}

.controller-drawer {
	display: none;
}

.mobile {
	&.container1 {
		position: relative;
		.frame-section {
			width: 100%;
		}
		.control-section {
			position: absolute;
			right: 0;
			top: 0;
			bottom: 0;
			width: 0px;
			overflow: hidden;
			transition: 0.3s;
			padding-right: 0;
			padding-left: 0;

			&.open {
				width: 300px;
			}

			.control {
				width: 300px;
				height: 100%;
				box-shadow: none;
			}
		}
	}

	.controller-drawer {
		position: absolute;
		top: 1.5rem;
		left: 2rem;
		width: 3rem;
		height: 3rem;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		background-color: #ffffffb9;
		border-radius: 5px;
		box-shadow: 0 0 5px #0004;
		z-index:999;

		&::before,
		&::after,
		& div {
			background-color: #000;
			content: '';
			display: block;
			height: 3px;
			width: 20px;
			border-radius: 3px;
			margin: 3px 0;
			transition: 0.5s;
		}
		&.open::before {
			transform: translateY(8px) rotate(135deg);
		}
		&.open::after {
			transform: translateY(-10px) rotate(-135deg);
		}
		&.open div {
			transform: scale(0);
		}
	}
}

.related-products {
	position: absolute;
	bottom: 2rem;
	left: 50%;
	display: flex;
	transform: translateX(-50%);
	opacity: 0.3;
	transition: 0.2s;
	max-width: 300px;
	overflow-x: auto;
	&:hover {
		opacity: 1;
	}
	@media (max-width: 700px) {
		opacity: 0.5;
		bottom: 1rem;
	}
	&__image {
		min-width: 5rem;
		max-width: 5rem;
		height: 4.5rem;
		margin: 0 6px;
		border: 8px solid #fff;
		border-radius: 10px;
		transition: 0.3s;
		@media (max-width: 700px) {
			min-width: 3rem;
			max-width: 3rem;
			height: 3rem;
		}
		img {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}
		&:hover {
			transform: scale(1.05);
		}
	}
}

</style>

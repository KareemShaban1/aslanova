<template>
	<div
		class="categories"
		:class="{ selected: selectedGroup }">
		<div class="category-container">
			<template v-if="haveSubGroup">
				<div class="categories-list">
					<div
						v-for="[key, items] in Object.entries(items)"
						:key="key"
						class="categories-list__item"
						@click="selectedGroup = { key, items }">
						{{ handler.getSubGroups(key) }}
					</div>
				</div>
				<div class="category">
					<div
						class="category-header"
						@click="selectedGroup = null">
						{{ handler.getSubGroups(selectedGroup?.key) }}
					</div>
					<div class="category-body">
						<div
							v-for="(item, i) in selectedGroup?.items"
							:key="i + '-category-item'"
							class="category-body__item item"
							:class="{ active: item.url === selectedTexture }"
							@click="selectTexture(item)">
							<div class="item__image">
								<img
									:src="item.url"
									alt="" />
							</div>
							<div class="item__text">{{ item?.name }}</div>
						</div>
					</div>
				</div>
			</template>

			<div
				v-else
				class="category">
				<div class="category-body">
					<div
						v-for="item in items"
						:key="i + '-category-item'"
						class="category-body__item item"
						:class="{ active: item.url === selectedTexture }"
						@click="selectTexture(item)">
						<div class="item__image">
							<img
								:src="item.url"
								:alt="item.name" />
						</div>
						<div class="item__text">{{ item.name }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			selectedGroup: null,
		};
	},

	props: {
		handler: Object,
		material: Object,
		selectedTexture: String,
	},

	computed: {
		items() {
			return this.material?.textures || [];
		},
		haveSubGroup() {
			return !this.items.length;
		},
	},

	methods: {
		selectTexture(texture) {
			try {
				this.handler.selectTexture(this.material, texture);
				this.$emit('texture-selected', { material: this.material, texture });
			} catch (err) {
				console.error('Category.selectTexture: ' + err);
			}
		},
	},
};
</script>

<style lang="scss" scoped>
.categories {
	width: 100%;
	overflow: hidden;
	.category-container {
		flex-wrap: wrap;
		display: flex;
		width: 200%;
		transition: 0.2s;
		> * {
			width: 50%;
		}
	}
	&.selected {
		.category-container {
			transform: translateX(-50%);
		}
	}
	.categories-list {
		padding: 1rem 0;
		&__item:not(:last-child) {
			margin-bottom: 1rem;
		}
	}
	.category {
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: white;
		.category-header {
			padding-top: 5px;
			padding-bottom: 10px;
			color: #666;
			&::before {
				content: '';
				margin: 0 4px;
				display: inline-block;
				width: 7px;
				height: 7px;
				border-bottom: 1px solid #666;
				border-left: 1px solid #666;
				transform: rotate(45deg);
			}
		}
		.category-body {
			display: flex;
			flex-wrap: wrap;
			&__item {
				display: flex;
				flex-direction: column;
				align-items: center;
				width: 25%;
				padding: 10px;
				.item {
					&__image {
						width: 3rem;
						height: 3rem;
						border-radius: 50%;
						border: 1px solid #ccc;
						margin-bottom: 4px;
						overflow: hidden;
						img {
							width: 100%;
							height: 100%;
							object-fit: cover;
						}
					}
					&__text {
						text-align: center;
					}
				}
				&.active {
					.item__image {
						outline: 4px solid var(--3d-active-color);
					}
				}
			}
		}
	}
}
</style>

<template>
	<div
		class="dropdown"
		:class="{ expand: dropdown }">
		<div
			class="dropdown-label"
			@click="dropdown = !dropdown">
			<span>
				{{ name }}
			</span>
			<div class="arrow"></div>
		</div>
		<div class="dropdown-body">
			<div
				class="dropdown-loader"
				v-if="loading">
				<span class="loader"></span>
			</div>
			<slot></slot>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			dropdown: false,
		};
	},

	props: {
		name: { type: String },
		loading: { type: Boolean },
	},
};
</script>

<style lang="scss" scoped>
.dropdown {
	position: relative;
	.dropdown-label {
		padding: 0.8rem 1rem;
		border: 1px solid #aaa;
		border-radius: 0.6rem;
		color: #333;
		font-size: 1.1rem;
		margin-bottom: 0.3rem;
		display: flex;
		align-items: center;
		justify-content: space-between;
		.arrow {
			width: 0.5rem;
			height: 0.5rem;
			border-bottom: 2px solid #aaa;
			border-right: 2px solid #aaa;
			transition: 0.3s;
			transform: rotate(45deg);
		}
	}
	.dropdown-body {
		padding: 0 1rem;
		border-radius: 0.6rem;
		box-shadow: none;

		transition: 0.3s;
		max-height: 0;
		opacity: 0;
		position: relative;
	}
	.dropdown-loader {
		position: absolute;
		z-index: 1;
		border-radius: 0.6rem;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(0, 0, 0, 0.651);
		display: flex;
		align-items: center;
		justify-content: center;
		.loader {
			width: 10px;
			height: 10px;
			border-radius: 50%;
			background-color: #fff;
			box-shadow: 32px 0 #fff, -32px 0 #fff;
			position: relative;
			animation: flash 0.5s ease-out infinite alternate;
		}

		@keyframes flash {
			0% {
				background-color: #fff2;
				box-shadow: 15px 0 #fff2, -15px 0 #fff;
			}
			50% {
				background-color: #fff;
				box-shadow: 15px 0 #fff2, -15px 0 #fff2;
			}
			100% {
				background-color: #fff2;
				box-shadow: 15px 0 #fff, -15px 0 #fff2;
			}
		}
	}
	&.expand {
		.dropdown-body {
			margin-bottom: 0.5rem;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
			border: 1px solid #ccc;
			max-height: 200px;
			opacity: 1;
			overflow: auto;
		}
	}
}

.expand {
	.arrow {
		transform: rotate(225deg) !important;
	}
}
</style>

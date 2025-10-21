<template>
	<div
		class="expander smb-2"
		:class="{ show: expander }">
		<div
			class="expander-header"
			@click="expander = !expander">
			<span>
				{{ name }}
			</span>
			<div class="expander-arrow"></div>
		</div>
		<div class="expander-body">
			<slot></slot>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			expander: false,
		};
	},

	props: {
		name: { type: String },
	},
};
</script>

<style lang="scss" scoped>
.expander {
	position: relative;
	width: 100%;
	overflow: hidden;
	.expander-header {
		padding: 5px;
		font-size: 1.4rem;
		font-weight: bold;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: space-between;
		.expander-arrow {
			width: 0.5rem;
			height: 0.5rem;
			border-bottom: 2px solid #aaa;
			border-right: 2px solid #aaa;
			transition: 0.3s;
			transform: rotate(45deg);
		}
	}
	.expander-body {
		transition: 0.5s;
		padding: 0 5px;
		max-height: 800px;
	}
	&.show {
		.expander-body {
			padding: 0 5px;
			max-height: 0px;
		}
	}
}
.show {
	.expander-arrow {
		transform: rotate(225deg) !important;
	}
}
.smb-2 {
	margin-bottom: 1rem;
}
</style>

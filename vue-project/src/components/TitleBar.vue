<template>
	<div style="width: 100%"><el-button type="primary" icon="el-icon-arrow-left" @click="onBack"></el-button>{{title}}</div>
</template>

<script type="text/javascript">
	export default {
		name: 'TitleBar',
		props: {
			title: ''
		},
		data() {
			return {

			}
		},
		methods: {
			onBack() {
				this.$router.push({name: 'main'});
			}
		},

		mounted() {
			//this.$set(this, 'title', this.)
		}
	}
</script>
<template>
	<div>
		<component :is="target"/>
	</div>
</template>

<script type="text/javascript">
	export default {
		components: {'MemberManage': () => import("@/components/MemberManage"), 'SystemManage': () => import("@/components/SystemManage"), 'StaticsManager': () => import("@/components/StaticsManager")},
		data() {
			return {
				target: this.$route.query.page
			}
		},

		mounted() {
			console.log(this.$route.query);
			window.navigateTo = this.navigateTo;
		}, 

		methods: {
			navigateTo(target) {
				this.$set(this, 'target', target);
			}
		}
	}
</script>
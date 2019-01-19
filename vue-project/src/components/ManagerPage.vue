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

			//检查是否登录
				// window.localStorage.setItem('username', response.data.username);
  		// 		window.localStorage.setItem('type', response.data.type);
  		// 		window.localStorage.setItem('time', new Date().getTime());
  			let username = window.localStorage.getItem('username');
  			let time = window.localStorage.getItem('time');
  			let t = new Date().getTime();
  			console.log('login d = ' + (t - time));
  			if (t - time > 3600 * 3 * 1000) {
  				window.location = window.location = window.location.origin + '/#/user';
  			}
		}, 

		methods: {
			navigateTo(target) {
				this.$set(this, 'target', target);
			}
		}
	}
</script>
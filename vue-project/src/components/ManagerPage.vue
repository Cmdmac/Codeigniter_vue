<template>
	<div>
		<component :is="target"/>
	</div>
</template>

<script type="text/javascript">
	import axios from 'axios';
	import qs from 'qs';
	
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
			},
			logout() {
				let username = window.localStorage.getItem('username');
	      	let that = this;
		            let instance = axios.create({
		  				headers: { 'content-type': 'application/x-www-form-urlencoded' },
		  				withCredentials: true});
			  		instance.post(this.Server.api.user.logout,
			  			qs.stringify({ username: username}))
			  		.then(function (response) {
			  			if (response.data.code == 200) {
			  				//alert(response.data.msg);
			  				//window.location = 'http://localhost:8080/#/manager?username=' + that.username
			  				//alert(response.data.last_login_time);
			  				Message({
			  					showClose: true,
			  					message: response.data.msg, 
			  					type: 'success',
			  					duration: 1000
			  				});
			  				//退出，清除登录数据，回到登录
			  				window.localStorage.removeItem('username');
			  				window.localStorage.removeItem('type');
			  				window.localStorage.removeItem('time');
			  				window.location = that.Server.host;
			  			} else {
			  				//alert(response.data.msg);
			  				Message({
			  					showClose: true,
			  					message: response.data.msg, 
			  					type: 'error',
			  					duration: 1000
			  				});
			  			}
			  		}).catch(function (error) {
			                //eslint-disable-next-line
			                console.log(error);
			                //alert('error');
			        });
			}
		}
	}
</script>
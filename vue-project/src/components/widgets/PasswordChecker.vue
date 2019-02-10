<template>
	<div class="container" v-if="visible">
		<div style="color: white">{{levelStrs[parseInt(level) -1]}}级密码</div>
		<table style="width: 80%; margin-top: 20px;">
			<tr><td><el-input placeholder="输入密码" v-model="password"></el-input></td></tr>
			<tr><td><span style="color: yellow; font-size: 8pt;">{{error}}</span></td></tr>
			<tr><td><el-button style="width: 100%; margin-top: 15px;" type="primary" @click="checkPassword">登录</el-button></td></tr>
			<tr><td><el-button style="width: 100%; margin-top: 10px; color: #DDDDDD;" type="text" @click="onBack">返回</el-button></td></tr>
		</table>
	</div>
</template>

<script type="text/javascript">
	import {Message} from 'element-ui';
	export default {
		name: 'PasswordChecker',
		props: { level: String },
		data() {
			return {
				levelStrs: ['一', '二', '三', '四', '五', '六', '七', '八'],
				password: '',
				visible: true,
				error: ''
			}
		},

		methods: {
			checkPassword() {
				let that = this;
				this.ajax().post(this.Server.api.member.checkPassword, {level: this.level, password: this.password})
				.ok(function(data) {
					that.$emit('password-valide');
					that.$set(that, 'visible', false);
					window.localStorage.setItem('last_time_input_level' + that.level, new Date().getTime());
				}).notOk(function(data) {
					// console.log(data);
					// alert(data.msg);
					that.$set(that, 'error', data.msg);
					setTimeout(function() {
						that.$set(that, 'error', '');
					}, 1000);
					Message({
	  					showClose: true,
	  					message: data.msg, 
	  					type: 'error',
	  					duration: 1000
	  				});	  				
				}).catch(function(error) {
					console.log(error);
				}).start();
			},

			onBack() {
				this.$router.go(-1);
			}
		},

		mounted() {
			let lastTime = window.localStorage.getItem('last_time_input_level' + this.level);
			// 一个小时的时间
			if (lastTime != undefined || (new Date().getTime() - lastTime < 3600 * 1000)) {
				this.$set(this, 'visible', false);
				this.$emit('password-valide');
			} else {

			}
		}
	};
</script>

<style type="text/css" scoped>
.container {
	width: 100%;
	height: 100%;
	left: 0px;
	top: 0px;
	position: fixed;/*这里一定要设置*/
	z-index: 100;/*这里是该元素与显示屏的距离，据说越大越好，但是我也没有看到效果，因为没有它也是可以的*/
	-webkit-transition: .5s ease-in-out;/* css的transition允许css的属性值在一定的时间内从一个状态平滑的过渡到另一个状态 */
	-moz-transition: .5s ease-in-out;/*这里为了兼容其他浏览器*/
	-o-transition: .5s ease-in-out;
	background: gray;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
}

table {
	width: 80%;
  	max-width: 500px;
}
</style>
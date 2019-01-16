<template>
	<div>
		<div><h2>欢迎来到XXX系统</h2></div>
		<table align="center">
			<tr><td><span>用户名：</span></td><td><el-input v-model="username" placeholder="请输入用户名"></el-input></td></tr>
			<tr><td><span>密码：</span></td><td><el-input v-model="password" type="password" placeholder="请输入密码"></el-input></td></tr>
			<tr><td></td><td align="right"><el-button type="primary" @click="onLogin">登录</el-button></td></tr>
			<tr><td></td><td align="right"><el-button type="text" @click="onRegister">注册</el-button><el-button type="text" @click="onForgetPassword">忘记密码</el-button></td></tr>
		</table>
		
	</div>
</template>

<script>
import axios from "axios";
import qs from 'qs';

export default {
  name: 'User',
  data() {
  	return {
  		username: '',
  		password: ''}

  	  },
  methods: {
  	onLogin() {
  		//alert('ddd')
  		let that = this;
  		let instance = axios.create({
  			headers: { 'content-type': 'application/x-www-form-urlencoded' },
  			withCredentials: true 
  		});
  		instance.post("http://localhost/index.php/user/login",
  			qs.stringify({ username: this.username, password: this.password }
  				)).then(function (response) {
  			if (response.data.code == 200) {
  				//alert(response.data.msg);
  				window.location = 'http://localhost:8080/#/manager?username=' + that.username
  				//alert(response.data.last_login_time);
  			} else {
  				alert(response.data.msg);
  			}
  		}).catch(function (error) {
                //eslint-disable-next-line
                console.log(error);
                //alert('error');
        });
  	},

  	onRegister() {
  		//alert('onRegister');
  		let instance = axios.create({
  			headers: { 'content-type': 'application/x-www-form-urlencoded' },
  			withCredentials: true 
  		});
  		instance.post("http://localhost/index.php/user/register",
  			qs.stringify({ username: this.username, password: this.password }
  				)).then(function (response) {
  			if (response.data.code == 200) {
  				alert(response.data.msg);
  				//alert(response.data.last_login_time);
  			} else {
  				alert(response.data.msg);
  			}
  		}).catch(function (error) {
                //eslint-disable-next-line
                console.log(error);
                //alert('error');
        });
  	},

  	onForgetPassword() {
  		alert('请联系管理员！');
  	}
  }  
}
</script>

<style type="text/css">
	td {
		margin: 10px;
	}
</style>
<template>
	<div>
		<table align="center">
			<tr><td><span>用户名：</span></td><td><el-input v-model="username" placeholder="请输入用户名"></el-input></td></tr>
			<tr><td><span>密码：</span></td><td><el-input v-model="password" placeholder="请输入密码"></el-input></td></tr>
			<tr><td></td><td align="right"><el-button type="primary" @click="onLogin">登录</el-button></td></tr>
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
  		let instance = axios.create({
  			headers: { 'content-type': 'application/x-www-form-urlencoded' },
  			withCredentials: true 
  		});
  		instance.post("http://localhost/index.php/user/login",
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
        });
  	}
  }  
}
</script>
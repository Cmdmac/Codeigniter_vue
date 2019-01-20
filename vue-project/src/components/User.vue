<template>
	<div align="center">
		<div align="center"><h2>欢迎来到爱我中华自助平台</h2></div>
    
		<table align="center">
			<tr><td><span>用户名：</span></td><td><el-input v-model="username" placeholder="请输入用户名"></el-input></td></tr>
			<tr><td><span>密码：</span></td><td><el-input v-model="password" type="password" placeholder="请输入密码"></el-input></td></tr>
			<tr v-if="needEnsure" ><td><span>确认密码：</span></td><td><el-input v-model="ensure_password" type="password" placeholder="确认密码"></el-input></td></tr>
			<tr><td></td><td align="right"><el-button type="primary" v-if="!needEnsure" @click="onLogin">{{loginButtonText}}</el-button><el-button type="primary" v-if="needEnsure" @click="doRegister">{{registerButtonText}}</el-button></td></tr>
			<tr><td></td><td align="right"><el-button v-if="needEnsure" type="text" @click="showLogin">{{loginButtonText}}</el-button><el-button v-if="!needEnsure" type="text" @click="onRegister">{{registerButtonText}}</el-button><el-button type="text" @click="onForgetPassword">忘记密码</el-button></td></tr>
		</table>
		
	</div>
</template>

<script>
import axios from "axios";
import qs from 'qs';
import {Message} from 'element-ui';
export default {
  name: 'User',
  data() {
  	return {
  		loginButtonText: '登录',
  		registerButtonText: '注册',
  		needEnsure: false,
  		ensure_password: '',
  		username: '',
  		password: ''}

  	  },
  methods: {
  	showLogin() {
  		this.$set(this, 'needEnsure', false);
  	},
  	onLogin() {
  		// if (window.android != undefined) {
			 // window.android.navigateTo("local://navigator/manager?tabs=" + encodeURIComponent("http://172.18.12.197:8080/#/manager,http://172.18.12.197:8080/#/manager,http://172.18.12.197:8080/#/manager"));
		  // }
  		//alert('ddd')
  		let that = this;
  		let instance = axios.create({
  			headers: { 'content-type': 'application/x-www-form-urlencoded' },
  			withCredentials: true 
  		});
  		instance.post(this.Server.api.user.login,
  			qs.stringify({ username: this.username, password: this.password }
  				)).then(function (response) {
  			if (response.data.code == 200) {
  				//alert(response.data.msg);
  				window.localStorage.setItem('username', response.data.username);
  				window.localStorage.setItem('type', response.data.type);
          let t = new Date().getTime();
  				window.localStorage.setItem('time', t);
  				if (window.android != undefined) {
            if (response.data.type == 0) {
              let url = "local://navigator/manager?tabs=" + encodeURIComponent(that.Server.page.manager.member + "," + that.Server.page.manager.system + "," + that.Server.page.manager.statics);
              console.log(url);
              android.navigateTo(url);
              
            }
            console.log("login time=" + t);
  					android.onLogin(response.data.username, response.data.type, "" + t);
            window.location = window.location.origin + '/#/manager_page?page=MemberManage';
  				} else {
  				  window.location = window.location.origin + '/#/manager';
          }
  				//alert(response.data.last_login_time);
  			} else {
  				Message({
		  			showClose: true,
		  			message: response.data.msg, 
		  			type: 'error',
		  			duration: 2000
		  		});
  			}
  		}).catch(function (error) {
                //eslint-disable-next-line
                console.log(error);
                //alert('error');
        });
  	},

  	doRegister() {
		if (this.password != this.ensure_password) {
  			Message({
		  			showClose: true,
		  			message: '两次密码不一致', 
		  			type: 'error',
		  			duration: 2000
		  		});
  		} else {
  			let that = this;
  			let instance = axios.create({
  			headers: { 'content-type': 'application/x-www-form-urlencoded' },
  			withCredentials: true 
	  		});
	  		instance.post(this.Server.api.user.register,
	  			qs.stringify({ username: this.username, password: this.password }
	  				)).then(function (response) {
	  			if (response.data.code == 200) {
	  				Message({
			  			showClose: true,
			  			message: response.data.msg, 
			  			type: 'success',
			  			duration: 2000
		  			});
	  				that.showLogin();
	  				//alert(response.data.last_login_time);
	  			} else {
	  				Message({
			  			showClose: true,
			  			message: response.data.msg, 
			  			type: 'error',
			  			duration: 2000
		  			});
	  			}
	  		}).catch(function (error) {
	                //eslint-disable-next-line
	                console.log(error);
	                //alert('error');
	        });
  		} 		
        
  	},

  	onRegister() {
  		//alert('onRegister');
  		this.$set(this, 'needEnsure', true);   		
  	},

  	onForgetPassword() {
  		alert('请联系管理员！');
  	}
  }  
}
</script>

<style type="text/css" scoped>
td {
		margin: '10px';
	}
</style>
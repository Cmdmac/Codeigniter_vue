<template>
	<div class="container" align="center" ref="homePage"  
    v-loading="loading"
    element-loading-text="正在登录...">
    <div class="container2">
  		<div align="center"><h2>爱我中华自助平台</h2></div>    
  		<table align="center" class="table">
  			<tr><!--<td><span>用户名：</span></td>--><td><el-input v-model="username" placeholder="请输入用户名"></el-input></td></tr>
  			<tr><!--<td><span>密码：</span></td>--><td><el-input v-model="password" type="password" placeholder="请输入密码"></el-input></td></tr>
  			<tr v-if="needEnsure" ><td><span>确认密码：</span></td><td><el-input v-model="ensure_password" type="password" placeholder="确认密码"></el-input></td></tr>
  			<!-- <tr><td></td><td align="right"><el-button type="primary" v-if="!needEnsure" @click="onLogin">{{loginButtonText}}</el-button><el-button type="primary" v-if="needEnsure" @click="doRegister">{{registerButtonText}}</el-button></td></tr> -->
  			<!-- <tr>
          <td></td>
          <td align="right"><el-button v-if="needEnsure" type="text" @click="showLogin">{{loginButtonText}}</el-button><el-button v-if="!needEnsure" type="text" @click="onRegister">{{registerButtonText}}</el-button><el-button type="text" @click="onForgetPassword">忘记密码</el-button></td>
        </tr> -->
  		</table>
      <el-button style="width: 100%; margin-top: 30px;" type="primary" @click="onLogin">{{loginButtonText}}</el-button>
      <el-button type="text" @click="onForgetPassword">忘记密码</el-button>
<!--   		<div class="foot" align="center"><el-button type="text" @click="onDownloadApp">下载App</el-button></div>
 -->	 </div>
</div>
</template>

<script>

export default {
  name: 'User',
  data() {
  	return {
      loading: false,
  		loginButtonText: '登录',
  		registerButtonText: '注册',
  		needEnsure: false,
  		ensure_password: '',
  		username: '',
  		password: '',
      clientHeight: ''
    }

  },
  methods: {
  	showLogin() {
  		this.$set(this, 'needEnsure', false);
  	},

    saveToken(data) {
      window.localStorage.setItem('username', data.username);
      window.localStorage.setItem('type', data.type);
      window.localStorage.setItem('token', data.token);
    },

    goToMain() {
        // console.log(this.Server.page.main.index);
        // window.location = this.Server.page.main.index;//window.location.origin + '/#/manager';
        this.$router.replace({name: 'main'});
    },

    onLoginSuccess(data) {
      this.saveToken(data);
      this.goToMain();
        // console.log(window.location);

    },

  	onLogin() {
  		// if (window.android != undefined) {
			 // window.android.navigateTo("local://navigator/manager?tabs=" + encodeURIComponent("http://172.18.12.197:8080/#/manager,http://172.18.12.197:8080/#/manager,http://172.18.12.197:8080/#/manager"));
		  // }
  		//alert('ddd')
  		let that = this;
      this.ajax().post(this.Server.api.user.login, { username: this.username, password: this.password })
      .ok(function (data) {        
          //alert(response.data.msg);
            that.onLoginSuccess(data);
            document.onkeydown = undefined;
          }).start();
  	},

  	doRegister() {
  		if (this.password != this.ensure_password) {
    			this.$message({
  		  			showClose: true,
  		  			message: '两次密码不一致', 
  		  			type: 'error',
  		  			duration: 2000
  		  		});
    		} else {
          let that = this;
    			this.ajax().post(this.Server.api.user.register, { username: this.username, password: this.password })
          .ok(function(data) {
  	  				that.$message({
  			  			showClose: true,
  			  			message: data.msg, 
  			  			type: 'success',
  			  			duration: 2000
  		  			});
  	  				that.showLogin();
  	  				//alert(response.data.last_login_time);  	  			
  	  		}).start(); 		
          
    	}
    },

  	onRegister() {
  		//alert('onRegister');
  		this.$set(this, 'needEnsure', true);   		
  	},

  	onForgetPassword() {
  		this.$message('请联系管理员！');
  	}, 

  	onDownloadApp() {
  		window.location = this.Server.base + "/app-release.apk"
  	},

    changeFixed(clientHeight){                        //动态修改样式
        // console.log(clientHeight);
        this.$refs.homePage.style.height = clientHeight+'px';
    }
  },

  mounted() {
    //console.log(this.ajax().post('url'));

  
    this.$set(this, 'loading', true);

    let that = this;
    let username = window.localStorage.getItem('username');
    let token = window.localStorage.getItem('token');
    if (username == undefined) {
      this.$set(this, 'loading', false);
      //console.log("return");
      return;
    } else if (new Date().getTime() / 1000 - token < 3600) {
      this.goToMain();
    } else {
      this.ajax().post(this.Server.api.user.loginByToken, {username: username, token: token})
      .ok(function(data) {
        that.$set(that, 'loading', false);
        that.goToMain();
      }).notOk(function(data) {
        // Message({
        //   showClose: true,
        //   message: data.msg, 
        //   type: 'error',
        //   duration: 2000
        // });          
        that.$set(that, 'loading', false);
      }).catch(function(error) {
        that.$set(that, 'loading', false);
        console.log(error);
      }).start();
    }
  },

  created() {
    var that = this;
    document.onkeydown = function(e) {
      var key = window.event.keyCode;
      if (key == 13) {
        that.onLogin();
      }
    }
  },


};
</script>

<style type="text/css" scoped>
.container {
  color: #FEFEFE;
  background: #555;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  left: 0px;
  top: 0px;
  position: fixed;/*这里一定要设置*/
}

.container2 {
  width: 80%;
  max-width: 500px;
/*  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;*/
}

table  {
  width: 100%;
  border-collapse: separate; 
  border-spacing: 0px 10px;
}

	.foot {
		width: 100%;
	    position: fixed;
	    bottom: 0;
	    overflow: hidden;
	    text-align: center;
	}
</style>
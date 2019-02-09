<template>
	<div class="container">
		<el-form ref="model" :label-position="labelPosition" label-width="80px" :model="user" :rules="rules"  align="center" class="form">
		 <!-- <el-form-item label="推荐人" prop="name">
		    <el-input :disabled="true" v-model="model.recommend" ></el-input>
		  </el-form-item>
		  <el-form-item label="接点人" prop="name">
		    <el-input :disabled="true" v-model="model.contact" ></el-input>
		  </el-form-item> -->
		  <el-form-item label="旧会员">
		    <el-input :disabled="true" v-model="user.old_username" ></el-input>
		  </el-form-item>
		 <el-form-item label="新会员" prop="name">
		    <el-input v-model="user.username" ></el-input>
		  </el-form-item>
		  <el-form-item label="密码" prop="password">
		    <el-input v-model="user.password" ></el-input>
		  </el-form-item>
		  <el-form-item label="电话" prop="phone">
		    <el-input v-model="user.phone" ></el-input>
		  </el-form-item>
		  <el-form-item label="微信" prop="wx">
		    <el-input v-model="user.wx" ></el-input>
		  </el-form-item>
		  <el-form-item label="支付宝" prop="alipay">
		    <el-input v-model="user.alipay" ></el-input>
		  </el-form-item>
		  <!-- <el-form-item label="业务方向" prop="leaf" >
		     <el-radio-group v-model="model.leaf">
			    <el-radio :label="1">1区</el-radio>
			    <el-radio :label="2">2区</el-radio>
			  </el-radio-group>
		  </el-form-item> -->
		  <el-form-item >
        	<el-button type="primary" @click="submitForm('model')">{{buttonLabel}}</el-button>
        	<el-button @click="resetForm('model')">重置</el-button>
      		</el-form-item>
		</el-form>
		<el-dialog
			title="提示"
			:visible.sync="dialogVisible"
			width="80%">
			<span>确认使用这个新会员信息更新吗？旧会员的推荐关系将由新会员继承</span>
			<span slot="footer" class="dialog-footer">
				<el-button @click="dialogVisible = false">取 消</el-button>
				<el-button type="primary" @click="doUpdate" >确 定</el-button>
			</span>
		</el-dialog>
	</div>
</template>
<script type="text/javascript">
	import axios from "axios";
	import qs from 'qs';
	import {Message} from 'element-ui';

	function isvalidPhone(str) {
  		const reg = /^1[3|4|5|7|8][0-9]\d{8}$/
  		return reg.test(str)
	}

	function isValidName(str) {
		const nameReg = /^[\u4E00-\u9FA5, 1-9]{2,4}$/;
		return nameReg.test(str);
	}

	var validPhone=(rule, value,callback)=>{
      if (!value){
          callback(new Error('请输入电话号码'))
      }else  if (!isvalidPhone(value)){
        callback(new Error('请输入正确的11位手机号码'))
      }else {
          callback()
      }
  	}

  	var validName = (rule, value, callback) => {
		if (!value){
          	callback(new Error('请输入姓名'))
      	} else  if (!isValidName(value)){
      	  	callback(new Error('请输入中文或中文加数字的名字'))
      	} else {
          	callback()
      	}
  	}

	export default {
		name: 'UpdateMember', 
	    data() {
	      return {
	      	dialogVisible: false,
	        labelPosition: 'right',
	        buttonLabel: '更新',
	        user: {
	        	old_username: '',
	          username: '',
	          password: '',
	          phone: '',
	          wx: '',
	          alipay: '',
	          // recommend: this.$route.params.username,
	          // contact: this.$route.params.username,
	          // leaf: 1,
			},
			old_username: '',
	        rules: {
	        	username: [{ required: true, trigger: 'blur', validator: validName }], /*{required: true, message: '请输入名称', trigger: 'blur'}, {min: 2, max: 10, message: '长度在2到10个字符', trigger: 'blur'}]*/
	        	password: [{ required: true, trigger: 'blur', message: '请输入密码' }],
	        	phone: [{ required: true, trigger: 'blur', validator: validPhone }],
				wx: [{ required: true, trigger: 'blur', message: '请输入微信账号' }],
				alipay: [{ required: true, trigger: 'blur', message: '请输入支付宝账号' }],
	        }
	      }
	    },

	    methods: {

	    	doUpdate() {			
	    		this.$set(this, 'dialogVisible', false);
	    		//alert(this.model.name);
	            //alert('submit!');//这里就是符合规则，然后去调对应的接口
	            let that = this;
	            let instance = axios.create({
	  				headers: { 'content-type': 'application/x-www-form-urlencoded' },
	  				withCredentials: true});
		  		instance.post(this.Server.api.member.update,
		  			qs.stringify({ old_username: this.user.old_username, username: this.user.username, password: this.user.password, phone: this.user.phone, wx: this.user.wx, alipay: this.user.alipay }))
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
		  				//that.model.name = '';
		  				//that.model.phone = '';
		  				//that.model.recommend = '';
		  				//that.$set(that, 'model', that.model);
		  				that.$router.replace({ name: 'main' });
		  				// that.$router.go(-2);
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
			          
	    	},

	    	submitForm(formName) {
	    		let that = this;
	        	this.$refs[formName].validate((valid) => {
		          if (valid) {
		          	that.$set(that, 'dialogVisible', true);
		          	//that.doUpdate();		          	
		          } else {
		            console.log('error submit!!');
		            return false;
		          }
	        	});
	      	},

	      	resetForm(formName) {
				this.$refs[formName].resetFields();
			}
	    },

	    mounted() {
	    	//alert(this.$route.params.leaf);
	    	let that = this;
	        this.ajax().get(this.Server.api.member.get + this.$route.params.username)
	        .ok(function(data) {
	        	data.data.old_username = that.$route.params.username;
	          that.$set(that, 'user', data.data);
	          //that.$set(that, 'dialogVisible', true);          
	        }).notOk(function(data) {
	          Message({
	              showClose: true,
	              message: data.msg, 
	              type: 'error',
	              duration: 1000
	            });
	        }).catch(function(error){
	          console.log(error);
	        }).start();
	    }
	}
</script>

<style type="text/css" scoped>

	.container {
		display: flex;
		flex-direction: column;
		align-items: center;
	}
	.form {
		align: center;
		width: 100%;
		max-width: 500px; 
		margin-top: 30px;
		margin-right: 20px;
	}

	.el-form-item {
		margin-bottom: 18px;
	}

	.leaf {
		display: flex;
		align-items: center;
		justify-content: center;
	}
</style>
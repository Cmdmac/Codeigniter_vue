<template>
	<div class="container">
		<el-form ref="model" :label-position="labelPosition" label-width="80px" :model="model" :rules="rules"  align="center" class="form">
		 <!-- <el-form-item label="推荐人" prop="name">
		    <el-input :disabled="true" v-model="model.recommend" ></el-input>
		  </el-form-item>
		  <el-form-item label="接点人" prop="name">
		    <el-input :disabled="true" v-model="model.contact" ></el-input>
		  </el-form-item> -->
		 <el-form-item label="姓名" prop="username">
		    <el-input :disabled="true" v-model="model.username" ></el-input>
		  </el-form-item>
		  <el-form-item label="新密码" prop="new_password">
		    <el-input v-model="model.new_password" ></el-input>
		  </el-form-item>
		  <el-form-item label="确认密码" prop="new_password2">
		    <el-input v-model="model.new_password2" ></el-input>
		  </el-form-item>
		  <el-form-item label="旧密码" prop="password">
		    <el-input v-model="model.password" ></el-input>
		  </el-form-item>
		  <el-form-item label="电话" prop="phone">
		    <el-input v-model="model.phone" ></el-input>
		  </el-form-item>
		  <el-form-item label="微信" prop="wx">
		    <el-input v-model="model.wx" ></el-input>
		  </el-form-item>
		  <el-form-item label="支付宝" prop="alipay">
		    <el-input v-model="model.alipay" ></el-input>
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
	</div>
</template>
<script type="text/javascript">
	// import axios from "axios";
	// import qs from 'qs';
	// import {Message} from 'element-ui';

	import {validPhone, validName, validPassword} from '../utils.js';

	export default {
		name: 'ModifyProfile',
	    data() {
	      return {
	        labelPosition: 'right',
	        buttonLabel: '修 改',
	        model: {
	          username: '',
	          new_password: '',
	          new_password2: '',
	          password: '',
	          phone: '',
	          wx: '',
	          alipay: '',
	          recommend: this.$route.params.username,
	          contact: this.$route.params.username,
	          leaf: 1,
			},
	        rules: {
	        	name: [{ required: true, trigger: 'blur', validator: validName }] /*{required: true, message: '请输入名称', trigger: 'blur'}, {min: 2, max: 10, message: '长度在2到10个字符', trigger: 'blur'}]*/,
	        	password: [{ required: true, trigger: 'blur', message: '请输入密码' }],
	        	new_password: [{ required: true, trigger: 'blur', message: '请输入密码' }],
	        	new_password2: [{ required: true, trigger: 'blur', message: '请输入密码' }],
	        	phone: [{ required: true, trigger: 'blur', validator: validPhone }],
				wx: [{ required: true, trigger: 'blur', message: '请输入微信账号' }],
				alipay: [{ required: true, trigger: 'blur', message: '请输入支付宝账号' }],
	        }
	      }
	    },

	    methods: {

	    	doUpdateProfile() {			
	    		//alert(this.model.name);
		            //alert('submit!');//这里就是符合规则，然后去调对应的接口
		            let that = this;
		            this.ajax().post(this.Server.api.user.modify,
			  			{ username: this.model.username, password: this.model.password, 
			  				new_password: this.model.new_password, phone: this.model.phone, wx: this.model.wx, alipay: this.model.alipay })
			  		.ok(function (data) {
		  			
		  				that.$message({
		  					showClose: true,
		  					message: data.msg, 
		  					type: 'success',
		  					duration: 1000
		  				});
		  				//that.model.name = '';
		  				//that.model.phone = '';
		  				//that.model.recommend = '';
		  				//that.$set(that, 'model', that.model);
		  				that.$router.replace({ name: 'main', params: {needRefresh: true}});
		  				//that.$router.go(-2);

			  		}).catch(function (error) {
			                //eslint-disable-next-line
			                console.log(error);
			                //alert('error');
			        }).start();
			          
	    	},

	    	submitForm(formName) {
	    		let that = this;
	        	this.$refs[formName].validate((valid) => {
		          if (valid) {
		          	if (that.model.new_password != that.model.new_password2) {
		          		that.$message({
		          			showClose: true,
		          			message: '两次密码不一样',
		          			type: 'warning',
		          			duration: 1000
		          		});
		          	} else {
		          		that.doUpdateProfile();	
		          	}
		          	          	
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
	        this.ajax().get(this.Server.api.user.get + "?username=" + this.$route.params.username)
	        .ok(function(data) {
	        	data.data.old_username = that.$route.params.username;
	          	that.$set(that, 'model', data.data);
	          //that.$set(that, 'dialogVisible', true);          
	        }).notOk(function(data){
	        	if (data.code == 201) {
					data.data.old_username = that.$route.params.username;
	          		that.$set(that, 'model', data.data);
	        	}
	        }).catch(function(error){
	          console.log(error);
	        }).start();	    
	    }
	};
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
<template>
	<div class="container">
		<el-form ref="model" :label-position="labelPosition" label-width="80px" :model="model" :rules="rules"  align="center" class="form">
		 <el-form-item label="推荐人" prop="name">
		    <el-input :disabled="disabled" v-model="model.recommend" ></el-input>
		  </el-form-item>
		  <el-form-item label="接点人" prop="name">
		    <el-input :disabled="disabled" v-model="model.contact" ></el-input>
		  </el-form-item>
		 <el-form-item label="姓名" prop="name">
		    <el-input v-model="model.name" ></el-input>
		  </el-form-item>
		  <el-form-item label="密码" prop="pwd">
		    <el-input v-model="model.pwd" ></el-input>
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
		  <el-form-item label="业务方向" prop="leaf" >
		     <el-radio-group v-model="model.leaf">
			    <el-radio :label="1">1区</el-radio>
			    <el-radio :label="2">2区</el-radio>
			  </el-radio-group>
		  </el-form-item>
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
		name: 'RegisterMember',
	    data() {
	      return {
	        labelPosition: 'right',
	        buttonLabel: '注册会员',
	        disabled: true,
	        model: {
	          name: '',
	          pwd: '',
	          phone: '',
	          wx: '',
	          alipay: '',
	          recommend: this.$route.params.username,
	          contact: this.$route.params.username,
	          leaf: 1,
			},
	        rules: {
	        	name: [{ required: true, trigger: 'blur', validator: validName }] /*{required: true, message: '请输入名称', trigger: 'blur'}, {min: 2, max: 10, message: '长度在2到10个字符', trigger: 'blur'}]*/,
	        	pwd: [{ required: true, trigger: 'blur', message: '请输入密码' }],
	        	phone: [{ required: true, trigger: 'blur', validator: validPhone }],
				wx: [{ required: true, trigger: 'blur', message: '请输入微信账号' }],
				alipay: [{ required: true, trigger: 'blur', message: '请输入支付宝账号' }],
	        }
	      }
	    },

	    methods: {

	    	doRegister() {			
	    		//alert(this.model.name);
		            //alert('submit!');//这里就是符合规则，然后去调对应的接口
		            let that = this;
		            this.ajax().post(this.Server.api.member.register,
			  			{ username: this.model.name, password: this.model.pwd, phone: this.model.phone, wx: this.model.wx, alipay: this.model.alipay, recommend: this.model.recommend, contact: this.model.contact, leaf: this.model.leaf })
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
		  				that.$router.replace({ name: 'main' });
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
		          	if (that.model.recommend != that.model.contact) {
		          		that.$message({
		          			showClose: true,
				            message: '推荐人和接点人不一样', 
				            type: 'error',
				            duration: 1000});
		          		return false;
		          	}
		          	that.doRegister();		          	
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
	    	if (this.$route.params.username == undefined) {
	    		this.$set(this, 'disabled', false);
	    	}
	    	let l = this.$route.params.leaf;
	    	if (l == undefined) {
	    		l = 1;
	    	}
	    	this.$set(this.model, 'leaf', l);
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
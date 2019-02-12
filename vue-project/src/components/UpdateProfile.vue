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
		    <el-input :disabled="disabledName" v-model="model.username" ></el-input>
		  </el-form-item>
		  <el-form-item label="密码" prop="password">
		    <el-input v-model="model.password" ></el-input>
		  </el-form-item>
		  <el-form-item label="级别" prop="level">
		    <el-input v-model="model.level" ></el-input>
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
	
	import {validPhone, validName, validPassword, valideLevel} from '../utils.js';


	export default {
		name: 'UpdateProfile',
	    data() {
	      return {
	      	disabledName: true,
	        labelPosition: 'right',
	        buttonLabel: '更 新',
	        model: {
	        	old_username: '',
	          username: '',
	          password: '',
	          level: 1,
	          phone: '',
	          wx: '',
	          alipay: '',
	          recommend: this.$route.params.username,
	          contact: this.$route.params.username,
	          leaf: 1,
			},
	        rules: {
	        	username: [{ required: true, trigger: 'blur', validator: validName }] /*{required: true, message: '请输入名称', trigger: 'blur'}, {min: 2, max: 10, message: '长度在2到10个字符', trigger: 'blur'}]*/,
	        	password: [{ required: true, trigger: 'blur', message: '请输入密码' }],
	        	level: [{ required: true, trigger: 'blur', validator: valideLevel}],
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
		            this.ajax().post(this.Server.api.user.update,
			  			{ old_username: this.model.old_username, username: this.model.username, password: this.model.password, level: this.model.level, phone: this.model.phone, wx: this.model.wx, alipay: this.model.alipay })
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
		  			}).start();
			          
	    	},

	    	submitForm(formName) {
	    		let that = this;
	        	this.$refs[formName].validate((valid) => {
		          if (valid) {
		          	if (that.model.old_level != that.model.level) {
		          		let r = confirm('级别发生了改变，' + '从' + that.model.old_level + '变为' + that.model.level + '，是否继续更新？');
		          		if (r == true) {
		          			that.doUpdateProfile();	
		          		}
		          	} else {
		          		that.doUpdateProfile();	
		          	}
		          	// that.doUpdateProfile();		          	
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
	    	let type = window.localStorage.getItem('type');
	    	if (type <= 1) {
	    		this.$set(this, 'disabledName', false);
	    	}
			let that = this;
	        this.ajax().get(this.Server.api.member.get + this.$route.params.username)
	        .ok(function(data) {
	        	data.data.old_level = data.data.level;
	        	data.data.old_username = that.$route.params.username;
	          that.$set(that, 'model', data.data);
	          //that.$set(that, 'dialogVisible', true);          
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
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
	import {validPhone, validName, validPassword} from '../utils.js';

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
	            this.ajax().post(this.Server.api.member.update,
		  			{ old_username: this.user.old_username, username: this.user.username, password: this.user.password, phone: this.user.phone, wx: this.user.wx, alipay: this.user.alipay })
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
	  				// that.$router.go(-2);
	  			}).start();
			          
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
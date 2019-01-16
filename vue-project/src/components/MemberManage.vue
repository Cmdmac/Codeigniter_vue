<template>
	<div >
		<el-form ref="model" :label-position="labelPosition" label-width="80px" :model="model" :rules="rules" align="center" style="width: 30%; margin-top: 30px">
		  <el-form-item label="姓名" prop="name">
		    <el-input v-model="model.name" ></el-input>
		  </el-form-item>
		  <el-form-item label="电话" prop="phone">
		    <el-input v-model="model.phone" ></el-input>
		  </el-form-item>
		  <el-form-item label="推荐人" prop="name">
		    <el-input v-model="model.recommend" ></el-input>
		  </el-form-item>
		  <el-form-item >
        	<el-button type="primary" @click="submitForm('model')">注册会员</el-button>
      		</el-form-item>
		</el-form>
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
		const nameReg = /^[\u4E00-\u9FA5]{2,4}$/;
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
      	  	callback(new Error('请输入长度为2~4的中文姓名'))
      	} else {
          	callback()
      	}
  	}

	export default {
	    data() {
	      return {
	        labelPosition: 'right',
	        model: {
	          name: '',
	          phone: '',
	          recommend: '',
			},
	        rules: {
	        	name: [{ required: true, trigger: 'blur', validator: validName }] /*{required: true, message: '请输入名称', trigger: 'blur'}, {min: 2, max: 10, message: '长度在2到10个字符', trigger: 'blur'}]*/,
	        	phone: [{ required: true, trigger: 'blur', validator: validPhone }],

	        }
	      }
	    },

	    methods: {

	    	doRegister() {			
	    		//alert(this.model.name);
		            //alert('submit!');//这里就是符合规则，然后去调对应的接口
		            let that = this;
		            let instance = axios.create({
		  				headers: { 'content-type': 'application/x-www-form-urlencoded' },
		  				withCredentials: true});
			  		instance.post("http://localhost/index.php/member/register",
			  			qs.stringify({ name: this.model.name, phone: this.model.phone, recommend: this.model.recommend }))
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
			  				that.model.name = '';
			  				that.model.phone = '';
			  				that.model.recommend = '';
			  				that.$set(that, 'model', that.model);
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
		            that.doRegister();
		          } else {
		            console.log('error submit!!');
		            return false;
		          }
	        });
	      	}
	    }
  }
</script>

<style type="text/css">
	
</style>
<template>
	<div class="container" :label-width="label_width" :rules="rules">
		<el-form class="form" ref="modifyForm" :model="form" >
			<el-form-item label="新密码" :label-width="label_width" prop="newPwd">
		      <el-input v-model="form.newPwd" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="确认新密码" :label-width="label_width" prop="newPwd2">
		      <el-input v-model="form.newPwd2" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="旧密码" :label-width="label_width" prop="oldPwd">
		      <el-input v-model="form.oldPwd" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="手机号" :label-width="label_width" prop="wx">
		      <el-input v-model="form.phone" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="微信" :label-width="label_width" prop="wx">
		      <el-input v-model="form.wx" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="支付宝" :label-width="label_width" prop="alipay">
		      <el-input v-model="form.alipay" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item>
			    <el-button type="primary" @click="submitForm('modifyForm')">提交</el-button>
			    <el-button @click="resetForm('modifyForm')">重置</el-button>
			 </el-form-item>
		  </el-form>
	</div>
</template>

<script type="text/javascript">
	export default {
		name: 'ModifyProfile',
		data() {
			return {
				label_width: '100px',
				form: {
					newPwd: '',
					newPwd2: '',
					oldPwd: '',
					wx: '',
					alipay: ''
				},

				rules: {
					 newPwd: [{ required: true, message: '请输入新密码', trigger: 'blur' }],
			          newPwd2: [{ required: true, message: '请输入旧密码', trigger: 'blur' }],
			          oldPwd: [{ required: true, message: '请确认旧密码', trigger: 'blur' }],
			          phone: [{ required: true, message: '请输入手机号码', trigger: 'blur' }],
			          wx: [{ required: true, message: '请输入微信账号', trigger: 'blur' }],
			          alipay: [{ required: true, message: '请输入支付宝名账号', trigger: 'blur' }]
				}
			}
		},

		methods: {
			submitForm(formName) {
				this.$refs[formName].validate((valid) => {
					if (valid) {
						alert('submit!');
					} else {
						console.log('error submit!!');
						return false;
					}
				});
			},
			resetForm(formName) {
				this.$refs[formName].resetFields();
			}
		}
	}
</script>

<style type="text/css" scoped>
	.container {
		display: flex;
		justify-content: center;
		align-items: center;
		margin: 10px;
	}

	.form {
		width: 90%;
	}

	
</style>
<template>
	<div>
		<div align="right" style="margin-top:20px;"><el-button type="primary" @click="onRefesh">刷新</el-button><el-button type="primary" @click="onAddManager">增加管理员</el-button><el-button @click="passwordManage" type="primary">密码管理</el-button></div>
	  <el-table
	    :data="tableData"
	    border
	    style="margin-top: 20px; position: relative; overflow: auto;">
	    <el-table-column
	      prop="username"
	      align="center"
	      label="用户名"
	      max-width="100"
	      min-width="80">
	    </el-table-column>
	    <el-table-column
	      prop="password"
	      label="密码"
	      align="center"
	      max-width="100"
	      min-width="80">
	    </el-table-column>
	    <el-table-column
	      prop="type"
	      label="类型"
	      :formatter="formatType"
	      align="center"
	      max-width="100"
	      min-width="80">
	    </el-table-column>
	    <el-table-column
	      prop="state"
	      label="状态"
	      :formatter="formatState"
	      align="center"
	      max-width="80"
	      min-width="80">
	    </el-table-column>
	    <el-table-column
	      prop="time"
	      label="注册时间"
	      align="center"
	      min-width="180">
	    </el-table-column>
	    <el-table-column
	      fixed="right"
	      label="操作"
	      align="center"
	      min-width="120">
	      <template slot-scope="scope">
	        <el-button @click="onReview(scope.row)" type="text" size="small">审核</el-button>
	        <el-button @click="onDisable(scope.row)" type="text" size="small">停用</el-button>
	        <el-button @click="onEdit(scope.row)" type="text" size="small">编辑</el-button>
	      </template>
	    </el-table-column>
	  </el-table>
	  
	  	  <el-dialog ref="addDialog" title="增加管理员" :visible.sync="addDialogFormVisible" width="90%">
		  <el-form ref="addForm" :model="form" :rules="rules">
		    <el-form-item label="用户名" :label-width="formLabelWidth" prop="username">
		    	<el-input v-model="form.username" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="密码" :label-width="formLabelWidth" prop="password">
		    	<el-input v-model="form.password" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="电话" :label-width="formLabelWidth" prop="phone">
		   		<el-input v-model="form.phone" ></el-input>
			</el-form-item>
			<el-form-item label="微信" :label-width="formLabelWidth" prop="wx">
				<el-input v-model="form.wx" ></el-input>
			</el-form-item>
			<el-form-item label="支付宝" :label-width="formLabelWidth" prop="alipay">
				<el-input v-model="form.alipay" ></el-input>
			</el-form-item>
		  </el-form>
		  <div slot="footer" class="dialog-footer">
		    <el-button @click="addDialogFormVisible = false">取 消</el-button>
		    <el-button type="primary" @click="submitForm('addForm')">确 定</el-button>
		  </div>
		</el-dialog>

	  <el-dialog ref="modifyDialog" title="修改管理信息" :visible.sync="dialogFormVisible" width="90%">
		  <el-form ref="form" :model="form" :rules="rules">
		    <el-form-item label="用户名" :label-width="formLabelWidth" prop="username">
		      <el-input v-model="form.username" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="密码" :label-width="formLabelWidth" prop="password">
		      <el-input v-model="form.password" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="电话" :label-width="formLabelWidth" prop="phone">
		   		<el-input v-model="form.phone" ></el-input>
			</el-form-item>
			<el-form-item label="微信" :label-width="formLabelWidth" prop="wx">
				<el-input v-model="form.wx" ></el-input>
			</el-form-item>
			<el-form-item label="支付宝" :label-width="formLabelWidth" prop="alipay">
				<el-input v-model="form.alipay" ></el-input>
			</el-form-item>
		  </el-form>
		  <div slot="footer" class="dialog-footer">
		    <el-button @click="dialogFormVisible = false">取 消</el-button>
		    <el-button type="primary" @click="submitForm('form')">确 定</el-button>
		  </div>
	</el-dialog>
	
	<el-dialog ref="passwordDialog" title="密码管理" :visible.sync="passwordDialogVisible" width="90%">
		<el-form ref="passwordForm" :model="pwds" :rules="rulesPwd">
		    <el-form-item label="第一级密码" :label-width="formLabelWidth2" prop="pwd1">
		      <el-input v-model="pwds.pwd1" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="第二级密码" :label-width="formLabelWidth2" prop="pwd2">
		      <el-input v-model="pwds.pwd2" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="第三级密码" :label-width="formLabelWidth2" prop="pwd3">
		   		<el-input v-model="pwds.pwd3" ></el-input>
			</el-form-item>
			<el-form-item label="第四级密码" :label-width="formLabelWidth2" prop="pwd4">
				<el-input v-model="pwds.pwd4" ></el-input>
			</el-form-item>
			<el-form-item label="第五级密码" :label-width="formLabelWidth2" prop="pwd5">
				<el-input v-model="pwds.pwd5" ></el-input>
			</el-form-item>
			<el-form-item label="第六级密码" :label-width="formLabelWidth2" prop="pwd6">
				<el-input v-model="pwds.pwd6" ></el-input>
			</el-form-item>
			<el-form-item label="第七级密码" :label-width="formLabelWidth2" prop="pwd7">
				<el-input v-model="pwds.pwd7" ></el-input>
			</el-form-item>
			<el-form-item label="第八级密码" :label-width="formLabelWidth2" prop="pwd8">
				<el-input v-model="pwds.pwd8" ></el-input>
			</el-form-item>
		  </el-form>
		  <div slot="footer" class="dialog-footer">
		    <el-button @click="passwordDialogVisible = false">取 消</el-button>
		    <el-button type="primary" @click="submitForm('passwordForm')">确 定</el-button>
		  </div>
	</el-dialog>

	</div>
</template>

<script type="text/javascript">
	import axios from 'axios';
	import qs from 'qs';
	import {Message} from 'element-ui';

	function isValidName(str) {
		const nameReg = /^[\u4E00-\u9FA5]{2,4}$/;
		return nameReg.test(str);
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

	function isvalidPhone(str) {
  		const reg = /^1[3|4|5|7|8][0-9]\d{8}$/
  		return reg.test(str)
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

	export default {
		data() {
	      return {
	      	formLabelWidth: '80px',
	      	formLabelWidth2: '100px',
	      	dialogFormVisible: false,
	      	addDialogFormVisible: false,
	      	passwordDialogVisible: false,
	        tableData: [/*{
	          time: '2016-05-03',
	          name: '王小虎1',
	          type: '1',
	          state: '未激活'
	        }, {
	          time: '2016-05-03',
	          name: '王小虎2',
	          type: '1',
	          state: '未激活'
	        }, {
	          time: '2016-05-03',
	          name: '王小虎',
	          type: '1',
	          state: '未激活'
	        }, {
	          time: '2016-05-03',
	          name: '王小虎',
	          type: '1',
	          state: '未激活'
	        }*/],
	        form: {
	        	id: '',
	          username: '',
	          password: ''
	        },
	        pwds: {
	        	pwd1: '',
	        	pwd2: '',
	        	pwd3: '',
	        	pwd4: '',
	        	pwd5: '',
	        	pwd6: '',
	        	pwd7: '',
	        	pwd8: ''
	        },
	        rules: {
		        username: [{ required: true, trigger: 'blur', message: '请输入用户名' }] /*{required: true, message: '请输入名称', trigger: 'blur'}, {min: 2, max: 10, message: '长度在2到10个字符', trigger: 'blur'}]*/,
		        password: [{ required: true, trigger: 'blur', message: '请输入密码' }],
		        phone: [{ required: true, trigger: 'blur', validator: validPhone }],
				wx: [{ required: true, trigger: 'blur', message: '请输入微信账号' }],
				alipay: [{ required: true, trigger: 'blur', message: '请输入支付宝账号' }],
		    },
		    rulesPwd: {
		    	pwd1: [{ required: true, trigger: 'blur', message: '请输入密码'}],
		    	pwd2: [{ required: true, trigger: 'blur', message: '请输入密码'}],
		    	pwd3: [{ required: true, trigger: 'blur', message: '请输入密码'}],
		    	pwd4: [{ required: true, trigger: 'blur', message: '请输入密码'}],
		    	pwd5: [{ required: true, trigger: 'blur', message: '请输入密码'}],
		    	pwd6: [{ required: true, trigger: 'blur', message: '请输入密码'}],
		    	pwd7: [{ required: true, trigger: 'blur', message: '请输入密码'}],
		    	pwd8: [{ required: true, trigger: 'blur', message: '请输入密码'}]
		    }
	      }
	    },
    	methods: {
    		passwordManage() {
    			let that = this;
    			this.$set(this, 'passwordDialogVisible', true);
    			this.ajax().get(this.Server.api.manager.password.get)
    			.ok(function(data) {    				
    				that.$set(that, 'pwds', data.data);
    				that.$set(that, 'passwordDialogVisible', true);
    			}).notOk(function(data) {
					Message({
		  				showClose: true,
		  				message: data.msg, 
		  				type: 'error',
		  				duration: 2000
		  			});
    			}).catch(function(error) {

    			}).start();
    		},

    		updatePasswords() {
    			let that = this;
    			this.ajax().post(this.Server.api.manager.password.update, 
    				{pwd1: this.pwds.pwd1, pwd2: this.pwds.pwd2, 
    				pwd3: this.pwds.pwd3, pwd4: this.pwds.pwd4, 
    				pwd5: this.pwds.pwd5, pwd6: this.pwds.pwd6, 
    				pwd7: this.pwds.pwd7, pwd8: this.pwds.pwd8})
    				.ok(function(data) {
    					that.$set(that, 'passwordDialogVisible', false);
    					Message({
			  				showClose: true,
			  				message: data.msg, 
			  				type: 'success',
			  				duration: 2000
			  			});		
    				}).notOk(function(data) {

    				}).catch(function(error) {

    				}).start();
    		},

	    	onRefesh() {
				let that = this;
		    	let instance = axios.create({
		    		headers: { 'content-type': 'application/x-www-form-urlencoded' },
		    		withCredentials: true});
		    	instance.get(this.Server.api.manager.list)
		    	.then(function (response) {

		    		if (response.data.code == 200) {
		    			that.$set(that, 'tableData', response.data.data);
		    		} else {
					  	
					}
				}).catch(function (error) {
				        //eslint-disable-next-line
				        console.log(error);
				        //alert('error');
				});
	    	},
	    	onAddManager() {
	    		this.$set(this, 'addDialogFormVisible', true);
	    	},
		      onReview(row) {
		        console.log(row);
		        if (row.state == 1) {
		        	let that = this;
				    let instance = axios.create({
				  				headers: { 'content-type': 'application/x-www-form-urlencoded' },
				  				withCredentials: true});
					instance.post(this.Server.api.manager.active,
					  			qs.stringify({ username: row.username }))
					.then(function (response) {
					  		if (response.data.code == 200) {
					  				//alert(response.data.msg);
					  				//window.location = 'http://localhost:8080/#/manager?username=' + that.username
					  				//alert(response.data.last_login_time);
					  			Message({
					  				showClose: true,
					  				message: response.data.msg, 
					  				type: 'success',
					  				duration: 2000
					  			});			  			
					  			row.state = '2';
					  			that.$set(that, 'tableData', that.tableData);
					  		} else {
					  				//alert(response.data.msg);
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
		        } else if (row.state == 2) {
		        	Message({
					  	showClose: true,
					  	message: '已审核', 
					  	type: 'success',
					  	duration: 1000
					});
		        }
		      },

      onDisable(row) {
			let that = this;
		    let instance = axios.create({
		  				headers: { 'content-type': 'application/x-www-form-urlencoded' },
		  				withCredentials: true});
			instance.post(this.Server.api.manager.disable,
			  			qs.stringify({ username: row.username }))
			.then(function (response) {
			  		if (response.data.code == 200) {
			  				//alert(response.data.msg);
			  				//window.location = 'http://localhost:8080/#/manager?username=' + that.username
			  				//alert(response.data.last_login_time);
			  			Message({
			  				showClose: true,
			  				message: response.data.msg, 
			  				type: 'success',
			  				duration: 2000
			  			});
			  			row.state = '1';
			  			that.$set(that, 'tableData', that.tableData);
			  			//window.location.reload();		  			
			  		} else {
			  				//alert(response.data.msg);
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

      onEdit(row) {
      	this.$set(this, 'dialogFormVisible', true);
      	this.form.id = row.id;
      	this.form.username = row.username;
      	this.form.password = row.password;
      	this.form.phone = row.phone;
      	this.form.wx = row.wx;
      	this.form.alipay = row.alipay;
      	this.$set(this, 'form', this.form);
      },

      doEdit() {
		let that = this;
	    let instance = axios.create({
			headers: { 'content-type': 'application/x-www-form-urlencoded' },
			withCredentials: true});
		instance.post(this.Server.api.manager.edit,
		  			qs.stringify({ id: this.form.id, username: this.form.username, password: this.form.password, phone: this.form.phone, wx: this.form.wx, alipay: this.form.alipay }))
		.then(function (response) {
		  		if (response.data.code == 200) {
		  			Message({
		  				showClose: true,
		  				message: response.data.msg, 
		  				type: 'success',
		  				duration: 2000
		  			});
		  			//row.state = '1';
		  			for (let i = 0; i < that.tableData.length; i++) {
		  				let row = that.tableData[i];
		  				if (row.id == that.form.id) {
		  					row.username = that.form.username;
		  					row.password = that.form.password;
		  					break;
		  				}
		  			}
		  			that.$set(that, 'tableData', that.tableData);
		  			//window.location.reload();		  			
		  		} else {
		  				//alert(response.data.msg);
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

      addManager() {
		let that = this;
	    let instance = axios.create({
	  				headers: { 'content-type': 'application/x-www-form-urlencoded' },
	  				withCredentials: true});
		instance.post(this.Server.api.manager.add,
		  			qs.stringify({ username: this.form.username, password: this.form.password, phone: this.form.phone, wx: this.form.wx, alipay: this.form.alipay }))
		.then(function (response) {
		  		if (response.data.code == 200) {
		  			Message({
		  				showClose: true,
		  				message: response.data.msg, 
		  				type: 'success',
		  				duration: 2000
		  			});
		  			//row.state = '1';
		  			that.$set(that, 'addDialogFormVisible', false);
		  			that.onRefesh();		  			  			
		  		} else {
		  				//alert(response.data.msg);
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

      submitForm(formName) {
	      	let that = this;
	      	this.$refs[formName].validate((valid) => {
	      		if (valid) {
	      			if (formName == 'form') {
	      				that.doEdit();
	      			} else if (formName == 'addForm') {
	      				that.addManager();
	      			} else if (formName == 'passwordForm') {
	      				that.updatePasswords();
	      			}

	      			that.$set(that, 'dialogFormVisible', false);
	      		} else {
	      			console.log('error submit!!');
	      			return false;
	      		}
	      	});
	    },

		formatType: function(row, column) {
      		if (row.type == 0) {
      		 	return "超级管理员";
      		} else if (row.type == 1) {
      			return '管理员'
      		} else {
      			return '未知';
      		}
    	},

    	formatState: function(row, column) {
      		if (row.state == '1') {
      		 	return "未审核";
      		} else if (row.state == '2') {
      			return '已审核';
      		} else {
      			return '未知状态';
      		}
    	}

    },
    
    mounted() {
    	this.onRefesh();
    }
  };
</script>

<style type="text/css">
	
</style>
<template>
	<div>
		<div align="right"><el-button type="primary" @click="onRefesh">刷新</el-button><el-button type="primary" @click="onAddManager">增加管理员</el-button></div>
	  <el-table
	    :data="tableData"
	    border
	    style=" width: 90%; margin-top: 20px;">
	    <el-table-column
	      fixed
	      prop="username"
	      align="center"
	      label="用户名"
	      min-width="150">
	    </el-table-column>
	    <el-table-column
	      prop="password"
	      label="密码"
	      align="center"
	      min-width="120">
	    </el-table-column>
	    <el-table-column
	      prop="type"
	      label="类型"
	      :formatter="formatType"
	      align="center"
	      min-width="120">
	    </el-table-column>
	    <el-table-column
	      prop="state"
	      label="状态"
	      :formatter="formatState"
	      align="center"
	      min-width="120">
	    </el-table-column>
	    <el-table-column
	      prop="time"
	      label="注册时间"
	      align="center"
	      min-width="120">
	    </el-table-column>
	    <el-table-column
	      fixed="right"
	      label="操作"
	      align="center"
	      min-width="100">
	      <template slot-scope="scope">
	        <el-button @click="onReview(scope.row)" type="text" size="small">审核</el-button>
	        <el-button @click="onDisable(scope.row)" type="text" size="small">停用</el-button>
	        <el-button @click="onEdit(scope.row)" type="text" size="small">编辑</el-button>
	      </template>
	    </el-table-column>
	  </el-table>
	  
	  	  <el-dialog ref="addDialog" title="增加管理员" :visible.sync="addDialogFormVisible" width="30%">
		  <el-form ref="addForm" :model="form" :rules="rules">
		    <el-form-item label="用户名" :label-width="formLabelWidth" prop="username">
		      <el-input v-model="form.username" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="密码" :label-width="formLabelWidth" prop="password">
		      <el-input v-model="form.password" autocomplete="off"></el-input>
		    </el-form-item>
		  </el-form>
		  <div slot="footer" class="dialog-footer">
		    <el-button @click="addDialogFormVisible = false">取 消</el-button>
		    <el-button type="primary" @click="submitForm('addForm')">确 定</el-button>
		  </div>
		</el-dialog>

	  <el-dialog ref="modifyDialog" title="修改管理信息" :visible.sync="dialogFormVisible" width="30%">
		  <el-form ref="form" :model="form" :rules="rules">
		    <el-form-item label="用户名" :label-width="formLabelWidth" prop="username">
		      <el-input v-model="form.username" autocomplete="off"></el-input>
		    </el-form-item>
		    <el-form-item label="密码" :label-width="formLabelWidth" prop="password">
		      <el-input v-model="form.password" autocomplete="off"></el-input>
		    </el-form-item>
		  </el-form>
		  <div slot="footer" class="dialog-footer">
		    <el-button @click="dialogFormVisible = false">取 消</el-button>
		    <el-button type="primary" @click="submitForm('form')">确 定</el-button>
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

	export default {
    	methods: {
	    	onRefesh() {
				let that = this;
		    	let instance = axios.create({
		    		headers: { 'content-type': 'application/x-www-form-urlencoded' },
		    		withCredentials: true});
		    	instance.get("http://localhost/index.php/manager/list")
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
					instance.post("http://localhost/index.php/manager/active",
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
			instance.post("http://localhost/index.php/manager/disable",
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
      	this.$set(this, 'form', this.form);
      },

      doEdit() {
		let that = this;
	    let instance = axios.create({
	  				headers: { 'content-type': 'application/x-www-form-urlencoded' },
	  				withCredentials: true});
		instance.post("http://localhost/index.php/manager/edit",
		  			qs.stringify({ id: this.form.id, username: this.form.username, password: this.form.password }))
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
		instance.post("http://localhost/index.php/manager/add",
		  			qs.stringify({ username: this.form.username, password: this.form.password }))
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

    data() {
      return {
      	formLabelWidth: '80px',
      	dialogFormVisible: false,
      	addDialogFormVisible: false,
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
        rules: {
	        username: [{ required: true, trigger: 'blur', message: '请输入用户名' }] /*{required: true, message: '请输入名称', trigger: 'blur'}, {min: 2, max: 10, message: '长度在2到10个字符', trigger: 'blur'}]*/,
	        password: [{ required: true, trigger: 'blur', message: '请输入密码' }],
	    }
      }
    },
    
    mounted() {
    	this.onRefesh();
    }
  }
</script>

<style type="text/css">
	
</style>
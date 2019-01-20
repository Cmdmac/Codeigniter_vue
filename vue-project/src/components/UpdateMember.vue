<template>
	<div>
	    <div class="titlebar">
	    	<el-input v-model="search" placeholder="输入推荐人" style="margin-right: 10px">
	    	</el-input><el-button type="small" @click="onSearch">搜索推荐人</el-button>
		</div>

		<el-table
		    :data="tableData"
		    border
		    style="margin-top: 20px; position: relative; overflow: auto;">
		    <el-table-column
		      prop="name"
		      align="center"
		      label="姓名"
		      max-width="100"
		      min-width="80">
		    </el-table-column>
		    <el-table-column
		      prop="phone"
		      label="电话"
		      align="center"
		      max-width="140"
		      min-width="120">
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
		      min-width="80">
		      <template slot-scope="scope">
		        <el-button @click="onEdit(scope.row, scope.$index)" type="text" size="small">更新</el-button>
		      </template>
		    </el-table-column>
		  </el-table>
		   <el-dialog ref="updateDialog" title="更新会员" :visible.sync="dialogFormVisible" width="90%">
			  <el-form ref="form" :model="form" :rules="rules">
			    <el-form-item label="姓名" prop="name">
			      <el-input v-model="form.name" autocomplete="off"></el-input>
			    </el-form-item>
			    <el-form-item label="电话" prop="phone">
			      <el-input v-model="form.phone" autocomplete="off"></el-input>
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
				tableData: [],
				search: '',
				dialogFormVisible: false,
				form: {
					index: 0,
					id: '',
					name: '',
					phone: ''
				},
				rules: {
		        	name: [{ required: true, trigger: 'blur', validator: validName }] /*{required: true, message: '请输入名称', trigger: 'blur'}, {min: 2, max: 10, message: '长度在2到10个字符', trigger: 'blur'}]*/,
		        	phone: [{ required: true, trigger: 'blur', validator: validPhone }],
	        	}
			}
		},
		methods: {
			onEdit(row, index) {
				console.log(index);
				this.form.index = index;
				this.form.id= row.id;
				this.form.name = row.name;
				this.form.phone = row.phone;
				this.dialogFormVisible = true;
				this.$set(this, 'dialogFormVisible', this.dialogFormVisible);
			},

			onSearch() {
				console.log(this.search);
				let that = this;
	            let instance = axios.create({
	  				headers: { 'content-type': 'application/x-www-form-urlencoded' },
	  				withCredentials: true});
		  		instance.get(this.Server.api.member.getChildren + this.search)
		  		.then(function (response) {
		  			if (response.data.code == 200) {
		  				//alert(response.data.msg);
		  				//window.location = 'http://localhost:8080/#/manager?username=' + that.username
		  				//alert(response.data.last_login_time);
		  				if (response.data.data.length == 0) {
		  					that.tableData = [];
		  				} else {
		  					that.tableData = response.data.data;
		  				}
		  				that.$set(that, 'tableData', that.tableData);
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

			updateMember() {
				let that = this;
	            let instance = axios.create({
	  				headers: { 'content-type': 'application/x-www-form-urlencoded' },
	  				withCredentials: true});
		  		instance.post(this.Server.api.member.update, qs.stringify({ id: this.form.id, name: this.form.name, phone: this.form.phone }))
		  		.then(function (response) {
		  			if (response.data.code == 200) {
		  				//alert(response.data.msg);
		  				//window.location = 'http://localhost:8080/#/manager?username=' + that.username
		  				//alert(response.data.last_login_time);
		  				let item = that.tableData[that.form.index];
		  				item.name = that.form.name;
		  				item.phone = that.form.phone;
		  				item.time = response.data.data.time;
		  				that.$set(that, 'tableData', that.tableData);
		  				that.$set(that, 'dialogFormVisible', false);
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
		          	that.updateMember();		          	
		          } else {
		            console.log('error submit!!');
		            return false;
		          }
	        	});
	      	}
		}
	}
</script>
<style scope>
	.titlebar {
		display: flex;
		width: 100%;
		margin-top: 20px;
	}
</style>
<template>
	<div>
		<div align="right"><el-button type="primary" @click="onAddManager">增加管理员</el-button></div>
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
	</div>
</template>

<script type="text/javascript">
	import axios from 'axios';
	import qs from 'qs';
	import {Message} from 'element-ui';

	export default {
    methods: {
    	onAddManager() {
    		alert('add')
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
        }*/]
      }
    },
    
    mounted() {
    	let that = this;
    	let instance = axios.create({
    		headers: { 'content-type': 'application/x-www-form-urlencoded' },
    		withCredentials: true});
    	instance.get("http://localhost/index.php/manager/list")
    	.then(function (response) {
    		if (response.data.code == 200) {
    			console.log(response.data);
    			that.$set(that, 'tableData', response.data.data);
    		} else {
			  	
			}
		}).catch(function (error) {
		        //eslint-disable-next-line
		        console.log(error);
		        //alert('error');
		});
    }
  }
</script>

<style type="text/css">
	
</style>
<template>
	<div class="main">
		<div class="AccountInfo">
			<div align="right"><div class="button" @click="onLogout">退出系统</div></div>
			<div class="No">
				<div>
					<div>会员编员</div>
					<div>{{user.uid}}</div>
				</div>
				<div>
					<div>注册币</div>
					<div>0</div>
				</div>
			</div>
			<div class="Name">
				<div>{{user.username}}</div>
			</div>
			<div class="State">
				<div style="margin-right: 10px;">会员状态：<span class="stateColor" v-bind:style="stateColor">{{user.level == 0 ? "未激活" : "正式会员"}}</span></div><div style="margin-left: 10px;">会员级别：{{user.level}}级</div>
			</div>
		</div>
		<div class="Entries">
			<table>
				<tr v-for="(item, index) in items" :key="index">
					<td v-for="(subItem, j) in item" :key="j" @click="onItemClick(index, j)">
						<div class="item">
							<div><img :src="subItem.icon" /></div>
							<div>{{subItem.title}}</div>							
						</div>
					</td>
				</tr>
				<!-- <tr><td><div>1</div></td><td><div>2</div></td><td><div>2</div></td></tr>
				<tr><td><div>4</div></td><td><div>5</div></td><td><div>6</div></td></tr>
				<tr><td><div>7</div></td><td><div>8</div></td><td><div>9</div></td></tr> -->
			</table>
		</div>
		<div style="height: 200px;">空白</div>
		<BottomBar :user="user" />
	</div>
</template>

<script type="text/javascript">
	import axios from 'axios';
	import qs from 'qs';
  	import BottomBar from '@/components/widgets/BottomBar'
	import {Message} from 'element-ui';

	export default {
		name: 'Main',
		components: {BottomBar, 'ModifyProfile': () => import("@/components/ModifyProfile")},
		data() {
			return {
				stateColor: {color: '#FEFEFE'},
				user: {id: 123456, username: "", state: "", level: 1},
				items: []
			}
		},

		methods: {

			onLogout() {

				let username = window.localStorage.getItem('username');
	      		let that = this;
		            let instance = axios.create({
		  				headers: { 'content-type': 'application/x-www-form-urlencoded' },
		  				withCredentials: true});
			  		instance.post(this.Server.api.user.logout, qs.stringify({ username: username}))
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
			  				//退出，清除登录数据，回到登录
			  				window.localStorage.removeItem('username');
			  				window.localStorage.removeItem('type');
			  				window.localStorage.removeItem('token');
			  				window.location = that.Server.host;
			  			} else {
			  				//alert(response.data.msg);
			  				Message({
			  					showClose: true,
			  					message: response.data.msg, 
			  					type: 'error',
			  					duration: 1000
			  				});
			  				window.location = that.Server.host;
			  			}
			  		}).catch(function (error) {
			                //eslint-disable-next-line
			                console.log(error);
			                //alert('error');
			        });
			},

			onItemClick(i, j) {
				if (this.canNavigate(i, j)) {
					this.$router.replace({ name: this.items[i][j].name, params: this.user});
					//window.location = this.items[i][j].target;
				}
			},

			canNavigate(i, j) {
				let item = this.items[i][j];
				if (item.name == undefined) {
					return false;
				} 

				if (item.level > parseInt(this.user.level)) {
					Message({
	  					showClose: true,
	  					message: '您没有权限使用此功能', 
	  					type: 'error',
	  					duration: 1000
	  				});
					return false;
				}
				return true;
			}, 

			initItems() {
				let items = [
						[{title: "联盟公告", icon: "1184611.png", level: 1, name: "http://www.baidu.com"}, {title: "团队结构", icon: "1184619.png", level: 1, name: "TeamManager"}, {title: "问题解答", icon: "1184675.png", level: 1}], 
						[{title: "游戏规则", icon: "1187084.png", level: 1,}, {title: "金币转账", icon: "1187096.png", level: 2}, {title: "升级记录", icon: "1187101.png", level: 1, name: 'updateRecorders'}],
						[{title: "会员管理", icon: "1187113.png", level: 2}, {title: "修改资料", icon: "1187116.png", level: 1, name: 'modifyProfile' }, {title: "我的账号", icon: "1187148.png", level: 1}]
					];

				
				this.$set(this, 'items', items);
			}
		},

		mounted() {
			let that = this;
			let username = window.localStorage.getItem('username');
			this.ajax().get(this.Server.api.user.get + "?username=" + username)
		  		.ok(function (data) {			  			
	  				//保存为全局对象
	  				//that.Vue.prototype.globalUser = response.data.data;
	  				that.$set(that, 'user', data.data);
	  				if (that.user.level == 0) {
	  					that.stateColor.color = 'red';
	  					that.$set(that, 'stateColor', that.stateColor);
	  				} else {
	  					that.stateColor.color = '#FEFEFE';
	  					that.$set(that, 'stateColor', that.stateColor);
	  				}

	  				that.initItems();			  			
		  		}).notOk(function(data) {
		  			Message({
	  					showClose: true,
	  					message: response.data.msg, 
	  					type: 'error',
	  					duration: 1000
	  				});
		  		}).catch(function(error) {
		  			console.log(error);

		  		}).start();
		}

	}
</script>

<style type="text/css" scoped>

	
	.main {
		background: #FEFEFE;
		margin: 0px;
	}

	.AccountInfo {
		display: flex;
		flex-direction: column;
		color: #EEEEEE;
		background: #333;
	}

	.No {
		font-size: 10pt;
		display: flex;
		margin-top: 20px;
		margin-left: 40px;
		margin-right: 40px;
		justify-content: space-between;
	}

	.Name {
		font-size: 20pt;
		margin-top: 40px;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.State {
		margin: 5px;
		font-size: 10pt;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.stateColor {
		color: #FEFEFE;
	}

	.Entries {
		width: 100%;
		height: 100%;
		margin-top: 20px;
		font-size: 10pt;
	}

	table {
		width: 100%;
	}

	tr {
		width: 100%;
		height: 100px;
		display: flex;
	}

	td {
		flex-grow: 1;
		height: 100%;
	}

	td:active {
		background: #DDD;
	}

	.item {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		height: 100%;
	}

	img {
		width: 60px;
		height: 60px;
	}

	.button {
		background: none;
		border-width: 0px;
		color: #FEFEFE;
		font-size: 10pt;
		margin: 10px;
	}

</style>
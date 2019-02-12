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
				<div style="margin-right: 10px;">会员状态：<span v-if="user.type <= 1" style="color: red">管理员</span><span v-if="user.type > 1" class="stateColor" v-bind:style="stateColor">{{user.level == 0 ? "未激活" : "正式会员"}}</span></div><div style="margin-left: 10px;">会员级别：{{user.level}}级</div>
			</div>
		</div>
		<div class="Entries">
			<table>
				<tr v-for="(item, index) in items" :key="index">
					<td v-for="(subItem, j) in item" :key="j" @click="onItemClick(index, j)">
						<div class="item" v-if="subItem">
							<div><img v-if="subItem.icon" class="img" :src="subItem.icon" /><div v-if="subItem.icon == undefined" class="img_none"></div></div>
							<div>{{subItem.title}}</div>							
						</div>
					</td>
				</tr>
				<!-- <tr><td><div>1</div></td><td><div>2</div></td><td><div>2</div></td></tr>
				<tr><td><div>4</div></td><td><div>5</div></td><td><div>6</div></td></tr>
				<tr><td><div>7</div></td><td><div>8</div></td><td><div>9</div></td></tr> -->
			</table>
		</div>
		<!-- <div style="height: 200px;">空白</div> -->
		<BottomBar :user="user" v-if="showBottom"/>
	</div>
</template>

<script type="text/javascript">
	
  	// import BottomBar from '@/components/widgets/BottomBar'

	export default {
		name: 'Main',
		components: {'BottomBar': () => import("@/components/widgets/BottomBar"), 'ModifyProfile': () => import("@/components/ModifyProfile")},
		data() {
			return {
				stateColor: {color: '#FEFEFE'},
				user: {id: 123456, username: "", state: "", level: 1},
				items: [],
				showBottom: true
			}
		},

		methods: {

			onLogout() {

				let username = window.localStorage.getItem('username');
	      		let that = this;
	            this.ajax().post(this.Server.api.user.logout, { username: username})
		  		.ok(function (data) {
			  			
	  				that.$message({
	  					showClose: true,
	  					message: data.msg, 
	  					type: 'success',
	  					duration: 1000
	  				});
	  				//退出，清除登录数据，回到登录
	  				window.localStorage.removeItem('username');
	  				window.localStorage.removeItem('type');
	  				window.localStorage.removeItem('token');
	  				for (let i = 1; i <= 8; i++) {
	  					window.localStorage.removeItem('last_time_input_level' + i);
	  				}			  				
	  				window.location = that.Server.host;
			  			       //alert('error');
		        }).start();
			},

			onItemClick(i, j) {
				if (this.canNavigate(i, j)) {
					this.$router.push({ name: this.items[i][j].name, params: this.user});
					//window.location = this.items[i][j].target;
				}
			},

			canNavigate(i, j) {
				let item = this.items[i][j];
				if (item.name == undefined) {
					return false;
				} 

				if (item.level > parseInt(this.user.level)) {
					this.$message({
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
						[{title: "联盟公告", icon: "images/notification.png", level: 0, name: "Notification"}, 
						{title: "团队结构", icon: "images/connections.png", level: 1, name: "TeamManager"}, 
						{title: "问题解答", icon: "images/documents.png", level: 0, name: 'Questions'}], 

						[{title: "游戏规则", icon: "images/infomation.png", level: 0, name: 'GameRules'}, 
						{title: "金币转账", icon: "images/money.png", level: 2}, 
						{title: "升级记录", icon: "images/interface.png", level: 1, name: 'updateRecorders'}],

						[{title: "修改资料", icon: "images/light.png", level: 0, name: 'ModifyProfile' },
						{},
						{}]
					];

				let type = window.localStorage.getItem('type');
				if (type != undefined && type < 1) {
					items[2][0] = {title: "会员管理", icon: "images/agenda.png", name: 'StaticsManager', level: 8};
					items[2][1] = {title: "修改资料", icon: "images/light.png", level: 0, name: 'ModifyProfile' };
					items[2][2] = {title: "系统管理", icon: "images/barchart.png", level: 8, name: 'SystemManage'};
				}
				this.$set(this, 'items', items);
			},

			initForManager() {
				let type = window.localStorage.getItem('type');
				if (type == 0) {
					//超级管理员
					let items = [
						[{title: "联盟公告", icon: "images/notification.png", level: 0, name: "Notification"}, 
						{title: "游戏规则", icon: "images/infomation.png", level: 0, name: 'GameRules'},
						{title: "问题解答", icon: "images/documents.png", level: 0, name: 'Questions'}], 

						[{title: "修改资料", icon: "images/light.png", level: 0, name: 'ModifyProfile' },
						{title: "金币转账", icon: "images/money.png", level: 2}, 
						{title: "系统管理", icon: "images/barchart.png", level: 8, name: 'SystemManage'}],

						[{title: "会员管理", icon: "images/agenda.png", name: 'StaticsManager', level: 8}, 
						{title: "团队结构", icon: "images/connections.png", level: 1, name: "TeamManager"},
						{}]
					];
				
					this.$set(this, 'items', items);
				} else if (type == 1) {
					//普通管理员
					let items = [
						[{title: "联盟公告", icon: "images/notification.png", level: 0, name: "Notification"}, 
						{title: "游戏规则", icon: "images/infomation.png", level: 0, name: 'GameRules'},
						{title: "问题解答", icon: "images/documents.png", level: 0, name: 'Questions'}], 

						[{title: "会员管理", icon: "images/agenda.png", name: 'StaticsManager', level: 8}, 
						{title: "金币转账", icon: "images/money.png", level: 2}, 
						{title: "修改资料", icon: "images/light.png", level: 0, name: 'ModifyProfile' }]
					];
				
					this.$set(this, 'items', items);
				}	
				
				this.$set(this, "showBottom", false);
			},

			initForUser() {
				//普通会员
				let items = [
					[{title: "联盟公告", icon: "images/notification.png", level: 0, name: "Notification"}, 
					{title: "游戏规则", icon: "images/infomation.png", level: 0, name: 'GameRules'},
					{title: "问题解答", icon: "images/documents.png", level: 0, name: 'Questions'}], 

					[{title: "修改资料", icon: "images/light.png", level: 0, name: 'ModifyProfile' }, 
					{title: "金币转账", icon: "images/money.png", level: 2},
					{}]
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
		  			//没有在团队结构中，管理员或者是已经被淘汰的会员
		  			if (data.code == 201) {
		  				that.$set(that, 'user', data.data);
			  			if (that.user.type <= 1 && that.user.level == 8) {
			  				that.initForManager();
			  			} else {
			  				that.initForUser();
			  			}
		  			}		  			
		  		}).start();
		}

	};
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
		width: 100%;
		height: 100%;
	}

	.img {
		width: 48px;
		height: 48px;
	}

	.img_none {
		width: 48px;
		height: 48px;
	}

	.button {
		background: none;
		border-width: 0px;
		color: #FEFEFE;
		font-size: 10pt;
		margin: 10px;
	}

</style>
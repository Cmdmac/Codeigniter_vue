<template>
	<div class="container">
		<div>
			<div class="level">你当前的级别是:<span class="currentLevel">{{member.level}}</span>，下一个级别是<span class="nextLevel">{{parseInt(member.level) < 8 ? parseInt(member.level) + 1 : "已经是最高级别了"}}</span></div>
			<div v-if="contact != undefined">需要上层会员：<span class="nextLevel"><span v-if="contact.level - member.level >= 2">[超越升级]</span>{{contact.username}}</span>，交升级款</div>
			<div v-if="contact != undefined" class="item">
					<div>上层会员信息：</div>
			 		<div >姓名：<span>{{contact.username}}</span></div>
			 		<div >微信：<span>{{contact.wx}}</span></span></div>
			 		<div >支付宝：<span>{{contact.alipay}}</span></div>
			 </div>
		</div>
		<el-button v-if="contact == undefined" type="primary" style="margin: 10px;width: 80%; max-width: 500px" @click="onRequestUpdate">申请升级</el-button>
		<el-button v-if="contact != undefined" type="primary" style="margin: 10px;width: 80%; max-width: 500px" @click="onUpdate">确认升级</el-button>

		 <el-dialog ref="contactDialog" title="接点人信息" :visible.sync="showContact" width="80%">
		 	<div v-if="contact != undefined">
		 		<div>姓名:<span>{{contact.username}}</span></div>
		 		<div>微信:<span>{{contact.wx}}</span></span></div>
		 		<div>支付宝：<span>{{contact.alipay}}</span></div>
		 	</div>
		</el-dialog>
	</div>
</template>

<script type="text/javascript">
	import {Message} from 'element-ui';

	export default {
		name: 'RequestUpdate',
		data() {
			return {
				showContact: false,
				isOver: false,
				contact: undefined,
				member: {}
			}
		},
		methods: {
			onUpdate() {
				let that = this;
				this.ajax().post(this.Server.api.update.add, {username: this.member.username, contact: this.contact.username})
				.ok(function(data) {
					Message({
	  					showClose: true,
	  					message: data.msg, 
	  					type: 'error',
	  					duration: 1000
	  				});
	  				window.location = that.Server.page.main.index;
				}).notOk(function(data) {
					Message({
	  					showClose: true,
	  					message: data.msg, 
	  					type: 'error',
	  					duration: 1000
	  				});
	  				if (data.code == 401) {

	  				} else {
	  					window.location = that.Server.page.main.index;
	  				}
				}).start();
			},

			onRequestUpdate() {
				//console.log(this.ajax());
				let that = this;
				this.ajax().get(this.Server.api.member.findContact + window.user.username)
				.ok(function(data) {
					that.contact = data.data;
					that.$set(that, 'contact', that.contact);
				}).notOk(function(data) {

				}).start();
			}
		}, 

		mounted() {
			if (window.member == undefined && window.user != undefined) {
				let that = this;
				this.ajax().get(this.Server.api.member.get + window.user.username)
				.ok(function(data) {
					window.member = data.data;
					that.$set(that, 'member', data.data);
				}).notOk(function(data) {

				}).start();
			} else {
				this.$set(this, 'member', window.member);
			}
		}

	}
</script>

<style type="text/css" scoped>
	.container {
		margin: 10px;
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.level {
		font-size: 12pt;
		margin: 10px;
		margin-top: 250px;
	}

	.currentLevel {
		font-weight: bold; 
		font-size: 15pt;
	}

	.nextLevel {
		color: red; 
		font-weight: bold; 
		font-size: 20pt;
	}

	.item {
		font-weight: bold;
		margin-top: 10px;
	}

	p {
		width: 100%;
	}
</style>
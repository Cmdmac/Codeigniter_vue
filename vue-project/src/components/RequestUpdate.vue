<template>
	<div class="container">
		<div>
			<div class="level">你当前的级别是:<span class="currentLevel">{{parseInt(user.level)}}</span>，下一个级别是<span class="nextLevel">{{parseInt(user.level) < 8 ? parseInt(user.level) + 1 : "已经是最高级别了"}}</span></div>
			<div v-if="contact != undefined">需要上层会员：<span class="nextLevel"><span v-if="contact.level - parseInt(user.level) >= 2">[超越升级]</span>{{contact.username}}</span>，交升级款</div>
			<div v-if="contact != undefined" class="item">
					<div>上层会员信息：</div>
			 		<div >姓名：<span>{{contact.username}}</span></div>
			 		<div >微信：<span>{{contact.wx}}</span></span></div>
			 		<div >支付宝：<span>{{contact.alipay}}</span></div>
			 </div>
		</div>
		<el-button v-if="showRequestButton" type="primary" style="margin: 10px;width: 80%; max-width: 500px" @click="onRequestUpdate">申请升级</el-button>
		<el-button v-if="contact != undefined" type="primary" style="margin: 10px;width: 80%; max-width: 500px" @click="onUpdate">确认升级</el-button>

		 <el-dialog ref="contactDialog" title="接点人信息" :visible.sync="showContact" width="80%">
		 	<div v-if="contact != undefined">
		 		<div>姓名:<span>{{contact.username}}</span></div>
		 		<div>微信:<span>{{contact.wx}}</span></span></div>
		 		<div>支付宝：<span>{{contact.alipay}}</span></div>
		 	</div>
		</el-dialog>
		<PasswordChecker :level="this.user.level" @password-valide="passwordValided" />
	</div>
</template>

<script type="text/javascript">
	// import {Message} from 'element-ui';

	export default {
		name: 'RequestUpdate',
		components: {'PasswordChecker': () => import("@/components/widgets/PasswordChecker")},
		data() {
			return {
				showContact: false,
				isOver: false,
				contact: undefined,
				user: undefined,
				showRequestButton: false
			}
		},
		methods: {
			onUpdate() {
				let that = this;
				this.ajax().post(this.Server.api.update.add, {username: this.user.username, contact: this.contact.username})
				.ok(function(data) {
					that.$message({
	  					showClose: true,
	  					message: data.msg, 
	  					type: 'success',
	  					duration: 1000
	  				});
	  				//window.location = that.Server.page.main.index;
	  				that.$router.push({name: 'main'，params: {needRefresh: true}});
				}).notOk(function(data) {					
	  				if (data.code == 401) {

	  				} else {
	  					//window.location = that.Server.page.main.index;
	  					that.$router.push({name: 'main'});
	  				}
				}).start();
			},

			onRequestUpdate() {
				//console.log(this.ajax());
				let that = this;
				//console.log(this.member);
				this.ajax().get(this.Server.api.member.findContact + this.user.username)
				.ok(function(data) {
					that.contact = data.data;
					that.$set(that, 'contact', that.contact);
					that.$set(that, 'showRequestButton', false);
				}).notOk(function(data) {

				}).start();
			},

			passwordValided() {

			}
		}, 

		created() {
			//this.member = JSON.parse(JSON.stringify(this.$route.params));
			this.user = this.$route.params;
			//this.$set(this, 'member', this.member);
			//console.log(this.member);
			//console.log('created');
		}, 

		mounted() {
			//this.member = this.$route.params;
			//this.$set(this, 'member', this.member);
			//console.log(this.$router.query);
			
			if (this.user.level < 8) {
				this.$set(this, 'showRequestButton', true);
			}					
			
			
		}

	};
</script>

<style type="text/css" scoped>
	.container {
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
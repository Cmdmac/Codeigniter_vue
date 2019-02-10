<template>
	<div>
		<div class="nodata" v-if="records.length == 0">没有数据</div>
		<div class="list">
			<div class="listItem" v-for="(item, index) in records" :key="index" @click="onReview(index)">
				<div style="display: flex; justify-content: space-between; align-items: center; font-size: 10pt; width: 100%"><span align="left">{{index + 1}}.<span style="color: red;">{{item.username}}</span>向<span style="color: red;">{{item.contact}}</span>申请升级</span><span align="right" style="margin-left: 5px;font-size: 8pt; color: #DDD">{{item.time}}</span></div>
			</div>
		</div>
		<el-dialog
			title="提示"
			:visible.sync="dialogVisible"
			width="80%">
			<span>确认已从<span class="warning">{{item.username}}</span>收到升级款并将其从级别<span class="warning">{{item.level_from}}</span>升级到级别<span class="warning">{{item.level_to}}</span>吗?</span>
			<span slot="footer" class="dialog-footer">
				<el-button @click="dialogVisible = false">取 消</el-button>
				<el-button type="primary" @click="confirmReview" >确 定</el-button>
			</span>
		</el-dialog>
		<PasswordChecker :level="this.user.level" @password-valide="passwordValided" />
	</div>
</template>

<script type="text/javascript">
	// import {Message} from 'element-ui';
	export default {
		name: 'ReviewRecorders',
		components: {'PasswordChecker': () => import("@/components/widgets/PasswordChecker")},
		data() {
			return {
				records:[],
				message: '',
				item: {},
				user: {},
				dialogVisible: false
			}
		},

		methods: {
			confirmReview() {
				let that = this;
				this.$set(this, 'dialogVisible', false);
				this.ajax().post(this.Server.api.update.review, {username: this.item.username, contact: this.item.contact})
				.ok(function(data) {
					that.$message({
	  					showClose: true,
	  					message: data.msg, 
	  					type: 'success',
	  					duration: 1000
	  				});
					that.refesh();
				}).start();

			},

			onReview(index) {
				let that = this;
				let item = this.records[index];
				//let message = '确认已从' + item.username + '收到升级款并将其从级别' + item.level_from +'升级到级别' + item.level_to + '吗?';
				this.$set(this, 'item', item);
				this.$set(this, 'dialogVisible', true);
			},

			refesh() {
				let that = this;
				this.ajax().get(this.Server.api.update.getReviewRecords + this.$route.params.username)
				.ok(function(data){

					that.$set(that, 'records', data.data);

				}).notOk(function(data) {

				}).start();
			},

			passwordValided() {
				this.refesh();
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

			// this.refesh();
		}
	};
</script>

<style type="text/css" scoped>
	.nodata {
		margin-top: 200px;
	}
	.warning {
		color: red;
		font-weight: bold;
	}

	.list {
		margin: 10px;
	}

	.listItem {
		display: flex;
		flex-direction: column;
		align-items: start;
		justify-content: center;
		width: 100%;
		height: 50px;
		border-bottom: 1px solid #DDD;

	}

</style>
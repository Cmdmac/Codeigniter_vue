<template>
	<div>
		<div class="nodata" v-if="records.length == 0">没有数据</div>
		<ul>
			<li v-for="(item, index) in records" :key="index" @click="onReview(index)">
				<div>{{item.username}}向{{item.contact}}申请升级</div>
			</li>
		</ul>
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
	</div>
</template>

<script type="text/javascript">
	import {Message} from 'element-ui';
	export default {
		name: 'ReviewRecorders',
		data() {
			return {
				records:[],
				message: '',
				item: {},
				dialogVisible: false
			}
		},

		methods: {
			confirmReview() {
				this.$set(this, 'dialogVisible', false);
				this.ajax().post(this.Server.api.update.review, {username: this.item.username, contact: this.item.contact})
				.ok(function(data) {
					Message({
	  					showClose: true,
	  					message: data.data.msg, 
	  					type: 'success',
	  					duration: 1000
	  				});
				}).notOk(function(data) {
					Message({
	  					showClose: true,
	  					message: data.data.msg, 
	  					type: 'error',
	  					duration: 1000
	  				});
				}).start();

			},

			onReview(index) {
				let that = this;
				let item = this.records[index];
				//let message = '确认已从' + item.username + '收到升级款并将其从级别' + item.level_from +'升级到级别' + item.level_to + '吗?';
				this.$set(this, 'item', item);
				this.$set(this, 'dialogVisible', true);
			}

		},

		mounted() {

			let that = this;
			this.ajax().get(this.Server.api.update.getReviewRecords + this.$route.params.username)
			.ok(function(data){

				that.$set(that, 'records', data.data);

			}).notOk(function(data) {

			}).start();
		}
	}
</script>

<style type="text/css" scoped>
	.nodata {
		margin-top: 200px;
	}
	.warning {
		color: red;
		font-weight: bold;
	}
</style>
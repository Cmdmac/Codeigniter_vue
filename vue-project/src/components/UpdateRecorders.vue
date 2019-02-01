<template>
	<div>
		<div class="nodata" v-if="records.length == 0">没有数据</div>
		<ul>
			<li v-for="(item, index) in records" :key="index">
				<div>{{item.username}}向{{item.contact}}申请升级</div>
			</li>
		</ul>
	</div>
</template>

<script type="text/javascript">
	export default {
		name: 'UpdateRecords',
		data() {
			return {
				records:[]
			}
		},

		methods: {


		},

		mounted() {

			let that = this;
			this.ajax().get(this.Server.api.update.getUpdateRecords + window.user.username)
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
</style>
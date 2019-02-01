<template>
	<div>
		<div class="nodata" v-if="records.length == 0">没有数据</div>
		<div class="list">
			<div class="listItem" v-for="(item, index) in records" :key="index">
				<div style="font-size: 12pt;">{{item.username}}向{{item.contact}}申请升级</div>
			</div>
		</div>
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

	.title {

	}
</style>
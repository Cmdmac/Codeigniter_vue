<template>
	<div class="bottom-bar">
		<div v-on:click="onTabItemClick(index)" :class="{item: selected != index, 'item-selected': selected == index}" v-for="(item, index) in tabItems" :key="index">
			<img class="item-img" :src="tabItems[index].image">
			<div class="item-text">{{tabItems[index].title}}</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default {
		name: 'BottomBar',
		props: {user: Object},
		data() {
			return {
				// tabItems: this.tabs,
				selected: 0,
				tabItems: [{title: '首页', image: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1548858922438&di=f4e09c3cd7299d315809bd1420c40c53&imgtype=0&src=http%3A%2F%2Fimg.zcool.cn%2Fcommunity%2F01f6d058d9d6c0a801219c77562fcf.png%401280w_1l_2o_100sh.png'},
            		{title: '站内信', image: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1549457318&di=67bc402aaae6cd3688ff11a4903a6a34&imgtype=jpg&er=1&src=http%3A%2F%2Fimg.25pp.com%2Fuploadfile%2Fapp%2Ficon%2F20160420%2F1461149412855957.jpg'}, 
       				{title: '申请升级', image: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1549457318&di=67bc402aaae6cd3688ff11a4903a6a34&imgtype=jpg&er=1&src=http%3A%2F%2Fimg.25pp.com%2Fuploadfile%2Fapp%2Ficon%2F20160420%2F1461149412855957.jpg', target: 'requestUpdate'}, 
       				{title: '审核状况', image: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1548858922438&di=f4e09c3cd7299d315809bd1420c40c53&imgtype=0&src=http%3A%2F%2Fimg.zcool.cn%2Fcommunity%2F01f6d058d9d6c0a801219c77562fcf.png%401280w_1l_2o_100sh.png', target: 'reviewRecorders'}]
			}
		},

		methods: {
			// onTabItemClick(index) {
				// this.selected = index;
				// this.$set(this, 'selected', this.selected);
				// this.$emit('onTabItemClick', index);
				// this.onItemClick()
			// },

			onTabItemClick(index) {
				let tab = this.tabItems[index];
				if (tab.target != undefined) {
					//window.location = tab.target;
					this.$router.push({ name: tab.target, params: this.user});
				}
			}
		}
	};
</script>
<style type="text/css" scoped>
	.bottom-bar {
		float: left;
        position: fixed;
        display: flex;
		flex-direction: row;
		align-items: center;
        bottom: 0px;
        width: 100%;
        
        background-color: #DDDDDDDD;
    }

	.item {
		padding: 10px;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		height: 100%;
		flex-grow: 1;
		background: #AAA;
		-webkit-box-flex: 1;
    	-webkit-flex: 1;
    	font-size: 10pt;
	}

	.item:active {
		background: #999;
	}

	.item-selected {
		padding: 10px;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		height: 100%;
		flex-grow: 1;
		background: #888;
		-webkit-box-flex: 1;
    	-webkit-flex: 1;
    	font-size: 10pt;
	}

	.item-img {
		width: 30px;
		height: 30px;
	}

	.item-text {
		margin-top: 5px;
	}
</style>
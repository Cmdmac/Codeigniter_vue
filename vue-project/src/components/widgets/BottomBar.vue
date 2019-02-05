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
				tabItems: [{title: '首页', image: 'images/home.png'},
            		{title: '站内信', image: 'images/mail.png'}, 
       				{title: '申请升级', image: 'images/note.png', target: 'requestUpdate'}, 
       				{title: '审核状况', image: 'images/check.png', target: 'reviewRecorders'}]
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
	}
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
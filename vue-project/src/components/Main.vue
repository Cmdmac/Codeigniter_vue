<template>
	<div class="main">
		<div class="AccountInfo">
			<div align="right"><button>退出系统</button></div>
			<div class="No">
				<div>会员编员</div>
				<div>注册币</div>
			</div>
			<div class="Name">
				<div>魏群春</div>
			</div>
			<div class="State">
				<div>会员状态：正式会员</div><div>会员级别：1级</div>
			</div>
		</div>
		<div class="Entries">
			<table>
				<tr v-for="(item, index) in items" :key="index">
					<td v-for="(subItem, j) in item" :key="j">
						<div>
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
		<BottomBar :tabs="tabs"/>
	</div>
</template>

<script type="text/javascript">
  	import BottomBar from '@/components/BottomBar'
	export default {
		name: 'Main',
		components: {BottomBar},
		data() {
			return {
				items: [[{title: "联盟公告", icon: "1184611.png"}, {title: "团队结构", icon: "1184619.png"}, {title: "问题解答", icon: "1184675.png"}], [{title: "游戏规则", icon: "1187084.png"}, {title: "金币转账", icon: "1187096.png"}, {title: "升级记录", icon: "1187101.png"}], [{title: "会员管理", icon: "1187113.png"}, {title: "修改资料", icon: "1187116.png"}, {title: "我的账号", icon: "1187148.png"}]],
				tabs: [{title: '首页', image: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1548858922438&di=f4e09c3cd7299d315809bd1420c40c53&imgtype=0&src=http%3A%2F%2Fimg.zcool.cn%2Fcommunity%2F01f6d058d9d6c0a801219c77562fcf.png%401280w_1l_2o_100sh.png'},
            		{title: '站内信', image: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1549457318&di=67bc402aaae6cd3688ff11a4903a6a34&imgtype=jpg&er=1&src=http%3A%2F%2Fimg.25pp.com%2Fuploadfile%2Fapp%2Ficon%2F20160420%2F1461149412855957.jpg'}, 
       				{title: '申请升级', image: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1549457318&di=67bc402aaae6cd3688ff11a4903a6a34&imgtype=jpg&er=1&src=http%3A%2F%2Fimg.25pp.com%2Fuploadfile%2Fapp%2Ficon%2F20160420%2F1461149412855957.jpg'}, 
       				{title: '审核状况', image: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1548858922438&di=f4e09c3cd7299d315809bd1420c40c53&imgtype=0&src=http%3A%2F%2Fimg.zcool.cn%2Fcommunity%2F01f6d058d9d6c0a801219c77562fcf.png%401280w_1l_2o_100sh.png'}]
			}
		}
	}
</script>

<style type="text/css" scoped>

	
	.main {
		background: #FEFEFE;
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

	img {
		width: 60px;
		height: 60px;
	}

</style>
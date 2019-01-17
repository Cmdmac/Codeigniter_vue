<template>
	<div align="center" style="width: 80%;">
		<div align="left" style="margin-left: 10px; margin-bottom: 20px; font-size: 15pt;">欢迎<span style="font-weight: bold">{{$route.query.username}}</span>登录XXX系统</div>
		<el-tabs v-model="activeName2" type="card" @tab-click="handleClick">
		    <el-tab-pane label="会员管理" name="first"><MemberManage /></el-tab-pane>
		    <el-tab-pane v-if="showSystemPage" label="系统管理" name="second"><SystemManage /></el-tab-pane>
		    <el-tab-pane v-if="showSystemPage" label="统计管理" name="third">统计管理</el-tab-pane>
  		</el-tabs>
	</div>

</template>

<script type="text/javascript">
	import MemberManage from './MemberManage.vue'
	import SystemManage from './SystemManage.vue'
	export default {
	components: {MemberManage, SystemManage},
    data() {
      return {
      	showSystemPage: false,
        activeName2: 'first'
      };
    },
    methods: {
      handleClick(tab, event) {
        console.log(tab, event);
      }
    },

    mounted() {
    	let username = window.localStorage.getItem('username');
    	let type = window.localStorage.getItem('type');
    	if (type == '0') {
    		this.$set(this, 'showSystemPage', true);
    	} else {
    		this.$set(this, 'showSystemPage', false);
    	}
    }
  };
</script>

<style type="text/css">
	
</style>
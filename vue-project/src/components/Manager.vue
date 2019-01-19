<template>
	<div align="center" style="width: 100%;">
		<div align="left" style="margin-left: 10px; margin-bottom: 20px; font-size: 15pt;">欢迎<span style="font-weight: bold">{{username}}</span>欢迎登录爱我中华自助系统</div>
		<el-tabs type="card" @tab-click="handleClick" tab-position="top" v-model="activeName">
		    <el-tab-pane label="会员管理" name="first"><MemberManage /></el-tab-pane>
		    <el-tab-pane v-if="showSystemPage" label="系统管理" name="second" :lazy='true'><SystemManage /></el-tab-pane>
		    <el-tab-pane v-if="showSystemPage" label="统计管理" name="third" :lazy="true"><StaticsManager /></el-tab-pane>
  		</el-tabs>
	</div>

</template>

<script type="text/javascript">
	// import MemberManage from './MemberManage.vue'
	// import SystemManage from './SystemManage.vue'
	// import StaticsManager from './StaticsManager.vue'
	export default {
		components: {'MemberManage': () => import("@/components/MemberManage"), 'SystemManage': () => import("@/components/SystemManage"), 'StaticsManager': () => import("@/components/StaticsManager")},
	    data() {
	      return {
	      	username: '',
	      	loadTab2: false,
	      	loadTab3: false,
	      	showSystemPage: false,
	        activeName: 'second'
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
	    	let time = window.localStorage.getItem('time');
	    	//console.log(this.$route);
	    	if (new Date().getTime() - time > 6 * 3600 * 1000) {
	    		window.location = window.location.origin + '/#/user';
	    		return;
	    	}
	    	if (type == '0') {
	    		this.$set(this, 'showSystemPage', true);
	    	} else {
	    		this.$set(this, 'showSystemPage', false);
	    	}
	    	this.$set(this, 'username', username);
	    }
  };
</script>

<style type="text/css">
	
</style>
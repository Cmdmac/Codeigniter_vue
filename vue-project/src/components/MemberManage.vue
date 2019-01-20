<template>
	<div >
		<el-radio-group v-model="tab" @change="onCheckChange">
		    <el-radio :label="0">注册会员</el-radio>
		    <el-radio :label="1">更新会员</el-radio>
		</el-radio-group>
		<component :is="target"/>
	</div>
</template>

<script type="text/javascript">

	export default {
		components: {'RegisterMember': () => import("@/components/RegisterMember"), 'UpdateMember': () => import("@/components/UpdateMember")},
	    data() {
	      return {
	      	tab: 0,
	      	target: 'RegisterMember'
	      }
	    },

	    methods: {

	      	onCheckChange(index) {
	      		//alert(index);
	      		if (index == 0) {
	      			//注册
	      			this.target = 'RegisterMember';
	      		} else {
	      			//更新
	      			this.target = 'UpdateMember';
	      		}
	      	}
	    }
  }
</script>

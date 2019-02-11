<template>
  <div id="app">
    <div align="left">
      <span style="font-weight: bold; font-size: 12pt">共有<span style="color: red; font-size: 15pt">{{totalMemberCount}}</span>个注册会员 </span>
      <!-- <el-button type="text" @click="loadTree">刷新</el-button> -->
      <span>
        <button @click="clickRegister">注册会员</button>
        <!-- <button @click="clickUpdate">更新会员</button> -->
      </span>
    </div>
    <div class="header">
      <input class="input" v-model="query" placeholder="输入会员名查询"></input><button @click="onQuery">查询</button>
      <span style="font-size: 10pt">显示:</span>
      <select class="select" v-model="level" @change="getLevel">
        <!-- <option value="1">1层</option> -->
        <!-- <option value="2">2层</option> -->
        <option value="3">3层</option>
        <option value="4">4层</option>
        <option value="5">5层</option>
        <option value="6">6层</option>
        <option value="7">7层</option>
      </select>
    </div>
    
    <TreeChart ref="tree" :json="tree" align='center' :class="{landscape: landscape.length}" 
      v-on:click-handle="onClickHandler" 
      v-on:click-node="clickNode" 
      v-on:click-register="clickRegister"
      v-on:click-refresh="clickRefresh"></TreeChart>
    <footer class="foot" v-if="false">
        <div align="right" style="margin-right: 10px">切换为横向<input type="checkbox" v-model="landscape" value="1"></div>
    </footer>

    <!--
    <el-button type="primary" @click="onFind">查找</el-button>
  -->

    <el-dialog
      title="会员信息"
      :visible.sync="dialogVisible"
      width="80%">
      <table cellspacing="10px">
        <tr><td class="infoHeader">姓名:</td><td class="info">{{member.username}}</td></tr>
        <tr><td class="infoHeader">级别:</td><td class="info">{{member.level}}</td></tr>
        <tr><td class="infoHeader">方向:</td><td class="info">{{member.leaf}}区 </td></tr>
        <tr><td class="infoHeader">电话:</td><td class="info">{{member.phone}}</td></tr>
        <tr><td class="infoHeader">微信:</td><td class="info">{{member.wx}}</td></tr>
        <tr><td class="infoHeader">支付宝:</td><td class="info">{{member.alipay}}</td></tr>
      </table>
      <span slot="footer" class="dialog-footer">
        <!-- <el-button @click="dialogVisible = false">取 消</el-button> -->
        <el-button v-if="user.type != 0" type="primary" @click="dialogVisible = false" >确 定</el-button>
        <el-button v-if="user.type <= 1" type="primary" @click="onModifyProfile" >修改资料</el-button>
        <el-button v-if="user.type <= 1" @click="onReplace" >替换会员</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
  // import axios from 'axios';
  // import qs from 'qs';
  // import {Message} from 'element-ui';
  import TreeChart from "@/components/widgets/TreeChart";
  // import TitleBar from "@/components/TitleBar";

export default {
  name: 'StaticsManager',
  components: {
    TreeChart
  },
  data() {
    return {
      query: '',
      level: 3,
      dialogVisible: false,
      totalMemberCount: 0,
      landscape: [],
      tree: {
      },
      user: {},
      member: {}
    }
  },
  methods: {
    onModifyProfile() {
      this.$set(this, 'dialogVisible', false);
      this.$router.replace({ name: 'UpdateProfile', params: { username: this.member.username }});
      // this.$router.replace({ name: 'UpdateProfile', params: { username: this.member.username }});
    },

    onReplace() {
      this.$set(this, 'dialogVisible', false);
      this.$router.replace({ name: 'UpdateMember', params: { username: this.member.username }});
    },

    onQuery() {
      if (this.query == '') {
        return;
      }

      //this.showMemberInfo(this.query);
      let q = this.query.replace(/(^\s*)|(\s*$)/g, "");
      let r = this.findNode(this.tree, q);
      if (r == undefined) {
        this.$message({
              showClose: true,
              message: '没找到', 
              type: 'error',
              duration: 1000
            });
      } else {
        // console.log(r);
        this.showMemberInfo(r.name);
      }
      //alert(r);
    },

    getLevel: function (ele) {
      //var optionTxt = $(ele.target).find("option:selected").text();
      var optionVal = ele.target.value;
      //alert(optionVal);
      this.loadTree();
    },

    onFind() {
      let r = this.findNode(this.tree, 'grandchild3');
      if (r != undefined) {
        //console.log(r);
      }
    },

    showMemberInfo(username) {
        let that = this;
        this.ajax().get(this.Server.api.member.get + username)
        .ok(function(data) {
          that.$set(that, 'member', data.data);
          that.$set(that, 'dialogVisible', true);          
        }).start();
    },

    clickRegister: function(node) {
        this.$router.replace({ name: 'registeMember', params: {username: node.parent, leaf: node.leaf}});
    },


    clickUpdate: function() {
      // alert(node);
      // this.$router.push({ name: 'UpdateMember', params: { username: this.member.username }});
        // this.$router.replace({ name: 'UpdateMember', params: { username: node.name }});
    },

    clickNode: function(node){
      // eslint-disable-next-line
      //console.log(node)
      //this.getChildren(node.name);
      //console.log(node);
        // get member info
        if (node.name.indexOf('空位') == -1) {
          this.showMemberInfo(node.name);
        }        
      
    },

    clickRefresh: function(node) {
      // alert('refesh');
      this.getChildren(node.name);
    },

    onClickHandler: function(node) {
      // console.log(e);
      // this.getChildren(node.name);
      if (node.children == undefined || node.children.length == 0) {
        this.getChildren(node.name);
      } else if (node.children != undefined && node.children.length == 2 && node.children[0].name == '空位' && node.children[1].name == '空位') {
        this.getChildren(node.name);
      }
    },

    getChildren(recommend) {
      let that = this;
      this.ajax().get(this.Server.api.member.getChildren + recommend)
      .ok(function (data) {
       
        let children = data.data;
        if (children.length == 0) {
          return;
        }
        let node = that.findNode(that.tree, recommend);
        //console.log(node);
        node.children = children;
        node.showChildren = true;
        for (let i = 0; i < node.children.length; i++) {
          let item = node.children[i];
          // item.showRefresh = true;
          item.name = item.username;
          that.totalMemberCount++;
        }

        that.buildTree(node);

        if (node.children.length > 0) {
          node.extend = true;
        }
        // node.leaf = node.children.length == 0;
        
        //console.log(that.tree);
        that.$set(that, 'tree', that.tree);
        that.$set(that, 'totalMemberCount', that.totalMemberCount);
        that.$refs.tree.toggleExtend(node);
        // that.$refs.tree.toggleExtend(node);
        // that.$refs.tree.toggleExtend(node);
        // that.$refs.tree.toggleExtend(node);
       
      }).start();
    },

    findNode(node, name) {
      if (node.name == name) {
        return node;
      } else {
        if (node.children == undefined) {
          return undefined;
        }
        for (let i = 0; i < node.children.length; i++) {
          let n = node.children[i];
          let r = this.findNode(n, name);
          if (r != undefined) {
            return r;
          }
        }
        return undefined;
      }
    },

    buildTree(data) {
      // this.totalMemberCount = 0;
      if (data == undefined) {
        // data.showRefresh = true;
        return;
      } 
      // data.showRefresh = true;
      data.showChildren = true;
      if (data.children != undefined && data.children.length > 0) {
        // for (let i = 0; i < data.children.length; i++) {
        //   let item = data.children[i];
        //   this.totalMemberCount++;
        //   this.buildTree(item);
        // }
        let children = data.children;
        if (data.children.length == 2) {
          this.totalMemberCount += 2;
          if (children[0].leaf != 1 && children[1].leaf != 2) {
            //exchange
            let t = children[0];
            children[0] = children[1];
            children[1] = t;
          }
          this.buildTree(children[0]);
          this.buildTree(children[1]);
        } else if (data.children.length == 1) {
          this.totalMemberCount++;
          let node = children[0];
          if (node.leaf == 1) {
            let right = { name : '空位', children: undefined, leaf: 2, parent: data.name};
            right.register = true;
            children[1] = right;
            this.buildTree(children[0]);
          } else {
            let left = { name : '空位', children: undefined, leaf: 1, parent: data.name};
            left.register = true;
            // let t = node;
            children[0] = left;
            children[1] = node;
            this.buildTree(children[1]);
          }                        
        } 
      } else {
        data.children = [];
          let left = { name : '空位', children: undefined, leaf: 1, parent: data.name};
          let right = { name : '空位', children: undefined, leaf: 2, parent: data.name};
          // if (data.name == this.user.username) {
            left.register = true;
            right.register = true;
          // }
          data.children.push(left);
          data.children.push(right);
      }
    },

    loadTree() {
      let that = this;
      this.ajax().get(this.Server.api.member.init + "?level=" + this.level)
          .ok(function (data) {
            //console.log(response.data);
            let tree = data.data;
            that.totalMemberCount = 0;
            that.buildTree(tree);
            that.$set(that, 'totalMemberCount', that.totalMemberCount);
            that.$set(that, 'tree', tree);
          }).start();

          // instance.get(this.Server.api.member.getMemberCount)
          // .then(function(response) {
          //   if (response.data.code == 200) {
          //     that.totalMemberCount = response.data.data;
          //     that.$set(that, 'totalMemberCount', that.totalMemberCount);
          //   }
          // }).catch(function(error) {

          // });
    }
  },

  mounted() {
    //this.getChildren('root');
    this.$set(this, 'user', this.$route.params);
    this.loadTree();
  }
};
</script>

<style scoped>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 20px;
  margin-left: 10px;
}
#app .avat{border-radius: 2em;border-width:2px;}
#app .name{font-weight:700;}

.header {
  display: flex;
  width: 100%;
  height: 30px;
  align-items: center;
}

.input {
  width: 100px;
  height: 20px;
  border-width: 1px;
  border-style: solid;
  border-color: #DDD;
  font-size: 10pt;
}

.select
{
   width                    : 50px;
   height                   : 20px;
   line-height              : 20px;
   padding-right            : 10px;
   text-indent              : 4px;
   text-align               : left;
   vertical-align           : middle;
   border                   : 1px solid #94c1e7;
   -moz-border-radius       : 6px;
   -webkit-border-radius    : 6px;
   border-radius            : 6px;
   -webkit-appearance       : none;
   -moz-appearance          : none;
   appearance               : none;
   font-family              : SimHei;
   font-size                : 10pt;
   font-weight              : 500;
   color                    : RGBA(50,50,50,0.7);
   cursor                   : pointer;
   outline                  : none;
}

.foot {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background: #ccc;
    padding: 10px;
    overflow: hidden;
    color: #333;
    font-size: 14px;
    text-align: center;
}
.foot a{color:#fff; margin:0 .5em}

.infoHeader {
  width: 50px;
  text-align: right;
}
.info {
  width: 80px;
  font-weight: bold;
  text-align: left;
}
</style>

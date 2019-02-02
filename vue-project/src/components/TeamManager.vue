<template>
  <div id="app">
<!--     <div align="left"><span style="font-weight: bold; font-size: 13pt">总有<span style="color: red; font-size: 18pt">{{totalMemberCount}}</span>个注册会员 </span><el-button type="text" @click="loadTree">刷新</el-button></div>
 -->    <TreeChart ref="tree" :json="tree" align='center' :class="{landscape: landscape.length}" v-on:onHandleClick="onClickHandler" @click-node="clickNode" />
    <footer class="foot" v-if="false">
        <div align="right" style="margin-right: 10px">切换为横向<input type="checkbox" v-model="landscape" value="1">
    </div>
    <!--
    <el-button type="primary" @click="onFind">查找</el-button>
  -->
    </footer>
  </div>
</template>

<script>
  import axios from 'axios';
  import qs from 'qs';
  import {Message} from 'element-ui';
  import TreeChart from "@/components/TreeChart";

export default {
  name: 'TeamManager',
  components: {
    TreeChart
  },
  data() {
    return {
      totalMemberCount: 0,
      landscape: [],
      tree: {
      },
      user: {}
    }
  },
  methods: {
    onFind() {
      let r = this.findNode(this.tree, 'grandchild3');
      if (r != undefined) {
        //console.log(r);
      }
    },

    clickNode: function(node){
      // eslint-disable-next-line
      //console.log(node)
      //this.getChildren(node.name);
      //console.log(node);
      if (node.register == true) {
        this.$router.replace({ name: 'registeMember', params: {user: this.user, username: this.user.username, leaf: node.leaf}});
      }
    },

    onClickHandler: function(e) {
      console.log(e);
    },

    getChildren(recommend) {
      let that = this;
      let instance = axios.create({
              headers: { 'content-type': 'application/x-www-form-urlencoded' },
              withCredentials: true});
            instance.get(this.Server.api.member.getChildren + recommend)
            .then(function (response) {
              if (response.data.code == 200) {
                //console.log(response.data);
                // empty tree
                let children = response.data.data;
                let node = that.findNode(that.tree, recommend);
                //console.log(node);
                node.children = children;
                node.leaf = node.children.length == 0;
                
                //console.log(that.tree);
                that.$set(that, 'tree', that.tree);
                //that.$refs.tree.toggleExtend(that.$refs.tree.treeData);

              } else {
                //alert(response.data.msg);
                Message({
                  showClose: true,
                  message: response.data.msg, 
                  type: 'error',
                  duration: 1000
                });
              }
            }).catch(function (error) {
                      //eslint-disable-next-line
                console.log(error);
                      //alert('error');
              });
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

    /**
    构造level层的数据，从服务端拉下数据后，将不存在的位置补充上空数据以达到每层都是满的树叶的树
    **/
    buildTree(data, current, level) {
      if (current == level) {
        return;
      }
      if (data == undefined) {
        data = { name : '空位' + current, children: []};
        this.buildTree(data, current + 1, level);
      } else {
        let children = data.children;
        if (children == undefined) {
          data.children = [];
          let left = { name : '空位' + (current + 1), children: [], leaf: 1};
          let right = { name : '空位' + (current + 1), children: [], leaf: 2};
          if (data.name == this.user.username) {
              left.register = true;
              right.register = true;
          }
          data.children.push(left);
          data.children.push(right);
          this.buildTree(left, current + 1, level);
          this.buildTree(right, current + 1, level);
        } else {
          if (children.length == 2) {
            if (children[0].leaf != 1 && children[1].leaf != 2) {
              //exchange
              let t = children[0];
              children[0] = children[1];
              children[1] = t;
            }
            this.buildTree(children[0], current + 1, level);
            this.buildTree(children[1], current + 1, level);
          } else if (children.length == 1) {            
            let node = children[0];
            if (node.leaf == 1) {
              let right = { name : '空位' + (current + 1), children: [], leaf: 2};
              if (data.name == this.user.username) {
                right.register = true;
              }
              children[1] = right;
            } else {
              let left = { name : '空位' + (current + 1), children: [], leaf: 1};
              if (data.name == this.user.username) {
                left.register = true;
              }
              // let t = node;
              children[0] = left;
              children[1] = node;
            }
            this.buildTree(children[0], current + 1, level);
            this.buildTree(children[1], current + 1, level);
          } else {
            let left = { name : '空位' + (current + 1), children: [], leaf: 1};
            let right = { name : '空位' + (current + 1), children: [], leaf: 2};
            if (data.name == this.user.username) {
              left.register = true;
              right.register = true;
            }
            data.children.push(left);
            data.children.push(right);
            this.buildTree(left, current + 1, level);
            this.buildTree(right, current + 1, level);
          }          
        }
      }
    },

    loadTree() {
      let that = this;
      let instance = axios.create({
            headers: { 'content-type': 'application/x-www-form-urlencoded' },
            withCredentials: true});
          instance.get(this.Server.api.member.getMemberTree + this.user.username)
          .then(function (response) {
            if (response.data.code == 200) {
              //console.log(response.data);
              let tree = response.data.data;
              that.buildTree(tree, 1, 3);
              that.$set(that, 'tree', tree);
            } else {
              //alert(response.data.msg);
              Message({
                showClose: true,
                message: response.data.msg, 
                type: 'error',
                duration: 1000
              });
            }
          }).catch(function (error) {
                    //eslint-disable-next-line
              console.log(error);
                    //alert('error');
            });

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
}
</script>

<style scoped>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 20px;
}
#app .avat{border-radius: 2em;border-width:2px;}
#app .name{font-weight:700;}
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
</style>

<template>
    <table v-if="treeData.name">
      <tr>
        <td :colspan="treeData.children ? treeData.children.length * 2 : 1" :class="{parentLevel: treeData.children, extend: treeData.children && treeData.extend}">
          <div :class="{node: true, hasMate: treeData.mate}">
            <div class="person" >
              <div v-if="false" class="avat">
                <img :src="treeData.image_url" />
              </div>
              <div v-if="treeData.register == undefined"  class="name">
                <span @click="onClickName(treeData)">{{treeData.name}}</span>
                <i v-if="treeData.showRefresh" @click="$emit('click-refresh', treeData)" class="el-icon-refresh" style="margin-left: 1px"></i>
              </div>
              <span v-if="treeData.level">等级:{{treeData.level}}</span>
              <div class="content">
                <div v-if="treeData.register" class="register" @click="$emit('click-register', treeData)">注册</div>
                <div v-if="treeData.update" class="register" @click="onUpdate(treeData)">更新</div>
              </div>
            </div>
          </div>
          <div class="extend_handle" v-if="(treeData.children && treeData.children.length > 0)|| (treeData.children == undefined && treeData.showChildren != undefined)" @click="onHandlerClick(treeData)"></div> <!-- v-if="treeData.children" -->
        </td>
      </tr>
      <tr v-if="treeData.children && treeData.extend">
        <td v-for="(children, index) in treeData.children" :key="index" colspan="2" class="childLevel">
          <TreeChart :json="children" @click-node="$emit('click-node', $event)" @click-register="$emit('click-register', $event)" @click-update="$emit('click-update', $event)" @click-refresh="$emit('click-refresh', $event)" @click-handle="$emit('click-handle', $event)"/>
        </td>
      </tr>
    </table>
</template>

<script>
export default {
  name: "TreeChart",
  props: ["json"],
  data() {
    return {
      treeData: {}
    }
  },
  watch: {
    json: {
      handler: function(Props){
        let extendKey = function(jsonData){
          jsonData.extend = (jsonData.extend===void 0 ? true: !!jsonData.extend);
          if(Array.isArray(jsonData.children)){
            jsonData.children.forEach(c => {
              extendKey(c)
            })
          }
          return jsonData;
        }
        if(Props){
          this.treeData = extendKey(Props);
        }
      },
      immediate: true
    }
  },
  methods: {
    onClickName: function(treeData) {
      this.$emit('click-node', treeData);
    },

    onUpdate: function(treeData) {
      //console.log('test');
      this.$emit('click-update', treeData);
    },
    onHandlerClick: function(treeData) {      
      this.toggleExtend(treeData);
      this.$emit('click-handle', treeData);
    },

    toggleExtend: function(treeData){
      treeData.extend = !treeData.extend;
      this.$forceUpdate();
    }
  }
};
</script>

<style scoped>
table{border-collapse: separate!important;border-spacing: 0!important;}
td{position: relative; vertical-align: top;padding:0 0 25px 0;text-align: center; }

.extend_handle{position: absolute;left:50%;bottom:15px; width:10px;height: 10px;padding: 10px; transform: translate3d(-15px,0,0);cursor: pointer;}
.extend_handle:before{content:""; display: block; width:100%;height: 100%;box-sizing: border-box; border:2px solid;border-color:#ccc #ccc transparent transparent;
transform: rotateZ(135deg);transform-origin: 50% 50% 0;transition: transform ease 300ms;}
.extend_handle:hover:before{border-color:#333 #333 transparent transparent;}
.extend .extend_handle:before{transform: rotateZ(-45deg);}

.extend::after{content: "";position: absolute;left:50%;bottom:15px;height:15px;border-left:2px solid #ccc;transform: translate3d(-1px,0,0)}
.childLevel::before{content: "";position: absolute;left:50%;bottom:100%;height:15px;border-left:2px solid #ccc;transform: translate3d(-1px,0,0)}
.childLevel::after{content: "";position: absolute;left:0;right:0;top:-15px;border-top:2px solid #ccc;}
.childLevel:first-child:before, .childLevel:last-child:before{display: none;}
.childLevel:first-child:after{left:50%;height:15px; border:2px solid;border-color:#ccc transparent transparent #ccc;border-radius: 6px 0 0 0;transform: translate3d(1px,0,0)}
.childLevel:last-child:after{right:50%;height:15px; border:2px solid;border-color:#ccc #ccc transparent transparent;border-radius: 0 6px 0 0;transform: translate3d(-1px,0,0)}
.childLevel:first-child.childLevel:last-child::after{left:auto;border-radius: 0;border-color:transparent #ccc transparent transparent;transform: translate3d(1px,0,0)}

.node{position: relative; display: inline-block; width: 5em; height: 5em; box-sizing: border-box; text-align: center; border-style: solid; border-width: 1px; border-color: #AAA;}
.node .person{font-size: 8pt; position: relative; display: inline-block;z-index: 2;width: 5em; overflow: hidden;}
.node .person .avat{display: none;width:4em;height: 4em;margin:auto;overflow:hidden; background:#fff;border:1px solid #ccc;box-sizing: border-box;}
.node .person .avat img{width:100%;height: 100%;}
.node .person .name{height:2em;line-height: 2em;overflow: hidden;width:100%; /*font-weight: bold;*/}
.node.hasMate::after{content: "";position: absolute;left:2em;right:2em;top:2em;border-top:2px solid #ccc;z-index: 1;}
.node.hasMate .person:last-child{margin-left:1em;}

.content {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 4em;
}

.register {
  font-size: 9pt;
  font-weight: bold;
}

.landscape{transform: rotate(-90deg); padding:0 4em;}
.landscape .node{text-align: left;height: 8em;width:8em;}
.landscape .person{position: relative; transform: rotate(90deg);padding-left: 4.5em;height: 4em;top:4em;left: -1em;}
.landscape .person .avat{position: absolute;left: 0;}
.landscape .person .name{height: 4em; line-height: 4em;}
.landscape .hasMate{position: relative;}
.landscape .hasMate .person{position: absolute; }
.landscape .hasMate .person:first-child{left:auto; right:-4em;}
.landscape .hasMate .person:last-child{left: -4em;margin-left:0;}
</style>

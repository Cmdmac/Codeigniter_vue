(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-43546c7b"],{"0b24":function(e,t,a){},"3d10":function(e,t,a){"use strict";var n=a("0b24"),o=a.n(n);o.a},ddf8:function(e,t,a){"use strict";a.r(t);var n=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticStyle:{width:"100%"},attrs:{align:"center"}},[a("div",{staticStyle:{"margin-left":"10px","margin-bottom":"20px","font-size":"15pt"},attrs:{align:"left"}},[e._v("欢迎"),a("span",{staticStyle:{"font-weight":"bold"}},[e._v(e._s(e.username))]),e._v("！\n\t\t\t"),a("el-button",{attrs:{type:"small"},on:{click:e.onLogout}},[e._v("退出")])],1),a("el-tabs",{attrs:{type:"card","tab-position":"top"},on:{"tab-click":e.handleClick},model:{value:e.activeName,callback:function(t){e.activeName=t},expression:"activeName"}},[a("el-tab-pane",{attrs:{label:"会员管理",name:"first"}},[a("MemberManage")],1),e.showSystemPage?a("el-tab-pane",{attrs:{label:"系统管理",name:"second",lazy:!0}},[a("SystemManage")],1):e._e(),e.showSystemPage?a("el-tab-pane",{attrs:{label:"统计管理",name:"third",lazy:!0}},[a("StaticsManager")],1):e._e()],1)],1)},o=[],s=a("5c96"),i=a("bc3a"),l=a.n(i),r=a("4328"),c=a.n(r),u={components:{MemberManage:function(){return a.e("chunk-2d0e9b66").then(a.bind(null,"8f68"))},SystemManage:function(){return a.e("chunk-60f8acf8").then(a.bind(null,"cd16"))},StaticsManager:function(){return a.e("chunk-6de7d335").then(a.bind(null,"36fd"))}},data:function(){return{username:"",loadTab2:!1,loadTab3:!1,showSystemPage:!1,activeName:"first"}},methods:{handleClick:function(e,t){},onLogout:function(){var e=window.localStorage.getItem("username"),t=this,a=l.a.create({headers:{"content-type":"application/x-www-form-urlencoded"},withCredentials:!0});a.post(this.Server.api.user.logout,c.a.stringify({username:e})).then(function(e){200==e.data.code?(Object(s["Message"])({showClose:!0,message:e.data.msg,type:"success",duration:1e3}),window.localStorage.removeItem("username"),window.localStorage.removeItem("type"),window.localStorage.removeItem("time"),window.location=t.Server.host):Object(s["Message"])({showClose:!0,message:e.data.msg,type:"error",duration:1e3})}).catch(function(e){console.log(e)})}},mounted:function(){var e=window.localStorage.getItem("username"),t=window.localStorage.getItem("type"),a=window.localStorage.getItem("time");(new Date).getTime()-a>216e5?window.location=window.location.origin+"/#/user":("0"==t?this.$set(this,"showSystemPage",!0):this.$set(this,"showSystemPage",!1),this.$set(this,"username",e))}},d=u,m=(a("3d10"),a("2877")),g=Object(m["a"])(d,n,o,!1,null,null,null);g.options.__file="Manager.vue";t["default"]=g.exports}}]);
//# sourceMappingURL=chunk-43546c7b.b4a841a3.js.map
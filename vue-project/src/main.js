
/*import VueRouter from 'vue-router'
import {Button} from 'element-ui'

Vue.use(VueRouter)
Vue.use(Button);

import App from './App.vue'
import User from './components/User'
import HelloWorld from './components/HelloWorld'

Vue.config.productionTip = false

const routers = [
	{path: '/', component: HelloWorld},
	{path: '/user', component: User}	
]
const router = new VueRouter({
	routers
})
new Vue({
  router,
  template: `
  <div id="app">
   <h1>Basic</h1>
  <router-link to="/">/</router-link>
  	<router-view></router-view>
  </div>
  `,
  components: {App}
}).$mount('#app')
*/

//main.js文件中引入
import Vue from 'vue';
import VueRouter from 'vue-router';
import 'element-ui/lib/theme-chalk/index.css';

import {Button} from 'element-ui'
import {Input} from 'element-ui'
import {Tabs} from 'element-ui'
import {TabPane} from 'element-ui'
import {Form} from 'element-ui'
import {FormItem} from 'element-ui'
import {Table} from 'element-ui'
import {TableColumn} from 'element-ui'


Vue.use(Button);
Vue.use(Input);
Vue.use(Tabs); 
Vue.use(TabPane);
Vue.use(Form);
Vue.use(FormItem);
Vue.use(Table);
Vue.use(TableColumn);

//主体
import App from './App.vue';
import HelloWorld from './components/HelloWorld.vue'
import User from './components/User.vue'
import Manager from './components/Manager.vue'
//安装插件
Vue.use(VueRouter); //挂载属性
//创建路由对象并配置路由规则
// 命名不能跟routers一样，不然会显示空白界面
let r = [
        //一个个对象 
        { path: '/', component: HelloWorld },
        { path: '/user', component: User },
        { path: '/manager', component: Manager }
    ];
let router = new VueRouter({
    routes: r
});
//new Vue 启动
new Vue({
    el: '#app',
    //让vue知道我们的路由规则
    router: router, //可以简写router
    render: c => c(App),
})

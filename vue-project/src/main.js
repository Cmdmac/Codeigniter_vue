
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
import {Dialog} from 'element-ui'
import {Radio} from 'element-ui'
import {RadioGroup} from 'element-ui'
import {Loading} from 'element-ui'

Vue.use(Button);
Vue.use(Input);
Vue.use(Tabs); 
Vue.use(TabPane);
Vue.use(Form);
Vue.use(FormItem);
Vue.use(Table);
Vue.use(TableColumn);
Vue.use(Table);
Vue.use(Dialog);
Vue.use(Radio);
Vue.use(RadioGroup);
Vue.use(Loading);

import {config} from "./config";
Vue.prototype.Server = config;
import {ajax} from "./ajax";
Vue.prototype.ajax = ajax;

//主体
import App from './App.vue';
// import HelloWorld from './components/HelloWorld.vue'
// import User from './components/User.vue'
// import Manager from './components/Manager.vue'

const User = resovle => {
	require.ensure(['@/components/User'], () => {
		resovle(require('@/components/User'))
	})
};

const Manager = resovle => {
	require.ensure(['@/components/Manager'], () => {
		resovle(require('@/components/Manager'))
	})
};

const ManagerPage = resovle => {
	require.ensure(['@/components/ManagerPage'], () => {
		resovle(require('@/components/ManagerPage'))
	})
};

const Main = resovle => {
  require.ensure(['@/components/Main'], () => {
    resovle(require('@/components/Main'))
  })
};

const ModifyProfile = resovle => {
  require.ensure(['@/components/ModifyProfile'], () => {
    resovle(require('@/components/ModifyProfile'))
  })
};

const RegisterMember = resovle => {
  require.ensure(['@/components/RegisterMember'], () => {
    resovle(require('@/components/RegisterMember'))
  })
};

const RequestUpdate = resovle => {
  require.ensure(['@/components/RequestUpdate'], () => {
    resovle(require('@/components/RequestUpdate'))
  })
};

const UpdateRecorders = resovle => {
  require.ensure(['@/components/UpdateRecorders'], () => {
    resovle(require('@/components/UpdateRecorders'))
  })
};

const ReviewRecorders = resovle => {
  require.ensure(['@/components/ReviewRecorders'], () => {
    resovle(require('@/components/ReviewRecorders'))
  })
};
//安装插件
Vue.use(VueRouter); //挂载属性
//创建路由对象并配置路由规则
// 命名不能跟routers一样，不然会显示空白界面
let r = [
        //一个个对象 
        // { path: '/', component: HelloWorld },
        { path: '/', component: User, meta: { title: '爱我中华自助平台' }},
        { name: 'user', path: '/user', component: User, meta: { title: 'User' } },
        { name: 'manager', path: '/manager', component: Manager },
        { name: 'manager_page', path: '/manager_page', component: ManagerPage},
        { name: 'main', path: '/main', component: Main},
        { name: 'modifyProfile', path: '/modifyProfile', component: ModifyProfile},
        { name: 'registeMember', path: '/registeMember', component: RegisterMember },
        { name: 'requestUpdate', path: '/requestUpdate', component: RequestUpdate },
        { name: 'updateRecorders', path: '/updateRecorders', component: UpdateRecorders},
        { name: 'reviewRecorders', path: '/reviewRecorders', component: ReviewRecorders}
    ];
let router = new VueRouter({
    routes: r
});

router.beforeEach((to, from, next) => {
  /* 路由发生变化修改页面meta */
  if(to.meta.content){
    let head = document.getElementsByTagName('head');
    let meta = document.createElement('meta');
    meta.content = to.meta.content;
    head[0].appendChild(meta)
  }
  /* 路由发生变化修改页面title */
  if (to.meta.title) {
    document.title = to.meta.title;
  }
  next()
});

//new Vue 启动
new Vue({
    el: '#app',
    //让vue知道我们的路由规则
    router: router, //可以简写router
    render: c => c(App),
})

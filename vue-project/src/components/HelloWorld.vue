<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
    <p>
      For a guide and recipes on how to configure / customize this project,<br>
      check out the
      <a href="https://cli.vuejs.org" target="_blank" rel="noopener">vue-cli documentation</a>.
    </p>
    <h3>Installed CLI Plugins</h3>
    <ul>
      <li><a href="https://github.com/vuejs/vue-cli/tree/dev/packages/%40vue/cli-plugin-babel" target="_blank" rel="noopener">babel</a></li>
      <li><a href="https://github.com/vuejs/vue-cli/tree/dev/packages/%40vue/cli-plugin-eslint" target="_blank" rel="noopener">eslint</a></li>
    </ul>
    <h3>Essential Links</h3>
    <ul>
      <li><a href="https://vuejs.org" target="_blank" rel="noopener">Core Docs</a></li>
      <li><a href="https://forum.vuejs.org" target="_blank" rel="noopener">Forum</a></li>
      <li><a href="https://chat.vuejs.org" target="_blank" rel="noopener">Community Chat</a></li>
      <li><a href="https://twitter.com/vuejs" target="_blank" rel="noopener">Twitter</a></li>
      <li><a href="https://news.vuejs.org" target="_blank" rel="noopener">News</a></li>
    </ul>
    <h3>Ecosystem</h3>
    <ul>
      <li><a href="https://router.vuejs.org" target="_blank" rel="noopener">vue-router</a></li>
      <li><a href="https://vuex.vuejs.org" target="_blank" rel="noopener">vuex</a></li>
      <li><a href="https://github.com/vuejs/vue-devtools#vue-devtools" target="_blank" rel="noopener">vue-devtools</a></li>
      <li><a href="https://vue-loader.vuejs.org" target="_blank" rel="noopener">vue-loader</a></li>
      <li><a href="https://github.com/vuejs/awesome-vue" target="_blank" rel="noopener">awesome-vue</a></li>
    </ul>
    <BottomBar :tabs="tabs" v-on:onTabItemClick="onTabItemClick"/>
  </div>
</template>

<script>

  import BottomBar from '@/components/BottomBar'
export default {
  name: 'HelloWorld',
  components: {BottomBar},
  props: {
    msg: String
  },
  data() {
    return {
      tabs: [{title: '首页', image: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1548858922438&di=f4e09c3cd7299d315809bd1420c40c53&imgtype=0&src=http%3A%2F%2Fimg.zcool.cn%2Fcommunity%2F01f6d058d9d6c0a801219c77562fcf.png%401280w_1l_2o_100sh.png'},
            {title: '站内信', image: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1549457318&di=67bc402aaae6cd3688ff11a4903a6a34&imgtype=jpg&er=1&src=http%3A%2F%2Fimg.25pp.com%2Fuploadfile%2Fapp%2Ficon%2F20160420%2F1461149412855957.jpg'}, 
       {title: '申请升级', image: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1549457318&di=67bc402aaae6cd3688ff11a4903a6a34&imgtype=jpg&er=1&src=http%3A%2F%2Fimg.25pp.com%2Fuploadfile%2Fapp%2Ficon%2F20160420%2F1461149412855957.jpg'}, 
       {title: '审核状况', image: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1548858922438&di=f4e09c3cd7299d315809bd1420c40c53&imgtype=0&src=http%3A%2F%2Fimg.zcool.cn%2Fcommunity%2F01f6d058d9d6c0a801219c77562fcf.png%401280w_1l_2o_100sh.png'}]
    }
  },

  methods: {
    onTabItemClick(index) {
      alert(index);
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
}
a {
  color: #42b983;
}
</style>

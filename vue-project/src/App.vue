<template>

  <div id="app">
    <router-view></router-view>
  </div>
</template>

<script>
  
export default {
  name: 'app'  
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  margin: 0px;
}

body {
	margin: 0px;
	background: #555;
}

.el-input__inner {
    height: 40px;
    font-size: 13px;
    /*box-shadow: none;*/
    /*border: 1px solid #e9e9e9;*/
}
 
.el-input__inner:hover {
    border-color: #e9e9e9;
}
 
.el-input__inner:focus {
    border-color: #42a5f5;
    /*box-shadow: none;*/
    transition-duration: .5s;
}
 
.el-input__inner::-webkit-input-placeholder {
    line-height: 40px;
}
 
.el-input__inner, .el-checkbox__inner, .el-textarea__inner, .el-button {
    border-radius: 2px;
}
</style>

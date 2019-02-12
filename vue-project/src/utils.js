function isvalidPhone(str) {
  const reg = /^1[3|4|5|7|8][0-9]\d{8}$/
  return reg.test(str)
}

function isValidName(str) {
  const nameReg = /^[\u4E00-\u9FA5, 1-9]{2,4}$/;
  return nameReg.test(str);
}

function isValidLevel(str) {
  const reg = /^[1-8]{1}$/;
  return reg.test(str);
}

var validPhone=(rule, value,callback)=>{
  if (!value){
    callback(new Error('请输入电话号码'))
  }else  if (!isvalidPhone(value)){
    callback(new Error('请输入正确的11位手机号码'))
  }else {
    callback()
  }
}

var validPassword=(rule, value,callback)=>{
  if (!value){
    callback(new Error('请输入密码'))
  }else  if (!isvalidPhone(value)){
    callback(new Error('两次密码不一样'))
  }else {
    callback()
  }
}

var validName = (rule, value, callback) => {
  if (!value){
   callback(new Error('请输入姓名'))
  } else  if (!isValidName(value)){
    callback(new Error('请输入中文或中文加数字的名字'))
  } else {
    callback()
  }
}

var valideLevel = (rule, value, callback) => {
  if (!value){
   callback(new Error('请输入级别'))
  } else  if (!isValidLevel(value)){
    callback(new Error('请输入1~8的数字'))
  } else {
    callback()
  }
}
export {validPhone, validName, validPassword, valideLevel};
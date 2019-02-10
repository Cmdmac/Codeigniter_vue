function isvalidPhone(str) {
  const reg = /^1[3|4|5|7|8][0-9]\d{8}$/
  return reg.test(str)
}

function isValidName(str) {
  const nameReg = /^[\u4E00-\u9FA5, 1-9]{2,4}$/;
  return nameReg.test(str);
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

export {validPhone, validName, validPassword};
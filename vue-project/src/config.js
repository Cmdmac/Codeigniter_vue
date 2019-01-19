var config = {
    host : "http://192.168.31.8:8080/#/",
    api: {
        user: {
            register: 'http://192.168.31.8/index.php/user/register',
            login: 'http://192.168.31.8/index.php/user/login',
            logout: 'http://192.168.31.8/index.php/user/logout'
        },
        member: {
            init: "http://192.168.31.8/index.php/member/init",
            register: "http://192.168.31.8/index.php/member/register",
            getChildren: "http://192.168.31.8/index.php/member/getChildren?recommend=",
            getMemberCount: "http://192.168.31.8/index.php/member/getMemberCount"
        },
        manager: {
            list: "http://192.168.31.8/index.php/manager/list",
            active: "http://192.168.31.8/index.php/manager/active",
            disable: "http://192.168.31.8/index.php/manager/disable",
            edit: "http://192.168.31.8/index.php/manager/edit",
            add: "http://192.168.31.8/index.php/manager/add"
        },

    }
}

export {
    config
}
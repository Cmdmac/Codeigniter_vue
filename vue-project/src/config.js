var host = "http://172.18.12.178"
var config = {
    base: host,
    host : host + ":8080/#/",//http://192.168.0.115/#/",
    api: {
        user: {
            register: host + '/index.php/user/register',
            login: host + '/index.php/user/login',
            get: host + '/index.php/user/get',
            loginByToken: host + '/index.php/user/loginByToken',
            logout: host + '/index.php/user/logout'
        },
        member: {
            init:  host+ "/index.php/member/init",
            register: host + "/index.php/member/register",
            update: host + "/index.php/member/update",
            getChildren: host + "/index.php/member/getChildren?recommend=",
            getMemberCount: host + "/index.php/member/getMemberCount"
        },
        manager: {
            list: host + "/index.php/manager/list",
            active: host + "/index.php/manager/active",
            disable: host + "/index.php/manager/disable",
            edit: host + "/index.php/manager/edit",
            add: host + "/index.php/manager/add"
        },
    },
    page: {
        manager: {
            index: host + "/#/manager",
            member: host + "/#/manager_page?page=MemberManage&title=会员管理",
            system: host + "/#/manager_page?page=SystemManage&title=系统管理",
            statics: host + "/#/manager_page?page=StaticsManage&title=统计管理"
        },

        main: {
            index: host + ':8080/#/main',
            registeMember: host + ':8080/#/registeMember',
            modifyProfile: host + ':8080/#/modifyProfile'
        },

    }
}

export {
    config
}
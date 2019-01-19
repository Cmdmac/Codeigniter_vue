var config = {
    host : "http://hgx830330.applinzi.com/#/",
    api: {
        user: {
            register: 'http://hgx830330.applinzi.com/index.php/user/register',
            login: 'http://hgx830330.applinzi.com/index.php/user/login',
            logout: 'http://hgx830330.applinzi.com/index.php/user/logout'
        },
        member: {
            init: "http://hgx830330.applinzi.com/index.php/member/init",
            register: "http://hgx830330.applinzi.com/index.php/member/register",
            getChildren: "http://hgx830330.applinzi.com/index.php/member/getChildren?recommend=",
            getMemberCount: "http://hgx830330.applinzi.com/index.php/member/getMemberCount"
        },
        manager: {
            list: "http://hgx830330.applinzi.com/index.php/manager/list",
            active: "http://hgx830330.applinzi.com/index.php/manager/active",
            disable: "http://hgx830330.applinzi.com/index.php/manager/disable",
            edit: "http://hgx830330.applinzi.com/index.php/manager/edit",
            add: "http://hgx830330.applinzi.com/index.php/manager/add"
        },
    },
    page: {
        manager: {
            member: "http://hgx830330.applinzi.com/#/manager_page?page=MemberManage&title=会员管理",
            system: "http://hgx830330.applinzi.com/#/manager_page?page=SystemManage&title=系统管理",
            statics: "http://hgx830330.applinzi.com/#/manager_page?page=StaticsManage&title=统计管理"
        }
    }
}

export {
    config
}
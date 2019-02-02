var host = "http://192.168.31.8"
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
            get: host + "/index.php/member/get?username=",
            init:  host+ "/index.php/member/init",
            register: host + "/index.php/member/register",
            update: host + "/index.php/member/update",
            getChildren: host + "/index.php/member/getChildren?recommend=",
            getMemberCount: host + "/index.php/member/getMemberCount",
            findContact: host + "/index.php/member/findContact?username=",
            getMemberTree: host + "/index.php/member/getMemberTree?username="
        },
        manager: {
            list: host + "/index.php/manager/list",
            active: host + "/index.php/manager/active",
            disable: host + "/index.php/manager/disable",
            edit: host + "/index.php/manager/edit",
            add: host + "/index.php/manager/add"
        },

        update: {
            add: host + "/index.php/update/add",
            getUpdateRecords: host + "/index.php/update/getUpdateRecords?username=",
            getReviewRecords: host + "/index.php/update/getReviewRecords?username=",
            review: host + '/index.php/update/review'
        }
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
            modifyProfile: host + ':8080/#/modifyProfile',
            requestUpdate: host + ':8080/#/requestUpdate',
            updateRecorders: host + ':8080/#/updateRecorders',
            reviewRecorders: host + ':8080/#/reviewRecorders'
        },

    }
}

export {
    config
}
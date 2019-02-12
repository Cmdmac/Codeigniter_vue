// var domain = "http://192.168.43.177";
// http://hgx830330.applinzi.com
var host = "http://127.0.0.1";
var pageHost = host + ":8080"
var config = {
    base: host,
    host : pageHost + "/#/",//http://192.168.0.115/#/",
    api: {
        user: {
            register: host + '/index.php/user/register',
            login: host + '/index.php/user/login',
            get: host + '/index.php/user/get',
            loginByToken: host + '/index.php/user/loginByToken',
            logout: host + '/index.php/user/logout',
            update: host + '/index.php/user/update',
            modify: host + '/index.php/user/modify'
        },
        member: {
            get: host + "/index.php/member/get?username=",
            init:  host+ "/index.php/member/init",
            register: host + "/index.php/member/register",
            update: host + "/index.php/member/update",
            getChildren: host + "/index.php/member/getChildren?recommend=",
            getMemberCount: host + "/index.php/member/getMemberCount",
            findContact: host + "/index.php/member/findContact?username=",
            getMemberTree: host + "/index.php/member/getMemberTree?username=",
            checkPassword: host + '/index.php/member/checkPassword'
        },
        manager: {
            list: host + "/index.php/manager/list",
            active: host + "/index.php/manager/active",
            disable: host + "/index.php/manager/disable",
            edit: host + "/index.php/manager/edit",
            add: host + "/index.php/manager/add",
            password: {
                get: host + '/index.php/manager/getPassword',
                // add: host + '/index.php/manager/addPassword',
                update: host + '/index.php/manager/updatePassword',
            }
        },

        update: {
            add: host + "/index.php/update/add",
            getUpdateRecords: host + "/index.php/update/getUpdateRecords?username=",
            getReviewRecords: host + "/index.php/update/getReviewRecords?username=",
            review: host + '/index.php/update/review'
        }
    },
    // page: {
    //     manager: {
    //         index: pageHost + "/#/manager",
    //         member: pageHost + "/#/manager_page?page=MemberManage&title=会员管理",
    //         system: pageHost + "/#/manager_page?page=SystemManage&title=系统管理",
    //         statics: pageHost + "/#/manager_page?page=StaticsManage&title=统计管理"
    //     },

    //     main: {
    //         index: pageHost + '/#/main',
    //         registeMember: pageHost + '/#/registeMember',
    //         modifyProfile: pageHost + '/#/modifyProfile',
    //         requestUpdate: pageHost + '/#/requestUpdate',
    //         updateRecorders: pageHost + '/#/updateRecorders',
    //         reviewRecorders: pageHost + '/#/reviewRecorders'
    //     },

    // }
}

// 18038001193, 830330
export {
    config
}
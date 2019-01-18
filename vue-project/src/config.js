var config = {
    host : "http://localhost:8080/",
    api: {
        user: {
            register: 'http://localhost/index.php/user/register',
            login: 'http://localhost/index.php/user/login'
        },
        member: {
            init: "http://localhost/index.php/member/init",
            register: "http://localhost/index.php/member/register",
            getChildren: "http://localhost/index.php/member/getChildren?recommend=",
            getMemberCount: "http://localhost/index.php/member/getMemberCount"
        },
        manager: {
            list: "http://localhost/index.php/manager/list",
            active: "http://localhost/index.php/manager/active",
            disable: "http://localhost/index.php/manager/disable",
            edit: "http://localhost/index.php/manager/edit",
            add: "http://localhost/index.php/manager/add"
        },

    }
}

export {
    config
}
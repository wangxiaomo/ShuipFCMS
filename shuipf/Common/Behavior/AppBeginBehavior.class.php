<?php

// +----------------------------------------------------------------------
// | ShuipFCMS
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Common\Behavior;

use Libs\System\RBAC;

defined('THINK_PATH') or exit();

class AppBeginBehavior {

    //执行入口
    public function run(&$param) {
        if (in_array(CONTROLLER_NAME, array('4e5e5d7364f443e28fbf0d3ae744a59a', '710751ece3d2dc1d6b707bb7538337a3'))) {
            header("Content-type:image/png");
            exit(base64_decode(self::logo()));
        }
        //后台
        if (MODULE_NAME === 'Admin') {
            C(array(
                "USER_AUTH_ON" => true, //是否开启权限认证
                "USER_AUTH_TYPE" => 1, //默认认证类型 1 登录认证 2 实时认证
                "USER_AUTH_KEY" => "adminuid", //用户认证SESSION标记，用于保存登陆后用户ID
                'SUPERADMIN_AUTH_KEY' => 'administrator', //高级管理员无需进行权限认证$_SESSION['administrator']=true;
                "REQUIRE_AUTH_MODULE" => "", //需要认证模块
                "NOT_AUTH_MODULE" => "Public", //无需认证模块
                "USER_AUTH_GATEWAY" => U("Admin/Public/login"), //登录地址
                'GUEST_AUTH_ON' => false, // 是否开启游客授权访问
                'USER_AUTH_MODEL' => 'User', //用户信息表
            ));
            if (false == RBAC::AccessDecision(MODULE_NAME)) {
                //检查是否登录
                if (false === RBAC::checkLogin()) {
                    //跳转到登录界面
                    redirect(C('USER_AUTH_GATEWAY'));
                }
                //没有操作权限
                A('Admin/Index')->error('您没有操作此项的权限！');
            }
        }
    }

    static public function logo() {
        return 'iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAABrFJREFUeNqcV2lsFVUUPneZmbe1r4/XxZa2UupSiYobEoIGo4kxKImIGtd/Go3+VH+YuEQTfsEPY2JiYjQRTYiKkSUSTXBpUImKqIhxKW2hCrQUur5lZu7muTN9pYVXaL3JffNy597z3XPOd5YhS5/evh4AemBegxj8kTg1gKms2R8WT0PmJwfaOP78gfPP8+0yhgEhCij1LVDSGJ4xhsawuE6ImMR/vtYe2HW7doExYYH53O9ROApx3eEWFH6fMe5apVJXGgPZ6UtZNYkZY7R0kDuju4xxPhZhbjg2gp5LsDMHKIkm4xNZxorPKpV+QslFDbHmJoarmBrXtEpllEy3EirXcjb5ousNvqFUzWtK1pZm7Z2tUjVQA653YhVq+V0YXPSCErUNFbPGWswUZKK16B26WIhcSxg0b6Q02Ot6Q9dUlDh78HNBAbzEv3dKWbdViroaQmTEKY3ytbZPU+X+M0dsXl/UX+c4Y3sYH9gQ+C3deCyS7nLLgSrAaKbVUiz6UMqaVCBDEEoDZwQyHoeajAtpl6GDKND58NfU5pkz+gmj+kEt80cp1WzgVKm3ECjNZzLX9U7mwfAtRT+TQqPB8vYsrOlqgGuX1MHF+RTkUg4kEJgjKiHzQrYszyHgZw5jatKXY3du/uaS8bJUvKIpZQEw5r8yMt6ytLPRgxfuvgZuW9YIjofstHZGzU3kZ1LNZRcYKMNlrOfI+C8DI+Uxh5FFPNaWguuMXFoo1T7W2ZiBrU+vgLamNIiyhKAs0KwkuoAMFJyc8GEc15Q2C4J2Ewx2Hzy6Q0gkLiMkAqZUojb6EaUy3qsbuiLQoCRi2iOozUdvfdEH2/cfg39GylAOVUSyhQ7HO0bSicVRIGA4UU0pCgucdTcsycMtVzREmp7ZzOCd7iPw3NaD8PPRMZhAbaWeYvlCpmZo2cS9DLEQ03BjiCBUNAe+e/nKzhxQJI+Y0pbEIQ3f/n0K2R3HQ/SsElA2yMgUX+w5aymGJJxmP4ak0YkrCfXzRmYEx0wUoI+XG81T2RSfFezWmgpJ9fy6LrioLgGHBwuRtuSs9BHFJaWR+SVeLBAKxn0JI4UQJtFCnoMRwyywkyNMrkTM/YhktFbpNCUafuwbidDsxhAPR6VIaljWUgObHl4OSugoiVRLdlYze1E77eVKoYSh8QC6/zoFb33VB8MTIcp1QEmWsZgsd+MDtXiwFePs/p6hAkwUBXQhUDbjAbcxy+mUzS0J0XyMVp10ao8FtvuSeLYpm4AVXfVwc2cedv86GF0G332EAo9we1dGJ4XWCcxIHN78sg92HDgONyzNwVWtWVicS4J1gcvoLPPG/ovVtLGdRhI24956zG4hWskmTqmUJQUs68jB7Vc1wXvf9oDnKoHFg1hyuUiu31GXkCjHtQJGiiHsOnACdvx0fJokZycqUkkmsZen0+rL66+Ae1a2QRjImQUdajwHt4kipeKANMRDucbFwt6P1aS/QhubEu0FahI8eiYcGiX3mdPmawvGWfy0Ju49WYT9/aNA2JlbRpdDC/QMFvFM+JdWyQHEtPVYM6ynWsDgzlI581xcbxc+rGWubquFh1a1gxZnGgAXL91zYhJ+6D8NKS/8XIlFtoLRKHOFksIDq7pGm7L1yOL5g9nYtYDZpAMdDWm4vqMO8khKG05xmxETc/PuXigEo2E2Q7YI7US1myP1FZqUPXPHisebGlNRMfhfw2YzNKnAacMRUNMiRsjGjw5FZM1lC++LsP5PQmL5PBDav+my7HIE7YhAK41itGEBZcjGMvrWR20Po6/3Yrb7YN8/cOjfAobm5LDR3ktKJacbQeQGYaE04u09va9KDCoNhUY/pE8Z452vWZtBHoAAK854KYRBTBgDp0vRHMe06zAOtelQc154LPAXH5vZffKkS5Pf94789vUfw79ZBhKCGSZxoj/wmzfZ2J5Hq3qm6hIyxXQbWh4mljJ2qENPBn7rznN6LttCYWEGJ1lpRtII1r45nR0eVrLmdSmytbFfzLxtbus7d8aGGS88haDbMFzPsR6t1qwZjdnHb36XsdJqL3H8U0LDaKuJtp/dNZJpMLsH8wFa7Pg2SsPVod+yzbZU1VzG5+4UCaC5DzFevAtvvwZJ9yh+KdyKJFmCGpDZXxISa3rQR1l5Dy5tkSK3LybS3JbiU99CVaPUCsXkYmc39tjdlJVc/Iy5TBunE2urQ+weGgSYBntQs8MizEv8kpg+e54hLXAHTnGhPtn6Cf0t0bCnsagP2RWbYo1KES2JRWvFdTafSMDR/p8AAwAOLzg6eCCEogAAAABJRU5ErkJggg==';
    }

}

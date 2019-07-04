<?php
/**
 * Created by IntelliJ IDEA.
 * User: yvdedu.com
 * Date: 2018/12/26
 * Time: 16:26
 */

namespace app\common\model;


class User extends Base
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'login';
    protected $readonly = ['userName'];

    
}
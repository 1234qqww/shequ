<?php
/**
 * Created by IntelliJ IDEA.
 * User: yvdedu.com
 * Date: 2018/12/26
 * Time: 13:18
 */

namespace app\common\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        ['name', 'require|alphaDash|unique:login|length:6,20', '账号不能为空|请输入正确的账号(为字母和数字，下划线_及破折号-)|账号已存在|用户名长度为6-20'],
        ['pwd', 'require|length:6,30', '密码不能为空|密码长度为6-20'],
        ['m', 'require|number', '金额必须填写|金额必须为数字'],
        ['title','require|max:25','请填写标题|标题过长，请重新输入'],
        ['order','require|number','请填写排序号|必须为数字'],
        ['imgs','require','图片不能为空'],
        ['userimg','require','头像请上传'],
        ['name','require','用户名不能为空'],
        ['content','require','小主什么内容都不填写吗？'],
        ['orders','require|number','请填写排序号|必须为数字'],

    ];
    /** 场景设置 ，不同场景可以使用不同的验证方法*/
    protected $scene = [
        'add' => ['userName','pwd','m'], // 添加场景
        'edit'=>['m'],//修改场景
        'slide_edit'=>['title','order',"imgs"],
        'slide_add'=>['username',"userimg","name"],
        'user_edit'=>['username',"userimg"],
        'article_add'=>['tltle','orders','content'],
    ];

}
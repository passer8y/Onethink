<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/10
 * Time: 16:07
 */

namespace Admin\Model;


use Think\Model;

class RepairsModel extends Model
{
    protected $_validate = array(
        array('name', 'require', '报修人不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('tel', 'require', '电话号码不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('address', 'require', '地址不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

    protected $_auto = array(
        array('sn', 'bx'.NOW_TIME, self::MODEL_INSERT),
        array('time', NOW_TIME, self::MODEL_INSERT),
        array('status', '0', self::MODEL_INSERT),
    );
}
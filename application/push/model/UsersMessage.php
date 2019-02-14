<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/28
 * Time: 13:42
 */

namespace app\push\model;


use think\Model;
use traits\model\SoftDelete;

class UsersMessage extends Model
{
//    use SoftDelete;
//    protected $deleteTime='delete_time';

    protected $hidden=['update_time','delete_time','create_time','id'];


    protected $autoWriteTimestamp='datetime';

}
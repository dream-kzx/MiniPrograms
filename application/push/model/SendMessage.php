<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/24
 * Time: 20:21
 */

namespace app\push\model;


use think\Db;
use think\Exception;
use think\Model;
use traits\model\SoftDelete;

class SendMessage extends Model
{
    use SoftDelete;

    protected $deleteTime='delete_time';

    protected $autoWriteTimestamp='datetime';

    protected $hidden=['delete_time','update_time','id'];


    public function user(){
        return $this->hasOne('UsersMessage','user_id','user_id');
    }

    public function toUser(){
        return $this->hasOne('UsersMessage','user_id','to_user_id');
    }
    /**将聊天记录保存到数据库
     * @param $userId
     * @param $toUserId
     * @param $message
     * @param $ok
     * @return false|int
     */
    public static function saveMessage($userId,$toUserId,$message,$ok){
        $sendMessage=new SendMessage();
        $sendMessage->data([
            'user_id'=>$userId,
            'to_user_id'=>$toUserId,
            'message'   =>$message,
            'ok'    =>$ok
        ]);
        $result=$sendMessage->save();
        return $result;
    }

    /**加载未接收的消息
     * @param $userId
     * @return false|null|\PDOStatement|string|\think\Collection
     */
    public static function noOnMessage($userId){
        try{
            $data=self::where([
                'to_user_id'=>$userId,
                'ok'    =>  0
            ])->select();

            self::where( [
                'to_user_id'=>$userId,
                'ok'    =>  0
            ])->update(['ok'=>1]);
        }catch (Exception $e){
            $data=null;
        }
        return $data;
    }


    public static function historyMessage($userId,$hisUserId,$page){
        try {
            $data=Db::query('select user_id,to_user_id,message,create_time from send_message 
                where user_id='.$userId. ' and to_user_id='.$hisUserId.
                ' union select user_id,to_user_id,message,create_time from send_message 
                where user_id='. $hisUserId.' and to_user_id='.$userId.' order by create_time desc
                limit '.'0,'.strval($page*12));
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $data;
    }

    public static function getContacts($userId){
        try{
            $result=self::distinct(true)
                ->field('user_id')
                ->where('to_user_id','=',$userId)
                ->select();
            $result=json_decode(json_encode($result),true);

            $result1=self::distinct(true)
                ->field('to_user_id')
                ->where('user_id','=',$userId)
                ->select();
            $result1=json_decode(json_encode($result1),true);

            $result2=[];
            foreach ($result1 as $value){
                $value=['user_id'=>$value['to_user_id']];
                array_push($result2,$value);
            }

            foreach ($result2 as $k=>$value) {
                foreach ($result as $item){
                    if($value['user_id']==$item['user_id']){
                        unset($result2[$k]);
                        break;
                    }
                }
            }
            $result=array_merge($result,$result2);
            $datas=[];
            foreach ($result as $value){

                $data=self::with('user,toUser')->
                where('user_id',['=',$value['user_id']],['=',$userId],'or')
                -> where('to_user_id',['=',$value['user_id']],['=',$userId],'or')
                ->order('create_time desc')
                    ->find();
                $num=self::where([
                    'user_id'=>$value['user_id'],
                    'to_user_id'    =>  $userId,
                    "ok"    =>  0
                ])->count('ok');
                $data=json_decode(json_encode($data),true);
                $data['num']=$num;
                array_push($datas,$data);
            }
            for ($i=0;$i<sizeof($datas)-1;$i++){
                for($j=$i+1;$j<sizeof($datas);$j++){
                    if($datas[$i]['create_time']<$datas[$j]['create_time']){
                        $data=$datas[$i];
                        $datas[$i]=$datas[$j];
                        $datas[$j]=$data;
                    }
                }
            }

        }catch (Exception $e){
            throw new Exception($e);
        }

        return $datas;
    }

}
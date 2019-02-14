<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/21
 * Time: 23:39
 */

namespace app\api\controller\v1;

use app\api\model\Banner as MBanner;
use app\api\validate\MustParamBanner;
use app\lib\exception\BannerException;
use app\lib\exception\BaseException;
use think\Request;

class Banner
{
    /**
     * 根据id以及location获取banner图片，以及对应的goods_id
     * @url /api/Banner?id= &location=
     * @param Request $request
     * @return \think\response\Json
     * @throws BannerException
     * @throws BaseException
     */
    public function getBanner(Request $request){
        (new MustParamBanner())->gocheck();

        $banner=MBanner::getBannerById($request->get('id'));
        if(!$banner){
            throw new BannerException();
        }
        return json($banner,200);
    }
}
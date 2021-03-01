<?php
namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\controllers\BaseController;
use yii\filters\Cors;

/**
 * 前台基类控制器
 *
 * Class IController
 * @package frontend\controllers
 */
class IController extends BaseController
{
    /**
     * csrf验证
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * @throws NotFoundHttpException
     */
    public function init()
    {
        if (!session_id()){
            session_start();
        }
        //站点关闭信息
        if(Yii::$app->config->info('SYS_SITE_CLOSE') != 1)
        {
            throw new NotFoundHttpException('您访问的站点已经关闭');
        }

        if (!empty($_GET['language'])) {
            if($_GET['language'] == 'tw'){
                $_SESSION['language'] = 'tw';
            }
            if($_GET['language'] == 'en'){
                $_SESSION['language'] = 'en';
            }
            if($_GET['language'] == 'zh'){
                $_SESSION['language'] = 'zh';
            }
            if($_GET['language'] == 'ko'){
                $_SESSION['language'] = 'ko';
            }
        }
        if (!empty($_GET['mode'])) {
            if($_GET['mode'] == 'night'){
                $_SESSION['mode'] = 'night';
                $_SESSION['mode_choose'] = 1;

            }
            if($_GET['mode'] == 'day'){
                $_SESSION['mode'] = 'day';
                $_SESSION['mode_choose'] = 1;
            }
        }
        $is_night = 1;
        if (empty($_SESSION['mode_choose'])) {
            if($is_night == 1){
                $_SESSION['mode'] = 'night';
            }else{
                $_SESSION['mode'] = 'day';
            }
        }

//<li class="zh"><img src="/resource/frontend/img/jtzw@2x(1).png">简体中文</li>
//<li class="en"><img src="/resource/frontend/img/English@2x.png">English</li>
//<li class="ko"><img src="/resource/frontend/img/ko.png">한국어</li>

        $show_language_str =<<<string
<li class="tw"><img src="/resource/frontend/img/hk.png">繁體中文</li>
<li class="zh"><img src="/resource/frontend/img/jtzw@2x(1).png">简体中文</li>
string;
Yii::$app->params['show_language_str'] = $show_language_str;

        if (!empty($_SESSION['language']) && $_SESSION['language'] == 'tw') {
            $this->module->setViewPath($this->module->getBasePath().'/views_tw');
            parent::init();
        // }else if ($_SESSION['language'] == 'ko') {
        //     $this->module->setViewPath($this->module->getBasePath().'/views_ko');
        //     parent::init();
        // }else if ($_SESSION['language'] == 'en') {
        //     $this->module->setViewPath($this->module->getBasePath().'/views_en');
        //     parent::init();
        }else{
            $this->module->setViewPath($this->module->getBasePath().'/views');
            parent::init();
        }
    }


}

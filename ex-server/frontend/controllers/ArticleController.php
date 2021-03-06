<?php
namespace frontend\controllers;

use Yii;
use jianyan\basics\common\models\sys\ArticleSingle;
use common\models\Article;
use common\servers\DeviceDetect;

/**
 * Index controller
 */
class ArticleController extends IController
{
    /**
     * 不显示头尾
     */
    /**
     * 系统首页
     * @return string
     */
    public function actionIndex()
    {
    	
                $request = Yii::$app->request;
                $id = intval($request->get('id'));
                $where['id'] = $id;
                $select = 'title,content,append';
                $content = Article::find()->select($select)->where($where)->asArray()->one();
                if (empty($content)) {
                        $content['title'] = '您要访问的内容不存在';
                        $content['content'] = '您要访问的内容不存在';
                        $content['append'] = 0;
                }
	         $header['title']= $content['title']." - ".Yii::$app->config->info('WEB_SITE_TITLE') ;
		  $header['keywords']= $content['title'].','.Yii::$app->config->info('WEB_SITE_KEYWORD');
		  $header['descripition']= Yii::$app->config->info('WEB_SITE_DESCRIPTION');       
	         $view = Yii::$app->view;
		  $view->params['header']=$header;
        $detect = new DeviceDetect;
        if ($detect->isMobile()){
        	 $this->layout='@app/views/layouts/main-mb.php';  
            return $this->render('index-mob', [
                'content'  => $content,
            ]);
        }else{
            return $this->render('index', [
                'content'  => $content,
            ]);
        }

    }

    public function actionEdit()
    {
                $request = Yii::$app->request;
                $id = intval($request->get('id'));
                $where['id'] = $id;
                $select = 'title,content';
                $content = Article::find()->select($select)->where($where)->asArray()->one();
                if (empty($content)) {
                        $content['title'] = '您要访问的内容不存在';
                        $content['content'] = '您要访问的内容不存在';
                }
	         $header['title']= Yii::$app->config->info('WEB_SITE_TITLE') ;
		  $header['keywords']= Yii::$app->config->info('WEB_SITE_KEYWORD');
		  $header['descripition']= Yii::$app->config->info('WEB_SITE_DESCRIPTION');          
	         $view = Yii::$app->view;
		  $view->params['header']=$header;	  		                                 		                        
                return $this->render('edit', [
                    'content'  => $content,
                ]);
    }
}

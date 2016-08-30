<?php

class GuideController extends Controller
{
	public $layout='//layouts/none';
	
	public function actionIndex()
	{
		$sql="SELECT * FROM {{workflowtemplates}} wt JOIN {{workflow}} w ON (w.w_id = wt.w_id) JOIN {{category}} c ON ( c.c_id = wt.c_id ) ORDER BY wt.wt_id DESC";
		$templates=Yii::app()->db->createCommand($sql)->queryAll();
			
		$sql1="SELECT * FROM {{category}} ORDER BY c_name ASC";
		$categories=Yii::app()->db->createCommand($sql1)->queryAll();
			
		$this->render('index',array(
			'templates'=>$templates,
			'categories'=>$categories,
		));
	}
	
	public function actionGettagsbyguide()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		
		$id = $_POST['id'];
		$criteria=new CDbCriteria;
		$criteria->condition='wt_id=:ID';
		$criteria->params=array(':ID'=>$id );
		$tags=Tags::model()->findAll($criteria);
		$tagscontent = $this->renderPartial('tagscontent', array('tags'=>$tags),true);
		$res = array(
			'tagscontent'=> $tagscontent
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}

	public function actionGetguidesbytag()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$key = $_POST['key'];	
		$sql="SELECT * FROM {{tags}} t
		JOIN `{{workflowtemplates}}` wt ON (wt.wt_id = t.wt_id)
		JOIN `{{workflow}}` w ON (w.w_id = wt.w_id) 
		JOIN `{{category}}` c ON ( c.c_id = wt.c_id )
		where t.tag like '%".$key."%'";
		$templates=Yii::app()->db->createCommand($sql)->queryAll();	
		$guidecontent= $this->renderPartial('guidecontent', array('templates'=>$templates),true);
		$res = array(
			'guidecontent'=> $guidecontent
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res );
		Yii::app()->end();	
	}
		
	public function actionGetbycategories()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$ids= $_POST['ids'];	
		$where = '';
		if(count($ids)==1 && $ids[0]=='all'){
			$where = '';
		}else{			
			for($i = 0; $i<count($ids); $i++){	
				if($where=='')
					$where .= "WHERE c.c_id='".$ids[$i]."'";
				else
					$where .= " OR c.c_id='".$ids[$i]."'";
			}
			
		}
		$sql="SELECT * FROM {{workflowtemplates}} wt JOIN {{workflow}} w ON (w.w_id = wt.w_id) JOIN {{category}} c ON ( c.c_id = wt.c_id ) ".$where."  ORDER BY wt.wt_id DESC";
		$templates=Yii::app()->db->createCommand($sql)->queryAll();	
		
		$guidecontent= $this->renderPartial('guidecontent', array('templates'=>$templates),true);
		$res = array(
			'guidecontent'=> $guidecontent,
			'templates'=>$templates
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res );
		Yii::app()->end();	
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
<?php

class AutomationController extends Controller
{
	public $layout='//layouts/none';
	
	public function actionIndex()
	{
		$criteria=new CDbCriteria;
		$criteria->select='w_id,w_name';
		$projectlist=Workflow::model()->findAll($criteria);	
		$this->render('index',array(
			'projectlist'=>$projectlist,
		));
	}
	
	public function actionGettriggeractions()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		
		$triggers=Triggers::model()->findAll();	
		$actions=Actions::model()->findAll();	
		
		$res = array(
			'triggers'=> $triggers,
			'actions'=> $actions
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionGetactioneventsbyid()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id = $_POST['id'];
		$criteria=new CDbCriteria;
		$criteria->condition='a_id=:actionID';
		$criteria->params=array(':actionID'=>$id);
		$action_events=ActionEvents::model()->findAll($criteria);		
		
		$res = array(
			'action_events'=> $action_events
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionGettriggereventsbyid()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id = $_POST['id'];
		$criteria=new CDbCriteria;
		$criteria->condition='t_id=:triggerID';
		$criteria->params=array(':triggerID'=>$id);
		$trigger_events=TriggerEvents::model()->findAll($criteria);		
		
		$res = array(
			'trigger_events'=> $trigger_events
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionGetconditions()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id = $_POST['id'];
		$type = $_POST['type'];
		$criteria=new CDbCriteria;
		
		if($type=='action'){		
			$criteria->condition='ae_id=:eventID';
			$criteria->params=array(':eventID'=>$id);
			$conditions=ActionConditions::model()->findAll($criteria);	
		}else{
			$criteria->condition='te_id=:eventID';
			$criteria->params=array(':eventID'=>$id);
			$conditions=TriggerConditions::model()->findAll($criteria);	
		}
		
		$res = array(
			'conditions'=> $conditions
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionGettriggerconfigurations()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id = $_POST['id'];		
		$criteria=new CDbCriteria;
		$criteria->condition='te_id=:eventID';
		$criteria->params=array(':eventID'=>$id);
		$configdata=TriggerConfigurations::model()->findAll($criteria);	
				
		$res = array(
			'configdata'=> $configdata
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionGetactionconfigurations()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id = $_POST['id'];		
		$criteria=new CDbCriteria;
		$criteria->condition='ae_id=:eventID';
		$criteria->params=array(':eventID'=>$id);
		$configdata=ActionConfigurations::model()->findAll($criteria);	
				
		$res = array(
			'configdata'=> $configdata
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionLoadproject()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id = $_POST['id'];		
		$criteria=new CDbCriteria;
		$criteria->select='w_name,w_data';
		$criteria->condition='w_id=:ID';
		$criteria->params=array(':ID'=>$id);
		$project=Workflow::model()->find($criteria);	
		$wname= $project->w_name;
		$wdata= $project->w_data;
		
		$res = array(
			'name'=> $wname,
			'data'=> $wdata
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionDeleteproject()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id = $_POST['id'];	
		$workflow=Workflow::model()->deleteByPk($id);
		$res = array(
			'return'=> true
		);
		header('Content-Type: application/json; charset="UTF-8"');	
		echo CJSON::encode($res);	
		Yii::app()->end();
	}
	
	public function actionGetworkflowtype()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id = $_POST['id'];	
		$criteria=new CDbCriteria;
		$criteria->condition='w_id=:ID';
		$criteria->params=array(':ID'=>$id);	
		$post=Workflow::model()->find($criteria);	
		
		$type = $post->w_type;
		$wdesc = $post->w_desc;
		$wname = $post->w_name;
		
		if($type=='guide'){
			$sql="Select * from `tbl_workflowtemplates` where `w_id`='".$id."'";
			$guide=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($guide)>0){
				foreach($guide as $row){
				    $wtid = $row['wt_id'];
				    $wthumb = $row['wt_thumb'];
				    $wcat = $row['c_id'];		
				}
				$criteria2=new CDbCriteria;
				$criteria2->condition='wt_id=:ID';
				$criteria2->params=array(':ID'=>$wtid);
				$tags=Tags::model()->findAll($criteria2);	
				
				$res = array('type'=> $type,'desc'=> $wdesc,'name'=> $wname,'thumb'=>$wthumb,'cat'=>$wcat,'tags'=>$tags,'wtid'=>$wtid);
			}else{
				$res = array('type'=> $type,'desc'=> $wdesc,'name'=> $wname,'thumb'=>'','cat'=>'','tags'=>array(),'wtid'=>'');
			}
		}else{
			$res = array('type'=> $type,'desc'=> $wdesc,'name'=> $wname);
		}
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();	
	}
	
	public function actionGetallcategories()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
			
		$categories=Category::model()->findAll();	
				
		$res = array('categories'=> $categories);
		
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();	
	}
	
	public function actionGettagsbykey()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$key = $_POST['phrase'];	
			
		$criteria=new CDbCriteria;	
		$criteria->group = 'tag';
		$criteria->distinct = true;
		$criteria->compare('tag',$key,true);		
		$tags=Tags::model()->findAll($criteria);		
		
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($tags);
		Yii::app()->end();	
	}
	
	public function actionSaveproject()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id = $_POST['current_id'];
		
		if($id=='' || $id==0){
			$workflow=new Workflow;
		}else{		
			$workflow=Workflow::model()->findByPk($id);
		}
		$workflow->w_name=$_POST['name'];
		$workflow->w_data=$_POST['graphdata'];
		$workflow->w_desc='--';
		$workflow->w_date=new CDbExpression("NOW()");
		$workflow->save();
		$w_id = $workflow->getPrimaryKey();			
		
		$res = array(
			'id'=> $w_id
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionSavetemplateguide()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id = $_POST['current_id'];
		$wtid = $_POST['wtid'];
		
		if($id=='' || $id==0){
			$workflow=new Workflow;
		}else{
			$workflow=Workflow::model()->findByPk($id);
		}		
		$workflow->w_name=$_POST['name'];
		$workflow->w_data=$_POST['graphdata'];
		$workflow->w_desc=$_POST['desc'];
		$workflow->w_date=new CDbExpression("NOW()");
		$workflow->w_type='guide';
		$workflow->save();
		
		 	
		if($wtid=='' || $wtid==0){
			$template=new Workflowtemplates;
		}else{
			$template=Workflowtemplates::model()->findByPk($wtid);
		}	
	
		$template->w_id=$workflow->getPrimaryKey();		
		$template->wt_thumb=$_POST['thumb'];		
		$template->c_id=$_POST['category'];
		$template->save();
		
		$taglist = $_POST['taglist'];
		if( count($taglist) > 0 ){
			//delete existing tags
			Tags::model()->deleteAll("wt_id =".$wtid);
			for($i=0; $i<count($taglist); $i++){
				$tag=new Tags;				
				$tag->wt_id = $template->getPrimaryKey();
				$tag->tag = $taglist[$i];
				$tag->save();
			}
		}
		
		$res = array(
			'id'=> $workflow->w_id
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionUploadthumb()
    	{
        	if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		
		$uploadedFile = CUploadedFile::getInstanceByName('thumbnail');
		$ext = $uploadedFile->getExtensionName();
		$size = $uploadedFile->getSize();
		
		if($ext=='png'||$ext=='jpg'||$ext=='jpeg'||$ext=='gif'){
			if($size<100000){
				$fileName = 'thumb_'.time().'.'.$ext;
				$uploadedFile->saveAs(YiiBase::getPathOfAlias("webroot").'/images/guides/'.$fileName);
				$error = $uploadedFile->getError();
			}else{
				$error = 'The file you are attempting to upload is larger than the permitted size.';
			}
		}else{
			$error = 'The filetype you are attempting to upload is not allowed.';
		}        
		$res = array(
			'error'=> $error,
			'path'=> $fileName
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
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
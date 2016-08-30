<?php

class ManagecategoryController extends Controller
{
	public $layout='//layouts/none';
	public function actionIndex()
	{
		$sql="SELECT `tag`, COUNT(`tag`) as cnt FROM {{tags}} GROUP BY `tag` ORDER BY `tag` ASC";
		$tags=Yii::app()->db->createCommand($sql)->queryAll();
		
		$sql1="SELECT * FROM {{category}} ORDER BY c_name ASC";
		$categories=Yii::app()->db->createCommand($sql1)->queryAll();
			
		$this->render('index',array(
			'tags'=>$tags,
			'categories'=>$categories,
		));
	}
	
	public function actionAddcategory()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		
		$category=new Category;
		$category->c_name=$_POST['name'];
		$category->c_desc=htmlspecialchars($_POST['desc']);
		$category->save();
		$c_id = $category->getPrimaryKey();			
		
		$res = array(
			'id'=> $c_id,
			'return'=>true
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionEditcategory()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id=$_POST['c_id'];
		$category=Category::model()->findByPk($id);
		$category->c_name=$_POST['name'];
		$category->c_desc=htmlspecialchars($_POST['desc']);
		$category->save();
		$c_id = $category->getPrimaryKey();			
		
		$res = array(
			'id'=> $c_id,
			'return'=>true
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}


	public function actionCountundercategory()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id=$_POST['id'];	
		$sql="SELECT * FROM {{workflowtemplates}} where c_id=".$id;
		$query=Yii::app()->db->createCommand($sql)->queryAll();
		
		$res = array(
			'return'=>true,
			'count'=>count($query)
		);
		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode($res);
		Yii::app()->end();
	}

	public function actionDeletecategory()
	{
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$id = $_POST['c_id'];	
		Category::model()->deleteByPk($id);
		$res = array(
			'return'=> true
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
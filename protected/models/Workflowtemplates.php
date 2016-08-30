<?php

/**
 * This is the model class for table "{{workflowtemplates}}".
 *
 * The followings are the available columns in table '{{workflowtemplates}}':
 * @property integer $wt_id
 * @property string $wt_thumb
 * @property integer $w_id
 * @property integer $c_id
 */
class Workflowtemplates extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{workflowtemplates}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('w_id', 'c_id', 'required'),
			//array('w_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wt_id, wt_thumb, w_id, c_id', 'safe', 'on'=>'search'),			
			//array('wt_thumb', 'image','types'=>'jpg,jpeg,gif,png ', 'allowEmpty'=>true, 'on'=>'update'),
			//array('wt_thumb','image', 'length', 'max'=>255, 'on'=>'insert,update'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wt_id' => 'wt_id',
			'wt_thumb' => 'Thumbnail',
			'w_id' => 'w_id',
			'c_id' => 'Category',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('wt_id',$this->wt_id);
		$criteria->compare('wt_thumb',$this->wt_thumb,true);
		$criteria->compare('w_id',$this->w_id);
		$criteria->compare('c_id',$this->c_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Workflowtemplates the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "{{trigger_events}}".
 *
 * The followings are the available columns in table '{{trigger_events}}':
 * @property integer $te_id
 * @property integer $t_id
 * @property string $te_name
 * @property string $te_desc
 * @property string $te_img
 */
class TriggerEvents extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{trigger_events}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('t_id, te_name, te_desc, te_img', 'required'),
			array('t_id', 'numerical', 'integerOnly'=>true),
			array('te_name', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('te_id, t_id, te_name, te_desc, te_img', 'safe', 'on'=>'search'),
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
			'te_id' => 'Te',
			't_id' => 'T',
			'te_name' => 'Te Name',
			'te_desc' => 'Te Desc',
			'te_img' => 'Te Img',
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

		$criteria->compare('te_id',$this->te_id);
		$criteria->compare('t_id',$this->t_id);
		$criteria->compare('te_name',$this->te_name,true);
		$criteria->compare('te_desc',$this->te_desc,true);
		$criteria->compare('te_img',$this->te_img,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TriggerEvents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

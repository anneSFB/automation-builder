<?php

/**
 * This is the model class for table "{{workflow}}".
 *
 * The followings are the available columns in table '{{workflow}}':
 * @property integer $w_id
 * @property string $w_name
 * @property string $w_type
 * @property string $w_desc
 * @property string $w_data
 * @property string $w_date
 */
class Workflow extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{workflow}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('w_name', 'required'),
			array('w_name, w_type', 'length', 'max'=>200),
			array('w_data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('w_id, w_name, w_type, w_desc, w_data, w_date', 'safe', 'on'=>'search'),
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
			'w_id' => 'W',
			'w_name' => 'W Name',
			'w_type' => 'W Type',
			'w_desc' => 'W Desc',
			'w_data' => 'W Data',
			'w_date' => 'W Date',
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

		$criteria->compare('w_id',$this->w_id);
		$criteria->compare('w_name',$this->w_name,true);
		$criteria->compare('w_type',$this->w_type,true);
		$criteria->compare('w_desc',$this->w_desc,true);
		$criteria->compare('w_data',$this->w_data,true);
		$criteria->compare('w_date',$this->w_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Workflow the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

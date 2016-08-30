<?php

/**
 * This is the model class for table "{{trigger_conditions}}".
 *
 * The followings are the available columns in table '{{trigger_conditions}}':
 * @property integer $tec_id
 * @property integer $te_id
 * @property string $tec_label
 * @property string $tec_color
 * @property string $tec_desc
 */
class TriggerConditions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{trigger_conditions}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('te_id, tec_label, tec_color, tec_desc', 'required'),
			array('te_id', 'numerical', 'integerOnly'=>true),
			array('tec_color', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tec_id, te_id, tec_label, tec_color, tec_desc', 'safe', 'on'=>'search'),
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
			'tec_id' => 'Tec',
			'te_id' => 'Te',
			'tec_label' => 'Tec Label',
			'tec_color' => 'Tec Color',
			'tec_desc' => 'Tec Desc',
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

		$criteria->compare('tec_id',$this->tec_id);
		$criteria->compare('te_id',$this->te_id);
		$criteria->compare('tec_label',$this->tec_label,true);
		$criteria->compare('tec_color',$this->tec_color,true);
		$criteria->compare('tec_desc',$this->tec_desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TriggerConditions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

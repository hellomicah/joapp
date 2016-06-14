<?php

/**
 * This is the model class for table "form_dropdown".
 *
 * The followings are the available columns in table 'form_dropdown':
 * @property string $dropdown_id
 * @property string $name
 * @property string $values
 * @property string $date_added
 * @property string $datetime_created
 * @property string $form_updated
 * @property integer $admin_id
 */
class FormDropdown extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'form_dropdown';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, values', 'required'),
			array('admin_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('date_added, datetime_created, form_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dropdown_id, name, values, date_added, datetime_created, form_updated, admin_id', 'safe', 'on'=>'search'),
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
			'dropdown_id' => 'Dropdown',
			'name' => 'Name',
			'values' => 'Values',
			'date_added' => 'Date Added',
			'datetime_created' => 'Datetime Created',
			'form_updated' => 'Form Updated',
			'admin_id' => 'Admin',
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

		$criteria->compare('dropdown_id',$this->dropdown_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('values',$this->values,true);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('datetime_created',$this->datetime_created,true);
		$criteria->compare('form_updated',$this->form_updated,true);
		$criteria->compare('admin_id',$this->admin_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FormDropdown the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

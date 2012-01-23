<?php

/**
 * Represents information about a user activity
 *
 * @property string $id the id column in table 'useractivity'
 * @property string $userId the userId column in table 'useractivity'
 * @property string $type the type column in table 'useractivity'
 * @property string $locationId the locationId column in table 'useractivity'
 * @property string $timeAdded the timeAdded column in table 'useractivity'
 *
 * @package application.models
 */
class AUserActivity extends CActiveRecord
{
	const REGISTER = 1;
	const LOGIN = 2;
	const INVALID_LOGIN = 3;
	const ACCOUNT_LOCKED = 4;
	const FORGOT_PASSWORD = 5;
	const RESET_PASSWORD = 6;
	const CHANGE_PASSWORD = 7;
	const CHANGE_EMAIL = 8;
	const SUSPENDED = 9;
	const BANNED = 10;
	const UNSUSPENDED = 11;
	const UNBANNED = 12;
	const DELETED = 13;
	const EXPIRED = 14;
	const DEACTIVATED = 15;
	const CHECKIN = 16;
	const CHECKOUT = 17;
	const LOGOUT = 18;
	const ADD_TO_CART = 19;
	const REMOVE_FROM_CART = 20;
	const ORDER = 21;
	const CONFIRM_ORDER = 22;
	const CANCEL_ORDER = 23;
	const REQUEST_REFUND = 24;
	const UPDATE_PROFILE = 25;
	const SET_PROFILE_IMAGE = 26;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className the class name to instantiate
	 * @return AUserActivity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Returns the name of the associated database table.
	 * @see CActiveRecord::tableName()
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'useractivity';
	}

	/**
	 * Returns the validation rules for attributes.
	 * @see CModel::rules()
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, type, timeAdded', 'required'),
			array('userId, locationId', 'length', 'max'=>10),
			array('type', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userId, type, locationId, timeAdded', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns the relational rules that specify the relations this model uses
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
	 * Returns the attribute labels. Attribute labels are mainly used in error messages of validation.
	 * @see CModel::attributeLabels()
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' => 'User',
			'type' => 'Type',
			'locationId' => 'Location',
			'timeAdded' => 'Time Added',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('locationId',$this->locationId,true);
		$criteria->compare('timeAdded',$this->timeAdded,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
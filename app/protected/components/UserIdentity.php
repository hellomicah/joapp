<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
require'PasswordHash.php';

class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_access;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$wp_hasher = new PasswordHash(8, TRUE);
		$record=Admin::model()->findByAttributes(array('username'=>$this->username));
		$count = count($record);
		
		if($count >=1){
			if($record===null){
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			//echo '<br/>null';
				
			}elseif($record->user_status == "Inactive"){
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}elseif($wp_hasher->CheckPassword($this->password, $record->password)){
					$this->_id=$record->user_id;
					$this->_access=$record->user_role;
					$this->setState('title', $record->first_name);
					$this->setState('access', $record->user_role);
					Yii::app()->session['access_role'] = $record->user_role;
					
					Yii::app()->session->add('user_'.$record->user_id.'user_name',$record->username);
					
					$this->errorCode=self::ERROR_NONE;
			}else{
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}
		}else{
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		
		return !$this->errorCode;
		
		/*
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
		*/
	}
	public function getId()
    {
        return $this->_id;
    }
    
    public function getAccess()
    {
        return $this->_access;
    }
}
<?php

/**
 * This is the model class for table "admin".
 *
 * The followings are the available columns in table 'admin':
 * @property string $user_id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $user_role
 * @property string $user_status
 * @property string $date_registered
 */
class Admin extends CActiveRecord
{
	const LEVEL_SUPER_ADMIN = 'Super Admin';
	const LEVEL_LINE_HEAD ='Line Head';
	const LEVEL_GLOBAL_VIEWER ='Global Viewer';
	const LEVEL_PRODUCTION_HEAD='Production Head' ;
	const LEVEL_SEWING_CONTROLLER='Sewing Output & Status Controller' ;
	const LEVEL_FINISHING_CONTROLLER='Finishing Output & Status Controller' ;
	
	const ACTIVE='Active' ;
	const INACTIVE='Inactive' ;
	
	public $confirm_password;
	public $old_password;
	public $new_password;
	public $confirm_new_password;
	public $initialPassword;
	public $selected_line;
	public $line_list;
	public $single_line;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'admin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, first_name, last_name,password,confirm_password,user_role', 'required', 'on' => 'create'),
			array('confirm_password', 'compare', 'compareAttribute'=>'password','on' => 'create'),
			array('username', 'unique', 'on' => 'create'),
			
			array('username, first_name, last_name,user_role', 'required', 'on' => 'update'),
			array('old_password', 'must_equal', 'on' => 'update'),
			array('confirm_new_password', 'compare', 'compareAttribute'=>'new_password','on' => 'update'),

			array('single_line,selected_line','validateSelectedList','on' => 'create,update'),
			

			array('username', 'length', 'max'=>32),
			array('first_name, last_name', 'length', 'max'=>140),
			array('password', 'length', 'max'=>240),
			array('user_status', 'length', 'max'=>8),
			array('date_registered,user_role,new_password,password,single_line', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, username, first_name, last_name, password, user_role, user_status, date_registered', 'safe', 'on'=>'search'),
		);
	}
	public function validateSelectedList($attribute,$params)
	{
   		if($this->user_role == "Sewing Output & Status Controller" || $this->user_role == "Finishing Output & Status Controller"){
			if(empty($this->selected_line)){
				$this->addError($attribute, 'Cannot be blank.');
			}	
		}else if($this->user_role == self::LEVEL_LINE_HEAD){
			if(empty($this->single_line)){
				$this->addError($attribute, 'Cannot be blank.');
			}	
		}
    
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
			'user_id' => 'User',
			'username' => 'Username',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'password' => 'Password',
			'user_role' => 'User Role',
			'user_status' => 'User Status',
			'date_registered' => 'Date Registered',
			'single_line' => 'Line'
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('user_role',$this->user_role,true);
		$criteria->compare('user_status',$this->user_status,true);
		$criteria->compare('date_registered',$this->date_registered,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
            	'pageSize' => 50,
        	),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Admin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * use to fill the dropdownlist in user _form.
	 * @return an array of the user role.
	 */
	public function userRoles(){
	 return array(
	 		""=>"Select Role",
	 		self::LEVEL_SUPER_ADMIN => self::LEVEL_SUPER_ADMIN,
	 		self::LEVEL_PRODUCTION_HEAD => self::LEVEL_PRODUCTION_HEAD,
            self::LEVEL_GLOBAL_VIEWER => self::LEVEL_GLOBAL_VIEWER,
			self::LEVEL_SEWING_CONTROLLER => self::LEVEL_SEWING_CONTROLLER,
			self::LEVEL_FINISHING_CONTROLLER => self::LEVEL_FINISHING_CONTROLLER,
			self::LEVEL_LINE_HEAD => self::LEVEL_LINE_HEAD,
        );
	}
	
	/*
	*Before saving the users data
	*/
	public function beforeSave(){
		
		if ($this->isNewRecord){
			$this->date_registered = date('Y-m-d');
			$t_hasher = new PasswordHash(8, FALSE);
			$hash = $t_hasher->HashPassword($_POST['Admin']['password']);
			$this->password= $hash;
		}else{
			if(!empty($this->new_password) && !empty($this->confirm_new_password) && !empty($this->old_password)){
				$t_hasher = new PasswordHash(8, FALSE);
				$hash = $t_hasher->HashPassword($this->new_password);
				$this->password= $hash;
			}else if(!empty($this->new_password) && !empty($this->confirm_new_password)){
				$t_hasher = new PasswordHash(8, FALSE);
				$hash = $t_hasher->HashPassword($this->new_password);
				$this->password= $hash;
			}
			
			$this->updateAdminLine($this->user_id);
			/*if(!empty($this->selected_line)){
					foreach($this->selected_line as $sl){
						$this->addAdminLine($sl);
					}
				}*/
		}
		return parent::beforeSave();
	}
	
	public function afterSave(){
		if($this->user_role == self::LEVEL_SEWING_CONTROLLER || $this->user_role == self::LEVEL_FINISHING_CONTROLLER){
			//save data to admin_line
			//select from admin_line
			if(!empty($this->selected_line)){
					foreach($this->selected_line as $sl){
						$this->addAdminLine($sl);
					}
				}
			
			
		}else if($this->user_role == self::LEVEL_LINE_HEAD){
			if(!empty($this->single_line)){
					$this->addAdminLine($this->single_line);
				}
		}
	}
	
	private function addAdminLine($sl){
		$user = Yii::app()->db->createCommand()
							->insert('admin_line', array(
    						'admin_id'=>$this->user_id,
    						'line_id'=>$sl,
    						'date_added'=>date('Y-m-d')
						));
	}
	
	private function updateAdminLine($admin_id){
		//delete from admin_line
		
		$command = Yii::app()->db->createCommand()
			->delete('admin_line', 'admin_id=:admin_id', array(':admin_id'=>$admin_id));
	}
	
	public function getSelectedLine($admin_id){
		$line_list_data = JoLine::model()->LineList("admin");
		$selected_line_data = array();
		/*$connection = Yii::app()->db;
		$command = $connection->createCommand('select B.name,B.line_id from admin_line A left join jo_line B on A.line_id = B.line_id where A.admin_id = "$admin_id"');
		$jo_line = $command->queryAll(); */
		
		$sql = 'select B.name,B.line_id from admin_line A left join jo_line B on A.line_id = B.line_id where A.admin_id = '.$admin_id;
		$jo_line  = Yii::app()->db
        ->createCommand($sql)
        ->queryAll();
		if(!empty($jo_line)){
			foreach($jo_line as $name){
				$jo_arr[$name["line_id"]] = $name["name"];
				$v = $line_list_data[$name["line_id"]];
				//unset($line_list_data[$name["line_id"]]);
				//print_r($line_list_data);
				//$key = key($line_list_data[$name["line_id"]]);
				//unset($line_list_data[$key]);
				unset($line_list_data[array_search($name["name"],$line_list_data)]);

				$selected_line_data[$name["line_id"]]  = $v;
			}
		}
		$jo_arr["selected_line"]=$selected_line_data;
		$jo_arr["list_data"] =$line_list_data;
	 return $jo_arr;
	}
	
	public function getSelectedSingleLine($admin_id){
		$line_list_data = JoLine::model()->LineList("admin");
		$single_line_id = "";
		/*$connection = Yii::app()->db;
		$command = $connection->createCommand('select B.name,B.line_id from admin_line A left join jo_line B on A.line_id = B.line_id where A.admin_id = "$admin_id"');
		$jo_line = $command->queryAll(); */
		
		$sql = 'select B.name,B.line_id from admin_line A left join jo_line B on A.line_id = B.line_id where A.admin_id = '.$admin_id;
		$jo_line  = Yii::app()->db
        ->createCommand($sql)
        ->queryRow();
		if(!empty($jo_line)){
				$single_line_id = $jo_line["line_id"];
			
		}
		
	 return $single_line_id;
	}
	
	public function getSelectedLineIDS($admin_id){
		$line_list_data = JoLine::model()->LineList("admin");
		$selected_line_data = array();
		/*$connection = Yii::app()->db;
		$command = $connection->createCommand('select B.name,B.line_id from admin_line A left join jo_line B on A.line_id = B.line_id where A.admin_id = "$admin_id"');
		$jo_line = $command->queryAll(); */
		
		$sql = 'select B.name,B.line_id from admin_line A left join jo_line B on A.line_id = B.line_id where A.admin_id = '.$admin_id;
		$jo_line  = Yii::app()->db
        ->createCommand($sql)
        ->queryAll();
		if(!empty($jo_line)){
			foreach($jo_line as $name){
				$jo_arr[$name["line_id"]] = $name["name"];
				$selected_line_data[]  = $name["line_id"];
			}
		}
	
	 return $selected_line_data;
	}
	
	/*
	on update of users data
	*/
	public function must_equal($attribute_name, $params){
		if (!empty($this->old_password)) {
			$t_hasher = new PasswordHash(8, TRUE);
			if(!$t_hasher->CheckPassword($this->old_password, $this->password)){
				$this->addError($attribute_name, Yii::t('old_password', 'Old Password not valid.'));
			}
			return false;
		}

		return true;
	}
	
		/**
	 * @updates the user status from active to inactive instead of directly deleting on database.
	 */
	public function changeStatus($id){
		$command = Yii::app()->db->createCommand()
				->update('admin', array(
						'user_status'=>self::INACTIVE,
					), 'user_id=:user_id', array(':user_id'=>$id));
	}
	
	/**
	 * use to fill the dropdownlist in user _form.
	 * @return an array of the user role.
	 */
	public function userStatus(){
	 return array(
            self::ACTIVE => self::ACTIVE,
			self::INACTIVE => self::INACTIVE,
        );
	}
}

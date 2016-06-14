<?php
class WebUser extends CWebUser{
 private $_users;

//is the user a superadmin ?
 function getIsSuperAdmin(){
  return ( $this->users && $this->users->user_role == Admin::LEVEL_SUPER_ADMIN);
 }
 //is the user a superadmin ?
 function getIsProductionHead(){
  return ( $this->users && $this->users->user_role == Admin::LEVEL_PRODUCTION_HEAD);
 }
 //is the user a Global Admin ?
 function getIsGlobalViewer(){
  return ( $this->users && $this->users->user_role == Admin::LEVEL_GLOBAL_VIEWER);
 }
 //is the user a sewing editor ?
 function getIsSewingController(){
  return ( $this->users && $this->users->user_role == Admin::LEVEL_SEWING_CONTROLLER);
 }
 //is the user a finishing editor ?
function getIsFinishingController(){
  return ( $this->users && $this->users->user_role == Admin::LEVEL_FINISHING_CONTROLLER);
 }
  //is the user a viewer ?
 function getIsLineHead(){
  return ( $this->users && $this->users->user_role == Admin::LEVEL_LINE_HEAD);
 }
 //get the logged user
 function getUsers(){
  if( $this->isGuest )
   return;
  if( $this->_users === null ){
   $this->_users = Admin::model()->findByPk( $this->id );
  }
  return $this->_users;
 }
}
?>
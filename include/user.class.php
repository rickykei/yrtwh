<?php
include_once('db.class.php');
Class User{ 
 private $roleTable = 'role'; 
 private $userTable = 'staff';
 private $username="";
 private $name="";
 private $userrole=array();
 private $pc="";
 private $area="";
 private $db;
  public function __construct(Database $db){
    $this->db = $db;
  }

 public function checkPassword($user,$pass){
	 
  $out=$this->db->query("SET NAMES 'UTF8'");	 
  $out=$this->db->query_first("SELECT * FROM ".$this->userTable." WHERE `password` = '$pass' and `username` = '$user'");
  if ($this->db->affected_rows>0){
	$this->username=$out['username'];
	$this->pc=$out['pc'];
	$this->area=$out['area'];
	$this->name=$out['name'];
	array_push($this->userrole,$this->getRoleName($out['role']));
	//print_r($this->userrole);
    return true;
	}else
	return false;
 }
 
 public function getRoleName($rid){ 
  $result = $this->db->query_first("SELECT * FROM ".$this->roleTable." WHERE `role_id` = $rid"); 
  if(empty($result['role_id'])) { return false; } 
  else return $result['name']; 
 } 
 
 public function isAdmin(){ 
  if($this->user['role'] === ADMIN_ROLE) return true; 
  return false; 
 } 
 
 /*public function getUserRole($uid){ 
  if(!$user = $this->getUserById($uid)) 
   return false; 
  else return $this->getRoleName($user['role']); 
 } */
  public function getName(){
	return $this->name;
 }
 
 public function getUsername(){
	return $this->username;
 }
 public function getUserrole($i=0){
	return $this->userrole[$i];
 }
 public function getUserarea(){
	return $this->area;
 }
 public function getUserpc(){
	return $this->pc;
 }
 
} 
?>
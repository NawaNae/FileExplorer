<?php
session_start();
class Account
{
	private $account ;
	public function isLogin()
	{
		if(isset($_SESSION['account']))
			return true;
		else
			return false;
	}
	public function logout()
	{
		if($this->isLogin())
			include("logout.php");
		else
			echo $this->account.",you have already logged in.";
	}
	public function showLogin()
	{
		include("login.php");
	}
	public function login($accountName,$password)
	{
		$_POST['account']=$accountName;
		$_POST['pw']=$password;
		include("connect.php");
		$this->account = $_SESSION['account'];
	}
}


?>
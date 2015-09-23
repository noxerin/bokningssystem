<?php
class model_auth
{
	
	public function authenticate($user, $hash){
		$sql = "
			SELECT
				id, email, fname, lname
			FROM
				admin
			WHERE
				email = ?
			AND
				password = ?";
		$result = $GLOBALS['db']->query($sql, array($user, $hash));
		if(!$result){
			return false;
		}else{
			$_SESSION['admin']['id'] = $result[0]['id'];
			$_SESSION['admin']['fname'] = $result[0]['fname'];
			$_SESSION['admin']['lname'] = $result[0]['lname'];
			$_SESSION['admin']['email'] = $result[0]['email'];
			$_SESSION['admin']['auth'] = TRUE;
			return true;
		}
	}
	
	public function getAdminUpdates(){
		$sql = "
			SELECT
				email
			FROM
				admin
			WHERE
				updates = 'ALL'";
		return $GLOBALS['db']->query($sql);
	}
	
}
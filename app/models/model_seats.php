<?php
class model_seats
{

	public function freeTable(){
		$sql = "
				SELECT
					*
				FROM
					platser
				WHERE
					status = 'ledig'";
		$GLOBALS["db"]->querySecured($sql);
		
		
		return $GLOBALS["db"]->countRow();
	}
	
	public function getAllTables(){
		$sql1 = "
			SELECT 
				* 
			FROM 
				platser
			GROUP BY 
				bord 
			ORDER BY 
				id 
				  ASC";
		$sql2 = "
			SELECT 
				* 
			FROM 
				platser  
			ORDER BY 
				id 
				  ASC";
		$result1 = $GLOBALS["db"]->querySecured($sql1);
		$result2 = $GLOBALS["db"]->querySecured($sql2);	
		//Prepare data array
		$data[0] = $result1;
		$data[1] = $result2;
		
		return $data;
	}
	
	public function getSeatInfo($id){
		$sql = "
			SELECT
				*
			FROM
				platser
			JOIN 
				bokningar
					ON platser.id = bokningar.plats_id
						JOIN
							users
								ON bokningar.kund = users.id
			WHERE
				platser.id = ".$id;
		$result = $GLOBALS["db"]->querySecured($sql);
		if(!$result){
			$sql = "
				SELECT
					*
				FROM
					platser
				WHERE
					platser.id = ".$id;
			$result = $GLOBALS["db"]->querySecured($sql);
		}
		
		return $result;
	}
	
	public function updateLock($seat, $set){
		$mode = "";
		if($set == 0){
			$mode = "ledig";
		}else if($set == 1){
			$mode = "inaktiv";
		}
		$sql = "
			SELECT
				*
			FROM
				bokningar
			WHERE
				plats_id = $seat;";
		$GLOBALS["db"]->querySecured($sql);
		if($GLOBALS["db"]->countRow() == 0){
			$sql = "
				UPDATE
					platser
				SET
					status = '$mode'
				WHERE
					id = '$seat'";
			$GLOBALS["db"]->querySecured($sql);			
			return true;
		}else{
			return false;
		}

	}
	
	public function removeSeat($seat){
		$sql = "
			UPDATE
				platser
			SET
				status = 'ledig'
			WHERE
				id = '$seat'";
		$GLOBALS['db']->querySecured($sql);
	}
	
	public function bookSeat($seat, $user, $booking){
		$sql = "
			SELECT
				*
			FROM
				platser
			WHERE
				id = '$seat'
			AND
				status = 'ledig'";
		$result = $GLOBALS['db']->querySecured($sql);
		
		$sql = "
			SELECT
				*
			FROM
				users
			WHERE
				id = '$user'";
		$GLOBALS['db']->querySecured($sql);
		if($GLOBALS["db"]->countRow() > 0){
			if($result[0]['status'] == "ledig"){
				$sql = "
					UPDATE
						platser
					SET
						status = 'bokad'
					WHERE
						id = '$seat'";
				$GLOBALS["db"]->querySecured($sql);
					/*
					*
					*	Checks if customer already have a booking and releases that seat
					*/
					$sql = "
						SELECT
							*
						FROM
							bokningar
						WHERE
							kund = $user
						AND
							id = $booking";
					$moveBook = $GLOBALS['db']->querySecured($sql);
					if($GLOBALS["db"]->countRow() > 0){
						$sql = "
							UPDATE
								platser
							SET
								status = 'ledig'
							WHERE
								id = ".$moveBook[0]["plats_id"];
						$GLOBALS['db']->querySecured($sql);
					}
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
}
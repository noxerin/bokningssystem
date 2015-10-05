<?php
class model_booking
{
	
	public function fetch(){
		$sql = "
			SELECT
				*
			FROM
				book_times";
		return $GLOBALS['db']->query($sql);
	}
	
	public function getBookingTime($id){
		$sql = "
			SELECT
				*
			FROM
				book_times
			WHERE
				id = ?";
		return $GLOBALS['db']->query($sql, $id);
	}
	
	public function getAllByProduct($id){
		$sql = "
			SELECT
				*
			FROM
				book_times
			WHERE
				product = ?";
		return $GLOBALS['db']->query($sql, $id);
	}
	
	public function addBooking($booking_id, $order_id, $fname, $lname, $phone, $email){
		if($this->checkRemainingSeats($booking_id) >= $_SESSION['book']['product']['count'] && $_SESSION['book']['product']['count'] > 0){
			if($this->orderRemaininingSeats($order_id)){
				if(isset($_SESSION['book']['addon'])){
					foreach($_SESSION['book']['addon'] as $row){
						if($this->orderRemaininingExtras($order_id) >= $row['count']){
						}else{
							return false;
							break;
						}
					}
					$this->insertNewBooking($booking_id, $order_id, $_SESSION['book']['product']['count'], $fname, $lname, $phone, $email);
					foreach($_SESSION['book']['addon'] as $row){
						$this->updateUsedExtras($booking_id, $order_id, $row['count'], $fname, $lname, $phone, $email, $row['id']);						
					}
					return true;
				}else{	
					$this->insertNewBooking($booking_id, $order_id, $_SESSION['book']['product']['count'], $fname, $lname, $phone, $email);
					return true;
				}
			}
		}else{
			return false;
		}
	}
	
	public function insertNewBooking($booking_id, $order_id, $count, $fname, $lname, $phone, $email){
		$sql = "
			INSERT
				INTO 
					bookings
					(booking_id, order_id, count, fname, lname, phone, email)
			VALUES
				(?, ?, ?, ?, ?, ?, ?)";
		$GLOBALS['db']->query($sql, array($booking_id, $order_id, $count, $fname, $lname, $phone, $email));
		
		$sql = "
			SET SQL_SAFE_UPDATES = 0;

			UPDATE
				order_items
			SET
				used = used + ?
			WHERE
				order_items.order = ?
			AND
				category = 'PRODUCT'";
		$GLOBALS['db']->query($sql, array($count, $order_id));
	}
	
	public function updateUsedExtras($booking_id, $order_id, $count, $fname, $lname, $phone, $email, $item_id){
		$sql = "
			INSERT
				INTO 
					bookings
					(booking_id, order_id, count, fname, lname, phone, email, type, item_id)
			VALUES
				(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$GLOBALS['db']->query($sql, array($booking_id, $order_id, $count, $fname, $lname, $phone, $email, "EXTRAS", $item_id));
		
		
		$sql = "
			SET SQL_SAFE_UPDATES = 0;

			UPDATE
				order_items
			SET
				used = used + ?
			WHERE
				order_items.order = ?
			AND
				category = 'EXTRAS'";
		$GLOBALS['db']->query($sql, array($count, $order_id));
	}
	
	//Call functions
	
	public function checkRemainingSeats($booking_id){
		$sql = "
			SELECT
				*
			FROM
				book_times
			WHERE
				id = ?";
		$result = $GLOBALS['db']->query($sql, $booking_id);

		$sql = "
			SELECT
				*
			FROM
				bookings
			WHERE
				booking_id = ?
			AND
				type = 'PRODUCT'";
		$result2 = $GLOBALS['db']->query($sql, $result[0]['id']);
		$seats = 0;
		foreach($result2 as $row){
			$seats += $row['count'];
		}
		
		return ($result[0]['seats'] - $seats);
	}
	
	public function orderRemaininingSeats($order_id){
		$sql = "
			SELECT
				*
			FROM
				order_items
			WHERE
				order_items.order = ?
			AND
				category = 'PRODUCT'";
		$result = $GLOBALS['db']->query($sql, $order_id);
		
		$seatsRemaining = ($result[0]['count'] - $result[0]['used']);
		
		return $seatsRemaining;
	}
	
	public function orderRemaininingExtras($order_id){
		$sql = "
			SELECT
				*
			FROM
				order_items
			WHERE
				order_items.order = ?
			AND
				category = 'EXTRAS'";
		$result = $GLOBALS['db']->query($sql, $order_id);
		
		$seatsRemaining = ($result[0]['count'] - $result[0]['used']);
		
		return $seatsRemaining;
	}
	
	/***
	*
	*	This is classes used i live querys using ajax
	*
	*	These classes still requires session var if used from admin panel
	*
	***/
	
	public function fetchTimes($booking_id, $date){
		$sql = "
			SELECT
				*
			FROM
				book_times
			WHERE
				product = ?
			AND
				time_from BETWEEN ? - 172800 AND ? + 172800
			AND
				time_from > UNIX_TIMESTAMP()
			LIMIT 5";
		$booking_times = $GLOBALS['db']->query($sql, array($booking_id, $date, $date));

		//Render result
		if($booking_times){
			foreach($booking_times as $row){
				$remaining = $this->checkRemainingSeats($row['id']);
				if(date('n/j' ,$row['time_from']) == date('n/j' ,$row['time_to'])){
					echo "
					<div class='bookingItem bookingRemove' data-id='" .  $row['id'] . "'>
						<p>Den " . date('j F \k\l H:i', $row['time_from']) . " till " . date('\k\l H:i', $row['time_to']) . " platser lediga " . $remaining . " / " . $row['seats'] . "</p>
					</div>";
				}else{
					echo "
					<div class='bookingItem bookingRemove' data-id='" .  $row['id'] . "'>
						<p>Den " . date('j F \k\l H:i', $row['time_from']) . " till " . date('F j \k\l H:i', $row['time_to']) . " platser lediga " . $remaining . " / " . $row['seats'] . "</p>
					</div>";
				}
			}		
		}else{
			echo '<p class="bookingInfo bookingRemove">Det finns inga tider nära valt datum välj ett annat datum!</p>';
		}
	}
		
}
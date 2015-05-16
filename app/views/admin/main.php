			<div class="container" style="margin-top: 50px;">
				<div class="col-md-2 latest-boxes latest-boxes-1">
					<div class="latest-text">
						<h1>1</h1>
						<small>Nya köp idag</small>
					</div>
				</div>
				<div class="col-md-2 col-md-offset-1 latest-boxes latest-boxes-3">
					<div class="latest-text">
						<h1>10</h1>
						<small>Totalt sålda</small>
					</div>
				</div>
				<div class="col-md-2 col-md-offset-1 latest-boxes latest-boxes-2">
					<div class="latest-text">
						<h1>2</h1>
						<small>Bokningar för idag</small>
					</div>
				</div>
				<div class="col-md-2 col-md-offset-1 latest-boxes latest-boxes-4">
					<div class="latest-text">
						<h1>200</h1>
						<small>Totalt antal bokningar</small>
					</div>
				</div>
				<div class="col-md-12" style="margin-top: 30px;">
					<h2>Senaste händelserna</h2>
				</div>
				<div class="col-md-12 latest-actions">
					<?php
						foreach($data["latest"] as $row)
						{
							$row['time'] = $row['time']-3600;
							switch($row["origin"]){
								case "betalning":
									echo '
									<!-- Betalning -->
									<div class="col-md-12 latest-actions-event">
										<div class="col-md-2">
											<i class="fa fa-credit-card"></i> Betalning
										</div>
										<div class="col-md-4 col-md-offset-2">
											Anv: ' . $row['username'] . '
										</div>
										<div class="col-md-2 col-md-offset-1">
											<abbr class="timeago" title="' . date("Y-m-d", $row['time']) . "T" . date("G:i:s", $row['time']) . 'Z"></abbr>
										</div>
									</div>
									';
								break;
								case "users":
									echo '
									<!-- Registrerad användare -->
									<div class="col-md-12 latest-actions-event">
										<div class="col-md-2">
											<i class="fa fa-user-plus" style="color: green;"></i> Ny användare
										</div>
										<div class="col-md-4 col-md-offset-2">
											Anv: ' . $row['username'] . '
										</div>
										<div class="col-md-2 col-md-offset-1">
											<abbr class="timeago" title="' . date("Y-m-d", $row['time']) . "T" . date("G:i:s", $row['time']) . 'Z"></abbr>
										</div>
									</div>
									';
								break;
								case "bokning":
									echo '
									<!- Ny bokning -->
									<div class="col-md-12 latest-actions-event">
										<div class="col-md-2">
											<i class="fa fa-book"></i> Ny bokning
										</div>
										<div class="col-md-4 col-md-offset-2">
											Anv: ' . $row['username'] . '
										</div>
										<div class="col-md-2 col-md-offset-1">
											<abbr class="timeago" title="' . date("Y-m-d", $row['time']) . "T" . date("G:i:s", $row['time']) . 'Z"></abbr>
										</div>
									</div>
									';
								break;
								default: 
									echo "<p>Inga händelser</p>";
							}
						}
					?>
					<!-- Missyckad betalning --
					<div class="col-md-12 latest-actions-event">
						<div class="col-md-2">
							<i class="fa fa-times" style="color: red;"></i> Misslyckad betalning
						</div>
						<div class="col-md-4 col-md-offset-2">
							Anv: xXPussyDestroyerXx
						</div>
						<div class="col-md-2 col-md-offset-1">
							Tid: 22:00
						</div>
					</div>
					<!-- Lyckad betalning --
					<div class="col-md-12 latest-actions-event">
						<div class="col-md-2">
							<i class="fa fa-check" style="color: green;"></i> Lyckad betalning
						</div>
						<div class="col-md-4 col-md-offset-2">
							Anv: xXPussyDestroyerXx
						</div>
						<div class="col-md-2 col-md-offset-1">
							Tid: 22:00
						</div>
					</div>
					<!-- Registrerad användare --
					<div class="col-md-12 latest-actions-event">
						<div class="col-md-2">
							<i class="fa fa-user-plus" style="color: green;"></i> Ny användare
						</div>
						<div class="col-md-4 col-md-offset-2">
							Anv: xXPussyDestroyerXx
						</div>
						<div class="col-md-2 col-md-offset-1">
							Tid: 22:00
						</div>
					</div>-->
				</div>
			</div>
<script>
jQuery(document).ready(function() {
  jQuery("abbr.timeago").timeago();
});
</script>
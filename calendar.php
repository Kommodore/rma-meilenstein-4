<?php
	$content = "";
	$currDate = time();

	if($_GET['month'] && $_GET['month'] >= 1 && $_GET['month'] <= 12 && is_numeric($_GET['month'])){
		$month = $_GET['month'];
	} else {
		$month = date('n', $currDate);
	}

	if($_GET['year'] && is_numeric($_GET['year'])){
		$year = $_GET['year'];
	} else {
		$year = date('Y', $currDate);
	}

	/* Create nav buttons */
	$prevMonth = $month-1;
	$prevMonthYear = $year;
	$nextMonth = $month+1;
	$nextMonthYear = $year;

	if($month == 12){
		$nextMonth = 1;
		$nextMonthYear = $year+1;
	}

	if($month == 1){
		$prevMonth = 12;
		$prevMonthYear = $year-1;
	}

	/* Create month table */
	$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	$firstDay = date('N', strtotime('1.'.$month.'.'.$year));
	if($days%7==0 && $firstDay == 0){
		$weeksInMonth = $days/7;
	} else {
		$weeksInMonth = ($days/7)+1;
	}
	$offset = 0;

	for($week = 1; $week <= $weeksInMonth; $week++){
		$content .= '<tr><td>'.$week.'</td>';
		for($day = 1; $day <= 7; $day++){
			if(date("j.n.o",$currDate) == date("j.n.o", strtotime(($day+(($week-1)*7)-$offset).'.'.$month.'.'.$year))){
				$itDate = ' style="background-color: yellow"';
			} else {
				$itDate = "";
			}

			if($day+(($week-1)*7)-$offset > $days){
				$content .= '<td></td>';
			} elseif($day+(($week-1)*7) < $firstDay){
				$content .= '<td></td>';
				$offset++;
			} else {
				$content .= '<td'.$itDate.'>'.($day+(($week-1)*7)-$offset).'</td>';
			}
		}
		$content .= '</tr>';
	}
	$content .= '</tr>';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Kalender</title>
		<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
	</head>
	<body>
		<main class="container">
			<h1>Kalender</h1>
			<h2><?=date("F",$currDate) ?></h2>
			<a href="calendar.php?month=1&year=<?= $year-1 ?>" class="btn btn-info btn-lg">Vorheriges Jahr</a>
			<a href="calendar.php?month=<?= $prevMonth ?>&year=<?= $prevMonthYear ?>" class="btn btn-info btn-lg">Vorheriger Monat</a>
			<a href="calendar.php" class="btn btn-info btn-lg">Aktueller Monat</a>
			<a href="calendar.php?month=<?= $nextMonth ?>&year=<?= $nextMonthYear ?>" class="btn btn-info btn-lg">Nächster Monat</a>
			<a href="calendar.php?month=1&year=<?= $year+1 ?>" class="btn btn-info btn-lg">Nächstes Jahr</a><br><br>
			<table class="table-bordered">
				<thead>
					<tr>
						<th>Woche</th>
						<th>Montag</th>
						<th>Dienstag</th>
						<th>Mittwoch</th>
						<th>Donnerstag</th>
						<th>Freitag</th>
						<th>Samstag</th>
						<th>Sonntag</th>
					</tr>
				</thead>
				<tbody>
				<?= $content ?>
				</tbody>
			</table>
		</main>
	</body>
</html>
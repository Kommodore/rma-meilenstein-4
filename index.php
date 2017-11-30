<?php
	include('CSVHandler.php');

	$csv = new CSVHandler('input.csv');
	if("POST" == $_SERVER['REQUEST_METHOD']){
		$csv->setContent(array($_POST['id'], $_POST['company_name'], $_POST['owner_name']));
		$csv->saveFile();
	}

	$thead = $content = "";
	$row = 1;
	$data = $csv->getContent();
	$head = $csv->getColumns();
	foreach($data as $entry){
		$row++;
		$content .= '<tr><td>'.$entry[0].'</td><td>'.$entry[1].'</td>
			<td>'.$entry[2].'</td><td><a href="edit.php?id='.$entry[0].'">Bearbeiten</a></td></tr>';
	}
	foreach($head as $entry){
		$thead .= '<td>'.$entry.'</td>';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CSV Auslesen</title>
		<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
	</head>
	<body>
		<main class="container-fluid col-xs-10"><br><br>
			<a href="form.php?id=<?= $row ?>" type="button" class="btn btn-info btn-lg col-xs-offset-1">Eintrag hinzufügen</a>
			<a href="pdf.php" type="button" class="btn btn-info btn-lg col-xs-offset-4">PDF erstellen</a><br><br>
			<table class="table-bordered col-xs-10 col-xs-offset-1">
				<thead><tr><?= $thead ?><th></th></tr></thead>
				<tbody><?= $content ?></tbody>
			</table>
		</main>
	</body>
</html>

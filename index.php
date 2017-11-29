<?php
	if("POST" == $_SERVER['REQUEST_METHOD']){
		$attrs = array($_POST['id'], $_POST['company_name'], $_POST['owner_name']);
		$file = fopen("input.csv","a+");

		fputcsv($file, $attrs);
		fclose($file);
	}

	$row = 0;
	$content = "";
	$thead = "";
	if (($handle = fopen("input.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if($row++ == 0){
				$num = count($data);
				$thead .= "<tr>";
				for ($c=0; $c < $num; $c++) {
					$thead .= "<th>".$data[$c] . "</th>";
				}
				$thead .= "<th></th></tr>";
			} else {
				$num = count($data);
				$content .= "<tr>";
				for ($c=0; $c < $num; $c++) {
					$content .= "<td>".$data[$c] . "</td>";
				}
				$content .= '<td><a href="edit.php?id='.$data[0].'">Bearbeiten</a></td></tr>';
			}
		}
		fclose($handle);
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
				<thead><?= $thead ?></thead>
				<tbody><?= $content ?></tbody>
			</table>
		</main>
	</body>
</html>

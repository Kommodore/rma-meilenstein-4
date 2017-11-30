<?php
	include('CSVHandler.php');
	$csv = new CSVHandler('input.csv');
	$company = $owner = $id = "";

	if("POST" == $_SERVER['REQUEST_METHOD']){
		if(isset($_POST['delete']) && isset($_POST['id']) && is_numeric($_POST['id'])){
			$csv->deleteContent(0, $_POST['id']);
		} else {
			$csv->setContent(array($_GET['id'], $_POST['company_name'], $_POST['owner_name']), true, 0, $_POST['id']);
		}
		$csv->saveFile();
		header("location: index.php");
	}

	$data = $csv->getContent();
	if($data){
		foreach($data as $entry){
			if($entry[0] == $_GET['id']){
				$company = $entry[1];
				$owner = $entry[2];
				$id = $entry[0];
			}
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Eintrag bearbeiten</title>
	<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<main class="container">
	<form action="" method="POST">
		<input type="hidden" value="<?= $id ?>" name="id">
		<label for="company_name">Name der Firma:</label>
		<input type="text" class="form-control" name="company_name" id="company_name" value="<?= $company ?>" required="required">
		<label for="owner_name">Name des Inhabers:</label>
		<input type="text" class="form-control" name="owner_name" id="owner_name" value="<?= $owner ?>" required="required">
		<label for="delete">Eintrag löschen:</label>
		<input type="checkbox" name="delete" id="delete">
		<input type="submit" value="Änderungen speichern" class="form-control">
	</form>
</main>
</body>
</html>
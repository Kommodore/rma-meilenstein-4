<?php
$company = $owner = "";

if("POST" == $_SERVER['REQUEST_METHOD']){
	if (($handle = fopen("input.csv", "r")) !== FALSE) {
		$output = array();
		while(($attrs = fgetcsv($handle, 1000, ",")) !== false){
			if($attrs[0] == $_GET['id']){
				$attrs[1] = $_POST['company_name'];
				$attrs[2] = $_POST['owner_name'];
			}
			if(isset($_POST['delete']) && $attrs[0] == $_GET['id']){
				//
			} else {
				$output[] = $attrs;
			}
		}

		fclose($handle);
		$file = fopen("input.csv","w+");
		foreach($output as $entry){
			fputcsv($file, $entry);
		}
		fclose($file);
	}
	header("location: index.php");
}

if (($handle = fopen("input.csv", "r")) !== FALSE) {
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		if($data[0] == $_GET['id']){
			$company = $data[1];
			$owner = $data[2];
		}
	}
	fclose($handle);
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
		<input type="hidden" value="<?= $_GET['id'] ?>" name="id">
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
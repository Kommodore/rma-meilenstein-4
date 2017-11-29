<!DOCTYPE html>
<html>
	<head>
		<title>Eintrag hinzufügen</title>
		<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
	</head>
	<body>
		<main class="container">
			<form action="index.php" method="POST">
				<input type="hidden" value="<?= $_GET['id'] ?>" name="id">
				<label for="company_name">Name der Firma:</label>
				<input type="text" class="form-control" name="company_name" id="company_name" required="required">
				<label for="owner_name">Name des Inhabers:</label>
				<input type="text" class="form-control" name="owner_name" id="owner_name" required="required">
				<input type="submit" value="Eintrag hinzufügen" class="form-control">
			</form>
		</main>
	</body>
</html>
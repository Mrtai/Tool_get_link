<!DOCTYPE html>
<html>
<head>
	<title>Tool lấy link</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<h1>Tool lấy link file</h1>
		<form action="xuly.php" method="post">
			<div class="form-group">
				<label for="name">Tên dự án: </label>
				<input type="name" name="name_web" class="form-control" id="name" aria-describedby="name web" placeholder="Enter name">
			</div>
			<div class="form-group">
				<label for="url">URL web: </label>
				<input type="url" name="url_web" class="form-control" id="url" aria-describedby="url web" placeholder="Enter URL">
			</div>
			<div class="form-group">
				<label for="name">Tên thư mục css: </label>
				<input type="name" name="name_css" class="form-control" id="name" aria-describedby="name css" placeholder="Enter name">
			</div>
			<div class="form-group">
				<label for="name">Tên thư mục js: </label>
				<input type="name" name="name_js" class="form-control" id="name" aria-describedby="name js" placeholder="Enter name">
			</div>
			<div class="form-group">
				<label for="name">Tên thư mục hình ảnh: </label>
				<input type="name" name="name_images" class="form-control" id="name" aria-describedby="name images" placeholder="Enter name">
			</div>
			<div class="form-group">
				<label for="name">Tên thư mục font: </label>
				<input type="name" name="name_font" class="form-control" id="name" aria-describedby="name font" placeholder="Enter name">
			</div>
			
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
</body>
</html>


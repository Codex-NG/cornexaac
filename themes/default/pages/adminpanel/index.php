
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="<?php echo assets('assets/css/bootstrap.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo assets('assets/css/styles.css'); ?>">
		<link rel="stylesheet" href="<?php echo assets('assets/css/font-awesome.css') ?>">
		<link rel="stylesheet" href="<?php echo assets('assets/css/summernote.css') ?>">
	</head>
	<body>

		<div class="container">
			<?php app()->getPage(); ?>
		</div>

		<script src="<?php echo assets('assets/js/jquery.min.js'); ?>"></script>
		<script src="<?php echo assets('assets/js/bootstrap.min.js'); ?>"></script>
		<script src="<?php echo assets('assets/js/summernote.min.js'); ?>"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#summernote-add-news').summernote();
			});
		</script>
	</body>
</html>


<div id="adminpanel-addnews">

	<?php include theme('pages/adminpanel/alerts.php'); ?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Add news</h3>
		</div>
		<div class="panel-body">

			<form method="POST">
				<?php echo app('formtoken')->getField(); ?>
				<label>Title:</label>
				<input type="text" class="form-control" name="add_news_title" id="news_title">

				<label>Post as:</label>
				<select name="add_news_post_as" class="form-control" id="news_title">
					<?php foreach (app('account')->characters() as $character): ?>
						<option value="<?php echo $character->id; ?>"><?php echo $character->getName(); ?></option>
					<?php endforeach; ?>
				</select>

				<textarea id="summernote-add-news" name="add_news_content"></textarea>

				<input type="submit" value="Submit news" class="btn btn-primary">
			</form>

		</div>
	</div>

</div>
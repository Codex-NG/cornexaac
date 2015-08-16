

<?php
	$offers = app('shop');

	if (isset($_GET['buy'])) {
		$product = $offers->find($_GET['buy']);
	}

	include theme('includes/alerts.php');
?>

<div id="subtopic-shop">

	<?php if (empty($_GET['buy'])): ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Shop offers</h3>
			</div>
			<div class="panel-body">
				<table class="table">
					<div class="alert alert-info">
						<?php if (isLoggedIn()): ?>
							You have <strong><?php echo app('AACAccount')->points(); ?> </strong> points to spend.
						<?php else: ?>
							Please <a href="<?php echo url('?subtopic=login&action=shop'); ?>">login</a> to see how much points you got.
						<?php endif; ?>
					</div>
					<?php foreach ($offers->getOffers() as $offer): ?>
						<tr>
							<td width="10%"><img class="img-thumbnail img-responsive" src="http://item-images.ots.me/960/<?php echo $offer->item_id ?>"></td>
							<td>
								<b><?php echo $offer->item_title ?></b><br>
								<?php echo $offer->item_description ?>
							</td>
							<td style="padding-top:15px;">
								<label class="label label-info"><?php echo $offer->points ?> points</label>
							</td>
							<td>
								<a href="<?php echo url('?subtopic=shop&buy='.$offer->id) ?>" class="btn btn-outlined btn-theme btn-sm" data-wow-delay="0.7s">Purchase Now</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	<?php endif; ?>

<?php if (isset($_GET['buy'])): ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Confirm order</h3>
		</div>
		<div class="panel-body">

			<?php if (! isLoggedIn()): ?>
				<div class="alert alert-info">Please <a href="<?php echo url('?subtopic=login&action=shop'); ?>">login</a> before you can proceed.</div>
			<?php else: ?>
			   <form method="POST">
					<?php echo app('formtoken')->getField(); ?>

					<label>Select a character</label>
					<select name="shop_buy_name" class="form-control" style="margin-bottom:10px;">
						<?php foreach (app('account')->characters() as $charater): ?>
							<option><?php echo $charater->getName() ?></option>
						<?php endforeach; ?>
					</select>

					<label>Or buy for a friend, enter a character name:</label>
					<input type="text" class="form-control" name="shop_buy_for" style="margin-bottom:10px;">

					<input type="hidden" name="product_id" value="<?php echo $product->id ?>">
					<img style="margin-right:5px;" class="img-thumbnail img-responsive" src="http://item-images.ots.me/960/<?php echo $product->item_id ?>">
					Are you sure you want to buy <b><?php echo $product->item_title; ?></b>
					<div class="pull-right">
						<input type="submit" style="margin-left:15px;" class="btn btn-outlined btn-theme btn-sm" data-wow-delay="0.7s" value="Yes, Buy now">
					</div>
			   </form>
			<?php endif; ?>
		</div>
	</div>

<?php endif; ?>

</div>
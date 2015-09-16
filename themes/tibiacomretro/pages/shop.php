

<?php
	$offers = app('shop');

	if (isset($_GET['buy'])) {
		$product = $offers->find($_GET['buy']);
	}

	include theme('includes/notifications.php');
?>

<?php if (empty($_GET['buy'])): ?>

	<?php if (isLoggedIn()): ?>
		<div class="success">
			<p>You have <strong><?php echo app('account')->getPoints(); ?> </strong> points to spend.</p>
		</div>
	<?php else: ?>
		<div class="errors">
			<ul style="list-style:none;">
				<li>Please <a href="<?php echo url('?subtopic=login&action=shop'); ?>">login</a> to see how much points you got.</li>
			</ul>
		</div>
	<?php endif; ?>

	<table>
		<tr class="header">
			<th colspan="4">Shop offers</th>
		</tr>

		<?php foreach ($offers->getOffers() as $offer): ?>
			<tr>
				<td width="6%"><img class="img-thumbnail img-responsive" src="http://item-images.ots.me/960/<?php echo $offer->item_id ?>"></td>
				<td width="70%"><b><?php echo $offer->item_title ?></b><br>
				<?php echo $offer->item_description ?>
				</td>
				<td><?php echo $offer->points ?> points</td>
				<td><a href="<?php echo url('?subtopic=shop&buy='.$offer->id) ?>" class="button">Purchase</a></td>
			</tr>
		<?php endforeach; ?>

	</table>
<?php endif; ?>

<div id="subtopic-shop">
	<?php if (isset($_GET['buy'])): ?>

		<?php if (! isLoggedIn()): ?>
			Please login before you proceed
		<?php else: ?>
			<form method="POST">
				<input type="hidden" name="product_id" value="<?php echo $product->id ?>">
				<table>
					<tr class="header">
						<th colspan="2">Confirm order</th>
					</tr>

					<tr>
						<td width="20%">Select a character</td>
						<td>
							<?php if ($characters = app('account')->characters()): ?>
								<select name="shop_buy_name">
									<?php foreach ($characters as $charater): ?>
										<option><?php echo $charater->getName() ?></option>
									<?php endforeach; ?>
								</select>
							<?php else: ?>
								<td>Please create a character before you </td>
							<?php endif; ?>
						</td>
					</tr>

					<tr>
						<td width="20%">Or buy for a friend:</td>
						<td>
							<input type="text" class="form-control" name="shop_buy_for">
						</td>
					</tr>

					<tr class="transparent noborderpadding">
			            <th></th>
			            <td>
			                <input type="submit" value="Submit" class="button">
			                <a href="#" class="button">Back</a>
			            </td>
			        </tr>
				</table>
			</form>
		<?php endif; ?>

	<?php endif; ?>
</div>

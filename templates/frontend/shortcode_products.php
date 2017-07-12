<?php
	
	if( empty( $products ) ){
		?>

			<ul class="wp-pushpress-cat">
				<li class="wp-pushpress-item-other">
					<strong>No product available</strong>
				</li>
			</ul>
		<?php
	}else{
		foreach ($products as $keyItem => $item) {
			$linkTo = str_replace('{subdomain}', $this->subdomain, PUSHPRESS_CLIENT) . 'product/purchase/';
			if ( $keyItem == 'preorder_categories_id' ){
				$linkTo = str_replace('{subdomain}', $this->subdomain, PUSHPRESS_CLIENT) . 'product/preorder/';
			}

			?>

			<ul class="wp-pushpress-cat">
				<li class="wp-pushpress-item-first">
					<h3><?php echo $item['category_name'];?></h3>
					<div class="clear"></div>
				</li>
			<?php
			foreach ($item['products'] as $key => $value) {
				$n = count( $value['price'] );
				?>

				<li class="wp-pushpress-item-other">
					<span class="wp-pushpress-name"><?php echo $value['name'];?></span>
					<span class="wp-pushpress-price">
						<?php
							if ($n>1) {
								echo "$" . number_format($value['price'][0], 2) . " - $" . number_format($value['price'][$n-1], 2);
							}else{
								echo "$" . number_format($value['price'][0], 2);
							}
						?>
					</span>
					<span class="wp-pushpress-id">
						<button data-href="<?php echo $linkTo . $key;?>" data-target="_blank">Buy</button>
					</span>
				</li>
				<?php	
			}
			?>

			</ul>
			<?php 
		}
	}


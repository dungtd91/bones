<?php

global $postID;

$db_product_infomation = get_field( 'db_product_infomation', $postID );
$db_product_detail     = get_field( 'db_product_detail', $postID );
$db_product_infomation_obj = get_field_object('db_product_infomation', $postID);
$db_product_detail_obj = get_field_object('db_product_detail', $postID);

?>

<?php if ( $db_product_infomation ): ?>
	<div class="product-meta">
		<h3 class="widget-title"><?php echo $db_product_infomation_obj['label'];?></h3>
		<?php echo $db_product_infomation; ?>
	</div>
<?php endif; ?>
<?php if ( $db_product_detail ): ?>
	<div class="product-detail">
		<h3 class="widget-title"><?php echo $db_product_detail_obj['label'];?></h3>
		<?php echo $db_product_detail; ?>
	</div>
<?php endif; ?>
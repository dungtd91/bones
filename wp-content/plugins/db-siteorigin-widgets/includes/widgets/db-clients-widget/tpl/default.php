<?php
/**
 * @var $clients
 */

?>

<?php $num_of_columns = intval($settings['per_line']); ?>

<?php $column_style = db_get_column_class($num_of_columns); ?>

<div class="db-clients db-container">

    <?php $column_count = 0; ?>

    <?php foreach ($clients as $client): ?>
        
        <?php $column_count%$num_of_columns == 0 ? ' db-last-row' : ''; ?>

        <div class="db-client <?php echo $column_style; ?> db-zero-margin">

            <?php echo wp_get_attachment_image($client['image'], 'full', false, array('class' => 'db-image full', 'alt' => $client['name'])); ?>

            <div class="db-client-name"><?php echo esc_html($client['name']); ?></div>

            <div class="db-image-overlay"></div>

        </div>

    <?php

    endforeach;

    ?>

</div>
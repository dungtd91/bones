<?php
/**
 * @var $style
 * @var $settings
 * @var $team_members
 */

?>

<?php $column_style = ''; ?>

<?php if ($style == 'style1'): ?>

    <?php $column_style = db_get_column_class(intval($settings['per_line'])); ?>

<?php endif; ?>

<div class="db-team-members db-<?php echo $style; ?> db-container">

    <?php foreach ($team_members as $team_member): ?>

        <div class="db-team-member-wrapper <?php echo $column_style; ?>">

            <div class="db-team-member">

                <div class="db-image-wrapper">

                    <?php echo wp_get_attachment_image($team_member['image'], 'full', false, array('class' => 'db-image full')); ?>

                    <?php if ($style == 'style1'): ?>

                        <?php include 'social-profile.php'; ?>

                    <?php endif; ?>

                </div>

                <div class="db-team-member-text">

                    <h3 class="db-title"><?php echo esc_html($team_member['name']) ?></h3>

                    <div class="db-team-member-position">

                        <?php echo esc_html($team_member['position']) ?>

                    </div>

                    <div class="db-team-member-details">

                        <?php echo wp_kses_post($team_member['details']) ?>

                    </div>

                    <?php if ($style == 'style2'): ?>

                        <?php include 'social-profile.php'; ?>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>
<?php

?>

<div class="db-social-wrap">

    <div class="db-social-list">

        <?php

        $social_profile = $team_member['social_profile'];

        $email = $social_profile['email'];
        $facebook_url = $social_profile['facebook'];
        $twitter_url = $social_profile['twitter'];
        $linkedin_url = $social_profile['linkedin'];
        $dribbble_url = $social_profile['dribbble'];
        $pinterest_url = $social_profile['pinterest'];
        $googleplus_url = $social_profile['google_plus'];
        $instagram_url = $social_profile['instagram'];


        if ($email)
            echo '<div class="db-social-list-item"><a class="db-email" href="mailto:' . $email . '" title="' . __("Contact Us", 'db-so-widgets') . '"><i class="db-icon-mail"></i></a></div>';
        if ($facebook_url)
            echo '<div class="db-social-list-item"><a class="db-facebook" href="' . $facebook_url . '" target="_blank" title="' . __("Follow on Facebook", 'db-so-widgets') . '"><i class="db-icon-facebook"></i></a></div>';
        if ($twitter_url)
            echo '<div class="db-social-list-item"><a class="db-twitter" href="' . $twitter_url . '" target="_blank" title="' . __("Subscribe to Twitter Feed", 'db-so-widgets') . '"><i class="db-icon-twitter"></i></a></div>';
        if ($linkedin_url)
            echo '<div class="db-social-list-item"><a class="db-linkedin" href="' . $linkedin_url . '" target="_blank" title="' . __("View LinkedIn Profile", 'db-so-widgets') . '"><i class="db-icon-linkedin"></i></a></div>';
        if ($googleplus_url)
            echo '<div class="db-social-list-item"><a class="db-googleplus" href="' . $googleplus_url . '" target="_blank" title="' . __("Follow on Google Plus", 'db-so-widgets') . '"><i class="db-icon-googleplus"></i></a></div>';
        if ($instagram_url)
            echo '<div class="db-social-list-item"><a class="db-instagram" href="' . $instagram_url . '" target="_blank" title="' . __("View Instagram Feed", 'db-so-widgets') . '"><i class="db-icon-instagram"></i></a></div>';
        if ($pinterest_url)
            echo '<div class="db-social-list-item"><a class="db-pinterest" href="' . $pinterest_url . '" target="_blank" title="' . __("Subscribe to Pinterest Feed", 'db-so-widgets') . '"><i class="db-icon-pinterest"></i></a></div>';
        if ($dribbble_url)
            echo '<div class="db-social-list-item"><a class="db-dribbble" href="' . $dribbble_url . '" target="_blank" title="' . __("View Dribbble Portfolio", 'db-so-widgets') . '"><i class="db-icon-dribbble"></i></a></div>';

        ?>

    </div>

</div>

<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="main-container">


<div class="banner">

    <div class="banner-content-body">
        <h3 class="banner-title"><?php echo esc_html($title); ?></h3>
        <p class="banner-desc"> <?php echo esc_html($description); ?></p>
        <a class="banner_link" href="<?php echo esc_url($link); ?>" target="_blank"><?php echo esc_html($link_text); ?></a>
        <p class="banner_sub-desc"> <?php echo esc_html($short_description); ?></p>

    </div>
    <div class="banner-content-image">
        <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($title); ?>">
    </div>
</div>
</div>

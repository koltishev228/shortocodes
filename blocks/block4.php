<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>

<div class="simple-content">
    <?php echo wp_kses_post($content); ?>
</div>

<?php if (!defined('ABSPATH')) exit; ?>
<div class="main-container">
    <div class="dropdown-container">
    <?php if (!empty($title_dropdown)): ?>
        <h3 class="dropdown-title-main"><?php echo esc_html($title_dropdown); ?></h3>
    <?php endif; ?>
<?php
foreach ($items as $item):
    list($title, $item_content) = array_pad(explode($delimiter, $item, 2), 2, '');
    ?>
    <div class="dropdown-item">
        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 24.8016H24V0.801582H0V24.8016Z" fill="#1F3651"/>
        </svg>

<div class="dropdown-item-info">
       <div class="dropdown-title"> <b><?php echo esc_html(trim($title)); ?></b></div>
        <div class="dropdown-content" style="display: none;">
            <?php echo wp_kses_post(trim($item_content)); ?>
        </div>
    </div>
    </div>
<?php endforeach; ?>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.dropdown-title').forEach(function(title) {
            title.addEventListener('click', function() {
                var content = this.nextElementSibling;
                content.style.display = content.style.display === 'block' ? 'none' : 'block';
            });
        });
    });
</script>

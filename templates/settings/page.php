<?php

// Render the settings template.
settings_errors( 'just_disable_it_messages' );
?>
<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
        <?php settings_fields( 'just_disable_it' ); ?>
        <?php do_settings_sections( 'just_disable_it' ); ?>
        <hr><br>
        <?php submit_button( 'Save' ); ?>
    </form>
</div>

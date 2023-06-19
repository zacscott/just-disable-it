<?php

$option_value = get_option( $args['option'] );
$checked      = ! empty( $option_value );

?>

<p>
    <input 
        id="<?php echo esc_attr( $args['option'] ); ?>"
        name="<?php echo esc_attr( $args['option'] ); ?>"
        type="checkbox"
        <?php echo esc_attr( $checked ); ?>>
</p>

<p class="description">
    <?php esc_html_e( 'Some description goes here.', 'just_disable_it' ); ?>
</p>

<?php

$option_value = get_option( $args['option'] );
$checked      = ! empty( $option_value ) ? 'checked' : '';

?>

<p>
    <input 
        id="<?php echo esc_attr( $args['option'] ); ?>"
        name="<?php echo esc_attr( $args['option'] ); ?>"
        type="checkbox"
        <?php echo esc_attr( $checked ); ?>>
</p>

<p class="description">
    <?php echo esc_html( $args['desc'] ); ?>
</p>

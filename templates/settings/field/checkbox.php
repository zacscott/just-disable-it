<?php

$model = \JustDisableIt\Model\SettingModel::get_instance();

$option_name = $model->get_option_name( $args['setting'] );

$option_value = $model->get_value( $args['setting'] );
$checked      = ! empty( $option_value ) ? 'checked' : '';

?>

<p>
    <input 
        id="<?php echo esc_attr( $option_name ); ?>"
        name="<?php echo esc_attr( $option_name ); ?>"
        type="checkbox"
        <?php echo esc_attr( $checked ); ?>>
    <label for="<?php echo esc_attr( $option_name ); ?>">
        <?php echo esc_html( $args['desc'] ); ?>
    </label>
</p>

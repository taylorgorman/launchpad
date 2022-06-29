<?php

function admin_field( $arguments ) {

	$v = wp_parse_args_deep( $arguments, [
		'id'          => '',
		'type'        => 'text',
		'label'       => '',
		'placeholder' => '',
		'value'       => '',
		'rows'        => 4,
		'required'    => false,
		'description' => '',
		'options'     => [], // label, value, checked
	] );

	// required settings
	if ( empty( $v['id'] ) )
		return;

	// attributes
	$type = ' type="'. $v['type'] .'"';
	$id = ' id="'. $v['id'] .'"';
	$name = ' name="'. $v['id'] .'"';
	$placeholder = $v['placeholder'] ? ' placeholder="'. $v['placeholder'] .'"' : '';
	$value = ' value="'. $v['value'] .'"';
	$rows = ' rows="'. $v['rows'] .'"';
	$aria_describedby = ' aria-describedby="'. $v['id'] .'-description"';
	$required = $v['required'] ? ' required' : '';
	$class = ' class="regular-text"';
	$label = $v['label'] ? '<label for="'. $v['id'] .'">'. $v['label'] .'</label>' : '';

	switch ( $v['type'] ) {
	case 'select':
	?>

		<?php echo $label; ?>
		<select <?php echo $id . $name . $aria_describedby . $required; ?>>
		<?php foreach ( $v['options'] as $value => $label ) { ?>
			<option <?php selected( $v['value'], $value ); ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>
		<?php } ?>
		</select>

	<?php
	break;
	case 'radio':
	case 'checkbox':

		$name = ' name="' . $v['id'] . ( $v['type'] === 'checkbox' && count( $v['options'] ) > 1 ? '[]' : '' ) . '"';

		foreach ( $v['options'] as $option ) {
			?>
			<label class="<?php echo esc_attr( $v['id'] ); ?>">
				<input <?php echo $type . $name . $option['checked']; ?> value="<?php echo $option['value']; ?>">
				<?php echo $option['label']; ?>
			</label>
			<?php
		}

	break;
	case 'textarea':
	?>

		<?php echo $label; ?>
		<textarea <?php echo $id . $name . $class . $aria_describedby . $placeholder . $value . $rows . $required; ?>></textarea>

	<?php
	break;
	default:
	?>

		<?php echo $label; ?>
		<input <?php echo $type . $id . $name . $class . $aria_describedby . $placeholder . $value . $required; ?>>

	<?php
	}

	if ( ! empty($v['description']) ) {
	?>
	<p class="description" id="<?php echo $v['id']; ?>-description"><?php echo $v['description']; ?></p>
	<?php
	}

}

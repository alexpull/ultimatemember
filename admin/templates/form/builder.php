<?php
	
	if ( !isset( $UM_Builder ) ){
		$UM_Builder = new UM_Admin_Builder();
		$UM_Builder->form_id = $this->form_id;
	}
	
?>

<div class="um-admin-builder" data-form_id="<?php echo $UM_Builder->form_id; ?>">

	<div class="um-admin-drag-ctrls-demo um-admin-drag-ctrls">
		
		<a href="#" class="active" data-modal="UM_preview_form" data-modal-size="normal" data-dynamic-content="um_admin_preview_form" data-arg1="<?php the_ID(); ?>" data-arg2=""><i class="um-icon-play"></i><?php _e('Live Preview','ultimatemember'); ?></a>
		
	</div>
	
	<div class="um-admin-clear"></div>
	
	<div class="um-admin-drag">
		
		<div class="um-admin-drag-ajax" data-form_id="<?php echo $UM_Builder->form_id; ?>">
		
			<?php $UM_Builder->show_builder( $UM_Builder->form_id ); ?>
			
		</div>
		
		<div class="um-admin-drag-addrow" data-row_action="add_row"><i class="um-icon-plus-add"></i></div>
	
	</div>

</div>
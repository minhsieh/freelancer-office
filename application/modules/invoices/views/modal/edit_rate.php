<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?=lang('edit_rate')?></h4>
		</div>
		<?php
			if (!empty($rate_info)) {
			foreach ($rate_info as $key => $r) { ?>

		<?php
			 $attributes = array('class' => 'bs-example form-horizontal');
          echo form_open(base_url().'invoices/tax_rates/edit',$attributes); ?>
          <input type="hidden" name="tax_rate_id" value="<?=$r->tax_rate_id?>">
		<div class="modal-body">
			 
          				<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('tax_rate_name')?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="text" class="form-control" required value="<?=$r->tax_rate_name?>" name="tax_rate_name">
				</div>
				</div>

				<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('tax_rate_percent')?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="text" class="form-control" required value="<?=$r->tax_rate_percent?>" name="tax_rate_percent">
				</div>
				</div>

				
				
			
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a> 
		<button type="submit" class="btn btn-primary"><?=lang('save_changes')?></button>
		</form>
		</div>
		<?php } } ?>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
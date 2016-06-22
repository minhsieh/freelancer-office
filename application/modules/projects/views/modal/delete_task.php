<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?=lang('delete_task')?></h4>
		</div><?php
			echo form_open(base_url().'projects/tasks/delete'); ?>
		<div class="modal-body">
			<p><?=lang('delete_task_warning')?></p>
			
			<input type="hidden" name="task_id" value="<?=$task_id?>">
			<input type="hidden" name="project" value="<?=$project?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-primary"><?=lang('delete_button')?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
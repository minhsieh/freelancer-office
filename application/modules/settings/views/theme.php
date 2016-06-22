<div class="row">
	<!-- Start Form -->
	<div class="col-lg-12">
		<?php
		$attributes = array('class' => 'bs-example form-horizontal');
		echo form_open_multipart('settings/update', $attributes); ?>
			<section class="panel panel-default">
				<header class="panel-heading font-bold"><i class="fa fa-cogs"></i> <?=lang('theme_settings')?></header>
				<div class="panel-body">
					<?php echo validation_errors(); ?>
					<input type="hidden" name="settings" value="<?=$load_setting?>">
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('site_name')?></label>
						<div class="col-lg-3">
							<input type="text" name="website_name" class="form-control" value="<?=config_item('website_name')?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('logo_or_icon')?></label>
						<div class="col-lg-3">
							<select name="logo_or_icon" class="form-control">
								<?php $logoicon = config_item('logo_or_icon'); ?>
								<option value="icon_title"<?=($logoicon == "icon_title" ? ' selected="selected"' : '')?>><?=lang('icon')?> & <?=lang('site_name')?></option>
								<option value="icon"<?=($logoicon == "icon" ? ' selected="selected"' : '')?>><?=lang('icon')?></option>
								<option value="logo_title"<?=($logoicon == "logo_title" ? ' selected="selected"' : '')?>><?=lang('logo')?> & <?=lang('site_name')?></option>
								<option value="logo"<?=($logoicon == "logo" ? ' selected="selected"' : '')?>><?=lang('logo')?></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('site_icon')?></label>
						<div class="col-lg-3">
							<input id="site-icon" type="text" name="site_icon" class="form-control" value="<?=config_item('site_icon')?>">
						</div>
						<div class="col-lg-3">
							<div id="icon-preview"><i class="fa <?=config_item('site_icon')?>"></i></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('company_logo')?></label>
						<div class="col-lg-3">
							<input type="file" class="filestyle" data-buttonText="<?=lang('choose_file')?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="logofile">
						</div>
						<div class="col-lg-6">
							<?php if (config_item('company_logo') != '') : ?>
							<div class="settings-image"><img src="<?=base_url()?>resource/images/<?=config_item('company_logo')?>" /></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('favicon')?></label>
						<div class="col-lg-3">
							<input type="file" class="filestyle" data-buttonText="<?=lang('choose_file')?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="iconfile">
						</div>
						<div class="col-lg-6">
							<?php if (config_item('site_favicon') != '') : ?>
							<div class="settings-image"><img src="<?=base_url()?>resource/images/<?=config_item('site_favicon')?>" /></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('apple_icon')?></label>
						<div class="col-lg-3">
							<input type="file" class="filestyle" data-buttonText="<?=lang('choose_file')?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="appleicon">
						</div>
						<div class="col-lg-6">
							<?php if (config_item('site_appleicon') != '') : ?>
							<div class="settings-image"><img src="<?=base_url()?>resource/images/<?=config_item('site_appleicon')?>" /></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('system_font')?> </label>
						<div class="col-lg-3">
							<?php $font = config_item('system_font'); ?>
							<select name="system_font" class="form-control">
								<option value="open_sans"<?=($font == "open_sans" ? ' selected="selected"' : '')?>>Open Sans</option>
								<option value="open_sans_condensed"<?=($font == "open_sans_condensed" ? ' selected="selected"' : '')?>>Open Sans Condensed</option>
								<option value="roboto"<?=($font == "roboto" ? ' selected="selected"' : '')?>>Roboto</option>
								<option value="roboto_condensed"<?=($font == "roboto_condensed" ? ' selected="selected"' : '')?>>Roboto Condensed</option>
								<option value="ubuntu"<?=($font == "ubuntu" ? ' selected="selected"' : '')?>>Ubuntu</option>
								<option value="lato"<?=($font == "lato" ? ' selected="selected"' : '')?>>Lato</option>
								<option value="oxygen"<?=($font == "oxygen" ? ' selected="selected"' : '')?>>Oxygen</option>
								<option value="pt_sans"<?=($font == "pt_sans" ? ' selected="selected"' : '')?>>PT Sans</option>
								<option value="source_sans"<?=($font == "source_sans" ? ' selected="selected"' : '')?>>Source Sans Pro</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('sidebar_theme')?></label>
						<div class="col-lg-3">
							<?php $theme = config_item('sidebar_theme'); ?>
							<select name="sidebar_theme" class="form-control">
								<option value="light lter"<?=($theme == "light lter" ? ' selected="selected"' : '')?>>Light</option>
								<option value="dark"<?=($theme == "dark" ? ' selected="selected"' : '')?>>Dark</option>
								<option value="black"<?=($theme == "black" ? ' selected="selected"' : '')?>>Black</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('login_title')?></label>
						<div class="col-lg-3">
							<input type="text" name="login_title" class="form-control" value="<?=config_item('login_title')?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('login_background')?></label>
						<div class="col-lg-3">
							<input type="file" class="filestyle" data-buttonText="<?=lang('choose_file')?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="loginbg">
						</div>
						<div class="col-lg-6">
							<?php if (config_item('login_bg') != '') : ?>
							<div class="settings-image"><img src="<?=base_url()?>resource/images/<?=config_item('login_bg')?>" /></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('hide_branding')?></label>
						<div class="col-lg-3">
							<label class="switch">
								<input type="hidden" value="off" name="hide_branding" />
								<input type="checkbox" <?php if(config_item('hide_branding') == 'TRUE'){ echo "checked=\"checked\""; } ?>  name="hide_branding"/>
								<span></span>
							</label>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="text-center">
						<button type="submit" class="btn btn-sm btn-primary"><?=lang('save_changes')?></button>
					</div>
				</div>
			</section>
		</form>
	</div>
	<!-- End Form -->
</div>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h4 class="modal-title"><?=lang('edit_company')?></h4>
        </div><?php
            echo form_open(base_url().'companies/update'); ?>
        <div class="modal-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="active" data-toggle="tab" href="#tab-client-general"><?=lang('general')?></a></li>
                        <li><a data-toggle="tab" href="#tab-client-contact"><?=lang('contact')?></a></li>
                        <li><a data-toggle="tab" href="#tab-client-web"><?=lang('web')?></a></li>
                        <li><a data-toggle="tab" href="#tab-client-bank"><?=lang('bank')?></a></li>
                        <li><a data-toggle="tab" href="#tab-client-hosting"><?=lang('hosting')?></a></li>
                    </ul>
                    <?php foreach ($client_details as $key => $i) : ?>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">
                            <input type="hidden" name="company_ref" value="<?=$i->company_ref?>">
                            <input type="hidden" name="co_id" value="<?=$i->co_id?>">
                            <div class="form-group">
                                    <label><?=lang('company_name')?> <span class="text-danger">*</span></label>
                                    <input type="text" name="company_name" value="<?=$i->company_name?>" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label><?=lang('company_email')?> <span class="text-danger">*</span></label>
                                    <input type="email" name="company_email" value="<?=$i->company_email?>" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label><?=lang('vat')?> </label>
                                    <input type="text" value="<?=$i->VAT?>" name="VAT" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label><?=lang('language')?></label>
                                <select name="language" class="form-control">
                                <?php foreach ($languages as $lang) : ?>
                                <option value="<?=$lang->name?>"<?=($i->language == $lang->name ? ' selected="selected"' : '')?>><?=  ucfirst($lang->name)?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <?php $currency = $this->applib->currencies($i->currency); ?>
                            <div class="form-group">
                                <label><?=lang('currency')?></label>
                                <select name="currency" class="form-control">
                                <?php foreach ($currencies as $cur) : ?>
                                <option value="<?=$cur->code?>"<?=($currency->code == $cur->code ? ' selected="selected"' : '')?>><?=$cur->name?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane fade in" id="tab-client-contact">
                            <div class="form-group col-md-6 no-gutter-left">
                                    <label><?=lang('phone')?> </label>
                                    <input type="text" value="<?=$i->company_phone?>" name="company_phone"  class="input-sm form-control">
                            </div>
                            <div class="form-group col-md-6 no-gutter-right">
                                    <label><?=lang('mobile_phone')?> </label>
                                    <input type="text" value="<?=$i->company_mobile?>" name="company_mobile"  class="input-sm form-control">
                            </div>
                            <div class="form-group col-md-6 no-gutter-left">
                                    <label><?=lang('fax')?> </label>
                                    <input type="text" value="<?=$i->company_fax?>" name="company_fax"  class="input-sm form-control">
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                    <label><?=lang('address')?></label>
                                    <textarea name="company_address" class="form-control"><?=$i->company_address?></textarea>
                            </div>
                            <div class="form-group col-md-6 no-gutter-left">
                                    <label><?=lang('city')?> </label>
                                    <input type="text" value="<?=$i->city?>" name="city" class="input-sm form-control">
                            </div>
                            <div class="form-group col-md-6 no-gutter-right">
                                    <label><?=lang('zip_code')?> </label>
                                    <input type="text" value="<?=$i->zip?>" name="zip" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                    <label><?=lang('country')?> </label>
                                    <select class="form-control" style="width:200px" name="country" >
                                            <optgroup label="<?=lang('selected_country')?>">
                                                    <option value="<?=$i->country?>"><?=$i->country?></option>
                                            </optgroup>
                                            <optgroup label="<?=lang('other_countries')?>">
                                                    <?php foreach ($countries as $country): ?>
                                                    <option value="<?=$country->value?>"><?=$country->value?></option>
                                                    <?php endforeach; ?>
                                            </optgroup>
                                    </select>
                            </div>
                        </div>
                        <div class="tab-pane fade in" id="tab-client-web">
                            <div class="form-group">
                                    <label><?=lang('website')?> </label>
                                    <input type="text" value="<?=$i->company_website?>" name="company_website"  class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                    <label>Skype</label>
                                    <input type="text" value="<?=$i->skype?>" name="skype"  class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                    <label>LinkedIn</label>
                                    <input type="text" value="<?=$i->linkedin?>" name="linkedin"  class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                    <label>Facebook</label>
                                    <input type="text" value="<?=$i->facebook?>" name="facebook"  class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                    <label>Twitter</label>
                                    <input type="text" value="<?=$i->twitter?>" name="twitter"  class="input-sm form-control">
                            </div>
                        </div>
                        <div class="tab-pane fade in" id="tab-client-bank">
                            <div class="form-group">
                                    <label><?=lang('bank')?> </label>
                                    <input type="text" value="<?=$i->bank?>" name="bank"  class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>SWIFT/BIC</label>
                                    <input type="text" value="<?=$i->bic?>" name="bic"  class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>Sort Code</label>
                                    <input type="text" value="<?=$i->sortcode?>" name="sortcode"  class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                    <label><?=lang('account_holder')?> </label>
                                    <input type="text" value="<?=$i->account_holder?>" name="account_holder"  class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                    <label><?=lang('account')?> </label>
                                    <input type="text" value="<?=$i->account?>" name="account"  class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                    <label>IBAN</label>
                                    <input type="text" value="<?=$i->iban?>" name="iban"  class="input-sm form-control">
                            </div>
                        </div>
                        
                        <div class="tab-pane fade in" id="tab-client-hosting">
                            <div class="form-group">
                                    <label><?=lang('hosting_company')?> </label>
                                    <input type="text" value="<?=$i->hosting_company?>" name="hosting_company" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                    <label><?=lang('hostname')?> </label>
                                    <input type="text" value="<?=$i->hostname?>" name="hostname" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                    <label><?=lang('account_username')?> </label>
                                    <input type="text" value="<?=$i->account_username?>" name="account_username" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                    <label><?=lang('account_password')?> </label>
                                    <input type="password" value="<?=$i->account_password?>" name="account_password" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                    <label><?=lang('port')?> </label>
                                    <input type="text" value="<?=$i->port?>" name="port" class="input-sm form-control">
                            </div>
                        </div>
                    </div>
            <?php endforeach; ?>
        </div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-info"><?=lang('save_changes')?></button>
		</form>
	</div>
</div>
</div>
<script type="text/javascript">
    $('.nav-tabs li a').first().tab('show');
</script>
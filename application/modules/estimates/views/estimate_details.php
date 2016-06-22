<?php $this->applib->set_locale(); ?>
<section id="content">
    <section class="hbox stretch">
        <?php
        $username = $this -> tank_auth -> get_username();
        ?>

        <aside>
            <section class="vbox">
                <header class="header bg-white b-b clearfix hidden-print">
                    <div class="row m-t-sm">
                        <div class="col-sm-8 m-b-xs">
                            <?php
                            if (!empty($estimate_details)) {
                            foreach ($estimate_details as $key => $estimate) { 
                                $l = $this->applib->company_details($estimate->client,'language'); ?>

                            <a data-original-title="<?=lang('print_estimate')?>" data-toggle="tooltip" data-placement="top" href="#" class="btn btn-sm btn-default" onClick="window.print();">
                                <i class="fa fa-print"></i> </a>

                            <?php if($role == '1' OR $this -> applib -> allowed_module('edit_estimates',$username)) { ?>
                                <a href="<?=base_url()?>estimates/items/insert/<?=$estimate->est_id?>" title="<?=lang('item_quick_add')?>" class="btn btn-sm btn-<?=config_item('button_color')?>" data-toggle="ajaxModal">
                                    <i class="fa fa-list-alt text-white"></i> <?=lang('items')?></a>

                                <a data-original-title="<?=lang('convert_to_invoice')?>" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success <?php if($estimate->invoiced == 'Yes' OR $estimate->client == '0'){ echo "disabled"; } ?>" href="<?=base_url()?>estimates/action/convert/<?=$estimate->est_id?>" data-toggle="ajaxModal"
                                   title="<?=lang('convert_to_invoice')?>">
                                    <?=lang('convert_to_invoice')?></a>


                                <?php if($estimate->show_client == 'Yes'){ ?>
                                <a class="btn btn-sm btn-success" href="<?=base_url()?>estimates/hide/<?=$estimate->est_id?>" title="<?=lang('hide_to_client')?>"><i class="fa fa-eye-slash"></i> <?=lang('hide_to_client')?>
                                    </a><?php }else{ ?>
                                    <a class="btn btn-sm btn-dark" href="<?=base_url()?>estimates/show/<?=$estimate->est_id?>" title="<?=lang('show_to_client')?>"><i class="fa fa-eye"></i> <?=lang('show_to_client')?>
                                    </a>
                                <?php } } ?>


                            <div class="btn-group">
                                <button class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
                                    <?=lang('more_actions')?>
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu">

                                    <?php if($role == '1' OR $this -> applib -> allowed_module('edit_estimates',$username)) { ?>
                                        <li><a href="<?=base_url()?>estimates/edit/<?=$estimate->est_id?>"><?=lang('edit_estimate')?></a></li>
                                        <li><a href="<?=base_url()?>estimates/email/<?=$estimate->est_id?>" data-toggle="ajaxModal"><?=lang('email_estimate')?></a></li>
                                        <li><a href="<?=base_url()?>estimates/timeline/<?=$estimate->est_id?>"><?=lang('estimate_history')?></a></li>
                                    <?php } ?>
                                    <li><a href="<?=base_url()?>estimates/action/status/declined/<?=$estimate->est_id?>"><?=lang('mark_as_declined')?></a></li>
                                    <li><a href="<?=base_url()?>estimates/action/status/accepted/<?=$estimate->est_id?>"><?=lang('mark_as_accepted')?></a></li>

                                    <?php if($role == '1' OR $this -> applib -> allowed_module('delete_estimates',$username)) { ?>
                                        <li class="divider"></li>
                                        <li><a href="<?=base_url()?>estimates/delete/<?=$estimate->est_id?>" data-toggle="ajaxModal"><?=lang('delete_estimate')?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>

                        </div>
                        <div class="col-sm-4 m-b-xs">
                            <?php
                            if ($estimate->client != 0) { ?>
                                <?php if (config_item('pdf_engine') == 'invoicr') : ?>
                                <a href="<?=base_url()?>fopdf/estimate/<?=$estimate->est_id?>" class="btn btn-sm btn-dark pull-right"><i class="fa fa-file-pdf-o"></i> <?=lang('pdf')?></a>
                                <?php elseif(config_item('pdf_engine') == 'mpdf') : ?>
                                <a href="<?=base_url()?>estimates/pdf/<?=$estimate->est_id?>" class="btn btn-sm btn-dark pull-right"><i class="fa fa-file-pdf-o"></i> <?=lang('pdf')?></a>
                                <?php endif; ?>
                            <?php } ?>

                        </div>
                    </div> </header>

                <!-- Start Display Details -->

                <section class="scrollable wrapper ie-details">
                    <!-- Start Display Details -->

                    <?php
                    if(!$this->session->flashdata('message')){
                        if(strtotime($estimate->due_date) < time() AND $estimate->status == 'Pending'){ ?>
                            <div class="alert alert-warning hidden-print">
                                <button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-warning"></i>
                                <?=lang('estimate_overdue')?>
                            </div>
                        <?php } } ?>

                    <section class="scrollable wrapper">
                        <div class="row">
                            <div class="col-xs-6">
                                <div style="height: <?=config_item('invoice_logo_height')?>px">
                                <img class="ie-logo" src="<?=base_url()?>resource/images/logos/<?=config_item('invoice_logo')?>" >
                                </div>
                            </div>
                            <div class="col-xs-6 text-right">
                                <p class="h4"><?=$estimate->reference_no?></p>
                                <div><?=lang('estimate_date')?><span class="col-xs-3 no-gutter-right pull-right"><strong><?=strftime(config_item('date_format'), strtotime($estimate->date_saved));?></strong></span></div>
                                <div><?=lang('valid_until')?><span class="col-xs-3 no-gutter-right pull-right"><strong><?=strftime(config_item('date_format'), strtotime($estimate->due_date));?></strong></span></div>
                                <div><?=lang('estimate_status')?><span class="col-xs-3 no-gutter-right pull-right"><span class="label bg-success"><?=$estimate->status?></span></span></div>
                            </div>
                        </div>


                        <div class="well m-t">
                            <div class="row">
                                <div class="col-xs-6">
                                    <strong><?=lang('received_from')?>:</strong>

                                    <h4><?=(config_item('company_legal_name_'.$l)) ? config_item('company_legal_name_'.$l) : config_item('company_legal_name')?></h4>
                                    <p>
                                                <span class="col-xs-3 no-gutter"><?= lang('address') ?>:</span>
                                                <span class="col-xs-9 no-gutter">
                                                    <?= (config_item('company_address_' . $l) ? config_item('company_address_' . $l) : config_item('company_address')) ?><br>
        <?= (config_item('company_city_' . $l) ? config_item('company_city_' . $l) : config_item('company_city')) ?>
        <?php if (config_item('company_zip_code_' . $l) != '' || config_item('company_zip_code') != '') : ?>
        , <?= (config_item('company_zip_code_' . $l) ? config_item('company_zip_code_' . $l) : config_item('company_zip_code')) ?>
        <?php endif; ?><br>
        <?= (config_item('company_country_' . $l) ? config_item('company_country_' . $l) : config_item('company_country')) ?>
                                                </span>

                                                <span class="col-xs-3 no-gutter"><?= lang('phone') ?>:</span>
                                                <span class="col-xs-9 no-gutter">
                                                    <a href="tel:<?= (config_item('company_phone_' . $l) ? config_item('company_phone_' . $l) : config_item('company_phone')) ?>">
                                                    <?= (config_item('company_phone_' . $l) ? config_item('company_phone_' . $l) : config_item('company_phone')) ?></a>
                                                    
        <?php if (config_item('company_phone_2_'.$l) != '' || config_item('company_phone_2') != '') : ?>
                                                        , <a href="tel:<?= (config_item('company_phone_2_' . $l) ? config_item('company_phone_2_' . $l) : config_item('company_phone_2')) ?>">
            <?= (config_item('company_phone_2_' . $l) ? config_item('company_phone_2_' . $l) : config_item('company_phone_2')) ?></a>
                                                    <?php endif; ?>
                                                </span>
                                                <span class="col-xs-3 no-gutter"><?= lang('fax') ?>:</span>
                                                <span class="col-xs-9 no-gutter">
                                                    <a href="tel:<?= (config_item('company_fax_' . $l) ? config_item('company_fax_' . $l) : config_item('company_fax')) ?>">
                                                    <?= (config_item('company_fax_' . $l) ? config_item('company_fax_' . $l) : config_item('company_fax')) ?></a>
                                                </span>

                                                <span class="col-xs-3 no-gutter"><?=lang('company_vat')?>:</span>
                                                <span class="col-xs-9 no-gutter">
        <?= (config_item('company_vat_' . $l) ? config_item('company_vat_' . $l) : config_item('company_vat')) ?><br>
                                                    <span>
                                    </p>
                                </div>
                                <div class="col-xs-6">
                                    <strong><?=lang('bill_to')?>:</strong>
                                    <h4><?=ucfirst($this->applib->company_details($estimate->client,'company_name'))?> <br></h4>
                                    <p>
                                    <span class="col-xs-3 no-gutter"><?= lang('address') ?>:</span>
                                    <span class="col-xs-9 no-gutter">
                                        <?= $this->applib->company_details($estimate->client, 'company_address') ?><br>
                                        <?= $this->applib->company_details($estimate->client, 'city') ?>
                                        <?php if ($this->applib->company_details($estimate->client, 'zip') != '') { echo ", ".$this->applib->company_details($estimate->client, 'zip');  } ?><br>
                                        <?= $this->applib->company_details($estimate->client, 'country') ?>
                                                                </span>
                                        <span class="col-xs-3 no-gutter"><?=lang('phone')?>:</span>
                                        <span class="col-xs-9 no-gutter"><a href="tel:<?= $this->applib->company_details($estimate->client, 'company_phone') ?>"><?=$this->applib->company_details($estimate->client,'company_phone')?></a></span>
                                        <?php if ($this->applib->company_details($estimate->client, 'company_fax') != '') : ?>
                                        <span class="col-xs-3 no-gutter"><?= lang('fax') ?>:</span>
                                        <span class="col-xs-9 no-gutter">
                                            <a href="tel:<?= $this->applib->company_details($estimate->client, 'company_fax') ?>"><?= ucfirst($this->applib->company_details($estimate->client, 'company_fax')) ?></a>&nbsp;
                                        </span>
                                        <?php endif; ?>
                                        <span class="col-xs-3 no-gutter"><?=lang('company_vat')?>:</span>
                                        <span class="col-xs-9 no-gutter"><?=$this->applib->company_details($estimate->client,'VAT')?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php $showtax = config_item('show_estimate_tax') == 'TRUE' ? TRUE : FALSE; ?>
                        <div class="line"></div>
                        <table class="table sorted_table" type="estimates"><thead>
                            <tr>
                                <th></th>
        <?php if ($showtax) : ?>
                                <th width="20%"><?= lang('item_name') ?> </th>
                                <th width="25%"><?= lang('description') ?> </th>
                                <th width="7%" class="text-right"><?= lang('qty') ?> </th>
                                <th width="7%" class="text-right"><?= lang('tax_rate') ?> </th>
                                <th width="12%" class="text-right"><?= lang('unit_price') ?> </th>
                                <th width="12%" class="text-right"><?= lang('tax') ?> </th>
                                <th width="12%" class="text-right"><?= lang('total') ?> </th>
        <?php else : ?>
                                <th width="25%"><?= lang('item_name') ?> </th>
                                <th width="35%"><?= lang('description') ?> </th>
                                <th width="7%" class="text-right"><?= lang('qty') ?> </th>
                                <th width="12%" class="text-right"><?= lang('unit_price') ?> </th>
                                <th width="12%" class="text-right"><?= lang('total') ?> </th>
                                                                <?php endif; ?>
                                <th class="text-right inv-actions"></th>
                            </tr> </thead> <tbody>
                            <?php
                            if (!empty($estimate_items)) {
                                foreach ($estimate_items as $key => $item) { ?>
                                    <tr class="sortable" data-name="<?=$item->item_name?>" data-id="<?=$item->item_id?>">
                                        <td class="drag-handle"><i class="fa fa-reorder"></i></td>
                                        <td>
                                            <?php
                                            $item_name = $item->item_name ? $item->item_name : $item->item_desc;
                                            if($role == '1' OR $this -> applib -> allowed_module('edit_estimates',$username)) { ?>
                                                <a class="text-info" href="<?=base_url()?>estimates/items/edit/<?=$item->item_id?>" data-toggle="ajaxModal"><?=$item_name?></a>
                                            <?php }else{ ?>
                                                <?=$item_name?>
                                            <?php } ?>
                                        </td>
                                        
                                        <td><?=nl2br($item->item_desc) ?></td>
                                        <td class="text-right"><?=$this->applib->fo_format_quantity($item->quantity)?></td>
                                        <?php if ($showtax) : ?>
                                        <td class="text-right"><?=$this->applib->fo_format_tax($item->item_tax_rate) ?>%</td>
                                        <?php endif; ?>
                                        <td class="text-right"><?=$this->applib->fo_format_currency($estimate->currency, $item->unit_cost)?></td>
                                        <?php if ($showtax) : ?>
                                        <td class="text-right"><?=$this->applib->fo_format_currency($estimate->currency, $item->item_tax_total)?></td>
                                        <?php endif; ?>
                                        <td class="text-right"><?=$this->applib->fo_format_currency($estimate->currency, $item->total_cost)?></td>
                                        <td>
                                            <?php if($role == '1' OR $this -> applib -> allowed_module('edit_estimates',$username)) { ?>
                                                <a class="hidden-print" href="<?=base_url()?>estimates/items/delete/<?=$item->item_id?>/<?=$item->estimate_id?>" data-toggle="ajaxModal"><i class="fa fa-trash-o text-danger"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } } ?>
                            <?php if($role == '1' OR $this -> applib -> allowed_module('edit_estimates',$username)) { ?>
                                <tr class="hidden-print">
                                    <?php
                                    $attributes = array('class' => 'bs-example form-horizontal');
                                    echo form_open(base_url().'estimates/items/add', $attributes); ?>
                                    <input type="hidden" name="estimate_id" value="<?=$estimate->est_id?>">
                                    <input type="hidden" name="item_order" value="<?=count($estimate_items)+1?>">
                                    <input id="hidden-item-name" type="hidden" name="item_name" value="<?=count($estimate_items)+1?>">
                                    <td></td>
                                    <td><input id="auto-item-name" data-scope="estimates" type="text" placeholder="<?=lang('item_name')?>" class="typeahead form-control"></td>
                                    <td><textarea id="auto-item-desc" rows="1" name="item_desc" placeholder="<?=lang('item_description')?>" class="form-control js-auto-size"></textarea></td>
                                    <td><input id="auto-quantity" type="text" name="quantity" placeholder="1" class="form-control"></td>
                                    <?php if ($showtax) : ?>
                                    <td>
                                        <select name="item_tax_rate" class="form-control m-b">
                                            <option value="0.00"><?=lang('none')?></option>
                                            <?php
                                            if (!empty($rates)) {
                                                foreach ($rates as $key => $tax) { ?>
                                                    <option value="<?=$tax->tax_rate_percent?>"<?= config_item('default_tax') == $tax->tax_rate_percent ? ' selected="selected"' : '' ?>><?=$tax->tax_rate_name?></option>
                                                <?php } } ?>
                                        </select>
                                    </td>
                                    <?php endif; ?>
                                    <td><input id="auto-unit-cost" type="text" name="unit_cost" required placeholder="50.56" class="form-control"></td>
                                    <?php if ($showtax) : ?>
                                    <td><input type="text" name="tax" placeholder="0.00" readonly="" class="form-control"></td>
                                    <?php endif; ?>
                                    <td></td>
                                    <td><button type="submit" class="btn btn-success"><i class="fa fa-check"></i> <?=lang('save')?></button></td>
                                    </form>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="<?= $showtax ? '7' : '5' ?>" class="text-right no-border"><strong><?=lang('sub_total')?></strong></td>
                                <td class="text-right"><?=$this->applib->fo_format_currency($estimate->currency, $this -> applib -> est_calculate('estimate_cost',$estimate->est_id))?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="<?= $showtax ? '7' : '5' ?>" class="text-right no-border">
                                    <strong><?=lang('tax')?> <?= $this->applib->fo_format_tax($estimate->tax) ?>%</strong></td>
                                <td class="text-right"><?=$this->applib->fo_format_currency($estimate->currency, $this -> applib -> est_calculate('tax',$estimate->est_id))?></td>
                                <td></td>
                            </tr>
                            <?php if($estimate->discount > 0){ ?>
                                <tr>
                                    <td colspan="<?= $showtax ? '7' : '5' ?>" class="text-right no-border">
                                        <strong><?=lang('discount')?> - <?= $this->applib->fo_format_tax($estimate->discount)?>%</strong></td>
                                    <td class="text-right"><?=$this->applib->fo_format_currency($estimate->currency, $this -> applib -> est_calculate('discount',$estimate->est_id))?></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="<?= $showtax ? '7' : '5' ?>" class="text-right no-border"><strong><?=lang('total')?></strong></td>
                                <td class="text-right"><?=$this->applib->fo_format_currency($estimate->currency, $this -> applib -> est_calculate('estimate_amount',$estimate->est_id))?></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </section>
                    <p><blockquote><?=$estimate->notes?></blockquote></p>
                </section>
                <?php } } ?>
                <!-- End display details -->






            </section>




    </section> </aside> </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
<!-- end -->
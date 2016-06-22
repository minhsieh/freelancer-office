<?php $this->applib->set_locale(); ?>
<section id="content">
    <section class="hbox stretch">
        <?php $username = $this->tank_auth->get_username(); ?>
        <aside>
            <section class="vbox">
                <header class="header bg-white b-b clearfix hidden-print">
                    <div class="row m-t-sm">
                        <div class="col-sm-8 m-b-xs">
                            <?php
                            if (!empty($invoice_details)) {
                            foreach ($invoice_details as $key => $inv) {?>
                            <a href="#" class="btn btn-sm btn-default" onClick="window.print();">
                                <i class="fa fa-print"></i>
                            </a>
                            <?php if ($role == '1' OR $this->applib->allowed_module('edit_all_invoices', $username)) { ?>
                            <a href="<?= base_url() ?>invoices/items/insert/<?= $inv->inv_id ?>" title="<?= lang('item_quick_add') ?>" class="btn btn-sm btn-<?= config_item('button_color') ?>" data-toggle="ajaxModal">
                            <i class="fa fa-list-alt text-white"></i> <?= lang('items') ?></a>
                            <?php if ($inv->show_client == 'Yes') { ?>
                            <a class="btn btn-sm btn-success" href="<?= base_url() ?>invoices/hide/<?= $inv->inv_id ?>" title="<?= lang('hide_to_client') ?>"><i class="fa fa-eye-slash"></i> <?= lang('hide_to_client') ?>
                            </a><?php } else { ?>
                            <a class="btn btn-sm btn-dark" href="<?= base_url() ?>invoices/show/<?= $inv->inv_id ?>" title="<?= lang('show_to_client') ?>"><i class="fa fa-eye"></i> <?= lang('show_to_client') ?>
                            </a><?php } ?>
                            <?php } ?>
                            
                            <?php if ($this->applib->get_payment_status($inv->inv_id) != 'fully_paid') : ?>
                            
                            <?php if ($role == '1' OR $this->applib->allowed_module('pay_invoice_offline', $username)) { ?>
                            <?php if ($this->user_profile->invoice_payable($inv->inv_id) > 0) { ?>
                            <a class="btn btn-sm btn-<?= config_item('button_color') ?>" href="<?= base_url() ?>invoices/pay/<?= $inv->inv_id ?>"
                                title="<?= lang('add_payment') ?>"><i class="fa fa-credit-card"></i> <?= lang('pay_invoice') ?>
                            </a>
                            <?php }
                            } else {
                            if ($inv->allow_paypal == 'Yes') {
                            ?>
                            <a class="btn btn-sm btn-success" href="<?= base_url() ?>paypal/pay/<?= $inv->inv_id ?>" data-toggle="ajaxModal"
                            title="<?= lang('via_paypal') ?>"><?= lang('via_paypal') ?></a>
                            <?php }
                            if ($inv->allow_2checkout == 'Yes') {
                            ?>
                            <a class="btn btn-sm btn-success" href="<?= base_url() ?>checkout/pay/<?= $inv->inv_id ?>" data-toggle="ajaxModal" title="<?= lang('via_2checkout') ?>"><?= lang('via_2checkout') ?></a>
                            <?php } if ($inv->allow_stripe == 'Yes') { ?>
                            <!-- <a class="btn btn-sm btn-success" href="<?= base_url() ?>stripepay/pay/<?= $inv->inv_id ?>" data-toggle="ajaxModal" title="<?= lang('via_stripe') ?>"><?= lang('via_stripe') ?></a> -->
                            
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
                            <script src="https://checkout.stripe.com/checkout.js"></script>


                            <button id="customButton" class="btn btn-sm btn-success" ><?=lang('via_stripe')?></button>


                            <?php } if ($inv->allow_bitcoin == 'Yes') { ?>
                            <a class="btn btn-sm btn-success" href="<?= base_url() ?>bitcoin/pay/<?= $inv->inv_id ?>" data-toggle="ajaxModal" title="<?= lang('via_bitcoin') ?>"><?= lang('via_bitcoin') ?></a>
                            <?php }
                            } ?>
                            <?php endif; ?>
                            
                            <div class="btn-group">
                                <button class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
                                <?= lang('more_actions') ?>
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <?php if ($this->applib->invoice_payable($inv->inv_id) > 0) { ?>
                                    <?php if ($role == '1' OR $this->applib->allowed_module('email_invoices', $username)) { ?>
                                    <li>
                                        <a href="<?= base_url() ?>invoices/email/<?= $inv->inv_id ?>" data-toggle="ajaxModal" title="<?= lang('email_invoice') ?>"><?= lang('email_invoice') ?></a>
                                    </li>
                                    <?php } if ($role == '1' OR $this->applib->allowed_module('send_email_reminders', $username)) { ?>
                                    <li>
                                        <a href="<?= base_url() ?>invoices/remind/<?= $inv->inv_id ?>" data-toggle="ajaxModal" title="<?= lang('send_reminder') ?>"><?= lang('send_reminder') ?></a>
                                    </li>
                                    <?php } ?>
                                    <li><a href="<?= base_url() ?>invoices/timeline/<?= $inv->inv_id ?>"><?= lang('invoice_history') ?></a></li>
                                    <?php } ?>
                                    <?php if ($role == '1' OR $this->applib->allowed_module('edit_all_invoices', $username)) { ?>
                                    <li class="divider"></li>
                                    <li><a href="<?= base_url() ?>invoices/edit/<?= $inv->inv_id ?>"><?= lang('edit_invoice') ?></a></li>
                                    <?php } ?>
                                    <?php if ($role == '1' OR $this->applib->allowed_module('delete_invoices', $username)) { ?>
                                    <li><a href="<?= base_url() ?>invoices/delete/<?= $inv->inv_id ?>" data-toggle="ajaxModal"><?= lang('delete_invoice') ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php if ($role == '1' AND $inv->recurring == 'Yes' OR $this->applib->allowed_module('edit_all_invoices', $username)) { ?>
                            <a class="btn btn-sm btn-warning" href="<?= base_url() ?>invoices/stop_recur/<?= $inv->inv_id ?>"
                                title="<?= lang('stop_recurring') ?>" data-toggle="ajaxModal"><i class="fa fa-retweet"></i> <?= lang('stop_recurring') ?>
                            </a>
                            <?php } ?>
                        </div>
                        <div class="col-sm-3 m-b-xs pull-right">
                            <?php if (config_item('pdf_engine') == 'invoicr') : ?>
                            <a href="<?= base_url() ?>fopdf/invoice/<?= $inv->inv_id ?>" class="btn btn-sm btn-dark pull-right"><i class="fa fa-file-pdf-o"></i> <?= lang('pdf') ?></a>
                            <?php elseif (config_item('pdf_engine') == 'mpdf') : ?>
                            <a href="<?= base_url() ?>invoices/pdf/<?= $inv->inv_id ?>" class="btn btn-sm btn-dark pull-right"><i class="fa fa-file-pdf-o"></i> <?= lang('pdf') ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </header>
                <section class="scrollable wrapper ie-details">
                    <!-- Start Display Details -->
                    <?php
                    if (!$this->session->flashdata('message')) {
                    if (strtotime($inv->due_date) < time() AND $payment_status != lang('fully_paid')) {
                    ?>
                    <div class="alert alert-warning hidden-print">
                        <button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-warning"></i>
                        <?= lang('invoice_overdue') ?>
                    </div>
                    <?php }
                    } ?>
                    <section class="scrollable wrapper">
                        <div class="row">
                            <div class="col-xs-6">
                                <div style="height: <?=config_item('invoice_logo_height')?>px">
                                    <img class="ie-logo" src="<?= base_url() ?>resource/images/logos/<?= config_item('invoice_logo') ?>" >
                                </div>
                            </div>
                            <div class="col-xs-6 text-right">
                                <p class="h4"><?= $inv->reference_no ?>
                                    <?php if ($inv->recurring == 'Yes') { ?>
                                    <span class="label bg-danger"><i class="fa fa-retweet"></i> <?= $inv->recur_frequency ?> </span>
                                    <?php } ?>
                                </p>
                                <div><?= lang('invoice_date') ?><span class="col-xs-3 no-gutter-right pull-right"><strong><?= strftime(config_item('date_format'), strtotime($inv->date_saved)); ?></strong></span>
                            </div>
                            <div><?= lang('payment_due') ?><span class="col-xs-3 no-gutter-right pull-right"><strong><?= strftime(config_item('date_format'), strtotime($inv->due_date)); ?></strong></span>
                        </div>
                        <div><?= lang('payment_status') ?><span class="col-xs-3 no-gutter-right pull-right"><span class="label bg-success"><?= $payment_status ?></span></span>
                    </div>
                </div>
            </div>
            <div class="well m-t">
                <div class="row">
                    <div class="col-xs-6">
                        <strong><?= lang('received_from') ?>:</strong>
                        <?php $l = $this->applib->company_details($inv->client, 'language'); ?>
                        <h4><?= (config_item('company_legal_name_' . $l) ? config_item('company_legal_name_' . $l) : config_item('company_legal_name')) ?></h4>
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
                                <strong><?= lang('bill_to') ?>:</strong>
                                <h4><?= $this->applib->company_details($inv->client, 'company_name') ?> <br></h4>
                                <p>
                                    <span class="col-xs-3 no-gutter"><?= lang('address') ?>:</span>
                                    <span class="col-xs-9 no-gutter">
                                        <?= $this->applib->company_details($inv->client, 'company_address') ?><br>
                                        <?= $this->applib->company_details($inv->client, 'city') ?>
                                        <?php if ($this->applib->company_details($inv->client, 'zip') != '') { echo ", ".$this->applib->company_details($inv->client, 'zip');  } ?><br>
                                        <?= $this->applib->company_details($inv->client, 'country') ?>
                                    </span>
                                    <span class="col-xs-3 no-gutter"><?= lang('phone') ?>:</span>
                                    <span class="col-xs-9 no-gutter">
                                        <a href="tel:<?= $this->applib->company_details($inv->client, 'company_phone') ?>"><?= ucfirst($this->applib->company_details($inv->client, 'company_phone')) ?></a>&nbsp;
                                    </span>
                                    <?php if ($this->applib->company_details($inv->client, 'company_fax') != '') : ?>
                                    <span class="col-xs-3 no-gutter"><?= lang('fax') ?>:</span>
                                    <span class="col-xs-9 no-gutter">
                                        <a href="tel:<?= $this->applib->company_details($inv->client, 'company_fax') ?>"><?= ucfirst($this->applib->company_details($inv->client, 'company_fax')) ?></a>&nbsp;
                                    </span>
                                    <?php endif; ?>
                                    <span class="col-xs-3 no-gutter"><?= lang('company_vat') ?>:</span>
                                    <span class="col-xs-9 no-gutter"><?= $this->applib->company_details($inv->client, 'VAT') ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php $showtax = config_item('show_invoice_tax') == 'TRUE' ? TRUE : FALSE; ?>
                    <div class="line"></div>
                    <table id="inv-details" class="table sorted_table" type="invoices"><thead>
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
                        if (!empty($invoice_items)) {
                        foreach ($invoice_items as $key => $item) {
                        $item_name = $item->item_name ? $item->item_name : $item->item_desc;
                        ?>
                        <tr class="sortable" data-name="<?= $item_name ?>" data-id="<?= $item->item_id ?>">
                            <td class="drag-handle"><i class="fa fa-reorder"></i></td>
                            <td>
                                <?php if ($role == '1' OR $this->applib->allowed_module('edit_all_invoices', $username)) { ?>
                                <a class="text-info" href="<?= base_url() ?>invoices/items/edit/<?= $item->item_id ?>" data-toggle="ajaxModal"><?= $item_name ?></a>
                                <?php } else { ?>
                                <?= $item_name ?>
                                <?php } ?>
                            </td>
                            <td><small class="small text-muted"><?= nl2br($item->item_desc) ?></small> </td>
                            <td class="text-right"><?=$this->applib->fo_format_quantity($item->quantity) ?></td>
                            <?php if ($showtax) : ?>
                            <td class="text-right"><?=$this->applib->fo_format_tax($item->item_tax_rate) ?>%</td>
                            <?php endif; ?>
                            <td class="text-right"><?=$this->applib->fo_format_currency($inv->currency, $item->unit_cost) ?></td>
                            <?php if ($showtax) : ?>
                            <td class="text-right"><?=$this->applib->fo_format_currency($inv->currency, $item->item_tax_total) ?></td>
                            <?php endif; ?>
                            <td class="text-right"><?=$this->applib->fo_format_currency($inv->currency, $item->total_cost) ?></td>
                            <td>
                                <?php if ($role == '1' OR $this->applib->allowed_module('edit_all_invoices', $username)) { ?>
                                <a class="hidden-print" href="<?= base_url() ?>invoices/items/delete/<?= $item->item_id ?>/<?= $item->invoice_id ?>" data-toggle="ajaxModal"><i class="fa fa-trash-o text-danger"></i></a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php }
                        } ?>
                        <?php if ($role == '1' OR $this->applib->allowed_module('edit_all_invoices', $username)) { ?>
                        <?php if ($inv->status != 'Paid') { ?>
                        <tr class="hidden-print">
                            <?php
                            $attributes = array('class' => 'bs-example form-horizontal');
                            echo form_open(base_url() . 'invoices/items/add', $attributes);
                            ?>
                            <input type="hidden" name="invoice_id" value="<?= $inv->inv_id ?>">
                            <input type="hidden" name="item_order" value="<?= count($invoice_items) + 1 ?>">
                            <input id="hidden-item-name" type="hidden" name="item_name">
                            <td></td>
                            <td><input id="auto-item-name" data-scope="invoices" type="text" placeholder="<?= lang('item_name') ?>" class="typeahead form-control"></td>
                            <td><textarea id="auto-item-desc" rows="1" name="item_desc" placeholder="<?= lang('item_description') ?>" class="form-control js-auto-size"></textarea></td>
                            <td><input id="auto-quantity" type="text" name="quantity" placeholder="1" class="form-control"></td>
                            <?php if ($showtax) : ?>
                            <td>
                                <select name="item_tax_rate" class="form-control m-b">
                                    <option value="0.00"><?= lang('none') ?></option>
                                    <?php
                                    if (!empty($rates)) {
                                    foreach ($rates as $key => $tax) {
                                    ?>
                                    <option value="<?= $tax->tax_rate_percent ?>"<?= config_item('default_tax') == $tax->tax_rate_percent ? ' selected="selected"' : '' ?>><?= $tax->tax_rate_name ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </td>
                            <?php endif; ?>
                            <td><input id="auto-unit-cost" type="text" name="unit_cost" required placeholder="50.56" class="form-control"></td>
                            <?php if ($showtax) : ?>
                            <td><input type="text" name="tax" placeholder="0.00" readonly="" class="form-control"></td>
                            <?php endif; ?>
                            <td></td>
                            <td><button type="submit" class="btn btn-success"><i class="fa fa-check"></i> <?= lang('save') ?></button></td>
                        </form>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <tr>
                        <td colspan="<?= $showtax ? '7' : '5' ?>" class="text-right no-border"><strong><?= lang('sub_total') ?></strong></td>
                        <td class="text-right"><?=$this->applib->fo_format_currency($inv->currency, $this->applib->calculate('invoice_cost', $inv->inv_id)) ?></td>
                        <td></td>
                    </tr>
                    <?php if ($inv->tax > 0.00): ?>
                    <tr>
                        <td colspan="<?= $showtax ? '7' : '5' ?>" class="text-right no-border">
                        <strong><?= lang('tax') ?> <?=$this->applib->fo_format_tax($inv->tax)?>%</strong></td>
                        <td class="text-right"><?=$this->applib->fo_format_currency($inv->currency, $this->applib->calculate('tax', $inv->inv_id))?></td>
                        <td></td>
                    </tr>
                    <?php endif ?>
                    <?php if ($inv->discount > 0) { ?>
                    <tr>
                        <td colspan="<?= $showtax ? '7' : '5' ?>" class="text-right no-border">
                        <strong><?= lang('discount') ?> - <?php echo $inv->discount; ?>%</strong></td>
                        <td class="text-right"><?=$this->applib->fo_format_currency($inv->currency, $this->applib->calculate('discount', $inv->inv_id)) ?></td>
                        <td></td>
                    </tr>
                    <?php
                    }
                    $payment_made = $this->applib->calculate('paid_amount', $inv->inv_id);
                    if ($payment_made > 0.00) {
                    ?>
                    <tr>
                        <td colspan="<?= $showtax ? '7' : '5' ?>" class="text-right no-border"><strong><?= lang('payment_made') ?></strong></td>
                        <td class="text-right"><?=$this->applib->fo_format_currency($inv->currency, $payment_made)?></td>
                        <td></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="<?= $showtax ? '7' : '5' ?>" class="text-right no-border"><strong><?= lang('total') ?></strong></td>
                        <td class="text-right"><?=$this->applib->fo_format_currency($inv->currency, $this->applib->calculate('invoice_due', $inv->inv_id)) ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </section>
        <p><blockquote><?= $inv->notes ?></blockquote></p>
        <!-- START STRIPE PAYMENT -->
        <script>
        var handler = StripeCheckout.configure({
        key: '<?=config_item('stripe_public_key')?>',
        image: '<?=base_url()?>resource/images/<?=config_item('company_logo')?>',
        token: function(token) {
        // Use the token to create the charge with a server-side script.
        // You can access the token ID with `token.id`
        $("#stripeToken").val(token.id);
        $("#stripeEmail").val(token.email);
        $("#stripeForm").submit();
        
        
        
        }
        });
        $('#customButton').on('click', function(e) {
        // Open Checkout with further options
        handler.open({
        name: '<?=config_item('company_name')?>',
        description: 'INV REF: #<?=$inv->reference_no?> (<?=$inv->currency?><?=$this->applib->calculate('invoice_due', $inv->inv_id)?>)',
        amount: '<?=$this->applib->calculate('invoice_due', $inv->inv_id)*100?>',
        currency: '<?=$inv->currency?>'
        });
        e.preventDefault();
        });
        // Close Checkout on page navigation
        $(window).on('popstate', function() {
        handler.close();
        });
        </script>
        <form id="stripeForm" action="<?=base_url()?>stripepay/authenticate" method="POST">
            <input type="hidden" id="stripeToken" name="stripeToken"/>
            <input type="hidden" id="stripeEmail" name="stripeEmail"/>
            <input type="hidden" name="invoice" value="<?=$inv->inv_id?>"/>
            <input type="hidden" name="ref" value="<?=$inv->reference_no?>"/>
            <input type="hidden" name="amount" value="<?=$this->applib->calculate('invoice_due', $inv->inv_id)?>"/>
        </form>


        <!-- END STRIPE CHECKOUT -->
        <?php }
        } ?>
        <!-- End display details -->
    </section>
</section>
</aside>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
<!-- end -->
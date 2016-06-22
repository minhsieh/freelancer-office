<?php $this->applib->set_locale(); ?>
<section id="content">
  <section class="hbox stretch">
    <aside>
      <section class="vbox">
        <section class="scrollable wrapper w-f">
          <section class="panel panel-default">
            <header class="panel-heading"><?=lang('all_invoices')?>
              <?php
              $username = $this -> tank_auth -> get_username();
              if($role == '1' OR $this -> applib -> allowed_module('add_invoices',$username)) { ?>
              <a href="<?=base_url()?>invoices/add" class="btn btn-xs btn-primary pull-right"><?=lang('create_invoice')?></a>
              <?php } ?>
            </header>
            <div class="table-responsive">
              <table id="table-invoices" class="table table-striped b-t b-light AppendDataTables">
                <thead>
                  <tr>
                  <th class="col-options no-sort col-sm-1"><?=lang('options')?></th>
                    <th class="col-sm-1"><?=lang('invoice')?></th>
                    <th class="col-sm-3"><?=lang('client_name')?></th>
                    <th class="col-sm-1"><?=lang('status')?></th>
                    <th class="col-date col-sm-2"><?=lang('due_date')?></th>
                    <th class="col-currency col-sm-2"><?=lang('amount')?></th>
                    <th class="col-currency col-sm-2"><?=lang('due_amount')?></th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($invoices)) {
                                foreach ($invoices as $key => $invoice) {

                              if ($this-> applib ->payment_status($invoice->inv_id) == lang('fully_paid') OR $invoice->status == 'Paid'){ 
                                $invoice_status = lang('fully_paid');
                                $label = "success"; 
                              }elseif($invoice->emailed == 'Yes') { 
                                $invoice_status = lang('sent'); 
                                $label = "info"; 
                              }else{ 
                                $invoice_status = lang('draft'); 
                                $label = "default"; 
                              }
                  ?>
                  <tr>

                  <td>
                      <div class="btn-group">
                        <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                         <?=lang('options')?>
                        <span class="caret"></span>
                        </button>
                        
                        <ul class="dropdown-menu">
                          <li><a href="<?=base_url()?>invoices/view/<?=$invoice->inv_id?>"><?=lang('preview_invoice')?></a></li>
                          <?php if($role == '1' OR $this -> applib -> allowed_module('edit_all_invoices',$username)) { ?>
                          <li><a href="<?=base_url()?>invoices/edit/<?=$invoice->inv_id?>"><?=lang('edit_invoice')?></a></li>
                          <?php } ?>
                          <?php if($role == '1' OR $this -> applib -> allowed_module('email_invoices',$username)) { ?>
                          <li><a href="<?=base_url()?>invoices/timeline/<?=$invoice->inv_id?>"><?=lang('invoice_history')?></a></li>
                          <li><a href="<?=base_url()?>invoices/email/<?=$invoice->inv_id?>" data-toggle="ajaxModal" title="<?=lang('email_invoice')?>"><?=lang('email_invoice')?></a></li>
                          <?php } ?>
                          <?php if($role == '1' OR $this -> applib -> allowed_module('send_email_reminders',$username)) { ?>
                          <li><a href="<?=base_url()?>invoices/remind/<?=$invoice->inv_id?>" data-toggle="ajaxModal" title="<?=lang('send_reminder')?>"><?=lang('send_reminder')?></a></li>
                          <?php } ?>
                        <?php if(config_item('pdf_engine') == 'invoicr') : ?>
                                <li><a href="<?=base_url()?>fopdf/invoice/<?=$invoice->inv_id?>"><?=lang('pdf')?></a></li>
                        <?php elseif(config_item('pdf_engine') == 'mpdf') : ?>
                                <li><a href="<?=base_url()?>invoices/pdf/<?=$invoice->inv_id?>"><?=lang('pdf')?></a></li>
                        <?php endif; ?>
                        </ul>
                      </div>
                    </td>
                    <td><a class="text-info" href="<?=base_url()?>invoices/view/<?=$invoice->inv_id?>"><?=$invoice->reference_no?></a></td>
                    <td><?=Applib::get_table_field(Applib::$companies_table,array('co_id'=>$invoice->client),'company_name')?></td>
                    <td class="small"><span class="label label-<?=$label?>"><?=$invoice_status?></span>
                      <?php if ($invoice->recurring == 'Yes') { ?>
                      <span class="label label-primary"><i class="fa fa-retweet"></i></span>
                      <?php }  ?>
                      <?php 
                      $pstatus = $this-> applib ->payment_status($invoice->inv_id);
                      if ($invoice->emailed == 'Yes' && $pstatus != lang('fully_paid')) { 
                        $label = "warning";
                        if ($pstatus == lang('not_paid')) { $label = "danger"; }
                      ?>
                      <span class="label label-<?=$label?>"><?=$pstatus?></span>
                      <?php }  ?>
                      
                    </td>
                    <td><?=strftime(config_item('date_format'), strtotime($invoice->due_date))?></td>
                    <td class="col-currency"><?=$this->applib->fo_format_currency($invoice->currency, $this -> applib -> calculate('invoice_cost',$invoice->inv_id))?></td>
                    <td class="col-currency"><?=$this->applib->fo_format_currency($invoice->currency, $this -> applib -> calculate('invoice_due',$invoice->inv_id))?></td>
                    
                  </tr>
                  <?php } } ?>
                </tbody>
              </table>
            </div>
          </section>
        </section>
        
        
        </section> </aside> </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
        <!-- end -->
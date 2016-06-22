<?php $this->applib->set_locale(); ?>
<section id="content">
  <section class="hbox stretch">

<aside>
      <section class="vbox">

<section class="scrollable wrapper">
  <section class="panel panel-default">
                <header class="panel-heading"><?=lang('all_payments')?> 
                </header>
                <div class="table-responsive">
                  <table id="table-payments" class="table table-striped b-t b-light AppendDataTables">
                    <thead>
                      <tr>
                        <th class="col-options no-sort  col-sm-1"><?=lang('options')?></th>
                        <th class="col-sm-1"><?=lang('invoice')?></th>
                        <th class="col-sm-3"><?=lang('client')?></th>
                        <th class="col-date col-sm-2"><?=lang('payment_date')?></th>
                        <th class="col-date col-sm-2"><?=lang('invoice_date')?></th>
                        <th class="col-currency col-sm-2"><?=lang('amount')?></th>
                        <th class="col-sm-2"><?=lang('payment_method')?></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($payments)) {
              foreach ($payments as $key => $p) { ?>
                      <tr>
                      <?php
                        $currency = $this -> applib->get_any_field('invoices',array('inv_id'=>$p->invoice),'currency');
                        $invoice_date = $this -> applib->get_any_field('invoices',array('inv_id'=>$p->invoice),'date_saved');
                        $invoice_date = strftime(config_item('date_format'), strtotime($invoice_date));
                        ?>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                            <?=lang('options')?>
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">                      
                            <li><a href="<?=base_url()?>invoices/payments/details/<?=$p->p_id?>"><?=lang('view_payment')?></a></li>
                            <li><a href="<?=base_url()?>invoices/payments/edit/<?=$p->p_id?>"><?=lang('edit_payment')?></a></li>
                            <li><a href="<?=base_url()?>invoices/payments/delete/<?=$p->p_id?>" data-toggle="ajaxModal"><?=lang('delete_payment')?></a></li>
                            </ul>
                          </div>
                        </td>
                        <td><a class="text-info" href="<?=base_url()?>invoices/view/<?=$p->invoice?>"><?=$this -> applib->get_any_field('invoices',array('inv_id'=>$p->invoice),'reference_no')?></a></td>
                        <td><?=$this -> applib->get_any_field('companies',array('co_id'=>$p->paid_by),'company_name')?></td>
                        <td><?=strftime(config_item('date_format'), strtotime($p->payment_date));?></td>
                        <td><?=$invoice_date?></td>
                        <td class="col-currency"><?=$this->applib->fo_format_currency($currency, $p->amount)?></td>
                        <td><?=$this -> applib->get_any_field('payment_methods',array('method_id'=>$p->payment_method),'method_name')?></td>
                      </tr>
                      <?php } } ?>
                    </tbody>
                  </table>
                </div>
              </section>
              </section>
  
     



    </section> </aside> </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>



<!-- end -->
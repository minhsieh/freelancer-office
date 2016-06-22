<?php $this->applib->set_locale(); ?>
<section id="content">
  <section class="hbox stretch">
    
    <aside class="aside-md bg-white b-r" id="subNav">
      <header class="dk header b-b">
        
        <p class="h4"><?=lang('all_payments')?></p>
      </header>
      <section class="vbox">
        <section class="scrollable w-f">
          <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
            <?=$this->load->view('sidebar/payments',$payments)?>
            </div></section>
          </section>
        </aside>
        
        <aside>
          <section class="vbox">
            <header class="header bg-white b-b clearfix">
              <div class="row m-t-sm">
                <div class="col-sm-8 m-b-xs">
                <?php
              if (!empty($payment_details)) {
              foreach ($payment_details as $key => $i) { ?>
                  <div class="btn-group">
                    <a href="<?=base_url()?>invoices/payments/edit/<?=$i->p_id?>" title="<?=lang('edit_payment')?>" class="btn btn-sm btn-<?=config_item('button_color')?>">
                  <i class="fa fa-pencil text-white"></i> <?=lang('edit_payment')?></a>
                  </div>
                  
                </div>
                <div class="col-sm-4 m-b-xs">
                  <?php  echo form_open(base_url().'invoices/payments/search'); ?>
                  <div class="input-group">
                    <input type="text" class="input-sm form-control" name="keyword" placeholder="<?=lang('search')?>">
                    <span class="input-group-btn"> <button class="btn btn-sm btn-default" type="submit"><?=lang('go')?>!</button>
                    </span>
                  </div>
                </form>
              </div>
            </div> </header>
            <section class="scrollable wrapper">
              <!-- Start Payment -->
              
              
              <div class="column content-column">
                <div class="details-page" style="margin:45px 25px 25px 8px">
                  <div class="details-container clearfix" style="margin-bottom:20px">
                    <div style="font-size:10pt;">
                      
                      <div style="padding:35px;">
                        <div style="padding-bottom:35px;border-bottom:1px solid #eee;width:100%;">
                          <div>
                            <div style="text-transform: uppercase;font-weight: bold;">
                              <?=$this->config->item('company_name')?>
                            </div>
                            <span style="color:#999"><?=$this->config->item('company_address')?></span>
                          </div>
                          <div style="clear:both;"></div>
                        </div>
                        <div style="padding:35px 0 50px;text-align:center">
                          <span style="text-transform: uppercase; border-bottom:1px solid #eee;font-size:13pt;"><?=lang('payments_received')?></span>
                        </div>
                        <div style="width: 70%;float: left;">
                          <div style="width: 100%;padding: 11px 0;">
                            <div style="color:#999;width:35%;float:left;"><?=lang('payment_date')?></div>
                            <div style="width:65%;border-bottom:1px solid #eee;float:right;foat:right;"><?=strftime(config_item('date_format')." %H:%M:%S", strtotime($i->created_date));?></div>
                            <div style="clear:both;"></div>
                          </div><div style="width: 100%;padding: 10px 0;">
                          <div style="color:#999;width:35%;float:left;"><?=lang('transaction_id')?></div>
                          <div style="width:65%;border-bottom:1px solid #eee;float:right;foat:right;min-height:22px"><?=$i->trans_id?></div>
                          <div style="clear:both;"></div>
                        </div>
                      </div>
                      <div style="text-align:center;color:white;float:right;background:#78ae54;width: 25%;
                        padding: 20px 5px;">
                        <span> <?=lang('amount_received')?></span><br>
                                <?php $inv_cur = $this -> applib -> get_any_field('invoices', array('inv_id' => $i->invoice),'currency'); ?>

                        <span style="font-size:16pt;"><?=$this->applib->fo_format_currency($inv_cur, $i->amount)?></span>
                        </div><div style="clear:both;"></div>
                        <div style="padding-top:10px">
                          <div style="width:75%;border-bottom:1px solid #eee;float:right"><strong><a href="<?=base_url()?>companies/view/details/<?=$i->paid_by?>"><?=ucfirst($this->applib->company_details($i->paid_by,'company_name'))?></a></strong></div>
                          <div style="color:#999;width:25%"><?=lang('received_from')?></div>
                        </div>
                        <div style="padding-top:25px">
                          <div style="width:75%;border-bottom:1px solid #eee;float:right"><?=$this -> applib->get_any_field('payment_methods',array('method_id'=>$i->payment_method),'method_name')?></div>
                          <div style="color:#999;width:25%"><?=lang('payment_mode')?></div>
                        </div>
                        <div style="padding-top:25px">
                          <div style="width:75%;border-bottom:1px solid #eee;float:right"><?=$i->notes?></div>
                          <div style="color:#999;width:25%"><?=lang('notes')?></div>
                        </div>
                        
                        <div style="margin-top:100px">
                          <div style="width:100%">
                            <div style="width:50%;float:left"><h4><?=lang('payment_for')?></h4></div>
                            <div style="clear:both;"></div>
                          </div>
                          
                          <table style="width:100%;margin-bottom:35px;table-layout:fixed;" cellpadding="0" cellspacing="0" border="0">
                            <thead>
                              <tr style="height:40px;background:#f5f5f5">
                                <td style="padding:5px 10px 5px 10px;word-wrap: break-word;">
                                  <?=lang('invoice_code')?>
                                </td>
                                <td style="padding:5px 10px 5px 5px;word-wrap: break-word;" align="right">
                                  <?=lang('invoice_date')?>
                                </td>
                                <td style="padding:5px 10px 5px 5px;word-wrap: break-word;" align="right">
                                  <?=lang('invoice_amount')?>
                                </td>
                                <td style="padding:5px 10px 5px 5px;word-wrap: break-word;" align="right">
                                  <?=lang('paid_amount')?>
                                </td>
                              </tr>
                            </thead>
                            <tbody>
                              <tr style="border-bottom:1px solid #ededed">
                                <td style="padding: 10px 0px 10px 10px;" valign="top"><?=$this->user_profile->get_invoice_details($i->invoice,'reference_no')?></td>
                                <td style="padding: 10px 10px 5px 10px;text-align:right;word-wrap: break-word;" valign="top">
                                  <?=strftime(config_item('date_format'), strtotime($this->user_profile->get_invoice_details($i->invoice,'date_saved')))?>
                                </td>
                                <td style="padding: 10px 10px 5px 10px;text-align:right;word-wrap: break-word;" valign="top">
                                  <span><?=$this->applib->fo_format_currency($inv_cur, $this->user_profile->invoice_payable($i->invoice))?> (- <?=lang('tax')?>) </span>
                                </td>
                                <td style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" valign="top">
                                  <span><?=$this->applib->fo_format_currency($inv_cur, $i->amount)?></span>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
              </div>
              <?php } } ?>
              <!-- End Payment -->
            </section>
            </section> </aside> </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
            <!-- end -->
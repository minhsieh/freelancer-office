<?php $this->applib->set_locale(); ?>
<section id="content">
    <section class="hbox stretch">

<aside>
            <section class="vbox">

<section class="scrollable wrapper w-f">
    <section class="panel panel-default">
                <header class="panel-heading"><?=lang('all_estimates')?>
                <?php
                $username = $this -> tank_auth -> get_username();
                if($role == '1' OR $this -> applib -> allowed_module('add_estimates',$username)) { ?> 
                <a href="<?=base_url()?>estimates/add" class="btn btn-xs btn-primary pull-right"><?=lang('create_estimate')?></a>
                <?php } ?>
                </header>
                <div class="table-responsive">
                  <table id="table-estimates" class="table table-striped b-t b-light AppendDataTables">
                    <thead>
                      <tr>
                        <th class="col-options no-sort col-sm-1"><?=lang('options')?></th>
                        <th class="col-sm-1"><?=lang('estimate')?></th>
                        <th class="col-sm-3"><?=lang('client_name')?></th>
                        <th class="col-sm-1"><?=lang('status')?></th>
                        <th class="col-date col-sm-2"><?=lang('due_date')?></th>
                        <th class="col-date col-sm-2"><?=lang('created')?></th>
                        <th class="col-currency col-sm-2"><?=lang('amount')?></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($estimates)) {
                            foreach ($estimates as $key => $e) {
                        if ($e->status == 'Pending'){ $label = "info"; }
                        elseif($e->status == 'Accepted') { $label = "success";  }
                        else{ $label = "danger"; }
                            ?>
                      <tr>
                        <td>
                          <div class="btn-group">
                                        <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                        <?=lang('options')?>
                                        <span class="caret"></span></button>
                            <ul class="dropdown-menu">      
              <?php if($role == '1' OR $this -> applib -> allowed_module('edit_estimates',$username)) { ?>  
                                <li><a href="<?=base_url()?>estimates/edit/<?=$e->est_id?>"><?=lang('edit_estimate')?></a></li>
                                <li><a href="<?=base_url()?>estimates/timeline/<?=$e->est_id?>"><?=lang('estimate_history')?></a></li>
                <?php } 
                if($role == '1' OR $this -> applib -> allowed_module('view_all_estimates',$username)) { ?>  
                                <li><a href="<?=base_url()?>estimates/email/<?=$e->est_id?>" data-toggle="ajaxModal" title="<?=lang('email_estimate')?>"><?=lang('email_estimate')?></a></li>
                <?php } ?>

                <li><a href="<?=base_url()?>estimates/view/<?=$e->est_id?>"><?=lang('view_estimate')?></a></li>
                        <li><a href="<?=base_url()?>estimates/view/<?=$e->est_id?>"><?=lang('view_estimate')?></a></li>
                        <?php if (config_item('pdf_engine') == 'invoicr') : ?>
                                <li><a href="<?=base_url()?>fopdf/estimate/<?=$e->est_id?>"><?=lang('pdf')?></a></li>
                        <?php elseif(config_item('pdf_engine') == 'mpdf') : ?>
                                <li><a href="<?=base_url()?>estimates/pdf/<?=$e->est_id?>"><?=lang('pdf')?></a></li>
                        <?php endif; ?>
                        </ul>
                        </div>
                        </td>
                        <td><a class="text-info" href="<?=base_url()?>estimates/view/<?=$e->est_id?>"><?=$e->reference_no?></a></td>
                        <td><?=$this -> applib->get_any_field('companies',array('co_id'=>$e->client),'company_name')?></td>
                        <td><span class="label label-<?=$label?>"><?=lang(strtolower($e->status))?></span></td>
                        <td><?=strftime(config_item('date_format'), strtotime($e->due_date))?></td>
                        <td><?=strftime(config_item('date_format'), strtotime($e->date_saved))?></td>
                        <td class="col-currency"><?=$this->applib->fo_format_currency($e->currency, $this -> applib -> est_calculate('estimate_amount',$e->est_id))?></td>
                      </tr>
                      <?php } } ?>
                    </tbody>
                  </table>
                </div>
              </section>
              </section>
    
         



        </section> </aside> </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>



<!-- end -->
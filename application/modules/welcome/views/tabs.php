<aside class="bg-white">
                    <header class="header bg-light bg-gradient">
                      <ul class="nav nav-tabs nav-white">
                        <li class="active"><a href="#projects" data-toggle="tab"><?= lang('recent_projects') ?></a></li>
                        <li class=""><a href="#bugs" data-toggle="tab"><?= lang('recent_bugs') ?></a></li>
                        <li class=""><a href="#invoices" data-toggle="tab"><?= lang('upcoming_invoices') ?></a></li>
                      </ul>
                    </header>
                    <section class="scrollable">
                      <div class="tab-content">
                        <div class="tab-pane active" id="projects">
                          

                          <table class="table table-striped m-b-none text-sm">
                            <thead>
                                <tr>
                                    <th class="col-md-1"><?= lang('timer') ?></th>
                                    <th class="col-md-3"><?= lang('project_name') ?> </th>
                                    <th class="col-md-3"><?= lang('progress') ?></th>
                                    <th class="col-options no-sort col-md-1"><?= lang('options') ?></th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$projects = $this->db->order_by('date_created','desc')->get(Applib::$projects_table,5)->result();
if (!empty($projects)) {
    foreach ($projects as $key => $project) {
        ?>
                                        <tr>
                                            <?php if ($project->timer == 'Off') {
                                                $timer = 'success';
                                            } else {
                                                $timer = 'danger';
                                            } ?>
                                            <td><span class="label label-<?= $timer ?>"><?= $project->timer ?></span></td>
                                            <td><a href="<?= base_url() ?>projects/view/<?= $project->project_id ?>"><?= $project->project_title ?></a></td>
                                            <td><?php if ($project->progress >= 100) { $bg = 'success'; } else { $bg = 'danger'; } ?>
                                                <div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar progress-bar-<?= $bg ?>" data-toggle="tooltip" data-original-title="<?= $project->progress ?>%" style="width: <?= $project->progress ?>%"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn  btn-dark btn-xs" href="<?= base_url() ?>projects/view/<?= $project->project_id ?>">
                                                    <i class="fa fa-suitcase text"></i> <?= lang('project') ?></a>
                                            </td>
                                        </tr>
    <?php }
} else { ?>
                                    <tr>
                                        <td colspan="4"><?= lang('nothing_to_display') ?></td>
                                    </tr>
<?php } ?>
                            </tbody>
                        </table>





                        </div>
                        <div class="tab-pane" id="bugs">


                          <table class="table table-striped m-b-none text-sm">
                            <thead>
                                <tr>
                                    <th class="col-md-1"><?= lang('bug_status') ?></th>
                                    <th class="col-md-3"><?= lang('issue_title') ?> </th>
                                    <th class="col-md-3"><?= lang('priority') ?></th>
                                    <th class="col-options no-sort col-md-1"><?= lang('options') ?></th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$bugs = $this->db->order_by('reported_on','DESC')->get(Applib::$bugs_table,5)->result();
if (!empty($bugs)) {
    foreach ($bugs as $key => $bug) {
        ?>
                                        <tr>
                                            <?php if ($bug->bug_status == 'Resolved') {
                                                $status = 'success';
                                            } else {
                                                $status = 'danger';
                                            } ?>
                                            <td><span class="label label-<?= $status ?>"><?= $bug->bug_status ?></span></td>
                                            <td>
                                              <a href="<?= base_url() ?>projects/view/<?=$bug->project?>?group=bugs&view=bug&id=<?=$bug->bug_id?>">
                                              <?= $bug->issue_title ?>
                                              </a>
                                            </td>
                                            <td>
                                            <span class="label label-success">
                                            <?=lang($bug->priority)?>
                                            </span>
                                            </td>
                                            <td>
                                                <a class="btn  btn-dark btn-xs" href="<?= base_url() ?>projects/view/<?=$bug->project?>?group=bugs&view=bug&id=<?=$bug->bug_id?>">
                                               <?= lang('view_details') ?></a>
                                            </td>
                                        </tr>
    <?php }
} else { ?>
                                    <tr>
                                        <td colspan="4"><?= lang('nothing_to_display') ?></td>
                                    </tr>
<?php } ?>
                            </tbody>
                        </table>


                        </div>
                        <div class="tab-pane" id="invoices">
                          
<table class="table table-striped m-b-none text-sm">
                            <thead>
                                <tr>
                                    <th class="col-md-1"><?= lang('reference_no') ?></th>
                                    <th class="col-md-3"><?= lang('client_name') ?> </th>
                                    <th class="col-md-2"><?= lang('due_date') ?></th>
                                    <th class="col-md-2"><?= lang('due_amount') ?></th>
                                </tr>
                            </thead>
                            <tbody>
<?php

$invoices = $this->db->order_by('due_date','ASC')->get(Applib::$invoices_table)->result();
foreach ($invoices as $key => &$invoice) {
    if($this-> applib ->payment_status($invoice->inv_id) == lang('fully_paid')){
            unset($invoices[$key]);
        }
        if(strtotime($invoice->due_date) < time()){
            unset($invoices[$key]);
        }
}
$invoices = array_slice($invoices, 0, 5);

if (!empty($invoices)) {
    foreach ($invoices as $key => &$invoice) {
        ?>
                                        <tr>
                                            
                                            <td>
                                            <a href="<?=base_url()?>invoices/view/<?=$invoice->inv_id?>">
                                            <span class="label label-primary"><?= $invoice->reference_no ?></span>
                                            </a>
                                            </td>
                                           <td>
                                           <?=Applib::get_table_field(Applib::$companies_table,array('co_id'=>$invoice->client),'company_name')?>
                                           </td>
                                           <td><span class="label label-danger">
                                           <?=strftime(config_item('date_format'), strtotime($invoice->due_date))?>
                                           </span>
                                           </td>
                                            <td class="col-currency"><?=$this->applib->fo_format_currency($invoice->currency, $this -> applib -> calculate('invoice_due',$invoice->inv_id))?></td>
                                            
                                        </tr>
    <?php }
} else { ?>
                                    <tr>
                                        <td colspan="4"><?= lang('nothing_to_display') ?></td>
                                    </tr>
<?php } ?>
                            </tbody>
                        </table>





                        </div>
                      </div>
                    </section>
                </aside>
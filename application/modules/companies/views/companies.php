<section id="content">
  <section class="hbox stretch">
 
    <!-- .aside -->
    <aside>
      <section class="vbox">
        <header class="header bg-white b-b b-light">
          <a href="<?=base_url()?>companies/view/create" class="btn btn-primary btn-sm pull-right" data-toggle="ajaxModal" title="<?=lang('new_company')?>"><i class="fa fa-plus"></i> <?=lang('new_company')?></a>
          <p><?=lang('registered_clients')?></p>
        </header>
        <section class="scrollable wrapper">
          <div class="row">
            <div class="col-lg-12">
              <section class="panel panel-default">
                <div class="table-responsive">
                  <table id="table-clients" class="table table-striped m-b-none AppendDataTables">
                    <thead>
                      <tr>
                        
                        <th><?=lang('company_name')?> </th>
                        <th><?=lang('contacts')?></th>
                        <th class="hidden-sm"><?=lang('primary_contact')?></th>
                        <th><?=lang('website')?> </th>
                        <th><?=lang('email')?> </th>
                        <th class="col-options no-sort"><?=lang('options')?></th>
                      </tr> </thead> <tbody>
                      <?php
                      if (!empty($companies)) {
                      foreach ($companies as $client) { ?>
                      <tr>
                        <td><a href="<?=base_url()?>companies/view/details/<?=$client->co_id?>" class="text-info">
                        <?=$client->company_name?></a></td>
                        <td><span class="badge bg-success" title="<?=lang('contacts')?>"><?=$this->applib->count_rows('account_details',array('company'=>$client->co_id))?></span></td>
                        <td class="hidden-sm"><?=$this->user_profile->get_profile_details($client->primary_contact,'fullname')?></td>
                        <td><a href="<?=$client->company_website?>" class="text-info" target="_blank">
                        <?=$client->company_website?></a>
                      </td>
                      <td><?=$client->company_email?></td>
                      <td>
                        <a href="<?=base_url()?>companies/view/details/<?=$client->co_id?>" class="btn btn-default btn-xs" title="<?=lang('details')?>"><i class="fa fa-home"></i> </a>
                        <a href="<?=base_url()?>companies/view/delete/<?=$client->co_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i></a>
                      </td>
                    </tr>
                    <?php } } ?>
                    
                    
                  </tbody>
                </table>

              </div>
            </section>            
          </div>
        </div>
      </section>

    </section>
  </aside>
  <!-- /.aside -->

</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>
<section id="content">
  <section class="hbox stretch">
    <aside>
      <section class="vbox">
        <section class="scrollable padder">
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
    <li><a href="<?=base_url()?>"><i class="fa fa-home"></i> <?=lang('home')?></a></li>
    <li class="active"><?=lang('updates')?></li>
            </ul>
   <div class="row padder">
          <section class="panel panel-default">
            <header class="panel-heading"><?=lang('system_details')?></header>
            <section class="panel-body">
            <div class="row">
              <div class="col-lg-6">
                <ul class="list-group no-radius">
                  <li class="list-group-item"><span class="pull-right"><?=config_item('version')?><?=config_item('build') > 0 ? " build ".config_item('build') : ""?></span><?=lang('fo_version')?></li>
                  <li class="list-group-item"><span class="pull-right"><?=phpversion()?></span><?=lang('php_version')?></li>
                  <li class="list-group-item"><span class="pull-right"><?=CI_VERSION?></span><?=lang('ci_version')?></li>
                </ul>
              </div>
              <div class="col-lg-6">
                <ul class="list-group no-radius">
                    <?php $status = Applib::pc(); ?>
                    <?php $beta = config_item("beta_updates") == "TRUE" ? TRUE : FALSE; ?>
                  <li class="list-group-item"><span class="pull-right badge bg-<?=$status == 'validated' ? 'success' : 'danger'?>"><?=lang($status)?></span><?=lang('purchase_status')?></li>
                  <li class="list-group-item"><span class="pull-right badge bg-<?=function_exists('curl_version') ? 'success' : 'danger';?>"><?=function_exists('curl_version') ? lang('enabled') : lang('disabled');?></span><?=lang('curl_status')?></li>
                  <li class="list-group-item"><span class="pull-right badge bg-<?=$beta ? 'success' : 'danger'?>"><?= $beta ? lang('enabled') : lang('disabled');?></span>
                  <?=lang('beta_updates')?>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <?php if ($beta) : ?>
                      <a href="<?=base_url()?>updates/beta/0"><?=lang('disable')?></a>
                    <?php else : ?>
                      <a href="<?=base_url()?>updates/beta/1"><?=lang('enable')?></a>
                    <?php endif; ?>
                  
                  </li>
                </ul>
              </div>
            </div>
            </section>
            </section>

        <section class="panel panel-default">
        <header class="panel-heading">
            <a href="<?=base_url()?>updates/check/" class="btn btn-info btn-xs pull-right"><?=lang('check_for_updates')?></a>
            <?=lang('updates')?></header>
                <div class="table-responsive">
                  <table id="table-clients" class="table table-striped m-b-none">
                    <thead>
                      <tr>
                        <th class="col-sm-1"><?=lang('build')?></th>
                        <th class="col-sm-6"><?=lang('title')?></th>
                        <th class="col-sm-1"><?=lang('date')?></th>
                        <th class="col-sm-1"><?=lang('status')?></th>
                        <th class="col-sm-1"><?=lang('importance')?></th>
                        <th class="col-sm-1"><?=lang('options')?></th>
                      </tr> 
                    </thead> 
                    <tbody>
                    <?php foreach ($updates as $up) : ?>
                    <tr>
                        <td><?=$up->build?></td>
                        <td><a href="<?=base_url()?>updates/view/<?=$up->build?>" data-toggle="ajaxModal" title="View Details"><?=$up->title?></a>
                        <span class="badge bg-info"><?=$up->code?></span>
                        </td>
                        <td><?=strftime(config_item('date_format'),strtotime($up->date))?></td>
                        <td><span class="text-success"><?=lang('new')?></span></td>
                        <?php
                        switch($up->importance) {
                            case "low": $badge = "bg-success"; break;
                            case "medium": $badge = "bg-warning"; break;
                            case "high": $badge = "bg-danger"; break;
                        }
                        ?>
                        <td><span class="badge <?=$badge?>"><?=lang($up->importance)?></span></td>
                        <td><a href="<?=base_url()?>updates/view/<?=$up->build?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="View Details"><?=lang('details')?></a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php foreach ($installed as $iup) : ?>
                    <tr>
                        <td><?=$iup->build?></td>
                        <td><a href="<?=base_url()?>updates/view/<?=$iup->build?>" data-toggle="ajaxModal" title="View Details"><?=$iup->title?></a>
                        <span class="badge"><?=$iup->code?></span>
                        </td>
                        <td><?=strftime(config_item('date_format'),strtotime($iup->date))?></td>
                        <td><span><?=lang('installed')?></span></td>
                        <td><span><?=lang($iup->importance)?></span></td>
                        <td><a href="<?=base_url()?>updates/view/<?=$iup->build?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="View Details"><?=lang('details')?></a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (count($updates) == 0 && count($installed) == 0) : ?>
                        <tr><td colspan="0"><?=lang('no_updates_found')?></td></tr>
                    <?php endif; ?>
                  </tbody>
                </table>
                </div>
        </section>
        <section class="panel panel-default">
        <header class="panel-heading">
            <a href="<?=base_url()?>updates/backup/" class="btn btn-info btn-xs pull-right"><?=lang('backup_now')?></a>
            <?=lang('backups')?></header>
                <div class="table-responsive">
                  <table id="table-clients" class="table table-striped m-b-none">
                    <tbody>
                    <?php foreach ($backups as $file) : ?>
                        <tr>
                        <td><a href="<?=base_url()?>resource/backup/<?=$file?>" class="text-info"><?=$file?></a></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (count($backups) == 0) : ?>
                        <tr><td><?=lang('no_backup_found')?></td></tr>
                    <?php endif; ?>
                  </tbody>
                </table>
                </div>
        </section>
<!-- footer -->
<?php if (config_item('hide_branding') == 'FALSE') : ?>
  <footer id="footer">
    <div class="text-center padder clearfix">
      <p>
        <small><?=lang('powered_by')?> <a class="text-info" href="http://codecanyon.net/item/freelancer-office/8870728">Freelancer Office v.<?=config_item('version')?></a></small>
      </p>
    </div>
  </footer>
<?php endif; ?>
  <!-- / footer -->
  
</div>
</section>
</section>
    </aside>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
</section>
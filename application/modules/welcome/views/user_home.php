<section id="content">
    <section class="vbox">
        <section class="scrollable padder">
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li>
                    <small><?= lang('welcome_back') ?> , <?php echo $this->user_profile->get_profile_details($this->tank_auth->get_user_id(), 'fullname') ? $this->user_profile->get_profile_details($this->tank_auth->get_user_id(), 'fullname') : $this->tank_auth->get_username() ?> </small>
                </li>
            </ul>
            <?php
            if ((config_item('valid_license') != 'TRUE' && $this->tank_auth->get_role_id() == 1) AND config_item('demo_mode') != 'TRUE') {
                ?>
                <div class="alert alert-danger" role="alert">
                    <strong><?= lang('fo_not_validated'); ?></strong><br/>
    <?php
    $link = '<a href="' . base_url() . 'settings/?settings=system">' . lang('system_settings') . '</a>';
    echo sprintf(lang('not_licenced_message'), $link);
    echo ' <a href="http://codecanyon.net/item/freelancer-office/8870728">Envato Market</a>';
    ?>
                </div>
                <?php } ?>
            <div class="panel panel-default">

                <div class="row m-l-none m-r-none bg-dark lter">
                    <div class="col-sm-6 col-md-3 padder-v b-r b-light">
                        <a class="clear" href="<?= base_url() ?>projects">
                            <span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-warning"></i> <i class="fa fa-coffee fa-stack-1x text-white"></i>
                            </span>
                            <span class="h3 block m-t-xs"><strong>
<?= Applib::count_num_rows(Applib::$projects_table, array('archived'=>0)) ?> </strong>
                            </span> <small class="text-muted text-uc"><?= lang('projects') ?> </small> </a>
                    </div>
                    <div class="col-sm-6 col-md-3 padder-v b-r b-light">
                        <a class="clear" href="<?= base_url() ?>messages">
                            <span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-info"></i> <i class="fa fa-envelope fa-stack-1x text-white"></i>
                            </span>
                            <span class="h3 block m-t-xs"><strong>
<?= Applib::count_num_rows(Applib::$messages_table, array('user_to' => $this->tank_auth->get_user_id(), 'deleted' => 'No')); ?>
                                </strong>
                            </span> <small class="text-muted text-uc"><?= lang('messages') ?>  </small> </a>
                    </div>
                    <div class="col-sm-6 col-md-3 padder-v b-r b-light">
                        <a class="clear" href="<?= base_url() ?>invoices">
                            <span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-danger"></i> <i class="fa fa-suitcase fa-stack-1x text-white"></i>
                            </span>
                            <span class="h3 block m-t-xs"><strong>
<?= Applib::count_num_rows(Applib::$invoices_table, array('status'=>'Unpaid')) ?> </strong></span>
                            <small class="text-muted text-uc"><?= lang('invoices') ?>  </small> </a>
                    </div>
                    <div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
                        <a class="clear" href="<?= base_url() ?>tickets">
                            <span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-success"></i> <i class="fa fa-ticket fa-stack-1x text-white"></i>
                            </span>
                            <span class="h3 block m-t-xs"><strong>
<?=count($this->db->where('archived_t','0')->where('status !=','closed')->get('tickets')->result());?></strong>
                            </span> <small class="text-muted text-uc"><?= lang('tickets') ?>  </small> </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <section class="panel panel-default">

                  
                        
                         <?=$this->load->view('tabs');?>


                        <footer class="panel-footer bg-white no-padder">
                            <div class="row text-center no-gutter">
                                <div class="col-xs-3 b-r b-light">
                                    <span class="h4 font-bold m-t block"><?= $this->user_profile->count_table_rows('bugs') ?>
                                    </span> <small class="text-muted m-b block"><?= lang('bugs') ?></small>
                                </div>
                                <div class="col-xs-3 b-r b-light">
                                    <span class="h4 font-bold m-t block"><?= $this->user_profile->count_rows('projects', array('progress >=' => '100')) ?>
                                    </span> <small class="text-muted m-b block"><?= lang('complete_projects') ?></small>
                                </div>
                                <div class="col-xs-3 b-r b-light">
                                    <span class="h4 font-bold m-t block"><?= $this->user_profile->count_table_rows('tasks') ?>
                                    </span> <small class="text-muted m-b block"><?= lang('tasks') ?>  </small>
                                </div>
                                <div class="col-xs-3">
                                    <span class="h4 font-bold m-t block"><?= $this->user_profile->count_rows('comments', array('posted_by' => $this->tank_auth->get_user_id())) ?>
                                    </span> <small class="text-muted m-b block"><?= lang('project_comments') ?></small>

                                </div>
                            </div>
                        </footer>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel panel-default">
                        <header class="panel-heading"><?= lang('recently_paid_invoices') ?></header>
                        <div class="panel-body">
                            <div class="list-group bg-white" style="height:200px">
                                <?php
                                $recently_paid = $this->db
                                        ->order_by('created_date', 'desc')
                                        ->get(Applib::$payments_table, 5)
                                        ->result();

                                if (!empty($recently_paid)) {
                                    foreach ($recently_paid as $key => $i) {
                                        $invoice = Applib::retrieve(Applib::$invoices_table, array('inv_id' => $i->invoice));
                                        $inv = $invoice[0];
                                        $reference = $inv->reference_no;
                                        $currency = $inv->currency;
                                        $payment_method = Applib::retrieve(Applib::$payment_methods_table, array('method_id' => $i->payment_method));
                                        $payment_method_name = $payment_method[0]->method_name;

                                        if ($i->payment_method == '1') {
                                            $badge = 'success';
                                        } elseif ($i->payment_method == '2') {
                                            $badge = 'danger';
                                        } else {
                                            $badge = 'dark';
                                        }
                                        $converted = "";
                                        if ($currency != config_item('default_currency')) {
                                            $converted = " (".$this->applib->fo_format_currency(config_item('default_currency'),$this->applib->fo_convert_currency($currency, $i->amount)).")";
                                        }
                                        ?>
                                        <a href="<?= base_url() ?>invoices/view/<?= $i->invoice ?>" class="list-group-item">
                                            <?= $reference ?> - <small class="text-muted"><?=$this->applib->fo_format_currency($currency, $i->amount)?> <?=$converted?>
                                                
                                        <span class="badge bg-<?= $badge ?> pull-right"><?= $payment_method_name ?></span></small>
                                        </a>
                                        <?php }
                                    } ?>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <small><?= lang('total_receipts') ?>: <strong>
                            <?php if (!isset($no_invoices)) {
                                echo $this->applib->fo_format_currency(config_item('default_currency'), $sums['paid']);
                            } else {
                                echo $this->applib->fo_format_currency(config_item('default_currency'), 0);
                            } ?> 
                                </strong></small>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 ">
                    <section class="panel panel-default">
                        <header class="panel-heading font-bold"><?= lang('yearly_overview') ?></header>
                        <div class="panel-body">
                            <div id="line-chart"></div>
                        </div>                  
                    </section>
                </div>
                <!-- Revenue Collection -->
                <?php
                $total_receipts = $sums['paid'];
                $invoices_cost = $this->applib->all_invoice_amount();
                $outstanding = $sums['due'];
                if ($outstanding < 0) { $outstanding = 0; }
                if ($invoices_cost > 0) {
                    $perc_paid = ($total_receipts / $invoices_cost) * 100;
                    if ($perc_paid > 100) {
                        $perc_paid = '100';
                    } else {
                        $perc_paid = round($perc_paid, 1);
                    }
                    $perc_outstanding = round(100 - $perc_paid, 1);
                } else {
                    $perc_paid = 0;
                    $perc_outstanding = 0;
                }
                ?>
                <div class="col-md-4">
                    <section class="panel panel-default revenue">
                        <header class="panel-heading"><?= lang('revenue_collection') ?></header>
                        <div class="panel-body text-center">
                            <h4><?= lang('received_amount') ?></h4>
                            <small class="text-muted block"><?= lang('percentage_collection') ?></small>
                            <div class="sparkline inline" data-type="pie" data-height="150" data-slice-colors="['#65BD77','#FFC333']">
<?= $perc_paid ?>,<?= $perc_outstanding ?></div>
                            <div class="line pull-in"></div>
                            <div>
                                <i class="fa fa-circle text-warning"></i> <?= lang('outstanding') ?> - <?= $perc_outstanding ?>%
                                <i class="fa fa-circle text-success"></i> <?= lang('paid') ?> - <?= $perc_paid ?>%
                            </div>
                        </div>
                        <div class="panel-footer"><small><?= lang('total_outstanding') ?> : <strong>
                            <?php if (!isset($no_invoices)) {
                                echo $this->applib->fo_format_currency(config_item('default_currency'), $sums['due']);
                            } else {
                                echo $this->applib->fo_format_currency(config_item('default_currency'), 0);
                            } ?> 
                                </strong></small>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <!-- Percentage Received -->
                        <div class="col-lg-12">
                            <section class="panel panel-default">
                                <header class="panel-heading"><?= lang('recent_tickets') ?></header>
                                <div class="panel-body">
                                    <section class="comment-list block">
                                        <section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                                        <?php
                                        $tickets = $this->db
                                                ->order_by('created', 'desc')
                                                ->get(Applib::$tickets_table, 50)
                                                ->result();
                                        if (!empty($tickets)) {
                                            foreach ($tickets as $key => $ticket) {
                                                if ($ticket->status == 'open') {
                                                    $badge = 'danger';
                                                } elseif ($ticket->status == 'closed') {
                                                    $badge = 'success';
                                                } else {
                                                    $badge = 'dark';
                                                }
                                        ?>
                                                

                <article id="comment-id-1" class="comment-item small">
                <?php if($ticket->reporter != NULL){ ?>
                <div class="pull-left thumb-sm avatar">
                    <?php
                        if (config_item('use_gravatar') == 'TRUE' AND
                           Applib::get_table_field(
                                Applib::$profile_table, 
                                        array('user_id' => $ticket->reporter), 'use_gravatar') == 'Y') {
                        $user_email = Applib::login_info($ticket->reporter)->email;
                     ?>
                                                            <img src="<?= $this->applib->get_gravatar($user_email) ?>" class="img-circle">
                                                                    <?php } else { ?>
                    <img src="<?= base_url() ?>resource/avatar/<?= Applib::profile_info($ticket->reporter)->avatar ?>" class="img-circle">
                                        <?php } ?>
                </div>
                <?php }else{ echo "NULL"; } ?>

                                                        <section class="comment-body m-b-lg">
                                                            <header class="b-b">
                                                                <strong>
        <?php if($ticket->reporter != NULL){ ?>
        <?= Applib::profile_info($ticket->reporter)->fullname ? Applib::profile_info($ticket->reporter)->fullname : Applib::login_info($ticket->reporter)->fullname ?>
        <?php }else{ echo "NULL"; } ?>
        </strong>
                                                                <span class="text-muted text-xs"> <?php
                                                    $today = time();
                                                    $activity_day = strtotime($ticket->created);
                                                    echo $this->user_profile->get_time_diff($today, $activity_day);
                                                    ?> <?= lang('ago') ?>
                                                                </span>
                                                            </header>
                                                            <div>
                                                                <a href="<?= base_url() ?>tickets/view/<?= $ticket->id ?>">
        <?= $ticket->subject ?> 
                                                                    <small class="text-muted">
        <?= lang('priority') ?>: <?= $ticket->priority ?> 
                                                                        <span class="badge bg-<?= $badge ?>"><?= $ticket->status ?></span>
                                                                    </small>
                                                                </a>
                                                            </div>
                                                        </section>
                                                    </article>





    <?php }
} ?>
                                        </section>
                                    </section>









                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="row">
                        <!-- Percentage Received -->
                        <div class="col-lg-12">
                            <section class="panel panel-default">
                                <header class="panel-heading"><?= lang('recent_tasks') ?></header>
                                <div class="panel-body">
                                    <section class="comment-list block">
                                        <section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                                        <?php
                                        $tasks = $tasks = $this->db
                                                ->join('projects','project = project_id')
                                                ->get('tasks')->result();

                                        if (!empty($tasks)) {
                                            foreach ($tasks as $key => $task) {
                                                if ($task->task_progress == '100') {
                                                    $badge = 'success';
                                                } elseif ($task->task_progress >= '50') {
                                                    $badge = 'warning';
                                                } else {
                                                    $badge = 'danger';
                                                }
                                                $assigned = unserialize($task->assigned_to);
                                                
                                                if (isset($assigned[0]) && $assigned[0] > 0) {
                                                    $user = $assigned[0];
                                                    $exists = $this->db->where('id',$user)->get('users')->result();
                                                    if (count($exists) == 0) { $user = $task->added_by; }
                                                } else {
                                                    $user = $task->added_by;
                                                }
                                                
                                        ?>
                                                    <article class="comment-item small">
                                                        <div class="pull-left thumb-sm avatar">
                                        <?php
                                            if (config_item('use_gravatar') == 'TRUE' AND
                                            Applib::get_table_field(Applib::$profile_table, array('user_id' => $user), 'use_gravatar') == 'Y') {
                                            $user_email = Applib::login_info($user)->email;
                                        ?>
                                                            <img src="<?= $this->applib->get_gravatar($user_email) ?>" class="img-circle">
                                                                    <?php } else { ?>
                                                            <img src="<?= base_url() ?>resource/avatar/<?= Applib::profile_info($user)->avatar ?>" class="img-circle">
                                        <?php } ?>
                                                        </div>
                                                        <section class="comment-body m-b-lg">
                                                            <header class="b-b">
                                                                <strong>
        <?= Applib::profile_info($user)->fullname ? Applib::profile_info($user)->fullname : Applib::login_info($user)->username ?></strong>
                                                                <span class="text-muted text-xs"> <?php
                                                    $today = time();
                                                    $activity_day = strtotime($task->date_added);
                                                    echo $this->user_profile->get_time_diff($today, $activity_day);
                                                    ?> <?= lang('ago') ?>
                                                                </span>
                                                            </header>
                                                            <div>
                                                                <a href="<?= base_url() ?>projects/view/<?= $task->project_id ?>?group=tasks&view=task&id=<?=$task->t_id?>">
        <?= $task->task_name ?> <span class="badge bg-<?= $badge ?>"><?= $task->task_progress ?>%</span>
                                                                </a>
                                                            </div>
                                                        </section>
                                                    </article>


    <?php }
} ?>
                                        </section>
                                    </section>









                                </div>
                            </section>
                        </div>
                    </div>
                </div>



                <div class="col-md-4">
                    <section class="panel panel-default b-light">
                        <header class="panel-heading"><?= lang('recent_activities') ?></header>
                        <div class="panel-body">



                            <section class="comment-list block">

                                <section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">


                                                    <?php
                                                    if (!empty($activities)) {
                                                        foreach ($activities as $key => $activity) {
                                                            ?>
                                            <article id="comment-id-1" class="comment-item small">
                                                <div class="pull-left thumb-sm">
                                                        <?php
                                                        if (config_item('use_gravatar') == 'TRUE' AND
                                                                Applib::get_table_field(Applib::$profile_table, array('user_id' => $activity->user), 'use_gravatar') == 'Y') {
                                                            $user_email = Applib::login_info($activity->user)->email;
                                                            ?>
                                                        <img src="<?= $this->applib->get_gravatar($user_email) ?>" class="img-circle">
                                                        <?php } else { ?>
                                                        <img src="<?= base_url() ?>resource/avatar/<?= Applib::profile_info($activity->user)->avatar ?>" class="img-circle">
                                                        <?php } ?>
                                                </div>

                                                <section class="comment-body m-b-lg">
                                                    <header class="b-b">
                                                        <strong>
        <?= Applib::profile_info($activity->user)->fullname ? Applib::profile_info($activity->user)->fullname : Applib::login_info($activity->user)->fullname ?></strong>
                                                        <span class="text-muted text-xs"> <?php
                                            $today = time();
                                            $activity_day = strtotime($activity->activity_date);
                                            echo $this->user_profile->get_time_diff($today, $activity_day);
                                            ?> <?= lang('ago') ?>
                                                        </span>
                                                    </header>
                                                    <div>
        <?php
        if (lang($activity->activity) != '') {
            if (!empty($activity->value1)) {
                if (!empty($activity->value2)) {
                    echo sprintf(lang($activity->activity), '<em>' . $activity->value1 . '</em>', '<em>' . $activity->value2 . '</em>');
                } else {
                    echo sprintf(lang($activity->activity), '<em>' . $activity->value1 . '</em>');
                }
            } else {
                echo lang($activity->activity);
            }
        } else {
            echo $activity->activity;
        }
        ?>
                                                    </div>
                                                </section>
                                            </article>


    <?php }
} ?></section>
                            </section>





                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
<?php $year = date('Y'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script type="text/javascript">
    Morris.Line({
        element: 'line-chart',
        data: [
<?php
for ($i = 1; $i <= 12; $i++) {
    print_r('{
    "Received Amount": ' . Applib::cal_amount('received', $year, sprintf('%02d', $i)) . ',
    "period": "' . $year . '-' . sprintf('%02d', $i) . '"
  },');
};
?>
            <?php 
                $cur = $this->applib->currencies(config_item('default_currency'));
            ?>

        ],
        xkey: 'period',
        ykeys: ['Received Amount'],
        labels: ['Paid Amount'],
        hoverCallback: function (index, options, content) {
            return(content);
        },
        hideHover: 'auto',
        behaveLikeLine: true,
        pointFillColors: ['#fff'],
        pointStrokeColors: ['black'],
        xLabelMargin: 10,
        xLabelAngle: 70,
        preUnits: ['<?=$cur->symbol?> '],
        lineColors: ['red'],
        xLabelFormat: function (x) {
            var IndexToMonth = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var month = IndexToMonth[ x.getMonth() ];
            var year = x.getFullYear();
            return year + ' ' + month;
        },
        dateFormat: function (x) {
            var IndexToMonth = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var month = IndexToMonth[ new Date(x).getMonth() ];
            var year = new Date(x).getFullYear();
            return year + ' ' + month;
        },
        resize: true
    });

</script>
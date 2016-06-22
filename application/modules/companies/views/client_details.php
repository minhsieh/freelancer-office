<?php $this->applib->set_locale(); ?>
<section id="content">
	<section class="hbox stretch">
		<?php
                if (!empty($client_details)) {
		foreach ($client_details as $key => $i) { ?>
		<!-- .aside -->
		<aside>
			<section class="vbox">
				<header class="header bg-white b-b b-light">
                                    <a href="<?=base_url()?>companies/view/edit/<?=$i->co_id?>" class="btn btn-dark btn-sm pull-right" data-toggle="ajaxModal" title="<?=lang('edit')?>"><i class="fa fa-edit"></i> <?=lang('edit')?></a>

					<p><?=$i->company_name?> - <?=lang('details')?> </p>
				</header>
				<section class="scrollable wrapper">
					<section class="panel panel-default">	
					<span class="text-danger"><?=$this->session->flashdata('form_errors')?></span>
						
						<div class="panel-body">	
						


							<!-- Details START -->
							<div class="col-md-4 small">
								<div class="group">
									<h4 class="subheader text-muted"><?=lang('contact_details')?></h4>
									<div class="row inline-fields">
										<div class="col-md-6"><strong><?=lang('company_name')?></strong></div>
										<div class="col-md-6"><?=$i->company_name?></div>
									</div>
									<div class="row inline-fields">
										<div class="col-md-6"><strong><?=lang('contact_person')?></strong></div>
										<div class="col-md-6"><?=($i->primary_contact) ? Applib::profile_info($i->primary_contact)->fullname : ''?></div>
									</div>
									<div class="row inline-fields">
										<div class="col-md-6"><strong><?=lang('email')?></strong></div>
                                     <div class="col-md-6"><a href="mailto:<?=$i->company_email?>"><?=$i->company_email?></a></div>
									</div>
									<div class="row inline-fields">
									<div class="col-md-6"><strong><?=lang('phone')?></strong></div>
                                    <div class="col-md-6"><a href="tel:<?=$i->company_phone?>"><?=$i->company_phone?></a></div>
									</div>
									<div class="row inline-fields">
								    <div class="col-md-6"><strong><?=lang('mobile_phone')?></strong></div>
                                    <div class="col-md-6"><a href="tel:<?=$i->company_mobile?>"><?=$i->company_mobile?></a></div>
									</div>
									<div class="row inline-fields">
									<div class="col-md-6"><strong><?=lang('fax')?></strong></div>
                                    <div class="col-md-6"><a href="tel:<?=$i->company_fax?>"><?=$i->company_fax?></a></div>
									</div>
									<div class="row inline-fields">
										<div class="col-md-6"><strong><?=lang('vat')?></strong></div>
										<div class="col-md-6"><?=$i->VAT?></div>
									</div>
								</div>
								
							</div>
							<div class="col-md-4 small">
								<div class="group">
									<h4 class="subheader text-muted"><?=lang('address')?></h4>
                                     <div class="row inline-fields">
										<div class="col-md-4"><strong><?=lang('address')?></strong></div>
                                         <div class="col-md-6"><?=nl2br($i->company_address)?></div>
									</div>
									<div class="row inline-fields">
										<div class="col-md-4"><strong><?=lang('city')?></strong></div>
										<div class="col-md-6"><?=$i->city?></div>
									</div>
									<div class="row inline-fields">
										<div class="col-md-4"><strong><?=lang('zip_code')?></strong></div>
										<div class="col-md-6"><?=$i->zip?></div>
									</div>
									<div class="row inline-fields">
										<div class="col-md-4"><strong><?=lang('country')?></strong></div>
										<div class="col-md-6"><?=$i->country?></div>
									</div>									
								</div>
								
							</div>
							<div class="col-md-4 small">
								<div class="group">
									<h4 class="subheader text-muted"><?=lang('web')?></h4>
                                       <div class="row inline-fields">
										<div class="col-md-4"><strong><?=lang('website')?></strong></div>
										<div class="col-md-6"><a href="<?=$i->company_website?>" class="text-info" target="_blank"><?=$i->company_website?></a></div>
									</div>
									<div class="row inline-fields">
										<div class="col-md-4"><strong>Skype</strong></div>
										<div class="col-md-6"><a href="skype:<?=$i->skype?>?call"><?=$i->skype?></a></div>
									</div>
									<div class="row inline-fields">
										<div class="col-md-4"><strong>LinkedIn</strong></div>
										<div class="col-md-6"><a href="<?=$i->linkedin?>" class="text-info" target="_blank"><?=$i->linkedin?></a></div>
									</div>
									<div class="row inline-fields">
										<div class="col-md-4"><strong>Facebook</strong></div>
										<div class="col-md-6"><a href="<?=$i->facebook?>" class="text-info" target="_blank"><?=$i->facebook?></a></div>
									</div>
									<div class="row inline-fields">
										<div class="col-md-4"><strong>Twitter</strong></div>
										<div class="col-md-6"><a href="<?=$i->twitter?>" class="text-info" target="_blank"><?=$i->twitter?></a></div>
									</div>
									<!-- End Additional Info -->
                                                                </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="col-md-12">
                                                            <hr>
                                            <div class="col-md-6 no-gutter">
                                                <a href="<?=base_url()?>companies/account/hosting/<?=$i->co_id?>" class="btn btn-sm btn-default" data-toggle="ajaxModal" title="<?=lang('hosting_account')?>"><i class="fa fa-info-circle"></i> <?=lang('show_account_details')?></a>
                                                <a href="<?=base_url()?>companies/account/bank/<?=$i->co_id?>" class="btn btn-sm btn-default" data-toggle="ajaxModal" title="<?=lang('bank_account')?>"><i class="fa fa-money"></i> <?=lang('show_bank_details')?></a>
                                            </div>
                                            <div class="col-md-6 no-gutter">
                                                <div class="rec-pay col-md-8 no-gutter">
                                                    <h4 class="subheader text-muted text-right"><?=lang('received_amount')?></h4>
                                                </div>
                                                <div class="rec-pay col-md-4 no-gutter">
                                                    <h3 class="amount text-danger cursor-pointer text-right"><strong>
                                                    <?php $cur = $this->applib->client_currency($i->co_id);?>
                                                    <?=$this->applib->fo_format_currency($cur->code, $this->user_profile->client_paid($i->co_id))?>
                                                    </strong></h3>
                                                </div>
                                                        </div>
                                                </div>
                                                </div>
							<!-- Details END -->

						<div class="panel-body">
							<!-- Client Contacts -->
							<div class="col-md-12">
							<section class="panel panel-default">
                <header class="panel-heading">
                <a href="<?=base_url()?>contacts/add/<?=$i->co_id?>" class="btn btn-xs btn-info pull-right" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?=lang('add_contact')?></a>

                <i class="fa fa-user"></i> <?=lang('contacts')?></header>

                

			<table id="table-client-details-1" class="table table-striped b-t b-light text-sm AppendDataTables">
			<thead>
				<tr>
					<th><?=lang('avatar_image')?></th>
					<th><?=lang('full_name')?></th>
					<th><?=lang('email')?></th>
					<th><?=lang('phone')?> </th>
					<th><?=lang('mobile_phone')?> </th>
					<th>Skype</th>
					<th class="col-date"><?=lang('last_login')?> </th>
					<th class="col-options no-sort"><?=lang('options')?></th>
				</tr> </thead> <tbody>
				<?php
								if (!empty($client_contacts)) {
				foreach ($client_contacts as $key => $contact) { ?>
				<tr>
                                    <td><a class="thumb-sm avatar">

				<?php
					$user_email = Applib::login_info($contact->user_id)->email;
					$gravatar_url = $this -> applib -> get_gravatar($user_email);
					 if(config_item('use_gravatar') == 'TRUE' AND $this -> applib -> get_any_field(Applib::$profile_table,array('user_id'=>$contact->user_id),'use_gravatar') == 'Y'){ ?>
					<img src="<?=$gravatar_url?>" class="img-circle">
					<?php }else{ ?>
					<img src="<?=base_url()?>resource/avatar/<?=Applib::profile_info($contact->user_id)->avatar?>" class="img-circle">
				<?php } ?>
                                        </a></td>
					<td><?=$contact->fullname?></td>
					<td class="text-info" ><?=$contact->email?> </td>
                    <td><a href="tel:<?=$contact->phone?>"><?=$contact->phone?></a></td>
                    <td><a href="tel:<?=$contact->mobile?>"><?=$contact->mobile?></a></td>
                    <td><a href="skype:<?=$contact->skype?>?call"><?=$contact->skype?></a></td>
					<?php
					if ($contact->last_login == '0000-00-00 00:00:00') {
						$login_time = "-";
					}else{ $login_time = strftime(config_item('date_format')." %H:%M:%S", strtotime($contact->last_login)); } ?>
					<td><?=$login_time?> </td>				
					<td>
					
					<a href="<?=base_url()?>companies/make_primary/<?=$contact->user_id?>/<?=$i->co_id?>" class="btn btn-default btn-xs" title="<?=lang('primary_contact')?>" >
					<i class="fa fa-chain <?php if ($i->primary_contact == $contact->user_id) { echo "text-danger"; } ?>"></i> </a>
					<a href="<?=base_url()?>contacts/view/update/<?=$contact->user_id?>" class="btn btn-default btn-xs" title="<?=lang('edit')?>"  data-toggle="ajaxModal">
					<i class="fa fa-edit"></i> </a>
					<a href="<?=base_url()?>users/account/delete/<?=$contact->user_id?>" class="btn btn-default btn-xs" title="<?=lang('delete')?>" data-toggle="ajaxModal">
					<i class="fa fa-trash-o"></i> </a>
					</td>
				</tr>
				<?php  } } ?>
				
				
				
			</tbody>
		</table>
							</section></div>

							<!-- Client Invoices -->
							<div class="col-md-6">
							<section class="panel panel-default">
                <header class="panel-heading"><i class="fa fa-list"></i> <?=strtoupper(lang('invoices'))?> </header>
		<table id="table-client-details-2" class="table table-striped b-t b-light text-sm AppendDataTables">
			<thead>
				<tr>
					<th><?=lang('reference_no')?></th>
					<th><?=lang('date_issued')?></th>
					<th><?=lang('due_date')?> </th>
					<th class="col-currency"><?=lang('amount')?> </th>
				</tr> </thead> <tbody>
				<?php
                setlocale(LC_ALL, config_item('locale').".UTF-8");
				if (!empty($client_invoices)) {
				foreach ($client_invoices as $key => $invoice) { ?>
				<tr>
					<td><a class="text-info" href="<?=base_url()?>invoices/view/<?=$invoice->inv_id?>"><?=$invoice->reference_no?></a></td>
					<td><?=strftime(config_item('date_format'), strtotime($invoice->date_saved));?> </td>
					<td><?=strftime(config_item('date_format'), strtotime($invoice->due_date));?> </td>
                                <td class="col-currency"><?=$this->applib->fo_format_currency($invoice->currency, $this->applib->invoice_payable($invoice->inv_id))?></td>
				</tr>
				<?php  } } ?>
				
				
				
			</tbody>
		</table></section>
                                                            
        <section class="panel panel-default">
                <header class="panel-heading"><i class="fa fa-link"></i> <?=strtoupper(lang('links'))?> </header>
                <table id="table-client-details-3" class="table table-striped b-t b-light text-sm AppendDataTables">
                        <thead>
                           <tr>
                            <th><?=lang('link_title')?></th>
                            <th class="col-options no-sort"><?=lang('options')?></th>
                          </tr> 
                             </thead>
                                <tbody>
                                     <?php if (!empty($client_links)) {
                                        foreach ($client_links as $link) { ?>
                                            <tr>
                                             <td>
                                             <img class="favicon" src="http://www.google.com/s2/favicons?domain=<?=$link->link_url;?>" />
                                            <a href="<?=base_url()?>projects/view/<?=$link->project_id?>?group=links&view=link&id=<?=$link->link_id?>"><?=$link->link_title?></a></td>
                                            <td>
                                            <?php if ($role == '1' OR $role == '3' OR $this -> applib -> project_setting('show_project_links',$link->project_id)) {  ?>
                                            <a href="<?=base_url()?>projects/links/pin/<?=$link->project_id;?>/<?=$link->link_id?>" title="<?=lang('link_pin');?>" class="foAjax btn btn-xs <?=($i->co_id == $link->client ? 'btn-danger':'btn-default');?> btn"><i class="fa fa-thumb-tack"></i>
                                            </a>
                                    <?php } ?>
                                        <a href="<?=$link->link_url?>" target="_blank" title="<?=$link->link_title?>" class="btn btn-xs btn-primary"><i class="fa fa-external-link text-white"></i></a>
                                </td>
                                        </tr>
                                            <?php  } } ?>
                                            </tbody>
                                </table>
        </section>
                                                            
                                                            
							</div>
							<!-- Client Projects -->
							<div class="col-md-6">
							<section class="panel panel-default">
                        <header class="panel-heading"><i class="fa fa-suitcase"></i> <?=strtoupper(lang('projects'))?> </header>
                                <table id="table-client-details-4" class="table table-striped b-t b-light text-sm AppendDataTables">
                                <thead>
                                        <tr>
                                                <th><?=lang('project_code')?></th>
                                                <th><?=lang('project_name')?></th>
                                                <th><?=lang('progress')?> </th>
                                        </tr> </thead> <tbody>
                                        <?php
                                        if (!empty($client_projects)) {
                                        foreach ($client_projects as $key => $project) { ?>
                                        <tr>
                                                <td><a class="text-info" href="<?=base_url()?>projects/view/<?=$project->project_id?>">
                                                <?=$project->project_code?></a></td>
                                                <td><?=$project->project_title?> </td>
                                                <td><div class="progress progress-xs m-t-xs progress-striped active m-b-none">
                                        <div class="progress-bar progress-bar-success" data-toggle="tooltip" data-original-title="<?=$project->progress?>%" style="width: <?=$project->progress?>%">
                                                                                                </div>
                                                                                        </div>
                                                </td>
                                        </tr>
                                        <?php  } } ?>
                                        </tbody>
                                </table>
							</section></div>



<!-- Client payments -->
							<div class="col-md-6">
							<section class="panel panel-default">
                        <header class="panel-heading"><i class="fa fa-usd"></i> <?=strtoupper(lang('payments'))?> </header>

							<table id="table-client-details-4" class="table table-striped b-t b-light text-sm">
			<thead>
				<tr>
					<th><?=lang('date')?></th>
					<th><?=lang('invoice')?></th>
					<th><?=lang('amount')?> </th>
					<th><?=lang('trans_id')?></th>
				</tr> </thead> <tbody>
				<?php
				$user_payments = $this->db->where('paid_by',$i->co_id)->get(Applib::$payments_table)->result();
								if (!empty($user_payments)) {
				foreach ($user_payments as $key => $p) { ?>
                                <?php $cur = $this->applib->client_currency($p->paid_by); ?>
				<tr>
					<td><?=strftime(config_item('date_format'), strtotime($p->created_date));?></td>
					<td><a class="text-success" href="<?=base_url()?>invoices/view/<?=$p->invoice?>">
					<?=Applib::get_table_field(Applib::$invoices_table,array('inv_id' => $p->invoice),'reference_no')?>
					</a>
					</td>
					<td><?=$this->applib->fo_format_currency($cur->code, $p->amount)?></td>
					<td><?=$p->trans_id;?></td>
				</tr>
				<?php  }} else{ ?>
				<tr>
					<td></td><td><?=lang('nothing_to_display')?></td><td></td><td></td><td></td>
				</tr>
				<?php } ?>
				
				
				
			</tbody>
		</table>
		</section></div>


                                                        <!-- End -->
						</div>
					</section>
				</section>
			</section>
		</aside>
		<!-- /.aside -->
		<?php }} ?>
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>
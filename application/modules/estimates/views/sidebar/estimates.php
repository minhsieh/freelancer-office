<ul class="nav">
			<?php
			if (!empty($estimates)) {
			foreach ($estimates as $key => $estimate) { 
				if ($estimate->invoiced == 'Yes') {	$invoice_status = 'INVOICED'; $label = 'success'; }elseif ($estimate->emailed == 'Yes') {
					$invoice_status = 'SENT'; $label = 'info';	}else{	$invoice_status = 'DRAFT'; $label = 'default';	}
				?>
				<li class="b-b b-light <?php if($estimate->est_id == $this->uri->segment(3)){ echo "bg-light dk"; } ?>"><a href="<?=base_url()?>estimates/view/<?=$estimate->est_id?>">
				<?php
				if ($estimate->client == '0') { ?>
					<span class="label label-success">General Estimate</span>
				<?php }else{ ?>
				<?=ucfirst($this->applib->company_details($estimate->client,'company_name'))?>
				<?php } ?>
				<div class="pull-right">
				<?=$this->applib->fo_format_currency($estimate->currency, $this -> applib -> est_calculate('estimate_amount',$estimate->est_id))?>
				</div> <br>
				<small class="block small text-muted"><?=$estimate->reference_no?> <span class="label label-<?=$label?>"><?=$invoice_status?></span></small>

				</a> </li>
				<?php } } ?>
			</ul>
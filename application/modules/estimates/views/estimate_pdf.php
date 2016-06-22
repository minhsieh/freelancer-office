<?php
        function stripAccents($string) {
                $chars = array("Ά"=>"Α","ά"=>"α","Έ"=>"Ε","έ"=>"ε","Ή"=>"Η","ή"=>"η","Ί"=>"Ι","ί"=>"ι","Ό"=>"Ο","ό"=>"ο","Ύ"=>"Υ","ύ"=>"υ","Ώ"=>"Ω","ώ"=>"ω");
                foreach ($chars as $find => $replace) {
                    $string = str_replace($find, $replace, $string);
                }
                return $string;
        }
        
        $ratio = 1.3;
        $logo_height = intval(config_item('invoice_logo_height') / $ratio);
        $logo_width = intval(config_item('invoice_logo_width') / $ratio);
        $color = config_item('estimate_color');
        
$this->applib->set_locale();
$username = $this->tank_auth->get_username(); 
        if (!empty($estimate_details)) {
            foreach ($estimate_details as $key => $est) {
                $l = $this->applib->company_details($est->client, 'language');
                $lang2 = $this->lang->load('fx_lang', $l, TRUE, FALSE, '', TRUE);?>
<html>
<head>
<style>
body {
    font-family: dejavusanscondensed;
    font-size: 10pt;
    line-height: 13pt;
    color: #777777;
}
p { 
    margin: 0pt;
}
td { 
    vertical-align: top; 
}
.items td {
    border: 0.2mm solid #ffffff;
    background-color: #F5F5F5;
}
table thead td {
    vertical-align: bottom;
    text-align: center;
    text-transform: uppercase;
    font-size: 7pt;
    font-weight: bold;
    background-color: #FFFFFF;
    color: #111111;
}
table thead td {
    border-bottom: 0.2mm solid <?=$color?>;
}
table .last td  {
    border-bottom: 0.2mm solid <?=$color?>;
}
table .first td  {
    border-top: 0.2mm solid <?=$color?>;
}

</style>
</head>
<body>
<?php 
$watermark = $lang2[str_replace(" ","_",strtolower($est->status))];
$watermark = mb_strtoupper(stripAccents($watermark));
?>
<watermarktext content="<?=$watermark?>" alpha="0.05" />
<htmlpageheader name="myheader">
    <div style="height:120px">
<table width="100%"><tr>
<td width="50%" style="height: <?=$logo_height?>px; width: <?=$logo_width?>px;"><div>
<img style="height: <?=$logo_height?>px; width: <?=$logo_width?>px;" src="<?= base_url() ?>resource/images/logos/<?= config_item('invoice_logo') ?>" /></div></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 20pt; text-transform: uppercase; color: #111111;"><?=stripAccents($lang2['estimate'])?></td>
</tr></table>
        </div>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="font-size: 9pt; text-align: left; padding-top: 3mm; width:40%; float:left;">
<?=nl2br(config_item('estimate_footer'))?>
</div>
<div style="font-size: 9pt; text-align: right; padding-top: 3mm; width:40%; float:right;">
<?=$lang2['page']?> {PAGENO} <?=$lang2['page_of']?> {nb}
</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />

<div style="margin-bottom: 20px; margin-top: 10px;">
<table width="100%">
    <tr>
        <td width="62%"></td>
        <td width="25%" style="color: <?=$color?>; text-align: left; font-size: 9pt; text-transform: uppercase;"><?=stripAccents($lang2['reference_no'])?>:</td>
        <td width="13%" style="text-align: right; font-size: 9pt;"><?= $est->reference_no ?></td>
    </tr>
    <tr>
        <td width="62%"></td>
        <td width="25%" style="color: <?=$color?>; text-align: left; font-size: 9pt; text-transform: uppercase;"><?=stripAccents($lang2['invoice_date'])?>:</td>
        <td width="13%" style="text-align: right; font-size: 9pt;"><?= strftime(config_item('date_format'), strtotime($est->date_saved)); ?></td>
    </tr>
    <tr>
        <td width="62%"></td>
        <td width="25%" style="color: <?=$color?>; text-align: left; font-size: 9pt; text-transform: uppercase;"><?=stripAccents($lang2['valid_until'])?>:</td>
        <td width="13%" style="text-align: right; font-size: 9pt;"><?= strftime(config_item('date_format'), strtotime($est->due_date)); ?></td>
    </tr>
</table>
</div>

<div style="margin-bottom: 20px;">
<table width="100%" cellpadding="10" style="vertical-align: top;">
    <tr>
        <td width="45%" style="border-bottom:0.2mm solid <?=$color?>; font-size: 9pt; font-weight:bold; color: <?=$color?>; text-transform: uppercase;"><?= stripAccents($lang2['received_from']) ?></td>
        <td width="10%">&nbsp;</td>
        <td width="45%" style="border-bottom:0.2mm solid <?=$color?>; font-size: 9pt; font-weight:bold; color: <?=$color?>; text-transform: uppercase;"><?= stripAccents($lang2['bill_to']) ?></td>
    </tr>
<tr>
<td width="45%">
    <span style="font-size: 11pt; font-weight: bold; color: #111111;"><?= (config_item('company_legal_name_' . $l) ? config_item('company_legal_name_' . $l) : config_item('company_legal_name')) ?>
        </span><br/>
    <?= (config_item('company_address_' . $l) ? config_item('company_address_' . $l) : config_item('company_address')) ?><br>
    <?= (config_item('company_city_' . $l) ? config_item('company_city_' . $l) : config_item('company_city')) ?>
    <?php if (config_item('company_zip_code_' . $l) != '' || config_item('company_zip_code') != '') : ?>
    , <?= (config_item('company_zip_code_' . $l) ? config_item('company_zip_code_' . $l) : config_item('company_zip_code')) ?>
    <?php endif; ?><br>
    <?= (config_item('company_country_' . $l) ? config_item('company_country_' . $l) : config_item('company_country')) ?><br>
    <?=$lang2['phone']?> | <?= (config_item('company_phone_' . $l) ? config_item('company_phone_' . $l) : config_item('company_phone')) ?>
    <?php if (config_item('company_phone_2_'.$l) != '' || config_item('company_phone_2') != '') : ?>
        , <?= (config_item('company_phone_2_' . $l) ? config_item('company_phone_2_' . $l) : config_item('company_phone_2')) ?>
    <?php endif; ?><br>
    <?php if (config_item('company_fax_'.$l) != '' || config_item('company_fax_') != '') : ?>
    <?=$lang2['fax']?> | <?= (config_item('company_fax_' . $l) ? config_item('company_fax_' . $l) : config_item('company_fax')) ?>
    <?php endif; ?><br>
    <?=$lang2['vat']?> | <?= (config_item('company_vat_' . $l) ? config_item('company_vat_' . $l) : config_item('company_vat')) ?><br>
</td>
<td width="10%">&nbsp;</td>
<td width="45%">
        <span style="font-size: 11pt; font-weight: bold; color: #111111;"><?= $this->applib->company_details($est->client, 'company_name') ?></span><br/>
            <?= $this->applib->company_details($est->client, 'company_address') ?><br/>
            <?= $this->applib->company_details($est->client, 'city') ?>
            <?php if ($this->applib->company_details($est->client, 'zip') != '') { echo ", ".$this->applib->company_details($est->client, 'zip');  } ?><br/>
            <?= $this->applib->company_details($est->client, 'country') ?> <br/>
            <?php $phone = $this->applib->company_details($est->client, 'company_phone'); ?>
            <?php if ($phone != '') : ?>
            <span><?= $lang2['phone'] ?> | </span><?= $phone ?><br/>
            <?php endif; ?>
            <?php $fax = $this->applib->company_details($est->client, 'company_fax'); ?>
            <?php if ($fax != '') : ?>
            <span><?= $lang2['fax'] ?> | </span><?= $fax ?><br/>
            <?php endif; ?>
            <?php $vat = $this->applib->company_details($est->client, 'VAT'); ?>
            <?php if ($vat != '') : ?>
            <span><?= $lang2['company_vat'] ?> | </span><?=$vat?> <br/>
            <?php endif; ?>
</td>
</tr>       
</table>
</div>

<table class="items" width="100%" style="border-spacing:3px; font-size: 9pt; border-collapse: collapse;" cellpadding="10">
<thead>
<tr>
    <?php if(config_item('show_estimate_tax') == 'FALSE') : ?>
    <td width="60%" style="text-align: left; color: #111111;"><?= stripAccents($lang2['item_name']) ?> </td>
    <td width="10%"><?= stripAccents($lang2['qty']) ?> </td>
    <td width="15%"><?= stripAccents($lang2['unit_price']) ?> </td>
    <td width="15%"><?= stripAccents($lang2['total']) ?> </td>
    <?php else : ?>
    <td width="45%" style="text-align: left; color: #111111;"><?= stripAccents($lang2['item_name']) ?> </td>
    <td width="10%"><?= stripAccents($lang2['qty']) ?> </td>
    <td width="15%"><?= stripAccents($lang2['unit_price']) ?> </td>
    <td width="15%"><?= stripAccents($lang2['tax']) ?> </td>
    <td width="15%"><?= stripAccents($lang2['total']) ?> </td>
    <?php endif; ?>
</tr>
</thead>
<tbody>
<!-- ITEMS HERE -->
<?php
if (!empty($estimate_items)) {
    foreach ($estimate_items as $idx => $item) { ?>
    <tr<?= $idx + 1 == count($estimate_items) ? ' class="last"' : ''?>>
    <?php if(config_item('show_estimate_tax') == 'FALSE') : ?>
        <td width="60%" style="text-align: left;"><div style="margin-bottom:6px; font-weight:bold; color: #111111;"><?= $item->item_name?></div>
        <?= nl2br($item->item_desc) ?></td>
        <td width="10%" style="text-align: center;"><?=$this->applib->fo_format_quantity($item->quantity)?></td>
        <td width="15%" style="text-align: right;"><?=$this->applib->fo_format_currency($est->currency, $item->unit_cost) ?></td>
        <td width="15%" style="text-align: right;"><?=$this->applib->fo_format_currency($est->currency, $item->total_cost) ?>
    <?php else : ?>
        <td width="45%" style="text-align: left;"><div style="margin-bottom:6px; font-weight:bold; color: #111111;"><?= $item->item_name?></div>
        <?= nl2br($item->item_desc) ?></td>
        <td width="10%" style="text-align: center;"><?=$this->applib->fo_format_quantity($item->quantity)?></td>
        <td width="15%" style="text-align: right;"><?=$this->applib->fo_format_currency($est->currency, $item->unit_cost) ?></td>
        <td width="15%" style="text-align: right;"><?=$this->applib->fo_format_currency($est->currency, $item->item_tax_total) ?></td>
        <td width="15%" style="text-align: right;"><?=$this->applib->fo_format_currency($est->currency, $item->total_cost) ?>
    <?php endif; ?>
        </td>
    </tr>
<?php }
} ?>
    
    <tr class="first">
    <td colspan="<?=(config_item('show_estimate_tax') == 'FALSE' ? '2': '3')?>" style="background-color:#ffffff;"></td>
    <td style="font-size: 8pt; color: #111111;"><strong><?= $lang2['total'] ?></strong></td>
    <td style="font-weight: bold; color: #111111; text-align: right;"><?=$this->applib->fo_format_currency($est->currency, $this->applib-> est_calculate('estimate_cost', $est->est_id)) ?></td>
</tr>
<?php if ($est->tax > 0.00): ?>
    <tr>
        <td colspan="<?=(config_item('show_estimate_tax') == 'FALSE' ? '2': '3')?>" style="background-color:#ffffff;"></td>
        <td style="font-size: 8pt; color: #111111;">
            <strong><?= $lang2['tax'] ?> <?= $this->applib->fo_format_tax($est->tax)?>%</strong></td>
        <td style="font-weight: bold; text-align: right; color: #111111;"><?=$this->applib->fo_format_currency($est->currency, $this->applib->est_calculate('tax', $est->est_id)) ?></td>
    </tr>
<?php endif ?>
<?php if ($est->discount > 0) { ?>
    <tr>
        <td colspan="<?=(config_item('show_estimate_tax') == 'FALSE' ? '2': '3')?>" style="background-color:#ffffff;"></td>
        <td style="font-size: 8pt; color: #111111;">
            <strong><?= $lang2['discount'] ?> - <?=$this->applib->fo_format_tax($est->discount) ?>%</strong></td>
        <td style="font-weight: bold; text-align: right; color: #111111;"><?=$this->applib->fo_format_currency($est->currency, $this->applib->est_calculate('discount', $est->est_id)) ?></td>
    </tr>
    <?php } ?>
<tr>
    <td colspan="<?=(config_item('show_estimate_tax') == 'FALSE' ? '2': '3')?>" style="background-color:#ffffff;"></td>
    <td style="font-size: 8pt; color: #111111; background-color: <?=$color?>; color:#ffffff;"><strong><?= $lang2['estimate_cost'] ?></strong></td>
    <td style="font-weight: bold; color: #111111; text-align: right; background-color: <?=$color?>; color:#ffffff;"><?=$this->applib->fo_format_currency($est->currency, $this->applib->est_calculate('estimate_amount', $est->est_id)) ?></td>
</tr>
    
</tbody>
</table>
        <div style="margin-top:40px;">
            <h4 style="padding:5px 0; color: #111111; border-bottom: 0.2mm solid <?=$color?>; font-size:9pt; text-transform: uppercase;"><?= stripAccents($lang2['notes']) ?></h4>
            <?= $est->notes ?>
        </div>
    </body>
</html>
    <?php } // endforeach  ?>
<?php } // endif  ?>
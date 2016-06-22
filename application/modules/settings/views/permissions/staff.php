<!-- Display staff -->
<div class="table-responsive">
    <table id="table-staff" class="AppendDataTables table table-striped m-b-none">
        <thead>
        <tr>
            <th><?=lang('full_name')?></th>
            <th><?=lang('username')?> </th>
            <th><?=lang('role')?> </th>
            <th class="hidden-sm"><?=lang('registered_on')?> </th>

            <th class="col-options no-sort"><?=lang('options')?></th>
        </tr> </thead> <tbody>
        <?php
        $users = $this -> db -> where(array('role_id'=>'3')) -> get('users') -> result();
        if (!empty($users)) {
            $cc = 1;
            foreach ($users as $key => $user) { 
            $account = $this->db->where('user_id',$user->id)->get('account_details')->result();
            if (count($account) == 1) { $acc = $account[0];
            $cc += 1;
                ?>
                <tr>
                    <td><?=$acc->fullname?></td>
                    <td>

                        <a class="pull-left thumb-sm avatar">
                            <?php  ?>
                            <?php if(config_item('use_gravatar') == 'TRUE' AND $acc->use_gravatar == 'Y'){ ?>
                                <img src="<?=$this -> applib -> get_gravatar($user->email)?>" class="img-circle">
                            <?php }else{ 
                                
                                ?>
                                <img src="<?=base_url()?>resource/avatar/<?=$acc->avatar?>" class="img-circle">
                            <?php } ?>
                            <?=ucfirst($user->username)?>
                        </a>

                    </td>
                    <td>
                        <span class="label label-primary"><?=ucfirst($this -> user_profile -> role_by_id($user->role_id))?></span></td>
                    <td class="hidden-sm"><?=strftime(config_item('date_format'), strtotime($user->created));?> </td>

                    <td>
                        <a href="<?=base_url()?>settings/?settings=permissions&staff=<?=$user->id?>" class="btn btn-default btn-sm" title="<?=lang('edit_permissions')?>"><i class="fa fa-edit"></i> <?=lang('edit_permissions')?> </a>

                    </td>
                </tr>
            <?php } ?>
            <?php } } ?>


        </tbody>
    </table>
</div>

<!-- End staff -->
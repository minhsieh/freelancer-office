<section class="scrollable">
<?php 
if ($role == '1' OR $role == '3' OR $this -> applib -> project_setting('show_project_calendar',$project_id)) { ?>
    <div class="calendar" id="calendar"></div>
        <?php } ?>
</section>

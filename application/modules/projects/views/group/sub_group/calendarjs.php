<script type="text/javascript">
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            <?php
            $tasks = Applib::retrieve(Applib::$tasks_table, array('project' => $project_id));
            ?>
            eventAfterRender: function(event, element, view) {
                $(element).attr('data-toggle', 'ajaxModal').addClass('ajaxModal');
            },
            eventSources: [
                {
                    events: [// put the array in the `events` property
                    <?php foreach ($tasks as $key => $t) { ?>
                            {
                                title  : '<?=addslashes($t->task_name)?>',
                                description: '<?=addslashes($t->description)?>',
                                start  : '<?= date('Y-m-d', strtotime($t->due_date)) ?>',
                                end: '<?= date('Y-m-d', strtotime($t->due_date)) ?>',
                                url: '<?= base_url('calendar/event/tasks/' . $t->t_id) ?>'
                            },
                    <?php } ?>
                    ],
                    color: '#7266BA',
                    textColor: 'white'
                }
                // additional sources
            ]
        });
    });
</script>
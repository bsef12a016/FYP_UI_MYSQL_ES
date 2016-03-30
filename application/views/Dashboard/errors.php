<?php
$session = $this->session->all_userdata();
$status = FALSE;
?>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content page-thin">
    <div class="col-md-12 portlets ui-sortable">
        <div class="panel">
            <div class="panel-header">
<!--                <h3>Colored <strong>Header</strong></h3>-->

                <div class="control-btn">
                    <a class="panel-reload hidden" href="#"><i class="icon-reload"></i></a>
                    <a class="panel-maximize hidden" href="#"><i class="icon-size-fullscreen"></i></a>
                </div>
            </div>
            <div class="panel-content">
                <table class="table table-hover">
                    <?php
                    $status = FALSE;
                    foreach ($errors as $value) {
                        $status = TRUE;
                        ?>
                        <thead>
                            <tr>
                                <th>
                        <h2><strong>Errors</strong></h2>
                        </th>
                        <th>Events</th>
                        <th>Last Recieved</th>
                        </tr>
                        </thead>

                        <?php
                        break;
                    }
                    ?>
                    <tbody>
                        <?php
                        foreach ($errors as $value) {
                            $events_link = 'Dashboard/events/';
                            $events_link .= $session[USER_ID];
                            $events_link .= '/';
                            $events_link .= $value[ERRORS_TABLE_ID];
                            $events_link .= '/';
                            $events_link .= $value[ERRORS_TABLE_API_KEY];
                            ?>
                            <tr>
                                <td>
                                    <div class="row">
                                        <a href="<?= site_url($events_link) ?>" style="font-size: 1.5rem;">
                                            <div class="col-md-12">
                                                <span style="margin-top:0px; margin-bottom:10px; margin-right: 10px; font-weight: 600;">
                                                    <strong><?= $value[ERRORS_TABLE_CLASS] ?></strong>
                                                </span>
                                                <?= $value[ERRORS_TABLE_LAST_CONTEXT] ?>
                                            </div>
                                            <div class="col-md-12">
                                                <?= $value[ERRORS_TABLE_LAST_MESSAGE] ?>
                                            </div>
                                        </a>

                                    </div>


                                </td>
                                <td>
                                    <?= $value[ERRORS_TABLE_OCCURENCES] ?>
                                </td>
                                <td>
                                    <?= $value[ERRORS_TABLE_LAST_RECIEVED] ?>
                                </td>
                            </tr>
                            <?php
                        }
                        if ($status == FALSE) {
                            echo '<p><h3 style="margin:0px;">No Errors existing currently</h3></p>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$href_mainView = 'Dashboard/userDashboard/';
$href_mainView .= $session[USER_ID];
$href_mainView .= '/';
$href_mainView .= $session[PROJECT_ID];
?>
<script>
//    (function myFunction() {
//        setTimeout(function () {
//            window.location = "<?= site_url($href_mainView) ?>";
//        }, 300000);
//    })();

</script>




<?php
$session = $this->session->all_userdata();
$status = FALSE;
?>


<div class="page-content page-thin">
    <div class="col-md-12 portlets ui-sortable">
        <?php
        foreach ($error as $value) {
            ?>
            <div class="panel">
                <div class="panel-header bg-dark">
                    <h3><strong><?= 'Error (' . $value[ERRORS_TABLE_OCCURENCES] . ')' ?></strong></h3>

                    <!--                <div class="control-btn">
                                        <a class="panel-reload hidden" href="#"><i class="icon-reload"></i></a>
                                        <a class="panel-maximize hidden" href="#"><i class="icon-size-fullscreen"></i></a>
                                    </div>-->
                </div>
                <div class="panel-content">
                    <table class="table table-hover">
                        <tbody>

                            <tr>
                                <td>
                                    <div class="row">
                                        <a href="#" style="font-size: 1.5rem; cursor: not-allowed">
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
                                    <?= $value[ERRORS_TABLE_LAST_RECIEVED] ?>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <div class="col-md-12 portlets ui-sortable">
        <div class="panel">
            <div class="panel-header bg-dark">
                <h3><strong>Events</strong></h3>

                <div class="control-btn">
                    <a class="panel-reload hidden" href="#"><i class="icon-reload"></i></a>
                    <a class="panel-maximize hidden" href="#"><i class="icon-size-fullscreen"></i></a>
                </div>
            </div>
            <div class="panel-content">
                <table class="table table-hover">
                    <tbody>
                        <?php
                        foreach ($events as $value) {
                            $events_link = 'Dashboard/events_details/';
                            $events_link .= $session[USER_ID];
                            $events_link .= '/';
                            $events_link .= $value[EVENTS_TABLE_ID];
                            $events_link .= '/';
                            $events_link .= $value[EVENTS_TABLE_API_KEY];
                            ?>
                            <tr>
                                <td>
                                    <div class="row">
                                        <a href="<?= site_url($events_link) ?>" style="font-size: 1.5rem;">
                                            <div class="col-md-12">
                                                <span style="margin-top:0px; margin-bottom:10px; margin-right: 10px; font-weight: 600;">
                                                    <strong><?= $value[EVENTS_TABLE_CLASS] ?></strong>
                                                </span>
                                                <?= $value[EVENTS_TABLE_CONTEXT] ?>
                                            </div>
                                            <div class="col-md-12">
                                                <?= $value[EVENTS_TABLE_MESSAGE] ?>
                                            </div>
                                        </a>

                                    </div>


                                </td>
                                <td>
                                    <?= $value[EVENTS_TABLE_RECIEVED_AT] ?>
                                </td>
                            </tr>
                            <?php
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




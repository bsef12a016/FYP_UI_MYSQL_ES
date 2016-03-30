<?php $projectCount = 0; ?>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content page-thin">
    <div class="row">
        <?php
        foreach ($projects as $value) {
            $projectCount = 1;
            $href = 'Dashboard/errors/';
            $href .= $value[PROJECT_TABLE_USER_ID];
            $href .= '/';
            $href .= $value[PROJECT_TABLE_ID];
            $href .= '/';
            $href .= $value[PROJECT_TABLE_API_KEY];
            ?>
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-header bg-dark">
                        <a href="<?= site_url($href) ?>"><h3><strong><?= $value[PROJECT_TABLE_PROJECT_NAME] ?></strong></h3></a>
                    </div>
                    <div class="panel-content">
                        <p><h3 style="margin:0px;">Created Date: <?= $value[PROJECT_TABLE_CREATED_AT] ?></h3></p>
                        <!--<p>Error Count</p>-->
                    </div>
                </div>
            </div>
            <?php
        }
        if ($projectCount == 0) {
            ?>
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-header bg-dark">
                        <a href="<?= site_url('Dashboard/addProject') ?>" style="text-align: center;"><h3><strong>No Projects Added</strong> (Click here to add)</h3></a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<!-- END PAGE CONTENT -->
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="header">
        <h2>Select <strong>Data Source</strong></h2>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default no-bd">
                <div class="panel-header bg-dark">
                    <h2 class="panel-title">Select <strong>Data Source</strong></h2>
                </div>
                <div class="panel-body bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="skin skin-square">
                                <form role="form" action="<?=site_url('Dashboard/saveDataSource')?>" method="POST">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="icheck-list">
                                                    <label><input type="radio" name="dataSource" checked="" data-radio="iradio_square-blue" value="mysql"> MY SQL</label>
                                                    <label><input type="radio" name="dataSource" data-radio="iradio_square-blue" value="es">Elastic Search</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center  m-t-20">
                                            <input type="submit" class="btn btn-embossed btn-primary" value="Select">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT -->
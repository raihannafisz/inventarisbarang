<?php 
$page_id = null;
$comp_model = new SharedController;
$current_page = $this->set_current_page_link();
?>
<div>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <h4 >V 1.0 2021</h4>
                </div>
                <div class="col-md-3 col-sm-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_barang();  ?>
                    <a class="animated zoomIn record-count card bg-warning text-white"  href="<?php print_link("barang/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-building fa-3x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Barang</div>
                                    <small class=""></small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_ruang();  ?>
                    <a class="animated zoomIn record-count alert alert-info"  href="<?php print_link("ruang/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-building-o fa-3x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Ruang</div>
                                    <small class=""></small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_user();  ?>
                    <a class="animated zoomIn record-count alert alert-warning"  href="<?php print_link("user/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-user fa-3x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">User</div>
                                    <small class=""></small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-10 comp-grid">
                    <div class=""><div>Aplikasi inventaris barang ini merupakan sofware sebagai alat bantu untuk sistematis yang bisa mengawasi, melacak kondisi sebuah barang yang terdapat didalam lingkungan sebuah kantor baik pemerintah ataupun swasta</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

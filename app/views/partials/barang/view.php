<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("barang/add");
$can_edit = ACL::is_allowed("barang/edit");
$can_view = ACL::is_allowed("barang/view");
$can_delete = ACL::is_allowed("barang/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "view-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Barang</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if(!empty($data)){
                        $rec_id = (!empty($data['Id_Barang']) ? urlencode($data['Id_Barang']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-Id_Barang">
                                        <th class="title"> Id Barang: </th>
                                        <td class="value"> <?php echo $data['Id_Barang']; ?></td>
                                    </tr>
                                    <tr  class="td-Id_Kategori">
                                        <th class="title"> Id Kategori: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("kategori/view/" . urlencode($data['Id_Kategori'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['kategori_Kategori'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-Nama_Barang">
                                        <th class="title"> Nama Barang: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Nama_Barang']; ?>" 
                                                data-pk="<?php echo $data['Id_Barang'] ?>" 
                                                data-url="<?php print_link("barang/editfield/" . urlencode($data['Id_Barang'])); ?>" 
                                                data-name="Nama_Barang" 
                                                data-title="Enter Nama Barang" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="text" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['Nama_Barang']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-Merek">
                                        <th class="title"> Merek: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Merek']; ?>" 
                                                data-pk="<?php echo $data['Id_Barang'] ?>" 
                                                data-url="<?php print_link("barang/editfield/" . urlencode($data['Id_Barang'])); ?>" 
                                                data-name="Merek" 
                                                data-title="Enter Merek" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="text" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['Merek']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-Gambar_Barang">
                                        <th class="title"> Gambar Barang: </th>
                                        <td class="value"><?php Html :: page_img($data['Gambar_Barang'],400,400,1); ?></td>
                                    </tr>
                                    <tr  class="td-Jumlah_Aset">
                                        <th class="title"> Jumlah Aset: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Jumlah_Aset']; ?>" 
                                                data-pk="<?php echo $data['Id_Barang'] ?>" 
                                                data-url="<?php print_link("barang/editfield/" . urlencode($data['Id_Barang'])); ?>" 
                                                data-name="Jumlah_Aset" 
                                                data-title="Enter Jumlah Aset" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="number" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['Jumlah_Aset']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-Nilai_Per_Aset">
                                        <th class="title"> Nilai Per Aset: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Nilai_Per_Aset']; ?>" 
                                                data-pk="<?php echo $data['Id_Barang'] ?>" 
                                                data-url="<?php print_link("barang/editfield/" . urlencode($data['Id_Barang'])); ?>" 
                                                data-name="Nilai_Per_Aset" 
                                                data-title="Enter Nilai Per Aset" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="text" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['Nilai_Per_Aset']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-Id_Ruangan">
                                        <th class="title"> Id Ruangan: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("ruang/view/" . urlencode($data['Id_Ruangan'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['ruang_Ruangan'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-Id_Kondisi">
                                        <th class="title"> Id Kondisi: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("kondisi/view/" . urlencode($data['Id_Kondisi'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['kondisi_Kondisi'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-Asal_Perolehan">
                                        <th class="title"> Asal Perolehan: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Asal_Perolehan']; ?>" 
                                                data-pk="<?php echo $data['Id_Barang'] ?>" 
                                                data-url="<?php print_link("barang/editfield/" . urlencode($data['Id_Barang'])); ?>" 
                                                data-name="Asal_Perolehan" 
                                                data-title="Enter Asal Perolehan" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="text" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['Asal_Perolehan']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-Tahun_Perolehan">
                                        <th class="title"> Tahun Perolehan: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Tahun_Perolehan']; ?>" 
                                                data-pk="<?php echo $data['Id_Barang'] ?>" 
                                                data-url="<?php print_link("barang/editfield/" . urlencode($data['Id_Barang'])); ?>" 
                                                data-name="Tahun_Perolehan" 
                                                data-title="Enter Tahun Perolehan" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="number" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['Tahun_Perolehan']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                            <div class="dropup export-btn-holder mx-1">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-save"></i> Export
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <?php $export_print_link = $this->set_current_page_link(array('format' => 'print')); ?>
                                    <a class="dropdown-item export-link-btn" data-format="print" href="<?php print_link($export_print_link); ?>" target="_blank">
                                        <img src="<?php print_link('assets/images/print.png') ?>" class="mr-2" /> PRINT
                                        </a>
                                        <?php $export_pdf_link = $this->set_current_page_link(array('format' => 'pdf')); ?>
                                        <a class="dropdown-item export-link-btn" data-format="pdf" href="<?php print_link($export_pdf_link); ?>" target="_blank">
                                            <img src="<?php print_link('assets/images/pdf.png') ?>" class="mr-2" /> PDF
                                            </a>
                                            <?php $export_word_link = $this->set_current_page_link(array('format' => 'word')); ?>
                                            <a class="dropdown-item export-link-btn" data-format="word" href="<?php print_link($export_word_link); ?>" target="_blank">
                                                <img src="<?php print_link('assets/images/doc.png') ?>" class="mr-2" /> WORD
                                                </a>
                                                <?php $export_csv_link = $this->set_current_page_link(array('format' => 'csv')); ?>
                                                <a class="dropdown-item export-link-btn" data-format="csv" href="<?php print_link($export_csv_link); ?>" target="_blank">
                                                    <img src="<?php print_link('assets/images/csv.png') ?>" class="mr-2" /> CSV
                                                    </a>
                                                    <?php $export_excel_link = $this->set_current_page_link(array('format' => 'excel')); ?>
                                                    <a class="dropdown-item export-link-btn" data-format="excel" href="<?php print_link($export_excel_link); ?>" target="_blank">
                                                        <img src="<?php print_link('assets/images/xsl.png') ?>" class="mr-2" /> EXCEL
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php if($can_edit){ ?>
                                                <a class="btn btn-sm btn-info"  href="<?php print_link("barang/edit/$rec_id"); ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <?php } ?>
                                                <?php if($can_delete){ ?>
                                                <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("barang/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                                    <i class="fa fa-times"></i> Delete
                                                </a>
                                                <?php } ?>
                                            </div>
                                            <?php
                                            }
                                            else{
                                            ?>
                                            <!-- Empty Record Message -->
                                            <div class="text-muted p-3">
                                                <i class="fa fa-ban"></i> No Record Found
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

<?php 
/**
 * Barang Page Controller
 * @category  Controller
 */
class BarangController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "barang";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("Id_Barang", 
			"Id_Kategori", 
			"Nama_Barang", 
			"Merek", 
			"Gambar_Barang", 
			"Jumlah_Aset", 
			"Nilai_Per_Aset", 
			"Asal_Perolehan", 
			"Tahun_Perolehan");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				barang.Id_Barang LIKE ? OR 
				barang.Id_Kategori LIKE ? OR 
				barang.Nama_Barang LIKE ? OR 
				barang.Merek LIKE ? OR 
				barang.Gambar_Barang LIKE ? OR 
				barang.Jumlah_Aset LIKE ? OR 
				barang.Nilai_Per_Aset LIKE ? OR 
				barang.Id_Ruangan LIKE ? OR 
				barang.Id_Kondisi LIKE ? OR 
				barang.Asal_Perolehan LIKE ? OR 
				barang.Tahun_Perolehan LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "barang/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("barang.Id_Barang", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Barang";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("barang/list.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("barang.Id_Barang", 
			"barang.Id_Kategori", 
			"kategori.Kategori AS kategori_Kategori", 
			"barang.Nama_Barang", 
			"barang.Merek", 
			"barang.Gambar_Barang", 
			"barang.Jumlah_Aset", 
			"barang.Nilai_Per_Aset", 
			"barang.Id_Ruangan", 
			"ruang.Ruangan AS ruang_Ruangan", 
			"barang.Id_Kondisi", 
			"kondisi.Kondisi AS kondisi_Kondisi", 
			"barang.Asal_Perolehan", 
			"barang.Tahun_Perolehan");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("barang.Id_Barang", $rec_id);; //select record based on primary key
		}
		$db->join("kategori", "barang.Id_Kategori = kategori.Id_Kategori", "INNER");
		$db->join("ruang", "barang.Id_Ruangan = ruang.Id_Ruangan", "INNER");
		$db->join("kondisi", "barang.Id_Kondisi = kondisi.Id_Kondisi", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Barang";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("barang/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("Id_Kategori","Nama_Barang","Merek","Gambar_Barang","Jumlah_Aset","Nilai_Per_Aset","Id_Ruangan","Id_Kondisi","Asal_Perolehan","Tahun_Perolehan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'Id_Kategori' => 'required',
				'Nama_Barang' => 'required',
				'Merek' => 'required',
				'Gambar_Barang' => 'required',
				'Jumlah_Aset' => 'required|numeric',
				'Nilai_Per_Aset' => 'required',
				'Id_Ruangan' => 'required',
				'Id_Kondisi' => 'required',
				'Asal_Perolehan' => 'required',
				'Tahun_Perolehan' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'Id_Kategori' => 'sanitize_string',
				'Nama_Barang' => 'sanitize_string',
				'Merek' => 'sanitize_string',
				'Gambar_Barang' => 'sanitize_string',
				'Jumlah_Aset' => 'sanitize_string',
				'Nilai_Per_Aset' => 'sanitize_string',
				'Id_Ruangan' => 'sanitize_string',
				'Id_Kondisi' => 'sanitize_string',
				'Asal_Perolehan' => 'sanitize_string',
				'Tahun_Perolehan' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("barang");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Barang";
		$this->render_view("barang/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("Id_Barang","Id_Kategori","Nama_Barang","Merek","Gambar_Barang","Jumlah_Aset","Nilai_Per_Aset","Id_Ruangan","Id_Kondisi","Asal_Perolehan","Tahun_Perolehan");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'Id_Kategori' => 'required',
				'Nama_Barang' => 'required',
				'Merek' => 'required',
				'Gambar_Barang' => 'required',
				'Jumlah_Aset' => 'required|numeric',
				'Nilai_Per_Aset' => 'required',
				'Id_Ruangan' => 'required',
				'Id_Kondisi' => 'required',
				'Asal_Perolehan' => 'required',
				'Tahun_Perolehan' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'Id_Kategori' => 'sanitize_string',
				'Nama_Barang' => 'sanitize_string',
				'Merek' => 'sanitize_string',
				'Gambar_Barang' => 'sanitize_string',
				'Jumlah_Aset' => 'sanitize_string',
				'Nilai_Per_Aset' => 'sanitize_string',
				'Id_Ruangan' => 'sanitize_string',
				'Id_Kondisi' => 'sanitize_string',
				'Asal_Perolehan' => 'sanitize_string',
				'Tahun_Perolehan' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("barang.Id_Barang", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("barang");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("barang");
					}
				}
			}
		}
		$db->where("barang.Id_Barang", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Barang";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("barang/edit.php", $data);
	}
	/**
     * Update single field
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function editfield($rec_id = null, $formdata = null){
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("Id_Barang","Id_Kategori","Nama_Barang","Merek","Gambar_Barang","Jumlah_Aset","Nilai_Per_Aset","Id_Ruangan","Id_Kondisi","Asal_Perolehan","Tahun_Perolehan");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'Id_Kategori' => 'required',
				'Nama_Barang' => 'required',
				'Merek' => 'required',
				'Gambar_Barang' => 'required',
				'Jumlah_Aset' => 'required|numeric',
				'Nilai_Per_Aset' => 'required',
				'Id_Ruangan' => 'required',
				'Id_Kondisi' => 'required',
				'Asal_Perolehan' => 'required',
				'Tahun_Perolehan' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'Id_Kategori' => 'sanitize_string',
				'Nama_Barang' => 'sanitize_string',
				'Merek' => 'sanitize_string',
				'Gambar_Barang' => 'sanitize_string',
				'Jumlah_Aset' => 'sanitize_string',
				'Nilai_Per_Aset' => 'sanitize_string',
				'Id_Ruangan' => 'sanitize_string',
				'Id_Kondisi' => 'sanitize_string',
				'Asal_Perolehan' => 'sanitize_string',
				'Tahun_Perolehan' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("barang.Id_Barang", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount();
				if($bool && $numRows){
					return render_json(
						array(
							'num_rows' =>$numRows,
							'rec_id' =>$rec_id,
						)
					);
				}
				else{
					if($db->getLastError()){
						$page_error = $db->getLastError();
					}
					elseif(!$numRows){
						$page_error = "No record updated";
					}
					render_error($page_error);
				}
			}
			else{
				render_error($this->view->page_error);
			}
		}
		return null;
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("barang.Id_Barang", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("barang");
	}
}

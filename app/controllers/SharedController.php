<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * barang_Id_Kategori_option_list Model Action
     * @return array
     */
	function barang_Id_Kategori_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT Kategori AS value , Kategori AS label FROM kategori ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * barang_Id_Ruangan_option_list Model Action
     * @return array
     */
	function barang_Id_Ruangan_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT Id_Ruangan AS value,Ruangan AS label FROM ruang";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * barang_Id_Kondisi_option_list Model Action
     * @return array
     */
	function barang_Id_Kondisi_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT Id_Kondisi AS value,Kondisi AS label FROM kondisi";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * user_user_role_id_option_list Model Action
     * @return array
     */
	function user_user_role_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT role_id AS value, role_name AS label FROM roles";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * user_username_value_exist Model Action
     * @return array
     */
	function user_username_value_exist($val){
		$db = $this->GetModel();
		$db->where("username", $val);
		$exist = $db->has("user");
		return $exist;
	}

	/**
     * user_email_value_exist Model Action
     * @return array
     */
	function user_email_value_exist($val){
		$db = $this->GetModel();
		$db->where("email", $val);
		$exist = $db->has("user");
		return $exist;
	}

	/**
     * getcount_barang Model Action
     * @return Value
     */
	function getcount_barang(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM barang";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
     * getcount_ruang Model Action
     * @return Value
     */
	function getcount_ruang(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM ruang";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
     * getcount_user Model Action
     * @return Value
     */
	function getcount_user(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM user";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

}

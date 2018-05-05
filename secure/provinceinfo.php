<?php

// Global variable for table object
$province = NULL;

//
// Table class for province
//
class cprovince extends cTable {
	var $province_id;
	var $country_id;
	var $province_name_kh;
	var $province_name_en;
	var $capital_kh;
	var $capital_en;
	var $population_kh;
	var $population_en;
	var $area_kh;
	var $area_en;
	var $density_kh;
	var $density_en;
	var $province_code;
	var $image;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'province';
		$this->TableName = 'province';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`province`";
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// province_id
		$this->province_id = new cField('province', 'province', 'x_province_id', 'province_id', '`province_id`', '`province_id`', 3, -1, FALSE, '`province_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->province_id->Sortable = TRUE; // Allow sort
		$this->province_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['province_id'] = &$this->province_id;

		// country_id
		$this->country_id = new cField('province', 'province', 'x_country_id', 'country_id', '`country_id`', '`country_id`', 3, -1, FALSE, '`country_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->country_id->Sortable = TRUE; // Allow sort
		$this->country_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['country_id'] = &$this->country_id;

		// province_name_kh
		$this->province_name_kh = new cField('province', 'province', 'x_province_name_kh', 'province_name_kh', '`province_name_kh`', '`province_name_kh`', 200, -1, FALSE, '`province_name_kh`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->province_name_kh->Sortable = TRUE; // Allow sort
		$this->fields['province_name_kh'] = &$this->province_name_kh;

		// province_name_en
		$this->province_name_en = new cField('province', 'province', 'x_province_name_en', 'province_name_en', '`province_name_en`', '`province_name_en`', 200, -1, FALSE, '`province_name_en`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->province_name_en->Sortable = TRUE; // Allow sort
		$this->fields['province_name_en'] = &$this->province_name_en;

		// capital_kh
		$this->capital_kh = new cField('province', 'province', 'x_capital_kh', 'capital_kh', '`capital_kh`', '`capital_kh`', 200, -1, FALSE, '`capital_kh`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->capital_kh->Sortable = TRUE; // Allow sort
		$this->fields['capital_kh'] = &$this->capital_kh;

		// capital_en
		$this->capital_en = new cField('province', 'province', 'x_capital_en', 'capital_en', '`capital_en`', '`capital_en`', 200, -1, FALSE, '`capital_en`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->capital_en->Sortable = TRUE; // Allow sort
		$this->fields['capital_en'] = &$this->capital_en;

		// population_kh
		$this->population_kh = new cField('province', 'province', 'x_population_kh', 'population_kh', '`population_kh`', '`population_kh`', 200, -1, FALSE, '`population_kh`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->population_kh->Sortable = TRUE; // Allow sort
		$this->fields['population_kh'] = &$this->population_kh;

		// population_en
		$this->population_en = new cField('province', 'province', 'x_population_en', 'population_en', '`population_en`', '`population_en`', 200, -1, FALSE, '`population_en`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->population_en->Sortable = TRUE; // Allow sort
		$this->fields['population_en'] = &$this->population_en;

		// area_kh
		$this->area_kh = new cField('province', 'province', 'x_area_kh', 'area_kh', '`area_kh`', '`area_kh`', 200, -1, FALSE, '`area_kh`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->area_kh->Sortable = TRUE; // Allow sort
		$this->fields['area_kh'] = &$this->area_kh;

		// area_en
		$this->area_en = new cField('province', 'province', 'x_area_en', 'area_en', '`area_en`', '`area_en`', 200, -1, FALSE, '`area_en`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->area_en->Sortable = TRUE; // Allow sort
		$this->fields['area_en'] = &$this->area_en;

		// density_kh
		$this->density_kh = new cField('province', 'province', 'x_density_kh', 'density_kh', '`density_kh`', '`density_kh`', 200, -1, FALSE, '`density_kh`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->density_kh->Sortable = TRUE; // Allow sort
		$this->fields['density_kh'] = &$this->density_kh;

		// density_en
		$this->density_en = new cField('province', 'province', 'x_density_en', 'density_en', '`density_en`', '`density_en`', 200, -1, FALSE, '`density_en`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->density_en->Sortable = TRUE; // Allow sort
		$this->fields['density_en'] = &$this->density_en;

		// province_code
		$this->province_code = new cField('province', 'province', 'x_province_code', 'province_code', '`province_code`', '`province_code`', 200, -1, FALSE, '`province_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->province_code->Sortable = TRUE; // Allow sort
		$this->fields['province_code'] = &$this->province_code;

		// image
		$this->image = new cField('province', 'province', 'x_image', 'image', '`image`', '`image`', 200, -1, FALSE, '`image`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->image->Sortable = TRUE; // Allow sort
		$this->fields['image'] = &$this->image;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`province`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->province_id->setDbValue($conn->Insert_ID());
			$rs['province_id'] = $this->province_id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('province_id', $rs))
				ew_AddFilter($where, ew_QuotedName('province_id', $this->DBID) . '=' . ew_QuotedValue($rs['province_id'], $this->province_id->FldDataType, $this->DBID));
			if (array_key_exists('country_id', $rs))
				ew_AddFilter($where, ew_QuotedName('country_id', $this->DBID) . '=' . ew_QuotedValue($rs['country_id'], $this->country_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`province_id` = @province_id@ AND `country_id` = @country_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->province_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->province_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@province_id@", ew_AdjustSql($this->province_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->country_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->country_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@country_id@", ew_AdjustSql($this->country_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "provincelist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "provinceview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "provinceedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "provinceadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "provincelist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("provinceview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("provinceview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "provinceadd.php?" . $this->UrlParm($parm);
		else
			$url = "provinceadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("provinceedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("provinceadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("provincedelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "province_id:" . ew_VarToJson($this->province_id->CurrentValue, "number", "'");
		$json .= ",country_id:" . ew_VarToJson($this->country_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->province_id->CurrentValue)) {
			$sUrl .= "province_id=" . urlencode($this->province_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->country_id->CurrentValue)) {
			$sUrl .= "&country_id=" . urlencode($this->country_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["province_id"]))
				$arKey[] = $_POST["province_id"];
			elseif (isset($_GET["province_id"]))
				$arKey[] = $_GET["province_id"];
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["country_id"]))
				$arKey[] = $_POST["country_id"];
			elseif (isset($_GET["country_id"]))
				$arKey[] = $_GET["country_id"];
			else
				$arKeys = NULL; // Do not setup
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) <> 2)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // province_id
					continue;
				if (!is_numeric($key[1])) // country_id
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->province_id->CurrentValue = $key[0];
			$this->country_id->CurrentValue = $key[1];
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->province_id->setDbValue($rs->fields('province_id'));
		$this->country_id->setDbValue($rs->fields('country_id'));
		$this->province_name_kh->setDbValue($rs->fields('province_name_kh'));
		$this->province_name_en->setDbValue($rs->fields('province_name_en'));
		$this->capital_kh->setDbValue($rs->fields('capital_kh'));
		$this->capital_en->setDbValue($rs->fields('capital_en'));
		$this->population_kh->setDbValue($rs->fields('population_kh'));
		$this->population_en->setDbValue($rs->fields('population_en'));
		$this->area_kh->setDbValue($rs->fields('area_kh'));
		$this->area_en->setDbValue($rs->fields('area_en'));
		$this->density_kh->setDbValue($rs->fields('density_kh'));
		$this->density_en->setDbValue($rs->fields('density_en'));
		$this->province_code->setDbValue($rs->fields('province_code'));
		$this->image->setDbValue($rs->fields('image'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// province_id
		// country_id
		// province_name_kh
		// province_name_en
		// capital_kh
		// capital_en
		// population_kh
		// population_en
		// area_kh
		// area_en
		// density_kh
		// density_en
		// province_code
		// image
		// province_id

		$this->province_id->ViewValue = $this->province_id->CurrentValue;
		$this->province_id->ViewCustomAttributes = "";

		// country_id
		$this->country_id->ViewValue = $this->country_id->CurrentValue;
		$this->country_id->ViewCustomAttributes = "";

		// province_name_kh
		$this->province_name_kh->ViewValue = $this->province_name_kh->CurrentValue;
		$this->province_name_kh->ViewCustomAttributes = "";

		// province_name_en
		$this->province_name_en->ViewValue = $this->province_name_en->CurrentValue;
		$this->province_name_en->ViewCustomAttributes = "";

		// capital_kh
		$this->capital_kh->ViewValue = $this->capital_kh->CurrentValue;
		$this->capital_kh->ViewCustomAttributes = "";

		// capital_en
		$this->capital_en->ViewValue = $this->capital_en->CurrentValue;
		$this->capital_en->ViewCustomAttributes = "";

		// population_kh
		$this->population_kh->ViewValue = $this->population_kh->CurrentValue;
		$this->population_kh->ViewCustomAttributes = "";

		// population_en
		$this->population_en->ViewValue = $this->population_en->CurrentValue;
		$this->population_en->ViewCustomAttributes = "";

		// area_kh
		$this->area_kh->ViewValue = $this->area_kh->CurrentValue;
		$this->area_kh->ViewCustomAttributes = "";

		// area_en
		$this->area_en->ViewValue = $this->area_en->CurrentValue;
		$this->area_en->ViewCustomAttributes = "";

		// density_kh
		$this->density_kh->ViewValue = $this->density_kh->CurrentValue;
		$this->density_kh->ViewCustomAttributes = "";

		// density_en
		$this->density_en->ViewValue = $this->density_en->CurrentValue;
		$this->density_en->ViewCustomAttributes = "";

		// province_code
		$this->province_code->ViewValue = $this->province_code->CurrentValue;
		$this->province_code->ViewCustomAttributes = "";

		// image
		$this->image->ViewValue = $this->image->CurrentValue;
		$this->image->ViewCustomAttributes = "";

		// province_id
		$this->province_id->LinkCustomAttributes = "";
		$this->province_id->HrefValue = "";
		$this->province_id->TooltipValue = "";

		// country_id
		$this->country_id->LinkCustomAttributes = "";
		$this->country_id->HrefValue = "";
		$this->country_id->TooltipValue = "";

		// province_name_kh
		$this->province_name_kh->LinkCustomAttributes = "";
		$this->province_name_kh->HrefValue = "";
		$this->province_name_kh->TooltipValue = "";

		// province_name_en
		$this->province_name_en->LinkCustomAttributes = "";
		$this->province_name_en->HrefValue = "";
		$this->province_name_en->TooltipValue = "";

		// capital_kh
		$this->capital_kh->LinkCustomAttributes = "";
		$this->capital_kh->HrefValue = "";
		$this->capital_kh->TooltipValue = "";

		// capital_en
		$this->capital_en->LinkCustomAttributes = "";
		$this->capital_en->HrefValue = "";
		$this->capital_en->TooltipValue = "";

		// population_kh
		$this->population_kh->LinkCustomAttributes = "";
		$this->population_kh->HrefValue = "";
		$this->population_kh->TooltipValue = "";

		// population_en
		$this->population_en->LinkCustomAttributes = "";
		$this->population_en->HrefValue = "";
		$this->population_en->TooltipValue = "";

		// area_kh
		$this->area_kh->LinkCustomAttributes = "";
		$this->area_kh->HrefValue = "";
		$this->area_kh->TooltipValue = "";

		// area_en
		$this->area_en->LinkCustomAttributes = "";
		$this->area_en->HrefValue = "";
		$this->area_en->TooltipValue = "";

		// density_kh
		$this->density_kh->LinkCustomAttributes = "";
		$this->density_kh->HrefValue = "";
		$this->density_kh->TooltipValue = "";

		// density_en
		$this->density_en->LinkCustomAttributes = "";
		$this->density_en->HrefValue = "";
		$this->density_en->TooltipValue = "";

		// province_code
		$this->province_code->LinkCustomAttributes = "";
		$this->province_code->HrefValue = "";
		$this->province_code->TooltipValue = "";

		// image
		$this->image->LinkCustomAttributes = "";
		$this->image->HrefValue = "";
		$this->image->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// province_id
		$this->province_id->EditAttrs["class"] = "form-control";
		$this->province_id->EditCustomAttributes = "";
		$this->province_id->EditValue = $this->province_id->CurrentValue;
		$this->province_id->ViewCustomAttributes = "";

		// country_id
		$this->country_id->EditAttrs["class"] = "form-control";
		$this->country_id->EditCustomAttributes = "";
		$this->country_id->EditValue = $this->country_id->CurrentValue;
		$this->country_id->ViewCustomAttributes = "";

		// province_name_kh
		$this->province_name_kh->EditAttrs["class"] = "form-control";
		$this->province_name_kh->EditCustomAttributes = "";
		$this->province_name_kh->EditValue = $this->province_name_kh->CurrentValue;
		$this->province_name_kh->PlaceHolder = ew_RemoveHtml($this->province_name_kh->FldCaption());

		// province_name_en
		$this->province_name_en->EditAttrs["class"] = "form-control";
		$this->province_name_en->EditCustomAttributes = "";
		$this->province_name_en->EditValue = $this->province_name_en->CurrentValue;
		$this->province_name_en->PlaceHolder = ew_RemoveHtml($this->province_name_en->FldCaption());

		// capital_kh
		$this->capital_kh->EditAttrs["class"] = "form-control";
		$this->capital_kh->EditCustomAttributes = "";
		$this->capital_kh->EditValue = $this->capital_kh->CurrentValue;
		$this->capital_kh->PlaceHolder = ew_RemoveHtml($this->capital_kh->FldCaption());

		// capital_en
		$this->capital_en->EditAttrs["class"] = "form-control";
		$this->capital_en->EditCustomAttributes = "";
		$this->capital_en->EditValue = $this->capital_en->CurrentValue;
		$this->capital_en->PlaceHolder = ew_RemoveHtml($this->capital_en->FldCaption());

		// population_kh
		$this->population_kh->EditAttrs["class"] = "form-control";
		$this->population_kh->EditCustomAttributes = "";
		$this->population_kh->EditValue = $this->population_kh->CurrentValue;
		$this->population_kh->PlaceHolder = ew_RemoveHtml($this->population_kh->FldCaption());

		// population_en
		$this->population_en->EditAttrs["class"] = "form-control";
		$this->population_en->EditCustomAttributes = "";
		$this->population_en->EditValue = $this->population_en->CurrentValue;
		$this->population_en->PlaceHolder = ew_RemoveHtml($this->population_en->FldCaption());

		// area_kh
		$this->area_kh->EditAttrs["class"] = "form-control";
		$this->area_kh->EditCustomAttributes = "";
		$this->area_kh->EditValue = $this->area_kh->CurrentValue;
		$this->area_kh->PlaceHolder = ew_RemoveHtml($this->area_kh->FldCaption());

		// area_en
		$this->area_en->EditAttrs["class"] = "form-control";
		$this->area_en->EditCustomAttributes = "";
		$this->area_en->EditValue = $this->area_en->CurrentValue;
		$this->area_en->PlaceHolder = ew_RemoveHtml($this->area_en->FldCaption());

		// density_kh
		$this->density_kh->EditAttrs["class"] = "form-control";
		$this->density_kh->EditCustomAttributes = "";
		$this->density_kh->EditValue = $this->density_kh->CurrentValue;
		$this->density_kh->PlaceHolder = ew_RemoveHtml($this->density_kh->FldCaption());

		// density_en
		$this->density_en->EditAttrs["class"] = "form-control";
		$this->density_en->EditCustomAttributes = "";
		$this->density_en->EditValue = $this->density_en->CurrentValue;
		$this->density_en->PlaceHolder = ew_RemoveHtml($this->density_en->FldCaption());

		// province_code
		$this->province_code->EditAttrs["class"] = "form-control";
		$this->province_code->EditCustomAttributes = "";
		$this->province_code->EditValue = $this->province_code->CurrentValue;
		$this->province_code->PlaceHolder = ew_RemoveHtml($this->province_code->FldCaption());

		// image
		$this->image->EditAttrs["class"] = "form-control";
		$this->image->EditCustomAttributes = "";
		$this->image->EditValue = $this->image->CurrentValue;
		$this->image->PlaceHolder = ew_RemoveHtml($this->image->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->province_id->Exportable) $Doc->ExportCaption($this->province_id);
					if ($this->country_id->Exportable) $Doc->ExportCaption($this->country_id);
					if ($this->province_name_kh->Exportable) $Doc->ExportCaption($this->province_name_kh);
					if ($this->province_name_en->Exportable) $Doc->ExportCaption($this->province_name_en);
					if ($this->capital_kh->Exportable) $Doc->ExportCaption($this->capital_kh);
					if ($this->capital_en->Exportable) $Doc->ExportCaption($this->capital_en);
					if ($this->population_kh->Exportable) $Doc->ExportCaption($this->population_kh);
					if ($this->population_en->Exportable) $Doc->ExportCaption($this->population_en);
					if ($this->area_kh->Exportable) $Doc->ExportCaption($this->area_kh);
					if ($this->area_en->Exportable) $Doc->ExportCaption($this->area_en);
					if ($this->density_kh->Exportable) $Doc->ExportCaption($this->density_kh);
					if ($this->density_en->Exportable) $Doc->ExportCaption($this->density_en);
					if ($this->province_code->Exportable) $Doc->ExportCaption($this->province_code);
					if ($this->image->Exportable) $Doc->ExportCaption($this->image);
				} else {
					if ($this->province_id->Exportable) $Doc->ExportCaption($this->province_id);
					if ($this->country_id->Exportable) $Doc->ExportCaption($this->country_id);
					if ($this->province_name_kh->Exportable) $Doc->ExportCaption($this->province_name_kh);
					if ($this->province_name_en->Exportable) $Doc->ExportCaption($this->province_name_en);
					if ($this->capital_kh->Exportable) $Doc->ExportCaption($this->capital_kh);
					if ($this->capital_en->Exportable) $Doc->ExportCaption($this->capital_en);
					if ($this->population_kh->Exportable) $Doc->ExportCaption($this->population_kh);
					if ($this->population_en->Exportable) $Doc->ExportCaption($this->population_en);
					if ($this->area_kh->Exportable) $Doc->ExportCaption($this->area_kh);
					if ($this->area_en->Exportable) $Doc->ExportCaption($this->area_en);
					if ($this->density_kh->Exportable) $Doc->ExportCaption($this->density_kh);
					if ($this->density_en->Exportable) $Doc->ExportCaption($this->density_en);
					if ($this->province_code->Exportable) $Doc->ExportCaption($this->province_code);
					if ($this->image->Exportable) $Doc->ExportCaption($this->image);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->province_id->Exportable) $Doc->ExportField($this->province_id);
						if ($this->country_id->Exportable) $Doc->ExportField($this->country_id);
						if ($this->province_name_kh->Exportable) $Doc->ExportField($this->province_name_kh);
						if ($this->province_name_en->Exportable) $Doc->ExportField($this->province_name_en);
						if ($this->capital_kh->Exportable) $Doc->ExportField($this->capital_kh);
						if ($this->capital_en->Exportable) $Doc->ExportField($this->capital_en);
						if ($this->population_kh->Exportable) $Doc->ExportField($this->population_kh);
						if ($this->population_en->Exportable) $Doc->ExportField($this->population_en);
						if ($this->area_kh->Exportable) $Doc->ExportField($this->area_kh);
						if ($this->area_en->Exportable) $Doc->ExportField($this->area_en);
						if ($this->density_kh->Exportable) $Doc->ExportField($this->density_kh);
						if ($this->density_en->Exportable) $Doc->ExportField($this->density_en);
						if ($this->province_code->Exportable) $Doc->ExportField($this->province_code);
						if ($this->image->Exportable) $Doc->ExportField($this->image);
					} else {
						if ($this->province_id->Exportable) $Doc->ExportField($this->province_id);
						if ($this->country_id->Exportable) $Doc->ExportField($this->country_id);
						if ($this->province_name_kh->Exportable) $Doc->ExportField($this->province_name_kh);
						if ($this->province_name_en->Exportable) $Doc->ExportField($this->province_name_en);
						if ($this->capital_kh->Exportable) $Doc->ExportField($this->capital_kh);
						if ($this->capital_en->Exportable) $Doc->ExportField($this->capital_en);
						if ($this->population_kh->Exportable) $Doc->ExportField($this->population_kh);
						if ($this->population_en->Exportable) $Doc->ExportField($this->population_en);
						if ($this->area_kh->Exportable) $Doc->ExportField($this->area_kh);
						if ($this->area_en->Exportable) $Doc->ExportField($this->area_en);
						if ($this->density_kh->Exportable) $Doc->ExportField($this->density_kh);
						if ($this->density_en->Exportable) $Doc->ExportField($this->density_en);
						if ($this->province_code->Exportable) $Doc->ExportField($this->province_code);
						if ($this->image->Exportable) $Doc->ExportField($this->image);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>

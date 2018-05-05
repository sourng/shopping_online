<?php

// Global variable for table object
$company = NULL;

//
// Table class for company
//
class ccompany extends cTable {
	var $company_id;
	var $com_fname;
	var $com_lname;
	var $com_name;
	var $com_address;
	var $com_phone;
	var $com_email;
	var $com_fb;
	var $com_tw;
	var $com_yt;
	var $com_logo;
	var $com_username;
	var $com_password;
	var $com_online;
	var $com_activation;
	var $com_status;
	var $reg_date;
	var $country_id;
	var $province_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'company';
		$this->TableName = 'company';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`company`";
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

		// company_id
		$this->company_id = new cField('company', 'company', 'x_company_id', 'company_id', '`company_id`', '`company_id`', 3, -1, FALSE, '`company_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->company_id->Sortable = TRUE; // Allow sort
		$this->company_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['company_id'] = &$this->company_id;

		// com_fname
		$this->com_fname = new cField('company', 'company', 'x_com_fname', 'com_fname', '`com_fname`', '`com_fname`', 200, -1, FALSE, '`com_fname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->com_fname->Sortable = TRUE; // Allow sort
		$this->fields['com_fname'] = &$this->com_fname;

		// com_lname
		$this->com_lname = new cField('company', 'company', 'x_com_lname', 'com_lname', '`com_lname`', '`com_lname`', 200, -1, FALSE, '`com_lname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->com_lname->Sortable = TRUE; // Allow sort
		$this->fields['com_lname'] = &$this->com_lname;

		// com_name
		$this->com_name = new cField('company', 'company', 'x_com_name', 'com_name', '`com_name`', '`com_name`', 200, -1, FALSE, '`com_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->com_name->Sortable = TRUE; // Allow sort
		$this->fields['com_name'] = &$this->com_name;

		// com_address
		$this->com_address = new cField('company', 'company', 'x_com_address', 'com_address', '`com_address`', '`com_address`', 200, -1, FALSE, '`com_address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->com_address->Sortable = TRUE; // Allow sort
		$this->fields['com_address'] = &$this->com_address;

		// com_phone
		$this->com_phone = new cField('company', 'company', 'x_com_phone', 'com_phone', '`com_phone`', '`com_phone`', 200, -1, FALSE, '`com_phone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->com_phone->Sortable = TRUE; // Allow sort
		$this->fields['com_phone'] = &$this->com_phone;

		// com_email
		$this->com_email = new cField('company', 'company', 'x_com_email', 'com_email', '`com_email`', '`com_email`', 200, -1, FALSE, '`com_email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->com_email->Sortable = TRUE; // Allow sort
		$this->fields['com_email'] = &$this->com_email;

		// com_fb
		$this->com_fb = new cField('company', 'company', 'x_com_fb', 'com_fb', '`com_fb`', '`com_fb`', 200, -1, FALSE, '`com_fb`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->com_fb->Sortable = TRUE; // Allow sort
		$this->fields['com_fb'] = &$this->com_fb;

		// com_tw
		$this->com_tw = new cField('company', 'company', 'x_com_tw', 'com_tw', '`com_tw`', '`com_tw`', 200, -1, FALSE, '`com_tw`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->com_tw->Sortable = TRUE; // Allow sort
		$this->fields['com_tw'] = &$this->com_tw;

		// com_yt
		$this->com_yt = new cField('company', 'company', 'x_com_yt', 'com_yt', '`com_yt`', '`com_yt`', 200, -1, FALSE, '`com_yt`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->com_yt->Sortable = TRUE; // Allow sort
		$this->fields['com_yt'] = &$this->com_yt;

		// com_logo
		$this->com_logo = new cField('company', 'company', 'x_com_logo', 'com_logo', '`com_logo`', '`com_logo`', 200, -1, TRUE, '`com_logo`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->com_logo->Sortable = TRUE; // Allow sort
		$this->fields['com_logo'] = &$this->com_logo;

		// com_username
		$this->com_username = new cField('company', 'company', 'x_com_username', 'com_username', '`com_username`', '`com_username`', 200, -1, FALSE, '`com_username`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->com_username->Sortable = TRUE; // Allow sort
		$this->fields['com_username'] = &$this->com_username;

		// com_password
		$this->com_password = new cField('company', 'company', 'x_com_password', 'com_password', '`com_password`', '`com_password`', 200, -1, FALSE, '`com_password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->com_password->Sortable = TRUE; // Allow sort
		$this->fields['com_password'] = &$this->com_password;

		// com_online
		$this->com_online = new cField('company', 'company', 'x_com_online', 'com_online', '`com_online`', '`com_online`', 200, -1, FALSE, '`com_online`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->com_online->Sortable = TRUE; // Allow sort
		$this->com_online->OptionCount = 2;
		$this->fields['com_online'] = &$this->com_online;

		// com_activation
		$this->com_activation = new cField('company', 'company', 'x_com_activation', 'com_activation', '`com_activation`', '`com_activation`', 200, -1, FALSE, '`com_activation`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->com_activation->Sortable = TRUE; // Allow sort
		$this->com_activation->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->com_activation->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->com_activation->OptionCount = 2;
		$this->fields['com_activation'] = &$this->com_activation;

		// com_status
		$this->com_status = new cField('company', 'company', 'x_com_status', 'com_status', '`com_status`', '`com_status`', 200, -1, FALSE, '`com_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->com_status->Sortable = TRUE; // Allow sort
		$this->com_status->OptionCount = 2;
		$this->fields['com_status'] = &$this->com_status;

		// reg_date
		$this->reg_date = new cField('company', 'company', 'x_reg_date', 'reg_date', '`reg_date`', ew_CastDateFieldForLike('`reg_date`', 1, "DB"), 135, 1, FALSE, '`reg_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->reg_date->Sortable = TRUE; // Allow sort
		$this->reg_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['reg_date'] = &$this->reg_date;

		// country_id
		$this->country_id = new cField('company', 'company', 'x_country_id', 'country_id', '`country_id`', '`country_id`', 3, -1, FALSE, '`country_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->country_id->Sortable = TRUE; // Allow sort
		$this->country_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->country_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->country_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['country_id'] = &$this->country_id;

		// province_id
		$this->province_id = new cField('company', 'company', 'x_province_id', 'province_id', '`province_id`', '`province_id`', 3, -1, FALSE, '`EV__province_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'SELECT');
		$this->province_id->Sortable = TRUE; // Allow sort
		$this->province_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->province_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->province_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['province_id'] = &$this->province_id;
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
			$sSortFieldList = ($ofld->FldVirtualExpression <> "") ? $ofld->FldVirtualExpression : $sSortField;
			if ($ctrl) {
				$sOrderByList = $this->getSessionOrderByList();
				if (strpos($sOrderByList, $sSortFieldList . " " . $sLastSort) !== FALSE) {
					$sOrderByList = str_replace($sSortFieldList . " " . $sLastSort, $sSortFieldList . " " . $sThisSort, $sOrderByList);
				} else {
					if ($sOrderByList <> "") $sOrderByList .= ", ";
					$sOrderByList .= $sSortFieldList . " " . $sThisSort;
				}
				$this->setSessionOrderByList($sOrderByList); // Save to Session
			} else {
				$this->setSessionOrderByList($sSortFieldList . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Session ORDER BY for List page
	function getSessionOrderByList() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST];
	}

	function setSessionOrderByList($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST] = $v;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`company`";
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
	var $_SqlSelectList = "";

	function getSqlSelectList() { // Select for List page
		$select = "";
		$select = "SELECT * FROM (" .
			"SELECT *, (SELECT DISTINCT CONCAT(COALESCE(`province_name_kh`, ''),'" . ew_ValueSeparator(1, $this->province_id) . "',COALESCE(`province_name_en`,'')) FROM `province` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`province_id` = `company`.`province_id` LIMIT 1) AS `EV__province_id` FROM `company`" .
			") `EW_TMP_TABLE`";
		return ($this->_SqlSelectList <> "") ? $this->_SqlSelectList : $select;
	}

	function SqlSelectList() { // For backward compatibility
		return $this->getSqlSelectList();
	}

	function setSqlSelectList($v) {
		$this->_SqlSelectList = $v;
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
		if ($this->UseVirtualFields()) {
			$sSelect = $this->getSqlSelectList();
			$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderByList() : "";
		} else {
			$sSelect = $this->getSqlSelect();
			$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		}
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = ($this->UseVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Check if virtual fields is used in SQL
	function UseVirtualFields() {
		$sWhere = $this->UseSessionForListSQL ? $this->getSessionWhere() : $this->CurrentFilter;
		$sOrderBy = $this->UseSessionForListSQL ? $this->getSessionOrderByList() : "";
		if ($sWhere <> "")
			$sWhere = " " . str_replace(array("(",")"), array("",""), $sWhere) . " ";
		if ($sOrderBy <> "")
			$sOrderBy = " " . str_replace(array("(",")"), array("",""), $sOrderBy) . " ";
		if ($this->province_id->AdvancedSearch->SearchValue <> "" ||
			$this->province_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->province_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->province_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		return FALSE;
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
		if ($this->UseVirtualFields())
			$sql = ew_BuildSelectSql($this->getSqlSelectList(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		else
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
			if (EW_ENCRYPTED_PASSWORD && $name == 'com_password')
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
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
			$this->company_id->setDbValue($conn->Insert_ID());
			$rs['company_id'] = $this->company_id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			if (EW_ENCRYPTED_PASSWORD && $name == 'com_password') {
				if ($value == $this->fields[$name]->OldValue) // No need to update hashed password if not changed
					continue;
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
			}
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
			if (array_key_exists('company_id', $rs))
				ew_AddFilter($where, ew_QuotedName('company_id', $this->DBID) . '=' . ew_QuotedValue($rs['company_id'], $this->company_id->FldDataType, $this->DBID));
			if (array_key_exists('country_id', $rs))
				ew_AddFilter($where, ew_QuotedName('country_id', $this->DBID) . '=' . ew_QuotedValue($rs['country_id'], $this->country_id->FldDataType, $this->DBID));
			if (array_key_exists('province_id', $rs))
				ew_AddFilter($where, ew_QuotedName('province_id', $this->DBID) . '=' . ew_QuotedValue($rs['province_id'], $this->province_id->FldDataType, $this->DBID));
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
		return "`company_id` = @company_id@ AND `country_id` = @country_id@ AND `province_id` = @province_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->company_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->company_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@company_id@", ew_AdjustSql($this->company_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->country_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->country_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@country_id@", ew_AdjustSql($this->country_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->province_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->province_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@province_id@", ew_AdjustSql($this->province_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "companylist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "companyview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "companyedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "companyadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "companylist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("companyview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("companyview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "companyadd.php?" . $this->UrlParm($parm);
		else
			$url = "companyadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("companyedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("companyadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("companydelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "company_id:" . ew_VarToJson($this->company_id->CurrentValue, "number", "'");
		$json .= ",country_id:" . ew_VarToJson($this->country_id->CurrentValue, "number", "'");
		$json .= ",province_id:" . ew_VarToJson($this->province_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->company_id->CurrentValue)) {
			$sUrl .= "company_id=" . urlencode($this->company_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->country_id->CurrentValue)) {
			$sUrl .= "&country_id=" . urlencode($this->country_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->province_id->CurrentValue)) {
			$sUrl .= "&province_id=" . urlencode($this->province_id->CurrentValue);
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
			if ($isPost && isset($_POST["company_id"]))
				$arKey[] = $_POST["company_id"];
			elseif (isset($_GET["company_id"]))
				$arKey[] = $_GET["company_id"];
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["country_id"]))
				$arKey[] = $_POST["country_id"];
			elseif (isset($_GET["country_id"]))
				$arKey[] = $_GET["country_id"];
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["province_id"]))
				$arKey[] = $_POST["province_id"];
			elseif (isset($_GET["province_id"]))
				$arKey[] = $_GET["province_id"];
			else
				$arKeys = NULL; // Do not setup
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) <> 3)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // company_id
					continue;
				if (!is_numeric($key[1])) // country_id
					continue;
				if (!is_numeric($key[2])) // province_id
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
			$this->company_id->CurrentValue = $key[0];
			$this->country_id->CurrentValue = $key[1];
			$this->province_id->CurrentValue = $key[2];
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
		$this->company_id->setDbValue($rs->fields('company_id'));
		$this->com_fname->setDbValue($rs->fields('com_fname'));
		$this->com_lname->setDbValue($rs->fields('com_lname'));
		$this->com_name->setDbValue($rs->fields('com_name'));
		$this->com_address->setDbValue($rs->fields('com_address'));
		$this->com_phone->setDbValue($rs->fields('com_phone'));
		$this->com_email->setDbValue($rs->fields('com_email'));
		$this->com_fb->setDbValue($rs->fields('com_fb'));
		$this->com_tw->setDbValue($rs->fields('com_tw'));
		$this->com_yt->setDbValue($rs->fields('com_yt'));
		$this->com_logo->Upload->DbValue = $rs->fields('com_logo');
		$this->com_username->setDbValue($rs->fields('com_username'));
		$this->com_password->setDbValue($rs->fields('com_password'));
		$this->com_online->setDbValue($rs->fields('com_online'));
		$this->com_activation->setDbValue($rs->fields('com_activation'));
		$this->com_status->setDbValue($rs->fields('com_status'));
		$this->reg_date->setDbValue($rs->fields('reg_date'));
		$this->country_id->setDbValue($rs->fields('country_id'));
		$this->province_id->setDbValue($rs->fields('province_id'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// company_id
		// com_fname
		// com_lname
		// com_name
		// com_address
		// com_phone
		// com_email
		// com_fb
		// com_tw
		// com_yt
		// com_logo
		// com_username
		// com_password
		// com_online
		// com_activation
		// com_status
		// reg_date
		// country_id
		// province_id
		// company_id

		$this->company_id->ViewValue = $this->company_id->CurrentValue;
		$this->company_id->ViewCustomAttributes = "";

		// com_fname
		$this->com_fname->ViewValue = $this->com_fname->CurrentValue;
		$this->com_fname->ViewCustomAttributes = "";

		// com_lname
		$this->com_lname->ViewValue = $this->com_lname->CurrentValue;
		$this->com_lname->ViewCustomAttributes = "";

		// com_name
		$this->com_name->ViewValue = $this->com_name->CurrentValue;
		$this->com_name->ViewCustomAttributes = "";

		// com_address
		$this->com_address->ViewValue = $this->com_address->CurrentValue;
		$this->com_address->ViewCustomAttributes = "";

		// com_phone
		$this->com_phone->ViewValue = $this->com_phone->CurrentValue;
		$this->com_phone->ViewCustomAttributes = "";

		// com_email
		$this->com_email->ViewValue = $this->com_email->CurrentValue;
		$this->com_email->ViewCustomAttributes = "";

		// com_fb
		$this->com_fb->ViewValue = $this->com_fb->CurrentValue;
		$this->com_fb->ViewCustomAttributes = "";

		// com_tw
		$this->com_tw->ViewValue = $this->com_tw->CurrentValue;
		$this->com_tw->ViewCustomAttributes = "";

		// com_yt
		$this->com_yt->ViewValue = $this->com_yt->CurrentValue;
		$this->com_yt->ViewCustomAttributes = "";

		// com_logo
		$this->com_logo->UploadPath = "../uploads/company";
		if (!ew_Empty($this->com_logo->Upload->DbValue)) {
			$this->com_logo->ImageWidth = 0;
			$this->com_logo->ImageHeight = 64;
			$this->com_logo->ImageAlt = $this->com_logo->FldAlt();
			$this->com_logo->ViewValue = $this->com_logo->Upload->DbValue;
		} else {
			$this->com_logo->ViewValue = "";
		}
		$this->com_logo->ViewCustomAttributes = "";

		// com_username
		$this->com_username->ViewValue = $this->com_username->CurrentValue;
		$this->com_username->ViewCustomAttributes = "";

		// com_password
		$this->com_password->ViewValue = $this->com_password->CurrentValue;
		$this->com_password->ViewCustomAttributes = "";

		// com_online
		if (strval($this->com_online->CurrentValue) <> "") {
			$this->com_online->ViewValue = $this->com_online->OptionCaption($this->com_online->CurrentValue);
		} else {
			$this->com_online->ViewValue = NULL;
		}
		$this->com_online->ViewCustomAttributes = "";

		// com_activation
		if (strval($this->com_activation->CurrentValue) <> "") {
			$this->com_activation->ViewValue = $this->com_activation->OptionCaption($this->com_activation->CurrentValue);
		} else {
			$this->com_activation->ViewValue = NULL;
		}
		$this->com_activation->ViewCustomAttributes = "";

		// com_status
		if (strval($this->com_status->CurrentValue) <> "") {
			$this->com_status->ViewValue = $this->com_status->OptionCaption($this->com_status->CurrentValue);
		} else {
			$this->com_status->ViewValue = NULL;
		}
		$this->com_status->ViewCustomAttributes = "";

		// reg_date
		$this->reg_date->ViewValue = $this->reg_date->CurrentValue;
		$this->reg_date->ViewValue = ew_FormatDateTime($this->reg_date->ViewValue, 1);
		$this->reg_date->ViewCustomAttributes = "";

		// country_id
		if (strval($this->country_id->CurrentValue) <> "") {
			$sFilterWrk = "`country_id`" . ew_SearchString("=", $this->country_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT DISTINCT `country_id`, `country_name_kh` AS `DispFld`, `country_name_en` AS `Disp2Fld`, `country_code` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `country`";
		$sWhereWrk = "";
		$this->country_id->LookupFilters = array("dx1" => '`country_name_kh`', "dx2" => '`country_name_en`', "dx3" => '`country_code`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->country_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->country_id->ViewValue = $this->country_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->country_id->ViewValue = $this->country_id->CurrentValue;
			}
		} else {
			$this->country_id->ViewValue = NULL;
		}
		$this->country_id->ViewCustomAttributes = "";

		// province_id
		if ($this->province_id->VirtualValue <> "") {
			$this->province_id->ViewValue = $this->province_id->VirtualValue;
		} else {
		if (strval($this->province_id->CurrentValue) <> "") {
			$sFilterWrk = "`province_id`" . ew_SearchString("=", $this->province_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT DISTINCT `province_id`, `province_name_kh` AS `DispFld`, `province_name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `province`";
		$sWhereWrk = "";
		$this->province_id->LookupFilters = array("dx1" => '`province_name_kh`', "dx2" => '`province_name_en`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->province_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->province_id->ViewValue = $this->province_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->province_id->ViewValue = $this->province_id->CurrentValue;
			}
		} else {
			$this->province_id->ViewValue = NULL;
		}
		}
		$this->province_id->ViewCustomAttributes = "";

		// company_id
		$this->company_id->LinkCustomAttributes = "";
		$this->company_id->HrefValue = "";
		$this->company_id->TooltipValue = "";

		// com_fname
		$this->com_fname->LinkCustomAttributes = "";
		$this->com_fname->HrefValue = "";
		$this->com_fname->TooltipValue = "";

		// com_lname
		$this->com_lname->LinkCustomAttributes = "";
		$this->com_lname->HrefValue = "";
		$this->com_lname->TooltipValue = "";

		// com_name
		$this->com_name->LinkCustomAttributes = "";
		$this->com_name->HrefValue = "";
		$this->com_name->TooltipValue = "";

		// com_address
		$this->com_address->LinkCustomAttributes = "";
		$this->com_address->HrefValue = "";
		$this->com_address->TooltipValue = "";

		// com_phone
		$this->com_phone->LinkCustomAttributes = "";
		$this->com_phone->HrefValue = "";
		$this->com_phone->TooltipValue = "";

		// com_email
		$this->com_email->LinkCustomAttributes = "";
		$this->com_email->HrefValue = "";
		$this->com_email->TooltipValue = "";

		// com_fb
		$this->com_fb->LinkCustomAttributes = "";
		$this->com_fb->HrefValue = "";
		$this->com_fb->TooltipValue = "";

		// com_tw
		$this->com_tw->LinkCustomAttributes = "";
		$this->com_tw->HrefValue = "";
		$this->com_tw->TooltipValue = "";

		// com_yt
		$this->com_yt->LinkCustomAttributes = "";
		$this->com_yt->HrefValue = "";
		$this->com_yt->TooltipValue = "";

		// com_logo
		$this->com_logo->LinkCustomAttributes = "";
		$this->com_logo->UploadPath = "../uploads/company";
		if (!ew_Empty($this->com_logo->Upload->DbValue)) {
			$this->com_logo->HrefValue = ew_GetFileUploadUrl($this->com_logo, $this->com_logo->Upload->DbValue); // Add prefix/suffix
			$this->com_logo->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->com_logo->HrefValue = ew_FullUrl($this->com_logo->HrefValue, "href");
		} else {
			$this->com_logo->HrefValue = "";
		}
		$this->com_logo->HrefValue2 = $this->com_logo->UploadPath . $this->com_logo->Upload->DbValue;
		$this->com_logo->TooltipValue = "";
		if ($this->com_logo->UseColorbox) {
			if (ew_Empty($this->com_logo->TooltipValue))
				$this->com_logo->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->com_logo->LinkAttrs["data-rel"] = "company_x_com_logo";
			ew_AppendClass($this->com_logo->LinkAttrs["class"], "ewLightbox");
		}

		// com_username
		$this->com_username->LinkCustomAttributes = "";
		$this->com_username->HrefValue = "";
		$this->com_username->TooltipValue = "";

		// com_password
		$this->com_password->LinkCustomAttributes = "";
		$this->com_password->HrefValue = "";
		$this->com_password->TooltipValue = "";

		// com_online
		$this->com_online->LinkCustomAttributes = "";
		$this->com_online->HrefValue = "";
		$this->com_online->TooltipValue = "";

		// com_activation
		$this->com_activation->LinkCustomAttributes = "";
		$this->com_activation->HrefValue = "";
		$this->com_activation->TooltipValue = "";

		// com_status
		$this->com_status->LinkCustomAttributes = "";
		$this->com_status->HrefValue = "";
		$this->com_status->TooltipValue = "";

		// reg_date
		$this->reg_date->LinkCustomAttributes = "";
		$this->reg_date->HrefValue = "";
		$this->reg_date->TooltipValue = "";

		// country_id
		$this->country_id->LinkCustomAttributes = "";
		$this->country_id->HrefValue = "";
		$this->country_id->TooltipValue = "";

		// province_id
		$this->province_id->LinkCustomAttributes = "";
		$this->province_id->HrefValue = "";
		$this->province_id->TooltipValue = "";

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

		// company_id
		$this->company_id->EditAttrs["class"] = "form-control";
		$this->company_id->EditCustomAttributes = "";
		$this->company_id->EditValue = $this->company_id->CurrentValue;
		$this->company_id->ViewCustomAttributes = "";

		// com_fname
		$this->com_fname->EditAttrs["class"] = "form-control";
		$this->com_fname->EditCustomAttributes = "";
		$this->com_fname->EditValue = $this->com_fname->CurrentValue;
		$this->com_fname->PlaceHolder = ew_RemoveHtml($this->com_fname->FldCaption());

		// com_lname
		$this->com_lname->EditAttrs["class"] = "form-control";
		$this->com_lname->EditCustomAttributes = "";
		$this->com_lname->EditValue = $this->com_lname->CurrentValue;
		$this->com_lname->PlaceHolder = ew_RemoveHtml($this->com_lname->FldCaption());

		// com_name
		$this->com_name->EditAttrs["class"] = "form-control";
		$this->com_name->EditCustomAttributes = "";
		$this->com_name->EditValue = $this->com_name->CurrentValue;
		$this->com_name->PlaceHolder = ew_RemoveHtml($this->com_name->FldCaption());

		// com_address
		$this->com_address->EditAttrs["class"] = "form-control";
		$this->com_address->EditCustomAttributes = "";
		$this->com_address->EditValue = $this->com_address->CurrentValue;
		$this->com_address->PlaceHolder = ew_RemoveHtml($this->com_address->FldCaption());

		// com_phone
		$this->com_phone->EditAttrs["class"] = "form-control";
		$this->com_phone->EditCustomAttributes = "";
		$this->com_phone->EditValue = $this->com_phone->CurrentValue;
		$this->com_phone->PlaceHolder = ew_RemoveHtml($this->com_phone->FldCaption());

		// com_email
		$this->com_email->EditAttrs["class"] = "form-control";
		$this->com_email->EditCustomAttributes = "";
		$this->com_email->EditValue = $this->com_email->CurrentValue;
		$this->com_email->PlaceHolder = ew_RemoveHtml($this->com_email->FldCaption());

		// com_fb
		$this->com_fb->EditAttrs["class"] = "form-control";
		$this->com_fb->EditCustomAttributes = "";
		$this->com_fb->EditValue = $this->com_fb->CurrentValue;
		$this->com_fb->PlaceHolder = ew_RemoveHtml($this->com_fb->FldCaption());

		// com_tw
		$this->com_tw->EditAttrs["class"] = "form-control";
		$this->com_tw->EditCustomAttributes = "";
		$this->com_tw->EditValue = $this->com_tw->CurrentValue;
		$this->com_tw->PlaceHolder = ew_RemoveHtml($this->com_tw->FldCaption());

		// com_yt
		$this->com_yt->EditAttrs["class"] = "form-control";
		$this->com_yt->EditCustomAttributes = "";
		$this->com_yt->EditValue = $this->com_yt->CurrentValue;
		$this->com_yt->PlaceHolder = ew_RemoveHtml($this->com_yt->FldCaption());

		// com_logo
		$this->com_logo->EditAttrs["class"] = "form-control";
		$this->com_logo->EditCustomAttributes = "";
		$this->com_logo->UploadPath = "../uploads/company";
		if (!ew_Empty($this->com_logo->Upload->DbValue)) {
			$this->com_logo->ImageWidth = 0;
			$this->com_logo->ImageHeight = 64;
			$this->com_logo->ImageAlt = $this->com_logo->FldAlt();
			$this->com_logo->EditValue = $this->com_logo->Upload->DbValue;
		} else {
			$this->com_logo->EditValue = "";
		}
		if (!ew_Empty($this->com_logo->CurrentValue))
				$this->com_logo->Upload->FileName = $this->com_logo->CurrentValue;

		// com_username
		$this->com_username->EditAttrs["class"] = "form-control";
		$this->com_username->EditCustomAttributes = "";
		$this->com_username->EditValue = $this->com_username->CurrentValue;
		$this->com_username->PlaceHolder = ew_RemoveHtml($this->com_username->FldCaption());

		// com_password
		$this->com_password->EditAttrs["class"] = "form-control";
		$this->com_password->EditCustomAttributes = "";
		$this->com_password->EditValue = $this->com_password->CurrentValue;
		$this->com_password->PlaceHolder = ew_RemoveHtml($this->com_password->FldCaption());

		// com_online
		$this->com_online->EditCustomAttributes = "";
		$this->com_online->EditValue = $this->com_online->Options(FALSE);

		// com_activation
		$this->com_activation->EditCustomAttributes = "";
		$this->com_activation->EditValue = $this->com_activation->Options(TRUE);

		// com_status
		$this->com_status->EditCustomAttributes = "";
		$this->com_status->EditValue = $this->com_status->Options(FALSE);

		// reg_date
		$this->reg_date->EditAttrs["class"] = "form-control";
		$this->reg_date->EditCustomAttributes = "";
		$this->reg_date->EditValue = ew_FormatDateTime($this->reg_date->CurrentValue, 8);
		$this->reg_date->PlaceHolder = ew_RemoveHtml($this->reg_date->FldCaption());

		// country_id
		$this->country_id->EditAttrs["class"] = "form-control";
		$this->country_id->EditCustomAttributes = "";
		if (strval($this->country_id->CurrentValue) <> "") {
			$sFilterWrk = "`country_id`" . ew_SearchString("=", $this->country_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT DISTINCT `country_id`, `country_name_kh` AS `DispFld`, `country_name_en` AS `Disp2Fld`, `country_code` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `country`";
		$sWhereWrk = "";
		$this->country_id->LookupFilters = array("dx1" => '`country_name_kh`', "dx2" => '`country_name_en`', "dx3" => '`country_code`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->country_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->country_id->EditValue = $this->country_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->country_id->EditValue = $this->country_id->CurrentValue;
			}
		} else {
			$this->country_id->EditValue = NULL;
		}
		$this->country_id->ViewCustomAttributes = "";

		// province_id
		$this->province_id->EditAttrs["class"] = "form-control";
		$this->province_id->EditCustomAttributes = "";
		if ($this->province_id->VirtualValue <> "") {
			$this->province_id->EditValue = $this->province_id->VirtualValue;
		} else {
		if (strval($this->province_id->CurrentValue) <> "") {
			$sFilterWrk = "`province_id`" . ew_SearchString("=", $this->province_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT DISTINCT `province_id`, `province_name_kh` AS `DispFld`, `province_name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `province`";
		$sWhereWrk = "";
		$this->province_id->LookupFilters = array("dx1" => '`province_name_kh`', "dx2" => '`province_name_en`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->province_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->province_id->EditValue = $this->province_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->province_id->EditValue = $this->province_id->CurrentValue;
			}
		} else {
			$this->province_id->EditValue = NULL;
		}
		}
		$this->province_id->ViewCustomAttributes = "";

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
					if ($this->company_id->Exportable) $Doc->ExportCaption($this->company_id);
					if ($this->com_fname->Exportable) $Doc->ExportCaption($this->com_fname);
					if ($this->com_lname->Exportable) $Doc->ExportCaption($this->com_lname);
					if ($this->com_name->Exportable) $Doc->ExportCaption($this->com_name);
					if ($this->com_address->Exportable) $Doc->ExportCaption($this->com_address);
					if ($this->com_phone->Exportable) $Doc->ExportCaption($this->com_phone);
					if ($this->com_email->Exportable) $Doc->ExportCaption($this->com_email);
					if ($this->com_fb->Exportable) $Doc->ExportCaption($this->com_fb);
					if ($this->com_tw->Exportable) $Doc->ExportCaption($this->com_tw);
					if ($this->com_yt->Exportable) $Doc->ExportCaption($this->com_yt);
					if ($this->com_logo->Exportable) $Doc->ExportCaption($this->com_logo);
					if ($this->com_username->Exportable) $Doc->ExportCaption($this->com_username);
					if ($this->com_password->Exportable) $Doc->ExportCaption($this->com_password);
					if ($this->com_online->Exportable) $Doc->ExportCaption($this->com_online);
					if ($this->com_activation->Exportable) $Doc->ExportCaption($this->com_activation);
					if ($this->com_status->Exportable) $Doc->ExportCaption($this->com_status);
					if ($this->reg_date->Exportable) $Doc->ExportCaption($this->reg_date);
					if ($this->country_id->Exportable) $Doc->ExportCaption($this->country_id);
				} else {
					if ($this->company_id->Exportable) $Doc->ExportCaption($this->company_id);
					if ($this->com_fname->Exportable) $Doc->ExportCaption($this->com_fname);
					if ($this->com_lname->Exportable) $Doc->ExportCaption($this->com_lname);
					if ($this->com_name->Exportable) $Doc->ExportCaption($this->com_name);
					if ($this->com_address->Exportable) $Doc->ExportCaption($this->com_address);
					if ($this->com_phone->Exportable) $Doc->ExportCaption($this->com_phone);
					if ($this->com_email->Exportable) $Doc->ExportCaption($this->com_email);
					if ($this->com_fb->Exportable) $Doc->ExportCaption($this->com_fb);
					if ($this->com_tw->Exportable) $Doc->ExportCaption($this->com_tw);
					if ($this->com_yt->Exportable) $Doc->ExportCaption($this->com_yt);
					if ($this->com_logo->Exportable) $Doc->ExportCaption($this->com_logo);
					if ($this->com_username->Exportable) $Doc->ExportCaption($this->com_username);
					if ($this->com_password->Exportable) $Doc->ExportCaption($this->com_password);
					if ($this->com_online->Exportable) $Doc->ExportCaption($this->com_online);
					if ($this->com_activation->Exportable) $Doc->ExportCaption($this->com_activation);
					if ($this->com_status->Exportable) $Doc->ExportCaption($this->com_status);
					if ($this->reg_date->Exportable) $Doc->ExportCaption($this->reg_date);
					if ($this->country_id->Exportable) $Doc->ExportCaption($this->country_id);
					if ($this->province_id->Exportable) $Doc->ExportCaption($this->province_id);
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
						if ($this->company_id->Exportable) $Doc->ExportField($this->company_id);
						if ($this->com_fname->Exportable) $Doc->ExportField($this->com_fname);
						if ($this->com_lname->Exportable) $Doc->ExportField($this->com_lname);
						if ($this->com_name->Exportable) $Doc->ExportField($this->com_name);
						if ($this->com_address->Exportable) $Doc->ExportField($this->com_address);
						if ($this->com_phone->Exportable) $Doc->ExportField($this->com_phone);
						if ($this->com_email->Exportable) $Doc->ExportField($this->com_email);
						if ($this->com_fb->Exportable) $Doc->ExportField($this->com_fb);
						if ($this->com_tw->Exportable) $Doc->ExportField($this->com_tw);
						if ($this->com_yt->Exportable) $Doc->ExportField($this->com_yt);
						if ($this->com_logo->Exportable) $Doc->ExportField($this->com_logo);
						if ($this->com_username->Exportable) $Doc->ExportField($this->com_username);
						if ($this->com_password->Exportable) $Doc->ExportField($this->com_password);
						if ($this->com_online->Exportable) $Doc->ExportField($this->com_online);
						if ($this->com_activation->Exportable) $Doc->ExportField($this->com_activation);
						if ($this->com_status->Exportable) $Doc->ExportField($this->com_status);
						if ($this->reg_date->Exportable) $Doc->ExportField($this->reg_date);
						if ($this->country_id->Exportable) $Doc->ExportField($this->country_id);
					} else {
						if ($this->company_id->Exportable) $Doc->ExportField($this->company_id);
						if ($this->com_fname->Exportable) $Doc->ExportField($this->com_fname);
						if ($this->com_lname->Exportable) $Doc->ExportField($this->com_lname);
						if ($this->com_name->Exportable) $Doc->ExportField($this->com_name);
						if ($this->com_address->Exportable) $Doc->ExportField($this->com_address);
						if ($this->com_phone->Exportable) $Doc->ExportField($this->com_phone);
						if ($this->com_email->Exportable) $Doc->ExportField($this->com_email);
						if ($this->com_fb->Exportable) $Doc->ExportField($this->com_fb);
						if ($this->com_tw->Exportable) $Doc->ExportField($this->com_tw);
						if ($this->com_yt->Exportable) $Doc->ExportField($this->com_yt);
						if ($this->com_logo->Exportable) $Doc->ExportField($this->com_logo);
						if ($this->com_username->Exportable) $Doc->ExportField($this->com_username);
						if ($this->com_password->Exportable) $Doc->ExportField($this->com_password);
						if ($this->com_online->Exportable) $Doc->ExportField($this->com_online);
						if ($this->com_activation->Exportable) $Doc->ExportField($this->com_activation);
						if ($this->com_status->Exportable) $Doc->ExportField($this->com_status);
						if ($this->reg_date->Exportable) $Doc->ExportField($this->reg_date);
						if ($this->country_id->Exportable) $Doc->ExportField($this->country_id);
						if ($this->province_id->Exportable) $Doc->ExportField($this->province_id);
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

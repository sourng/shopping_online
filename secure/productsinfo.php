<?php

// Global variable for table object
$products = NULL;

//
// Table class for products
//
class cproducts extends cTable {
	var $product_id;
	var $cat_id;
	var $company_id;
	var $pro_name;
	var $pro_description;
	var $pro_condition;
	var $pro_features;
	var $pro_model;
	var $post_date;
	var $ads_id;
	var $pro_base_price;
	var $pro_sell_price;
	var $featured_image;
	var $folder_image;
	var $img1;
	var $img2;
	var $img3;
	var $img4;
	var $img5;
	var $pro_status;
	var $branch_id;
	var $lang;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'products';
		$this->TableName = 'products';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`products`";
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// product_id
		$this->product_id = new cField('products', 'products', 'x_product_id', 'product_id', '`product_id`', '`product_id`', 3, -1, FALSE, '`product_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->product_id->Sortable = TRUE; // Allow sort
		$this->product_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['product_id'] = &$this->product_id;

		// cat_id
		$this->cat_id = new cField('products', 'products', 'x_cat_id', 'cat_id', '`cat_id`', '`cat_id`', 3, -1, FALSE, '`EV__cat_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'SELECT');
		$this->cat_id->Sortable = TRUE; // Allow sort
		$this->cat_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->cat_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->cat_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cat_id'] = &$this->cat_id;

		// company_id
		$this->company_id = new cField('products', 'products', 'x_company_id', 'company_id', '`company_id`', '`company_id`', 3, -1, FALSE, '`EV__company_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'SELECT');
		$this->company_id->Sortable = TRUE; // Allow sort
		$this->company_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->company_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->company_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['company_id'] = &$this->company_id;

		// pro_name
		$this->pro_name = new cField('products', 'products', 'x_pro_name', 'pro_name', '`pro_name`', '`pro_name`', 200, -1, FALSE, '`pro_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pro_name->Sortable = TRUE; // Allow sort
		$this->fields['pro_name'] = &$this->pro_name;

		// pro_description
		$this->pro_description = new cField('products', 'products', 'x_pro_description', 'pro_description', '`pro_description`', '`pro_description`', 201, -1, FALSE, '`pro_description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->pro_description->Sortable = TRUE; // Allow sort
		$this->fields['pro_description'] = &$this->pro_description;

		// pro_condition
		$this->pro_condition = new cField('products', 'products', 'x_pro_condition', 'pro_condition', '`pro_condition`', '`pro_condition`', 200, -1, FALSE, '`pro_condition`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->pro_condition->Sortable = TRUE; // Allow sort
		$this->pro_condition->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->pro_condition->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->pro_condition->OptionCount = 3;
		$this->fields['pro_condition'] = &$this->pro_condition;

		// pro_features
		$this->pro_features = new cField('products', 'products', 'x_pro_features', 'pro_features', '`pro_features`', '`pro_features`', 200, -1, FALSE, '`pro_features`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pro_features->Sortable = TRUE; // Allow sort
		$this->fields['pro_features'] = &$this->pro_features;

		// pro_model
		$this->pro_model = new cField('products', 'products', 'x_pro_model', 'pro_model', '`pro_model`', '`pro_model`', 200, -1, FALSE, '`pro_model`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pro_model->Sortable = TRUE; // Allow sort
		$this->fields['pro_model'] = &$this->pro_model;

		// post_date
		$this->post_date = new cField('products', 'products', 'x_post_date', 'post_date', '`post_date`', ew_CastDateFieldForLike('`post_date`', 0, "DB"), 135, 0, FALSE, '`post_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->post_date->Sortable = TRUE; // Allow sort
		$this->post_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['post_date'] = &$this->post_date;

		// ads_id
		$this->ads_id = new cField('products', 'products', 'x_ads_id', 'ads_id', '`ads_id`', '`ads_id`', 200, -1, FALSE, '`ads_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ads_id->Sortable = TRUE; // Allow sort
		$this->fields['ads_id'] = &$this->ads_id;

		// pro_base_price
		$this->pro_base_price = new cField('products', 'products', 'x_pro_base_price', 'pro_base_price', '`pro_base_price`', '`pro_base_price`', 131, -1, FALSE, '`pro_base_price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pro_base_price->Sortable = TRUE; // Allow sort
		$this->pro_base_price->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['pro_base_price'] = &$this->pro_base_price;

		// pro_sell_price
		$this->pro_sell_price = new cField('products', 'products', 'x_pro_sell_price', 'pro_sell_price', '`pro_sell_price`', '`pro_sell_price`', 131, -1, FALSE, '`pro_sell_price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pro_sell_price->Sortable = TRUE; // Allow sort
		$this->pro_sell_price->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['pro_sell_price'] = &$this->pro_sell_price;

		// featured_image
		$this->featured_image = new cField('products', 'products', 'x_featured_image', 'featured_image', '`featured_image`', '`featured_image`', 200, -1, TRUE, '`featured_image`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->featured_image->Sortable = TRUE; // Allow sort
		$this->fields['featured_image'] = &$this->featured_image;

		// folder_image
		$this->folder_image = new cField('products', 'products', 'x_folder_image', 'folder_image', '`folder_image`', '`folder_image`', 200, -1, FALSE, '`folder_image`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->folder_image->Sortable = TRUE; // Allow sort
		$this->folder_image->FldSelectMultiple = TRUE; // Multiple select
		$this->fields['folder_image'] = &$this->folder_image;

		// img1
		$this->img1 = new cField('products', 'products', 'x_img1', 'img1', '`img1`', '`img1`', 200, -1, FALSE, '`img1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->img1->Sortable = TRUE; // Allow sort
		$this->fields['img1'] = &$this->img1;

		// img2
		$this->img2 = new cField('products', 'products', 'x_img2', 'img2', '`img2`', '`img2`', 200, -1, FALSE, '`img2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->img2->Sortable = TRUE; // Allow sort
		$this->fields['img2'] = &$this->img2;

		// img3
		$this->img3 = new cField('products', 'products', 'x_img3', 'img3', '`img3`', '`img3`', 200, -1, FALSE, '`img3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->img3->Sortable = TRUE; // Allow sort
		$this->fields['img3'] = &$this->img3;

		// img4
		$this->img4 = new cField('products', 'products', 'x_img4', 'img4', '`img4`', '`img4`', 200, -1, FALSE, '`img4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->img4->Sortable = TRUE; // Allow sort
		$this->fields['img4'] = &$this->img4;

		// img5
		$this->img5 = new cField('products', 'products', 'x_img5', 'img5', '`img5`', '`img5`', 200, -1, FALSE, '`img5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->img5->Sortable = TRUE; // Allow sort
		$this->fields['img5'] = &$this->img5;

		// pro_status
		$this->pro_status = new cField('products', 'products', 'x_pro_status', 'pro_status', '`pro_status`', '`pro_status`', 202, -1, FALSE, '`pro_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->pro_status->Sortable = TRUE; // Allow sort
		$this->pro_status->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->pro_status->TrueValue = 'Y';
		$this->pro_status->FalseValue = 'N';
		$this->pro_status->OptionCount = 2;
		$this->fields['pro_status'] = &$this->pro_status;

		// branch_id
		$this->branch_id = new cField('products', 'products', 'x_branch_id', 'branch_id', '`branch_id`', '`branch_id`', 200, -1, FALSE, '`branch_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->branch_id->Sortable = TRUE; // Allow sort
		$this->branch_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->branch_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['branch_id'] = &$this->branch_id;

		// lang
		$this->lang = new cField('products', 'products', 'x_lang', 'lang', '`lang`', '`lang`', 200, -1, FALSE, '`lang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->lang->Sortable = TRUE; // Allow sort
		$this->fields['lang'] = &$this->lang;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`products`";
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
			"SELECT *, (SELECT `cat_name` FROM `categories` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`cat_id` = `products`.`cat_id` LIMIT 1) AS `EV__cat_id`, (SELECT DISTINCT CONCAT(COALESCE(`com_fname`, ''),'" . ew_ValueSeparator(1, $this->company_id) . "',COALESCE(`com_lname`,''),'" . ew_ValueSeparator(2, $this->company_id) . "',COALESCE(`com_name`,'')) FROM `company` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`company_id` = `products`.`company_id` LIMIT 1) AS `EV__company_id` FROM `products`" .
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
		if ($this->cat_id->AdvancedSearch->SearchValue <> "" ||
			$this->cat_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->cat_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->cat_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if ($this->company_id->AdvancedSearch->SearchValue <> "" ||
			$this->company_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->company_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->company_id->FldVirtualExpression . " ") !== FALSE)
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
			$this->product_id->setDbValue($conn->Insert_ID());
			$rs['product_id'] = $this->product_id->DbValue;
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
			if (array_key_exists('product_id', $rs))
				ew_AddFilter($where, ew_QuotedName('product_id', $this->DBID) . '=' . ew_QuotedValue($rs['product_id'], $this->product_id->FldDataType, $this->DBID));
			if (array_key_exists('cat_id', $rs))
				ew_AddFilter($where, ew_QuotedName('cat_id', $this->DBID) . '=' . ew_QuotedValue($rs['cat_id'], $this->cat_id->FldDataType, $this->DBID));
			if (array_key_exists('company_id', $rs))
				ew_AddFilter($where, ew_QuotedName('company_id', $this->DBID) . '=' . ew_QuotedValue($rs['company_id'], $this->company_id->FldDataType, $this->DBID));
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
		return "`product_id` = @product_id@ AND `cat_id` = @cat_id@ AND `company_id` = @company_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->product_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->product_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@product_id@", ew_AdjustSql($this->product_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->cat_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->cat_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@cat_id@", ew_AdjustSql($this->cat_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->company_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->company_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@company_id@", ew_AdjustSql($this->company_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "productslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "productsview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "productsedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "productsadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "productslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("productsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("productsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "productsadd.php?" . $this->UrlParm($parm);
		else
			$url = "productsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("productsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("productsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("productsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "product_id:" . ew_VarToJson($this->product_id->CurrentValue, "number", "'");
		$json .= ",cat_id:" . ew_VarToJson($this->cat_id->CurrentValue, "number", "'");
		$json .= ",company_id:" . ew_VarToJson($this->company_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->product_id->CurrentValue)) {
			$sUrl .= "product_id=" . urlencode($this->product_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->cat_id->CurrentValue)) {
			$sUrl .= "&cat_id=" . urlencode($this->cat_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->company_id->CurrentValue)) {
			$sUrl .= "&company_id=" . urlencode($this->company_id->CurrentValue);
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
			if ($isPost && isset($_POST["product_id"]))
				$arKey[] = $_POST["product_id"];
			elseif (isset($_GET["product_id"]))
				$arKey[] = $_GET["product_id"];
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["cat_id"]))
				$arKey[] = $_POST["cat_id"];
			elseif (isset($_GET["cat_id"]))
				$arKey[] = $_GET["cat_id"];
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["company_id"]))
				$arKey[] = $_POST["company_id"];
			elseif (isset($_GET["company_id"]))
				$arKey[] = $_GET["company_id"];
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
				if (!is_numeric($key[0])) // product_id
					continue;
				if (!is_numeric($key[1])) // cat_id
					continue;
				if (!is_numeric($key[2])) // company_id
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
			$this->product_id->CurrentValue = $key[0];
			$this->cat_id->CurrentValue = $key[1];
			$this->company_id->CurrentValue = $key[2];
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
		$this->product_id->setDbValue($rs->fields('product_id'));
		$this->cat_id->setDbValue($rs->fields('cat_id'));
		$this->company_id->setDbValue($rs->fields('company_id'));
		$this->pro_name->setDbValue($rs->fields('pro_name'));
		$this->pro_description->setDbValue($rs->fields('pro_description'));
		$this->pro_condition->setDbValue($rs->fields('pro_condition'));
		$this->pro_features->setDbValue($rs->fields('pro_features'));
		$this->pro_model->setDbValue($rs->fields('pro_model'));
		$this->post_date->setDbValue($rs->fields('post_date'));
		$this->ads_id->setDbValue($rs->fields('ads_id'));
		$this->pro_base_price->setDbValue($rs->fields('pro_base_price'));
		$this->pro_sell_price->setDbValue($rs->fields('pro_sell_price'));
		$this->featured_image->Upload->DbValue = $rs->fields('featured_image');
		$this->folder_image->setDbValue($rs->fields('folder_image'));
		$this->img1->setDbValue($rs->fields('img1'));
		$this->img2->setDbValue($rs->fields('img2'));
		$this->img3->setDbValue($rs->fields('img3'));
		$this->img4->setDbValue($rs->fields('img4'));
		$this->img5->setDbValue($rs->fields('img5'));
		$this->pro_status->setDbValue($rs->fields('pro_status'));
		$this->branch_id->setDbValue($rs->fields('branch_id'));
		$this->lang->setDbValue($rs->fields('lang'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// product_id
		// cat_id
		// company_id
		// pro_name
		// pro_description
		// pro_condition
		// pro_features
		// pro_model
		// post_date
		// ads_id
		// pro_base_price
		// pro_sell_price
		// featured_image
		// folder_image
		// img1
		// img2
		// img3
		// img4
		// img5
		// pro_status
		// branch_id
		// lang
		// product_id

		$this->product_id->ViewValue = $this->product_id->CurrentValue;
		$this->product_id->ViewCustomAttributes = "";

		// cat_id
		if ($this->cat_id->VirtualValue <> "") {
			$this->cat_id->ViewValue = $this->cat_id->VirtualValue;
		} else {
		if (strval($this->cat_id->CurrentValue) <> "") {
			$sFilterWrk = "`cat_id`" . ew_SearchString("=", $this->cat_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `cat_id`, `cat_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categories`";
		$sWhereWrk = "";
		$this->cat_id->LookupFilters = array("dx1" => '`cat_name`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->cat_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->cat_id->ViewValue = $this->cat_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->cat_id->ViewValue = $this->cat_id->CurrentValue;
			}
		} else {
			$this->cat_id->ViewValue = NULL;
		}
		}
		$this->cat_id->ViewCustomAttributes = "";

		// company_id
		if ($this->company_id->VirtualValue <> "") {
			$this->company_id->ViewValue = $this->company_id->VirtualValue;
		} else {
		if (strval($this->company_id->CurrentValue) <> "") {
			$sFilterWrk = "`company_id`" . ew_SearchString("=", $this->company_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT DISTINCT `company_id`, `com_fname` AS `DispFld`, `com_lname` AS `Disp2Fld`, `com_name` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `company`";
		$sWhereWrk = "";
		$this->company_id->LookupFilters = array("dx1" => '`com_fname`', "dx2" => '`com_lname`', "dx3" => '`com_name`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->company_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->company_id->ViewValue = $this->company_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->company_id->ViewValue = $this->company_id->CurrentValue;
			}
		} else {
			$this->company_id->ViewValue = NULL;
		}
		}
		$this->company_id->ViewCustomAttributes = "";

		// pro_name
		$this->pro_name->ViewValue = $this->pro_name->CurrentValue;
		$this->pro_name->ViewCustomAttributes = "";

		// pro_description
		$this->pro_description->ViewValue = $this->pro_description->CurrentValue;
		$this->pro_description->ViewCustomAttributes = "";

		// pro_condition
		if (strval($this->pro_condition->CurrentValue) <> "") {
			$this->pro_condition->ViewValue = $this->pro_condition->OptionCaption($this->pro_condition->CurrentValue);
		} else {
			$this->pro_condition->ViewValue = NULL;
		}
		$this->pro_condition->ViewCustomAttributes = "";

		// pro_features
		$this->pro_features->ViewValue = $this->pro_features->CurrentValue;
		$this->pro_features->ViewCustomAttributes = "";

		// pro_model
		$this->pro_model->ViewValue = $this->pro_model->CurrentValue;
		$this->pro_model->ViewCustomAttributes = "";

		// post_date
		$this->post_date->ViewValue = $this->post_date->CurrentValue;
		$this->post_date->ViewValue = ew_FormatDateTime($this->post_date->ViewValue, 0);
		$this->post_date->ViewCustomAttributes = "";

		// ads_id
		$this->ads_id->ViewValue = $this->ads_id->CurrentValue;
		$this->ads_id->ViewCustomAttributes = "";

		// pro_base_price
		$this->pro_base_price->ViewValue = $this->pro_base_price->CurrentValue;
		$this->pro_base_price->ViewCustomAttributes = "";

		// pro_sell_price
		$this->pro_sell_price->ViewValue = $this->pro_sell_price->CurrentValue;
		$this->pro_sell_price->ViewCustomAttributes = "";

		// featured_image
		$this->featured_image->UploadPath = "../uploads/product/";
		if (!ew_Empty($this->featured_image->Upload->DbValue)) {
			$this->featured_image->ImageWidth = 0;
			$this->featured_image->ImageHeight = 94;
			$this->featured_image->ImageAlt = $this->featured_image->FldAlt();
			$this->featured_image->ViewValue = $this->featured_image->Upload->DbValue;
		} else {
			$this->featured_image->ViewValue = "";
		}
		$this->featured_image->ViewCustomAttributes = "";

		// folder_image
		if (strval($this->folder_image->CurrentValue) <> "") {
			$arwrk = explode(",", $this->folder_image->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`pro_gallery_id`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT `pro_gallery_id`, `image` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `product_gallery`";
		$sWhereWrk = "";
		$this->folder_image->LookupFilters = array("dx1" => '`image`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->folder_image, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->folder_image->ViewValue = "";
				$ari = 0;
				while (!$rswrk->EOF) {
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->folder_image->ViewValue .= $this->folder_image->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->folder_image->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->Close();
			} else {
				$this->folder_image->ViewValue = $this->folder_image->CurrentValue;
			}
		} else {
			$this->folder_image->ViewValue = NULL;
		}
		$this->folder_image->ViewCustomAttributes = "";

		// img1
		$this->img1->ViewValue = $this->img1->CurrentValue;
		$this->img1->ViewCustomAttributes = "";

		// img2
		$this->img2->ViewValue = $this->img2->CurrentValue;
		$this->img2->ViewCustomAttributes = "";

		// img3
		$this->img3->ViewValue = $this->img3->CurrentValue;
		$this->img3->ViewCustomAttributes = "";

		// img4
		$this->img4->ViewValue = $this->img4->CurrentValue;
		$this->img4->ViewCustomAttributes = "";

		// img5
		$this->img5->ViewValue = $this->img5->CurrentValue;
		$this->img5->ViewCustomAttributes = "";

		// pro_status
		if (ew_ConvertToBool($this->pro_status->CurrentValue)) {
			$this->pro_status->ViewValue = $this->pro_status->FldTagCaption(1) <> "" ? $this->pro_status->FldTagCaption(1) : "Y";
		} else {
			$this->pro_status->ViewValue = $this->pro_status->FldTagCaption(2) <> "" ? $this->pro_status->FldTagCaption(2) : "N";
		}
		$this->pro_status->ViewCustomAttributes = "";

		// branch_id
		if (strval($this->branch_id->CurrentValue) <> "") {
			$sFilterWrk = "`branch_id`" . ew_SearchString("=", $this->branch_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `branch_id`, `branch_id` AS `DispFld`, `name` AS `Disp2Fld`, `image` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `branch`";
		$sWhereWrk = "";
		$this->branch_id->LookupFilters = array("dx1" => '`branch_id`', "dx2" => '`name`', "dx3" => '`image`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->branch_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->branch_id->ViewValue = $this->branch_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->branch_id->ViewValue = $this->branch_id->CurrentValue;
			}
		} else {
			$this->branch_id->ViewValue = NULL;
		}
		$this->branch_id->ViewCustomAttributes = "";

		// lang
		$this->lang->ViewValue = $this->lang->CurrentValue;
		$this->lang->ViewCustomAttributes = "";

		// product_id
		$this->product_id->LinkCustomAttributes = "";
		$this->product_id->HrefValue = "";
		$this->product_id->TooltipValue = "";

		// cat_id
		$this->cat_id->LinkCustomAttributes = "";
		$this->cat_id->HrefValue = "";
		$this->cat_id->TooltipValue = "";

		// company_id
		$this->company_id->LinkCustomAttributes = "";
		$this->company_id->HrefValue = "";
		$this->company_id->TooltipValue = "";

		// pro_name
		$this->pro_name->LinkCustomAttributes = "";
		$this->pro_name->HrefValue = "";
		$this->pro_name->TooltipValue = "";

		// pro_description
		$this->pro_description->LinkCustomAttributes = "";
		$this->pro_description->HrefValue = "";
		$this->pro_description->TooltipValue = "";

		// pro_condition
		$this->pro_condition->LinkCustomAttributes = "";
		$this->pro_condition->HrefValue = "";
		$this->pro_condition->TooltipValue = "";

		// pro_features
		$this->pro_features->LinkCustomAttributes = "";
		$this->pro_features->HrefValue = "";
		$this->pro_features->TooltipValue = "";

		// pro_model
		$this->pro_model->LinkCustomAttributes = "";
		$this->pro_model->HrefValue = "";
		$this->pro_model->TooltipValue = "";

		// post_date
		$this->post_date->LinkCustomAttributes = "";
		$this->post_date->HrefValue = "";
		$this->post_date->TooltipValue = "";

		// ads_id
		$this->ads_id->LinkCustomAttributes = "";
		$this->ads_id->HrefValue = "";
		$this->ads_id->TooltipValue = "";

		// pro_base_price
		$this->pro_base_price->LinkCustomAttributes = "";
		$this->pro_base_price->HrefValue = "";
		$this->pro_base_price->TooltipValue = "";

		// pro_sell_price
		$this->pro_sell_price->LinkCustomAttributes = "";
		$this->pro_sell_price->HrefValue = "";
		$this->pro_sell_price->TooltipValue = "";

		// featured_image
		$this->featured_image->LinkCustomAttributes = "";
		$this->featured_image->UploadPath = "../uploads/product/";
		if (!ew_Empty($this->featured_image->Upload->DbValue)) {
			$this->featured_image->HrefValue = ew_GetFileUploadUrl($this->featured_image, $this->featured_image->Upload->DbValue); // Add prefix/suffix
			$this->featured_image->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->featured_image->HrefValue = ew_FullUrl($this->featured_image->HrefValue, "href");
		} else {
			$this->featured_image->HrefValue = "";
		}
		$this->featured_image->HrefValue2 = $this->featured_image->UploadPath . $this->featured_image->Upload->DbValue;
		$this->featured_image->TooltipValue = "";
		if ($this->featured_image->UseColorbox) {
			if (ew_Empty($this->featured_image->TooltipValue))
				$this->featured_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->featured_image->LinkAttrs["data-rel"] = "products_x_featured_image";
			ew_AppendClass($this->featured_image->LinkAttrs["class"], "ewLightbox");
		}

		// folder_image
		$this->folder_image->LinkCustomAttributes = "";
		$this->folder_image->HrefValue = "";
		$this->folder_image->TooltipValue = "";

		// img1
		$this->img1->LinkCustomAttributes = "";
		$this->img1->HrefValue = "";
		$this->img1->TooltipValue = "";

		// img2
		$this->img2->LinkCustomAttributes = "";
		$this->img2->HrefValue = "";
		$this->img2->TooltipValue = "";

		// img3
		$this->img3->LinkCustomAttributes = "";
		$this->img3->HrefValue = "";
		$this->img3->TooltipValue = "";

		// img4
		$this->img4->LinkCustomAttributes = "";
		$this->img4->HrefValue = "";
		$this->img4->TooltipValue = "";

		// img5
		$this->img5->LinkCustomAttributes = "";
		$this->img5->HrefValue = "";
		$this->img5->TooltipValue = "";

		// pro_status
		$this->pro_status->LinkCustomAttributes = "";
		$this->pro_status->HrefValue = "";
		$this->pro_status->TooltipValue = "";

		// branch_id
		$this->branch_id->LinkCustomAttributes = "";
		$this->branch_id->HrefValue = "";
		$this->branch_id->TooltipValue = "";

		// lang
		$this->lang->LinkCustomAttributes = "";
		$this->lang->HrefValue = "";
		$this->lang->TooltipValue = "";

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

		// product_id
		$this->product_id->EditAttrs["class"] = "form-control";
		$this->product_id->EditCustomAttributes = "";
		$this->product_id->EditValue = $this->product_id->CurrentValue;
		$this->product_id->ViewCustomAttributes = "";

		// cat_id
		$this->cat_id->EditAttrs["class"] = "form-control";
		$this->cat_id->EditCustomAttributes = "";
		if ($this->cat_id->VirtualValue <> "") {
			$this->cat_id->EditValue = $this->cat_id->VirtualValue;
		} else {
		if (strval($this->cat_id->CurrentValue) <> "") {
			$sFilterWrk = "`cat_id`" . ew_SearchString("=", $this->cat_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `cat_id`, `cat_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categories`";
		$sWhereWrk = "";
		$this->cat_id->LookupFilters = array("dx1" => '`cat_name`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->cat_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->cat_id->EditValue = $this->cat_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->cat_id->EditValue = $this->cat_id->CurrentValue;
			}
		} else {
			$this->cat_id->EditValue = NULL;
		}
		}
		$this->cat_id->ViewCustomAttributes = "";

		// company_id
		$this->company_id->EditAttrs["class"] = "form-control";
		$this->company_id->EditCustomAttributes = "";
		if ($this->company_id->VirtualValue <> "") {
			$this->company_id->EditValue = $this->company_id->VirtualValue;
		} else {
		if (strval($this->company_id->CurrentValue) <> "") {
			$sFilterWrk = "`company_id`" . ew_SearchString("=", $this->company_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT DISTINCT `company_id`, `com_fname` AS `DispFld`, `com_lname` AS `Disp2Fld`, `com_name` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `company`";
		$sWhereWrk = "";
		$this->company_id->LookupFilters = array("dx1" => '`com_fname`', "dx2" => '`com_lname`', "dx3" => '`com_name`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->company_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->company_id->EditValue = $this->company_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->company_id->EditValue = $this->company_id->CurrentValue;
			}
		} else {
			$this->company_id->EditValue = NULL;
		}
		}
		$this->company_id->ViewCustomAttributes = "";

		// pro_name
		$this->pro_name->EditAttrs["class"] = "form-control";
		$this->pro_name->EditCustomAttributes = "";
		$this->pro_name->EditValue = $this->pro_name->CurrentValue;
		$this->pro_name->PlaceHolder = ew_RemoveHtml($this->pro_name->FldCaption());

		// pro_description
		$this->pro_description->EditAttrs["class"] = "form-control";
		$this->pro_description->EditCustomAttributes = "";
		$this->pro_description->EditValue = $this->pro_description->CurrentValue;
		$this->pro_description->PlaceHolder = ew_RemoveHtml($this->pro_description->FldCaption());

		// pro_condition
		$this->pro_condition->EditAttrs["class"] = "form-control";
		$this->pro_condition->EditCustomAttributes = "";
		$this->pro_condition->EditValue = $this->pro_condition->Options(TRUE);

		// pro_features
		$this->pro_features->EditAttrs["class"] = "form-control";
		$this->pro_features->EditCustomAttributes = "";
		$this->pro_features->EditValue = $this->pro_features->CurrentValue;
		$this->pro_features->PlaceHolder = ew_RemoveHtml($this->pro_features->FldCaption());

		// pro_model
		$this->pro_model->EditAttrs["class"] = "form-control";
		$this->pro_model->EditCustomAttributes = "";
		$this->pro_model->EditValue = $this->pro_model->CurrentValue;
		$this->pro_model->PlaceHolder = ew_RemoveHtml($this->pro_model->FldCaption());

		// post_date
		$this->post_date->EditAttrs["class"] = "form-control";
		$this->post_date->EditCustomAttributes = "";
		$this->post_date->EditValue = ew_FormatDateTime($this->post_date->CurrentValue, 8);
		$this->post_date->PlaceHolder = ew_RemoveHtml($this->post_date->FldCaption());

		// ads_id
		$this->ads_id->EditAttrs["class"] = "form-control";
		$this->ads_id->EditCustomAttributes = "";
		$this->ads_id->EditValue = $this->ads_id->CurrentValue;
		$this->ads_id->PlaceHolder = ew_RemoveHtml($this->ads_id->FldCaption());

		// pro_base_price
		$this->pro_base_price->EditAttrs["class"] = "form-control";
		$this->pro_base_price->EditCustomAttributes = "";
		$this->pro_base_price->EditValue = $this->pro_base_price->CurrentValue;
		$this->pro_base_price->PlaceHolder = ew_RemoveHtml($this->pro_base_price->FldCaption());
		if (strval($this->pro_base_price->EditValue) <> "" && is_numeric($this->pro_base_price->EditValue)) $this->pro_base_price->EditValue = ew_FormatNumber($this->pro_base_price->EditValue, -2, -1, -2, 0);

		// pro_sell_price
		$this->pro_sell_price->EditAttrs["class"] = "form-control";
		$this->pro_sell_price->EditCustomAttributes = "";
		$this->pro_sell_price->EditValue = $this->pro_sell_price->CurrentValue;
		$this->pro_sell_price->PlaceHolder = ew_RemoveHtml($this->pro_sell_price->FldCaption());
		if (strval($this->pro_sell_price->EditValue) <> "" && is_numeric($this->pro_sell_price->EditValue)) $this->pro_sell_price->EditValue = ew_FormatNumber($this->pro_sell_price->EditValue, -2, -1, -2, 0);

		// featured_image
		$this->featured_image->EditAttrs["class"] = "form-control";
		$this->featured_image->EditCustomAttributes = "";
		$this->featured_image->UploadPath = "../uploads/product/";
		if (!ew_Empty($this->featured_image->Upload->DbValue)) {
			$this->featured_image->ImageWidth = 0;
			$this->featured_image->ImageHeight = 94;
			$this->featured_image->ImageAlt = $this->featured_image->FldAlt();
			$this->featured_image->EditValue = $this->featured_image->Upload->DbValue;
		} else {
			$this->featured_image->EditValue = "";
		}
		if (!ew_Empty($this->featured_image->CurrentValue))
				$this->featured_image->Upload->FileName = $this->featured_image->CurrentValue;

		// folder_image
		$this->folder_image->EditAttrs["class"] = "form-control";
		$this->folder_image->EditCustomAttributes = "";

		// img1
		$this->img1->EditAttrs["class"] = "form-control";
		$this->img1->EditCustomAttributes = "";
		$this->img1->EditValue = $this->img1->CurrentValue;
		$this->img1->PlaceHolder = ew_RemoveHtml($this->img1->FldCaption());

		// img2
		$this->img2->EditAttrs["class"] = "form-control";
		$this->img2->EditCustomAttributes = "";
		$this->img2->EditValue = $this->img2->CurrentValue;
		$this->img2->PlaceHolder = ew_RemoveHtml($this->img2->FldCaption());

		// img3
		$this->img3->EditAttrs["class"] = "form-control";
		$this->img3->EditCustomAttributes = "";
		$this->img3->EditValue = $this->img3->CurrentValue;
		$this->img3->PlaceHolder = ew_RemoveHtml($this->img3->FldCaption());

		// img4
		$this->img4->EditAttrs["class"] = "form-control";
		$this->img4->EditCustomAttributes = "";
		$this->img4->EditValue = $this->img4->CurrentValue;
		$this->img4->PlaceHolder = ew_RemoveHtml($this->img4->FldCaption());

		// img5
		$this->img5->EditAttrs["class"] = "form-control";
		$this->img5->EditCustomAttributes = "";
		$this->img5->EditValue = $this->img5->CurrentValue;
		$this->img5->PlaceHolder = ew_RemoveHtml($this->img5->FldCaption());

		// pro_status
		$this->pro_status->EditCustomAttributes = "";
		$this->pro_status->EditValue = $this->pro_status->Options(FALSE);

		// branch_id
		$this->branch_id->EditAttrs["class"] = "form-control";
		$this->branch_id->EditCustomAttributes = "";

		// lang
		$this->lang->EditAttrs["class"] = "form-control";
		$this->lang->EditCustomAttributes = "";
		$this->lang->EditValue = $this->lang->CurrentValue;
		$this->lang->PlaceHolder = ew_RemoveHtml($this->lang->FldCaption());

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
					if ($this->product_id->Exportable) $Doc->ExportCaption($this->product_id);
					if ($this->cat_id->Exportable) $Doc->ExportCaption($this->cat_id);
					if ($this->company_id->Exportable) $Doc->ExportCaption($this->company_id);
					if ($this->pro_name->Exportable) $Doc->ExportCaption($this->pro_name);
					if ($this->pro_description->Exportable) $Doc->ExportCaption($this->pro_description);
					if ($this->pro_condition->Exportable) $Doc->ExportCaption($this->pro_condition);
					if ($this->pro_features->Exportable) $Doc->ExportCaption($this->pro_features);
					if ($this->pro_model->Exportable) $Doc->ExportCaption($this->pro_model);
					if ($this->post_date->Exportable) $Doc->ExportCaption($this->post_date);
					if ($this->ads_id->Exportable) $Doc->ExportCaption($this->ads_id);
					if ($this->pro_base_price->Exportable) $Doc->ExportCaption($this->pro_base_price);
					if ($this->pro_sell_price->Exportable) $Doc->ExportCaption($this->pro_sell_price);
					if ($this->featured_image->Exportable) $Doc->ExportCaption($this->featured_image);
					if ($this->folder_image->Exportable) $Doc->ExportCaption($this->folder_image);
					if ($this->img1->Exportable) $Doc->ExportCaption($this->img1);
					if ($this->img2->Exportable) $Doc->ExportCaption($this->img2);
					if ($this->img3->Exportable) $Doc->ExportCaption($this->img3);
					if ($this->img4->Exportable) $Doc->ExportCaption($this->img4);
					if ($this->img5->Exportable) $Doc->ExportCaption($this->img5);
					if ($this->pro_status->Exportable) $Doc->ExportCaption($this->pro_status);
					if ($this->branch_id->Exportable) $Doc->ExportCaption($this->branch_id);
					if ($this->lang->Exportable) $Doc->ExportCaption($this->lang);
				} else {
					if ($this->product_id->Exportable) $Doc->ExportCaption($this->product_id);
					if ($this->cat_id->Exportable) $Doc->ExportCaption($this->cat_id);
					if ($this->company_id->Exportable) $Doc->ExportCaption($this->company_id);
					if ($this->pro_name->Exportable) $Doc->ExportCaption($this->pro_name);
					if ($this->pro_condition->Exportable) $Doc->ExportCaption($this->pro_condition);
					if ($this->pro_features->Exportable) $Doc->ExportCaption($this->pro_features);
					if ($this->pro_model->Exportable) $Doc->ExportCaption($this->pro_model);
					if ($this->post_date->Exportable) $Doc->ExportCaption($this->post_date);
					if ($this->ads_id->Exportable) $Doc->ExportCaption($this->ads_id);
					if ($this->pro_base_price->Exportable) $Doc->ExportCaption($this->pro_base_price);
					if ($this->pro_sell_price->Exportable) $Doc->ExportCaption($this->pro_sell_price);
					if ($this->featured_image->Exportable) $Doc->ExportCaption($this->featured_image);
					if ($this->folder_image->Exportable) $Doc->ExportCaption($this->folder_image);
					if ($this->img1->Exportable) $Doc->ExportCaption($this->img1);
					if ($this->img2->Exportable) $Doc->ExportCaption($this->img2);
					if ($this->img3->Exportable) $Doc->ExportCaption($this->img3);
					if ($this->img4->Exportable) $Doc->ExportCaption($this->img4);
					if ($this->img5->Exportable) $Doc->ExportCaption($this->img5);
					if ($this->pro_status->Exportable) $Doc->ExportCaption($this->pro_status);
					if ($this->branch_id->Exportable) $Doc->ExportCaption($this->branch_id);
					if ($this->lang->Exportable) $Doc->ExportCaption($this->lang);
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
						if ($this->product_id->Exportable) $Doc->ExportField($this->product_id);
						if ($this->cat_id->Exportable) $Doc->ExportField($this->cat_id);
						if ($this->company_id->Exportable) $Doc->ExportField($this->company_id);
						if ($this->pro_name->Exportable) $Doc->ExportField($this->pro_name);
						if ($this->pro_description->Exportable) $Doc->ExportField($this->pro_description);
						if ($this->pro_condition->Exportable) $Doc->ExportField($this->pro_condition);
						if ($this->pro_features->Exportable) $Doc->ExportField($this->pro_features);
						if ($this->pro_model->Exportable) $Doc->ExportField($this->pro_model);
						if ($this->post_date->Exportable) $Doc->ExportField($this->post_date);
						if ($this->ads_id->Exportable) $Doc->ExportField($this->ads_id);
						if ($this->pro_base_price->Exportable) $Doc->ExportField($this->pro_base_price);
						if ($this->pro_sell_price->Exportable) $Doc->ExportField($this->pro_sell_price);
						if ($this->featured_image->Exportable) $Doc->ExportField($this->featured_image);
						if ($this->folder_image->Exportable) $Doc->ExportField($this->folder_image);
						if ($this->img1->Exportable) $Doc->ExportField($this->img1);
						if ($this->img2->Exportable) $Doc->ExportField($this->img2);
						if ($this->img3->Exportable) $Doc->ExportField($this->img3);
						if ($this->img4->Exportable) $Doc->ExportField($this->img4);
						if ($this->img5->Exportable) $Doc->ExportField($this->img5);
						if ($this->pro_status->Exportable) $Doc->ExportField($this->pro_status);
						if ($this->branch_id->Exportable) $Doc->ExportField($this->branch_id);
						if ($this->lang->Exportable) $Doc->ExportField($this->lang);
					} else {
						if ($this->product_id->Exportable) $Doc->ExportField($this->product_id);
						if ($this->cat_id->Exportable) $Doc->ExportField($this->cat_id);
						if ($this->company_id->Exportable) $Doc->ExportField($this->company_id);
						if ($this->pro_name->Exportable) $Doc->ExportField($this->pro_name);
						if ($this->pro_condition->Exportable) $Doc->ExportField($this->pro_condition);
						if ($this->pro_features->Exportable) $Doc->ExportField($this->pro_features);
						if ($this->pro_model->Exportable) $Doc->ExportField($this->pro_model);
						if ($this->post_date->Exportable) $Doc->ExportField($this->post_date);
						if ($this->ads_id->Exportable) $Doc->ExportField($this->ads_id);
						if ($this->pro_base_price->Exportable) $Doc->ExportField($this->pro_base_price);
						if ($this->pro_sell_price->Exportable) $Doc->ExportField($this->pro_sell_price);
						if ($this->featured_image->Exportable) $Doc->ExportField($this->featured_image);
						if ($this->folder_image->Exportable) $Doc->ExportField($this->folder_image);
						if ($this->img1->Exportable) $Doc->ExportField($this->img1);
						if ($this->img2->Exportable) $Doc->ExportField($this->img2);
						if ($this->img3->Exportable) $Doc->ExportField($this->img3);
						if ($this->img4->Exportable) $Doc->ExportField($this->img4);
						if ($this->img5->Exportable) $Doc->ExportField($this->img5);
						if ($this->pro_status->Exportable) $Doc->ExportField($this->pro_status);
						if ($this->branch_id->Exportable) $Doc->ExportField($this->branch_id);
						if ($this->lang->Exportable) $Doc->ExportField($this->lang);
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

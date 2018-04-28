<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "productsinfo.php" ?>
<?php include_once "companyinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$products_delete = NULL; // Initialize page object first

class cproducts_delete extends cproducts {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'products';

	// Page object name
	var $PageObjName = 'products_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (products)
		if (!isset($GLOBALS["products"]) || get_class($GLOBALS["products"]) == "cproducts") {
			$GLOBALS["products"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["products"];
		}

		// Table object (company)
		if (!isset($GLOBALS['company'])) $GLOBALS['company'] = new ccompany();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'products', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// User table object (company)
		if (!isset($UserTable)) {
			$UserTable = new ccompany();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("productslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->product_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->product_id->Visible = FALSE;
		$this->cat_id->SetVisibility();
		$this->company_id->SetVisibility();
		$this->pro_name->SetVisibility();
		$this->pro_condition->SetVisibility();
		$this->pro_brand->SetVisibility();
		$this->pro_features->SetVisibility();
		$this->pro_model->SetVisibility();
		$this->post_date->SetVisibility();
		$this->ads_id->SetVisibility();
		$this->pro_base_price->SetVisibility();
		$this->pro_sell_price->SetVisibility();
		$this->featured_image->SetVisibility();
		$this->folder_image->SetVisibility();
		$this->img1->SetVisibility();
		$this->img2->SetVisibility();
		$this->img3->SetVisibility();
		$this->img4->SetVisibility();
		$this->img5->SetVisibility();
		$this->pro_status->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $products;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($products);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("productslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in products class, productsinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("productslist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->product_id->setDbValue($row['product_id']);
		$this->cat_id->setDbValue($row['cat_id']);
		$this->company_id->setDbValue($row['company_id']);
		$this->pro_name->setDbValue($row['pro_name']);
		$this->pro_description->setDbValue($row['pro_description']);
		$this->pro_condition->setDbValue($row['pro_condition']);
		$this->pro_brand->setDbValue($row['pro_brand']);
		$this->pro_features->setDbValue($row['pro_features']);
		$this->pro_model->setDbValue($row['pro_model']);
		$this->post_date->setDbValue($row['post_date']);
		$this->ads_id->setDbValue($row['ads_id']);
		$this->pro_base_price->setDbValue($row['pro_base_price']);
		$this->pro_sell_price->setDbValue($row['pro_sell_price']);
		$this->featured_image->setDbValue($row['featured_image']);
		$this->folder_image->setDbValue($row['folder_image']);
		$this->img1->setDbValue($row['img1']);
		$this->img2->setDbValue($row['img2']);
		$this->img3->setDbValue($row['img3']);
		$this->img4->setDbValue($row['img4']);
		$this->img5->setDbValue($row['img5']);
		$this->pro_status->setDbValue($row['pro_status']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['product_id'] = NULL;
		$row['cat_id'] = NULL;
		$row['company_id'] = NULL;
		$row['pro_name'] = NULL;
		$row['pro_description'] = NULL;
		$row['pro_condition'] = NULL;
		$row['pro_brand'] = NULL;
		$row['pro_features'] = NULL;
		$row['pro_model'] = NULL;
		$row['post_date'] = NULL;
		$row['ads_id'] = NULL;
		$row['pro_base_price'] = NULL;
		$row['pro_sell_price'] = NULL;
		$row['featured_image'] = NULL;
		$row['folder_image'] = NULL;
		$row['img1'] = NULL;
		$row['img2'] = NULL;
		$row['img3'] = NULL;
		$row['img4'] = NULL;
		$row['img5'] = NULL;
		$row['pro_status'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->product_id->DbValue = $row['product_id'];
		$this->cat_id->DbValue = $row['cat_id'];
		$this->company_id->DbValue = $row['company_id'];
		$this->pro_name->DbValue = $row['pro_name'];
		$this->pro_description->DbValue = $row['pro_description'];
		$this->pro_condition->DbValue = $row['pro_condition'];
		$this->pro_brand->DbValue = $row['pro_brand'];
		$this->pro_features->DbValue = $row['pro_features'];
		$this->pro_model->DbValue = $row['pro_model'];
		$this->post_date->DbValue = $row['post_date'];
		$this->ads_id->DbValue = $row['ads_id'];
		$this->pro_base_price->DbValue = $row['pro_base_price'];
		$this->pro_sell_price->DbValue = $row['pro_sell_price'];
		$this->featured_image->DbValue = $row['featured_image'];
		$this->folder_image->DbValue = $row['folder_image'];
		$this->img1->DbValue = $row['img1'];
		$this->img2->DbValue = $row['img2'];
		$this->img3->DbValue = $row['img3'];
		$this->img4->DbValue = $row['img4'];
		$this->img5->DbValue = $row['img5'];
		$this->pro_status->DbValue = $row['pro_status'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->pro_base_price->FormValue == $this->pro_base_price->CurrentValue && is_numeric(ew_StrToFloat($this->pro_base_price->CurrentValue)))
			$this->pro_base_price->CurrentValue = ew_StrToFloat($this->pro_base_price->CurrentValue);

		// Convert decimal values if posted back
		if ($this->pro_sell_price->FormValue == $this->pro_sell_price->CurrentValue && is_numeric(ew_StrToFloat($this->pro_sell_price->CurrentValue)))
			$this->pro_sell_price->CurrentValue = ew_StrToFloat($this->pro_sell_price->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// product_id
		// cat_id
		// company_id
		// pro_name
		// pro_description
		// pro_condition
		// pro_brand
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// product_id
		$this->product_id->ViewValue = $this->product_id->CurrentValue;
		$this->product_id->ViewCustomAttributes = "";

		// cat_id
		$this->cat_id->ViewValue = $this->cat_id->CurrentValue;
		$this->cat_id->ViewCustomAttributes = "";

		// company_id
		$this->company_id->ViewValue = $this->company_id->CurrentValue;
		$this->company_id->ViewCustomAttributes = "";

		// pro_name
		$this->pro_name->ViewValue = $this->pro_name->CurrentValue;
		$this->pro_name->ViewCustomAttributes = "";

		// pro_condition
		$this->pro_condition->ViewValue = $this->pro_condition->CurrentValue;
		$this->pro_condition->ViewCustomAttributes = "";

		// pro_brand
		$this->pro_brand->ViewValue = $this->pro_brand->CurrentValue;
		$this->pro_brand->ViewCustomAttributes = "";

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
		$this->featured_image->ViewValue = $this->featured_image->CurrentValue;
		$this->featured_image->ViewCustomAttributes = "";

		// folder_image
		$this->folder_image->ViewValue = $this->folder_image->CurrentValue;
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

			// pro_condition
			$this->pro_condition->LinkCustomAttributes = "";
			$this->pro_condition->HrefValue = "";
			$this->pro_condition->TooltipValue = "";

			// pro_brand
			$this->pro_brand->LinkCustomAttributes = "";
			$this->pro_brand->HrefValue = "";
			$this->pro_brand->TooltipValue = "";

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
			$this->featured_image->HrefValue = "";
			$this->featured_image->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['product_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['cat_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['company_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("productslist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($products_delete)) $products_delete = new cproducts_delete();

// Page init
$products_delete->Page_Init();

// Page main
$products_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$products_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fproductsdelete = new ew_Form("fproductsdelete", "delete");

// Form_CustomValidate event
fproductsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fproductsdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fproductsdelete.Lists["x_pro_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fproductsdelete.Lists["x_pro_status[]"].Options = <?php echo json_encode($products_delete->pro_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $products_delete->ShowPageHeader(); ?>
<?php
$products_delete->ShowMessage();
?>
<form name="fproductsdelete" id="fproductsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($products_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $products_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="products">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($products_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($products->product_id->Visible) { // product_id ?>
		<th class="<?php echo $products->product_id->HeaderCellClass() ?>"><span id="elh_products_product_id" class="products_product_id"><?php echo $products->product_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->cat_id->Visible) { // cat_id ?>
		<th class="<?php echo $products->cat_id->HeaderCellClass() ?>"><span id="elh_products_cat_id" class="products_cat_id"><?php echo $products->cat_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->company_id->Visible) { // company_id ?>
		<th class="<?php echo $products->company_id->HeaderCellClass() ?>"><span id="elh_products_company_id" class="products_company_id"><?php echo $products->company_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->pro_name->Visible) { // pro_name ?>
		<th class="<?php echo $products->pro_name->HeaderCellClass() ?>"><span id="elh_products_pro_name" class="products_pro_name"><?php echo $products->pro_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->pro_condition->Visible) { // pro_condition ?>
		<th class="<?php echo $products->pro_condition->HeaderCellClass() ?>"><span id="elh_products_pro_condition" class="products_pro_condition"><?php echo $products->pro_condition->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->pro_brand->Visible) { // pro_brand ?>
		<th class="<?php echo $products->pro_brand->HeaderCellClass() ?>"><span id="elh_products_pro_brand" class="products_pro_brand"><?php echo $products->pro_brand->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->pro_features->Visible) { // pro_features ?>
		<th class="<?php echo $products->pro_features->HeaderCellClass() ?>"><span id="elh_products_pro_features" class="products_pro_features"><?php echo $products->pro_features->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->pro_model->Visible) { // pro_model ?>
		<th class="<?php echo $products->pro_model->HeaderCellClass() ?>"><span id="elh_products_pro_model" class="products_pro_model"><?php echo $products->pro_model->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->post_date->Visible) { // post_date ?>
		<th class="<?php echo $products->post_date->HeaderCellClass() ?>"><span id="elh_products_post_date" class="products_post_date"><?php echo $products->post_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->ads_id->Visible) { // ads_id ?>
		<th class="<?php echo $products->ads_id->HeaderCellClass() ?>"><span id="elh_products_ads_id" class="products_ads_id"><?php echo $products->ads_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->pro_base_price->Visible) { // pro_base_price ?>
		<th class="<?php echo $products->pro_base_price->HeaderCellClass() ?>"><span id="elh_products_pro_base_price" class="products_pro_base_price"><?php echo $products->pro_base_price->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->pro_sell_price->Visible) { // pro_sell_price ?>
		<th class="<?php echo $products->pro_sell_price->HeaderCellClass() ?>"><span id="elh_products_pro_sell_price" class="products_pro_sell_price"><?php echo $products->pro_sell_price->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->featured_image->Visible) { // featured_image ?>
		<th class="<?php echo $products->featured_image->HeaderCellClass() ?>"><span id="elh_products_featured_image" class="products_featured_image"><?php echo $products->featured_image->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->folder_image->Visible) { // folder_image ?>
		<th class="<?php echo $products->folder_image->HeaderCellClass() ?>"><span id="elh_products_folder_image" class="products_folder_image"><?php echo $products->folder_image->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->img1->Visible) { // img1 ?>
		<th class="<?php echo $products->img1->HeaderCellClass() ?>"><span id="elh_products_img1" class="products_img1"><?php echo $products->img1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->img2->Visible) { // img2 ?>
		<th class="<?php echo $products->img2->HeaderCellClass() ?>"><span id="elh_products_img2" class="products_img2"><?php echo $products->img2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->img3->Visible) { // img3 ?>
		<th class="<?php echo $products->img3->HeaderCellClass() ?>"><span id="elh_products_img3" class="products_img3"><?php echo $products->img3->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->img4->Visible) { // img4 ?>
		<th class="<?php echo $products->img4->HeaderCellClass() ?>"><span id="elh_products_img4" class="products_img4"><?php echo $products->img4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->img5->Visible) { // img5 ?>
		<th class="<?php echo $products->img5->HeaderCellClass() ?>"><span id="elh_products_img5" class="products_img5"><?php echo $products->img5->FldCaption() ?></span></th>
<?php } ?>
<?php if ($products->pro_status->Visible) { // pro_status ?>
		<th class="<?php echo $products->pro_status->HeaderCellClass() ?>"><span id="elh_products_pro_status" class="products_pro_status"><?php echo $products->pro_status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$products_delete->RecCnt = 0;
$i = 0;
while (!$products_delete->Recordset->EOF) {
	$products_delete->RecCnt++;
	$products_delete->RowCnt++;

	// Set row properties
	$products->ResetAttrs();
	$products->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$products_delete->LoadRowValues($products_delete->Recordset);

	// Render row
	$products_delete->RenderRow();
?>
	<tr<?php echo $products->RowAttributes() ?>>
<?php if ($products->product_id->Visible) { // product_id ?>
		<td<?php echo $products->product_id->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_product_id" class="products_product_id">
<span<?php echo $products->product_id->ViewAttributes() ?>>
<?php echo $products->product_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->cat_id->Visible) { // cat_id ?>
		<td<?php echo $products->cat_id->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_cat_id" class="products_cat_id">
<span<?php echo $products->cat_id->ViewAttributes() ?>>
<?php echo $products->cat_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->company_id->Visible) { // company_id ?>
		<td<?php echo $products->company_id->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_company_id" class="products_company_id">
<span<?php echo $products->company_id->ViewAttributes() ?>>
<?php echo $products->company_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->pro_name->Visible) { // pro_name ?>
		<td<?php echo $products->pro_name->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_pro_name" class="products_pro_name">
<span<?php echo $products->pro_name->ViewAttributes() ?>>
<?php echo $products->pro_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->pro_condition->Visible) { // pro_condition ?>
		<td<?php echo $products->pro_condition->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_pro_condition" class="products_pro_condition">
<span<?php echo $products->pro_condition->ViewAttributes() ?>>
<?php echo $products->pro_condition->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->pro_brand->Visible) { // pro_brand ?>
		<td<?php echo $products->pro_brand->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_pro_brand" class="products_pro_brand">
<span<?php echo $products->pro_brand->ViewAttributes() ?>>
<?php echo $products->pro_brand->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->pro_features->Visible) { // pro_features ?>
		<td<?php echo $products->pro_features->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_pro_features" class="products_pro_features">
<span<?php echo $products->pro_features->ViewAttributes() ?>>
<?php echo $products->pro_features->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->pro_model->Visible) { // pro_model ?>
		<td<?php echo $products->pro_model->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_pro_model" class="products_pro_model">
<span<?php echo $products->pro_model->ViewAttributes() ?>>
<?php echo $products->pro_model->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->post_date->Visible) { // post_date ?>
		<td<?php echo $products->post_date->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_post_date" class="products_post_date">
<span<?php echo $products->post_date->ViewAttributes() ?>>
<?php echo $products->post_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->ads_id->Visible) { // ads_id ?>
		<td<?php echo $products->ads_id->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_ads_id" class="products_ads_id">
<span<?php echo $products->ads_id->ViewAttributes() ?>>
<?php echo $products->ads_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->pro_base_price->Visible) { // pro_base_price ?>
		<td<?php echo $products->pro_base_price->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_pro_base_price" class="products_pro_base_price">
<span<?php echo $products->pro_base_price->ViewAttributes() ?>>
<?php echo $products->pro_base_price->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->pro_sell_price->Visible) { // pro_sell_price ?>
		<td<?php echo $products->pro_sell_price->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_pro_sell_price" class="products_pro_sell_price">
<span<?php echo $products->pro_sell_price->ViewAttributes() ?>>
<?php echo $products->pro_sell_price->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->featured_image->Visible) { // featured_image ?>
		<td<?php echo $products->featured_image->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_featured_image" class="products_featured_image">
<span<?php echo $products->featured_image->ViewAttributes() ?>>
<?php echo $products->featured_image->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->folder_image->Visible) { // folder_image ?>
		<td<?php echo $products->folder_image->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_folder_image" class="products_folder_image">
<span<?php echo $products->folder_image->ViewAttributes() ?>>
<?php echo $products->folder_image->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->img1->Visible) { // img1 ?>
		<td<?php echo $products->img1->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_img1" class="products_img1">
<span<?php echo $products->img1->ViewAttributes() ?>>
<?php echo $products->img1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->img2->Visible) { // img2 ?>
		<td<?php echo $products->img2->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_img2" class="products_img2">
<span<?php echo $products->img2->ViewAttributes() ?>>
<?php echo $products->img2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->img3->Visible) { // img3 ?>
		<td<?php echo $products->img3->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_img3" class="products_img3">
<span<?php echo $products->img3->ViewAttributes() ?>>
<?php echo $products->img3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->img4->Visible) { // img4 ?>
		<td<?php echo $products->img4->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_img4" class="products_img4">
<span<?php echo $products->img4->ViewAttributes() ?>>
<?php echo $products->img4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->img5->Visible) { // img5 ?>
		<td<?php echo $products->img5->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_img5" class="products_img5">
<span<?php echo $products->img5->ViewAttributes() ?>>
<?php echo $products->img5->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($products->pro_status->Visible) { // pro_status ?>
		<td<?php echo $products->pro_status->CellAttributes() ?>>
<span id="el<?php echo $products_delete->RowCnt ?>_products_pro_status" class="products_pro_status">
<span<?php echo $products->pro_status->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($products->pro_status->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $products->pro_status->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $products->pro_status->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$products_delete->Recordset->MoveNext();
}
$products_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $products_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fproductsdelete.Init();
</script>
<?php
$products_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$products_delete->Page_Terminate();
?>

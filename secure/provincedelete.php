<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "provinceinfo.php" ?>
<?php include_once "companyinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$province_delete = NULL; // Initialize page object first

class cprovince_delete extends cprovince {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'province';

	// Page object name
	var $PageObjName = 'province_delete';

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

		// Table object (province)
		if (!isset($GLOBALS["province"]) || get_class($GLOBALS["province"]) == "cprovince") {
			$GLOBALS["province"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["province"];
		}

		// Table object (company)
		if (!isset($GLOBALS['company'])) $GLOBALS['company'] = new ccompany();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'province', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("provincelist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->province_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->province_id->Visible = FALSE;
		$this->country_id->SetVisibility();
		$this->province_name_kh->SetVisibility();
		$this->province_name_en->SetVisibility();
		$this->capital_kh->SetVisibility();
		$this->capital_en->SetVisibility();
		$this->population_kh->SetVisibility();
		$this->population_en->SetVisibility();
		$this->area_kh->SetVisibility();
		$this->area_en->SetVisibility();
		$this->density_kh->SetVisibility();
		$this->density_en->SetVisibility();
		$this->province_code->SetVisibility();
		$this->image->SetVisibility();

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
		global $EW_EXPORT, $province;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($province);
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
			$this->Page_Terminate("provincelist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in province class, provinceinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("provincelist.php"); // Return to list
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
		$this->province_id->setDbValue($row['province_id']);
		$this->country_id->setDbValue($row['country_id']);
		$this->province_name_kh->setDbValue($row['province_name_kh']);
		$this->province_name_en->setDbValue($row['province_name_en']);
		$this->capital_kh->setDbValue($row['capital_kh']);
		$this->capital_en->setDbValue($row['capital_en']);
		$this->population_kh->setDbValue($row['population_kh']);
		$this->population_en->setDbValue($row['population_en']);
		$this->area_kh->setDbValue($row['area_kh']);
		$this->area_en->setDbValue($row['area_en']);
		$this->density_kh->setDbValue($row['density_kh']);
		$this->density_en->setDbValue($row['density_en']);
		$this->province_code->setDbValue($row['province_code']);
		$this->image->setDbValue($row['image']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['province_id'] = NULL;
		$row['country_id'] = NULL;
		$row['province_name_kh'] = NULL;
		$row['province_name_en'] = NULL;
		$row['capital_kh'] = NULL;
		$row['capital_en'] = NULL;
		$row['population_kh'] = NULL;
		$row['population_en'] = NULL;
		$row['area_kh'] = NULL;
		$row['area_en'] = NULL;
		$row['density_kh'] = NULL;
		$row['density_en'] = NULL;
		$row['province_code'] = NULL;
		$row['image'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->province_id->DbValue = $row['province_id'];
		$this->country_id->DbValue = $row['country_id'];
		$this->province_name_kh->DbValue = $row['province_name_kh'];
		$this->province_name_en->DbValue = $row['province_name_en'];
		$this->capital_kh->DbValue = $row['capital_kh'];
		$this->capital_en->DbValue = $row['capital_en'];
		$this->population_kh->DbValue = $row['population_kh'];
		$this->population_en->DbValue = $row['population_en'];
		$this->area_kh->DbValue = $row['area_kh'];
		$this->area_en->DbValue = $row['area_en'];
		$this->density_kh->DbValue = $row['density_kh'];
		$this->density_en->DbValue = $row['density_en'];
		$this->province_code->DbValue = $row['province_code'];
		$this->image->DbValue = $row['image'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
				$sThisKey .= $row['province_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['country_id'];

				// Delete old files
				$this->LoadDbValues($row);
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("provincelist.php"), "", $this->TableVar, TRUE);
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
if (!isset($province_delete)) $province_delete = new cprovince_delete();

// Page init
$province_delete->Page_Init();

// Page main
$province_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$province_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fprovincedelete = new ew_Form("fprovincedelete", "delete");

// Form_CustomValidate event
fprovincedelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fprovincedelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $province_delete->ShowPageHeader(); ?>
<?php
$province_delete->ShowMessage();
?>
<form name="fprovincedelete" id="fprovincedelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($province_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $province_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="province">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($province_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($province->province_id->Visible) { // province_id ?>
		<th class="<?php echo $province->province_id->HeaderCellClass() ?>"><span id="elh_province_province_id" class="province_province_id"><?php echo $province->province_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->country_id->Visible) { // country_id ?>
		<th class="<?php echo $province->country_id->HeaderCellClass() ?>"><span id="elh_province_country_id" class="province_country_id"><?php echo $province->country_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->province_name_kh->Visible) { // province_name_kh ?>
		<th class="<?php echo $province->province_name_kh->HeaderCellClass() ?>"><span id="elh_province_province_name_kh" class="province_province_name_kh"><?php echo $province->province_name_kh->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->province_name_en->Visible) { // province_name_en ?>
		<th class="<?php echo $province->province_name_en->HeaderCellClass() ?>"><span id="elh_province_province_name_en" class="province_province_name_en"><?php echo $province->province_name_en->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->capital_kh->Visible) { // capital_kh ?>
		<th class="<?php echo $province->capital_kh->HeaderCellClass() ?>"><span id="elh_province_capital_kh" class="province_capital_kh"><?php echo $province->capital_kh->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->capital_en->Visible) { // capital_en ?>
		<th class="<?php echo $province->capital_en->HeaderCellClass() ?>"><span id="elh_province_capital_en" class="province_capital_en"><?php echo $province->capital_en->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->population_kh->Visible) { // population_kh ?>
		<th class="<?php echo $province->population_kh->HeaderCellClass() ?>"><span id="elh_province_population_kh" class="province_population_kh"><?php echo $province->population_kh->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->population_en->Visible) { // population_en ?>
		<th class="<?php echo $province->population_en->HeaderCellClass() ?>"><span id="elh_province_population_en" class="province_population_en"><?php echo $province->population_en->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->area_kh->Visible) { // area_kh ?>
		<th class="<?php echo $province->area_kh->HeaderCellClass() ?>"><span id="elh_province_area_kh" class="province_area_kh"><?php echo $province->area_kh->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->area_en->Visible) { // area_en ?>
		<th class="<?php echo $province->area_en->HeaderCellClass() ?>"><span id="elh_province_area_en" class="province_area_en"><?php echo $province->area_en->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->density_kh->Visible) { // density_kh ?>
		<th class="<?php echo $province->density_kh->HeaderCellClass() ?>"><span id="elh_province_density_kh" class="province_density_kh"><?php echo $province->density_kh->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->density_en->Visible) { // density_en ?>
		<th class="<?php echo $province->density_en->HeaderCellClass() ?>"><span id="elh_province_density_en" class="province_density_en"><?php echo $province->density_en->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->province_code->Visible) { // province_code ?>
		<th class="<?php echo $province->province_code->HeaderCellClass() ?>"><span id="elh_province_province_code" class="province_province_code"><?php echo $province->province_code->FldCaption() ?></span></th>
<?php } ?>
<?php if ($province->image->Visible) { // image ?>
		<th class="<?php echo $province->image->HeaderCellClass() ?>"><span id="elh_province_image" class="province_image"><?php echo $province->image->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$province_delete->RecCnt = 0;
$i = 0;
while (!$province_delete->Recordset->EOF) {
	$province_delete->RecCnt++;
	$province_delete->RowCnt++;

	// Set row properties
	$province->ResetAttrs();
	$province->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$province_delete->LoadRowValues($province_delete->Recordset);

	// Render row
	$province_delete->RenderRow();
?>
	<tr<?php echo $province->RowAttributes() ?>>
<?php if ($province->province_id->Visible) { // province_id ?>
		<td<?php echo $province->province_id->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_province_id" class="province_province_id">
<span<?php echo $province->province_id->ViewAttributes() ?>>
<?php echo $province->province_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->country_id->Visible) { // country_id ?>
		<td<?php echo $province->country_id->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_country_id" class="province_country_id">
<span<?php echo $province->country_id->ViewAttributes() ?>>
<?php echo $province->country_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->province_name_kh->Visible) { // province_name_kh ?>
		<td<?php echo $province->province_name_kh->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_province_name_kh" class="province_province_name_kh">
<span<?php echo $province->province_name_kh->ViewAttributes() ?>>
<?php echo $province->province_name_kh->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->province_name_en->Visible) { // province_name_en ?>
		<td<?php echo $province->province_name_en->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_province_name_en" class="province_province_name_en">
<span<?php echo $province->province_name_en->ViewAttributes() ?>>
<?php echo $province->province_name_en->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->capital_kh->Visible) { // capital_kh ?>
		<td<?php echo $province->capital_kh->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_capital_kh" class="province_capital_kh">
<span<?php echo $province->capital_kh->ViewAttributes() ?>>
<?php echo $province->capital_kh->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->capital_en->Visible) { // capital_en ?>
		<td<?php echo $province->capital_en->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_capital_en" class="province_capital_en">
<span<?php echo $province->capital_en->ViewAttributes() ?>>
<?php echo $province->capital_en->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->population_kh->Visible) { // population_kh ?>
		<td<?php echo $province->population_kh->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_population_kh" class="province_population_kh">
<span<?php echo $province->population_kh->ViewAttributes() ?>>
<?php echo $province->population_kh->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->population_en->Visible) { // population_en ?>
		<td<?php echo $province->population_en->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_population_en" class="province_population_en">
<span<?php echo $province->population_en->ViewAttributes() ?>>
<?php echo $province->population_en->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->area_kh->Visible) { // area_kh ?>
		<td<?php echo $province->area_kh->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_area_kh" class="province_area_kh">
<span<?php echo $province->area_kh->ViewAttributes() ?>>
<?php echo $province->area_kh->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->area_en->Visible) { // area_en ?>
		<td<?php echo $province->area_en->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_area_en" class="province_area_en">
<span<?php echo $province->area_en->ViewAttributes() ?>>
<?php echo $province->area_en->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->density_kh->Visible) { // density_kh ?>
		<td<?php echo $province->density_kh->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_density_kh" class="province_density_kh">
<span<?php echo $province->density_kh->ViewAttributes() ?>>
<?php echo $province->density_kh->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->density_en->Visible) { // density_en ?>
		<td<?php echo $province->density_en->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_density_en" class="province_density_en">
<span<?php echo $province->density_en->ViewAttributes() ?>>
<?php echo $province->density_en->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->province_code->Visible) { // province_code ?>
		<td<?php echo $province->province_code->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_province_code" class="province_province_code">
<span<?php echo $province->province_code->ViewAttributes() ?>>
<?php echo $province->province_code->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($province->image->Visible) { // image ?>
		<td<?php echo $province->image->CellAttributes() ?>>
<span id="el<?php echo $province_delete->RowCnt ?>_province_image" class="province_image">
<span<?php echo $province->image->ViewAttributes() ?>>
<?php echo $province->image->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$province_delete->Recordset->MoveNext();
}
$province_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $province_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fprovincedelete.Init();
</script>
<?php
$province_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$province_delete->Page_Terminate();
?>

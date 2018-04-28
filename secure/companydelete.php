<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "companyinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$company_delete = NULL; // Initialize page object first

class ccompany_delete extends ccompany {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'company';

	// Page object name
	var $PageObjName = 'company_delete';

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

		// Table object (company)
		if (!isset($GLOBALS["company"]) || get_class($GLOBALS["company"]) == "ccompany") {
			$GLOBALS["company"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["company"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'company', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("companylist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->company_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->company_id->Visible = FALSE;
		$this->com_fname->SetVisibility();
		$this->com_lname->SetVisibility();
		$this->com_name->SetVisibility();
		$this->com_phone->SetVisibility();
		$this->com_email->SetVisibility();
		$this->com_logo->SetVisibility();
		$this->com_province->SetVisibility();
		$this->com_username->SetVisibility();

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
		global $EW_EXPORT, $company;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($company);
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
			$this->Page_Terminate("companylist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in company class, companyinfo.php

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
				$this->Page_Terminate("companylist.php"); // Return to list
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
		$this->company_id->setDbValue($row['company_id']);
		$this->com_fname->setDbValue($row['com_fname']);
		$this->com_lname->setDbValue($row['com_lname']);
		$this->com_name->setDbValue($row['com_name']);
		$this->com_address->setDbValue($row['com_address']);
		$this->com_phone->setDbValue($row['com_phone']);
		$this->com_email->setDbValue($row['com_email']);
		$this->com_fb->setDbValue($row['com_fb']);
		$this->com_tw->setDbValue($row['com_tw']);
		$this->com_yt->setDbValue($row['com_yt']);
		$this->com_logo->setDbValue($row['com_logo']);
		$this->com_province->setDbValue($row['com_province']);
		$this->com_username->setDbValue($row['com_username']);
		$this->com_password->setDbValue($row['com_password']);
		$this->com_online->setDbValue($row['com_online']);
		$this->com_activation->setDbValue($row['com_activation']);
		$this->com_status->setDbValue($row['com_status']);
		$this->reg_date->setDbValue($row['reg_date']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['company_id'] = NULL;
		$row['com_fname'] = NULL;
		$row['com_lname'] = NULL;
		$row['com_name'] = NULL;
		$row['com_address'] = NULL;
		$row['com_phone'] = NULL;
		$row['com_email'] = NULL;
		$row['com_fb'] = NULL;
		$row['com_tw'] = NULL;
		$row['com_yt'] = NULL;
		$row['com_logo'] = NULL;
		$row['com_province'] = NULL;
		$row['com_username'] = NULL;
		$row['com_password'] = NULL;
		$row['com_online'] = NULL;
		$row['com_activation'] = NULL;
		$row['com_status'] = NULL;
		$row['reg_date'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->company_id->DbValue = $row['company_id'];
		$this->com_fname->DbValue = $row['com_fname'];
		$this->com_lname->DbValue = $row['com_lname'];
		$this->com_name->DbValue = $row['com_name'];
		$this->com_address->DbValue = $row['com_address'];
		$this->com_phone->DbValue = $row['com_phone'];
		$this->com_email->DbValue = $row['com_email'];
		$this->com_fb->DbValue = $row['com_fb'];
		$this->com_tw->DbValue = $row['com_tw'];
		$this->com_yt->DbValue = $row['com_yt'];
		$this->com_logo->DbValue = $row['com_logo'];
		$this->com_province->DbValue = $row['com_province'];
		$this->com_username->DbValue = $row['com_username'];
		$this->com_password->DbValue = $row['com_password'];
		$this->com_online->DbValue = $row['com_online'];
		$this->com_activation->DbValue = $row['com_activation'];
		$this->com_status->DbValue = $row['com_status'];
		$this->reg_date->DbValue = $row['reg_date'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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
		// com_province
		// com_username
		// com_password
		// com_online
		// com_activation
		// com_status
		// reg_date

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		$this->com_logo->ViewValue = $this->com_logo->CurrentValue;
		$this->com_logo->ViewCustomAttributes = "";

		// com_province
		$this->com_province->ViewValue = $this->com_province->CurrentValue;
		$this->com_province->ViewCustomAttributes = "";

		// com_username
		$this->com_username->ViewValue = $this->com_username->CurrentValue;
		$this->com_username->ViewCustomAttributes = "";

		// com_password
		$this->com_password->ViewValue = $this->com_password->CurrentValue;
		$this->com_password->ViewCustomAttributes = "";

		// com_online
		$this->com_online->ViewValue = $this->com_online->CurrentValue;
		$this->com_online->ViewCustomAttributes = "";

		// com_activation
		$this->com_activation->ViewValue = $this->com_activation->CurrentValue;
		$this->com_activation->ViewCustomAttributes = "";

		// com_status
		$this->com_status->ViewValue = $this->com_status->CurrentValue;
		$this->com_status->ViewCustomAttributes = "";

		// reg_date
		$this->reg_date->ViewValue = $this->reg_date->CurrentValue;
		$this->reg_date->ViewValue = ew_FormatDateTime($this->reg_date->ViewValue, 0);
		$this->reg_date->ViewCustomAttributes = "";

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

			// com_phone
			$this->com_phone->LinkCustomAttributes = "";
			$this->com_phone->HrefValue = "";
			$this->com_phone->TooltipValue = "";

			// com_email
			$this->com_email->LinkCustomAttributes = "";
			$this->com_email->HrefValue = "";
			$this->com_email->TooltipValue = "";

			// com_logo
			$this->com_logo->LinkCustomAttributes = "";
			$this->com_logo->HrefValue = "";
			$this->com_logo->TooltipValue = "";

			// com_province
			$this->com_province->LinkCustomAttributes = "";
			$this->com_province->HrefValue = "";
			$this->com_province->TooltipValue = "";

			// com_username
			$this->com_username->LinkCustomAttributes = "";
			$this->com_username->HrefValue = "";
			$this->com_username->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("companylist.php"), "", $this->TableVar, TRUE);
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
if (!isset($company_delete)) $company_delete = new ccompany_delete();

// Page init
$company_delete->Page_Init();

// Page main
$company_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$company_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fcompanydelete = new ew_Form("fcompanydelete", "delete");

// Form_CustomValidate event
fcompanydelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcompanydelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $company_delete->ShowPageHeader(); ?>
<?php
$company_delete->ShowMessage();
?>
<form name="fcompanydelete" id="fcompanydelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($company_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $company_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="company">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($company_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($company->company_id->Visible) { // company_id ?>
		<th class="<?php echo $company->company_id->HeaderCellClass() ?>"><span id="elh_company_company_id" class="company_company_id"><?php echo $company->company_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($company->com_fname->Visible) { // com_fname ?>
		<th class="<?php echo $company->com_fname->HeaderCellClass() ?>"><span id="elh_company_com_fname" class="company_com_fname"><?php echo $company->com_fname->FldCaption() ?></span></th>
<?php } ?>
<?php if ($company->com_lname->Visible) { // com_lname ?>
		<th class="<?php echo $company->com_lname->HeaderCellClass() ?>"><span id="elh_company_com_lname" class="company_com_lname"><?php echo $company->com_lname->FldCaption() ?></span></th>
<?php } ?>
<?php if ($company->com_name->Visible) { // com_name ?>
		<th class="<?php echo $company->com_name->HeaderCellClass() ?>"><span id="elh_company_com_name" class="company_com_name"><?php echo $company->com_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($company->com_phone->Visible) { // com_phone ?>
		<th class="<?php echo $company->com_phone->HeaderCellClass() ?>"><span id="elh_company_com_phone" class="company_com_phone"><?php echo $company->com_phone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($company->com_email->Visible) { // com_email ?>
		<th class="<?php echo $company->com_email->HeaderCellClass() ?>"><span id="elh_company_com_email" class="company_com_email"><?php echo $company->com_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($company->com_logo->Visible) { // com_logo ?>
		<th class="<?php echo $company->com_logo->HeaderCellClass() ?>"><span id="elh_company_com_logo" class="company_com_logo"><?php echo $company->com_logo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($company->com_province->Visible) { // com_province ?>
		<th class="<?php echo $company->com_province->HeaderCellClass() ?>"><span id="elh_company_com_province" class="company_com_province"><?php echo $company->com_province->FldCaption() ?></span></th>
<?php } ?>
<?php if ($company->com_username->Visible) { // com_username ?>
		<th class="<?php echo $company->com_username->HeaderCellClass() ?>"><span id="elh_company_com_username" class="company_com_username"><?php echo $company->com_username->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$company_delete->RecCnt = 0;
$i = 0;
while (!$company_delete->Recordset->EOF) {
	$company_delete->RecCnt++;
	$company_delete->RowCnt++;

	// Set row properties
	$company->ResetAttrs();
	$company->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$company_delete->LoadRowValues($company_delete->Recordset);

	// Render row
	$company_delete->RenderRow();
?>
	<tr<?php echo $company->RowAttributes() ?>>
<?php if ($company->company_id->Visible) { // company_id ?>
		<td<?php echo $company->company_id->CellAttributes() ?>>
<span id="el<?php echo $company_delete->RowCnt ?>_company_company_id" class="company_company_id">
<span<?php echo $company->company_id->ViewAttributes() ?>>
<?php echo $company->company_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($company->com_fname->Visible) { // com_fname ?>
		<td<?php echo $company->com_fname->CellAttributes() ?>>
<span id="el<?php echo $company_delete->RowCnt ?>_company_com_fname" class="company_com_fname">
<span<?php echo $company->com_fname->ViewAttributes() ?>>
<?php echo $company->com_fname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($company->com_lname->Visible) { // com_lname ?>
		<td<?php echo $company->com_lname->CellAttributes() ?>>
<span id="el<?php echo $company_delete->RowCnt ?>_company_com_lname" class="company_com_lname">
<span<?php echo $company->com_lname->ViewAttributes() ?>>
<?php echo $company->com_lname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($company->com_name->Visible) { // com_name ?>
		<td<?php echo $company->com_name->CellAttributes() ?>>
<span id="el<?php echo $company_delete->RowCnt ?>_company_com_name" class="company_com_name">
<span<?php echo $company->com_name->ViewAttributes() ?>>
<?php echo $company->com_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($company->com_phone->Visible) { // com_phone ?>
		<td<?php echo $company->com_phone->CellAttributes() ?>>
<span id="el<?php echo $company_delete->RowCnt ?>_company_com_phone" class="company_com_phone">
<span<?php echo $company->com_phone->ViewAttributes() ?>>
<?php echo $company->com_phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($company->com_email->Visible) { // com_email ?>
		<td<?php echo $company->com_email->CellAttributes() ?>>
<span id="el<?php echo $company_delete->RowCnt ?>_company_com_email" class="company_com_email">
<span<?php echo $company->com_email->ViewAttributes() ?>>
<?php echo $company->com_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($company->com_logo->Visible) { // com_logo ?>
		<td<?php echo $company->com_logo->CellAttributes() ?>>
<span id="el<?php echo $company_delete->RowCnt ?>_company_com_logo" class="company_com_logo">
<span<?php echo $company->com_logo->ViewAttributes() ?>>
<?php echo $company->com_logo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($company->com_province->Visible) { // com_province ?>
		<td<?php echo $company->com_province->CellAttributes() ?>>
<span id="el<?php echo $company_delete->RowCnt ?>_company_com_province" class="company_com_province">
<span<?php echo $company->com_province->ViewAttributes() ?>>
<?php echo $company->com_province->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($company->com_username->Visible) { // com_username ?>
		<td<?php echo $company->com_username->CellAttributes() ?>>
<span id="el<?php echo $company_delete->RowCnt ?>_company_com_username" class="company_com_username">
<span<?php echo $company->com_username->ViewAttributes() ?>>
<?php echo $company->com_username->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$company_delete->Recordset->MoveNext();
}
$company_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $company_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fcompanydelete.Init();
</script>
<?php
$company_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$company_delete->Page_Terminate();
?>

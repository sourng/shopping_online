<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tbl_pagesinfo.php" ?>
<?php include_once "companyinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tbl_pages_delete = NULL; // Initialize page object first

class ctbl_pages_delete extends ctbl_pages {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'tbl_pages';

	// Page object name
	var $PageObjName = 'tbl_pages_delete';

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

		// Table object (tbl_pages)
		if (!isset($GLOBALS["tbl_pages"]) || get_class($GLOBALS["tbl_pages"]) == "ctbl_pages") {
			$GLOBALS["tbl_pages"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_pages"];
		}

		// Table object (company)
		if (!isset($GLOBALS['company'])) $GLOBALS['company'] = new ccompany();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_pages', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("tbl_pageslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->page_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->page_id->Visible = FALSE;
		$this->page_name->SetVisibility();
		$this->page_title->SetVisibility();
		$this->page_url->SetVisibility();
		$this->page_description->SetVisibility();
		$this->page_icon->SetVisibility();
		$this->lang->SetVisibility();

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
		global $EW_EXPORT, $tbl_pages;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tbl_pages);
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
			$this->Page_Terminate("tbl_pageslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tbl_pages class, tbl_pagesinfo.php

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
				$this->Page_Terminate("tbl_pageslist.php"); // Return to list
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
		$this->page_id->setDbValue($row['page_id']);
		$this->page_name->setDbValue($row['page_name']);
		$this->page_title->setDbValue($row['page_title']);
		$this->page_url->setDbValue($row['page_url']);
		$this->page_description->setDbValue($row['page_description']);
		$this->page_detail->setDbValue($row['page_detail']);
		$this->page_icon->setDbValue($row['page_icon']);
		$this->lang->setDbValue($row['lang']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['page_id'] = NULL;
		$row['page_name'] = NULL;
		$row['page_title'] = NULL;
		$row['page_url'] = NULL;
		$row['page_description'] = NULL;
		$row['page_detail'] = NULL;
		$row['page_icon'] = NULL;
		$row['lang'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->page_id->DbValue = $row['page_id'];
		$this->page_name->DbValue = $row['page_name'];
		$this->page_title->DbValue = $row['page_title'];
		$this->page_url->DbValue = $row['page_url'];
		$this->page_description->DbValue = $row['page_description'];
		$this->page_detail->DbValue = $row['page_detail'];
		$this->page_icon->DbValue = $row['page_icon'];
		$this->lang->DbValue = $row['lang'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// page_id
		// page_name
		// page_title
		// page_url
		// page_description
		// page_detail
		// page_icon
		// lang

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// page_id
		$this->page_id->ViewValue = $this->page_id->CurrentValue;
		$this->page_id->ViewCustomAttributes = "";

		// page_name
		$this->page_name->ViewValue = $this->page_name->CurrentValue;
		$this->page_name->ViewCustomAttributes = "";

		// page_title
		$this->page_title->ViewValue = $this->page_title->CurrentValue;
		$this->page_title->ViewCustomAttributes = "";

		// page_url
		$this->page_url->ViewValue = $this->page_url->CurrentValue;
		$this->page_url->ViewCustomAttributes = "";

		// page_description
		$this->page_description->ViewValue = $this->page_description->CurrentValue;
		$this->page_description->ViewCustomAttributes = "";

		// page_icon
		$this->page_icon->ViewValue = $this->page_icon->CurrentValue;
		$this->page_icon->ViewCustomAttributes = "";

		// lang
		$this->lang->ViewValue = $this->lang->CurrentValue;
		$this->lang->ViewCustomAttributes = "";

			// page_id
			$this->page_id->LinkCustomAttributes = "";
			$this->page_id->HrefValue = "";
			$this->page_id->TooltipValue = "";

			// page_name
			$this->page_name->LinkCustomAttributes = "";
			$this->page_name->HrefValue = "";
			$this->page_name->TooltipValue = "";

			// page_title
			$this->page_title->LinkCustomAttributes = "";
			$this->page_title->HrefValue = "";
			$this->page_title->TooltipValue = "";

			// page_url
			$this->page_url->LinkCustomAttributes = "";
			$this->page_url->HrefValue = "";
			$this->page_url->TooltipValue = "";

			// page_description
			$this->page_description->LinkCustomAttributes = "";
			$this->page_description->HrefValue = "";
			$this->page_description->TooltipValue = "";

			// page_icon
			$this->page_icon->LinkCustomAttributes = "";
			$this->page_icon->HrefValue = "";
			$this->page_icon->TooltipValue = "";

			// lang
			$this->lang->LinkCustomAttributes = "";
			$this->lang->HrefValue = "";
			$this->lang->TooltipValue = "";
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
				$sThisKey .= $row['page_id'];

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tbl_pageslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($tbl_pages_delete)) $tbl_pages_delete = new ctbl_pages_delete();

// Page init
$tbl_pages_delete->Page_Init();

// Page main
$tbl_pages_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_pages_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ftbl_pagesdelete = new ew_Form("ftbl_pagesdelete", "delete");

// Form_CustomValidate event
ftbl_pagesdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftbl_pagesdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tbl_pages_delete->ShowPageHeader(); ?>
<?php
$tbl_pages_delete->ShowMessage();
?>
<form name="ftbl_pagesdelete" id="ftbl_pagesdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tbl_pages_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tbl_pages_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tbl_pages">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tbl_pages_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($tbl_pages->page_id->Visible) { // page_id ?>
		<th class="<?php echo $tbl_pages->page_id->HeaderCellClass() ?>"><span id="elh_tbl_pages_page_id" class="tbl_pages_page_id"><?php echo $tbl_pages->page_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tbl_pages->page_name->Visible) { // page_name ?>
		<th class="<?php echo $tbl_pages->page_name->HeaderCellClass() ?>"><span id="elh_tbl_pages_page_name" class="tbl_pages_page_name"><?php echo $tbl_pages->page_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tbl_pages->page_title->Visible) { // page_title ?>
		<th class="<?php echo $tbl_pages->page_title->HeaderCellClass() ?>"><span id="elh_tbl_pages_page_title" class="tbl_pages_page_title"><?php echo $tbl_pages->page_title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tbl_pages->page_url->Visible) { // page_url ?>
		<th class="<?php echo $tbl_pages->page_url->HeaderCellClass() ?>"><span id="elh_tbl_pages_page_url" class="tbl_pages_page_url"><?php echo $tbl_pages->page_url->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tbl_pages->page_description->Visible) { // page_description ?>
		<th class="<?php echo $tbl_pages->page_description->HeaderCellClass() ?>"><span id="elh_tbl_pages_page_description" class="tbl_pages_page_description"><?php echo $tbl_pages->page_description->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tbl_pages->page_icon->Visible) { // page_icon ?>
		<th class="<?php echo $tbl_pages->page_icon->HeaderCellClass() ?>"><span id="elh_tbl_pages_page_icon" class="tbl_pages_page_icon"><?php echo $tbl_pages->page_icon->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tbl_pages->lang->Visible) { // lang ?>
		<th class="<?php echo $tbl_pages->lang->HeaderCellClass() ?>"><span id="elh_tbl_pages_lang" class="tbl_pages_lang"><?php echo $tbl_pages->lang->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tbl_pages_delete->RecCnt = 0;
$i = 0;
while (!$tbl_pages_delete->Recordset->EOF) {
	$tbl_pages_delete->RecCnt++;
	$tbl_pages_delete->RowCnt++;

	// Set row properties
	$tbl_pages->ResetAttrs();
	$tbl_pages->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tbl_pages_delete->LoadRowValues($tbl_pages_delete->Recordset);

	// Render row
	$tbl_pages_delete->RenderRow();
?>
	<tr<?php echo $tbl_pages->RowAttributes() ?>>
<?php if ($tbl_pages->page_id->Visible) { // page_id ?>
		<td<?php echo $tbl_pages->page_id->CellAttributes() ?>>
<span id="el<?php echo $tbl_pages_delete->RowCnt ?>_tbl_pages_page_id" class="tbl_pages_page_id">
<span<?php echo $tbl_pages->page_id->ViewAttributes() ?>>
<?php echo $tbl_pages->page_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_pages->page_name->Visible) { // page_name ?>
		<td<?php echo $tbl_pages->page_name->CellAttributes() ?>>
<span id="el<?php echo $tbl_pages_delete->RowCnt ?>_tbl_pages_page_name" class="tbl_pages_page_name">
<span<?php echo $tbl_pages->page_name->ViewAttributes() ?>>
<?php echo $tbl_pages->page_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_pages->page_title->Visible) { // page_title ?>
		<td<?php echo $tbl_pages->page_title->CellAttributes() ?>>
<span id="el<?php echo $tbl_pages_delete->RowCnt ?>_tbl_pages_page_title" class="tbl_pages_page_title">
<span<?php echo $tbl_pages->page_title->ViewAttributes() ?>>
<?php echo $tbl_pages->page_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_pages->page_url->Visible) { // page_url ?>
		<td<?php echo $tbl_pages->page_url->CellAttributes() ?>>
<span id="el<?php echo $tbl_pages_delete->RowCnt ?>_tbl_pages_page_url" class="tbl_pages_page_url">
<span<?php echo $tbl_pages->page_url->ViewAttributes() ?>>
<?php echo $tbl_pages->page_url->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_pages->page_description->Visible) { // page_description ?>
		<td<?php echo $tbl_pages->page_description->CellAttributes() ?>>
<span id="el<?php echo $tbl_pages_delete->RowCnt ?>_tbl_pages_page_description" class="tbl_pages_page_description">
<span<?php echo $tbl_pages->page_description->ViewAttributes() ?>>
<?php echo $tbl_pages->page_description->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_pages->page_icon->Visible) { // page_icon ?>
		<td<?php echo $tbl_pages->page_icon->CellAttributes() ?>>
<span id="el<?php echo $tbl_pages_delete->RowCnt ?>_tbl_pages_page_icon" class="tbl_pages_page_icon">
<span<?php echo $tbl_pages->page_icon->ViewAttributes() ?>>
<?php echo $tbl_pages->page_icon->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_pages->lang->Visible) { // lang ?>
		<td<?php echo $tbl_pages->lang->CellAttributes() ?>>
<span id="el<?php echo $tbl_pages_delete->RowCnt ?>_tbl_pages_lang" class="tbl_pages_lang">
<span<?php echo $tbl_pages->lang->ViewAttributes() ?>>
<?php echo $tbl_pages->lang->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tbl_pages_delete->Recordset->MoveNext();
}
$tbl_pages_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tbl_pages_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ftbl_pagesdelete.Init();
</script>
<?php
$tbl_pages_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_pages_delete->Page_Terminate();
?>

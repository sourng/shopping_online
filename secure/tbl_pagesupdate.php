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

$tbl_pages_update = NULL; // Initialize page object first

class ctbl_pages_update extends ctbl_pages {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'tbl_pages';

	// Page object name
	var $PageObjName = 'tbl_pages_update';

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
			define("EW_PAGE_ID", 'update', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanEdit()) {
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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->page_name->SetVisibility();
		$this->page_title->SetVisibility();
		$this->page_url->SetVisibility();
		$this->page_description->SetVisibility();
		$this->page_detail->SetVisibility();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "tbl_pagesview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewUpdateForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $RecKeys;
	var $Disabled;
	var $Recordset;
	var $UpdateCount = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewUpdateForm form-horizontal";

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Try to load keys from list form
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		if (@$_POST["a_update"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_update"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {
			$this->LoadMultiUpdateValues(); // Load initial values to form
		}
		if (count($this->RecKeys) <= 0)
			$this->Page_Terminate("tbl_pageslist.php"); // No records selected, return to list
		switch ($this->CurrentAction) {
			case "U": // Update
				if ($this->UpdateRows()) { // Update Records based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values
				}
		}

		// Render row
		if ($this->CurrentAction == "F") { // Confirm page
			$this->RowType = EW_ROWTYPE_VIEW; // Render view
			$this->Disabled = " disabled";
		} else {
			$this->RowType = EW_ROWTYPE_EDIT; // Render edit
			$this->Disabled = "";
		}
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Load initial values to form if field values are identical in all selected records
	function LoadMultiUpdateValues() {
		$this->CurrentFilter = $this->GetKeyFilter();

		// Load recordset
		if ($this->Recordset = $this->LoadRecordset()) {
			$i = 1;
			while (!$this->Recordset->EOF) {
				if ($i == 1) {
					$this->page_name->setDbValue($this->Recordset->fields('page_name'));
					$this->page_title->setDbValue($this->Recordset->fields('page_title'));
					$this->page_url->setDbValue($this->Recordset->fields('page_url'));
					$this->page_description->setDbValue($this->Recordset->fields('page_description'));
					$this->page_detail->setDbValue($this->Recordset->fields('page_detail'));
					$this->page_icon->setDbValue($this->Recordset->fields('page_icon'));
					$this->lang->setDbValue($this->Recordset->fields('lang'));
				} else {
					if (!ew_CompareValue($this->page_name->DbValue, $this->Recordset->fields('page_name')))
						$this->page_name->CurrentValue = NULL;
					if (!ew_CompareValue($this->page_title->DbValue, $this->Recordset->fields('page_title')))
						$this->page_title->CurrentValue = NULL;
					if (!ew_CompareValue($this->page_url->DbValue, $this->Recordset->fields('page_url')))
						$this->page_url->CurrentValue = NULL;
					if (!ew_CompareValue($this->page_description->DbValue, $this->Recordset->fields('page_description')))
						$this->page_description->CurrentValue = NULL;
					if (!ew_CompareValue($this->page_detail->DbValue, $this->Recordset->fields('page_detail')))
						$this->page_detail->CurrentValue = NULL;
					if (!ew_CompareValue($this->page_icon->DbValue, $this->Recordset->fields('page_icon')))
						$this->page_icon->CurrentValue = NULL;
					if (!ew_CompareValue($this->lang->DbValue, $this->Recordset->fields('lang')))
						$this->lang->CurrentValue = NULL;
				}
				$i++;
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
		}
	}

	// Set up key value
	function SetupKeyValues($key) {
		$sKeyFld = $key;
		if (!is_numeric($sKeyFld))
			return FALSE;
		$this->page_id->CurrentValue = $sKeyFld;
		return TRUE;
	}

	// Update all selected rows
	function UpdateRows() {
		global $Language;
		$conn = &$this->Connection();
		$conn->BeginTrans();

		// Get old recordset
		$this->CurrentFilter = $this->GetKeyFilter();
		$sSql = $this->SQL();
		$rsold = $conn->Execute($sSql);

		// Update all rows
		$sKey = "";
		foreach ($this->RecKeys as $key) {
			if ($this->SetupKeyValues($key)) {
				$sThisKey = $key;
				$this->SendEmail = FALSE; // Do not send email on update success
				$this->UpdateCount += 1; // Update record count for records being updated
				$UpdateRows = $this->EditRow(); // Update this row
			} else {
				$UpdateRows = FALSE;
			}
			if (!$UpdateRows)
				break; // Update failed
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}

		// Check if all rows updated
		if ($UpdateRows) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$rsnew = $conn->Execute($sSql);
		} else {
			$conn->RollbackTrans(); // Rollback transaction
		}
		return $UpdateRows;
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->page_name->FldIsDetailKey) {
			$this->page_name->setFormValue($objForm->GetValue("x_page_name"));
		}
		$this->page_name->MultiUpdate = $objForm->GetValue("u_page_name");
		if (!$this->page_title->FldIsDetailKey) {
			$this->page_title->setFormValue($objForm->GetValue("x_page_title"));
		}
		$this->page_title->MultiUpdate = $objForm->GetValue("u_page_title");
		if (!$this->page_url->FldIsDetailKey) {
			$this->page_url->setFormValue($objForm->GetValue("x_page_url"));
		}
		$this->page_url->MultiUpdate = $objForm->GetValue("u_page_url");
		if (!$this->page_description->FldIsDetailKey) {
			$this->page_description->setFormValue($objForm->GetValue("x_page_description"));
		}
		$this->page_description->MultiUpdate = $objForm->GetValue("u_page_description");
		if (!$this->page_detail->FldIsDetailKey) {
			$this->page_detail->setFormValue($objForm->GetValue("x_page_detail"));
		}
		$this->page_detail->MultiUpdate = $objForm->GetValue("u_page_detail");
		if (!$this->page_icon->FldIsDetailKey) {
			$this->page_icon->setFormValue($objForm->GetValue("x_page_icon"));
		}
		$this->page_icon->MultiUpdate = $objForm->GetValue("u_page_icon");
		if (!$this->lang->FldIsDetailKey) {
			$this->lang->setFormValue($objForm->GetValue("x_lang"));
		}
		$this->lang->MultiUpdate = $objForm->GetValue("u_lang");
		if (!$this->page_id->FldIsDetailKey)
			$this->page_id->setFormValue($objForm->GetValue("x_page_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->page_id->CurrentValue = $this->page_id->FormValue;
		$this->page_name->CurrentValue = $this->page_name->FormValue;
		$this->page_title->CurrentValue = $this->page_title->FormValue;
		$this->page_url->CurrentValue = $this->page_url->FormValue;
		$this->page_description->CurrentValue = $this->page_description->FormValue;
		$this->page_detail->CurrentValue = $this->page_detail->FormValue;
		$this->page_icon->CurrentValue = $this->page_icon->FormValue;
		$this->lang->CurrentValue = $this->lang->FormValue;
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

		// page_detail
		$this->page_detail->ViewValue = $this->page_detail->CurrentValue;
		$this->page_detail->ViewCustomAttributes = "";

		// page_icon
		$this->page_icon->ViewValue = $this->page_icon->CurrentValue;
		$this->page_icon->ViewCustomAttributes = "";

		// lang
		$this->lang->ViewValue = $this->lang->CurrentValue;
		$this->lang->ViewCustomAttributes = "";

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

			// page_detail
			$this->page_detail->LinkCustomAttributes = "";
			$this->page_detail->HrefValue = "";
			$this->page_detail->TooltipValue = "";

			// page_icon
			$this->page_icon->LinkCustomAttributes = "";
			$this->page_icon->HrefValue = "";
			$this->page_icon->TooltipValue = "";

			// lang
			$this->lang->LinkCustomAttributes = "";
			$this->lang->HrefValue = "";
			$this->lang->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// page_name
			$this->page_name->EditAttrs["class"] = "form-control";
			$this->page_name->EditCustomAttributes = "";
			$this->page_name->EditValue = ew_HtmlEncode($this->page_name->CurrentValue);
			$this->page_name->PlaceHolder = ew_RemoveHtml($this->page_name->FldCaption());

			// page_title
			$this->page_title->EditAttrs["class"] = "form-control";
			$this->page_title->EditCustomAttributes = "";
			$this->page_title->EditValue = ew_HtmlEncode($this->page_title->CurrentValue);
			$this->page_title->PlaceHolder = ew_RemoveHtml($this->page_title->FldCaption());

			// page_url
			$this->page_url->EditAttrs["class"] = "form-control";
			$this->page_url->EditCustomAttributes = "";
			$this->page_url->EditValue = ew_HtmlEncode($this->page_url->CurrentValue);
			$this->page_url->PlaceHolder = ew_RemoveHtml($this->page_url->FldCaption());

			// page_description
			$this->page_description->EditAttrs["class"] = "form-control";
			$this->page_description->EditCustomAttributes = "";
			$this->page_description->EditValue = ew_HtmlEncode($this->page_description->CurrentValue);
			$this->page_description->PlaceHolder = ew_RemoveHtml($this->page_description->FldCaption());

			// page_detail
			$this->page_detail->EditAttrs["class"] = "form-control";
			$this->page_detail->EditCustomAttributes = "";
			$this->page_detail->EditValue = ew_HtmlEncode($this->page_detail->CurrentValue);
			$this->page_detail->PlaceHolder = ew_RemoveHtml($this->page_detail->FldCaption());

			// page_icon
			$this->page_icon->EditAttrs["class"] = "form-control";
			$this->page_icon->EditCustomAttributes = "";
			$this->page_icon->EditValue = ew_HtmlEncode($this->page_icon->CurrentValue);
			$this->page_icon->PlaceHolder = ew_RemoveHtml($this->page_icon->FldCaption());

			// lang
			$this->lang->EditAttrs["class"] = "form-control";
			$this->lang->EditCustomAttributes = "";
			$this->lang->EditValue = ew_HtmlEncode($this->lang->CurrentValue);
			$this->lang->PlaceHolder = ew_RemoveHtml($this->lang->FldCaption());

			// Edit refer script
			// page_name

			$this->page_name->LinkCustomAttributes = "";
			$this->page_name->HrefValue = "";

			// page_title
			$this->page_title->LinkCustomAttributes = "";
			$this->page_title->HrefValue = "";

			// page_url
			$this->page_url->LinkCustomAttributes = "";
			$this->page_url->HrefValue = "";

			// page_description
			$this->page_description->LinkCustomAttributes = "";
			$this->page_description->HrefValue = "";

			// page_detail
			$this->page_detail->LinkCustomAttributes = "";
			$this->page_detail->HrefValue = "";

			// page_icon
			$this->page_icon->LinkCustomAttributes = "";
			$this->page_icon->HrefValue = "";

			// lang
			$this->lang->LinkCustomAttributes = "";
			$this->lang->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";
		$lUpdateCnt = 0;
		if ($this->page_name->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->page_title->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->page_url->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->page_description->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->page_detail->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->page_icon->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->lang->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// page_name
			$this->page_name->SetDbValueDef($rsnew, $this->page_name->CurrentValue, NULL, $this->page_name->ReadOnly || $this->page_name->MultiUpdate <> "1");

			// page_title
			$this->page_title->SetDbValueDef($rsnew, $this->page_title->CurrentValue, NULL, $this->page_title->ReadOnly || $this->page_title->MultiUpdate <> "1");

			// page_url
			$this->page_url->SetDbValueDef($rsnew, $this->page_url->CurrentValue, NULL, $this->page_url->ReadOnly || $this->page_url->MultiUpdate <> "1");

			// page_description
			$this->page_description->SetDbValueDef($rsnew, $this->page_description->CurrentValue, NULL, $this->page_description->ReadOnly || $this->page_description->MultiUpdate <> "1");

			// page_detail
			$this->page_detail->SetDbValueDef($rsnew, $this->page_detail->CurrentValue, NULL, $this->page_detail->ReadOnly || $this->page_detail->MultiUpdate <> "1");

			// page_icon
			$this->page_icon->SetDbValueDef($rsnew, $this->page_icon->CurrentValue, NULL, $this->page_icon->ReadOnly || $this->page_icon->MultiUpdate <> "1");

			// lang
			$this->lang->SetDbValueDef($rsnew, $this->lang->CurrentValue, NULL, $this->lang->ReadOnly || $this->lang->MultiUpdate <> "1");

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tbl_pageslist.php"), "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_pages_update)) $tbl_pages_update = new ctbl_pages_update();

// Page init
$tbl_pages_update->Page_Init();

// Page main
$tbl_pages_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_pages_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = ftbl_pagesupdate = new ew_Form("ftbl_pagesupdate", "update");

// Validate form
ftbl_pagesupdate.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	if (!ew_UpdateSelected(fobj)) {
		ew_Alert(ewLanguage.Phrase("NoFieldSelected"));
		return false;
	}
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
ftbl_pagesupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftbl_pagesupdate.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tbl_pages_update->ShowPageHeader(); ?>
<?php
$tbl_pages_update->ShowMessage();
?>
<form name="ftbl_pagesupdate" id="ftbl_pagesupdate" class="<?php echo $tbl_pages_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tbl_pages_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tbl_pages_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tbl_pages">
<?php if ($tbl_pages->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_update" id="a_update" value="U">
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } else { ?>
<input type="hidden" name="a_update" id="a_update" value="F">
<?php } ?>
<input type="hidden" name="modal" value="<?php echo intval($tbl_pages_update->IsModal) ?>">
<?php foreach ($tbl_pages_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_tbl_pagesupdate" class="ewUpdateDiv"><!-- page -->
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"<?php echo $tbl_pages_update->Disabled ?>> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($tbl_pages->page_name->Visible) { // page_name ?>
	<div id="r_page_name" class="form-group">
		<label for="x_page_name" class="<?php echo $tbl_pages_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_page_name" id="u_page_name" class="ewMultiSelect" value="1"<?php echo ($tbl_pages->page_name->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($tbl_pages->page_name->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_page_name" id="u_page_name" value="<?php echo $tbl_pages->page_name->MultiUpdate ?>">
<?php } ?>
 <?php echo $tbl_pages->page_name->FldCaption() ?></label></div></label>
		<div class="<?php echo $tbl_pages_update->RightColumnClass ?>"><div<?php echo $tbl_pages->page_name->CellAttributes() ?>>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<span id="el_tbl_pages_page_name">
<input type="text" data-table="tbl_pages" data-field="x_page_name" name="x_page_name" id="x_page_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($tbl_pages->page_name->getPlaceHolder()) ?>" value="<?php echo $tbl_pages->page_name->EditValue ?>"<?php echo $tbl_pages->page_name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_tbl_pages_page_name">
<span<?php echo $tbl_pages->page_name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tbl_pages->page_name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tbl_pages" data-field="x_page_name" name="x_page_name" id="x_page_name" value="<?php echo ew_HtmlEncode($tbl_pages->page_name->FormValue) ?>">
<?php } ?>
<?php echo $tbl_pages->page_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_pages->page_title->Visible) { // page_title ?>
	<div id="r_page_title" class="form-group">
		<label for="x_page_title" class="<?php echo $tbl_pages_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_page_title" id="u_page_title" class="ewMultiSelect" value="1"<?php echo ($tbl_pages->page_title->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($tbl_pages->page_title->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_page_title" id="u_page_title" value="<?php echo $tbl_pages->page_title->MultiUpdate ?>">
<?php } ?>
 <?php echo $tbl_pages->page_title->FldCaption() ?></label></div></label>
		<div class="<?php echo $tbl_pages_update->RightColumnClass ?>"><div<?php echo $tbl_pages->page_title->CellAttributes() ?>>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<span id="el_tbl_pages_page_title">
<input type="text" data-table="tbl_pages" data-field="x_page_title" name="x_page_title" id="x_page_title" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($tbl_pages->page_title->getPlaceHolder()) ?>" value="<?php echo $tbl_pages->page_title->EditValue ?>"<?php echo $tbl_pages->page_title->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_tbl_pages_page_title">
<span<?php echo $tbl_pages->page_title->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tbl_pages->page_title->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tbl_pages" data-field="x_page_title" name="x_page_title" id="x_page_title" value="<?php echo ew_HtmlEncode($tbl_pages->page_title->FormValue) ?>">
<?php } ?>
<?php echo $tbl_pages->page_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_pages->page_url->Visible) { // page_url ?>
	<div id="r_page_url" class="form-group">
		<label for="x_page_url" class="<?php echo $tbl_pages_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_page_url" id="u_page_url" class="ewMultiSelect" value="1"<?php echo ($tbl_pages->page_url->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($tbl_pages->page_url->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_page_url" id="u_page_url" value="<?php echo $tbl_pages->page_url->MultiUpdate ?>">
<?php } ?>
 <?php echo $tbl_pages->page_url->FldCaption() ?></label></div></label>
		<div class="<?php echo $tbl_pages_update->RightColumnClass ?>"><div<?php echo $tbl_pages->page_url->CellAttributes() ?>>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<span id="el_tbl_pages_page_url">
<input type="text" data-table="tbl_pages" data-field="x_page_url" name="x_page_url" id="x_page_url" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($tbl_pages->page_url->getPlaceHolder()) ?>" value="<?php echo $tbl_pages->page_url->EditValue ?>"<?php echo $tbl_pages->page_url->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_tbl_pages_page_url">
<span<?php echo $tbl_pages->page_url->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tbl_pages->page_url->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tbl_pages" data-field="x_page_url" name="x_page_url" id="x_page_url" value="<?php echo ew_HtmlEncode($tbl_pages->page_url->FormValue) ?>">
<?php } ?>
<?php echo $tbl_pages->page_url->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_pages->page_description->Visible) { // page_description ?>
	<div id="r_page_description" class="form-group">
		<label for="x_page_description" class="<?php echo $tbl_pages_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_page_description" id="u_page_description" class="ewMultiSelect" value="1"<?php echo ($tbl_pages->page_description->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($tbl_pages->page_description->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_page_description" id="u_page_description" value="<?php echo $tbl_pages->page_description->MultiUpdate ?>">
<?php } ?>
 <?php echo $tbl_pages->page_description->FldCaption() ?></label></div></label>
		<div class="<?php echo $tbl_pages_update->RightColumnClass ?>"><div<?php echo $tbl_pages->page_description->CellAttributes() ?>>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<span id="el_tbl_pages_page_description">
<input type="text" data-table="tbl_pages" data-field="x_page_description" name="x_page_description" id="x_page_description" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($tbl_pages->page_description->getPlaceHolder()) ?>" value="<?php echo $tbl_pages->page_description->EditValue ?>"<?php echo $tbl_pages->page_description->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_tbl_pages_page_description">
<span<?php echo $tbl_pages->page_description->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tbl_pages->page_description->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tbl_pages" data-field="x_page_description" name="x_page_description" id="x_page_description" value="<?php echo ew_HtmlEncode($tbl_pages->page_description->FormValue) ?>">
<?php } ?>
<?php echo $tbl_pages->page_description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_pages->page_detail->Visible) { // page_detail ?>
	<div id="r_page_detail" class="form-group">
		<label for="x_page_detail" class="<?php echo $tbl_pages_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_page_detail" id="u_page_detail" class="ewMultiSelect" value="1"<?php echo ($tbl_pages->page_detail->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($tbl_pages->page_detail->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_page_detail" id="u_page_detail" value="<?php echo $tbl_pages->page_detail->MultiUpdate ?>">
<?php } ?>
 <?php echo $tbl_pages->page_detail->FldCaption() ?></label></div></label>
		<div class="<?php echo $tbl_pages_update->RightColumnClass ?>"><div<?php echo $tbl_pages->page_detail->CellAttributes() ?>>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<span id="el_tbl_pages_page_detail">
<textarea data-table="tbl_pages" data-field="x_page_detail" name="x_page_detail" id="x_page_detail" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($tbl_pages->page_detail->getPlaceHolder()) ?>"<?php echo $tbl_pages->page_detail->EditAttributes() ?>><?php echo $tbl_pages->page_detail->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el_tbl_pages_page_detail">
<span<?php echo $tbl_pages->page_detail->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tbl_pages->page_detail->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tbl_pages" data-field="x_page_detail" name="x_page_detail" id="x_page_detail" value="<?php echo ew_HtmlEncode($tbl_pages->page_detail->FormValue) ?>">
<?php } ?>
<?php echo $tbl_pages->page_detail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_pages->page_icon->Visible) { // page_icon ?>
	<div id="r_page_icon" class="form-group">
		<label for="x_page_icon" class="<?php echo $tbl_pages_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_page_icon" id="u_page_icon" class="ewMultiSelect" value="1"<?php echo ($tbl_pages->page_icon->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($tbl_pages->page_icon->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_page_icon" id="u_page_icon" value="<?php echo $tbl_pages->page_icon->MultiUpdate ?>">
<?php } ?>
 <?php echo $tbl_pages->page_icon->FldCaption() ?></label></div></label>
		<div class="<?php echo $tbl_pages_update->RightColumnClass ?>"><div<?php echo $tbl_pages->page_icon->CellAttributes() ?>>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<span id="el_tbl_pages_page_icon">
<input type="text" data-table="tbl_pages" data-field="x_page_icon" name="x_page_icon" id="x_page_icon" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($tbl_pages->page_icon->getPlaceHolder()) ?>" value="<?php echo $tbl_pages->page_icon->EditValue ?>"<?php echo $tbl_pages->page_icon->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_tbl_pages_page_icon">
<span<?php echo $tbl_pages->page_icon->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tbl_pages->page_icon->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tbl_pages" data-field="x_page_icon" name="x_page_icon" id="x_page_icon" value="<?php echo ew_HtmlEncode($tbl_pages->page_icon->FormValue) ?>">
<?php } ?>
<?php echo $tbl_pages->page_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tbl_pages->lang->Visible) { // lang ?>
	<div id="r_lang" class="form-group">
		<label for="x_lang" class="<?php echo $tbl_pages_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_lang" id="u_lang" class="ewMultiSelect" value="1"<?php echo ($tbl_pages->lang->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($tbl_pages->lang->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_lang" id="u_lang" value="<?php echo $tbl_pages->lang->MultiUpdate ?>">
<?php } ?>
 <?php echo $tbl_pages->lang->FldCaption() ?></label></div></label>
		<div class="<?php echo $tbl_pages_update->RightColumnClass ?>"><div<?php echo $tbl_pages->lang->CellAttributes() ?>>
<?php if ($tbl_pages->CurrentAction <> "F") { ?>
<span id="el_tbl_pages_lang">
<input type="text" data-table="tbl_pages" data-field="x_lang" name="x_lang" id="x_lang" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($tbl_pages->lang->getPlaceHolder()) ?>" value="<?php echo $tbl_pages->lang->EditValue ?>"<?php echo $tbl_pages->lang->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_tbl_pages_lang">
<span<?php echo $tbl_pages->lang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tbl_pages->lang->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tbl_pages" data-field="x_lang" name="x_lang" id="x_lang" value="<?php echo ew_HtmlEncode($tbl_pages->lang->FormValue) ?>">
<?php } ?>
<?php echo $tbl_pages->lang->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page -->
<?php if (!$tbl_pages_update->IsModal) { ?>
	<div class="form-group"><!-- buttons .form-group -->
		<div class="<?php echo $tbl_pages_update->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($tbl_pages->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_update.value='F';"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tbl_pages_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_update.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
		</div><!-- /buttons offset -->
	</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ftbl_pagesupdate.Init();
</script>
<?php
$tbl_pages_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_pages_update->Page_Terminate();
?>

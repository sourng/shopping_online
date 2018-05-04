<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "categoriesinfo.php" ?>
<?php include_once "companyinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$categories_addopt = NULL; // Initialize page object first

class ccategories_addopt extends ccategories {

	// Page ID
	var $PageID = 'addopt';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'categories';

	// Page object name
	var $PageObjName = 'categories_addopt';

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

		// Table object (categories)
		if (!isset($GLOBALS["categories"]) || get_class($GLOBALS["categories"]) == "ccategories") {
			$GLOBALS["categories"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["categories"];
		}

		// Table object (company)
		if (!isset($GLOBALS['company'])) $GLOBALS['company'] = new ccompany();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'addopt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'categories', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("categorieslist.php"));
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
		$this->cat_name->SetVisibility();
		$this->cat_ico_class->SetVisibility();
		$this->cat_ico_image->SetVisibility();
		$this->cat_home->SetVisibility();

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
		global $EW_EXPORT, $categories;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($categories);
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

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		set_error_handler("ew_ErrorHandler");

		// Set up Breadcrumb
		//$this->SetupBreadcrumb(); // Not used

		$this->LoadRowValues(); // Load default values

		// Process form if post back
		if ($objForm->GetValue("a_addopt") <> "") {
			$this->CurrentAction = $objForm->GetValue("a_addopt"); // Get form action
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back
			$this->CurrentAction = "I"; // Display blank record
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow()) { // Add successful
					$row = array();
					$row["x_cat_id"] = $this->cat_id->DbValue;
					$row["x_cat_name"] = ew_ConvertToUtf8($this->cat_name->DbValue);
					$row["x_cat_ico_class"] = ew_ConvertToUtf8($this->cat_ico_class->DbValue);
					$row["x_cat_ico_image"] = ew_ConvertToUtf8($this->cat_ico_image->DbValue);
					$row["x_cat_home"] = ew_ConvertToUtf8($this->cat_home->DbValue);
					if (!EW_DEBUG_ENABLED && ob_get_length())
						ob_end_clean();
					ew_Header(FALSE, "utf-8", TRUE);
					echo ew_ArrayToJson(array($row));
				} else {
					$this->ShowMessage();
				}
				$this->Page_Terminate();
				exit();
		}

		// Render row
		$this->RowType = EW_ROWTYPE_ADD; // Render add type
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->cat_id->CurrentValue = NULL;
		$this->cat_id->OldValue = $this->cat_id->CurrentValue;
		$this->cat_name->CurrentValue = NULL;
		$this->cat_name->OldValue = $this->cat_name->CurrentValue;
		$this->cat_ico_class->CurrentValue = NULL;
		$this->cat_ico_class->OldValue = $this->cat_ico_class->CurrentValue;
		$this->cat_ico_image->CurrentValue = NULL;
		$this->cat_ico_image->OldValue = $this->cat_ico_image->CurrentValue;
		$this->cat_home->CurrentValue = NULL;
		$this->cat_home->OldValue = $this->cat_home->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->cat_name->FldIsDetailKey) {
			$this->cat_name->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_cat_name")));
		}
		if (!$this->cat_ico_class->FldIsDetailKey) {
			$this->cat_ico_class->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_cat_ico_class")));
		}
		if (!$this->cat_ico_image->FldIsDetailKey) {
			$this->cat_ico_image->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_cat_ico_image")));
		}
		if (!$this->cat_home->FldIsDetailKey) {
			$this->cat_home->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_cat_home")));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->cat_name->CurrentValue = ew_ConvertToUtf8($this->cat_name->FormValue);
		$this->cat_ico_class->CurrentValue = ew_ConvertToUtf8($this->cat_ico_class->FormValue);
		$this->cat_ico_image->CurrentValue = ew_ConvertToUtf8($this->cat_ico_image->FormValue);
		$this->cat_home->CurrentValue = ew_ConvertToUtf8($this->cat_home->FormValue);
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
		$this->cat_id->setDbValue($row['cat_id']);
		$this->cat_name->setDbValue($row['cat_name']);
		$this->cat_ico_class->setDbValue($row['cat_ico_class']);
		$this->cat_ico_image->setDbValue($row['cat_ico_image']);
		$this->cat_home->setDbValue($row['cat_home']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['cat_id'] = $this->cat_id->CurrentValue;
		$row['cat_name'] = $this->cat_name->CurrentValue;
		$row['cat_ico_class'] = $this->cat_ico_class->CurrentValue;
		$row['cat_ico_image'] = $this->cat_ico_image->CurrentValue;
		$row['cat_home'] = $this->cat_home->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->cat_id->DbValue = $row['cat_id'];
		$this->cat_name->DbValue = $row['cat_name'];
		$this->cat_ico_class->DbValue = $row['cat_ico_class'];
		$this->cat_ico_image->DbValue = $row['cat_ico_image'];
		$this->cat_home->DbValue = $row['cat_home'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// cat_id
		// cat_name
		// cat_ico_class
		// cat_ico_image
		// cat_home

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// cat_id
		$this->cat_id->ViewValue = $this->cat_id->CurrentValue;
		$this->cat_id->ViewCustomAttributes = "";

		// cat_name
		$this->cat_name->ViewValue = $this->cat_name->CurrentValue;
		$this->cat_name->ViewCustomAttributes = "";

		// cat_ico_class
		$this->cat_ico_class->ViewValue = $this->cat_ico_class->CurrentValue;
		$this->cat_ico_class->ViewCustomAttributes = "";

		// cat_ico_image
		$this->cat_ico_image->ViewValue = $this->cat_ico_image->CurrentValue;
		$this->cat_ico_image->ViewCustomAttributes = "";

		// cat_home
		if (ew_ConvertToBool($this->cat_home->CurrentValue)) {
			$this->cat_home->ViewValue = $this->cat_home->FldTagCaption(1) <> "" ? $this->cat_home->FldTagCaption(1) : "Y";
		} else {
			$this->cat_home->ViewValue = $this->cat_home->FldTagCaption(2) <> "" ? $this->cat_home->FldTagCaption(2) : "N";
		}
		$this->cat_home->ViewCustomAttributes = "";

			// cat_name
			$this->cat_name->LinkCustomAttributes = "";
			$this->cat_name->HrefValue = "";
			$this->cat_name->TooltipValue = "";

			// cat_ico_class
			$this->cat_ico_class->LinkCustomAttributes = "";
			$this->cat_ico_class->HrefValue = "";
			$this->cat_ico_class->TooltipValue = "";

			// cat_ico_image
			$this->cat_ico_image->LinkCustomAttributes = "";
			$this->cat_ico_image->HrefValue = "";
			$this->cat_ico_image->TooltipValue = "";

			// cat_home
			$this->cat_home->LinkCustomAttributes = "";
			$this->cat_home->HrefValue = "";
			$this->cat_home->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// cat_name
			$this->cat_name->EditAttrs["class"] = "form-control";
			$this->cat_name->EditCustomAttributes = "";
			$this->cat_name->EditValue = ew_HtmlEncode($this->cat_name->CurrentValue);
			$this->cat_name->PlaceHolder = ew_RemoveHtml($this->cat_name->FldCaption());

			// cat_ico_class
			$this->cat_ico_class->EditAttrs["class"] = "form-control";
			$this->cat_ico_class->EditCustomAttributes = "";
			$this->cat_ico_class->EditValue = ew_HtmlEncode($this->cat_ico_class->CurrentValue);
			$this->cat_ico_class->PlaceHolder = ew_RemoveHtml($this->cat_ico_class->FldCaption());

			// cat_ico_image
			$this->cat_ico_image->EditAttrs["class"] = "form-control";
			$this->cat_ico_image->EditCustomAttributes = "";
			$this->cat_ico_image->EditValue = ew_HtmlEncode($this->cat_ico_image->CurrentValue);
			$this->cat_ico_image->PlaceHolder = ew_RemoveHtml($this->cat_ico_image->FldCaption());

			// cat_home
			$this->cat_home->EditCustomAttributes = "";
			$this->cat_home->EditValue = $this->cat_home->Options(FALSE);

			// Add refer script
			// cat_name

			$this->cat_name->LinkCustomAttributes = "";
			$this->cat_name->HrefValue = "";

			// cat_ico_class
			$this->cat_ico_class->LinkCustomAttributes = "";
			$this->cat_ico_class->HrefValue = "";

			// cat_ico_image
			$this->cat_ico_image->LinkCustomAttributes = "";
			$this->cat_ico_image->HrefValue = "";

			// cat_home
			$this->cat_home->LinkCustomAttributes = "";
			$this->cat_home->HrefValue = "";
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// cat_name
		$this->cat_name->SetDbValueDef($rsnew, $this->cat_name->CurrentValue, NULL, FALSE);

		// cat_ico_class
		$this->cat_ico_class->SetDbValueDef($rsnew, $this->cat_ico_class->CurrentValue, NULL, FALSE);

		// cat_ico_image
		$this->cat_ico_image->SetDbValueDef($rsnew, $this->cat_ico_image->CurrentValue, NULL, FALSE);

		// cat_home
		$tmpBool = $this->cat_home->CurrentValue;
		if ($tmpBool <> "Y" && $tmpBool <> "N")
			$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
		$this->cat_home->SetDbValueDef($rsnew, $tmpBool, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("categorieslist.php"), "", $this->TableVar, TRUE);
		$PageId = "addopt";
		$Breadcrumb->Add("addopt", $PageId, $url);
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

	// Custom validate event
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
if (!isset($categories_addopt)) $categories_addopt = new ccategories_addopt();

// Page init
$categories_addopt->Page_Init();

// Page main
$categories_addopt->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$categories_addopt->Page_Render();
?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "addopt";
var CurrentForm = fcategoriesaddopt = new ew_Form("fcategoriesaddopt", "addopt");

// Validate form
fcategoriesaddopt.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
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
fcategoriesaddopt.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcategoriesaddopt.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcategoriesaddopt.Lists["x_cat_home[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcategoriesaddopt.Lists["x_cat_home[]"].Options = <?php echo json_encode($categories_addopt->cat_home->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php
$categories_addopt->ShowMessage();
?>
<form name="fcategoriesaddopt" id="fcategoriesaddopt" class="ewForm form-horizontal" action="categoriesaddopt.php" method="post">
<?php if ($categories_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $categories_addopt->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="categories">
<input type="hidden" name="a_addopt" id="a_addopt" value="A">
<?php if ($categories->cat_name->Visible) { // cat_name ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_cat_name"><?php echo $categories->cat_name->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="categories" data-field="x_cat_name" name="x_cat_name" id="x_cat_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($categories->cat_name->getPlaceHolder()) ?>" value="<?php echo $categories->cat_name->EditValue ?>"<?php echo $categories->cat_name->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($categories->cat_ico_class->Visible) { // cat_ico_class ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_cat_ico_class"><?php echo $categories->cat_ico_class->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="categories" data-field="x_cat_ico_class" name="x_cat_ico_class" id="x_cat_ico_class" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($categories->cat_ico_class->getPlaceHolder()) ?>" value="<?php echo $categories->cat_ico_class->EditValue ?>"<?php echo $categories->cat_ico_class->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($categories->cat_ico_image->Visible) { // cat_ico_image ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_cat_ico_image"><?php echo $categories->cat_ico_image->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="categories" data-field="x_cat_ico_image" name="x_cat_ico_image" id="x_cat_ico_image" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($categories->cat_ico_image->getPlaceHolder()) ?>" value="<?php echo $categories->cat_ico_image->EditValue ?>"<?php echo $categories->cat_ico_image->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($categories->cat_home->Visible) { // cat_home ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel"><?php echo $categories->cat_home->FldCaption() ?></label>
		<div class="col-sm-10">
<?php
$selwrk = (ew_ConvertToBool($categories->cat_home->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="categories" data-field="x_cat_home" name="x_cat_home[]" id="x_cat_home[]" value="1"<?php echo $selwrk ?><?php echo $categories->cat_home->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
</form>
<script type="text/javascript">
fcategoriesaddopt.Init();
</script>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$categories_addopt->Page_Terminate();
?>

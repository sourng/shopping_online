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

$categories_update = NULL; // Initialize page object first

class ccategories_update extends ccategories {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'categories';

	// Page object name
	var $PageObjName = 'categories_update';

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
			define("EW_PAGE_ID", 'update', TRUE);

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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "categoriesview.php")
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
			$this->Page_Terminate("categorieslist.php"); // No records selected, return to list
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
					$this->cat_name->setDbValue($this->Recordset->fields('cat_name'));
					$this->cat_ico_class->setDbValue($this->Recordset->fields('cat_ico_class'));
					$this->cat_home->setDbValue($this->Recordset->fields('cat_home'));
				} else {
					if (!ew_CompareValue($this->cat_name->DbValue, $this->Recordset->fields('cat_name')))
						$this->cat_name->CurrentValue = NULL;
					if (!ew_CompareValue($this->cat_ico_class->DbValue, $this->Recordset->fields('cat_ico_class')))
						$this->cat_ico_class->CurrentValue = NULL;
					if (!ew_CompareValue($this->cat_home->DbValue, $this->Recordset->fields('cat_home')))
						$this->cat_home->CurrentValue = NULL;
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
		$this->cat_id->CurrentValue = $sKeyFld;
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
		$this->cat_ico_image->Upload->Index = $objForm->Index;
		$this->cat_ico_image->Upload->UploadFile();
		$this->cat_ico_image->CurrentValue = $this->cat_ico_image->Upload->FileName;
		$this->cat_ico_image->MultiUpdate = $objForm->GetValue("u_cat_ico_image");
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->cat_name->FldIsDetailKey) {
			$this->cat_name->setFormValue($objForm->GetValue("x_cat_name"));
		}
		$this->cat_name->MultiUpdate = $objForm->GetValue("u_cat_name");
		if (!$this->cat_ico_class->FldIsDetailKey) {
			$this->cat_ico_class->setFormValue($objForm->GetValue("x_cat_ico_class"));
		}
		$this->cat_ico_class->MultiUpdate = $objForm->GetValue("u_cat_ico_class");
		if (!$this->cat_home->FldIsDetailKey) {
			$this->cat_home->setFormValue($objForm->GetValue("x_cat_home"));
		}
		$this->cat_home->MultiUpdate = $objForm->GetValue("u_cat_home");
		if (!$this->cat_id->FldIsDetailKey)
			$this->cat_id->setFormValue($objForm->GetValue("x_cat_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->cat_id->CurrentValue = $this->cat_id->FormValue;
		$this->cat_name->CurrentValue = $this->cat_name->FormValue;
		$this->cat_ico_class->CurrentValue = $this->cat_ico_class->FormValue;
		$this->cat_home->CurrentValue = $this->cat_home->FormValue;
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
		$this->cat_id->setDbValue($row['cat_id']);
		$this->cat_name->setDbValue($row['cat_name']);
		$this->cat_ico_class->setDbValue($row['cat_ico_class']);
		$this->cat_ico_image->Upload->DbValue = $row['cat_ico_image'];
		$this->cat_ico_image->setDbValue($this->cat_ico_image->Upload->DbValue);
		$this->cat_home->setDbValue($row['cat_home']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['cat_id'] = NULL;
		$row['cat_name'] = NULL;
		$row['cat_ico_class'] = NULL;
		$row['cat_ico_image'] = NULL;
		$row['cat_home'] = NULL;
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
		$this->cat_ico_image->Upload->DbValue = $row['cat_ico_image'];
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
		$this->cat_ico_image->UploadPath = "../uploads/category/icons";
		if (!ew_Empty($this->cat_ico_image->Upload->DbValue)) {
			$this->cat_ico_image->ImageAlt = $this->cat_ico_image->FldAlt();
			$this->cat_ico_image->ViewValue = $this->cat_ico_image->Upload->DbValue;
		} else {
			$this->cat_ico_image->ViewValue = "";
		}
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
			$this->cat_ico_image->UploadPath = "../uploads/category/icons";
			if (!ew_Empty($this->cat_ico_image->Upload->DbValue)) {
				$this->cat_ico_image->HrefValue = ew_GetFileUploadUrl($this->cat_ico_image, $this->cat_ico_image->Upload->DbValue); // Add prefix/suffix
				$this->cat_ico_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->cat_ico_image->HrefValue = ew_FullUrl($this->cat_ico_image->HrefValue, "href");
			} else {
				$this->cat_ico_image->HrefValue = "";
			}
			$this->cat_ico_image->HrefValue2 = $this->cat_ico_image->UploadPath . $this->cat_ico_image->Upload->DbValue;
			$this->cat_ico_image->TooltipValue = "";
			if ($this->cat_ico_image->UseColorbox) {
				if (ew_Empty($this->cat_ico_image->TooltipValue))
					$this->cat_ico_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->cat_ico_image->LinkAttrs["data-rel"] = "categories_x_cat_ico_image";
				ew_AppendClass($this->cat_ico_image->LinkAttrs["class"], "ewLightbox");
			}

			// cat_home
			$this->cat_home->LinkCustomAttributes = "";
			$this->cat_home->HrefValue = "";
			$this->cat_home->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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
			$this->cat_ico_image->UploadPath = "../uploads/category/icons";
			if (!ew_Empty($this->cat_ico_image->Upload->DbValue)) {
				$this->cat_ico_image->ImageAlt = $this->cat_ico_image->FldAlt();
				$this->cat_ico_image->EditValue = $this->cat_ico_image->Upload->DbValue;
			} else {
				$this->cat_ico_image->EditValue = "";
			}
			if (!ew_Empty($this->cat_ico_image->CurrentValue))
					$this->cat_ico_image->Upload->FileName = $this->cat_ico_image->CurrentValue;

			// cat_home
			$this->cat_home->EditCustomAttributes = "";
			$this->cat_home->EditValue = $this->cat_home->Options(FALSE);

			// Edit refer script
			// cat_name

			$this->cat_name->LinkCustomAttributes = "";
			$this->cat_name->HrefValue = "";

			// cat_ico_class
			$this->cat_ico_class->LinkCustomAttributes = "";
			$this->cat_ico_class->HrefValue = "";

			// cat_ico_image
			$this->cat_ico_image->LinkCustomAttributes = "";
			$this->cat_ico_image->UploadPath = "../uploads/category/icons";
			if (!ew_Empty($this->cat_ico_image->Upload->DbValue)) {
				$this->cat_ico_image->HrefValue = ew_GetFileUploadUrl($this->cat_ico_image, $this->cat_ico_image->Upload->DbValue); // Add prefix/suffix
				$this->cat_ico_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->cat_ico_image->HrefValue = ew_FullUrl($this->cat_ico_image->HrefValue, "href");
			} else {
				$this->cat_ico_image->HrefValue = "";
			}
			$this->cat_ico_image->HrefValue2 = $this->cat_ico_image->UploadPath . $this->cat_ico_image->Upload->DbValue;

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
		$lUpdateCnt = 0;
		if ($this->cat_name->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->cat_ico_class->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->cat_ico_image->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->cat_home->MultiUpdate == "1") $lUpdateCnt++;
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
			$this->cat_ico_image->OldUploadPath = "../uploads/category/icons";
			$this->cat_ico_image->UploadPath = $this->cat_ico_image->OldUploadPath;
			$rsnew = array();

			// cat_name
			$this->cat_name->SetDbValueDef($rsnew, $this->cat_name->CurrentValue, NULL, $this->cat_name->ReadOnly || $this->cat_name->MultiUpdate <> "1");

			// cat_ico_class
			$this->cat_ico_class->SetDbValueDef($rsnew, $this->cat_ico_class->CurrentValue, NULL, $this->cat_ico_class->ReadOnly || $this->cat_ico_class->MultiUpdate <> "1");

			// cat_ico_image
			if ($this->cat_ico_image->Visible && !$this->cat_ico_image->ReadOnly && strval($this->cat_ico_image->MultiUpdate) == "1" && !$this->cat_ico_image->Upload->KeepFile) {
				$this->cat_ico_image->Upload->DbValue = $rsold['cat_ico_image']; // Get original value
				if ($this->cat_ico_image->Upload->FileName == "") {
					$rsnew['cat_ico_image'] = NULL;
				} else {
					$rsnew['cat_ico_image'] = $this->cat_ico_image->Upload->FileName;
				}
			}

			// cat_home
			$tmpBool = $this->cat_home->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->cat_home->SetDbValueDef($rsnew, $tmpBool, NULL, $this->cat_home->ReadOnly || $this->cat_home->MultiUpdate <> "1");
			if ($this->cat_ico_image->Visible && !$this->cat_ico_image->Upload->KeepFile) {
				$this->cat_ico_image->UploadPath = "../uploads/category/icons";
				$OldFiles = ew_Empty($this->cat_ico_image->Upload->DbValue) ? array() : array($this->cat_ico_image->Upload->DbValue);
				if (!ew_Empty($this->cat_ico_image->Upload->FileName) && $this->UpdateCount == 1) {
					$NewFiles = array($this->cat_ico_image->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->cat_ico_image->Upload->Index < 0) ? $this->cat_ico_image->FldVar : substr($this->cat_ico_image->FldVar, 0, 1) . $this->cat_ico_image->Upload->Index . substr($this->cat_ico_image->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->cat_ico_image->TblVar) . $file)) {
								$OldFileFound = FALSE;
								$OldFileCount = count($OldFiles);
								for ($j = 0; $j < $OldFileCount; $j++) {
									$file1 = $OldFiles[$j];
									if ($file1 == $file) { // Old file found, no need to delete anymore
										unset($OldFiles[$j]);
										$OldFileFound = TRUE;
										break;
									}
								}
								if ($OldFileFound) // No need to check if file exists further
									continue;
								$file1 = ew_UploadFileNameEx($this->cat_ico_image->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->cat_ico_image->TblVar) . $file1) || file_exists($this->cat_ico_image->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->cat_ico_image->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->cat_ico_image->TblVar) . $file, ew_UploadTempPath($fldvar, $this->cat_ico_image->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->cat_ico_image->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->cat_ico_image->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->cat_ico_image->SetDbValueDef($rsnew, $this->cat_ico_image->Upload->FileName, NULL, $this->cat_ico_image->ReadOnly || $this->cat_ico_image->MultiUpdate <> "1");
				}
			}

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
					if ($this->cat_ico_image->Visible && !$this->cat_ico_image->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->cat_ico_image->Upload->DbValue) ? array() : array($this->cat_ico_image->Upload->DbValue);
						if (!ew_Empty($this->cat_ico_image->Upload->FileName) && $this->UpdateCount == 1) {
							$NewFiles = array($this->cat_ico_image->Upload->FileName);
							$NewFiles2 = array($rsnew['cat_ico_image']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->cat_ico_image->Upload->Index < 0) ? $this->cat_ico_image->FldVar : substr($this->cat_ico_image->FldVar, 0, 1) . $this->cat_ico_image->Upload->Index . substr($this->cat_ico_image->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->cat_ico_image->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->cat_ico_image->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
											$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
											return FALSE;
										}
									}
								}
							}
						} else {
							$NewFiles = array();
						}
						$OldFileCount = count($OldFiles);
						for ($i = 0; $i < $OldFileCount; $i++) {
							if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
								@unlink($this->cat_ico_image->OldPhysicalUploadPath() . $OldFiles[$i]);
						}
					}
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

		// cat_ico_image
		ew_CleanUploadTempPath($this->cat_ico_image, $this->cat_ico_image->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("categorieslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($categories_update)) $categories_update = new ccategories_update();

// Page init
$categories_update->Page_Init();

// Page main
$categories_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$categories_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = fcategoriesupdate = new ew_Form("fcategoriesupdate", "update");

// Validate form
fcategoriesupdate.Validate = function() {
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
fcategoriesupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcategoriesupdate.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcategoriesupdate.Lists["x_cat_home[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcategoriesupdate.Lists["x_cat_home[]"].Options = <?php echo json_encode($categories_update->cat_home->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $categories_update->ShowPageHeader(); ?>
<?php
$categories_update->ShowMessage();
?>
<form name="fcategoriesupdate" id="fcategoriesupdate" class="<?php echo $categories_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($categories_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $categories_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="categories">
<?php if ($categories->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_update" id="a_update" value="U">
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } else { ?>
<input type="hidden" name="a_update" id="a_update" value="F">
<?php } ?>
<input type="hidden" name="modal" value="<?php echo intval($categories_update->IsModal) ?>">
<?php foreach ($categories_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_categoriesupdate" class="ewUpdateDiv"><!-- page -->
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"<?php echo $categories_update->Disabled ?>> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($categories->cat_name->Visible) { // cat_name ?>
	<div id="r_cat_name" class="form-group">
		<label for="x_cat_name" class="<?php echo $categories_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($categories->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_cat_name" id="u_cat_name" class="ewMultiSelect" value="1"<?php echo ($categories->cat_name->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($categories->cat_name->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_cat_name" id="u_cat_name" value="<?php echo $categories->cat_name->MultiUpdate ?>">
<?php } ?>
 <?php echo $categories->cat_name->FldCaption() ?></label></div></label>
		<div class="<?php echo $categories_update->RightColumnClass ?>"><div<?php echo $categories->cat_name->CellAttributes() ?>>
<?php if ($categories->CurrentAction <> "F") { ?>
<span id="el_categories_cat_name">
<input type="text" data-table="categories" data-field="x_cat_name" name="x_cat_name" id="x_cat_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($categories->cat_name->getPlaceHolder()) ?>" value="<?php echo $categories->cat_name->EditValue ?>"<?php echo $categories->cat_name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_categories_cat_name">
<span<?php echo $categories->cat_name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $categories->cat_name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="categories" data-field="x_cat_name" name="x_cat_name" id="x_cat_name" value="<?php echo ew_HtmlEncode($categories->cat_name->FormValue) ?>">
<?php } ?>
<?php echo $categories->cat_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($categories->cat_ico_class->Visible) { // cat_ico_class ?>
	<div id="r_cat_ico_class" class="form-group">
		<label for="x_cat_ico_class" class="<?php echo $categories_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($categories->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_cat_ico_class" id="u_cat_ico_class" class="ewMultiSelect" value="1"<?php echo ($categories->cat_ico_class->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($categories->cat_ico_class->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_cat_ico_class" id="u_cat_ico_class" value="<?php echo $categories->cat_ico_class->MultiUpdate ?>">
<?php } ?>
 <?php echo $categories->cat_ico_class->FldCaption() ?></label></div></label>
		<div class="<?php echo $categories_update->RightColumnClass ?>"><div<?php echo $categories->cat_ico_class->CellAttributes() ?>>
<?php if ($categories->CurrentAction <> "F") { ?>
<span id="el_categories_cat_ico_class">
<input type="text" data-table="categories" data-field="x_cat_ico_class" name="x_cat_ico_class" id="x_cat_ico_class" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($categories->cat_ico_class->getPlaceHolder()) ?>" value="<?php echo $categories->cat_ico_class->EditValue ?>"<?php echo $categories->cat_ico_class->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_categories_cat_ico_class">
<span<?php echo $categories->cat_ico_class->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $categories->cat_ico_class->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="categories" data-field="x_cat_ico_class" name="x_cat_ico_class" id="x_cat_ico_class" value="<?php echo ew_HtmlEncode($categories->cat_ico_class->FormValue) ?>">
<?php } ?>
<?php echo $categories->cat_ico_class->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($categories->cat_ico_image->Visible) { // cat_ico_image ?>
	<div id="r_cat_ico_image" class="form-group">
		<label class="<?php echo $categories_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($categories->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_cat_ico_image" id="u_cat_ico_image" class="ewMultiSelect" value="1"<?php echo ($categories->cat_ico_image->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($categories->cat_ico_image->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_cat_ico_image" id="u_cat_ico_image" value="<?php echo $categories->cat_ico_image->MultiUpdate ?>">
<?php } ?>
 <?php echo $categories->cat_ico_image->FldCaption() ?></label></div></label>
		<div class="<?php echo $categories_update->RightColumnClass ?>"><div<?php echo $categories->cat_ico_image->CellAttributes() ?>>
<span id="el_categories_cat_ico_image">
<div id="fd_x_cat_ico_image">
<span title="<?php echo $categories->cat_ico_image->FldTitle() ? $categories->cat_ico_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($categories->cat_ico_image->ReadOnly || $categories->cat_ico_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="categories" data-field="x_cat_ico_image" name="x_cat_ico_image" id="x_cat_ico_image"<?php echo $categories->cat_ico_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_cat_ico_image" id= "fn_x_cat_ico_image" value="<?php echo $categories->cat_ico_image->Upload->FileName ?>">
<?php if (@$_POST["fa_x_cat_ico_image"] == "0") { ?>
<input type="hidden" name="fa_x_cat_ico_image" id= "fa_x_cat_ico_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_cat_ico_image" id= "fa_x_cat_ico_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x_cat_ico_image" id= "fs_x_cat_ico_image" value="250">
<input type="hidden" name="fx_x_cat_ico_image" id= "fx_x_cat_ico_image" value="<?php echo $categories->cat_ico_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_cat_ico_image" id= "fm_x_cat_ico_image" value="<?php echo $categories->cat_ico_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_cat_ico_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $categories->cat_ico_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($categories->cat_home->Visible) { // cat_home ?>
	<div id="r_cat_home" class="form-group">
		<label class="<?php echo $categories_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($categories->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_cat_home" id="u_cat_home" class="ewMultiSelect" value="1"<?php echo ($categories->cat_home->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($categories->cat_home->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_cat_home" id="u_cat_home" value="<?php echo $categories->cat_home->MultiUpdate ?>">
<?php } ?>
 <?php echo $categories->cat_home->FldCaption() ?></label></div></label>
		<div class="<?php echo $categories_update->RightColumnClass ?>"><div<?php echo $categories->cat_home->CellAttributes() ?>>
<?php if ($categories->CurrentAction <> "F") { ?>
<span id="el_categories_cat_home">
<?php
$selwrk = (ew_ConvertToBool($categories->cat_home->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="categories" data-field="x_cat_home" name="x_cat_home[]" id="x_cat_home[]" value="1"<?php echo $selwrk ?><?php echo $categories->cat_home->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_categories_cat_home">
<span<?php echo $categories->cat_home->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($categories->cat_home->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $categories->cat_home->ViewValue ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $categories->cat_home->ViewValue ?>" disabled>
<?php } ?>
</span>
</span>
<input type="hidden" data-table="categories" data-field="x_cat_home" name="x_cat_home" id="x_cat_home" value="<?php echo ew_HtmlEncode($categories->cat_home->FormValue) ?>">
<?php } ?>
<?php echo $categories->cat_home->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page -->
<?php if (!$categories_update->IsModal) { ?>
	<div class="form-group"><!-- buttons .form-group -->
		<div class="<?php echo $categories_update->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($categories->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_update.value='F';"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $categories_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_update.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
		</div><!-- /buttons offset -->
	</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcategoriesupdate.Init();
</script>
<?php
$categories_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$categories_update->Page_Terminate();
?>

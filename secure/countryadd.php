<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "countryinfo.php" ?>
<?php include_once "companyinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$country_add = NULL; // Initialize page object first

class ccountry_add extends ccountry {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'country';

	// Page object name
	var $PageObjName = 'country_add';

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

		// Table object (country)
		if (!isset($GLOBALS["country"]) || get_class($GLOBALS["country"]) == "ccountry") {
			$GLOBALS["country"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["country"];
		}

		// Table object (company)
		if (!isset($GLOBALS['company'])) $GLOBALS['company'] = new ccompany();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'country', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("countrylist.php"));
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
		$this->country_name_kh->SetVisibility();
		$this->country_name_en->SetVisibility();
		$this->country_code->SetVisibility();
		$this->image->SetVisibility();
		$this->deatil->SetVisibility();

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
		global $EW_EXPORT, $country;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($country);
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
					if ($pageName == "countryview.php")
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

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
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["country_id"] != "") {
				$this->country_id->setQueryStringValue($_GET["country_id"]);
				$this->setKey("country_id", $this->country_id->CurrentValue); // Set up key
			} else {
				$this->setKey("country_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("countrylist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "countrylist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "countryview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		if ($this->CurrentAction == "F") { // Confirm page
			$this->RowType = EW_ROWTYPE_VIEW; // Render view type
		} else {
			$this->RowType = EW_ROWTYPE_ADD; // Render add type
		}

		// Render row
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
		$this->country_id->CurrentValue = NULL;
		$this->country_id->OldValue = $this->country_id->CurrentValue;
		$this->country_name_kh->CurrentValue = NULL;
		$this->country_name_kh->OldValue = $this->country_name_kh->CurrentValue;
		$this->country_name_en->CurrentValue = NULL;
		$this->country_name_en->OldValue = $this->country_name_en->CurrentValue;
		$this->country_code->CurrentValue = NULL;
		$this->country_code->OldValue = $this->country_code->CurrentValue;
		$this->image->CurrentValue = "default.jpg";
		$this->deatil->CurrentValue = NULL;
		$this->deatil->OldValue = $this->deatil->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->country_name_kh->FldIsDetailKey) {
			$this->country_name_kh->setFormValue($objForm->GetValue("x_country_name_kh"));
		}
		if (!$this->country_name_en->FldIsDetailKey) {
			$this->country_name_en->setFormValue($objForm->GetValue("x_country_name_en"));
		}
		if (!$this->country_code->FldIsDetailKey) {
			$this->country_code->setFormValue($objForm->GetValue("x_country_code"));
		}
		if (!$this->image->FldIsDetailKey) {
			$this->image->setFormValue($objForm->GetValue("x_image"));
		}
		if (!$this->deatil->FldIsDetailKey) {
			$this->deatil->setFormValue($objForm->GetValue("x_deatil"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->country_name_kh->CurrentValue = $this->country_name_kh->FormValue;
		$this->country_name_en->CurrentValue = $this->country_name_en->FormValue;
		$this->country_code->CurrentValue = $this->country_code->FormValue;
		$this->image->CurrentValue = $this->image->FormValue;
		$this->deatil->CurrentValue = $this->deatil->FormValue;
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
		$this->country_id->setDbValue($row['country_id']);
		$this->country_name_kh->setDbValue($row['country_name_kh']);
		$this->country_name_en->setDbValue($row['country_name_en']);
		$this->country_code->setDbValue($row['country_code']);
		$this->image->setDbValue($row['image']);
		$this->deatil->setDbValue($row['deatil']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['country_id'] = $this->country_id->CurrentValue;
		$row['country_name_kh'] = $this->country_name_kh->CurrentValue;
		$row['country_name_en'] = $this->country_name_en->CurrentValue;
		$row['country_code'] = $this->country_code->CurrentValue;
		$row['image'] = $this->image->CurrentValue;
		$row['deatil'] = $this->deatil->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->country_id->DbValue = $row['country_id'];
		$this->country_name_kh->DbValue = $row['country_name_kh'];
		$this->country_name_en->DbValue = $row['country_name_en'];
		$this->country_code->DbValue = $row['country_code'];
		$this->image->DbValue = $row['image'];
		$this->deatil->DbValue = $row['deatil'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("country_id")) <> "")
			$this->country_id->CurrentValue = $this->getKey("country_id"); // country_id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// country_id
		// country_name_kh
		// country_name_en
		// country_code
		// image
		// deatil

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// country_id
		$this->country_id->ViewValue = $this->country_id->CurrentValue;
		$this->country_id->ViewCustomAttributes = "";

		// country_name_kh
		$this->country_name_kh->ViewValue = $this->country_name_kh->CurrentValue;
		$this->country_name_kh->ViewCustomAttributes = "";

		// country_name_en
		$this->country_name_en->ViewValue = $this->country_name_en->CurrentValue;
		$this->country_name_en->ViewCustomAttributes = "";

		// country_code
		$this->country_code->ViewValue = $this->country_code->CurrentValue;
		$this->country_code->ViewCustomAttributes = "";

		// image
		$this->image->ViewValue = $this->image->CurrentValue;
		$this->image->ViewCustomAttributes = "";

		// deatil
		$this->deatil->ViewValue = $this->deatil->CurrentValue;
		$this->deatil->ViewCustomAttributes = "";

			// country_name_kh
			$this->country_name_kh->LinkCustomAttributes = "";
			$this->country_name_kh->HrefValue = "";
			$this->country_name_kh->TooltipValue = "";

			// country_name_en
			$this->country_name_en->LinkCustomAttributes = "";
			$this->country_name_en->HrefValue = "";
			$this->country_name_en->TooltipValue = "";

			// country_code
			$this->country_code->LinkCustomAttributes = "";
			$this->country_code->HrefValue = "";
			$this->country_code->TooltipValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";
			$this->image->TooltipValue = "";

			// deatil
			$this->deatil->LinkCustomAttributes = "";
			$this->deatil->HrefValue = "";
			$this->deatil->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// country_name_kh
			$this->country_name_kh->EditAttrs["class"] = "form-control";
			$this->country_name_kh->EditCustomAttributes = "";
			$this->country_name_kh->EditValue = ew_HtmlEncode($this->country_name_kh->CurrentValue);
			$this->country_name_kh->PlaceHolder = ew_RemoveHtml($this->country_name_kh->FldCaption());

			// country_name_en
			$this->country_name_en->EditAttrs["class"] = "form-control";
			$this->country_name_en->EditCustomAttributes = "";
			$this->country_name_en->EditValue = ew_HtmlEncode($this->country_name_en->CurrentValue);
			$this->country_name_en->PlaceHolder = ew_RemoveHtml($this->country_name_en->FldCaption());

			// country_code
			$this->country_code->EditAttrs["class"] = "form-control";
			$this->country_code->EditCustomAttributes = "";
			$this->country_code->EditValue = ew_HtmlEncode($this->country_code->CurrentValue);
			$this->country_code->PlaceHolder = ew_RemoveHtml($this->country_code->FldCaption());

			// image
			$this->image->EditAttrs["class"] = "form-control";
			$this->image->EditCustomAttributes = "";
			$this->image->EditValue = ew_HtmlEncode($this->image->CurrentValue);
			$this->image->PlaceHolder = ew_RemoveHtml($this->image->FldCaption());

			// deatil
			$this->deatil->EditAttrs["class"] = "form-control";
			$this->deatil->EditCustomAttributes = "";
			$this->deatil->EditValue = ew_HtmlEncode($this->deatil->CurrentValue);
			$this->deatil->PlaceHolder = ew_RemoveHtml($this->deatil->FldCaption());

			// Add refer script
			// country_name_kh

			$this->country_name_kh->LinkCustomAttributes = "";
			$this->country_name_kh->HrefValue = "";

			// country_name_en
			$this->country_name_en->LinkCustomAttributes = "";
			$this->country_name_en->HrefValue = "";

			// country_code
			$this->country_code->LinkCustomAttributes = "";
			$this->country_code->HrefValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";

			// deatil
			$this->deatil->LinkCustomAttributes = "";
			$this->deatil->HrefValue = "";
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

		// country_name_kh
		$this->country_name_kh->SetDbValueDef($rsnew, $this->country_name_kh->CurrentValue, NULL, FALSE);

		// country_name_en
		$this->country_name_en->SetDbValueDef($rsnew, $this->country_name_en->CurrentValue, NULL, FALSE);

		// country_code
		$this->country_code->SetDbValueDef($rsnew, $this->country_code->CurrentValue, NULL, FALSE);

		// image
		$this->image->SetDbValueDef($rsnew, $this->image->CurrentValue, NULL, strval($this->image->CurrentValue) == "");

		// deatil
		$this->deatil->SetDbValueDef($rsnew, $this->deatil->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("countrylist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($country_add)) $country_add = new ccountry_add();

// Page init
$country_add->Page_Init();

// Page main
$country_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$country_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcountryadd = new ew_Form("fcountryadd", "add");

// Validate form
fcountryadd.Validate = function() {
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

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fcountryadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcountryadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $country_add->ShowPageHeader(); ?>
<?php
$country_add->ShowMessage();
?>
<form name="fcountryadd" id="fcountryadd" class="<?php echo $country_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($country_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $country_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="country">
<?php if ($country->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } else { ?>
<input type="hidden" name="a_add" id="a_add" value="F">
<?php } ?>
<input type="hidden" name="modal" value="<?php echo intval($country_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($country->country_name_kh->Visible) { // country_name_kh ?>
	<div id="r_country_name_kh" class="form-group">
		<label id="elh_country_country_name_kh" for="x_country_name_kh" class="<?php echo $country_add->LeftColumnClass ?>"><?php echo $country->country_name_kh->FldCaption() ?></label>
		<div class="<?php echo $country_add->RightColumnClass ?>"><div<?php echo $country->country_name_kh->CellAttributes() ?>>
<?php if ($country->CurrentAction <> "F") { ?>
<span id="el_country_country_name_kh">
<input type="text" data-table="country" data-field="x_country_name_kh" name="x_country_name_kh" id="x_country_name_kh" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($country->country_name_kh->getPlaceHolder()) ?>" value="<?php echo $country->country_name_kh->EditValue ?>"<?php echo $country->country_name_kh->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_country_country_name_kh">
<span<?php echo $country->country_name_kh->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $country->country_name_kh->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="country" data-field="x_country_name_kh" name="x_country_name_kh" id="x_country_name_kh" value="<?php echo ew_HtmlEncode($country->country_name_kh->FormValue) ?>">
<?php } ?>
<?php echo $country->country_name_kh->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($country->country_name_en->Visible) { // country_name_en ?>
	<div id="r_country_name_en" class="form-group">
		<label id="elh_country_country_name_en" for="x_country_name_en" class="<?php echo $country_add->LeftColumnClass ?>"><?php echo $country->country_name_en->FldCaption() ?></label>
		<div class="<?php echo $country_add->RightColumnClass ?>"><div<?php echo $country->country_name_en->CellAttributes() ?>>
<?php if ($country->CurrentAction <> "F") { ?>
<span id="el_country_country_name_en">
<input type="text" data-table="country" data-field="x_country_name_en" name="x_country_name_en" id="x_country_name_en" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($country->country_name_en->getPlaceHolder()) ?>" value="<?php echo $country->country_name_en->EditValue ?>"<?php echo $country->country_name_en->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_country_country_name_en">
<span<?php echo $country->country_name_en->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $country->country_name_en->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="country" data-field="x_country_name_en" name="x_country_name_en" id="x_country_name_en" value="<?php echo ew_HtmlEncode($country->country_name_en->FormValue) ?>">
<?php } ?>
<?php echo $country->country_name_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($country->country_code->Visible) { // country_code ?>
	<div id="r_country_code" class="form-group">
		<label id="elh_country_country_code" for="x_country_code" class="<?php echo $country_add->LeftColumnClass ?>"><?php echo $country->country_code->FldCaption() ?></label>
		<div class="<?php echo $country_add->RightColumnClass ?>"><div<?php echo $country->country_code->CellAttributes() ?>>
<?php if ($country->CurrentAction <> "F") { ?>
<span id="el_country_country_code">
<input type="text" data-table="country" data-field="x_country_code" name="x_country_code" id="x_country_code" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($country->country_code->getPlaceHolder()) ?>" value="<?php echo $country->country_code->EditValue ?>"<?php echo $country->country_code->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_country_country_code">
<span<?php echo $country->country_code->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $country->country_code->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="country" data-field="x_country_code" name="x_country_code" id="x_country_code" value="<?php echo ew_HtmlEncode($country->country_code->FormValue) ?>">
<?php } ?>
<?php echo $country->country_code->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($country->image->Visible) { // image ?>
	<div id="r_image" class="form-group">
		<label id="elh_country_image" for="x_image" class="<?php echo $country_add->LeftColumnClass ?>"><?php echo $country->image->FldCaption() ?></label>
		<div class="<?php echo $country_add->RightColumnClass ?>"><div<?php echo $country->image->CellAttributes() ?>>
<?php if ($country->CurrentAction <> "F") { ?>
<span id="el_country_image">
<input type="text" data-table="country" data-field="x_image" name="x_image" id="x_image" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($country->image->getPlaceHolder()) ?>" value="<?php echo $country->image->EditValue ?>"<?php echo $country->image->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_country_image">
<span<?php echo $country->image->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $country->image->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="country" data-field="x_image" name="x_image" id="x_image" value="<?php echo ew_HtmlEncode($country->image->FormValue) ?>">
<?php } ?>
<?php echo $country->image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($country->deatil->Visible) { // deatil ?>
	<div id="r_deatil" class="form-group">
		<label id="elh_country_deatil" for="x_deatil" class="<?php echo $country_add->LeftColumnClass ?>"><?php echo $country->deatil->FldCaption() ?></label>
		<div class="<?php echo $country_add->RightColumnClass ?>"><div<?php echo $country->deatil->CellAttributes() ?>>
<?php if ($country->CurrentAction <> "F") { ?>
<span id="el_country_deatil">
<textarea data-table="country" data-field="x_deatil" name="x_deatil" id="x_deatil" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($country->deatil->getPlaceHolder()) ?>"<?php echo $country->deatil->EditAttributes() ?>><?php echo $country->deatil->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el_country_deatil">
<span<?php echo $country->deatil->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $country->deatil->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="country" data-field="x_deatil" name="x_deatil" id="x_deatil" value="<?php echo ew_HtmlEncode($country->deatil->FormValue) ?>">
<?php } ?>
<?php echo $country->deatil->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$country_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $country_add->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($country->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_add.value='F';"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $country_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_add.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcountryadd.Init();
</script>
<?php
$country_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$country_add->Page_Terminate();
?>

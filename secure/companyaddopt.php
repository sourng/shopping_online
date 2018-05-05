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

$company_addopt = NULL; // Initialize page object first

class ccompany_addopt extends ccompany {

	// Page ID
	var $PageID = 'addopt';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'company';

	// Page object name
	var $PageObjName = 'company_addopt';

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
			define("EW_PAGE_ID", 'addopt', TRUE);

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
		if (!$Security->CanAdd()) {
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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->com_fname->SetVisibility();
		$this->com_lname->SetVisibility();
		$this->com_name->SetVisibility();
		$this->com_address->SetVisibility();
		$this->com_phone->SetVisibility();
		$this->com_email->SetVisibility();
		$this->com_fb->SetVisibility();
		$this->com_tw->SetVisibility();
		$this->com_yt->SetVisibility();
		$this->com_logo->SetVisibility();
		$this->com_username->SetVisibility();
		$this->com_password->SetVisibility();
		$this->com_online->SetVisibility();
		$this->com_activation->SetVisibility();
		$this->com_status->SetVisibility();
		$this->reg_date->SetVisibility();
		$this->country_id->SetVisibility();
		$this->province_id->SetVisibility();

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
					$row["x_company_id"] = $this->company_id->DbValue;
					$row["x_com_fname"] = ew_ConvertToUtf8($this->com_fname->DbValue);
					$row["x_com_lname"] = ew_ConvertToUtf8($this->com_lname->DbValue);
					$row["x_com_name"] = ew_ConvertToUtf8($this->com_name->DbValue);
					$row["x_com_address"] = ew_ConvertToUtf8($this->com_address->DbValue);
					$row["x_com_phone"] = ew_ConvertToUtf8($this->com_phone->DbValue);
					$row["x_com_email"] = ew_ConvertToUtf8($this->com_email->DbValue);
					$row["x_com_fb"] = ew_ConvertToUtf8($this->com_fb->DbValue);
					$row["x_com_tw"] = ew_ConvertToUtf8($this->com_tw->DbValue);
					$row["x_com_yt"] = ew_ConvertToUtf8($this->com_yt->DbValue);
					$row["x_com_logo"] = ew_ConvertToUtf8($this->com_logo->DbValue);
					$row["x_com_username"] = ew_ConvertToUtf8($this->com_username->DbValue);
					$row["x_com_password"] = ew_ConvertToUtf8($this->com_password->DbValue);
					$row["x_com_online"] = ew_ConvertToUtf8($this->com_online->DbValue);
					$row["x_com_activation"] = ew_ConvertToUtf8($this->com_activation->DbValue);
					$row["x_com_status"] = ew_ConvertToUtf8($this->com_status->DbValue);
					$row["x_reg_date"] = $this->reg_date->DbValue;
					$row["x_country_id"] = $this->country_id->DbValue;
					$row["x_province_id"] = $this->province_id->DbValue;
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
		$this->com_logo->Upload->Index = $objForm->Index;
		$this->com_logo->Upload->UploadFile();
		$this->com_logo->CurrentValue = $this->com_logo->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->company_id->CurrentValue = NULL;
		$this->company_id->OldValue = $this->company_id->CurrentValue;
		$this->com_fname->CurrentValue = NULL;
		$this->com_fname->OldValue = $this->com_fname->CurrentValue;
		$this->com_lname->CurrentValue = NULL;
		$this->com_lname->OldValue = $this->com_lname->CurrentValue;
		$this->com_name->CurrentValue = NULL;
		$this->com_name->OldValue = $this->com_name->CurrentValue;
		$this->com_address->CurrentValue = NULL;
		$this->com_address->OldValue = $this->com_address->CurrentValue;
		$this->com_phone->CurrentValue = NULL;
		$this->com_phone->OldValue = $this->com_phone->CurrentValue;
		$this->com_email->CurrentValue = NULL;
		$this->com_email->OldValue = $this->com_email->CurrentValue;
		$this->com_fb->CurrentValue = NULL;
		$this->com_fb->OldValue = $this->com_fb->CurrentValue;
		$this->com_tw->CurrentValue = NULL;
		$this->com_tw->OldValue = $this->com_tw->CurrentValue;
		$this->com_yt->CurrentValue = NULL;
		$this->com_yt->OldValue = $this->com_yt->CurrentValue;
		$this->com_logo->Upload->DbValue = NULL;
		$this->com_logo->OldValue = $this->com_logo->Upload->DbValue;
		$this->com_logo->CurrentValue = NULL; // Clear file related field
		$this->com_username->CurrentValue = NULL;
		$this->com_username->OldValue = $this->com_username->CurrentValue;
		$this->com_password->CurrentValue = NULL;
		$this->com_password->OldValue = $this->com_password->CurrentValue;
		$this->com_online->CurrentValue = NULL;
		$this->com_online->OldValue = $this->com_online->CurrentValue;
		$this->com_activation->CurrentValue = NULL;
		$this->com_activation->OldValue = $this->com_activation->CurrentValue;
		$this->com_status->CurrentValue = NULL;
		$this->com_status->OldValue = $this->com_status->CurrentValue;
		$this->reg_date->CurrentValue = NULL;
		$this->reg_date->OldValue = $this->reg_date->CurrentValue;
		$this->country_id->CurrentValue = NULL;
		$this->country_id->OldValue = $this->country_id->CurrentValue;
		$this->province_id->CurrentValue = NULL;
		$this->province_id->OldValue = $this->province_id->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->com_fname->FldIsDetailKey) {
			$this->com_fname->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_fname")));
		}
		if (!$this->com_lname->FldIsDetailKey) {
			$this->com_lname->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_lname")));
		}
		if (!$this->com_name->FldIsDetailKey) {
			$this->com_name->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_name")));
		}
		if (!$this->com_address->FldIsDetailKey) {
			$this->com_address->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_address")));
		}
		if (!$this->com_phone->FldIsDetailKey) {
			$this->com_phone->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_phone")));
		}
		if (!$this->com_email->FldIsDetailKey) {
			$this->com_email->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_email")));
		}
		if (!$this->com_fb->FldIsDetailKey) {
			$this->com_fb->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_fb")));
		}
		if (!$this->com_tw->FldIsDetailKey) {
			$this->com_tw->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_tw")));
		}
		if (!$this->com_yt->FldIsDetailKey) {
			$this->com_yt->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_yt")));
		}
		if (!$this->com_username->FldIsDetailKey) {
			$this->com_username->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_username")));
		}
		if (!$this->com_password->FldIsDetailKey) {
			$this->com_password->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_password")));
		}
		if (!$this->com_online->FldIsDetailKey) {
			$this->com_online->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_online")));
		}
		if (!$this->com_activation->FldIsDetailKey) {
			$this->com_activation->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_activation")));
		}
		if (!$this->com_status->FldIsDetailKey) {
			$this->com_status->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_com_status")));
		}
		if (!$this->reg_date->FldIsDetailKey) {
			$this->reg_date->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_reg_date")));
			$this->reg_date->CurrentValue = ew_UnFormatDateTime($this->reg_date->CurrentValue, 1);
		}
		if (!$this->country_id->FldIsDetailKey) {
			$this->country_id->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_country_id")));
		}
		if (!$this->province_id->FldIsDetailKey) {
			$this->province_id->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_province_id")));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->com_fname->CurrentValue = ew_ConvertToUtf8($this->com_fname->FormValue);
		$this->com_lname->CurrentValue = ew_ConvertToUtf8($this->com_lname->FormValue);
		$this->com_name->CurrentValue = ew_ConvertToUtf8($this->com_name->FormValue);
		$this->com_address->CurrentValue = ew_ConvertToUtf8($this->com_address->FormValue);
		$this->com_phone->CurrentValue = ew_ConvertToUtf8($this->com_phone->FormValue);
		$this->com_email->CurrentValue = ew_ConvertToUtf8($this->com_email->FormValue);
		$this->com_fb->CurrentValue = ew_ConvertToUtf8($this->com_fb->FormValue);
		$this->com_tw->CurrentValue = ew_ConvertToUtf8($this->com_tw->FormValue);
		$this->com_yt->CurrentValue = ew_ConvertToUtf8($this->com_yt->FormValue);
		$this->com_username->CurrentValue = ew_ConvertToUtf8($this->com_username->FormValue);
		$this->com_password->CurrentValue = ew_ConvertToUtf8($this->com_password->FormValue);
		$this->com_online->CurrentValue = ew_ConvertToUtf8($this->com_online->FormValue);
		$this->com_activation->CurrentValue = ew_ConvertToUtf8($this->com_activation->FormValue);
		$this->com_status->CurrentValue = ew_ConvertToUtf8($this->com_status->FormValue);
		$this->reg_date->CurrentValue = ew_ConvertToUtf8($this->reg_date->FormValue);
		$this->reg_date->CurrentValue = ew_UnFormatDateTime($this->reg_date->CurrentValue, 1);
		$this->country_id->CurrentValue = ew_ConvertToUtf8($this->country_id->FormValue);
		$this->province_id->CurrentValue = ew_ConvertToUtf8($this->province_id->FormValue);
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
		$this->com_logo->Upload->DbValue = $row['com_logo'];
		$this->com_logo->setDbValue($this->com_logo->Upload->DbValue);
		$this->com_username->setDbValue($row['com_username']);
		$this->com_password->setDbValue($row['com_password']);
		$this->com_online->setDbValue($row['com_online']);
		$this->com_activation->setDbValue($row['com_activation']);
		$this->com_status->setDbValue($row['com_status']);
		$this->reg_date->setDbValue($row['reg_date']);
		$this->country_id->setDbValue($row['country_id']);
		$this->province_id->setDbValue($row['province_id']);
		if (array_key_exists('EV__province_id', $rs->fields)) {
			$this->province_id->VirtualValue = $rs->fields('EV__province_id'); // Set up virtual field value
		} else {
			$this->province_id->VirtualValue = ""; // Clear value
		}
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['company_id'] = $this->company_id->CurrentValue;
		$row['com_fname'] = $this->com_fname->CurrentValue;
		$row['com_lname'] = $this->com_lname->CurrentValue;
		$row['com_name'] = $this->com_name->CurrentValue;
		$row['com_address'] = $this->com_address->CurrentValue;
		$row['com_phone'] = $this->com_phone->CurrentValue;
		$row['com_email'] = $this->com_email->CurrentValue;
		$row['com_fb'] = $this->com_fb->CurrentValue;
		$row['com_tw'] = $this->com_tw->CurrentValue;
		$row['com_yt'] = $this->com_yt->CurrentValue;
		$row['com_logo'] = $this->com_logo->Upload->DbValue;
		$row['com_username'] = $this->com_username->CurrentValue;
		$row['com_password'] = $this->com_password->CurrentValue;
		$row['com_online'] = $this->com_online->CurrentValue;
		$row['com_activation'] = $this->com_activation->CurrentValue;
		$row['com_status'] = $this->com_status->CurrentValue;
		$row['reg_date'] = $this->reg_date->CurrentValue;
		$row['country_id'] = $this->country_id->CurrentValue;
		$row['province_id'] = $this->province_id->CurrentValue;
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
		$this->com_logo->Upload->DbValue = $row['com_logo'];
		$this->com_username->DbValue = $row['com_username'];
		$this->com_password->DbValue = $row['com_password'];
		$this->com_online->DbValue = $row['com_online'];
		$this->com_activation->DbValue = $row['com_activation'];
		$this->com_status->DbValue = $row['com_status'];
		$this->reg_date->DbValue = $row['reg_date'];
		$this->country_id->DbValue = $row['country_id'];
		$this->province_id->DbValue = $row['province_id'];
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
		// com_username
		// com_password
		// com_online
		// com_activation
		// com_status
		// reg_date
		// country_id
		// province_id

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// com_fname
			$this->com_fname->EditAttrs["class"] = "form-control";
			$this->com_fname->EditCustomAttributes = "";
			$this->com_fname->EditValue = ew_HtmlEncode($this->com_fname->CurrentValue);
			$this->com_fname->PlaceHolder = ew_RemoveHtml($this->com_fname->FldCaption());

			// com_lname
			$this->com_lname->EditAttrs["class"] = "form-control";
			$this->com_lname->EditCustomAttributes = "";
			$this->com_lname->EditValue = ew_HtmlEncode($this->com_lname->CurrentValue);
			$this->com_lname->PlaceHolder = ew_RemoveHtml($this->com_lname->FldCaption());

			// com_name
			$this->com_name->EditAttrs["class"] = "form-control";
			$this->com_name->EditCustomAttributes = "";
			$this->com_name->EditValue = ew_HtmlEncode($this->com_name->CurrentValue);
			$this->com_name->PlaceHolder = ew_RemoveHtml($this->com_name->FldCaption());

			// com_address
			$this->com_address->EditAttrs["class"] = "form-control";
			$this->com_address->EditCustomAttributes = "";
			$this->com_address->EditValue = ew_HtmlEncode($this->com_address->CurrentValue);
			$this->com_address->PlaceHolder = ew_RemoveHtml($this->com_address->FldCaption());

			// com_phone
			$this->com_phone->EditAttrs["class"] = "form-control";
			$this->com_phone->EditCustomAttributes = "";
			$this->com_phone->EditValue = ew_HtmlEncode($this->com_phone->CurrentValue);
			$this->com_phone->PlaceHolder = ew_RemoveHtml($this->com_phone->FldCaption());

			// com_email
			$this->com_email->EditAttrs["class"] = "form-control";
			$this->com_email->EditCustomAttributes = "";
			$this->com_email->EditValue = ew_HtmlEncode($this->com_email->CurrentValue);
			$this->com_email->PlaceHolder = ew_RemoveHtml($this->com_email->FldCaption());

			// com_fb
			$this->com_fb->EditAttrs["class"] = "form-control";
			$this->com_fb->EditCustomAttributes = "";
			$this->com_fb->EditValue = ew_HtmlEncode($this->com_fb->CurrentValue);
			$this->com_fb->PlaceHolder = ew_RemoveHtml($this->com_fb->FldCaption());

			// com_tw
			$this->com_tw->EditAttrs["class"] = "form-control";
			$this->com_tw->EditCustomAttributes = "";
			$this->com_tw->EditValue = ew_HtmlEncode($this->com_tw->CurrentValue);
			$this->com_tw->PlaceHolder = ew_RemoveHtml($this->com_tw->FldCaption());

			// com_yt
			$this->com_yt->EditAttrs["class"] = "form-control";
			$this->com_yt->EditCustomAttributes = "";
			$this->com_yt->EditValue = ew_HtmlEncode($this->com_yt->CurrentValue);
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
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->com_logo);

			// com_username
			$this->com_username->EditAttrs["class"] = "form-control";
			$this->com_username->EditCustomAttributes = "";
			$this->com_username->EditValue = ew_HtmlEncode($this->com_username->CurrentValue);
			$this->com_username->PlaceHolder = ew_RemoveHtml($this->com_username->FldCaption());

			// com_password
			$this->com_password->EditAttrs["class"] = "form-control";
			$this->com_password->EditCustomAttributes = "";
			$this->com_password->EditValue = ew_HtmlEncode($this->com_password->CurrentValue);
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
			$this->reg_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->reg_date->CurrentValue, 8));
			$this->reg_date->PlaceHolder = ew_RemoveHtml($this->reg_date->FldCaption());

			// country_id
			$this->country_id->EditCustomAttributes = "";
			if (trim(strval($this->country_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`country_id`" . ew_SearchString("=", $this->country_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT DISTINCT `country_id`, `country_name_kh` AS `DispFld`, `country_name_en` AS `Disp2Fld`, `country_code` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `country`";
			$sWhereWrk = "";
			$this->country_id->LookupFilters = array("dx1" => '`country_name_kh`', "dx2" => '`country_name_en`', "dx3" => '`country_code`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->country_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$arwrk[3] = ew_HtmlEncode($rswrk->fields('Disp3Fld'));
				$this->country_id->ViewValue = $this->country_id->DisplayValue($arwrk);
			} else {
				$this->country_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->country_id->EditValue = $arwrk;

			// province_id
			$this->province_id->EditCustomAttributes = "";
			if (trim(strval($this->province_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`province_id`" . ew_SearchString("=", $this->province_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT DISTINCT `province_id`, `province_name_kh` AS `DispFld`, `province_name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `country_id` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `province`";
			$sWhereWrk = "";
			$this->province_id->LookupFilters = array("dx1" => '`province_name_kh`', "dx2" => '`province_name_en`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->province_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->province_id->ViewValue = $this->province_id->DisplayValue($arwrk);
			} else {
				$this->province_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->province_id->EditValue = $arwrk;

			// Add refer script
			// com_fname

			$this->com_fname->LinkCustomAttributes = "";
			$this->com_fname->HrefValue = "";

			// com_lname
			$this->com_lname->LinkCustomAttributes = "";
			$this->com_lname->HrefValue = "";

			// com_name
			$this->com_name->LinkCustomAttributes = "";
			$this->com_name->HrefValue = "";

			// com_address
			$this->com_address->LinkCustomAttributes = "";
			$this->com_address->HrefValue = "";

			// com_phone
			$this->com_phone->LinkCustomAttributes = "";
			$this->com_phone->HrefValue = "";

			// com_email
			$this->com_email->LinkCustomAttributes = "";
			$this->com_email->HrefValue = "";

			// com_fb
			$this->com_fb->LinkCustomAttributes = "";
			$this->com_fb->HrefValue = "";

			// com_tw
			$this->com_tw->LinkCustomAttributes = "";
			$this->com_tw->HrefValue = "";

			// com_yt
			$this->com_yt->LinkCustomAttributes = "";
			$this->com_yt->HrefValue = "";

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

			// com_username
			$this->com_username->LinkCustomAttributes = "";
			$this->com_username->HrefValue = "";

			// com_password
			$this->com_password->LinkCustomAttributes = "";
			$this->com_password->HrefValue = "";

			// com_online
			$this->com_online->LinkCustomAttributes = "";
			$this->com_online->HrefValue = "";

			// com_activation
			$this->com_activation->LinkCustomAttributes = "";
			$this->com_activation->HrefValue = "";

			// com_status
			$this->com_status->LinkCustomAttributes = "";
			$this->com_status->HrefValue = "";

			// reg_date
			$this->reg_date->LinkCustomAttributes = "";
			$this->reg_date->HrefValue = "";

			// country_id
			$this->country_id->LinkCustomAttributes = "";
			$this->country_id->HrefValue = "";

			// province_id
			$this->province_id->LinkCustomAttributes = "";
			$this->province_id->HrefValue = "";
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
		if (!ew_CheckDateDef($this->reg_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->reg_date->FldErrMsg());
		}
		if (!$this->country_id->FldIsDetailKey && !is_null($this->country_id->FormValue) && $this->country_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->country_id->FldCaption(), $this->country_id->ReqErrMsg));
		}
		if (!$this->province_id->FldIsDetailKey && !is_null($this->province_id->FormValue) && $this->province_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->province_id->FldCaption(), $this->province_id->ReqErrMsg));
		}

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
			$this->com_logo->OldUploadPath = "../uploads/company";
			$this->com_logo->UploadPath = $this->com_logo->OldUploadPath;
		}
		$rsnew = array();

		// com_fname
		$this->com_fname->SetDbValueDef($rsnew, $this->com_fname->CurrentValue, NULL, FALSE);

		// com_lname
		$this->com_lname->SetDbValueDef($rsnew, $this->com_lname->CurrentValue, NULL, FALSE);

		// com_name
		$this->com_name->SetDbValueDef($rsnew, $this->com_name->CurrentValue, NULL, FALSE);

		// com_address
		$this->com_address->SetDbValueDef($rsnew, $this->com_address->CurrentValue, NULL, FALSE);

		// com_phone
		$this->com_phone->SetDbValueDef($rsnew, $this->com_phone->CurrentValue, NULL, FALSE);

		// com_email
		$this->com_email->SetDbValueDef($rsnew, $this->com_email->CurrentValue, NULL, FALSE);

		// com_fb
		$this->com_fb->SetDbValueDef($rsnew, $this->com_fb->CurrentValue, NULL, FALSE);

		// com_tw
		$this->com_tw->SetDbValueDef($rsnew, $this->com_tw->CurrentValue, NULL, FALSE);

		// com_yt
		$this->com_yt->SetDbValueDef($rsnew, $this->com_yt->CurrentValue, NULL, FALSE);

		// com_logo
		if ($this->com_logo->Visible && !$this->com_logo->Upload->KeepFile) {
			$this->com_logo->Upload->DbValue = ""; // No need to delete old file
			if ($this->com_logo->Upload->FileName == "") {
				$rsnew['com_logo'] = NULL;
			} else {
				$rsnew['com_logo'] = $this->com_logo->Upload->FileName;
			}
		}

		// com_username
		$this->com_username->SetDbValueDef($rsnew, $this->com_username->CurrentValue, NULL, FALSE);

		// com_password
		$this->com_password->SetDbValueDef($rsnew, $this->com_password->CurrentValue, NULL, FALSE);

		// com_online
		$this->com_online->SetDbValueDef($rsnew, $this->com_online->CurrentValue, NULL, FALSE);

		// com_activation
		$this->com_activation->SetDbValueDef($rsnew, $this->com_activation->CurrentValue, NULL, FALSE);

		// com_status
		$this->com_status->SetDbValueDef($rsnew, $this->com_status->CurrentValue, NULL, FALSE);

		// reg_date
		$this->reg_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->reg_date->CurrentValue, 1), NULL, FALSE);

		// country_id
		$this->country_id->SetDbValueDef($rsnew, $this->country_id->CurrentValue, 0, FALSE);

		// province_id
		$this->province_id->SetDbValueDef($rsnew, $this->province_id->CurrentValue, 0, FALSE);
		if ($this->com_logo->Visible && !$this->com_logo->Upload->KeepFile) {
			$this->com_logo->UploadPath = "../uploads/company";
			$OldFiles = ew_Empty($this->com_logo->Upload->DbValue) ? array() : array($this->com_logo->Upload->DbValue);
			if (!ew_Empty($this->com_logo->Upload->FileName)) {
				$NewFiles = array($this->com_logo->Upload->FileName);
				$NewFileCount = count($NewFiles);
				for ($i = 0; $i < $NewFileCount; $i++) {
					$fldvar = ($this->com_logo->Upload->Index < 0) ? $this->com_logo->FldVar : substr($this->com_logo->FldVar, 0, 1) . $this->com_logo->Upload->Index . substr($this->com_logo->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->com_logo->TblVar) . $file)) {
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
							$file1 = ew_UploadFileNameEx($this->com_logo->PhysicalUploadPath(), $file); // Get new file name
							if ($file1 <> $file) { // Rename temp file
								while (file_exists(ew_UploadTempPath($fldvar, $this->com_logo->TblVar) . $file1) || file_exists($this->com_logo->PhysicalUploadPath() . $file1)) // Make sure no file name clash
									$file1 = ew_UniqueFilename($this->com_logo->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
								rename(ew_UploadTempPath($fldvar, $this->com_logo->TblVar) . $file, ew_UploadTempPath($fldvar, $this->com_logo->TblVar) . $file1);
								$NewFiles[$i] = $file1;
							}
						}
					}
				}
				$this->com_logo->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
				$this->com_logo->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$this->com_logo->SetDbValueDef($rsnew, $this->com_logo->Upload->FileName, NULL, FALSE);
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['country_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['province_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if ($this->com_logo->Visible && !$this->com_logo->Upload->KeepFile) {
					$OldFiles = ew_Empty($this->com_logo->Upload->DbValue) ? array() : array($this->com_logo->Upload->DbValue);
					if (!ew_Empty($this->com_logo->Upload->FileName)) {
						$NewFiles = array($this->com_logo->Upload->FileName);
						$NewFiles2 = array($rsnew['com_logo']);
						$NewFileCount = count($NewFiles);
						for ($i = 0; $i < $NewFileCount; $i++) {
							$fldvar = ($this->com_logo->Upload->Index < 0) ? $this->com_logo->FldVar : substr($this->com_logo->FldVar, 0, 1) . $this->com_logo->Upload->Index . substr($this->com_logo->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->com_logo->TblVar) . $NewFiles[$i];
								if (file_exists($file)) {
									if (@$NewFiles2[$i] <> "") // Use correct file name
										$NewFiles[$i] = $NewFiles2[$i];
									if (!$this->com_logo->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
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
							@unlink($this->com_logo->OldPhysicalUploadPath() . $OldFiles[$i]);
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
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}

		// com_logo
		ew_CleanUploadTempPath($this->com_logo, $this->com_logo->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("companylist.php"), "", $this->TableVar, TRUE);
		$PageId = "addopt";
		$Breadcrumb->Add("addopt", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_country_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT DISTINCT `country_id` AS `LinkFld`, `country_name_kh` AS `DispFld`, `country_name_en` AS `Disp2Fld`, `country_code` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `country`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`country_name_kh`', "dx2" => '`country_name_en`', "dx3" => '`country_code`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`country_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->country_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_province_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT DISTINCT `province_id` AS `LinkFld`, `province_name_kh` AS `DispFld`, `province_name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `province`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`province_name_kh`', "dx2" => '`province_name_en`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`province_id` IN ({filter_value})', "t0" => "3", "fn0" => "", "f1" => '`country_id` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->province_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($company_addopt)) $company_addopt = new ccompany_addopt();

// Page init
$company_addopt->Page_Init();

// Page main
$company_addopt->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$company_addopt->Page_Render();
?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "addopt";
var CurrentForm = fcompanyaddopt = new ew_Form("fcompanyaddopt", "addopt");

// Validate form
fcompanyaddopt.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_reg_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($company->reg_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_country_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $company->country_id->FldCaption(), $company->country_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_province_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $company->province_id->FldCaption(), $company->province_id->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fcompanyaddopt.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcompanyaddopt.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcompanyaddopt.Lists["x_com_online"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcompanyaddopt.Lists["x_com_online"].Options = <?php echo json_encode($company_addopt->com_online->Options()) ?>;
fcompanyaddopt.Lists["x_com_activation"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcompanyaddopt.Lists["x_com_activation"].Options = <?php echo json_encode($company_addopt->com_activation->Options()) ?>;
fcompanyaddopt.Lists["x_com_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcompanyaddopt.Lists["x_com_status"].Options = <?php echo json_encode($company_addopt->com_status->Options()) ?>;
fcompanyaddopt.Lists["x_country_id"] = {"LinkField":"x_country_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_country_name_kh","x_country_name_en","x_country_code",""],"ParentFields":[],"ChildFields":["x_province_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"country"};
fcompanyaddopt.Lists["x_country_id"].Data = "<?php echo $company_addopt->country_id->LookupFilterQuery(FALSE, "addopt") ?>";
fcompanyaddopt.Lists["x_province_id"] = {"LinkField":"x_province_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_province_name_kh","x_province_name_en","",""],"ParentFields":["x_country_id"],"ChildFields":[],"FilterFields":["x_country_id"],"Options":[],"Template":"","LinkTable":"province"};
fcompanyaddopt.Lists["x_province_id"].Data = "<?php echo $company_addopt->province_id->LookupFilterQuery(FALSE, "addopt") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php
$company_addopt->ShowMessage();
?>
<form name="fcompanyaddopt" id="fcompanyaddopt" class="ewForm form-horizontal" action="companyaddopt.php" method="post">
<?php if ($company_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $company_addopt->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="company">
<input type="hidden" name="a_addopt" id="a_addopt" value="A">
<?php if ($company->com_fname->Visible) { // com_fname ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_com_fname"><?php echo $company->com_fname->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="company" data-field="x_com_fname" name="x_com_fname" id="x_com_fname" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_fname->getPlaceHolder()) ?>" value="<?php echo $company->com_fname->EditValue ?>"<?php echo $company->com_fname->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($company->com_lname->Visible) { // com_lname ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_com_lname"><?php echo $company->com_lname->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="company" data-field="x_com_lname" name="x_com_lname" id="x_com_lname" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_lname->getPlaceHolder()) ?>" value="<?php echo $company->com_lname->EditValue ?>"<?php echo $company->com_lname->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($company->com_name->Visible) { // com_name ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_com_name"><?php echo $company->com_name->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="company" data-field="x_com_name" name="x_com_name" id="x_com_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_name->getPlaceHolder()) ?>" value="<?php echo $company->com_name->EditValue ?>"<?php echo $company->com_name->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($company->com_address->Visible) { // com_address ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_com_address"><?php echo $company->com_address->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="company" data-field="x_com_address" name="x_com_address" id="x_com_address" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_address->getPlaceHolder()) ?>" value="<?php echo $company->com_address->EditValue ?>"<?php echo $company->com_address->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($company->com_phone->Visible) { // com_phone ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_com_phone"><?php echo $company->com_phone->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="company" data-field="x_com_phone" name="x_com_phone" id="x_com_phone" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_phone->getPlaceHolder()) ?>" value="<?php echo $company->com_phone->EditValue ?>"<?php echo $company->com_phone->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($company->com_email->Visible) { // com_email ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_com_email"><?php echo $company->com_email->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="company" data-field="x_com_email" name="x_com_email" id="x_com_email" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_email->getPlaceHolder()) ?>" value="<?php echo $company->com_email->EditValue ?>"<?php echo $company->com_email->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($company->com_fb->Visible) { // com_fb ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_com_fb"><?php echo $company->com_fb->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="company" data-field="x_com_fb" name="x_com_fb" id="x_com_fb" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_fb->getPlaceHolder()) ?>" value="<?php echo $company->com_fb->EditValue ?>"<?php echo $company->com_fb->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($company->com_tw->Visible) { // com_tw ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_com_tw"><?php echo $company->com_tw->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="company" data-field="x_com_tw" name="x_com_tw" id="x_com_tw" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_tw->getPlaceHolder()) ?>" value="<?php echo $company->com_tw->EditValue ?>"<?php echo $company->com_tw->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($company->com_yt->Visible) { // com_yt ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_com_yt"><?php echo $company->com_yt->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="company" data-field="x_com_yt" name="x_com_yt" id="x_com_yt" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_yt->getPlaceHolder()) ?>" value="<?php echo $company->com_yt->EditValue ?>"<?php echo $company->com_yt->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($company->com_logo->Visible) { // com_logo ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel"><?php echo $company->com_logo->FldCaption() ?></label>
		<div class="col-sm-10">
<div id="fd_x_com_logo">
<span title="<?php echo $company->com_logo->FldTitle() ? $company->com_logo->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($company->com_logo->ReadOnly || $company->com_logo->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="company" data-field="x_com_logo" name="x_com_logo" id="x_com_logo"<?php echo $company->com_logo->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_com_logo" id= "fn_x_com_logo" value="<?php echo $company->com_logo->Upload->FileName ?>">
<input type="hidden" name="fa_x_com_logo" id= "fa_x_com_logo" value="0">
<input type="hidden" name="fs_x_com_logo" id= "fs_x_com_logo" value="250">
<input type="hidden" name="fx_x_com_logo" id= "fx_x_com_logo" value="<?php echo $company->com_logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_com_logo" id= "fm_x_com_logo" value="<?php echo $company->com_logo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_com_logo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</div>
	</div>
<?php } ?>
<?php if ($company->com_username->Visible) { // com_username ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_com_username"><?php echo $company->com_username->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="company" data-field="x_com_username" name="x_com_username" id="x_com_username" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_username->getPlaceHolder()) ?>" value="<?php echo $company->com_username->EditValue ?>"<?php echo $company->com_username->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($company->com_password->Visible) { // com_password ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_com_password"><?php echo $company->com_password->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="company" data-field="x_com_password" name="x_com_password" id="x_com_password" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_password->getPlaceHolder()) ?>" value="<?php echo $company->com_password->EditValue ?>"<?php echo $company->com_password->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($company->com_online->Visible) { // com_online ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel"><?php echo $company->com_online->FldCaption() ?></label>
		<div class="col-sm-10">
<div id="tp_x_com_online" class="ewTemplate"><input type="radio" data-table="company" data-field="x_com_online" data-value-separator="<?php echo $company->com_online->DisplayValueSeparatorAttribute() ?>" name="x_com_online" id="x_com_online" value="{value}"<?php echo $company->com_online->EditAttributes() ?>></div>
<div id="dsl_x_com_online" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $company->com_online->RadioButtonListHtml(FALSE, "x_com_online") ?>
</div></div>
</div>
	</div>
<?php } ?>
<?php if ($company->com_activation->Visible) { // com_activation ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_com_activation"><?php echo $company->com_activation->FldCaption() ?></label>
		<div class="col-sm-10">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($company->com_activation->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $company->com_activation->ViewValue ?>
	</span>
	<?php if (!$company->com_activation->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_com_activation" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $company->com_activation->RadioButtonListHtml(TRUE, "x_com_activation") ?>
		</div>
	</div>
	<div id="tp_x_com_activation" class="ewTemplate"><input type="radio" data-table="company" data-field="x_com_activation" data-value-separator="<?php echo $company->com_activation->DisplayValueSeparatorAttribute() ?>" name="x_com_activation" id="x_com_activation" value="{value}"<?php echo $company->com_activation->EditAttributes() ?>></div>
</div>
</div>
	</div>
<?php } ?>
<?php if ($company->com_status->Visible) { // com_status ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel"><?php echo $company->com_status->FldCaption() ?></label>
		<div class="col-sm-10">
<div id="tp_x_com_status" class="ewTemplate"><input type="radio" data-table="company" data-field="x_com_status" data-value-separator="<?php echo $company->com_status->DisplayValueSeparatorAttribute() ?>" name="x_com_status" id="x_com_status" value="{value}"<?php echo $company->com_status->EditAttributes() ?>></div>
<div id="dsl_x_com_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $company->com_status->RadioButtonListHtml(FALSE, "x_com_status") ?>
</div></div>
</div>
	</div>
<?php } ?>
<?php if ($company->reg_date->Visible) { // reg_date ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_reg_date"><?php echo $company->reg_date->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="company" data-field="x_reg_date" data-format="1" name="x_reg_date" id="x_reg_date" placeholder="<?php echo ew_HtmlEncode($company->reg_date->getPlaceHolder()) ?>" value="<?php echo $company->reg_date->EditValue ?>"<?php echo $company->reg_date->EditAttributes() ?>>
<?php if (!$company->reg_date->ReadOnly && !$company->reg_date->Disabled && !isset($company->reg_date->EditAttrs["readonly"]) && !isset($company->reg_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fcompanyaddopt", "x_reg_date", {"ignoreReadonly":true,"useCurrent":false,"format":1});
</script>
<?php } ?>
</div>
	</div>
<?php } ?>
<?php if ($company->country_id->Visible) { // country_id ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_country_id"><?php echo $company->country_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10">
<?php $company->country_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$company->country_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_country_id"><?php echo (strval($company->country_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $company->country_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($company->country_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_country_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($company->country_id->ReadOnly || $company->country_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="company" data-field="x_country_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $company->country_id->DisplayValueSeparatorAttribute() ?>" name="x_country_id" id="x_country_id" value="<?php echo $company->country_id->CurrentValue ?>"<?php echo $company->country_id->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($company->province_id->Visible) { // province_id ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_province_id"><?php echo $company->province_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_province_id"><?php echo (strval($company->province_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $company->province_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($company->province_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_province_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($company->province_id->ReadOnly || $company->province_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="company" data-field="x_province_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $company->province_id->DisplayValueSeparatorAttribute() ?>" name="x_province_id" id="x_province_id" value="<?php echo $company->province_id->CurrentValue ?>"<?php echo $company->province_id->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
</form>
<script type="text/javascript">
fcompanyaddopt.Init();
</script>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$company_addopt->Page_Terminate();
?>

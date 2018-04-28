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

$province_add = NULL; // Initialize page object first

class cprovince_add extends cprovince {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'province';

	// Page object name
	var $PageObjName = 'province_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("provincelist.php"));
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "provinceview.php")
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
			if (@$_GET["province_id"] != "") {
				$this->province_id->setQueryStringValue($_GET["province_id"]);
				$this->setKey("province_id", $this->province_id->CurrentValue); // Set up key
			} else {
				$this->setKey("province_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
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
					$this->Page_Terminate("provincelist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "provincelist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "provinceview.php")
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
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

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
		$this->province_id->CurrentValue = NULL;
		$this->province_id->OldValue = $this->province_id->CurrentValue;
		$this->country_id->CurrentValue = NULL;
		$this->country_id->OldValue = $this->country_id->CurrentValue;
		$this->province_name_kh->CurrentValue = NULL;
		$this->province_name_kh->OldValue = $this->province_name_kh->CurrentValue;
		$this->province_name_en->CurrentValue = NULL;
		$this->province_name_en->OldValue = $this->province_name_en->CurrentValue;
		$this->capital_kh->CurrentValue = NULL;
		$this->capital_kh->OldValue = $this->capital_kh->CurrentValue;
		$this->capital_en->CurrentValue = NULL;
		$this->capital_en->OldValue = $this->capital_en->CurrentValue;
		$this->population_kh->CurrentValue = NULL;
		$this->population_kh->OldValue = $this->population_kh->CurrentValue;
		$this->population_en->CurrentValue = NULL;
		$this->population_en->OldValue = $this->population_en->CurrentValue;
		$this->area_kh->CurrentValue = NULL;
		$this->area_kh->OldValue = $this->area_kh->CurrentValue;
		$this->area_en->CurrentValue = NULL;
		$this->area_en->OldValue = $this->area_en->CurrentValue;
		$this->density_kh->CurrentValue = NULL;
		$this->density_kh->OldValue = $this->density_kh->CurrentValue;
		$this->density_en->CurrentValue = NULL;
		$this->density_en->OldValue = $this->density_en->CurrentValue;
		$this->province_code->CurrentValue = NULL;
		$this->province_code->OldValue = $this->province_code->CurrentValue;
		$this->image->CurrentValue = NULL;
		$this->image->OldValue = $this->image->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->country_id->FldIsDetailKey) {
			$this->country_id->setFormValue($objForm->GetValue("x_country_id"));
		}
		if (!$this->province_name_kh->FldIsDetailKey) {
			$this->province_name_kh->setFormValue($objForm->GetValue("x_province_name_kh"));
		}
		if (!$this->province_name_en->FldIsDetailKey) {
			$this->province_name_en->setFormValue($objForm->GetValue("x_province_name_en"));
		}
		if (!$this->capital_kh->FldIsDetailKey) {
			$this->capital_kh->setFormValue($objForm->GetValue("x_capital_kh"));
		}
		if (!$this->capital_en->FldIsDetailKey) {
			$this->capital_en->setFormValue($objForm->GetValue("x_capital_en"));
		}
		if (!$this->population_kh->FldIsDetailKey) {
			$this->population_kh->setFormValue($objForm->GetValue("x_population_kh"));
		}
		if (!$this->population_en->FldIsDetailKey) {
			$this->population_en->setFormValue($objForm->GetValue("x_population_en"));
		}
		if (!$this->area_kh->FldIsDetailKey) {
			$this->area_kh->setFormValue($objForm->GetValue("x_area_kh"));
		}
		if (!$this->area_en->FldIsDetailKey) {
			$this->area_en->setFormValue($objForm->GetValue("x_area_en"));
		}
		if (!$this->density_kh->FldIsDetailKey) {
			$this->density_kh->setFormValue($objForm->GetValue("x_density_kh"));
		}
		if (!$this->density_en->FldIsDetailKey) {
			$this->density_en->setFormValue($objForm->GetValue("x_density_en"));
		}
		if (!$this->province_code->FldIsDetailKey) {
			$this->province_code->setFormValue($objForm->GetValue("x_province_code"));
		}
		if (!$this->image->FldIsDetailKey) {
			$this->image->setFormValue($objForm->GetValue("x_image"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->country_id->CurrentValue = $this->country_id->FormValue;
		$this->province_name_kh->CurrentValue = $this->province_name_kh->FormValue;
		$this->province_name_en->CurrentValue = $this->province_name_en->FormValue;
		$this->capital_kh->CurrentValue = $this->capital_kh->FormValue;
		$this->capital_en->CurrentValue = $this->capital_en->FormValue;
		$this->population_kh->CurrentValue = $this->population_kh->FormValue;
		$this->population_en->CurrentValue = $this->population_en->FormValue;
		$this->area_kh->CurrentValue = $this->area_kh->FormValue;
		$this->area_en->CurrentValue = $this->area_en->FormValue;
		$this->density_kh->CurrentValue = $this->density_kh->FormValue;
		$this->density_en->CurrentValue = $this->density_en->FormValue;
		$this->province_code->CurrentValue = $this->province_code->FormValue;
		$this->image->CurrentValue = $this->image->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['province_id'] = $this->province_id->CurrentValue;
		$row['country_id'] = $this->country_id->CurrentValue;
		$row['province_name_kh'] = $this->province_name_kh->CurrentValue;
		$row['province_name_en'] = $this->province_name_en->CurrentValue;
		$row['capital_kh'] = $this->capital_kh->CurrentValue;
		$row['capital_en'] = $this->capital_en->CurrentValue;
		$row['population_kh'] = $this->population_kh->CurrentValue;
		$row['population_en'] = $this->population_en->CurrentValue;
		$row['area_kh'] = $this->area_kh->CurrentValue;
		$row['area_en'] = $this->area_en->CurrentValue;
		$row['density_kh'] = $this->density_kh->CurrentValue;
		$row['density_en'] = $this->density_en->CurrentValue;
		$row['province_code'] = $this->province_code->CurrentValue;
		$row['image'] = $this->image->CurrentValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("province_id")) <> "")
			$this->province_id->CurrentValue = $this->getKey("province_id"); // province_id
		else
			$bValidKey = FALSE;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// country_id
			$this->country_id->EditAttrs["class"] = "form-control";
			$this->country_id->EditCustomAttributes = "";
			$this->country_id->EditValue = ew_HtmlEncode($this->country_id->CurrentValue);
			$this->country_id->PlaceHolder = ew_RemoveHtml($this->country_id->FldCaption());

			// province_name_kh
			$this->province_name_kh->EditAttrs["class"] = "form-control";
			$this->province_name_kh->EditCustomAttributes = "";
			$this->province_name_kh->EditValue = ew_HtmlEncode($this->province_name_kh->CurrentValue);
			$this->province_name_kh->PlaceHolder = ew_RemoveHtml($this->province_name_kh->FldCaption());

			// province_name_en
			$this->province_name_en->EditAttrs["class"] = "form-control";
			$this->province_name_en->EditCustomAttributes = "";
			$this->province_name_en->EditValue = ew_HtmlEncode($this->province_name_en->CurrentValue);
			$this->province_name_en->PlaceHolder = ew_RemoveHtml($this->province_name_en->FldCaption());

			// capital_kh
			$this->capital_kh->EditAttrs["class"] = "form-control";
			$this->capital_kh->EditCustomAttributes = "";
			$this->capital_kh->EditValue = ew_HtmlEncode($this->capital_kh->CurrentValue);
			$this->capital_kh->PlaceHolder = ew_RemoveHtml($this->capital_kh->FldCaption());

			// capital_en
			$this->capital_en->EditAttrs["class"] = "form-control";
			$this->capital_en->EditCustomAttributes = "";
			$this->capital_en->EditValue = ew_HtmlEncode($this->capital_en->CurrentValue);
			$this->capital_en->PlaceHolder = ew_RemoveHtml($this->capital_en->FldCaption());

			// population_kh
			$this->population_kh->EditAttrs["class"] = "form-control";
			$this->population_kh->EditCustomAttributes = "";
			$this->population_kh->EditValue = ew_HtmlEncode($this->population_kh->CurrentValue);
			$this->population_kh->PlaceHolder = ew_RemoveHtml($this->population_kh->FldCaption());

			// population_en
			$this->population_en->EditAttrs["class"] = "form-control";
			$this->population_en->EditCustomAttributes = "";
			$this->population_en->EditValue = ew_HtmlEncode($this->population_en->CurrentValue);
			$this->population_en->PlaceHolder = ew_RemoveHtml($this->population_en->FldCaption());

			// area_kh
			$this->area_kh->EditAttrs["class"] = "form-control";
			$this->area_kh->EditCustomAttributes = "";
			$this->area_kh->EditValue = ew_HtmlEncode($this->area_kh->CurrentValue);
			$this->area_kh->PlaceHolder = ew_RemoveHtml($this->area_kh->FldCaption());

			// area_en
			$this->area_en->EditAttrs["class"] = "form-control";
			$this->area_en->EditCustomAttributes = "";
			$this->area_en->EditValue = ew_HtmlEncode($this->area_en->CurrentValue);
			$this->area_en->PlaceHolder = ew_RemoveHtml($this->area_en->FldCaption());

			// density_kh
			$this->density_kh->EditAttrs["class"] = "form-control";
			$this->density_kh->EditCustomAttributes = "";
			$this->density_kh->EditValue = ew_HtmlEncode($this->density_kh->CurrentValue);
			$this->density_kh->PlaceHolder = ew_RemoveHtml($this->density_kh->FldCaption());

			// density_en
			$this->density_en->EditAttrs["class"] = "form-control";
			$this->density_en->EditCustomAttributes = "";
			$this->density_en->EditValue = ew_HtmlEncode($this->density_en->CurrentValue);
			$this->density_en->PlaceHolder = ew_RemoveHtml($this->density_en->FldCaption());

			// province_code
			$this->province_code->EditAttrs["class"] = "form-control";
			$this->province_code->EditCustomAttributes = "";
			$this->province_code->EditValue = ew_HtmlEncode($this->province_code->CurrentValue);
			$this->province_code->PlaceHolder = ew_RemoveHtml($this->province_code->FldCaption());

			// image
			$this->image->EditAttrs["class"] = "form-control";
			$this->image->EditCustomAttributes = "";
			$this->image->EditValue = ew_HtmlEncode($this->image->CurrentValue);
			$this->image->PlaceHolder = ew_RemoveHtml($this->image->FldCaption());

			// Add refer script
			// country_id

			$this->country_id->LinkCustomAttributes = "";
			$this->country_id->HrefValue = "";

			// province_name_kh
			$this->province_name_kh->LinkCustomAttributes = "";
			$this->province_name_kh->HrefValue = "";

			// province_name_en
			$this->province_name_en->LinkCustomAttributes = "";
			$this->province_name_en->HrefValue = "";

			// capital_kh
			$this->capital_kh->LinkCustomAttributes = "";
			$this->capital_kh->HrefValue = "";

			// capital_en
			$this->capital_en->LinkCustomAttributes = "";
			$this->capital_en->HrefValue = "";

			// population_kh
			$this->population_kh->LinkCustomAttributes = "";
			$this->population_kh->HrefValue = "";

			// population_en
			$this->population_en->LinkCustomAttributes = "";
			$this->population_en->HrefValue = "";

			// area_kh
			$this->area_kh->LinkCustomAttributes = "";
			$this->area_kh->HrefValue = "";

			// area_en
			$this->area_en->LinkCustomAttributes = "";
			$this->area_en->HrefValue = "";

			// density_kh
			$this->density_kh->LinkCustomAttributes = "";
			$this->density_kh->HrefValue = "";

			// density_en
			$this->density_en->LinkCustomAttributes = "";
			$this->density_en->HrefValue = "";

			// province_code
			$this->province_code->LinkCustomAttributes = "";
			$this->province_code->HrefValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";
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
		if (!$this->country_id->FldIsDetailKey && !is_null($this->country_id->FormValue) && $this->country_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->country_id->FldCaption(), $this->country_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->country_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->country_id->FldErrMsg());
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
		}
		$rsnew = array();

		// country_id
		$this->country_id->SetDbValueDef($rsnew, $this->country_id->CurrentValue, 0, FALSE);

		// province_name_kh
		$this->province_name_kh->SetDbValueDef($rsnew, $this->province_name_kh->CurrentValue, NULL, FALSE);

		// province_name_en
		$this->province_name_en->SetDbValueDef($rsnew, $this->province_name_en->CurrentValue, NULL, FALSE);

		// capital_kh
		$this->capital_kh->SetDbValueDef($rsnew, $this->capital_kh->CurrentValue, NULL, FALSE);

		// capital_en
		$this->capital_en->SetDbValueDef($rsnew, $this->capital_en->CurrentValue, NULL, FALSE);

		// population_kh
		$this->population_kh->SetDbValueDef($rsnew, $this->population_kh->CurrentValue, NULL, FALSE);

		// population_en
		$this->population_en->SetDbValueDef($rsnew, $this->population_en->CurrentValue, NULL, FALSE);

		// area_kh
		$this->area_kh->SetDbValueDef($rsnew, $this->area_kh->CurrentValue, NULL, FALSE);

		// area_en
		$this->area_en->SetDbValueDef($rsnew, $this->area_en->CurrentValue, NULL, FALSE);

		// density_kh
		$this->density_kh->SetDbValueDef($rsnew, $this->density_kh->CurrentValue, NULL, FALSE);

		// density_en
		$this->density_en->SetDbValueDef($rsnew, $this->density_en->CurrentValue, NULL, FALSE);

		// province_code
		$this->province_code->SetDbValueDef($rsnew, $this->province_code->CurrentValue, NULL, FALSE);

		// image
		$this->image->SetDbValueDef($rsnew, $this->image->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['country_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("provincelist.php"), "", $this->TableVar, TRUE);
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
if (!isset($province_add)) $province_add = new cprovince_add();

// Page init
$province_add->Page_Init();

// Page main
$province_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$province_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fprovinceadd = new ew_Form("fprovinceadd", "add");

// Validate form
fprovinceadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_country_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $province->country_id->FldCaption(), $province->country_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_country_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($province->country_id->FldErrMsg()) ?>");

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
fprovinceadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fprovinceadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $province_add->ShowPageHeader(); ?>
<?php
$province_add->ShowMessage();
?>
<form name="fprovinceadd" id="fprovinceadd" class="<?php echo $province_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($province_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $province_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="province">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($province_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($province->country_id->Visible) { // country_id ?>
	<div id="r_country_id" class="form-group">
		<label id="elh_province_country_id" for="x_country_id" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->country_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->country_id->CellAttributes() ?>>
<span id="el_province_country_id">
<input type="text" data-table="province" data-field="x_country_id" name="x_country_id" id="x_country_id" size="30" placeholder="<?php echo ew_HtmlEncode($province->country_id->getPlaceHolder()) ?>" value="<?php echo $province->country_id->EditValue ?>"<?php echo $province->country_id->EditAttributes() ?>>
</span>
<?php echo $province->country_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->province_name_kh->Visible) { // province_name_kh ?>
	<div id="r_province_name_kh" class="form-group">
		<label id="elh_province_province_name_kh" for="x_province_name_kh" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->province_name_kh->FldCaption() ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->province_name_kh->CellAttributes() ?>>
<span id="el_province_province_name_kh">
<input type="text" data-table="province" data-field="x_province_name_kh" name="x_province_name_kh" id="x_province_name_kh" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->province_name_kh->getPlaceHolder()) ?>" value="<?php echo $province->province_name_kh->EditValue ?>"<?php echo $province->province_name_kh->EditAttributes() ?>>
</span>
<?php echo $province->province_name_kh->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->province_name_en->Visible) { // province_name_en ?>
	<div id="r_province_name_en" class="form-group">
		<label id="elh_province_province_name_en" for="x_province_name_en" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->province_name_en->FldCaption() ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->province_name_en->CellAttributes() ?>>
<span id="el_province_province_name_en">
<input type="text" data-table="province" data-field="x_province_name_en" name="x_province_name_en" id="x_province_name_en" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->province_name_en->getPlaceHolder()) ?>" value="<?php echo $province->province_name_en->EditValue ?>"<?php echo $province->province_name_en->EditAttributes() ?>>
</span>
<?php echo $province->province_name_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->capital_kh->Visible) { // capital_kh ?>
	<div id="r_capital_kh" class="form-group">
		<label id="elh_province_capital_kh" for="x_capital_kh" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->capital_kh->FldCaption() ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->capital_kh->CellAttributes() ?>>
<span id="el_province_capital_kh">
<input type="text" data-table="province" data-field="x_capital_kh" name="x_capital_kh" id="x_capital_kh" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->capital_kh->getPlaceHolder()) ?>" value="<?php echo $province->capital_kh->EditValue ?>"<?php echo $province->capital_kh->EditAttributes() ?>>
</span>
<?php echo $province->capital_kh->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->capital_en->Visible) { // capital_en ?>
	<div id="r_capital_en" class="form-group">
		<label id="elh_province_capital_en" for="x_capital_en" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->capital_en->FldCaption() ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->capital_en->CellAttributes() ?>>
<span id="el_province_capital_en">
<input type="text" data-table="province" data-field="x_capital_en" name="x_capital_en" id="x_capital_en" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->capital_en->getPlaceHolder()) ?>" value="<?php echo $province->capital_en->EditValue ?>"<?php echo $province->capital_en->EditAttributes() ?>>
</span>
<?php echo $province->capital_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->population_kh->Visible) { // population_kh ?>
	<div id="r_population_kh" class="form-group">
		<label id="elh_province_population_kh" for="x_population_kh" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->population_kh->FldCaption() ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->population_kh->CellAttributes() ?>>
<span id="el_province_population_kh">
<input type="text" data-table="province" data-field="x_population_kh" name="x_population_kh" id="x_population_kh" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->population_kh->getPlaceHolder()) ?>" value="<?php echo $province->population_kh->EditValue ?>"<?php echo $province->population_kh->EditAttributes() ?>>
</span>
<?php echo $province->population_kh->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->population_en->Visible) { // population_en ?>
	<div id="r_population_en" class="form-group">
		<label id="elh_province_population_en" for="x_population_en" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->population_en->FldCaption() ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->population_en->CellAttributes() ?>>
<span id="el_province_population_en">
<input type="text" data-table="province" data-field="x_population_en" name="x_population_en" id="x_population_en" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->population_en->getPlaceHolder()) ?>" value="<?php echo $province->population_en->EditValue ?>"<?php echo $province->population_en->EditAttributes() ?>>
</span>
<?php echo $province->population_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->area_kh->Visible) { // area_kh ?>
	<div id="r_area_kh" class="form-group">
		<label id="elh_province_area_kh" for="x_area_kh" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->area_kh->FldCaption() ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->area_kh->CellAttributes() ?>>
<span id="el_province_area_kh">
<input type="text" data-table="province" data-field="x_area_kh" name="x_area_kh" id="x_area_kh" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->area_kh->getPlaceHolder()) ?>" value="<?php echo $province->area_kh->EditValue ?>"<?php echo $province->area_kh->EditAttributes() ?>>
</span>
<?php echo $province->area_kh->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->area_en->Visible) { // area_en ?>
	<div id="r_area_en" class="form-group">
		<label id="elh_province_area_en" for="x_area_en" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->area_en->FldCaption() ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->area_en->CellAttributes() ?>>
<span id="el_province_area_en">
<input type="text" data-table="province" data-field="x_area_en" name="x_area_en" id="x_area_en" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->area_en->getPlaceHolder()) ?>" value="<?php echo $province->area_en->EditValue ?>"<?php echo $province->area_en->EditAttributes() ?>>
</span>
<?php echo $province->area_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->density_kh->Visible) { // density_kh ?>
	<div id="r_density_kh" class="form-group">
		<label id="elh_province_density_kh" for="x_density_kh" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->density_kh->FldCaption() ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->density_kh->CellAttributes() ?>>
<span id="el_province_density_kh">
<input type="text" data-table="province" data-field="x_density_kh" name="x_density_kh" id="x_density_kh" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->density_kh->getPlaceHolder()) ?>" value="<?php echo $province->density_kh->EditValue ?>"<?php echo $province->density_kh->EditAttributes() ?>>
</span>
<?php echo $province->density_kh->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->density_en->Visible) { // density_en ?>
	<div id="r_density_en" class="form-group">
		<label id="elh_province_density_en" for="x_density_en" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->density_en->FldCaption() ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->density_en->CellAttributes() ?>>
<span id="el_province_density_en">
<input type="text" data-table="province" data-field="x_density_en" name="x_density_en" id="x_density_en" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->density_en->getPlaceHolder()) ?>" value="<?php echo $province->density_en->EditValue ?>"<?php echo $province->density_en->EditAttributes() ?>>
</span>
<?php echo $province->density_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->province_code->Visible) { // province_code ?>
	<div id="r_province_code" class="form-group">
		<label id="elh_province_province_code" for="x_province_code" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->province_code->FldCaption() ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->province_code->CellAttributes() ?>>
<span id="el_province_province_code">
<input type="text" data-table="province" data-field="x_province_code" name="x_province_code" id="x_province_code" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->province_code->getPlaceHolder()) ?>" value="<?php echo $province->province_code->EditValue ?>"<?php echo $province->province_code->EditAttributes() ?>>
</span>
<?php echo $province->province_code->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->image->Visible) { // image ?>
	<div id="r_image" class="form-group">
		<label id="elh_province_image" for="x_image" class="<?php echo $province_add->LeftColumnClass ?>"><?php echo $province->image->FldCaption() ?></label>
		<div class="<?php echo $province_add->RightColumnClass ?>"><div<?php echo $province->image->CellAttributes() ?>>
<span id="el_province_image">
<input type="text" data-table="province" data-field="x_image" name="x_image" id="x_image" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->image->getPlaceHolder()) ?>" value="<?php echo $province->image->EditValue ?>"<?php echo $province->image->EditAttributes() ?>>
</span>
<?php echo $province->image->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$province_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $province_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $province_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fprovinceadd.Init();
</script>
<?php
$province_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$province_add->Page_Terminate();
?>

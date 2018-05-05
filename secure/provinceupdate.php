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

$province_update = NULL; // Initialize page object first

class cprovince_update extends cprovince {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'province';

	// Page object name
	var $PageObjName = 'province_update';

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
			define("EW_PAGE_ID", 'update', TRUE);

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
		if (!$Security->CanEdit()) {
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
			$this->Page_Terminate("provincelist.php"); // No records selected, return to list
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
					$this->country_id->setDbValue($this->Recordset->fields('country_id'));
					$this->province_name_kh->setDbValue($this->Recordset->fields('province_name_kh'));
					$this->province_name_en->setDbValue($this->Recordset->fields('province_name_en'));
					$this->capital_kh->setDbValue($this->Recordset->fields('capital_kh'));
					$this->capital_en->setDbValue($this->Recordset->fields('capital_en'));
					$this->population_kh->setDbValue($this->Recordset->fields('population_kh'));
					$this->population_en->setDbValue($this->Recordset->fields('population_en'));
					$this->area_kh->setDbValue($this->Recordset->fields('area_kh'));
					$this->area_en->setDbValue($this->Recordset->fields('area_en'));
					$this->density_kh->setDbValue($this->Recordset->fields('density_kh'));
					$this->density_en->setDbValue($this->Recordset->fields('density_en'));
					$this->province_code->setDbValue($this->Recordset->fields('province_code'));
					$this->image->setDbValue($this->Recordset->fields('image'));
				} else {
					if (!ew_CompareValue($this->country_id->DbValue, $this->Recordset->fields('country_id')))
						$this->country_id->CurrentValue = NULL;
					if (!ew_CompareValue($this->province_name_kh->DbValue, $this->Recordset->fields('province_name_kh')))
						$this->province_name_kh->CurrentValue = NULL;
					if (!ew_CompareValue($this->province_name_en->DbValue, $this->Recordset->fields('province_name_en')))
						$this->province_name_en->CurrentValue = NULL;
					if (!ew_CompareValue($this->capital_kh->DbValue, $this->Recordset->fields('capital_kh')))
						$this->capital_kh->CurrentValue = NULL;
					if (!ew_CompareValue($this->capital_en->DbValue, $this->Recordset->fields('capital_en')))
						$this->capital_en->CurrentValue = NULL;
					if (!ew_CompareValue($this->population_kh->DbValue, $this->Recordset->fields('population_kh')))
						$this->population_kh->CurrentValue = NULL;
					if (!ew_CompareValue($this->population_en->DbValue, $this->Recordset->fields('population_en')))
						$this->population_en->CurrentValue = NULL;
					if (!ew_CompareValue($this->area_kh->DbValue, $this->Recordset->fields('area_kh')))
						$this->area_kh->CurrentValue = NULL;
					if (!ew_CompareValue($this->area_en->DbValue, $this->Recordset->fields('area_en')))
						$this->area_en->CurrentValue = NULL;
					if (!ew_CompareValue($this->density_kh->DbValue, $this->Recordset->fields('density_kh')))
						$this->density_kh->CurrentValue = NULL;
					if (!ew_CompareValue($this->density_en->DbValue, $this->Recordset->fields('density_en')))
						$this->density_en->CurrentValue = NULL;
					if (!ew_CompareValue($this->province_code->DbValue, $this->Recordset->fields('province_code')))
						$this->province_code->CurrentValue = NULL;
					if (!ew_CompareValue($this->image->DbValue, $this->Recordset->fields('image')))
						$this->image->CurrentValue = NULL;
				}
				$i++;
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
		}
	}

	// Set up key value
	function SetupKeyValues($key) {
		if (count($key) <> 2)
			return FALSE;
		$sKeyFld = $key[0];
		if (!is_numeric($sKeyFld))
			return FALSE;
		$this->province_id->CurrentValue = $sKeyFld;
		$sKeyFld = $key[1];
		if (!is_numeric($sKeyFld))
			return FALSE;
		$this->country_id->CurrentValue = $sKeyFld;
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
				$sThisKey = implode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
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
		if (!$this->country_id->FldIsDetailKey) {
			$this->country_id->setFormValue($objForm->GetValue("x_country_id"));
		}
		$this->country_id->MultiUpdate = $objForm->GetValue("u_country_id");
		if (!$this->province_name_kh->FldIsDetailKey) {
			$this->province_name_kh->setFormValue($objForm->GetValue("x_province_name_kh"));
		}
		$this->province_name_kh->MultiUpdate = $objForm->GetValue("u_province_name_kh");
		if (!$this->province_name_en->FldIsDetailKey) {
			$this->province_name_en->setFormValue($objForm->GetValue("x_province_name_en"));
		}
		$this->province_name_en->MultiUpdate = $objForm->GetValue("u_province_name_en");
		if (!$this->capital_kh->FldIsDetailKey) {
			$this->capital_kh->setFormValue($objForm->GetValue("x_capital_kh"));
		}
		$this->capital_kh->MultiUpdate = $objForm->GetValue("u_capital_kh");
		if (!$this->capital_en->FldIsDetailKey) {
			$this->capital_en->setFormValue($objForm->GetValue("x_capital_en"));
		}
		$this->capital_en->MultiUpdate = $objForm->GetValue("u_capital_en");
		if (!$this->population_kh->FldIsDetailKey) {
			$this->population_kh->setFormValue($objForm->GetValue("x_population_kh"));
		}
		$this->population_kh->MultiUpdate = $objForm->GetValue("u_population_kh");
		if (!$this->population_en->FldIsDetailKey) {
			$this->population_en->setFormValue($objForm->GetValue("x_population_en"));
		}
		$this->population_en->MultiUpdate = $objForm->GetValue("u_population_en");
		if (!$this->area_kh->FldIsDetailKey) {
			$this->area_kh->setFormValue($objForm->GetValue("x_area_kh"));
		}
		$this->area_kh->MultiUpdate = $objForm->GetValue("u_area_kh");
		if (!$this->area_en->FldIsDetailKey) {
			$this->area_en->setFormValue($objForm->GetValue("x_area_en"));
		}
		$this->area_en->MultiUpdate = $objForm->GetValue("u_area_en");
		if (!$this->density_kh->FldIsDetailKey) {
			$this->density_kh->setFormValue($objForm->GetValue("x_density_kh"));
		}
		$this->density_kh->MultiUpdate = $objForm->GetValue("u_density_kh");
		if (!$this->density_en->FldIsDetailKey) {
			$this->density_en->setFormValue($objForm->GetValue("x_density_en"));
		}
		$this->density_en->MultiUpdate = $objForm->GetValue("u_density_en");
		if (!$this->province_code->FldIsDetailKey) {
			$this->province_code->setFormValue($objForm->GetValue("x_province_code"));
		}
		$this->province_code->MultiUpdate = $objForm->GetValue("u_province_code");
		if (!$this->image->FldIsDetailKey) {
			$this->image->setFormValue($objForm->GetValue("x_image"));
		}
		$this->image->MultiUpdate = $objForm->GetValue("u_image");
		if (!$this->province_id->FldIsDetailKey)
			$this->province_id->setFormValue($objForm->GetValue("x_province_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->province_id->CurrentValue = $this->province_id->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// country_id
			$this->country_id->EditAttrs["class"] = "form-control";
			$this->country_id->EditCustomAttributes = "";
			$this->country_id->EditValue = $this->country_id->CurrentValue;
			$this->country_id->ViewCustomAttributes = "";

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

			// Edit refer script
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
		$lUpdateCnt = 0;
		if ($this->country_id->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->province_name_kh->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->province_name_en->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->capital_kh->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->capital_en->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->population_kh->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->population_en->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->area_kh->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->area_en->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->density_kh->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->density_en->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->province_code->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->image->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->country_id->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->country_id->FormValue)) {
				ew_AddMessage($gsFormError, $this->country_id->FldErrMsg());
			}
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

			// country_id
			// province_name_kh

			$this->province_name_kh->SetDbValueDef($rsnew, $this->province_name_kh->CurrentValue, NULL, $this->province_name_kh->ReadOnly || $this->province_name_kh->MultiUpdate <> "1");

			// province_name_en
			$this->province_name_en->SetDbValueDef($rsnew, $this->province_name_en->CurrentValue, NULL, $this->province_name_en->ReadOnly || $this->province_name_en->MultiUpdate <> "1");

			// capital_kh
			$this->capital_kh->SetDbValueDef($rsnew, $this->capital_kh->CurrentValue, NULL, $this->capital_kh->ReadOnly || $this->capital_kh->MultiUpdate <> "1");

			// capital_en
			$this->capital_en->SetDbValueDef($rsnew, $this->capital_en->CurrentValue, NULL, $this->capital_en->ReadOnly || $this->capital_en->MultiUpdate <> "1");

			// population_kh
			$this->population_kh->SetDbValueDef($rsnew, $this->population_kh->CurrentValue, NULL, $this->population_kh->ReadOnly || $this->population_kh->MultiUpdate <> "1");

			// population_en
			$this->population_en->SetDbValueDef($rsnew, $this->population_en->CurrentValue, NULL, $this->population_en->ReadOnly || $this->population_en->MultiUpdate <> "1");

			// area_kh
			$this->area_kh->SetDbValueDef($rsnew, $this->area_kh->CurrentValue, NULL, $this->area_kh->ReadOnly || $this->area_kh->MultiUpdate <> "1");

			// area_en
			$this->area_en->SetDbValueDef($rsnew, $this->area_en->CurrentValue, NULL, $this->area_en->ReadOnly || $this->area_en->MultiUpdate <> "1");

			// density_kh
			$this->density_kh->SetDbValueDef($rsnew, $this->density_kh->CurrentValue, NULL, $this->density_kh->ReadOnly || $this->density_kh->MultiUpdate <> "1");

			// density_en
			$this->density_en->SetDbValueDef($rsnew, $this->density_en->CurrentValue, NULL, $this->density_en->ReadOnly || $this->density_en->MultiUpdate <> "1");

			// province_code
			$this->province_code->SetDbValueDef($rsnew, $this->province_code->CurrentValue, NULL, $this->province_code->ReadOnly || $this->province_code->MultiUpdate <> "1");

			// image
			$this->image->SetDbValueDef($rsnew, $this->image->CurrentValue, NULL, $this->image->ReadOnly || $this->image->MultiUpdate <> "1");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("provincelist.php"), "", $this->TableVar, TRUE);
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
if (!isset($province_update)) $province_update = new cprovince_update();

// Page init
$province_update->Page_Init();

// Page main
$province_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$province_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = fprovinceupdate = new ew_Form("fprovinceupdate", "update");

// Validate form
fprovinceupdate.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_country_id");
			uelm = this.GetElements("u" + infix + "_country_id");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($province->country_id->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fprovinceupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fprovinceupdate.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $province_update->ShowPageHeader(); ?>
<?php
$province_update->ShowMessage();
?>
<form name="fprovinceupdate" id="fprovinceupdate" class="<?php echo $province_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($province_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $province_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="province">
<?php if ($province->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_update" id="a_update" value="U">
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } else { ?>
<input type="hidden" name="a_update" id="a_update" value="F">
<?php } ?>
<input type="hidden" name="modal" value="<?php echo intval($province_update->IsModal) ?>">
<?php foreach ($province_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_provinceupdate" class="ewUpdateDiv"><!-- page -->
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"<?php echo $province_update->Disabled ?>> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($province->province_name_kh->Visible) { // province_name_kh ?>
	<div id="r_province_name_kh" class="form-group">
		<label for="x_province_name_kh" class="<?php echo $province_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($province->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_province_name_kh" id="u_province_name_kh" class="ewMultiSelect" value="1"<?php echo ($province->province_name_kh->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($province->province_name_kh->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_province_name_kh" id="u_province_name_kh" value="<?php echo $province->province_name_kh->MultiUpdate ?>">
<?php } ?>
 <?php echo $province->province_name_kh->FldCaption() ?></label></div></label>
		<div class="<?php echo $province_update->RightColumnClass ?>"><div<?php echo $province->province_name_kh->CellAttributes() ?>>
<?php if ($province->CurrentAction <> "F") { ?>
<span id="el_province_province_name_kh">
<input type="text" data-table="province" data-field="x_province_name_kh" name="x_province_name_kh" id="x_province_name_kh" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->province_name_kh->getPlaceHolder()) ?>" value="<?php echo $province->province_name_kh->EditValue ?>"<?php echo $province->province_name_kh->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_province_province_name_kh">
<span<?php echo $province->province_name_kh->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $province->province_name_kh->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="province" data-field="x_province_name_kh" name="x_province_name_kh" id="x_province_name_kh" value="<?php echo ew_HtmlEncode($province->province_name_kh->FormValue) ?>">
<?php } ?>
<?php echo $province->province_name_kh->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->province_name_en->Visible) { // province_name_en ?>
	<div id="r_province_name_en" class="form-group">
		<label for="x_province_name_en" class="<?php echo $province_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($province->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_province_name_en" id="u_province_name_en" class="ewMultiSelect" value="1"<?php echo ($province->province_name_en->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($province->province_name_en->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_province_name_en" id="u_province_name_en" value="<?php echo $province->province_name_en->MultiUpdate ?>">
<?php } ?>
 <?php echo $province->province_name_en->FldCaption() ?></label></div></label>
		<div class="<?php echo $province_update->RightColumnClass ?>"><div<?php echo $province->province_name_en->CellAttributes() ?>>
<?php if ($province->CurrentAction <> "F") { ?>
<span id="el_province_province_name_en">
<input type="text" data-table="province" data-field="x_province_name_en" name="x_province_name_en" id="x_province_name_en" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->province_name_en->getPlaceHolder()) ?>" value="<?php echo $province->province_name_en->EditValue ?>"<?php echo $province->province_name_en->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_province_province_name_en">
<span<?php echo $province->province_name_en->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $province->province_name_en->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="province" data-field="x_province_name_en" name="x_province_name_en" id="x_province_name_en" value="<?php echo ew_HtmlEncode($province->province_name_en->FormValue) ?>">
<?php } ?>
<?php echo $province->province_name_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->capital_kh->Visible) { // capital_kh ?>
	<div id="r_capital_kh" class="form-group">
		<label for="x_capital_kh" class="<?php echo $province_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($province->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_capital_kh" id="u_capital_kh" class="ewMultiSelect" value="1"<?php echo ($province->capital_kh->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($province->capital_kh->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_capital_kh" id="u_capital_kh" value="<?php echo $province->capital_kh->MultiUpdate ?>">
<?php } ?>
 <?php echo $province->capital_kh->FldCaption() ?></label></div></label>
		<div class="<?php echo $province_update->RightColumnClass ?>"><div<?php echo $province->capital_kh->CellAttributes() ?>>
<?php if ($province->CurrentAction <> "F") { ?>
<span id="el_province_capital_kh">
<input type="text" data-table="province" data-field="x_capital_kh" name="x_capital_kh" id="x_capital_kh" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->capital_kh->getPlaceHolder()) ?>" value="<?php echo $province->capital_kh->EditValue ?>"<?php echo $province->capital_kh->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_province_capital_kh">
<span<?php echo $province->capital_kh->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $province->capital_kh->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="province" data-field="x_capital_kh" name="x_capital_kh" id="x_capital_kh" value="<?php echo ew_HtmlEncode($province->capital_kh->FormValue) ?>">
<?php } ?>
<?php echo $province->capital_kh->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->capital_en->Visible) { // capital_en ?>
	<div id="r_capital_en" class="form-group">
		<label for="x_capital_en" class="<?php echo $province_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($province->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_capital_en" id="u_capital_en" class="ewMultiSelect" value="1"<?php echo ($province->capital_en->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($province->capital_en->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_capital_en" id="u_capital_en" value="<?php echo $province->capital_en->MultiUpdate ?>">
<?php } ?>
 <?php echo $province->capital_en->FldCaption() ?></label></div></label>
		<div class="<?php echo $province_update->RightColumnClass ?>"><div<?php echo $province->capital_en->CellAttributes() ?>>
<?php if ($province->CurrentAction <> "F") { ?>
<span id="el_province_capital_en">
<input type="text" data-table="province" data-field="x_capital_en" name="x_capital_en" id="x_capital_en" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->capital_en->getPlaceHolder()) ?>" value="<?php echo $province->capital_en->EditValue ?>"<?php echo $province->capital_en->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_province_capital_en">
<span<?php echo $province->capital_en->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $province->capital_en->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="province" data-field="x_capital_en" name="x_capital_en" id="x_capital_en" value="<?php echo ew_HtmlEncode($province->capital_en->FormValue) ?>">
<?php } ?>
<?php echo $province->capital_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->population_kh->Visible) { // population_kh ?>
	<div id="r_population_kh" class="form-group">
		<label for="x_population_kh" class="<?php echo $province_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($province->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_population_kh" id="u_population_kh" class="ewMultiSelect" value="1"<?php echo ($province->population_kh->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($province->population_kh->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_population_kh" id="u_population_kh" value="<?php echo $province->population_kh->MultiUpdate ?>">
<?php } ?>
 <?php echo $province->population_kh->FldCaption() ?></label></div></label>
		<div class="<?php echo $province_update->RightColumnClass ?>"><div<?php echo $province->population_kh->CellAttributes() ?>>
<?php if ($province->CurrentAction <> "F") { ?>
<span id="el_province_population_kh">
<input type="text" data-table="province" data-field="x_population_kh" name="x_population_kh" id="x_population_kh" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->population_kh->getPlaceHolder()) ?>" value="<?php echo $province->population_kh->EditValue ?>"<?php echo $province->population_kh->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_province_population_kh">
<span<?php echo $province->population_kh->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $province->population_kh->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="province" data-field="x_population_kh" name="x_population_kh" id="x_population_kh" value="<?php echo ew_HtmlEncode($province->population_kh->FormValue) ?>">
<?php } ?>
<?php echo $province->population_kh->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->population_en->Visible) { // population_en ?>
	<div id="r_population_en" class="form-group">
		<label for="x_population_en" class="<?php echo $province_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($province->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_population_en" id="u_population_en" class="ewMultiSelect" value="1"<?php echo ($province->population_en->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($province->population_en->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_population_en" id="u_population_en" value="<?php echo $province->population_en->MultiUpdate ?>">
<?php } ?>
 <?php echo $province->population_en->FldCaption() ?></label></div></label>
		<div class="<?php echo $province_update->RightColumnClass ?>"><div<?php echo $province->population_en->CellAttributes() ?>>
<?php if ($province->CurrentAction <> "F") { ?>
<span id="el_province_population_en">
<input type="text" data-table="province" data-field="x_population_en" name="x_population_en" id="x_population_en" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->population_en->getPlaceHolder()) ?>" value="<?php echo $province->population_en->EditValue ?>"<?php echo $province->population_en->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_province_population_en">
<span<?php echo $province->population_en->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $province->population_en->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="province" data-field="x_population_en" name="x_population_en" id="x_population_en" value="<?php echo ew_HtmlEncode($province->population_en->FormValue) ?>">
<?php } ?>
<?php echo $province->population_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->area_kh->Visible) { // area_kh ?>
	<div id="r_area_kh" class="form-group">
		<label for="x_area_kh" class="<?php echo $province_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($province->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_area_kh" id="u_area_kh" class="ewMultiSelect" value="1"<?php echo ($province->area_kh->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($province->area_kh->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_area_kh" id="u_area_kh" value="<?php echo $province->area_kh->MultiUpdate ?>">
<?php } ?>
 <?php echo $province->area_kh->FldCaption() ?></label></div></label>
		<div class="<?php echo $province_update->RightColumnClass ?>"><div<?php echo $province->area_kh->CellAttributes() ?>>
<?php if ($province->CurrentAction <> "F") { ?>
<span id="el_province_area_kh">
<input type="text" data-table="province" data-field="x_area_kh" name="x_area_kh" id="x_area_kh" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->area_kh->getPlaceHolder()) ?>" value="<?php echo $province->area_kh->EditValue ?>"<?php echo $province->area_kh->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_province_area_kh">
<span<?php echo $province->area_kh->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $province->area_kh->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="province" data-field="x_area_kh" name="x_area_kh" id="x_area_kh" value="<?php echo ew_HtmlEncode($province->area_kh->FormValue) ?>">
<?php } ?>
<?php echo $province->area_kh->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->area_en->Visible) { // area_en ?>
	<div id="r_area_en" class="form-group">
		<label for="x_area_en" class="<?php echo $province_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($province->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_area_en" id="u_area_en" class="ewMultiSelect" value="1"<?php echo ($province->area_en->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($province->area_en->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_area_en" id="u_area_en" value="<?php echo $province->area_en->MultiUpdate ?>">
<?php } ?>
 <?php echo $province->area_en->FldCaption() ?></label></div></label>
		<div class="<?php echo $province_update->RightColumnClass ?>"><div<?php echo $province->area_en->CellAttributes() ?>>
<?php if ($province->CurrentAction <> "F") { ?>
<span id="el_province_area_en">
<input type="text" data-table="province" data-field="x_area_en" name="x_area_en" id="x_area_en" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->area_en->getPlaceHolder()) ?>" value="<?php echo $province->area_en->EditValue ?>"<?php echo $province->area_en->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_province_area_en">
<span<?php echo $province->area_en->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $province->area_en->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="province" data-field="x_area_en" name="x_area_en" id="x_area_en" value="<?php echo ew_HtmlEncode($province->area_en->FormValue) ?>">
<?php } ?>
<?php echo $province->area_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->density_kh->Visible) { // density_kh ?>
	<div id="r_density_kh" class="form-group">
		<label for="x_density_kh" class="<?php echo $province_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($province->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_density_kh" id="u_density_kh" class="ewMultiSelect" value="1"<?php echo ($province->density_kh->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($province->density_kh->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_density_kh" id="u_density_kh" value="<?php echo $province->density_kh->MultiUpdate ?>">
<?php } ?>
 <?php echo $province->density_kh->FldCaption() ?></label></div></label>
		<div class="<?php echo $province_update->RightColumnClass ?>"><div<?php echo $province->density_kh->CellAttributes() ?>>
<?php if ($province->CurrentAction <> "F") { ?>
<span id="el_province_density_kh">
<input type="text" data-table="province" data-field="x_density_kh" name="x_density_kh" id="x_density_kh" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->density_kh->getPlaceHolder()) ?>" value="<?php echo $province->density_kh->EditValue ?>"<?php echo $province->density_kh->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_province_density_kh">
<span<?php echo $province->density_kh->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $province->density_kh->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="province" data-field="x_density_kh" name="x_density_kh" id="x_density_kh" value="<?php echo ew_HtmlEncode($province->density_kh->FormValue) ?>">
<?php } ?>
<?php echo $province->density_kh->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->density_en->Visible) { // density_en ?>
	<div id="r_density_en" class="form-group">
		<label for="x_density_en" class="<?php echo $province_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($province->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_density_en" id="u_density_en" class="ewMultiSelect" value="1"<?php echo ($province->density_en->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($province->density_en->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_density_en" id="u_density_en" value="<?php echo $province->density_en->MultiUpdate ?>">
<?php } ?>
 <?php echo $province->density_en->FldCaption() ?></label></div></label>
		<div class="<?php echo $province_update->RightColumnClass ?>"><div<?php echo $province->density_en->CellAttributes() ?>>
<?php if ($province->CurrentAction <> "F") { ?>
<span id="el_province_density_en">
<input type="text" data-table="province" data-field="x_density_en" name="x_density_en" id="x_density_en" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->density_en->getPlaceHolder()) ?>" value="<?php echo $province->density_en->EditValue ?>"<?php echo $province->density_en->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_province_density_en">
<span<?php echo $province->density_en->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $province->density_en->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="province" data-field="x_density_en" name="x_density_en" id="x_density_en" value="<?php echo ew_HtmlEncode($province->density_en->FormValue) ?>">
<?php } ?>
<?php echo $province->density_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->province_code->Visible) { // province_code ?>
	<div id="r_province_code" class="form-group">
		<label for="x_province_code" class="<?php echo $province_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($province->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_province_code" id="u_province_code" class="ewMultiSelect" value="1"<?php echo ($province->province_code->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($province->province_code->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_province_code" id="u_province_code" value="<?php echo $province->province_code->MultiUpdate ?>">
<?php } ?>
 <?php echo $province->province_code->FldCaption() ?></label></div></label>
		<div class="<?php echo $province_update->RightColumnClass ?>"><div<?php echo $province->province_code->CellAttributes() ?>>
<?php if ($province->CurrentAction <> "F") { ?>
<span id="el_province_province_code">
<input type="text" data-table="province" data-field="x_province_code" name="x_province_code" id="x_province_code" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->province_code->getPlaceHolder()) ?>" value="<?php echo $province->province_code->EditValue ?>"<?php echo $province->province_code->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_province_province_code">
<span<?php echo $province->province_code->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $province->province_code->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="province" data-field="x_province_code" name="x_province_code" id="x_province_code" value="<?php echo ew_HtmlEncode($province->province_code->FormValue) ?>">
<?php } ?>
<?php echo $province->province_code->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($province->image->Visible) { // image ?>
	<div id="r_image" class="form-group">
		<label for="x_image" class="<?php echo $province_update->LeftColumnClass ?>"><div class="checkbox"><label>
<?php if ($province->CurrentAction <> "F") { ?>
<input type="checkbox" name="u_image" id="u_image" class="ewMultiSelect" value="1"<?php echo ($province->image->MultiUpdate == "1") ? " checked" : "" ?>>
<?php } else { ?>
<input type="checkbox" disabled<?php echo ($province->image->MultiUpdate == "1") ? " checked" : "" ?>>
<input type="hidden" name="u_image" id="u_image" value="<?php echo $province->image->MultiUpdate ?>">
<?php } ?>
 <?php echo $province->image->FldCaption() ?></label></div></label>
		<div class="<?php echo $province_update->RightColumnClass ?>"><div<?php echo $province->image->CellAttributes() ?>>
<?php if ($province->CurrentAction <> "F") { ?>
<span id="el_province_image">
<input type="text" data-table="province" data-field="x_image" name="x_image" id="x_image" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($province->image->getPlaceHolder()) ?>" value="<?php echo $province->image->EditValue ?>"<?php echo $province->image->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_province_image">
<span<?php echo $province->image->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $province->image->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="province" data-field="x_image" name="x_image" id="x_image" value="<?php echo ew_HtmlEncode($province->image->FormValue) ?>">
<?php } ?>
<?php echo $province->image->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page -->
<?php if (!$province_update->IsModal) { ?>
	<div class="form-group"><!-- buttons .form-group -->
		<div class="<?php echo $province_update->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($province->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_update.value='F';"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $province_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_update.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
		</div><!-- /buttons offset -->
	</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fprovinceupdate.Init();
</script>
<?php
$province_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$province_update->Page_Terminate();
?>

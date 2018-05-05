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

$country_edit = NULL; // Initialize page object first

class ccountry_edit extends ccountry {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'country';

	// Page object name
	var $PageObjName = 'country_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		$this->country_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->country_id->Visible = FALSE;
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $HashValue; // Hash Value
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $RecCnt;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";

		// Load record by position
		$loadByPosition = FALSE;
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_country_id")) {
				$this->country_id->setFormValue($objForm->GetValue("x_country_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["country_id"])) {
				$this->country_id->setQueryStringValue($_GET["country_id"]);
				$loadByQuery = TRUE;
			} else {
				$this->country_id->CurrentValue = NULL;
			}
			if (!$loadByQuery)
				$loadByPosition = TRUE;
		}

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("countrylist.php"); // Return to list page
		} elseif ($loadByPosition) { // Load record by position
			$this->SetupStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$this->Recordset->Move($this->StartRec-1);
				$loaded = TRUE;
			}
		} else { // Match key values
			if (!is_null($this->country_id->CurrentValue)) {
				while (!$this->Recordset->EOF) {
					if (strval($this->country_id->CurrentValue) == strval($this->Recordset->fields('country_id'))) {
						$this->setStartRecordNumber($this->StartRec); // Save record position
						$loaded = TRUE;
						break;
					} else {
						$this->StartRec++;
						$this->Recordset->MoveNext();
					}
				}
			}
		}

		// Load current row values
		if ($loaded)
			$this->LoadRowValues($this->Recordset);

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values

			// Overwrite record, reload hash value
			if ($this->CurrentAction == "overwrite") {
				$this->LoadRowHash();
				$this->CurrentAction = "F";
			}
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("countrylist.php"); // Return to list page
				} else {
					$this->HashValue = $this->GetRowHash($this->Recordset); // Get hash value for record
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "countrylist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		if ($this->CurrentAction == "F") { // Confirm page
			$this->RowType = EW_ROWTYPE_VIEW; // Render as View
		} else {
			$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		}
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
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
		if (!$this->country_id->FldIsDetailKey)
			$this->country_id->setFormValue($objForm->GetValue("x_country_id"));
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
		if ($this->CurrentAction <> "overwrite")
			$this->HashValue = $objForm->GetValue("k_hash");
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->country_id->CurrentValue = $this->country_id->FormValue;
		$this->country_name_kh->CurrentValue = $this->country_name_kh->FormValue;
		$this->country_name_en->CurrentValue = $this->country_name_en->FormValue;
		$this->country_code->CurrentValue = $this->country_code->FormValue;
		$this->image->CurrentValue = $this->image->FormValue;
		$this->deatil->CurrentValue = $this->deatil->FormValue;
		if ($this->CurrentAction <> "overwrite")
			$this->HashValue = $objForm->GetValue("k_hash");
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
			if (!$this->EventCancelled)
				$this->HashValue = $this->GetRowHash($rs); // Get hash value for record
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
		$row = array();
		$row['country_id'] = NULL;
		$row['country_name_kh'] = NULL;
		$row['country_name_en'] = NULL;
		$row['country_code'] = NULL;
		$row['image'] = NULL;
		$row['deatil'] = NULL;
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

			// country_id
			$this->country_id->LinkCustomAttributes = "";
			$this->country_id->HrefValue = "";
			$this->country_id->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// country_id
			$this->country_id->EditAttrs["class"] = "form-control";
			$this->country_id->EditCustomAttributes = "";
			$this->country_id->EditValue = $this->country_id->CurrentValue;
			$this->country_id->ViewCustomAttributes = "";

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

			// Edit refer script
			// country_id

			$this->country_id->LinkCustomAttributes = "";
			$this->country_id->HrefValue = "";

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

			// country_name_kh
			$this->country_name_kh->SetDbValueDef($rsnew, $this->country_name_kh->CurrentValue, NULL, $this->country_name_kh->ReadOnly);

			// country_name_en
			$this->country_name_en->SetDbValueDef($rsnew, $this->country_name_en->CurrentValue, NULL, $this->country_name_en->ReadOnly);

			// country_code
			$this->country_code->SetDbValueDef($rsnew, $this->country_code->CurrentValue, NULL, $this->country_code->ReadOnly);

			// image
			$this->image->SetDbValueDef($rsnew, $this->image->CurrentValue, NULL, $this->image->ReadOnly);

			// deatil
			$this->deatil->SetDbValueDef($rsnew, $this->deatil->CurrentValue, NULL, $this->deatil->ReadOnly);

			// Check hash value
			$bRowHasConflict = ($this->GetRowHash($rs) <> $this->HashValue);

			// Call Row Update Conflict event
			if ($bRowHasConflict)
				$bRowHasConflict = $this->Row_UpdateConflict($rsold, $rsnew);
			if ($bRowHasConflict) {
				$this->setFailureMessage($Language->Phrase("RecordChangedByOtherUser"));
				$this->UpdateConflict = "U";
				$rs->Close();
				return FALSE; // Update Failed
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

	// Load row hash
	function LoadRowHash() {
		$sFilter = $this->KeyFilter();

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$RsRow = $conn->Execute($sSql);
		$this->HashValue = ($RsRow && !$RsRow->EOF) ? $this->GetRowHash($RsRow) : ""; // Get hash value for record
		$RsRow->Close();
	}

	// Get Row Hash
	function GetRowHash(&$rs) {
		if (!$rs)
			return "";
		$sHash = "";
		$sHash .= ew_GetFldHash($rs->fields('country_name_kh')); // country_name_kh
		$sHash .= ew_GetFldHash($rs->fields('country_name_en')); // country_name_en
		$sHash .= ew_GetFldHash($rs->fields('country_code')); // country_code
		$sHash .= ew_GetFldHash($rs->fields('image')); // image
		$sHash .= ew_GetFldHash($rs->fields('deatil')); // deatil
		return md5($sHash);
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("countrylist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($country_edit)) $country_edit = new ccountry_edit();

// Page init
$country_edit->Page_Init();

// Page main
$country_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$country_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fcountryedit = new ew_Form("fcountryedit", "edit");

// Validate form
fcountryedit.Validate = function() {
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
fcountryedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcountryedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $country_edit->ShowPageHeader(); ?>
<?php
$country_edit->ShowMessage();
?>
<?php if (!$country_edit->IsModal) { ?>
<?php if ($country->CurrentAction <> "F") { // Confirm page ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($country_edit->Pager)) $country_edit->Pager = new cPrevNextPager($country_edit->StartRec, $country_edit->DisplayRecs, $country_edit->TotalRecs, $country_edit->AutoHidePager) ?>
<?php if ($country_edit->Pager->RecordCount > 0 && $country_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($country_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $country_edit->PageUrl() ?>start=<?php echo $country_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($country_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $country_edit->PageUrl() ?>start=<?php echo $country_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $country_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($country_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $country_edit->PageUrl() ?>start=<?php echo $country_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($country_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $country_edit->PageUrl() ?>start=<?php echo $country_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $country_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fcountryedit" id="fcountryedit" class="<?php echo $country_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($country_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $country_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="country">
<input type="hidden" name="k_hash" id="k_hash" value="<?php echo $country_edit->HashValue ?>">
<?php if ($country->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="a_conflict" id="a_conflict" value="1">
<?php } ?>
<?php if ($country->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } else { ?>
<input type="hidden" name="a_edit" id="a_edit" value="F">
<?php } ?>
<input type="hidden" name="modal" value="<?php echo intval($country_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($country->country_id->Visible) { // country_id ?>
	<div id="r_country_id" class="form-group">
		<label id="elh_country_country_id" class="<?php echo $country_edit->LeftColumnClass ?>"><?php echo $country->country_id->FldCaption() ?></label>
		<div class="<?php echo $country_edit->RightColumnClass ?>"><div<?php echo $country->country_id->CellAttributes() ?>>
<?php if ($country->CurrentAction <> "F") { ?>
<span id="el_country_country_id">
<span<?php echo $country->country_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $country->country_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="country" data-field="x_country_id" name="x_country_id" id="x_country_id" value="<?php echo ew_HtmlEncode($country->country_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_country_country_id">
<span<?php echo $country->country_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $country->country_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="country" data-field="x_country_id" name="x_country_id" id="x_country_id" value="<?php echo ew_HtmlEncode($country->country_id->FormValue) ?>">
<?php } ?>
<?php echo $country->country_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($country->country_name_kh->Visible) { // country_name_kh ?>
	<div id="r_country_name_kh" class="form-group">
		<label id="elh_country_country_name_kh" for="x_country_name_kh" class="<?php echo $country_edit->LeftColumnClass ?>"><?php echo $country->country_name_kh->FldCaption() ?></label>
		<div class="<?php echo $country_edit->RightColumnClass ?>"><div<?php echo $country->country_name_kh->CellAttributes() ?>>
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
		<label id="elh_country_country_name_en" for="x_country_name_en" class="<?php echo $country_edit->LeftColumnClass ?>"><?php echo $country->country_name_en->FldCaption() ?></label>
		<div class="<?php echo $country_edit->RightColumnClass ?>"><div<?php echo $country->country_name_en->CellAttributes() ?>>
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
		<label id="elh_country_country_code" for="x_country_code" class="<?php echo $country_edit->LeftColumnClass ?>"><?php echo $country->country_code->FldCaption() ?></label>
		<div class="<?php echo $country_edit->RightColumnClass ?>"><div<?php echo $country->country_code->CellAttributes() ?>>
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
		<label id="elh_country_image" for="x_image" class="<?php echo $country_edit->LeftColumnClass ?>"><?php echo $country->image->FldCaption() ?></label>
		<div class="<?php echo $country_edit->RightColumnClass ?>"><div<?php echo $country->image->CellAttributes() ?>>
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
		<label id="elh_country_deatil" for="x_deatil" class="<?php echo $country_edit->LeftColumnClass ?>"><?php echo $country->deatil->FldCaption() ?></label>
		<div class="<?php echo $country_edit->RightColumnClass ?>"><div<?php echo $country->deatil->CellAttributes() ?>>
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
<?php if (!$country_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $country_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($country->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_edit.value='overwrite';"><?php echo $Language->Phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnReload" id="btnReload" type="submit" onclick="this.form.a_edit.value='I';"><?php echo $Language->Phrase("ReloadBtn") ?></button>
<?php } else { ?>
<?php if ($country->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_edit.value='F';"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $country_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_edit.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$country_edit->IsModal) { ?>
<?php if ($country->CurrentAction <> "F") { // Confirm page ?>
<?php if (!isset($country_edit->Pager)) $country_edit->Pager = new cPrevNextPager($country_edit->StartRec, $country_edit->DisplayRecs, $country_edit->TotalRecs, $country_edit->AutoHidePager) ?>
<?php if ($country_edit->Pager->RecordCount > 0 && $country_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($country_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $country_edit->PageUrl() ?>start=<?php echo $country_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($country_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $country_edit->PageUrl() ?>start=<?php echo $country_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $country_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($country_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $country_edit->PageUrl() ?>start=<?php echo $country_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($country_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $country_edit->PageUrl() ?>start=<?php echo $country_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $country_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<script type="text/javascript">
fcountryedit.Init();
</script>
<?php
$country_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$country_edit->Page_Terminate();
?>

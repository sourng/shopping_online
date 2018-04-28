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

$company_list = NULL; // Initialize page object first

class ccompany_list extends ccompany {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'company';

	// Page object name
	var $PageObjName = 'company_list';

	// Grid form hidden field names
	var $FormName = 'fcompanylist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "companyadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "companydelete.php";
		$this->MultiUpdateUrl = "companyupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fcompanylistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->company_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->company_id->Visible = FALSE;
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
		$this->com_province->SetVisibility();
		$this->com_username->SetVisibility();
		$this->com_password->SetVisibility();
		$this->com_online->SetVisibility();
		$this->com_activation->SetVisibility();
		$this->com_status->SetVisibility();
		$this->reg_date->SetVisibility();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->company_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->company_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->company_id->AdvancedSearch->ToJson(), ","); // Field company_id
		$sFilterList = ew_Concat($sFilterList, $this->com_fname->AdvancedSearch->ToJson(), ","); // Field com_fname
		$sFilterList = ew_Concat($sFilterList, $this->com_lname->AdvancedSearch->ToJson(), ","); // Field com_lname
		$sFilterList = ew_Concat($sFilterList, $this->com_name->AdvancedSearch->ToJson(), ","); // Field com_name
		$sFilterList = ew_Concat($sFilterList, $this->com_address->AdvancedSearch->ToJson(), ","); // Field com_address
		$sFilterList = ew_Concat($sFilterList, $this->com_phone->AdvancedSearch->ToJson(), ","); // Field com_phone
		$sFilterList = ew_Concat($sFilterList, $this->com_email->AdvancedSearch->ToJson(), ","); // Field com_email
		$sFilterList = ew_Concat($sFilterList, $this->com_fb->AdvancedSearch->ToJson(), ","); // Field com_fb
		$sFilterList = ew_Concat($sFilterList, $this->com_tw->AdvancedSearch->ToJson(), ","); // Field com_tw
		$sFilterList = ew_Concat($sFilterList, $this->com_yt->AdvancedSearch->ToJson(), ","); // Field com_yt
		$sFilterList = ew_Concat($sFilterList, $this->com_logo->AdvancedSearch->ToJson(), ","); // Field com_logo
		$sFilterList = ew_Concat($sFilterList, $this->com_province->AdvancedSearch->ToJson(), ","); // Field com_province
		$sFilterList = ew_Concat($sFilterList, $this->com_username->AdvancedSearch->ToJson(), ","); // Field com_username
		$sFilterList = ew_Concat($sFilterList, $this->com_password->AdvancedSearch->ToJson(), ","); // Field com_password
		$sFilterList = ew_Concat($sFilterList, $this->com_online->AdvancedSearch->ToJson(), ","); // Field com_online
		$sFilterList = ew_Concat($sFilterList, $this->com_activation->AdvancedSearch->ToJson(), ","); // Field com_activation
		$sFilterList = ew_Concat($sFilterList, $this->com_status->AdvancedSearch->ToJson(), ","); // Field com_status
		$sFilterList = ew_Concat($sFilterList, $this->reg_date->AdvancedSearch->ToJson(), ","); // Field reg_date
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "fcompanylistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field company_id
		$this->company_id->AdvancedSearch->SearchValue = @$filter["x_company_id"];
		$this->company_id->AdvancedSearch->SearchOperator = @$filter["z_company_id"];
		$this->company_id->AdvancedSearch->SearchCondition = @$filter["v_company_id"];
		$this->company_id->AdvancedSearch->SearchValue2 = @$filter["y_company_id"];
		$this->company_id->AdvancedSearch->SearchOperator2 = @$filter["w_company_id"];
		$this->company_id->AdvancedSearch->Save();

		// Field com_fname
		$this->com_fname->AdvancedSearch->SearchValue = @$filter["x_com_fname"];
		$this->com_fname->AdvancedSearch->SearchOperator = @$filter["z_com_fname"];
		$this->com_fname->AdvancedSearch->SearchCondition = @$filter["v_com_fname"];
		$this->com_fname->AdvancedSearch->SearchValue2 = @$filter["y_com_fname"];
		$this->com_fname->AdvancedSearch->SearchOperator2 = @$filter["w_com_fname"];
		$this->com_fname->AdvancedSearch->Save();

		// Field com_lname
		$this->com_lname->AdvancedSearch->SearchValue = @$filter["x_com_lname"];
		$this->com_lname->AdvancedSearch->SearchOperator = @$filter["z_com_lname"];
		$this->com_lname->AdvancedSearch->SearchCondition = @$filter["v_com_lname"];
		$this->com_lname->AdvancedSearch->SearchValue2 = @$filter["y_com_lname"];
		$this->com_lname->AdvancedSearch->SearchOperator2 = @$filter["w_com_lname"];
		$this->com_lname->AdvancedSearch->Save();

		// Field com_name
		$this->com_name->AdvancedSearch->SearchValue = @$filter["x_com_name"];
		$this->com_name->AdvancedSearch->SearchOperator = @$filter["z_com_name"];
		$this->com_name->AdvancedSearch->SearchCondition = @$filter["v_com_name"];
		$this->com_name->AdvancedSearch->SearchValue2 = @$filter["y_com_name"];
		$this->com_name->AdvancedSearch->SearchOperator2 = @$filter["w_com_name"];
		$this->com_name->AdvancedSearch->Save();

		// Field com_address
		$this->com_address->AdvancedSearch->SearchValue = @$filter["x_com_address"];
		$this->com_address->AdvancedSearch->SearchOperator = @$filter["z_com_address"];
		$this->com_address->AdvancedSearch->SearchCondition = @$filter["v_com_address"];
		$this->com_address->AdvancedSearch->SearchValue2 = @$filter["y_com_address"];
		$this->com_address->AdvancedSearch->SearchOperator2 = @$filter["w_com_address"];
		$this->com_address->AdvancedSearch->Save();

		// Field com_phone
		$this->com_phone->AdvancedSearch->SearchValue = @$filter["x_com_phone"];
		$this->com_phone->AdvancedSearch->SearchOperator = @$filter["z_com_phone"];
		$this->com_phone->AdvancedSearch->SearchCondition = @$filter["v_com_phone"];
		$this->com_phone->AdvancedSearch->SearchValue2 = @$filter["y_com_phone"];
		$this->com_phone->AdvancedSearch->SearchOperator2 = @$filter["w_com_phone"];
		$this->com_phone->AdvancedSearch->Save();

		// Field com_email
		$this->com_email->AdvancedSearch->SearchValue = @$filter["x_com_email"];
		$this->com_email->AdvancedSearch->SearchOperator = @$filter["z_com_email"];
		$this->com_email->AdvancedSearch->SearchCondition = @$filter["v_com_email"];
		$this->com_email->AdvancedSearch->SearchValue2 = @$filter["y_com_email"];
		$this->com_email->AdvancedSearch->SearchOperator2 = @$filter["w_com_email"];
		$this->com_email->AdvancedSearch->Save();

		// Field com_fb
		$this->com_fb->AdvancedSearch->SearchValue = @$filter["x_com_fb"];
		$this->com_fb->AdvancedSearch->SearchOperator = @$filter["z_com_fb"];
		$this->com_fb->AdvancedSearch->SearchCondition = @$filter["v_com_fb"];
		$this->com_fb->AdvancedSearch->SearchValue2 = @$filter["y_com_fb"];
		$this->com_fb->AdvancedSearch->SearchOperator2 = @$filter["w_com_fb"];
		$this->com_fb->AdvancedSearch->Save();

		// Field com_tw
		$this->com_tw->AdvancedSearch->SearchValue = @$filter["x_com_tw"];
		$this->com_tw->AdvancedSearch->SearchOperator = @$filter["z_com_tw"];
		$this->com_tw->AdvancedSearch->SearchCondition = @$filter["v_com_tw"];
		$this->com_tw->AdvancedSearch->SearchValue2 = @$filter["y_com_tw"];
		$this->com_tw->AdvancedSearch->SearchOperator2 = @$filter["w_com_tw"];
		$this->com_tw->AdvancedSearch->Save();

		// Field com_yt
		$this->com_yt->AdvancedSearch->SearchValue = @$filter["x_com_yt"];
		$this->com_yt->AdvancedSearch->SearchOperator = @$filter["z_com_yt"];
		$this->com_yt->AdvancedSearch->SearchCondition = @$filter["v_com_yt"];
		$this->com_yt->AdvancedSearch->SearchValue2 = @$filter["y_com_yt"];
		$this->com_yt->AdvancedSearch->SearchOperator2 = @$filter["w_com_yt"];
		$this->com_yt->AdvancedSearch->Save();

		// Field com_logo
		$this->com_logo->AdvancedSearch->SearchValue = @$filter["x_com_logo"];
		$this->com_logo->AdvancedSearch->SearchOperator = @$filter["z_com_logo"];
		$this->com_logo->AdvancedSearch->SearchCondition = @$filter["v_com_logo"];
		$this->com_logo->AdvancedSearch->SearchValue2 = @$filter["y_com_logo"];
		$this->com_logo->AdvancedSearch->SearchOperator2 = @$filter["w_com_logo"];
		$this->com_logo->AdvancedSearch->Save();

		// Field com_province
		$this->com_province->AdvancedSearch->SearchValue = @$filter["x_com_province"];
		$this->com_province->AdvancedSearch->SearchOperator = @$filter["z_com_province"];
		$this->com_province->AdvancedSearch->SearchCondition = @$filter["v_com_province"];
		$this->com_province->AdvancedSearch->SearchValue2 = @$filter["y_com_province"];
		$this->com_province->AdvancedSearch->SearchOperator2 = @$filter["w_com_province"];
		$this->com_province->AdvancedSearch->Save();

		// Field com_username
		$this->com_username->AdvancedSearch->SearchValue = @$filter["x_com_username"];
		$this->com_username->AdvancedSearch->SearchOperator = @$filter["z_com_username"];
		$this->com_username->AdvancedSearch->SearchCondition = @$filter["v_com_username"];
		$this->com_username->AdvancedSearch->SearchValue2 = @$filter["y_com_username"];
		$this->com_username->AdvancedSearch->SearchOperator2 = @$filter["w_com_username"];
		$this->com_username->AdvancedSearch->Save();

		// Field com_password
		$this->com_password->AdvancedSearch->SearchValue = @$filter["x_com_password"];
		$this->com_password->AdvancedSearch->SearchOperator = @$filter["z_com_password"];
		$this->com_password->AdvancedSearch->SearchCondition = @$filter["v_com_password"];
		$this->com_password->AdvancedSearch->SearchValue2 = @$filter["y_com_password"];
		$this->com_password->AdvancedSearch->SearchOperator2 = @$filter["w_com_password"];
		$this->com_password->AdvancedSearch->Save();

		// Field com_online
		$this->com_online->AdvancedSearch->SearchValue = @$filter["x_com_online"];
		$this->com_online->AdvancedSearch->SearchOperator = @$filter["z_com_online"];
		$this->com_online->AdvancedSearch->SearchCondition = @$filter["v_com_online"];
		$this->com_online->AdvancedSearch->SearchValue2 = @$filter["y_com_online"];
		$this->com_online->AdvancedSearch->SearchOperator2 = @$filter["w_com_online"];
		$this->com_online->AdvancedSearch->Save();

		// Field com_activation
		$this->com_activation->AdvancedSearch->SearchValue = @$filter["x_com_activation"];
		$this->com_activation->AdvancedSearch->SearchOperator = @$filter["z_com_activation"];
		$this->com_activation->AdvancedSearch->SearchCondition = @$filter["v_com_activation"];
		$this->com_activation->AdvancedSearch->SearchValue2 = @$filter["y_com_activation"];
		$this->com_activation->AdvancedSearch->SearchOperator2 = @$filter["w_com_activation"];
		$this->com_activation->AdvancedSearch->Save();

		// Field com_status
		$this->com_status->AdvancedSearch->SearchValue = @$filter["x_com_status"];
		$this->com_status->AdvancedSearch->SearchOperator = @$filter["z_com_status"];
		$this->com_status->AdvancedSearch->SearchCondition = @$filter["v_com_status"];
		$this->com_status->AdvancedSearch->SearchValue2 = @$filter["y_com_status"];
		$this->com_status->AdvancedSearch->SearchOperator2 = @$filter["w_com_status"];
		$this->com_status->AdvancedSearch->Save();

		// Field reg_date
		$this->reg_date->AdvancedSearch->SearchValue = @$filter["x_reg_date"];
		$this->reg_date->AdvancedSearch->SearchOperator = @$filter["z_reg_date"];
		$this->reg_date->AdvancedSearch->SearchCondition = @$filter["v_reg_date"];
		$this->reg_date->AdvancedSearch->SearchValue2 = @$filter["y_reg_date"];
		$this->reg_date->AdvancedSearch->SearchOperator2 = @$filter["w_reg_date"];
		$this->reg_date->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->com_fname, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_lname, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_address, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_phone, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_fb, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_tw, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_yt, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_logo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_province, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_username, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_password, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_online, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_activation, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->com_status, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->company_id); // company_id
			$this->UpdateSort($this->com_fname); // com_fname
			$this->UpdateSort($this->com_lname); // com_lname
			$this->UpdateSort($this->com_name); // com_name
			$this->UpdateSort($this->com_address); // com_address
			$this->UpdateSort($this->com_phone); // com_phone
			$this->UpdateSort($this->com_email); // com_email
			$this->UpdateSort($this->com_fb); // com_fb
			$this->UpdateSort($this->com_tw); // com_tw
			$this->UpdateSort($this->com_yt); // com_yt
			$this->UpdateSort($this->com_logo); // com_logo
			$this->UpdateSort($this->com_province); // com_province
			$this->UpdateSort($this->com_username); // com_username
			$this->UpdateSort($this->com_password); // com_password
			$this->UpdateSort($this->com_online); // com_online
			$this->UpdateSort($this->com_activation); // com_activation
			$this->UpdateSort($this->com_status); // com_status
			$this->UpdateSort($this->reg_date); // reg_date
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->company_id->setSort("");
				$this->com_fname->setSort("");
				$this->com_lname->setSort("");
				$this->com_name->setSort("");
				$this->com_address->setSort("");
				$this->com_phone->setSort("");
				$this->com_email->setSort("");
				$this->com_fb->setSort("");
				$this->com_tw->setSort("");
				$this->com_yt->setSort("");
				$this->com_logo->setSort("");
				$this->com_province->setSort("");
				$this->com_username->setSort("");
				$this->com_password->setSort("");
				$this->com_online->setSort("");
				$this->com_activation->setSort("");
				$this->com_status->setSort("");
				$this->reg_date->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = FALSE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->company_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fcompanylistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fcompanylistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fcompanylist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$user = $row['com_email'];
					if ($userlist <> "") $userlist .= ",";
					$userlist .= $user;
					if ($UserAction == "resendregisteremail")
						$Processed = FALSE;
					elseif ($UserAction == "resetconcurrentuser")
						$Processed = FALSE;
					elseif ($UserAction == "resetloginretry")
						$Processed = FALSE;
					elseif ($UserAction == "setpasswordexpired")
						$Processed = FALSE;
					else
						$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fcompanylistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("company_id")) <> "")
			$this->company_id->CurrentValue = $this->getKey("company_id"); // company_id
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($company_list)) $company_list = new ccompany_list();

// Page init
$company_list->Page_Init();

// Page main
$company_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$company_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fcompanylist = new ew_Form("fcompanylist", "list");
fcompanylist.FormKeyCountName = '<?php echo $company_list->FormKeyCountName ?>';

// Form_CustomValidate event
fcompanylist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcompanylist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fcompanylistsrch = new ew_Form("fcompanylistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($company_list->TotalRecs > 0 && $company_list->ExportOptions->Visible()) { ?>
<?php $company_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($company_list->SearchOptions->Visible()) { ?>
<?php $company_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($company_list->FilterOptions->Visible()) { ?>
<?php $company_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $company_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($company_list->TotalRecs <= 0)
			$company_list->TotalRecs = $company->ListRecordCount();
	} else {
		if (!$company_list->Recordset && ($company_list->Recordset = $company_list->LoadRecordset()))
			$company_list->TotalRecs = $company_list->Recordset->RecordCount();
	}
	$company_list->StartRec = 1;
	if ($company_list->DisplayRecs <= 0 || ($company->Export <> "" && $company->ExportAll)) // Display all records
		$company_list->DisplayRecs = $company_list->TotalRecs;
	if (!($company->Export <> "" && $company->ExportAll))
		$company_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$company_list->Recordset = $company_list->LoadRecordset($company_list->StartRec-1, $company_list->DisplayRecs);

	// Set no record found message
	if ($company->CurrentAction == "" && $company_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$company_list->setWarningMessage(ew_DeniedMsg());
		if ($company_list->SearchWhere == "0=101")
			$company_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$company_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$company_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($company->Export == "" && $company->CurrentAction == "") { ?>
<form name="fcompanylistsrch" id="fcompanylistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($company_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fcompanylistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="company">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($company_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($company_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $company_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($company_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($company_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($company_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($company_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $company_list->ShowPageHeader(); ?>
<?php
$company_list->ShowMessage();
?>
<?php if ($company_list->TotalRecs > 0 || $company->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($company_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> company">
<form name="fcompanylist" id="fcompanylist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($company_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $company_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="company">
<div id="gmp_company" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($company_list->TotalRecs > 0 || $company->CurrentAction == "gridedit") { ?>
<table id="tbl_companylist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$company_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$company_list->RenderListOptions();

// Render list options (header, left)
$company_list->ListOptions->Render("header", "left");
?>
<?php if ($company->company_id->Visible) { // company_id ?>
	<?php if ($company->SortUrl($company->company_id) == "") { ?>
		<th data-name="company_id" class="<?php echo $company->company_id->HeaderCellClass() ?>"><div id="elh_company_company_id" class="company_company_id"><div class="ewTableHeaderCaption"><?php echo $company->company_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="company_id" class="<?php echo $company->company_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->company_id) ?>',1);"><div id="elh_company_company_id" class="company_company_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->company_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($company->company_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->company_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_fname->Visible) { // com_fname ?>
	<?php if ($company->SortUrl($company->com_fname) == "") { ?>
		<th data-name="com_fname" class="<?php echo $company->com_fname->HeaderCellClass() ?>"><div id="elh_company_com_fname" class="company_com_fname"><div class="ewTableHeaderCaption"><?php echo $company->com_fname->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_fname" class="<?php echo $company->com_fname->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_fname) ?>',1);"><div id="elh_company_com_fname" class="company_com_fname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_fname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_fname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_fname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_lname->Visible) { // com_lname ?>
	<?php if ($company->SortUrl($company->com_lname) == "") { ?>
		<th data-name="com_lname" class="<?php echo $company->com_lname->HeaderCellClass() ?>"><div id="elh_company_com_lname" class="company_com_lname"><div class="ewTableHeaderCaption"><?php echo $company->com_lname->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_lname" class="<?php echo $company->com_lname->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_lname) ?>',1);"><div id="elh_company_com_lname" class="company_com_lname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_lname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_lname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_lname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_name->Visible) { // com_name ?>
	<?php if ($company->SortUrl($company->com_name) == "") { ?>
		<th data-name="com_name" class="<?php echo $company->com_name->HeaderCellClass() ?>"><div id="elh_company_com_name" class="company_com_name"><div class="ewTableHeaderCaption"><?php echo $company->com_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_name" class="<?php echo $company->com_name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_name) ?>',1);"><div id="elh_company_com_name" class="company_com_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_address->Visible) { // com_address ?>
	<?php if ($company->SortUrl($company->com_address) == "") { ?>
		<th data-name="com_address" class="<?php echo $company->com_address->HeaderCellClass() ?>"><div id="elh_company_com_address" class="company_com_address"><div class="ewTableHeaderCaption"><?php echo $company->com_address->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_address" class="<?php echo $company->com_address->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_address) ?>',1);"><div id="elh_company_com_address" class="company_com_address">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_address->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_address->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_address->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_phone->Visible) { // com_phone ?>
	<?php if ($company->SortUrl($company->com_phone) == "") { ?>
		<th data-name="com_phone" class="<?php echo $company->com_phone->HeaderCellClass() ?>"><div id="elh_company_com_phone" class="company_com_phone"><div class="ewTableHeaderCaption"><?php echo $company->com_phone->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_phone" class="<?php echo $company->com_phone->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_phone) ?>',1);"><div id="elh_company_com_phone" class="company_com_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_email->Visible) { // com_email ?>
	<?php if ($company->SortUrl($company->com_email) == "") { ?>
		<th data-name="com_email" class="<?php echo $company->com_email->HeaderCellClass() ?>"><div id="elh_company_com_email" class="company_com_email"><div class="ewTableHeaderCaption"><?php echo $company->com_email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_email" class="<?php echo $company->com_email->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_email) ?>',1);"><div id="elh_company_com_email" class="company_com_email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_fb->Visible) { // com_fb ?>
	<?php if ($company->SortUrl($company->com_fb) == "") { ?>
		<th data-name="com_fb" class="<?php echo $company->com_fb->HeaderCellClass() ?>"><div id="elh_company_com_fb" class="company_com_fb"><div class="ewTableHeaderCaption"><?php echo $company->com_fb->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_fb" class="<?php echo $company->com_fb->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_fb) ?>',1);"><div id="elh_company_com_fb" class="company_com_fb">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_fb->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_fb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_fb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_tw->Visible) { // com_tw ?>
	<?php if ($company->SortUrl($company->com_tw) == "") { ?>
		<th data-name="com_tw" class="<?php echo $company->com_tw->HeaderCellClass() ?>"><div id="elh_company_com_tw" class="company_com_tw"><div class="ewTableHeaderCaption"><?php echo $company->com_tw->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_tw" class="<?php echo $company->com_tw->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_tw) ?>',1);"><div id="elh_company_com_tw" class="company_com_tw">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_tw->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_tw->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_tw->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_yt->Visible) { // com_yt ?>
	<?php if ($company->SortUrl($company->com_yt) == "") { ?>
		<th data-name="com_yt" class="<?php echo $company->com_yt->HeaderCellClass() ?>"><div id="elh_company_com_yt" class="company_com_yt"><div class="ewTableHeaderCaption"><?php echo $company->com_yt->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_yt" class="<?php echo $company->com_yt->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_yt) ?>',1);"><div id="elh_company_com_yt" class="company_com_yt">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_yt->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_yt->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_yt->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_logo->Visible) { // com_logo ?>
	<?php if ($company->SortUrl($company->com_logo) == "") { ?>
		<th data-name="com_logo" class="<?php echo $company->com_logo->HeaderCellClass() ?>"><div id="elh_company_com_logo" class="company_com_logo"><div class="ewTableHeaderCaption"><?php echo $company->com_logo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_logo" class="<?php echo $company->com_logo->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_logo) ?>',1);"><div id="elh_company_com_logo" class="company_com_logo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_logo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_logo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_logo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_province->Visible) { // com_province ?>
	<?php if ($company->SortUrl($company->com_province) == "") { ?>
		<th data-name="com_province" class="<?php echo $company->com_province->HeaderCellClass() ?>"><div id="elh_company_com_province" class="company_com_province"><div class="ewTableHeaderCaption"><?php echo $company->com_province->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_province" class="<?php echo $company->com_province->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_province) ?>',1);"><div id="elh_company_com_province" class="company_com_province">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_province->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_province->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_province->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_username->Visible) { // com_username ?>
	<?php if ($company->SortUrl($company->com_username) == "") { ?>
		<th data-name="com_username" class="<?php echo $company->com_username->HeaderCellClass() ?>"><div id="elh_company_com_username" class="company_com_username"><div class="ewTableHeaderCaption"><?php echo $company->com_username->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_username" class="<?php echo $company->com_username->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_username) ?>',1);"><div id="elh_company_com_username" class="company_com_username">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_username->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_username->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_username->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_password->Visible) { // com_password ?>
	<?php if ($company->SortUrl($company->com_password) == "") { ?>
		<th data-name="com_password" class="<?php echo $company->com_password->HeaderCellClass() ?>"><div id="elh_company_com_password" class="company_com_password"><div class="ewTableHeaderCaption"><?php echo $company->com_password->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_password" class="<?php echo $company->com_password->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_password) ?>',1);"><div id="elh_company_com_password" class="company_com_password">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_password->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_password->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_password->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_online->Visible) { // com_online ?>
	<?php if ($company->SortUrl($company->com_online) == "") { ?>
		<th data-name="com_online" class="<?php echo $company->com_online->HeaderCellClass() ?>"><div id="elh_company_com_online" class="company_com_online"><div class="ewTableHeaderCaption"><?php echo $company->com_online->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_online" class="<?php echo $company->com_online->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_online) ?>',1);"><div id="elh_company_com_online" class="company_com_online">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_online->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_online->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_online->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_activation->Visible) { // com_activation ?>
	<?php if ($company->SortUrl($company->com_activation) == "") { ?>
		<th data-name="com_activation" class="<?php echo $company->com_activation->HeaderCellClass() ?>"><div id="elh_company_com_activation" class="company_com_activation"><div class="ewTableHeaderCaption"><?php echo $company->com_activation->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_activation" class="<?php echo $company->com_activation->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_activation) ?>',1);"><div id="elh_company_com_activation" class="company_com_activation">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_activation->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_activation->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_activation->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_status->Visible) { // com_status ?>
	<?php if ($company->SortUrl($company->com_status) == "") { ?>
		<th data-name="com_status" class="<?php echo $company->com_status->HeaderCellClass() ?>"><div id="elh_company_com_status" class="company_com_status"><div class="ewTableHeaderCaption"><?php echo $company->com_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_status" class="<?php echo $company->com_status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_status) ?>',1);"><div id="elh_company_com_status" class="company_com_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_status->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->reg_date->Visible) { // reg_date ?>
	<?php if ($company->SortUrl($company->reg_date) == "") { ?>
		<th data-name="reg_date" class="<?php echo $company->reg_date->HeaderCellClass() ?>"><div id="elh_company_reg_date" class="company_reg_date"><div class="ewTableHeaderCaption"><?php echo $company->reg_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="reg_date" class="<?php echo $company->reg_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->reg_date) ?>',1);"><div id="elh_company_reg_date" class="company_reg_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->reg_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($company->reg_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->reg_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$company_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($company->ExportAll && $company->Export <> "") {
	$company_list->StopRec = $company_list->TotalRecs;
} else {

	// Set the last record to display
	if ($company_list->TotalRecs > $company_list->StartRec + $company_list->DisplayRecs - 1)
		$company_list->StopRec = $company_list->StartRec + $company_list->DisplayRecs - 1;
	else
		$company_list->StopRec = $company_list->TotalRecs;
}
$company_list->RecCnt = $company_list->StartRec - 1;
if ($company_list->Recordset && !$company_list->Recordset->EOF) {
	$company_list->Recordset->MoveFirst();
	$bSelectLimit = $company_list->UseSelectLimit;
	if (!$bSelectLimit && $company_list->StartRec > 1)
		$company_list->Recordset->Move($company_list->StartRec - 1);
} elseif (!$company->AllowAddDeleteRow && $company_list->StopRec == 0) {
	$company_list->StopRec = $company->GridAddRowCount;
}

// Initialize aggregate
$company->RowType = EW_ROWTYPE_AGGREGATEINIT;
$company->ResetAttrs();
$company_list->RenderRow();
while ($company_list->RecCnt < $company_list->StopRec) {
	$company_list->RecCnt++;
	if (intval($company_list->RecCnt) >= intval($company_list->StartRec)) {
		$company_list->RowCnt++;

		// Set up key count
		$company_list->KeyCount = $company_list->RowIndex;

		// Init row class and style
		$company->ResetAttrs();
		$company->CssClass = "";
		if ($company->CurrentAction == "gridadd") {
		} else {
			$company_list->LoadRowValues($company_list->Recordset); // Load row values
		}
		$company->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$company->RowAttrs = array_merge($company->RowAttrs, array('data-rowindex'=>$company_list->RowCnt, 'id'=>'r' . $company_list->RowCnt . '_company', 'data-rowtype'=>$company->RowType));

		// Render row
		$company_list->RenderRow();

		// Render list options
		$company_list->RenderListOptions();
?>
	<tr<?php echo $company->RowAttributes() ?>>
<?php

// Render list options (body, left)
$company_list->ListOptions->Render("body", "left", $company_list->RowCnt);
?>
	<?php if ($company->company_id->Visible) { // company_id ?>
		<td data-name="company_id"<?php echo $company->company_id->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_company_id" class="company_company_id">
<span<?php echo $company->company_id->ViewAttributes() ?>>
<?php echo $company->company_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_fname->Visible) { // com_fname ?>
		<td data-name="com_fname"<?php echo $company->com_fname->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_fname" class="company_com_fname">
<span<?php echo $company->com_fname->ViewAttributes() ?>>
<?php echo $company->com_fname->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_lname->Visible) { // com_lname ?>
		<td data-name="com_lname"<?php echo $company->com_lname->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_lname" class="company_com_lname">
<span<?php echo $company->com_lname->ViewAttributes() ?>>
<?php echo $company->com_lname->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_name->Visible) { // com_name ?>
		<td data-name="com_name"<?php echo $company->com_name->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_name" class="company_com_name">
<span<?php echo $company->com_name->ViewAttributes() ?>>
<?php echo $company->com_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_address->Visible) { // com_address ?>
		<td data-name="com_address"<?php echo $company->com_address->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_address" class="company_com_address">
<span<?php echo $company->com_address->ViewAttributes() ?>>
<?php echo $company->com_address->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_phone->Visible) { // com_phone ?>
		<td data-name="com_phone"<?php echo $company->com_phone->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_phone" class="company_com_phone">
<span<?php echo $company->com_phone->ViewAttributes() ?>>
<?php echo $company->com_phone->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_email->Visible) { // com_email ?>
		<td data-name="com_email"<?php echo $company->com_email->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_email" class="company_com_email">
<span<?php echo $company->com_email->ViewAttributes() ?>>
<?php echo $company->com_email->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_fb->Visible) { // com_fb ?>
		<td data-name="com_fb"<?php echo $company->com_fb->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_fb" class="company_com_fb">
<span<?php echo $company->com_fb->ViewAttributes() ?>>
<?php echo $company->com_fb->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_tw->Visible) { // com_tw ?>
		<td data-name="com_tw"<?php echo $company->com_tw->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_tw" class="company_com_tw">
<span<?php echo $company->com_tw->ViewAttributes() ?>>
<?php echo $company->com_tw->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_yt->Visible) { // com_yt ?>
		<td data-name="com_yt"<?php echo $company->com_yt->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_yt" class="company_com_yt">
<span<?php echo $company->com_yt->ViewAttributes() ?>>
<?php echo $company->com_yt->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_logo->Visible) { // com_logo ?>
		<td data-name="com_logo"<?php echo $company->com_logo->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_logo" class="company_com_logo">
<span<?php echo $company->com_logo->ViewAttributes() ?>>
<?php echo $company->com_logo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_province->Visible) { // com_province ?>
		<td data-name="com_province"<?php echo $company->com_province->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_province" class="company_com_province">
<span<?php echo $company->com_province->ViewAttributes() ?>>
<?php echo $company->com_province->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_username->Visible) { // com_username ?>
		<td data-name="com_username"<?php echo $company->com_username->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_username" class="company_com_username">
<span<?php echo $company->com_username->ViewAttributes() ?>>
<?php echo $company->com_username->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_password->Visible) { // com_password ?>
		<td data-name="com_password"<?php echo $company->com_password->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_password" class="company_com_password">
<span<?php echo $company->com_password->ViewAttributes() ?>>
<?php echo $company->com_password->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_online->Visible) { // com_online ?>
		<td data-name="com_online"<?php echo $company->com_online->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_online" class="company_com_online">
<span<?php echo $company->com_online->ViewAttributes() ?>>
<?php echo $company->com_online->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_activation->Visible) { // com_activation ?>
		<td data-name="com_activation"<?php echo $company->com_activation->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_activation" class="company_com_activation">
<span<?php echo $company->com_activation->ViewAttributes() ?>>
<?php echo $company->com_activation->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->com_status->Visible) { // com_status ?>
		<td data-name="com_status"<?php echo $company->com_status->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_status" class="company_com_status">
<span<?php echo $company->com_status->ViewAttributes() ?>>
<?php echo $company->com_status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($company->reg_date->Visible) { // reg_date ?>
		<td data-name="reg_date"<?php echo $company->reg_date->CellAttributes() ?>>
<span id="el<?php echo $company_list->RowCnt ?>_company_reg_date" class="company_reg_date">
<span<?php echo $company->reg_date->ViewAttributes() ?>>
<?php echo $company->reg_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$company_list->ListOptions->Render("body", "right", $company_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($company->CurrentAction <> "gridadd")
		$company_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($company->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($company_list->Recordset)
	$company_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($company->CurrentAction <> "gridadd" && $company->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($company_list->Pager)) $company_list->Pager = new cPrevNextPager($company_list->StartRec, $company_list->DisplayRecs, $company_list->TotalRecs, $company_list->AutoHidePager) ?>
<?php if ($company_list->Pager->RecordCount > 0 && $company_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($company_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $company_list->PageUrl() ?>start=<?php echo $company_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($company_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $company_list->PageUrl() ?>start=<?php echo $company_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $company_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($company_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $company_list->PageUrl() ?>start=<?php echo $company_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($company_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $company_list->PageUrl() ?>start=<?php echo $company_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $company_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($company_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $company_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $company_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $company_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($company_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($company_list->TotalRecs == 0 && $company->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($company_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fcompanylistsrch.FilterList = <?php echo $company_list->GetFilterList() ?>;
fcompanylistsrch.Init();
fcompanylist.Init();
</script>
<?php
$company_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$company_list->Page_Terminate();
?>

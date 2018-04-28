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

$province_list = NULL; // Initialize page object first

class cprovince_list extends cprovince {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'province';

	// Page object name
	var $PageObjName = 'province_list';

	// Grid form hidden field names
	var $FormName = 'fprovincelist';
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

		// Table object (province)
		if (!isset($GLOBALS["province"]) || get_class($GLOBALS["province"]) == "cprovince") {
			$GLOBALS["province"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["province"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "provinceadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "provincedelete.php";
		$this->MultiUpdateUrl = "provinceupdate.php";

		// Table object (company)
		if (!isset($GLOBALS['company'])) $GLOBALS['company'] = new ccompany();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fprovincelistsrch";

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
		// Get export parameters

		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} elseif (@$_GET["cmd"] == "json") {
			$this->Export = $_GET["cmd"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->province_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->province_id->Visible = FALSE;
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

		// Export selected records
		if ($this->Export <> "")
			$this->CurrentFilter = $this->BuildExportSelectedFilter();

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array_keys($EW_EXPORT))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
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
		if (count($arrKeyFlds) >= 2) {
			$this->province_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->province_id->FormValue))
				return FALSE;
			$this->country_id->setFormValue($arrKeyFlds[1]);
			if (!is_numeric($this->country_id->FormValue))
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
		$sFilterList = ew_Concat($sFilterList, $this->province_id->AdvancedSearch->ToJson(), ","); // Field province_id
		$sFilterList = ew_Concat($sFilterList, $this->country_id->AdvancedSearch->ToJson(), ","); // Field country_id
		$sFilterList = ew_Concat($sFilterList, $this->province_name_kh->AdvancedSearch->ToJson(), ","); // Field province_name_kh
		$sFilterList = ew_Concat($sFilterList, $this->province_name_en->AdvancedSearch->ToJson(), ","); // Field province_name_en
		$sFilterList = ew_Concat($sFilterList, $this->capital_kh->AdvancedSearch->ToJson(), ","); // Field capital_kh
		$sFilterList = ew_Concat($sFilterList, $this->capital_en->AdvancedSearch->ToJson(), ","); // Field capital_en
		$sFilterList = ew_Concat($sFilterList, $this->population_kh->AdvancedSearch->ToJson(), ","); // Field population_kh
		$sFilterList = ew_Concat($sFilterList, $this->population_en->AdvancedSearch->ToJson(), ","); // Field population_en
		$sFilterList = ew_Concat($sFilterList, $this->area_kh->AdvancedSearch->ToJson(), ","); // Field area_kh
		$sFilterList = ew_Concat($sFilterList, $this->area_en->AdvancedSearch->ToJson(), ","); // Field area_en
		$sFilterList = ew_Concat($sFilterList, $this->density_kh->AdvancedSearch->ToJson(), ","); // Field density_kh
		$sFilterList = ew_Concat($sFilterList, $this->density_en->AdvancedSearch->ToJson(), ","); // Field density_en
		$sFilterList = ew_Concat($sFilterList, $this->province_code->AdvancedSearch->ToJson(), ","); // Field province_code
		$sFilterList = ew_Concat($sFilterList, $this->image->AdvancedSearch->ToJson(), ","); // Field image
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fprovincelistsrch", $filters);

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

		// Field province_id
		$this->province_id->AdvancedSearch->SearchValue = @$filter["x_province_id"];
		$this->province_id->AdvancedSearch->SearchOperator = @$filter["z_province_id"];
		$this->province_id->AdvancedSearch->SearchCondition = @$filter["v_province_id"];
		$this->province_id->AdvancedSearch->SearchValue2 = @$filter["y_province_id"];
		$this->province_id->AdvancedSearch->SearchOperator2 = @$filter["w_province_id"];
		$this->province_id->AdvancedSearch->Save();

		// Field country_id
		$this->country_id->AdvancedSearch->SearchValue = @$filter["x_country_id"];
		$this->country_id->AdvancedSearch->SearchOperator = @$filter["z_country_id"];
		$this->country_id->AdvancedSearch->SearchCondition = @$filter["v_country_id"];
		$this->country_id->AdvancedSearch->SearchValue2 = @$filter["y_country_id"];
		$this->country_id->AdvancedSearch->SearchOperator2 = @$filter["w_country_id"];
		$this->country_id->AdvancedSearch->Save();

		// Field province_name_kh
		$this->province_name_kh->AdvancedSearch->SearchValue = @$filter["x_province_name_kh"];
		$this->province_name_kh->AdvancedSearch->SearchOperator = @$filter["z_province_name_kh"];
		$this->province_name_kh->AdvancedSearch->SearchCondition = @$filter["v_province_name_kh"];
		$this->province_name_kh->AdvancedSearch->SearchValue2 = @$filter["y_province_name_kh"];
		$this->province_name_kh->AdvancedSearch->SearchOperator2 = @$filter["w_province_name_kh"];
		$this->province_name_kh->AdvancedSearch->Save();

		// Field province_name_en
		$this->province_name_en->AdvancedSearch->SearchValue = @$filter["x_province_name_en"];
		$this->province_name_en->AdvancedSearch->SearchOperator = @$filter["z_province_name_en"];
		$this->province_name_en->AdvancedSearch->SearchCondition = @$filter["v_province_name_en"];
		$this->province_name_en->AdvancedSearch->SearchValue2 = @$filter["y_province_name_en"];
		$this->province_name_en->AdvancedSearch->SearchOperator2 = @$filter["w_province_name_en"];
		$this->province_name_en->AdvancedSearch->Save();

		// Field capital_kh
		$this->capital_kh->AdvancedSearch->SearchValue = @$filter["x_capital_kh"];
		$this->capital_kh->AdvancedSearch->SearchOperator = @$filter["z_capital_kh"];
		$this->capital_kh->AdvancedSearch->SearchCondition = @$filter["v_capital_kh"];
		$this->capital_kh->AdvancedSearch->SearchValue2 = @$filter["y_capital_kh"];
		$this->capital_kh->AdvancedSearch->SearchOperator2 = @$filter["w_capital_kh"];
		$this->capital_kh->AdvancedSearch->Save();

		// Field capital_en
		$this->capital_en->AdvancedSearch->SearchValue = @$filter["x_capital_en"];
		$this->capital_en->AdvancedSearch->SearchOperator = @$filter["z_capital_en"];
		$this->capital_en->AdvancedSearch->SearchCondition = @$filter["v_capital_en"];
		$this->capital_en->AdvancedSearch->SearchValue2 = @$filter["y_capital_en"];
		$this->capital_en->AdvancedSearch->SearchOperator2 = @$filter["w_capital_en"];
		$this->capital_en->AdvancedSearch->Save();

		// Field population_kh
		$this->population_kh->AdvancedSearch->SearchValue = @$filter["x_population_kh"];
		$this->population_kh->AdvancedSearch->SearchOperator = @$filter["z_population_kh"];
		$this->population_kh->AdvancedSearch->SearchCondition = @$filter["v_population_kh"];
		$this->population_kh->AdvancedSearch->SearchValue2 = @$filter["y_population_kh"];
		$this->population_kh->AdvancedSearch->SearchOperator2 = @$filter["w_population_kh"];
		$this->population_kh->AdvancedSearch->Save();

		// Field population_en
		$this->population_en->AdvancedSearch->SearchValue = @$filter["x_population_en"];
		$this->population_en->AdvancedSearch->SearchOperator = @$filter["z_population_en"];
		$this->population_en->AdvancedSearch->SearchCondition = @$filter["v_population_en"];
		$this->population_en->AdvancedSearch->SearchValue2 = @$filter["y_population_en"];
		$this->population_en->AdvancedSearch->SearchOperator2 = @$filter["w_population_en"];
		$this->population_en->AdvancedSearch->Save();

		// Field area_kh
		$this->area_kh->AdvancedSearch->SearchValue = @$filter["x_area_kh"];
		$this->area_kh->AdvancedSearch->SearchOperator = @$filter["z_area_kh"];
		$this->area_kh->AdvancedSearch->SearchCondition = @$filter["v_area_kh"];
		$this->area_kh->AdvancedSearch->SearchValue2 = @$filter["y_area_kh"];
		$this->area_kh->AdvancedSearch->SearchOperator2 = @$filter["w_area_kh"];
		$this->area_kh->AdvancedSearch->Save();

		// Field area_en
		$this->area_en->AdvancedSearch->SearchValue = @$filter["x_area_en"];
		$this->area_en->AdvancedSearch->SearchOperator = @$filter["z_area_en"];
		$this->area_en->AdvancedSearch->SearchCondition = @$filter["v_area_en"];
		$this->area_en->AdvancedSearch->SearchValue2 = @$filter["y_area_en"];
		$this->area_en->AdvancedSearch->SearchOperator2 = @$filter["w_area_en"];
		$this->area_en->AdvancedSearch->Save();

		// Field density_kh
		$this->density_kh->AdvancedSearch->SearchValue = @$filter["x_density_kh"];
		$this->density_kh->AdvancedSearch->SearchOperator = @$filter["z_density_kh"];
		$this->density_kh->AdvancedSearch->SearchCondition = @$filter["v_density_kh"];
		$this->density_kh->AdvancedSearch->SearchValue2 = @$filter["y_density_kh"];
		$this->density_kh->AdvancedSearch->SearchOperator2 = @$filter["w_density_kh"];
		$this->density_kh->AdvancedSearch->Save();

		// Field density_en
		$this->density_en->AdvancedSearch->SearchValue = @$filter["x_density_en"];
		$this->density_en->AdvancedSearch->SearchOperator = @$filter["z_density_en"];
		$this->density_en->AdvancedSearch->SearchCondition = @$filter["v_density_en"];
		$this->density_en->AdvancedSearch->SearchValue2 = @$filter["y_density_en"];
		$this->density_en->AdvancedSearch->SearchOperator2 = @$filter["w_density_en"];
		$this->density_en->AdvancedSearch->Save();

		// Field province_code
		$this->province_code->AdvancedSearch->SearchValue = @$filter["x_province_code"];
		$this->province_code->AdvancedSearch->SearchOperator = @$filter["z_province_code"];
		$this->province_code->AdvancedSearch->SearchCondition = @$filter["v_province_code"];
		$this->province_code->AdvancedSearch->SearchValue2 = @$filter["y_province_code"];
		$this->province_code->AdvancedSearch->SearchOperator2 = @$filter["w_province_code"];
		$this->province_code->AdvancedSearch->Save();

		// Field image
		$this->image->AdvancedSearch->SearchValue = @$filter["x_image"];
		$this->image->AdvancedSearch->SearchOperator = @$filter["z_image"];
		$this->image->AdvancedSearch->SearchCondition = @$filter["v_image"];
		$this->image->AdvancedSearch->SearchValue2 = @$filter["y_image"];
		$this->image->AdvancedSearch->SearchOperator2 = @$filter["w_image"];
		$this->image->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->province_name_kh, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->province_name_en, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->capital_kh, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->capital_en, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->population_kh, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->population_en, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->area_kh, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->area_en, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->density_kh, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->density_en, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->province_code, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->image, $arKeywords, $type);
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

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->province_id, $bCtrl); // province_id
			$this->UpdateSort($this->country_id, $bCtrl); // country_id
			$this->UpdateSort($this->province_name_kh, $bCtrl); // province_name_kh
			$this->UpdateSort($this->province_name_en, $bCtrl); // province_name_en
			$this->UpdateSort($this->capital_kh, $bCtrl); // capital_kh
			$this->UpdateSort($this->capital_en, $bCtrl); // capital_en
			$this->UpdateSort($this->population_kh, $bCtrl); // population_kh
			$this->UpdateSort($this->population_en, $bCtrl); // population_en
			$this->UpdateSort($this->area_kh, $bCtrl); // area_kh
			$this->UpdateSort($this->area_en, $bCtrl); // area_en
			$this->UpdateSort($this->density_kh, $bCtrl); // density_kh
			$this->UpdateSort($this->density_en, $bCtrl); // density_en
			$this->UpdateSort($this->province_code, $bCtrl); // province_code
			$this->UpdateSort($this->image, $bCtrl); // image
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
				$this->province_id->setSort("");
				$this->country_id->setSort("");
				$this->province_name_kh->setSort("");
				$this->province_name_en->setSort("");
				$this->capital_kh->setSort("");
				$this->capital_en->setSort("");
				$this->population_kh->setSort("");
				$this->population_en->setSort("");
				$this->area_kh->setSort("");
				$this->area_en->setSort("");
				$this->density_kh->setSort("");
				$this->density_en->setSort("");
				$this->province_code->setSort("");
				$this->image->setSort("");
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
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->province_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->country_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
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

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fprovincelist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fprovincelistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fprovincelistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fprovincelist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fprovincelistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

			// province_id
			$this->province_id->LinkCustomAttributes = "";
			$this->province_id->HrefValue = "";
			$this->province_id->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Build export filter for selected records
	function BuildExportSelectedFilter() {
		global $Language;
		$sWrkFilter = "";
		if ($this->Export <> "") {
			$sWrkFilter = $this->GetKeyFilter();
		}
		return $sWrkFilter;
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.fprovincelist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.fprovincelist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.fprovincelist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.fprovincelist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.fprovincelist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.fprovincelist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.fprovincelist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_province\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_province',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fprovincelist,sel:true" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->ListRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetupStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			echo $this->ExportEmail($Doc->Text);
		} else {
			$Doc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_POST["sender"];
		$sRecipient = @$_POST["recipient"];
		$sCc = @$_POST["cc"];
		$sBcc = @$_POST["bcc"];

		// Subject
		$sSubject = @$_POST["subject"];
		$sEmailSubject = $sSubject;

		// Message
		$sContent = @$_POST["message"];
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-danger\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = "html";
		if ($sEmailMessage <> "")
			$sEmailMessage = ew_RemoveXSS($sEmailMessage) . "<br><br>";
		foreach ($gTmpImages as $tmpimage)
			$Email->AddEmbeddedImage($tmpimage);
		$Email->Content = $sEmailMessage . ew_CleanEmailContent($EmailContent); // Content
		$EventArgs = array();
		if ($this->Recordset) {
			$this->RecCnt = $this->StartRec - 1;
			$this->Recordset->MoveFirst();
			if ($this->StartRec > 1)
				$this->Recordset->Move($this->StartRec - 1);
			$EventArgs["rs"] = &$this->Recordset;
		}
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<p class=\"text-success\">" . $Language->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {

			// Sent email failure
			return "<p class=\"text-danger\">" . $Email->SendErrDescription . "</p>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";
		if (isset($_GET["key_m"])) {
			$nKeys = count($_GET["key_m"]);
			foreach ($_GET["key_m"] as $key)
				$sQry .= "&key_m[]=" . $key;
		}
		return $sQry;
	}

	// Add search QueryString
	function AddSearchQueryString(&$Qry, &$Fld) {
		$FldSearchValue = $Fld->AdvancedSearch->getValue("x");
		$FldParm = substr($Fld->FldVar,2);
		if (strval($FldSearchValue) <> "") {
			$Qry .= "&x_" . $FldParm . "=" . urlencode($FldSearchValue) .
				"&z_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("z"));
		}
		$FldSearchValue2 = $Fld->AdvancedSearch->getValue("y");
		if (strval($FldSearchValue2) <> "") {
			$Qry .= "&v_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("v")) .
				"&y_" . $FldParm . "=" . urlencode($FldSearchValue2) .
				"&w_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("w"));
		}
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
if (!isset($province_list)) $province_list = new cprovince_list();

// Page init
$province_list->Page_Init();

// Page main
$province_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$province_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($province->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fprovincelist = new ew_Form("fprovincelist", "list");
fprovincelist.FormKeyCountName = '<?php echo $province_list->FormKeyCountName ?>';

// Form_CustomValidate event
fprovincelist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fprovincelist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fprovincelistsrch = new ew_Form("fprovincelistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($province->Export == "") { ?>
<div class="ewToolbar">
<?php if ($province_list->TotalRecs > 0 && $province_list->ExportOptions->Visible()) { ?>
<?php $province_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($province_list->SearchOptions->Visible()) { ?>
<?php $province_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($province_list->FilterOptions->Visible()) { ?>
<?php $province_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $province_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($province_list->TotalRecs <= 0)
			$province_list->TotalRecs = $province->ListRecordCount();
	} else {
		if (!$province_list->Recordset && ($province_list->Recordset = $province_list->LoadRecordset()))
			$province_list->TotalRecs = $province_list->Recordset->RecordCount();
	}
	$province_list->StartRec = 1;
	if ($province_list->DisplayRecs <= 0 || ($province->Export <> "" && $province->ExportAll)) // Display all records
		$province_list->DisplayRecs = $province_list->TotalRecs;
	if (!($province->Export <> "" && $province->ExportAll))
		$province_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$province_list->Recordset = $province_list->LoadRecordset($province_list->StartRec-1, $province_list->DisplayRecs);

	// Set no record found message
	if ($province->CurrentAction == "" && $province_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$province_list->setWarningMessage(ew_DeniedMsg());
		if ($province_list->SearchWhere == "0=101")
			$province_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$province_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$province_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($province->Export == "" && $province->CurrentAction == "") { ?>
<form name="fprovincelistsrch" id="fprovincelistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($province_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fprovincelistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="province">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($province_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($province_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $province_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($province_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($province_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($province_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($province_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $province_list->ShowPageHeader(); ?>
<?php
$province_list->ShowMessage();
?>
<?php if ($province_list->TotalRecs > 0 || $province->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($province_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> province">
<?php if ($province->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($province->CurrentAction <> "gridadd" && $province->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($province_list->Pager)) $province_list->Pager = new cPrevNextPager($province_list->StartRec, $province_list->DisplayRecs, $province_list->TotalRecs, $province_list->AutoHidePager) ?>
<?php if ($province_list->Pager->RecordCount > 0 && $province_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($province_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $province_list->PageUrl() ?>start=<?php echo $province_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($province_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $province_list->PageUrl() ?>start=<?php echo $province_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $province_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($province_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $province_list->PageUrl() ?>start=<?php echo $province_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($province_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $province_list->PageUrl() ?>start=<?php echo $province_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $province_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($province_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $province_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $province_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $province_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($province_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fprovincelist" id="fprovincelist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($province_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $province_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="province">
<input type="hidden" name="exporttype" id="exporttype" value="">
<div id="gmp_province" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($province_list->TotalRecs > 0 || $province->CurrentAction == "gridedit") { ?>
<table id="tbl_provincelist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$province_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$province_list->RenderListOptions();

// Render list options (header, left)
$province_list->ListOptions->Render("header", "left");
?>
<?php if ($province->province_id->Visible) { // province_id ?>
	<?php if ($province->SortUrl($province->province_id) == "") { ?>
		<th data-name="province_id" class="<?php echo $province->province_id->HeaderCellClass() ?>"><div id="elh_province_province_id" class="province_province_id"><div class="ewTableHeaderCaption"><?php echo $province->province_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="province_id" class="<?php echo $province->province_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->province_id) ?>',2);"><div id="elh_province_province_id" class="province_province_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->province_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($province->province_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->province_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->country_id->Visible) { // country_id ?>
	<?php if ($province->SortUrl($province->country_id) == "") { ?>
		<th data-name="country_id" class="<?php echo $province->country_id->HeaderCellClass() ?>"><div id="elh_province_country_id" class="province_country_id"><div class="ewTableHeaderCaption"><?php echo $province->country_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="country_id" class="<?php echo $province->country_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->country_id) ?>',2);"><div id="elh_province_country_id" class="province_country_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->country_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($province->country_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->country_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->province_name_kh->Visible) { // province_name_kh ?>
	<?php if ($province->SortUrl($province->province_name_kh) == "") { ?>
		<th data-name="province_name_kh" class="<?php echo $province->province_name_kh->HeaderCellClass() ?>"><div id="elh_province_province_name_kh" class="province_province_name_kh"><div class="ewTableHeaderCaption"><?php echo $province->province_name_kh->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="province_name_kh" class="<?php echo $province->province_name_kh->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->province_name_kh) ?>',2);"><div id="elh_province_province_name_kh" class="province_province_name_kh">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->province_name_kh->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($province->province_name_kh->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->province_name_kh->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->province_name_en->Visible) { // province_name_en ?>
	<?php if ($province->SortUrl($province->province_name_en) == "") { ?>
		<th data-name="province_name_en" class="<?php echo $province->province_name_en->HeaderCellClass() ?>"><div id="elh_province_province_name_en" class="province_province_name_en"><div class="ewTableHeaderCaption"><?php echo $province->province_name_en->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="province_name_en" class="<?php echo $province->province_name_en->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->province_name_en) ?>',2);"><div id="elh_province_province_name_en" class="province_province_name_en">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->province_name_en->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($province->province_name_en->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->province_name_en->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->capital_kh->Visible) { // capital_kh ?>
	<?php if ($province->SortUrl($province->capital_kh) == "") { ?>
		<th data-name="capital_kh" class="<?php echo $province->capital_kh->HeaderCellClass() ?>"><div id="elh_province_capital_kh" class="province_capital_kh"><div class="ewTableHeaderCaption"><?php echo $province->capital_kh->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="capital_kh" class="<?php echo $province->capital_kh->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->capital_kh) ?>',2);"><div id="elh_province_capital_kh" class="province_capital_kh">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->capital_kh->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($province->capital_kh->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->capital_kh->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->capital_en->Visible) { // capital_en ?>
	<?php if ($province->SortUrl($province->capital_en) == "") { ?>
		<th data-name="capital_en" class="<?php echo $province->capital_en->HeaderCellClass() ?>"><div id="elh_province_capital_en" class="province_capital_en"><div class="ewTableHeaderCaption"><?php echo $province->capital_en->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="capital_en" class="<?php echo $province->capital_en->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->capital_en) ?>',2);"><div id="elh_province_capital_en" class="province_capital_en">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->capital_en->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($province->capital_en->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->capital_en->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->population_kh->Visible) { // population_kh ?>
	<?php if ($province->SortUrl($province->population_kh) == "") { ?>
		<th data-name="population_kh" class="<?php echo $province->population_kh->HeaderCellClass() ?>"><div id="elh_province_population_kh" class="province_population_kh"><div class="ewTableHeaderCaption"><?php echo $province->population_kh->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="population_kh" class="<?php echo $province->population_kh->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->population_kh) ?>',2);"><div id="elh_province_population_kh" class="province_population_kh">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->population_kh->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($province->population_kh->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->population_kh->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->population_en->Visible) { // population_en ?>
	<?php if ($province->SortUrl($province->population_en) == "") { ?>
		<th data-name="population_en" class="<?php echo $province->population_en->HeaderCellClass() ?>"><div id="elh_province_population_en" class="province_population_en"><div class="ewTableHeaderCaption"><?php echo $province->population_en->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="population_en" class="<?php echo $province->population_en->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->population_en) ?>',2);"><div id="elh_province_population_en" class="province_population_en">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->population_en->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($province->population_en->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->population_en->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->area_kh->Visible) { // area_kh ?>
	<?php if ($province->SortUrl($province->area_kh) == "") { ?>
		<th data-name="area_kh" class="<?php echo $province->area_kh->HeaderCellClass() ?>"><div id="elh_province_area_kh" class="province_area_kh"><div class="ewTableHeaderCaption"><?php echo $province->area_kh->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="area_kh" class="<?php echo $province->area_kh->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->area_kh) ?>',2);"><div id="elh_province_area_kh" class="province_area_kh">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->area_kh->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($province->area_kh->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->area_kh->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->area_en->Visible) { // area_en ?>
	<?php if ($province->SortUrl($province->area_en) == "") { ?>
		<th data-name="area_en" class="<?php echo $province->area_en->HeaderCellClass() ?>"><div id="elh_province_area_en" class="province_area_en"><div class="ewTableHeaderCaption"><?php echo $province->area_en->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="area_en" class="<?php echo $province->area_en->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->area_en) ?>',2);"><div id="elh_province_area_en" class="province_area_en">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->area_en->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($province->area_en->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->area_en->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->density_kh->Visible) { // density_kh ?>
	<?php if ($province->SortUrl($province->density_kh) == "") { ?>
		<th data-name="density_kh" class="<?php echo $province->density_kh->HeaderCellClass() ?>"><div id="elh_province_density_kh" class="province_density_kh"><div class="ewTableHeaderCaption"><?php echo $province->density_kh->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="density_kh" class="<?php echo $province->density_kh->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->density_kh) ?>',2);"><div id="elh_province_density_kh" class="province_density_kh">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->density_kh->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($province->density_kh->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->density_kh->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->density_en->Visible) { // density_en ?>
	<?php if ($province->SortUrl($province->density_en) == "") { ?>
		<th data-name="density_en" class="<?php echo $province->density_en->HeaderCellClass() ?>"><div id="elh_province_density_en" class="province_density_en"><div class="ewTableHeaderCaption"><?php echo $province->density_en->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="density_en" class="<?php echo $province->density_en->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->density_en) ?>',2);"><div id="elh_province_density_en" class="province_density_en">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->density_en->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($province->density_en->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->density_en->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->province_code->Visible) { // province_code ?>
	<?php if ($province->SortUrl($province->province_code) == "") { ?>
		<th data-name="province_code" class="<?php echo $province->province_code->HeaderCellClass() ?>"><div id="elh_province_province_code" class="province_province_code"><div class="ewTableHeaderCaption"><?php echo $province->province_code->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="province_code" class="<?php echo $province->province_code->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->province_code) ?>',2);"><div id="elh_province_province_code" class="province_province_code">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->province_code->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($province->province_code->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->province_code->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($province->image->Visible) { // image ?>
	<?php if ($province->SortUrl($province->image) == "") { ?>
		<th data-name="image" class="<?php echo $province->image->HeaderCellClass() ?>"><div id="elh_province_image" class="province_image"><div class="ewTableHeaderCaption"><?php echo $province->image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="image" class="<?php echo $province->image->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $province->SortUrl($province->image) ?>',2);"><div id="elh_province_image" class="province_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $province->image->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($province->image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($province->image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$province_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($province->ExportAll && $province->Export <> "") {
	$province_list->StopRec = $province_list->TotalRecs;
} else {

	// Set the last record to display
	if ($province_list->TotalRecs > $province_list->StartRec + $province_list->DisplayRecs - 1)
		$province_list->StopRec = $province_list->StartRec + $province_list->DisplayRecs - 1;
	else
		$province_list->StopRec = $province_list->TotalRecs;
}
$province_list->RecCnt = $province_list->StartRec - 1;
if ($province_list->Recordset && !$province_list->Recordset->EOF) {
	$province_list->Recordset->MoveFirst();
	$bSelectLimit = $province_list->UseSelectLimit;
	if (!$bSelectLimit && $province_list->StartRec > 1)
		$province_list->Recordset->Move($province_list->StartRec - 1);
} elseif (!$province->AllowAddDeleteRow && $province_list->StopRec == 0) {
	$province_list->StopRec = $province->GridAddRowCount;
}

// Initialize aggregate
$province->RowType = EW_ROWTYPE_AGGREGATEINIT;
$province->ResetAttrs();
$province_list->RenderRow();
while ($province_list->RecCnt < $province_list->StopRec) {
	$province_list->RecCnt++;
	if (intval($province_list->RecCnt) >= intval($province_list->StartRec)) {
		$province_list->RowCnt++;

		// Set up key count
		$province_list->KeyCount = $province_list->RowIndex;

		// Init row class and style
		$province->ResetAttrs();
		$province->CssClass = "";
		if ($province->CurrentAction == "gridadd") {
		} else {
			$province_list->LoadRowValues($province_list->Recordset); // Load row values
		}
		$province->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$province->RowAttrs = array_merge($province->RowAttrs, array('data-rowindex'=>$province_list->RowCnt, 'id'=>'r' . $province_list->RowCnt . '_province', 'data-rowtype'=>$province->RowType));

		// Render row
		$province_list->RenderRow();

		// Render list options
		$province_list->RenderListOptions();
?>
	<tr<?php echo $province->RowAttributes() ?>>
<?php

// Render list options (body, left)
$province_list->ListOptions->Render("body", "left", $province_list->RowCnt);
?>
	<?php if ($province->province_id->Visible) { // province_id ?>
		<td data-name="province_id"<?php echo $province->province_id->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_province_id" class="province_province_id">
<span<?php echo $province->province_id->ViewAttributes() ?>>
<?php echo $province->province_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->country_id->Visible) { // country_id ?>
		<td data-name="country_id"<?php echo $province->country_id->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_country_id" class="province_country_id">
<span<?php echo $province->country_id->ViewAttributes() ?>>
<?php echo $province->country_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->province_name_kh->Visible) { // province_name_kh ?>
		<td data-name="province_name_kh"<?php echo $province->province_name_kh->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_province_name_kh" class="province_province_name_kh">
<span<?php echo $province->province_name_kh->ViewAttributes() ?>>
<?php echo $province->province_name_kh->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->province_name_en->Visible) { // province_name_en ?>
		<td data-name="province_name_en"<?php echo $province->province_name_en->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_province_name_en" class="province_province_name_en">
<span<?php echo $province->province_name_en->ViewAttributes() ?>>
<?php echo $province->province_name_en->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->capital_kh->Visible) { // capital_kh ?>
		<td data-name="capital_kh"<?php echo $province->capital_kh->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_capital_kh" class="province_capital_kh">
<span<?php echo $province->capital_kh->ViewAttributes() ?>>
<?php echo $province->capital_kh->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->capital_en->Visible) { // capital_en ?>
		<td data-name="capital_en"<?php echo $province->capital_en->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_capital_en" class="province_capital_en">
<span<?php echo $province->capital_en->ViewAttributes() ?>>
<?php echo $province->capital_en->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->population_kh->Visible) { // population_kh ?>
		<td data-name="population_kh"<?php echo $province->population_kh->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_population_kh" class="province_population_kh">
<span<?php echo $province->population_kh->ViewAttributes() ?>>
<?php echo $province->population_kh->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->population_en->Visible) { // population_en ?>
		<td data-name="population_en"<?php echo $province->population_en->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_population_en" class="province_population_en">
<span<?php echo $province->population_en->ViewAttributes() ?>>
<?php echo $province->population_en->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->area_kh->Visible) { // area_kh ?>
		<td data-name="area_kh"<?php echo $province->area_kh->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_area_kh" class="province_area_kh">
<span<?php echo $province->area_kh->ViewAttributes() ?>>
<?php echo $province->area_kh->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->area_en->Visible) { // area_en ?>
		<td data-name="area_en"<?php echo $province->area_en->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_area_en" class="province_area_en">
<span<?php echo $province->area_en->ViewAttributes() ?>>
<?php echo $province->area_en->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->density_kh->Visible) { // density_kh ?>
		<td data-name="density_kh"<?php echo $province->density_kh->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_density_kh" class="province_density_kh">
<span<?php echo $province->density_kh->ViewAttributes() ?>>
<?php echo $province->density_kh->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->density_en->Visible) { // density_en ?>
		<td data-name="density_en"<?php echo $province->density_en->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_density_en" class="province_density_en">
<span<?php echo $province->density_en->ViewAttributes() ?>>
<?php echo $province->density_en->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->province_code->Visible) { // province_code ?>
		<td data-name="province_code"<?php echo $province->province_code->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_province_code" class="province_province_code">
<span<?php echo $province->province_code->ViewAttributes() ?>>
<?php echo $province->province_code->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($province->image->Visible) { // image ?>
		<td data-name="image"<?php echo $province->image->CellAttributes() ?>>
<span id="el<?php echo $province_list->RowCnt ?>_province_image" class="province_image">
<span<?php echo $province->image->ViewAttributes() ?>>
<?php echo $province->image->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$province_list->ListOptions->Render("body", "right", $province_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($province->CurrentAction <> "gridadd")
		$province_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($province->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($province_list->Recordset)
	$province_list->Recordset->Close();
?>
<?php if ($province->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($province->CurrentAction <> "gridadd" && $province->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($province_list->Pager)) $province_list->Pager = new cPrevNextPager($province_list->StartRec, $province_list->DisplayRecs, $province_list->TotalRecs, $province_list->AutoHidePager) ?>
<?php if ($province_list->Pager->RecordCount > 0 && $province_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($province_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $province_list->PageUrl() ?>start=<?php echo $province_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($province_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $province_list->PageUrl() ?>start=<?php echo $province_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $province_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($province_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $province_list->PageUrl() ?>start=<?php echo $province_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($province_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $province_list->PageUrl() ?>start=<?php echo $province_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $province_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($province_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $province_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $province_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $province_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($province_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($province_list->TotalRecs == 0 && $province->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($province_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($province->Export == "") { ?>
<script type="text/javascript">
fprovincelistsrch.FilterList = <?php echo $province_list->GetFilterList() ?>;
fprovincelistsrch.Init();
fprovincelist.Init();
</script>
<?php } ?>
<?php
$province_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($province->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$province_list->Page_Terminate();
?>

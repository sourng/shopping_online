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
		// Create form object

		$objForm = new cFormObj();

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
		$this->company_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->company_id->Visible = FALSE;
		$this->com_fname->SetVisibility();
		$this->com_lname->SetVisibility();
		$this->com_name->SetVisibility();
		$this->com_phone->SetVisibility();
		$this->com_email->SetVisibility();
		$this->com_logo->SetVisibility();
		$this->com_username->SetVisibility();
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
	var $DisplayRecs = 10;
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
	var $HashValue; // Hash value
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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
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
			$this->DisplayRecs = 10; // Load default
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

	// Exit inline mode
	function ClearInlineMode() {
		$this->setKey("company_id", ""); // Clear inline edit key
		$this->setKey("country_id", ""); // Clear inline edit key
		$this->setKey("province_id", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (isset($_GET["company_id"])) {
			$this->company_id->setQueryStringValue($_GET["company_id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if (isset($_GET["country_id"])) {
			$this->country_id->setQueryStringValue($_GET["country_id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if (isset($_GET["province_id"])) {
			$this->province_id->setQueryStringValue($_GET["province_id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("company_id", $this->company_id->CurrentValue); // Set up inline edit key
				$this->setKey("country_id", $this->country_id->CurrentValue); // Set up inline edit key
				$this->setKey("province_id", $this->province_id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {

			// Overwrite record, just reload hash value
			if ($this->CurrentAction == "overwrite")
				$this->LoadRowHash();
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("company_id")) <> strval($this->company_id->CurrentValue))
			return FALSE;
		if (strval($this->getKey("country_id")) <> strval($this->country_id->CurrentValue))
			return FALSE;
		if (strval($this->getKey("province_id")) <> strval($this->province_id->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		$this->CurrentAction = "add";
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old record
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {

								// Overwrite record, just reload hash value
								if ($this->CurrentAction == "gridoverwrite")
									$this->LoadRowHash();
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
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
		if (count($arrKeyFlds) >= 3) {
			$this->company_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->company_id->FormValue))
				return FALSE;
			$this->country_id->setFormValue($arrKeyFlds[1]);
			if (!is_numeric($this->country_id->FormValue))
				return FALSE;
			$this->province_id->setFormValue($arrKeyFlds[2]);
			if (!is_numeric($this->province_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->company_id->CurrentValue;
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->country_id->CurrentValue;
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->province_id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_com_fname") && $objForm->HasValue("o_com_fname") && $this->com_fname->CurrentValue <> $this->com_fname->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_com_lname") && $objForm->HasValue("o_com_lname") && $this->com_lname->CurrentValue <> $this->com_lname->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_com_name") && $objForm->HasValue("o_com_name") && $this->com_name->CurrentValue <> $this->com_name->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_com_phone") && $objForm->HasValue("o_com_phone") && $this->com_phone->CurrentValue <> $this->com_phone->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_com_email") && $objForm->HasValue("o_com_email") && $this->com_email->CurrentValue <> $this->com_email->OldValue)
			return FALSE;
		if (!ew_Empty($this->com_logo->Upload->Value))
			return FALSE;
		if ($objForm->HasValue("x_com_username") && $objForm->HasValue("o_com_username") && $this->com_username->CurrentValue <> $this->com_username->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_country_id") && $objForm->HasValue("o_country_id") && $this->country_id->CurrentValue <> $this->country_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_province_id") && $objForm->HasValue("o_province_id") && $this->province_id->CurrentValue <> $this->province_id->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
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
		$sFilterList = ew_Concat($sFilterList, $this->com_username->AdvancedSearch->ToJson(), ","); // Field com_username
		$sFilterList = ew_Concat($sFilterList, $this->com_password->AdvancedSearch->ToJson(), ","); // Field com_password
		$sFilterList = ew_Concat($sFilterList, $this->com_online->AdvancedSearch->ToJson(), ","); // Field com_online
		$sFilterList = ew_Concat($sFilterList, $this->com_activation->AdvancedSearch->ToJson(), ","); // Field com_activation
		$sFilterList = ew_Concat($sFilterList, $this->com_status->AdvancedSearch->ToJson(), ","); // Field com_status
		$sFilterList = ew_Concat($sFilterList, $this->reg_date->AdvancedSearch->ToJson(), ","); // Field reg_date
		$sFilterList = ew_Concat($sFilterList, $this->country_id->AdvancedSearch->ToJson(), ","); // Field country_id
		$sFilterList = ew_Concat($sFilterList, $this->province_id->AdvancedSearch->ToJson(), ","); // Field province_id
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

		// Field country_id
		$this->country_id->AdvancedSearch->SearchValue = @$filter["x_country_id"];
		$this->country_id->AdvancedSearch->SearchOperator = @$filter["z_country_id"];
		$this->country_id->AdvancedSearch->SearchCondition = @$filter["v_country_id"];
		$this->country_id->AdvancedSearch->SearchValue2 = @$filter["y_country_id"];
		$this->country_id->AdvancedSearch->SearchOperator2 = @$filter["w_country_id"];
		$this->country_id->AdvancedSearch->Save();

		// Field province_id
		$this->province_id->AdvancedSearch->SearchValue = @$filter["x_province_id"];
		$this->province_id->AdvancedSearch->SearchOperator = @$filter["z_province_id"];
		$this->province_id->AdvancedSearch->SearchCondition = @$filter["v_province_id"];
		$this->province_id->AdvancedSearch->SearchValue2 = @$filter["y_province_id"];
		$this->province_id->AdvancedSearch->SearchOperator2 = @$filter["w_province_id"];
		$this->province_id->AdvancedSearch->Save();
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

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->company_id, $bCtrl); // company_id
			$this->UpdateSort($this->com_fname, $bCtrl); // com_fname
			$this->UpdateSort($this->com_lname, $bCtrl); // com_lname
			$this->UpdateSort($this->com_name, $bCtrl); // com_name
			$this->UpdateSort($this->com_phone, $bCtrl); // com_phone
			$this->UpdateSort($this->com_email, $bCtrl); // com_email
			$this->UpdateSort($this->com_logo, $bCtrl); // com_logo
			$this->UpdateSort($this->com_username, $bCtrl); // com_username
			$this->UpdateSort($this->country_id, $bCtrl); // country_id
			$this->UpdateSort($this->province_id, $bCtrl); // province_id
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
				$this->setSessionOrderByList($sOrderBy);
				$this->company_id->setSort("");
				$this->com_fname->setSort("");
				$this->com_lname->setSort("");
				$this->com_name->setSort("");
				$this->com_phone->setSort("");
				$this->com_email->setSort("");
				$this->com_logo->setSort("");
				$this->com_username->setSort("");
				$this->country_id->setSort("");
				$this->province_id->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			if ($this->UpdateConflict == "U") {
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineReload\" title=\"" . ew_HtmlTitle($Language->Phrase("ReloadLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ReloadLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddHash($this->InlineEditUrl, "r" . $this->RowCnt . "_" . $this->TableVar)) . "\">" .
					$Language->Phrase("ReloadLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineOverwrite\" title=\"" . ew_HtmlTitle($Language->Phrase("OverwriteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("OverwriteLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_UrlAddHash($this->PageName(), "r" . $this->RowCnt . "_" . $this->TableVar) . "');\">" . $Language->Phrase("OverwriteLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("ConflictCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ConflictCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("ConflictCancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"overwrite\"></div>";
			} else {
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_UrlAddHash($this->PageName(), "r" . $this->RowCnt . "_" . $this->TableVar) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			}
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_hash\" id=\"k" . $this->RowIndex . "_hash\" value=\"" . $this->HashValue . "\">";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->company_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->country_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->province_id->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"company\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "',btn:null});\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"company\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'SaveBtn',url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddHash($this->InlineEditUrl, "r" . $this->RowCnt . "_" . $this->TableVar)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-table=\"company\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->CopyUrl) . "'});\">" . $Language->Phrase("CopyLink") . "</a>";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->company_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->country_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->province_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->company_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->country_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->province_id->CurrentValue . "\">";
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_hash\" id=\"k" . $this->RowIndex . "_hash\" value=\"" . $this->HashValue . "\">";
		}
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
		if (ew_IsMobile())
			$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-table=\"company\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fcompanylist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"company\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'UpdateBtn',f:document.fcompanylist,url:'" . $this->MultiUpdateUrl . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
		$item->Visible = ($Security->CanEdit());

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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
				if ($this->UpdateConflict == "U") { // Record already updated by other user
					$item = &$option->Add("reload");
					$item->Body = "<a class=\"ewAction ewGridReload\" title=\"" . ew_HtmlTitle($Language->Phrase("ReloadLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ReloadLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("ReloadLink") . "</a>";
					$item = &$option->Add("overwrite");
					$item->Body = "<a class=\"ewAction ewGridOverwrite\" title=\"" . ew_HtmlTitle($Language->Phrase("OverwriteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("OverwriteLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("OverwriteLink") . "</a>";
					$item = &$option->Add("cancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("ConflictCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ConflictCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("ConflictCancelLink") . "</a>";
				} else {
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
				}
			}
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

		// Search highlight button
		$item = &$this->SearchOptions->Add("searchhighlight");
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewHighlight active\" title=\"" . $Language->Phrase("Highlight") . "\" data-caption=\"" . $Language->Phrase("Highlight") . "\" data-toggle=\"button\" data-form=\"fcompanylistsrch\" data-name=\"" . $this->HighlightName() . "\">" . $Language->Phrase("HighlightBtn") . "</button>";
		$item->Visible = ($this->SearchWhere <> "" && $this->TotalRecs > 0);

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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->company_id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->company_id->setFormValue($objForm->GetValue("x_company_id"));
		if (!$this->com_fname->FldIsDetailKey) {
			$this->com_fname->setFormValue($objForm->GetValue("x_com_fname"));
		}
		$this->com_fname->setOldValue($objForm->GetValue("o_com_fname"));
		if (!$this->com_lname->FldIsDetailKey) {
			$this->com_lname->setFormValue($objForm->GetValue("x_com_lname"));
		}
		$this->com_lname->setOldValue($objForm->GetValue("o_com_lname"));
		if (!$this->com_name->FldIsDetailKey) {
			$this->com_name->setFormValue($objForm->GetValue("x_com_name"));
		}
		$this->com_name->setOldValue($objForm->GetValue("o_com_name"));
		if (!$this->com_phone->FldIsDetailKey) {
			$this->com_phone->setFormValue($objForm->GetValue("x_com_phone"));
		}
		$this->com_phone->setOldValue($objForm->GetValue("o_com_phone"));
		if (!$this->com_email->FldIsDetailKey) {
			$this->com_email->setFormValue($objForm->GetValue("x_com_email"));
		}
		$this->com_email->setOldValue($objForm->GetValue("o_com_email"));
		if (!$this->com_username->FldIsDetailKey) {
			$this->com_username->setFormValue($objForm->GetValue("x_com_username"));
		}
		$this->com_username->setOldValue($objForm->GetValue("o_com_username"));
		if (!$this->country_id->FldIsDetailKey) {
			$this->country_id->setFormValue($objForm->GetValue("x_country_id"));
		}
		$this->country_id->setOldValue($objForm->GetValue("o_country_id"));
		if (!$this->province_id->FldIsDetailKey) {
			$this->province_id->setFormValue($objForm->GetValue("x_province_id"));
		}
		$this->province_id->setOldValue($objForm->GetValue("o_province_id"));
		if ($this->CurrentAction <> "overwrite")
			$this->HashValue = $objForm->GetValue("k_hash");
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->company_id->CurrentValue = $this->company_id->FormValue;
		$this->com_fname->CurrentValue = $this->com_fname->FormValue;
		$this->com_lname->CurrentValue = $this->com_lname->FormValue;
		$this->com_name->CurrentValue = $this->com_name->FormValue;
		$this->com_phone->CurrentValue = $this->com_phone->FormValue;
		$this->com_email->CurrentValue = $this->com_email->FormValue;
		$this->com_username->CurrentValue = $this->com_username->FormValue;
		$this->country_id->CurrentValue = $this->country_id->FormValue;
		$this->province_id->CurrentValue = $this->province_id->FormValue;
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
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderByList())));
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("company_id")) <> "")
			$this->company_id->CurrentValue = $this->getKey("company_id"); // company_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("country_id")) <> "")
			$this->country_id->CurrentValue = $this->getKey("country_id"); // country_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("province_id")) <> "")
			$this->province_id->CurrentValue = $this->getKey("province_id"); // province_id
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

			// company_id
			$this->company_id->LinkCustomAttributes = "";
			$this->company_id->HrefValue = "";
			$this->company_id->TooltipValue = "";

			// com_fname
			$this->com_fname->LinkCustomAttributes = "";
			$this->com_fname->HrefValue = "";
			$this->com_fname->TooltipValue = "";
			if ($this->Export == "")
				$this->com_fname->ViewValue = $this->HighlightValue($this->com_fname);

			// com_lname
			$this->com_lname->LinkCustomAttributes = "";
			$this->com_lname->HrefValue = "";
			$this->com_lname->TooltipValue = "";
			if ($this->Export == "")
				$this->com_lname->ViewValue = $this->HighlightValue($this->com_lname);

			// com_name
			$this->com_name->LinkCustomAttributes = "";
			$this->com_name->HrefValue = "";
			$this->com_name->TooltipValue = "";
			if ($this->Export == "")
				$this->com_name->ViewValue = $this->HighlightValue($this->com_name);

			// com_phone
			$this->com_phone->LinkCustomAttributes = "";
			$this->com_phone->HrefValue = "";
			$this->com_phone->TooltipValue = "";
			if ($this->Export == "")
				$this->com_phone->ViewValue = $this->HighlightValue($this->com_phone);

			// com_email
			$this->com_email->LinkCustomAttributes = "";
			$this->com_email->HrefValue = "";
			$this->com_email->TooltipValue = "";
			if ($this->Export == "")
				$this->com_email->ViewValue = $this->HighlightValue($this->com_email);

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
				$this->com_logo->LinkAttrs["data-rel"] = "company_x" . $this->RowCnt . "_com_logo";
				ew_AppendClass($this->com_logo->LinkAttrs["class"], "ewLightbox");
			}

			// com_username
			$this->com_username->LinkCustomAttributes = "";
			$this->com_username->HrefValue = "";
			$this->com_username->TooltipValue = "";
			if ($this->Export == "")
				$this->com_username->ViewValue = $this->HighlightValue($this->com_username);

			// country_id
			$this->country_id->LinkCustomAttributes = "";
			$this->country_id->HrefValue = "";
			$this->country_id->TooltipValue = "";

			// province_id
			$this->province_id->LinkCustomAttributes = "";
			$this->province_id->HrefValue = "";
			$this->province_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// company_id
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
					if ($this->RowIndex == '$rowindex$')
						$this->com_logo->Upload->FileName = "";
					else
						$this->com_logo->Upload->FileName = $this->com_logo->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->com_logo, $this->RowIndex);

			// com_username
			$this->com_username->EditAttrs["class"] = "form-control";
			$this->com_username->EditCustomAttributes = "";
			$this->com_username->EditValue = ew_HtmlEncode($this->com_username->CurrentValue);
			$this->com_username->PlaceHolder = ew_RemoveHtml($this->com_username->FldCaption());

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
			// company_id

			$this->company_id->LinkCustomAttributes = "";
			$this->company_id->HrefValue = "";

			// com_fname
			$this->com_fname->LinkCustomAttributes = "";
			$this->com_fname->HrefValue = "";

			// com_lname
			$this->com_lname->LinkCustomAttributes = "";
			$this->com_lname->HrefValue = "";

			// com_name
			$this->com_name->LinkCustomAttributes = "";
			$this->com_name->HrefValue = "";

			// com_phone
			$this->com_phone->LinkCustomAttributes = "";
			$this->com_phone->HrefValue = "";

			// com_email
			$this->com_email->LinkCustomAttributes = "";
			$this->com_email->HrefValue = "";

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

			// country_id
			$this->country_id->LinkCustomAttributes = "";
			$this->country_id->HrefValue = "";

			// province_id
			$this->province_id->LinkCustomAttributes = "";
			$this->province_id->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// company_id
			$this->company_id->EditAttrs["class"] = "form-control";
			$this->company_id->EditCustomAttributes = "";
			$this->company_id->EditValue = $this->company_id->CurrentValue;
			$this->company_id->ViewCustomAttributes = "";

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
					if ($this->RowIndex == '$rowindex$')
						$this->com_logo->Upload->FileName = "";
					else
						$this->com_logo->Upload->FileName = $this->com_logo->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->com_logo, $this->RowIndex);

			// com_username
			$this->com_username->EditAttrs["class"] = "form-control";
			$this->com_username->EditCustomAttributes = "";
			$this->com_username->EditValue = ew_HtmlEncode($this->com_username->CurrentValue);
			$this->com_username->PlaceHolder = ew_RemoveHtml($this->com_username->FldCaption());

			// country_id
			$this->country_id->EditAttrs["class"] = "form-control";
			$this->country_id->EditCustomAttributes = "";
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
					$this->country_id->EditValue = $this->country_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->country_id->EditValue = $this->country_id->CurrentValue;
				}
			} else {
				$this->country_id->EditValue = NULL;
			}
			$this->country_id->ViewCustomAttributes = "";

			// province_id
			$this->province_id->EditAttrs["class"] = "form-control";
			$this->province_id->EditCustomAttributes = "";
			if ($this->province_id->VirtualValue <> "") {
				$this->province_id->EditValue = $this->province_id->VirtualValue;
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
					$this->province_id->EditValue = $this->province_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->province_id->EditValue = $this->province_id->CurrentValue;
				}
			} else {
				$this->province_id->EditValue = NULL;
			}
			}
			$this->province_id->ViewCustomAttributes = "";

			// Edit refer script
			// company_id

			$this->company_id->LinkCustomAttributes = "";
			$this->company_id->HrefValue = "";

			// com_fname
			$this->com_fname->LinkCustomAttributes = "";
			$this->com_fname->HrefValue = "";

			// com_lname
			$this->com_lname->LinkCustomAttributes = "";
			$this->com_lname->HrefValue = "";

			// com_name
			$this->com_name->LinkCustomAttributes = "";
			$this->com_name->HrefValue = "";

			// com_phone
			$this->com_phone->LinkCustomAttributes = "";
			$this->com_phone->HrefValue = "";

			// com_email
			$this->com_email->LinkCustomAttributes = "";
			$this->com_email->HrefValue = "";

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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['company_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['country_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['province_id'];

				// Delete old files
				$this->LoadDbValues($row);
				$this->com_logo->OldUploadPath = "../uploads/company";
				$OldFiles = ew_Empty($row['com_logo']) ? array() : array($row['com_logo']);
				$OldFileCount = count($OldFiles);
				for ($i = 0; $i < $OldFileCount; $i++) {
					if (file_exists($this->com_logo->OldPhysicalUploadPath() . $OldFiles[$i]))
						@unlink($this->com_logo->OldPhysicalUploadPath() . $OldFiles[$i]);
				}
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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
			$this->com_logo->OldUploadPath = "../uploads/company";
			$this->com_logo->UploadPath = $this->com_logo->OldUploadPath;
			$rsnew = array();

			// com_fname
			$this->com_fname->SetDbValueDef($rsnew, $this->com_fname->CurrentValue, NULL, $this->com_fname->ReadOnly);

			// com_lname
			$this->com_lname->SetDbValueDef($rsnew, $this->com_lname->CurrentValue, NULL, $this->com_lname->ReadOnly);

			// com_name
			$this->com_name->SetDbValueDef($rsnew, $this->com_name->CurrentValue, NULL, $this->com_name->ReadOnly);

			// com_phone
			$this->com_phone->SetDbValueDef($rsnew, $this->com_phone->CurrentValue, NULL, $this->com_phone->ReadOnly);

			// com_email
			$this->com_email->SetDbValueDef($rsnew, $this->com_email->CurrentValue, NULL, $this->com_email->ReadOnly);

			// com_logo
			if ($this->com_logo->Visible && !$this->com_logo->ReadOnly && !$this->com_logo->Upload->KeepFile) {
				$this->com_logo->Upload->DbValue = $rsold['com_logo']; // Get original value
				if ($this->com_logo->Upload->FileName == "") {
					$rsnew['com_logo'] = NULL;
				} else {
					$rsnew['com_logo'] = $this->com_logo->Upload->FileName;
				}
			}

			// com_username
			$this->com_username->SetDbValueDef($rsnew, $this->com_username->CurrentValue, NULL, $this->com_username->ReadOnly);

			// country_id
			// province_id
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
					$this->com_logo->SetDbValueDef($rsnew, $this->com_logo->Upload->FileName, NULL, $this->com_logo->ReadOnly);
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
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();

		// com_logo
		ew_CleanUploadTempPath($this->com_logo, $this->com_logo->Upload->Index);
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
		$sHash .= ew_GetFldHash($rs->fields('com_fname')); // com_fname
		$sHash .= ew_GetFldHash($rs->fields('com_lname')); // com_lname
		$sHash .= ew_GetFldHash($rs->fields('com_name')); // com_name
		$sHash .= ew_GetFldHash($rs->fields('com_phone')); // com_phone
		$sHash .= ew_GetFldHash($rs->fields('com_email')); // com_email
		$sHash .= ew_GetFldHash($rs->fields('com_logo')); // com_logo
		$sHash .= ew_GetFldHash($rs->fields('com_username')); // com_username
		$sHash .= ew_GetFldHash($rs->fields('country_id')); // country_id
		$sHash .= ew_GetFldHash($rs->fields('province_id')); // province_id
		return md5($sHash);
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

		// com_phone
		$this->com_phone->SetDbValueDef($rsnew, $this->com_phone->CurrentValue, NULL, FALSE);

		// com_email
		$this->com_email->SetDbValueDef($rsnew, $this->com_email->CurrentValue, NULL, FALSE);

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
		$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.fcompanylist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.fcompanylist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.fcompanylist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.fcompanylist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.fcompanylist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.fcompanylist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.fcompanylist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_company\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_company',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fcompanylist,sel:true" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = FALSE;
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
<?php if ($company->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fcompanylist = new ew_Form("fcompanylist", "list");
fcompanylist.FormKeyCountName = '<?php echo $company_list->FormKeyCountName ?>';

// Validate form
fcompanylist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_country_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $company->country_id->FldCaption(), $company->country_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_province_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $company->province_id->FldCaption(), $company->province_id->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fcompanylist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "com_fname", false)) return false;
	if (ew_ValueChanged(fobj, infix, "com_lname", false)) return false;
	if (ew_ValueChanged(fobj, infix, "com_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "com_phone", false)) return false;
	if (ew_ValueChanged(fobj, infix, "com_email", false)) return false;
	if (ew_ValueChanged(fobj, infix, "com_logo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "com_username", false)) return false;
	if (ew_ValueChanged(fobj, infix, "country_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "province_id", false)) return false;
	return true;
}

// Form_CustomValidate event
fcompanylist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcompanylist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcompanylist.Lists["x_country_id"] = {"LinkField":"x_country_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_country_name_kh","x_country_name_en","x_country_code",""],"ParentFields":[],"ChildFields":["x_province_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"country"};
fcompanylist.Lists["x_country_id"].Data = "<?php echo $company_list->country_id->LookupFilterQuery(FALSE, "list") ?>";
fcompanylist.Lists["x_province_id"] = {"LinkField":"x_province_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_province_name_kh","x_province_name_en","",""],"ParentFields":["x_country_id"],"ChildFields":[],"FilterFields":["x_country_id"],"Options":[],"Template":"","LinkTable":"province"};
fcompanylist.Lists["x_province_id"].Data = "<?php echo $company_list->province_id->LookupFilterQuery(FALSE, "list") ?>";

// Form object for search
var CurrentSearchForm = fcompanylistsrch = new ew_Form("fcompanylistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($company->Export == "") { ?>
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
<?php } ?>
<?php
if ($company->CurrentAction == "gridadd") {
	$company->CurrentFilter = "0=1";
	$company_list->StartRec = 1;
	$company_list->DisplayRecs = $company->GridAddRowCount;
	$company_list->TotalRecs = $company_list->DisplayRecs;
	$company_list->StopRec = $company_list->DisplayRecs;
} else {
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
<?php if ($company->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($company->CurrentAction <> "gridadd" && $company->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
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
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fcompanylist" id="fcompanylist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($company_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $company_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="company">
<input type="hidden" name="exporttype" id="exporttype" value="">
<div id="gmp_company" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($company_list->TotalRecs > 0 || $company->CurrentAction == "add" || $company->CurrentAction == "copy" || $company->CurrentAction == "gridedit") { ?>
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
		<th data-name="company_id" class="<?php echo $company->company_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->company_id) ?>',2);"><div id="elh_company_company_id" class="company_company_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->company_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($company->company_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->company_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_fname->Visible) { // com_fname ?>
	<?php if ($company->SortUrl($company->com_fname) == "") { ?>
		<th data-name="com_fname" class="<?php echo $company->com_fname->HeaderCellClass() ?>"><div id="elh_company_com_fname" class="company_com_fname"><div class="ewTableHeaderCaption"><?php echo $company->com_fname->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_fname" class="<?php echo $company->com_fname->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_fname) ?>',2);"><div id="elh_company_com_fname" class="company_com_fname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_fname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_fname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_fname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_lname->Visible) { // com_lname ?>
	<?php if ($company->SortUrl($company->com_lname) == "") { ?>
		<th data-name="com_lname" class="<?php echo $company->com_lname->HeaderCellClass() ?>"><div id="elh_company_com_lname" class="company_com_lname"><div class="ewTableHeaderCaption"><?php echo $company->com_lname->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_lname" class="<?php echo $company->com_lname->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_lname) ?>',2);"><div id="elh_company_com_lname" class="company_com_lname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_lname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_lname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_lname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_name->Visible) { // com_name ?>
	<?php if ($company->SortUrl($company->com_name) == "") { ?>
		<th data-name="com_name" class="<?php echo $company->com_name->HeaderCellClass() ?>"><div id="elh_company_com_name" class="company_com_name"><div class="ewTableHeaderCaption"><?php echo $company->com_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_name" class="<?php echo $company->com_name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_name) ?>',2);"><div id="elh_company_com_name" class="company_com_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_phone->Visible) { // com_phone ?>
	<?php if ($company->SortUrl($company->com_phone) == "") { ?>
		<th data-name="com_phone" class="<?php echo $company->com_phone->HeaderCellClass() ?>"><div id="elh_company_com_phone" class="company_com_phone"><div class="ewTableHeaderCaption"><?php echo $company->com_phone->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_phone" class="<?php echo $company->com_phone->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_phone) ?>',2);"><div id="elh_company_com_phone" class="company_com_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_email->Visible) { // com_email ?>
	<?php if ($company->SortUrl($company->com_email) == "") { ?>
		<th data-name="com_email" class="<?php echo $company->com_email->HeaderCellClass() ?>"><div id="elh_company_com_email" class="company_com_email"><div class="ewTableHeaderCaption"><?php echo $company->com_email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_email" class="<?php echo $company->com_email->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_email) ?>',2);"><div id="elh_company_com_email" class="company_com_email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_logo->Visible) { // com_logo ?>
	<?php if ($company->SortUrl($company->com_logo) == "") { ?>
		<th data-name="com_logo" class="<?php echo $company->com_logo->HeaderCellClass() ?>"><div id="elh_company_com_logo" class="company_com_logo"><div class="ewTableHeaderCaption"><?php echo $company->com_logo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_logo" class="<?php echo $company->com_logo->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_logo) ?>',2);"><div id="elh_company_com_logo" class="company_com_logo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_logo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_logo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_logo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->com_username->Visible) { // com_username ?>
	<?php if ($company->SortUrl($company->com_username) == "") { ?>
		<th data-name="com_username" class="<?php echo $company->com_username->HeaderCellClass() ?>"><div id="elh_company_com_username" class="company_com_username"><div class="ewTableHeaderCaption"><?php echo $company->com_username->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="com_username" class="<?php echo $company->com_username->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->com_username) ?>',2);"><div id="elh_company_com_username" class="company_com_username">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->com_username->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($company->com_username->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->com_username->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->country_id->Visible) { // country_id ?>
	<?php if ($company->SortUrl($company->country_id) == "") { ?>
		<th data-name="country_id" class="<?php echo $company->country_id->HeaderCellClass() ?>"><div id="elh_company_country_id" class="company_country_id"><div class="ewTableHeaderCaption"><?php echo $company->country_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="country_id" class="<?php echo $company->country_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->country_id) ?>',2);"><div id="elh_company_country_id" class="company_country_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->country_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($company->country_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->country_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($company->province_id->Visible) { // province_id ?>
	<?php if ($company->SortUrl($company->province_id) == "") { ?>
		<th data-name="province_id" class="<?php echo $company->province_id->HeaderCellClass() ?>"><div id="elh_company_province_id" class="company_province_id"><div class="ewTableHeaderCaption"><?php echo $company->province_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="province_id" class="<?php echo $company->province_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $company->SortUrl($company->province_id) ?>',2);"><div id="elh_company_province_id" class="company_province_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $company->province_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($company->province_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($company->province_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
	if ($company->CurrentAction == "add" || $company->CurrentAction == "copy") {
		$company_list->RowIndex = 0;
		$company_list->KeyCount = $company_list->RowIndex;
		if ($company->CurrentAction == "add")
			$company_list->LoadRowValues();
		if ($company->EventCancelled) // Insert failed
			$company_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$company->ResetAttrs();
		$company->RowAttrs = array_merge($company->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_company', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$company->RowType = EW_ROWTYPE_ADD;

		// Render row
		$company_list->RenderRow();

		// Render list options
		$company_list->RenderListOptions();
		$company_list->StartRowCnt = 0;
?>
	<tr<?php echo $company->RowAttributes() ?>>
<?php

// Render list options (body, left)
$company_list->ListOptions->Render("body", "left", $company_list->RowCnt);
?>
	<?php if ($company->company_id->Visible) { // company_id ?>
		<td data-name="company_id">
<input type="hidden" data-table="company" data-field="x_company_id" name="o<?php echo $company_list->RowIndex ?>_company_id" id="o<?php echo $company_list->RowIndex ?>_company_id" value="<?php echo ew_HtmlEncode($company->company_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_fname->Visible) { // com_fname ?>
		<td data-name="com_fname">
<span id="el<?php echo $company_list->RowCnt ?>_company_com_fname" class="form-group company_com_fname">
<input type="text" data-table="company" data-field="x_com_fname" name="x<?php echo $company_list->RowIndex ?>_com_fname" id="x<?php echo $company_list->RowIndex ?>_com_fname" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_fname->getPlaceHolder()) ?>" value="<?php echo $company->com_fname->EditValue ?>"<?php echo $company->com_fname->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_fname" name="o<?php echo $company_list->RowIndex ?>_com_fname" id="o<?php echo $company_list->RowIndex ?>_com_fname" value="<?php echo ew_HtmlEncode($company->com_fname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_lname->Visible) { // com_lname ?>
		<td data-name="com_lname">
<span id="el<?php echo $company_list->RowCnt ?>_company_com_lname" class="form-group company_com_lname">
<input type="text" data-table="company" data-field="x_com_lname" name="x<?php echo $company_list->RowIndex ?>_com_lname" id="x<?php echo $company_list->RowIndex ?>_com_lname" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_lname->getPlaceHolder()) ?>" value="<?php echo $company->com_lname->EditValue ?>"<?php echo $company->com_lname->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_lname" name="o<?php echo $company_list->RowIndex ?>_com_lname" id="o<?php echo $company_list->RowIndex ?>_com_lname" value="<?php echo ew_HtmlEncode($company->com_lname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_name->Visible) { // com_name ?>
		<td data-name="com_name">
<span id="el<?php echo $company_list->RowCnt ?>_company_com_name" class="form-group company_com_name">
<input type="text" data-table="company" data-field="x_com_name" name="x<?php echo $company_list->RowIndex ?>_com_name" id="x<?php echo $company_list->RowIndex ?>_com_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_name->getPlaceHolder()) ?>" value="<?php echo $company->com_name->EditValue ?>"<?php echo $company->com_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_name" name="o<?php echo $company_list->RowIndex ?>_com_name" id="o<?php echo $company_list->RowIndex ?>_com_name" value="<?php echo ew_HtmlEncode($company->com_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_phone->Visible) { // com_phone ?>
		<td data-name="com_phone">
<span id="el<?php echo $company_list->RowCnt ?>_company_com_phone" class="form-group company_com_phone">
<input type="text" data-table="company" data-field="x_com_phone" name="x<?php echo $company_list->RowIndex ?>_com_phone" id="x<?php echo $company_list->RowIndex ?>_com_phone" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_phone->getPlaceHolder()) ?>" value="<?php echo $company->com_phone->EditValue ?>"<?php echo $company->com_phone->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_phone" name="o<?php echo $company_list->RowIndex ?>_com_phone" id="o<?php echo $company_list->RowIndex ?>_com_phone" value="<?php echo ew_HtmlEncode($company->com_phone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_email->Visible) { // com_email ?>
		<td data-name="com_email">
<span id="el<?php echo $company_list->RowCnt ?>_company_com_email" class="form-group company_com_email">
<input type="text" data-table="company" data-field="x_com_email" name="x<?php echo $company_list->RowIndex ?>_com_email" id="x<?php echo $company_list->RowIndex ?>_com_email" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_email->getPlaceHolder()) ?>" value="<?php echo $company->com_email->EditValue ?>"<?php echo $company->com_email->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_email" name="o<?php echo $company_list->RowIndex ?>_com_email" id="o<?php echo $company_list->RowIndex ?>_com_email" value="<?php echo ew_HtmlEncode($company->com_email->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_logo->Visible) { // com_logo ?>
		<td data-name="com_logo">
<span id="el<?php echo $company_list->RowCnt ?>_company_com_logo" class="form-group company_com_logo">
<div id="fd_x<?php echo $company_list->RowIndex ?>_com_logo">
<span title="<?php echo $company->com_logo->FldTitle() ? $company->com_logo->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($company->com_logo->ReadOnly || $company->com_logo->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="company" data-field="x_com_logo" name="x<?php echo $company_list->RowIndex ?>_com_logo" id="x<?php echo $company_list->RowIndex ?>_com_logo"<?php echo $company->com_logo->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fn_x<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo $company->com_logo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fa_x<?php echo $company_list->RowIndex ?>_com_logo" value="0">
<input type="hidden" name="fs_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fs_x<?php echo $company_list->RowIndex ?>_com_logo" value="250">
<input type="hidden" name="fx_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fx_x<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo $company->com_logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fm_x<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo $company->com_logo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $company_list->RowIndex ?>_com_logo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="company" data-field="x_com_logo" name="o<?php echo $company_list->RowIndex ?>_com_logo" id="o<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo ew_HtmlEncode($company->com_logo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_username->Visible) { // com_username ?>
		<td data-name="com_username">
<span id="el<?php echo $company_list->RowCnt ?>_company_com_username" class="form-group company_com_username">
<input type="text" data-table="company" data-field="x_com_username" name="x<?php echo $company_list->RowIndex ?>_com_username" id="x<?php echo $company_list->RowIndex ?>_com_username" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_username->getPlaceHolder()) ?>" value="<?php echo $company->com_username->EditValue ?>"<?php echo $company->com_username->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_username" name="o<?php echo $company_list->RowIndex ?>_com_username" id="o<?php echo $company_list->RowIndex ?>_com_username" value="<?php echo ew_HtmlEncode($company->com_username->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->country_id->Visible) { // country_id ?>
		<td data-name="country_id">
<span id="el<?php echo $company_list->RowCnt ?>_company_country_id" class="form-group company_country_id">
<?php $company->country_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$company->country_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $company_list->RowIndex ?>_country_id"><?php echo (strval($company->country_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $company->country_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($company->country_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $company_list->RowIndex ?>_country_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($company->country_id->ReadOnly || $company->country_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="company" data-field="x_country_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $company->country_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $company_list->RowIndex ?>_country_id" id="x<?php echo $company_list->RowIndex ?>_country_id" value="<?php echo $company->country_id->CurrentValue ?>"<?php echo $company->country_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $company->country_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $company_list->RowIndex ?>_country_id',url:'countryaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $company_list->RowIndex ?>_country_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $company->country_id->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="company" data-field="x_country_id" name="o<?php echo $company_list->RowIndex ?>_country_id" id="o<?php echo $company_list->RowIndex ?>_country_id" value="<?php echo ew_HtmlEncode($company->country_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->province_id->Visible) { // province_id ?>
		<td data-name="province_id">
<span id="el<?php echo $company_list->RowCnt ?>_company_province_id" class="form-group company_province_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $company_list->RowIndex ?>_province_id"><?php echo (strval($company->province_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $company->province_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($company->province_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $company_list->RowIndex ?>_province_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($company->province_id->ReadOnly || $company->province_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="company" data-field="x_province_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $company->province_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $company_list->RowIndex ?>_province_id" id="x<?php echo $company_list->RowIndex ?>_province_id" value="<?php echo $company->province_id->CurrentValue ?>"<?php echo $company->province_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $company->province_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $company_list->RowIndex ?>_province_id',url:'provinceaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $company_list->RowIndex ?>_province_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $company->province_id->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="company" data-field="x_province_id" name="o<?php echo $company_list->RowIndex ?>_province_id" id="o<?php echo $company_list->RowIndex ?>_province_id" value="<?php echo ew_HtmlEncode($company->province_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$company_list->ListOptions->Render("body", "right", $company_list->RowCnt);
?>
<script type="text/javascript">
fcompanylist.UpdateOpts(<?php echo $company_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
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

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($company_list->FormKeyCountName) && ($company->CurrentAction == "gridadd" || $company->CurrentAction == "gridedit" || $company->CurrentAction == "F")) {
		$company_list->KeyCount = $objForm->GetValue($company_list->FormKeyCountName);
		$company_list->StopRec = $company_list->StartRec + $company_list->KeyCount - 1;
	}
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
$company_list->EditRowCnt = 0;
if ($company->CurrentAction == "edit")
	$company_list->RowIndex = 1;
if ($company->CurrentAction == "gridadd")
	$company_list->RowIndex = 0;
if ($company->CurrentAction == "gridedit")
	$company_list->RowIndex = 0;
while ($company_list->RecCnt < $company_list->StopRec) {
	$company_list->RecCnt++;
	if (intval($company_list->RecCnt) >= intval($company_list->StartRec)) {
		$company_list->RowCnt++;
		if ($company->CurrentAction == "gridadd" || $company->CurrentAction == "gridedit" || $company->CurrentAction == "F") {
			$company_list->RowIndex++;
			$objForm->Index = $company_list->RowIndex;
			if ($objForm->HasValue($company_list->FormActionName))
				$company_list->RowAction = strval($objForm->GetValue($company_list->FormActionName));
			elseif ($company->CurrentAction == "gridadd")
				$company_list->RowAction = "insert";
			else
				$company_list->RowAction = "";
		}

		// Set up key count
		$company_list->KeyCount = $company_list->RowIndex;

		// Init row class and style
		$company->ResetAttrs();
		$company->CssClass = "";
		if ($company->CurrentAction == "gridadd") {
			$company_list->LoadRowValues(); // Load default values
		} else {
			$company_list->LoadRowValues($company_list->Recordset); // Load row values
		}
		$company->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($company->CurrentAction == "gridadd") // Grid add
			$company->RowType = EW_ROWTYPE_ADD; // Render add
		if ($company->CurrentAction == "gridadd" && $company->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$company_list->RestoreCurrentRowFormValues($company_list->RowIndex); // Restore form values
		if ($company->CurrentAction == "edit") {
			if ($company_list->CheckInlineEditKey() && $company_list->EditRowCnt == 0) { // Inline edit
				$company->RowType = EW_ROWTYPE_EDIT; // Render edit
				if (!$company->EventCancelled)
					$company_list->HashValue = $company_list->GetRowHash($company_list->Recordset); // Get hash value for record
			}
		}
		if ($company->CurrentAction == "gridedit") { // Grid edit
			if ($company->EventCancelled) {
				$company_list->RestoreCurrentRowFormValues($company_list->RowIndex); // Restore form values
			}
			if ($company_list->RowAction == "insert")
				$company->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$company->RowType = EW_ROWTYPE_EDIT; // Render edit
			if (!$company->EventCancelled)
				$company_list->HashValue = $company_list->GetRowHash($company_list->Recordset); // Get hash value for record
		}
		if ($company->CurrentAction == "edit" && $company->RowType == EW_ROWTYPE_EDIT && $company->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$company_list->RestoreFormValues(); // Restore form values
		}
		if ($company->CurrentAction == "gridedit" && ($company->RowType == EW_ROWTYPE_EDIT || $company->RowType == EW_ROWTYPE_ADD) && $company->EventCancelled) // Update failed
			$company_list->RestoreCurrentRowFormValues($company_list->RowIndex); // Restore form values
		if ($company->RowType == EW_ROWTYPE_EDIT) // Edit row
			$company_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$company->RowAttrs = array_merge($company->RowAttrs, array('data-rowindex'=>$company_list->RowCnt, 'id'=>'r' . $company_list->RowCnt . '_company', 'data-rowtype'=>$company->RowType));

		// Render row
		$company_list->RenderRow();

		// Render list options
		$company_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($company_list->RowAction <> "delete" && $company_list->RowAction <> "insertdelete" && !($company_list->RowAction == "insert" && $company->CurrentAction == "F" && $company_list->EmptyRow())) {
?>
	<tr<?php echo $company->RowAttributes() ?>>
<?php

// Render list options (body, left)
$company_list->ListOptions->Render("body", "left", $company_list->RowCnt);
?>
	<?php if ($company->company_id->Visible) { // company_id ?>
		<td data-name="company_id"<?php echo $company->company_id->CellAttributes() ?>>
<?php if ($company->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="company" data-field="x_company_id" name="o<?php echo $company_list->RowIndex ?>_company_id" id="o<?php echo $company_list->RowIndex ?>_company_id" value="<?php echo ew_HtmlEncode($company->company_id->OldValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_company_id" class="form-group company_company_id">
<span<?php echo $company->company_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $company->company_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="company" data-field="x_company_id" name="x<?php echo $company_list->RowIndex ?>_company_id" id="x<?php echo $company_list->RowIndex ?>_company_id" value="<?php echo ew_HtmlEncode($company->company_id->CurrentValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_company_id" class="company_company_id">
<span<?php echo $company->company_id->ViewAttributes() ?>>
<?php echo $company->company_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($company->com_fname->Visible) { // com_fname ?>
		<td data-name="com_fname"<?php echo $company->com_fname->CellAttributes() ?>>
<?php if ($company->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_fname" class="form-group company_com_fname">
<input type="text" data-table="company" data-field="x_com_fname" name="x<?php echo $company_list->RowIndex ?>_com_fname" id="x<?php echo $company_list->RowIndex ?>_com_fname" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_fname->getPlaceHolder()) ?>" value="<?php echo $company->com_fname->EditValue ?>"<?php echo $company->com_fname->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_fname" name="o<?php echo $company_list->RowIndex ?>_com_fname" id="o<?php echo $company_list->RowIndex ?>_com_fname" value="<?php echo ew_HtmlEncode($company->com_fname->OldValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_fname" class="form-group company_com_fname">
<input type="text" data-table="company" data-field="x_com_fname" name="x<?php echo $company_list->RowIndex ?>_com_fname" id="x<?php echo $company_list->RowIndex ?>_com_fname" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_fname->getPlaceHolder()) ?>" value="<?php echo $company->com_fname->EditValue ?>"<?php echo $company->com_fname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_fname" class="company_com_fname">
<span<?php echo $company->com_fname->ViewAttributes() ?>>
<?php echo $company->com_fname->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($company->com_lname->Visible) { // com_lname ?>
		<td data-name="com_lname"<?php echo $company->com_lname->CellAttributes() ?>>
<?php if ($company->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_lname" class="form-group company_com_lname">
<input type="text" data-table="company" data-field="x_com_lname" name="x<?php echo $company_list->RowIndex ?>_com_lname" id="x<?php echo $company_list->RowIndex ?>_com_lname" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_lname->getPlaceHolder()) ?>" value="<?php echo $company->com_lname->EditValue ?>"<?php echo $company->com_lname->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_lname" name="o<?php echo $company_list->RowIndex ?>_com_lname" id="o<?php echo $company_list->RowIndex ?>_com_lname" value="<?php echo ew_HtmlEncode($company->com_lname->OldValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_lname" class="form-group company_com_lname">
<input type="text" data-table="company" data-field="x_com_lname" name="x<?php echo $company_list->RowIndex ?>_com_lname" id="x<?php echo $company_list->RowIndex ?>_com_lname" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_lname->getPlaceHolder()) ?>" value="<?php echo $company->com_lname->EditValue ?>"<?php echo $company->com_lname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_lname" class="company_com_lname">
<span<?php echo $company->com_lname->ViewAttributes() ?>>
<?php echo $company->com_lname->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($company->com_name->Visible) { // com_name ?>
		<td data-name="com_name"<?php echo $company->com_name->CellAttributes() ?>>
<?php if ($company->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_name" class="form-group company_com_name">
<input type="text" data-table="company" data-field="x_com_name" name="x<?php echo $company_list->RowIndex ?>_com_name" id="x<?php echo $company_list->RowIndex ?>_com_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_name->getPlaceHolder()) ?>" value="<?php echo $company->com_name->EditValue ?>"<?php echo $company->com_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_name" name="o<?php echo $company_list->RowIndex ?>_com_name" id="o<?php echo $company_list->RowIndex ?>_com_name" value="<?php echo ew_HtmlEncode($company->com_name->OldValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_name" class="form-group company_com_name">
<input type="text" data-table="company" data-field="x_com_name" name="x<?php echo $company_list->RowIndex ?>_com_name" id="x<?php echo $company_list->RowIndex ?>_com_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_name->getPlaceHolder()) ?>" value="<?php echo $company->com_name->EditValue ?>"<?php echo $company->com_name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_name" class="company_com_name">
<span<?php echo $company->com_name->ViewAttributes() ?>>
<?php echo $company->com_name->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($company->com_phone->Visible) { // com_phone ?>
		<td data-name="com_phone"<?php echo $company->com_phone->CellAttributes() ?>>
<?php if ($company->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_phone" class="form-group company_com_phone">
<input type="text" data-table="company" data-field="x_com_phone" name="x<?php echo $company_list->RowIndex ?>_com_phone" id="x<?php echo $company_list->RowIndex ?>_com_phone" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_phone->getPlaceHolder()) ?>" value="<?php echo $company->com_phone->EditValue ?>"<?php echo $company->com_phone->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_phone" name="o<?php echo $company_list->RowIndex ?>_com_phone" id="o<?php echo $company_list->RowIndex ?>_com_phone" value="<?php echo ew_HtmlEncode($company->com_phone->OldValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_phone" class="form-group company_com_phone">
<input type="text" data-table="company" data-field="x_com_phone" name="x<?php echo $company_list->RowIndex ?>_com_phone" id="x<?php echo $company_list->RowIndex ?>_com_phone" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_phone->getPlaceHolder()) ?>" value="<?php echo $company->com_phone->EditValue ?>"<?php echo $company->com_phone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_phone" class="company_com_phone">
<span<?php echo $company->com_phone->ViewAttributes() ?>>
<?php echo $company->com_phone->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($company->com_email->Visible) { // com_email ?>
		<td data-name="com_email"<?php echo $company->com_email->CellAttributes() ?>>
<?php if ($company->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_email" class="form-group company_com_email">
<input type="text" data-table="company" data-field="x_com_email" name="x<?php echo $company_list->RowIndex ?>_com_email" id="x<?php echo $company_list->RowIndex ?>_com_email" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_email->getPlaceHolder()) ?>" value="<?php echo $company->com_email->EditValue ?>"<?php echo $company->com_email->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_email" name="o<?php echo $company_list->RowIndex ?>_com_email" id="o<?php echo $company_list->RowIndex ?>_com_email" value="<?php echo ew_HtmlEncode($company->com_email->OldValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_email" class="form-group company_com_email">
<input type="text" data-table="company" data-field="x_com_email" name="x<?php echo $company_list->RowIndex ?>_com_email" id="x<?php echo $company_list->RowIndex ?>_com_email" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_email->getPlaceHolder()) ?>" value="<?php echo $company->com_email->EditValue ?>"<?php echo $company->com_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_email" class="company_com_email">
<span<?php echo $company->com_email->ViewAttributes() ?>>
<?php echo $company->com_email->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($company->com_logo->Visible) { // com_logo ?>
		<td data-name="com_logo"<?php echo $company->com_logo->CellAttributes() ?>>
<?php if ($company->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_logo" class="form-group company_com_logo">
<div id="fd_x<?php echo $company_list->RowIndex ?>_com_logo">
<span title="<?php echo $company->com_logo->FldTitle() ? $company->com_logo->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($company->com_logo->ReadOnly || $company->com_logo->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="company" data-field="x_com_logo" name="x<?php echo $company_list->RowIndex ?>_com_logo" id="x<?php echo $company_list->RowIndex ?>_com_logo"<?php echo $company->com_logo->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fn_x<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo $company->com_logo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fa_x<?php echo $company_list->RowIndex ?>_com_logo" value="0">
<input type="hidden" name="fs_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fs_x<?php echo $company_list->RowIndex ?>_com_logo" value="250">
<input type="hidden" name="fx_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fx_x<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo $company->com_logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fm_x<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo $company->com_logo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $company_list->RowIndex ?>_com_logo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="company" data-field="x_com_logo" name="o<?php echo $company_list->RowIndex ?>_com_logo" id="o<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo ew_HtmlEncode($company->com_logo->OldValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_logo" class="form-group company_com_logo">
<div id="fd_x<?php echo $company_list->RowIndex ?>_com_logo">
<span title="<?php echo $company->com_logo->FldTitle() ? $company->com_logo->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($company->com_logo->ReadOnly || $company->com_logo->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="company" data-field="x_com_logo" name="x<?php echo $company_list->RowIndex ?>_com_logo" id="x<?php echo $company_list->RowIndex ?>_com_logo"<?php echo $company->com_logo->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fn_x<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo $company->com_logo->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $company_list->RowIndex ?>_com_logo"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fa_x<?php echo $company_list->RowIndex ?>_com_logo" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fa_x<?php echo $company_list->RowIndex ?>_com_logo" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fs_x<?php echo $company_list->RowIndex ?>_com_logo" value="250">
<input type="hidden" name="fx_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fx_x<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo $company->com_logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fm_x<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo $company->com_logo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $company_list->RowIndex ?>_com_logo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_logo" class="company_com_logo">
<span>
<?php echo ew_GetFileViewTag($company->com_logo, $company->com_logo->ListViewValue()) ?>
</span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($company->com_username->Visible) { // com_username ?>
		<td data-name="com_username"<?php echo $company->com_username->CellAttributes() ?>>
<?php if ($company->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_username" class="form-group company_com_username">
<input type="text" data-table="company" data-field="x_com_username" name="x<?php echo $company_list->RowIndex ?>_com_username" id="x<?php echo $company_list->RowIndex ?>_com_username" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_username->getPlaceHolder()) ?>" value="<?php echo $company->com_username->EditValue ?>"<?php echo $company->com_username->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_username" name="o<?php echo $company_list->RowIndex ?>_com_username" id="o<?php echo $company_list->RowIndex ?>_com_username" value="<?php echo ew_HtmlEncode($company->com_username->OldValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_username" class="form-group company_com_username">
<input type="text" data-table="company" data-field="x_com_username" name="x<?php echo $company_list->RowIndex ?>_com_username" id="x<?php echo $company_list->RowIndex ?>_com_username" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_username->getPlaceHolder()) ?>" value="<?php echo $company->com_username->EditValue ?>"<?php echo $company->com_username->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_com_username" class="company_com_username">
<span<?php echo $company->com_username->ViewAttributes() ?>>
<?php echo $company->com_username->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($company->country_id->Visible) { // country_id ?>
		<td data-name="country_id"<?php echo $company->country_id->CellAttributes() ?>>
<?php if ($company->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_country_id" class="form-group company_country_id">
<?php $company->country_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$company->country_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $company_list->RowIndex ?>_country_id"><?php echo (strval($company->country_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $company->country_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($company->country_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $company_list->RowIndex ?>_country_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($company->country_id->ReadOnly || $company->country_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="company" data-field="x_country_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $company->country_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $company_list->RowIndex ?>_country_id" id="x<?php echo $company_list->RowIndex ?>_country_id" value="<?php echo $company->country_id->CurrentValue ?>"<?php echo $company->country_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $company->country_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $company_list->RowIndex ?>_country_id',url:'countryaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $company_list->RowIndex ?>_country_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $company->country_id->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="company" data-field="x_country_id" name="o<?php echo $company_list->RowIndex ?>_country_id" id="o<?php echo $company_list->RowIndex ?>_country_id" value="<?php echo ew_HtmlEncode($company->country_id->OldValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_country_id" class="form-group company_country_id">
<span<?php echo $company->country_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $company->country_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="company" data-field="x_country_id" name="x<?php echo $company_list->RowIndex ?>_country_id" id="x<?php echo $company_list->RowIndex ?>_country_id" value="<?php echo ew_HtmlEncode($company->country_id->CurrentValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_country_id" class="company_country_id">
<span<?php echo $company->country_id->ViewAttributes() ?>>
<?php echo $company->country_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($company->province_id->Visible) { // province_id ?>
		<td data-name="province_id"<?php echo $company->province_id->CellAttributes() ?>>
<?php if ($company->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_province_id" class="form-group company_province_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $company_list->RowIndex ?>_province_id"><?php echo (strval($company->province_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $company->province_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($company->province_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $company_list->RowIndex ?>_province_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($company->province_id->ReadOnly || $company->province_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="company" data-field="x_province_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $company->province_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $company_list->RowIndex ?>_province_id" id="x<?php echo $company_list->RowIndex ?>_province_id" value="<?php echo $company->province_id->CurrentValue ?>"<?php echo $company->province_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $company->province_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $company_list->RowIndex ?>_province_id',url:'provinceaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $company_list->RowIndex ?>_province_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $company->province_id->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="company" data-field="x_province_id" name="o<?php echo $company_list->RowIndex ?>_province_id" id="o<?php echo $company_list->RowIndex ?>_province_id" value="<?php echo ew_HtmlEncode($company->province_id->OldValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_province_id" class="form-group company_province_id">
<span<?php echo $company->province_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $company->province_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="company" data-field="x_province_id" name="x<?php echo $company_list->RowIndex ?>_province_id" id="x<?php echo $company_list->RowIndex ?>_province_id" value="<?php echo ew_HtmlEncode($company->province_id->CurrentValue) ?>">
<?php } ?>
<?php if ($company->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $company_list->RowCnt ?>_company_province_id" class="company_province_id">
<span<?php echo $company->province_id->ViewAttributes() ?>>
<?php echo $company->province_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$company_list->ListOptions->Render("body", "right", $company_list->RowCnt);
?>
	</tr>
<?php if ($company->RowType == EW_ROWTYPE_ADD || $company->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcompanylist.UpdateOpts(<?php echo $company_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($company->CurrentAction <> "gridadd")
		if (!$company_list->Recordset->EOF) $company_list->Recordset->MoveNext();
}
?>
<?php
	if ($company->CurrentAction == "gridadd" || $company->CurrentAction == "gridedit") {
		$company_list->RowIndex = '$rowindex$';
		$company_list->LoadRowValues();

		// Set row properties
		$company->ResetAttrs();
		$company->RowAttrs = array_merge($company->RowAttrs, array('data-rowindex'=>$company_list->RowIndex, 'id'=>'r0_company', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($company->RowAttrs["class"], "ewTemplate");
		$company->RowType = EW_ROWTYPE_ADD;

		// Render row
		$company_list->RenderRow();

		// Render list options
		$company_list->RenderListOptions();
		$company_list->StartRowCnt = 0;
?>
	<tr<?php echo $company->RowAttributes() ?>>
<?php

// Render list options (body, left)
$company_list->ListOptions->Render("body", "left", $company_list->RowIndex);
?>
	<?php if ($company->company_id->Visible) { // company_id ?>
		<td data-name="company_id">
<input type="hidden" data-table="company" data-field="x_company_id" name="o<?php echo $company_list->RowIndex ?>_company_id" id="o<?php echo $company_list->RowIndex ?>_company_id" value="<?php echo ew_HtmlEncode($company->company_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_fname->Visible) { // com_fname ?>
		<td data-name="com_fname">
<span id="el$rowindex$_company_com_fname" class="form-group company_com_fname">
<input type="text" data-table="company" data-field="x_com_fname" name="x<?php echo $company_list->RowIndex ?>_com_fname" id="x<?php echo $company_list->RowIndex ?>_com_fname" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_fname->getPlaceHolder()) ?>" value="<?php echo $company->com_fname->EditValue ?>"<?php echo $company->com_fname->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_fname" name="o<?php echo $company_list->RowIndex ?>_com_fname" id="o<?php echo $company_list->RowIndex ?>_com_fname" value="<?php echo ew_HtmlEncode($company->com_fname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_lname->Visible) { // com_lname ?>
		<td data-name="com_lname">
<span id="el$rowindex$_company_com_lname" class="form-group company_com_lname">
<input type="text" data-table="company" data-field="x_com_lname" name="x<?php echo $company_list->RowIndex ?>_com_lname" id="x<?php echo $company_list->RowIndex ?>_com_lname" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_lname->getPlaceHolder()) ?>" value="<?php echo $company->com_lname->EditValue ?>"<?php echo $company->com_lname->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_lname" name="o<?php echo $company_list->RowIndex ?>_com_lname" id="o<?php echo $company_list->RowIndex ?>_com_lname" value="<?php echo ew_HtmlEncode($company->com_lname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_name->Visible) { // com_name ?>
		<td data-name="com_name">
<span id="el$rowindex$_company_com_name" class="form-group company_com_name">
<input type="text" data-table="company" data-field="x_com_name" name="x<?php echo $company_list->RowIndex ?>_com_name" id="x<?php echo $company_list->RowIndex ?>_com_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_name->getPlaceHolder()) ?>" value="<?php echo $company->com_name->EditValue ?>"<?php echo $company->com_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_name" name="o<?php echo $company_list->RowIndex ?>_com_name" id="o<?php echo $company_list->RowIndex ?>_com_name" value="<?php echo ew_HtmlEncode($company->com_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_phone->Visible) { // com_phone ?>
		<td data-name="com_phone">
<span id="el$rowindex$_company_com_phone" class="form-group company_com_phone">
<input type="text" data-table="company" data-field="x_com_phone" name="x<?php echo $company_list->RowIndex ?>_com_phone" id="x<?php echo $company_list->RowIndex ?>_com_phone" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_phone->getPlaceHolder()) ?>" value="<?php echo $company->com_phone->EditValue ?>"<?php echo $company->com_phone->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_phone" name="o<?php echo $company_list->RowIndex ?>_com_phone" id="o<?php echo $company_list->RowIndex ?>_com_phone" value="<?php echo ew_HtmlEncode($company->com_phone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_email->Visible) { // com_email ?>
		<td data-name="com_email">
<span id="el$rowindex$_company_com_email" class="form-group company_com_email">
<input type="text" data-table="company" data-field="x_com_email" name="x<?php echo $company_list->RowIndex ?>_com_email" id="x<?php echo $company_list->RowIndex ?>_com_email" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_email->getPlaceHolder()) ?>" value="<?php echo $company->com_email->EditValue ?>"<?php echo $company->com_email->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_email" name="o<?php echo $company_list->RowIndex ?>_com_email" id="o<?php echo $company_list->RowIndex ?>_com_email" value="<?php echo ew_HtmlEncode($company->com_email->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_logo->Visible) { // com_logo ?>
		<td data-name="com_logo">
<span id="el$rowindex$_company_com_logo" class="form-group company_com_logo">
<div id="fd_x<?php echo $company_list->RowIndex ?>_com_logo">
<span title="<?php echo $company->com_logo->FldTitle() ? $company->com_logo->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($company->com_logo->ReadOnly || $company->com_logo->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="company" data-field="x_com_logo" name="x<?php echo $company_list->RowIndex ?>_com_logo" id="x<?php echo $company_list->RowIndex ?>_com_logo"<?php echo $company->com_logo->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fn_x<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo $company->com_logo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fa_x<?php echo $company_list->RowIndex ?>_com_logo" value="0">
<input type="hidden" name="fs_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fs_x<?php echo $company_list->RowIndex ?>_com_logo" value="250">
<input type="hidden" name="fx_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fx_x<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo $company->com_logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $company_list->RowIndex ?>_com_logo" id= "fm_x<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo $company->com_logo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $company_list->RowIndex ?>_com_logo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="company" data-field="x_com_logo" name="o<?php echo $company_list->RowIndex ?>_com_logo" id="o<?php echo $company_list->RowIndex ?>_com_logo" value="<?php echo ew_HtmlEncode($company->com_logo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->com_username->Visible) { // com_username ?>
		<td data-name="com_username">
<span id="el$rowindex$_company_com_username" class="form-group company_com_username">
<input type="text" data-table="company" data-field="x_com_username" name="x<?php echo $company_list->RowIndex ?>_com_username" id="x<?php echo $company_list->RowIndex ?>_com_username" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($company->com_username->getPlaceHolder()) ?>" value="<?php echo $company->com_username->EditValue ?>"<?php echo $company->com_username->EditAttributes() ?>>
</span>
<input type="hidden" data-table="company" data-field="x_com_username" name="o<?php echo $company_list->RowIndex ?>_com_username" id="o<?php echo $company_list->RowIndex ?>_com_username" value="<?php echo ew_HtmlEncode($company->com_username->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->country_id->Visible) { // country_id ?>
		<td data-name="country_id">
<span id="el$rowindex$_company_country_id" class="form-group company_country_id">
<?php $company->country_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$company->country_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $company_list->RowIndex ?>_country_id"><?php echo (strval($company->country_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $company->country_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($company->country_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $company_list->RowIndex ?>_country_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($company->country_id->ReadOnly || $company->country_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="company" data-field="x_country_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $company->country_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $company_list->RowIndex ?>_country_id" id="x<?php echo $company_list->RowIndex ?>_country_id" value="<?php echo $company->country_id->CurrentValue ?>"<?php echo $company->country_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $company->country_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $company_list->RowIndex ?>_country_id',url:'countryaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $company_list->RowIndex ?>_country_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $company->country_id->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="company" data-field="x_country_id" name="o<?php echo $company_list->RowIndex ?>_country_id" id="o<?php echo $company_list->RowIndex ?>_country_id" value="<?php echo ew_HtmlEncode($company->country_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($company->province_id->Visible) { // province_id ?>
		<td data-name="province_id">
<span id="el$rowindex$_company_province_id" class="form-group company_province_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $company_list->RowIndex ?>_province_id"><?php echo (strval($company->province_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $company->province_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($company->province_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $company_list->RowIndex ?>_province_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($company->province_id->ReadOnly || $company->province_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="company" data-field="x_province_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $company->province_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $company_list->RowIndex ?>_province_id" id="x<?php echo $company_list->RowIndex ?>_province_id" value="<?php echo $company->province_id->CurrentValue ?>"<?php echo $company->province_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $company->province_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $company_list->RowIndex ?>_province_id',url:'provinceaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $company_list->RowIndex ?>_province_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $company->province_id->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="company" data-field="x_province_id" name="o<?php echo $company_list->RowIndex ?>_province_id" id="o<?php echo $company_list->RowIndex ?>_province_id" value="<?php echo ew_HtmlEncode($company->province_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$company_list->ListOptions->Render("body", "right", $company_list->RowIndex);
?>
<script type="text/javascript">
fcompanylist.UpdateOpts(<?php echo $company_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($company->CurrentAction == "add" || $company->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $company_list->FormKeyCountName ?>" id="<?php echo $company_list->FormKeyCountName ?>" value="<?php echo $company_list->KeyCount ?>">
<?php } ?>
<?php if ($company->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $company_list->FormKeyCountName ?>" id="<?php echo $company_list->FormKeyCountName ?>" value="<?php echo $company_list->KeyCount ?>">
<?php echo $company_list->MultiSelectKey ?>
<?php } ?>
<?php if ($company->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $company_list->FormKeyCountName ?>" id="<?php echo $company_list->FormKeyCountName ?>" value="<?php echo $company_list->KeyCount ?>">
<?php } ?>
<?php if ($company->CurrentAction == "gridedit") { ?>
<?php if ($company->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="a_list" id="a_list" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $company_list->FormKeyCountName ?>" id="<?php echo $company_list->FormKeyCountName ?>" value="<?php echo $company_list->KeyCount ?>">
<?php echo $company_list->MultiSelectKey ?>
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
<?php if ($company->Export == "") { ?>
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
<?php } ?>
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
<?php if ($company->Export == "") { ?>
<script type="text/javascript">
fcompanylistsrch.FilterList = <?php echo $company_list->GetFilterList() ?>;
fcompanylistsrch.Init();
fcompanylist.Init();
</script>
<?php } ?>
<?php
$company_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($company->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$company_list->Page_Terminate();
?>

<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "productsinfo.php" ?>
<?php include_once "companyinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$products_list = NULL; // Initialize page object first

class cproducts_list extends cproducts {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'products';

	// Page object name
	var $PageObjName = 'products_list';

	// Grid form hidden field names
	var $FormName = 'fproductslist';
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

		// Table object (products)
		if (!isset($GLOBALS["products"]) || get_class($GLOBALS["products"]) == "cproducts") {
			$GLOBALS["products"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["products"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "productsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "productsdelete.php";
		$this->MultiUpdateUrl = "productsupdate.php";

		// Table object (company)
		if (!isset($GLOBALS['company'])) $GLOBALS['company'] = new ccompany();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'products', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fproductslistsrch";

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
		$this->product_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->product_id->Visible = FALSE;
		$this->cat_id->SetVisibility();
		$this->company_id->SetVisibility();
		$this->pro_name->SetVisibility();
		$this->pro_condition->SetVisibility();
		$this->pro_brand->SetVisibility();
		$this->pro_features->SetVisibility();
		$this->pro_model->SetVisibility();
		$this->post_date->SetVisibility();
		$this->ads_id->SetVisibility();
		$this->pro_base_price->SetVisibility();
		$this->pro_sell_price->SetVisibility();
		$this->featured_image->SetVisibility();
		$this->folder_image->SetVisibility();
		$this->img1->SetVisibility();
		$this->img2->SetVisibility();
		$this->img3->SetVisibility();
		$this->img4->SetVisibility();
		$this->img5->SetVisibility();
		$this->pro_status->SetVisibility();

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
		global $EW_EXPORT, $products;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($products);
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
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

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

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
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

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
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
		if (count($arrKeyFlds) >= 3) {
			$this->product_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->product_id->FormValue))
				return FALSE;
			$this->cat_id->setFormValue($arrKeyFlds[1]);
			if (!is_numeric($this->cat_id->FormValue))
				return FALSE;
			$this->company_id->setFormValue($arrKeyFlds[2]);
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
		$sFilterList = ew_Concat($sFilterList, $this->product_id->AdvancedSearch->ToJson(), ","); // Field product_id
		$sFilterList = ew_Concat($sFilterList, $this->cat_id->AdvancedSearch->ToJson(), ","); // Field cat_id
		$sFilterList = ew_Concat($sFilterList, $this->company_id->AdvancedSearch->ToJson(), ","); // Field company_id
		$sFilterList = ew_Concat($sFilterList, $this->pro_name->AdvancedSearch->ToJson(), ","); // Field pro_name
		$sFilterList = ew_Concat($sFilterList, $this->pro_description->AdvancedSearch->ToJson(), ","); // Field pro_description
		$sFilterList = ew_Concat($sFilterList, $this->pro_condition->AdvancedSearch->ToJson(), ","); // Field pro_condition
		$sFilterList = ew_Concat($sFilterList, $this->pro_brand->AdvancedSearch->ToJson(), ","); // Field pro_brand
		$sFilterList = ew_Concat($sFilterList, $this->pro_features->AdvancedSearch->ToJson(), ","); // Field pro_features
		$sFilterList = ew_Concat($sFilterList, $this->pro_model->AdvancedSearch->ToJson(), ","); // Field pro_model
		$sFilterList = ew_Concat($sFilterList, $this->post_date->AdvancedSearch->ToJson(), ","); // Field post_date
		$sFilterList = ew_Concat($sFilterList, $this->ads_id->AdvancedSearch->ToJson(), ","); // Field ads_id
		$sFilterList = ew_Concat($sFilterList, $this->pro_base_price->AdvancedSearch->ToJson(), ","); // Field pro_base_price
		$sFilterList = ew_Concat($sFilterList, $this->pro_sell_price->AdvancedSearch->ToJson(), ","); // Field pro_sell_price
		$sFilterList = ew_Concat($sFilterList, $this->featured_image->AdvancedSearch->ToJson(), ","); // Field featured_image
		$sFilterList = ew_Concat($sFilterList, $this->folder_image->AdvancedSearch->ToJson(), ","); // Field folder_image
		$sFilterList = ew_Concat($sFilterList, $this->img1->AdvancedSearch->ToJson(), ","); // Field img1
		$sFilterList = ew_Concat($sFilterList, $this->img2->AdvancedSearch->ToJson(), ","); // Field img2
		$sFilterList = ew_Concat($sFilterList, $this->img3->AdvancedSearch->ToJson(), ","); // Field img3
		$sFilterList = ew_Concat($sFilterList, $this->img4->AdvancedSearch->ToJson(), ","); // Field img4
		$sFilterList = ew_Concat($sFilterList, $this->img5->AdvancedSearch->ToJson(), ","); // Field img5
		$sFilterList = ew_Concat($sFilterList, $this->pro_status->AdvancedSearch->ToJson(), ","); // Field pro_status
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fproductslistsrch", $filters);

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

		// Field product_id
		$this->product_id->AdvancedSearch->SearchValue = @$filter["x_product_id"];
		$this->product_id->AdvancedSearch->SearchOperator = @$filter["z_product_id"];
		$this->product_id->AdvancedSearch->SearchCondition = @$filter["v_product_id"];
		$this->product_id->AdvancedSearch->SearchValue2 = @$filter["y_product_id"];
		$this->product_id->AdvancedSearch->SearchOperator2 = @$filter["w_product_id"];
		$this->product_id->AdvancedSearch->Save();

		// Field cat_id
		$this->cat_id->AdvancedSearch->SearchValue = @$filter["x_cat_id"];
		$this->cat_id->AdvancedSearch->SearchOperator = @$filter["z_cat_id"];
		$this->cat_id->AdvancedSearch->SearchCondition = @$filter["v_cat_id"];
		$this->cat_id->AdvancedSearch->SearchValue2 = @$filter["y_cat_id"];
		$this->cat_id->AdvancedSearch->SearchOperator2 = @$filter["w_cat_id"];
		$this->cat_id->AdvancedSearch->Save();

		// Field company_id
		$this->company_id->AdvancedSearch->SearchValue = @$filter["x_company_id"];
		$this->company_id->AdvancedSearch->SearchOperator = @$filter["z_company_id"];
		$this->company_id->AdvancedSearch->SearchCondition = @$filter["v_company_id"];
		$this->company_id->AdvancedSearch->SearchValue2 = @$filter["y_company_id"];
		$this->company_id->AdvancedSearch->SearchOperator2 = @$filter["w_company_id"];
		$this->company_id->AdvancedSearch->Save();

		// Field pro_name
		$this->pro_name->AdvancedSearch->SearchValue = @$filter["x_pro_name"];
		$this->pro_name->AdvancedSearch->SearchOperator = @$filter["z_pro_name"];
		$this->pro_name->AdvancedSearch->SearchCondition = @$filter["v_pro_name"];
		$this->pro_name->AdvancedSearch->SearchValue2 = @$filter["y_pro_name"];
		$this->pro_name->AdvancedSearch->SearchOperator2 = @$filter["w_pro_name"];
		$this->pro_name->AdvancedSearch->Save();

		// Field pro_description
		$this->pro_description->AdvancedSearch->SearchValue = @$filter["x_pro_description"];
		$this->pro_description->AdvancedSearch->SearchOperator = @$filter["z_pro_description"];
		$this->pro_description->AdvancedSearch->SearchCondition = @$filter["v_pro_description"];
		$this->pro_description->AdvancedSearch->SearchValue2 = @$filter["y_pro_description"];
		$this->pro_description->AdvancedSearch->SearchOperator2 = @$filter["w_pro_description"];
		$this->pro_description->AdvancedSearch->Save();

		// Field pro_condition
		$this->pro_condition->AdvancedSearch->SearchValue = @$filter["x_pro_condition"];
		$this->pro_condition->AdvancedSearch->SearchOperator = @$filter["z_pro_condition"];
		$this->pro_condition->AdvancedSearch->SearchCondition = @$filter["v_pro_condition"];
		$this->pro_condition->AdvancedSearch->SearchValue2 = @$filter["y_pro_condition"];
		$this->pro_condition->AdvancedSearch->SearchOperator2 = @$filter["w_pro_condition"];
		$this->pro_condition->AdvancedSearch->Save();

		// Field pro_brand
		$this->pro_brand->AdvancedSearch->SearchValue = @$filter["x_pro_brand"];
		$this->pro_brand->AdvancedSearch->SearchOperator = @$filter["z_pro_brand"];
		$this->pro_brand->AdvancedSearch->SearchCondition = @$filter["v_pro_brand"];
		$this->pro_brand->AdvancedSearch->SearchValue2 = @$filter["y_pro_brand"];
		$this->pro_brand->AdvancedSearch->SearchOperator2 = @$filter["w_pro_brand"];
		$this->pro_brand->AdvancedSearch->Save();

		// Field pro_features
		$this->pro_features->AdvancedSearch->SearchValue = @$filter["x_pro_features"];
		$this->pro_features->AdvancedSearch->SearchOperator = @$filter["z_pro_features"];
		$this->pro_features->AdvancedSearch->SearchCondition = @$filter["v_pro_features"];
		$this->pro_features->AdvancedSearch->SearchValue2 = @$filter["y_pro_features"];
		$this->pro_features->AdvancedSearch->SearchOperator2 = @$filter["w_pro_features"];
		$this->pro_features->AdvancedSearch->Save();

		// Field pro_model
		$this->pro_model->AdvancedSearch->SearchValue = @$filter["x_pro_model"];
		$this->pro_model->AdvancedSearch->SearchOperator = @$filter["z_pro_model"];
		$this->pro_model->AdvancedSearch->SearchCondition = @$filter["v_pro_model"];
		$this->pro_model->AdvancedSearch->SearchValue2 = @$filter["y_pro_model"];
		$this->pro_model->AdvancedSearch->SearchOperator2 = @$filter["w_pro_model"];
		$this->pro_model->AdvancedSearch->Save();

		// Field post_date
		$this->post_date->AdvancedSearch->SearchValue = @$filter["x_post_date"];
		$this->post_date->AdvancedSearch->SearchOperator = @$filter["z_post_date"];
		$this->post_date->AdvancedSearch->SearchCondition = @$filter["v_post_date"];
		$this->post_date->AdvancedSearch->SearchValue2 = @$filter["y_post_date"];
		$this->post_date->AdvancedSearch->SearchOperator2 = @$filter["w_post_date"];
		$this->post_date->AdvancedSearch->Save();

		// Field ads_id
		$this->ads_id->AdvancedSearch->SearchValue = @$filter["x_ads_id"];
		$this->ads_id->AdvancedSearch->SearchOperator = @$filter["z_ads_id"];
		$this->ads_id->AdvancedSearch->SearchCondition = @$filter["v_ads_id"];
		$this->ads_id->AdvancedSearch->SearchValue2 = @$filter["y_ads_id"];
		$this->ads_id->AdvancedSearch->SearchOperator2 = @$filter["w_ads_id"];
		$this->ads_id->AdvancedSearch->Save();

		// Field pro_base_price
		$this->pro_base_price->AdvancedSearch->SearchValue = @$filter["x_pro_base_price"];
		$this->pro_base_price->AdvancedSearch->SearchOperator = @$filter["z_pro_base_price"];
		$this->pro_base_price->AdvancedSearch->SearchCondition = @$filter["v_pro_base_price"];
		$this->pro_base_price->AdvancedSearch->SearchValue2 = @$filter["y_pro_base_price"];
		$this->pro_base_price->AdvancedSearch->SearchOperator2 = @$filter["w_pro_base_price"];
		$this->pro_base_price->AdvancedSearch->Save();

		// Field pro_sell_price
		$this->pro_sell_price->AdvancedSearch->SearchValue = @$filter["x_pro_sell_price"];
		$this->pro_sell_price->AdvancedSearch->SearchOperator = @$filter["z_pro_sell_price"];
		$this->pro_sell_price->AdvancedSearch->SearchCondition = @$filter["v_pro_sell_price"];
		$this->pro_sell_price->AdvancedSearch->SearchValue2 = @$filter["y_pro_sell_price"];
		$this->pro_sell_price->AdvancedSearch->SearchOperator2 = @$filter["w_pro_sell_price"];
		$this->pro_sell_price->AdvancedSearch->Save();

		// Field featured_image
		$this->featured_image->AdvancedSearch->SearchValue = @$filter["x_featured_image"];
		$this->featured_image->AdvancedSearch->SearchOperator = @$filter["z_featured_image"];
		$this->featured_image->AdvancedSearch->SearchCondition = @$filter["v_featured_image"];
		$this->featured_image->AdvancedSearch->SearchValue2 = @$filter["y_featured_image"];
		$this->featured_image->AdvancedSearch->SearchOperator2 = @$filter["w_featured_image"];
		$this->featured_image->AdvancedSearch->Save();

		// Field folder_image
		$this->folder_image->AdvancedSearch->SearchValue = @$filter["x_folder_image"];
		$this->folder_image->AdvancedSearch->SearchOperator = @$filter["z_folder_image"];
		$this->folder_image->AdvancedSearch->SearchCondition = @$filter["v_folder_image"];
		$this->folder_image->AdvancedSearch->SearchValue2 = @$filter["y_folder_image"];
		$this->folder_image->AdvancedSearch->SearchOperator2 = @$filter["w_folder_image"];
		$this->folder_image->AdvancedSearch->Save();

		// Field img1
		$this->img1->AdvancedSearch->SearchValue = @$filter["x_img1"];
		$this->img1->AdvancedSearch->SearchOperator = @$filter["z_img1"];
		$this->img1->AdvancedSearch->SearchCondition = @$filter["v_img1"];
		$this->img1->AdvancedSearch->SearchValue2 = @$filter["y_img1"];
		$this->img1->AdvancedSearch->SearchOperator2 = @$filter["w_img1"];
		$this->img1->AdvancedSearch->Save();

		// Field img2
		$this->img2->AdvancedSearch->SearchValue = @$filter["x_img2"];
		$this->img2->AdvancedSearch->SearchOperator = @$filter["z_img2"];
		$this->img2->AdvancedSearch->SearchCondition = @$filter["v_img2"];
		$this->img2->AdvancedSearch->SearchValue2 = @$filter["y_img2"];
		$this->img2->AdvancedSearch->SearchOperator2 = @$filter["w_img2"];
		$this->img2->AdvancedSearch->Save();

		// Field img3
		$this->img3->AdvancedSearch->SearchValue = @$filter["x_img3"];
		$this->img3->AdvancedSearch->SearchOperator = @$filter["z_img3"];
		$this->img3->AdvancedSearch->SearchCondition = @$filter["v_img3"];
		$this->img3->AdvancedSearch->SearchValue2 = @$filter["y_img3"];
		$this->img3->AdvancedSearch->SearchOperator2 = @$filter["w_img3"];
		$this->img3->AdvancedSearch->Save();

		// Field img4
		$this->img4->AdvancedSearch->SearchValue = @$filter["x_img4"];
		$this->img4->AdvancedSearch->SearchOperator = @$filter["z_img4"];
		$this->img4->AdvancedSearch->SearchCondition = @$filter["v_img4"];
		$this->img4->AdvancedSearch->SearchValue2 = @$filter["y_img4"];
		$this->img4->AdvancedSearch->SearchOperator2 = @$filter["w_img4"];
		$this->img4->AdvancedSearch->Save();

		// Field img5
		$this->img5->AdvancedSearch->SearchValue = @$filter["x_img5"];
		$this->img5->AdvancedSearch->SearchOperator = @$filter["z_img5"];
		$this->img5->AdvancedSearch->SearchCondition = @$filter["v_img5"];
		$this->img5->AdvancedSearch->SearchValue2 = @$filter["y_img5"];
		$this->img5->AdvancedSearch->SearchOperator2 = @$filter["w_img5"];
		$this->img5->AdvancedSearch->Save();

		// Field pro_status
		$this->pro_status->AdvancedSearch->SearchValue = @$filter["x_pro_status"];
		$this->pro_status->AdvancedSearch->SearchOperator = @$filter["z_pro_status"];
		$this->pro_status->AdvancedSearch->SearchCondition = @$filter["v_pro_status"];
		$this->pro_status->AdvancedSearch->SearchValue2 = @$filter["y_pro_status"];
		$this->pro_status->AdvancedSearch->SearchOperator2 = @$filter["w_pro_status"];
		$this->pro_status->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->product_id, $Default, FALSE); // product_id
		$this->BuildSearchSql($sWhere, $this->cat_id, $Default, FALSE); // cat_id
		$this->BuildSearchSql($sWhere, $this->company_id, $Default, FALSE); // company_id
		$this->BuildSearchSql($sWhere, $this->pro_name, $Default, FALSE); // pro_name
		$this->BuildSearchSql($sWhere, $this->pro_description, $Default, FALSE); // pro_description
		$this->BuildSearchSql($sWhere, $this->pro_condition, $Default, FALSE); // pro_condition
		$this->BuildSearchSql($sWhere, $this->pro_brand, $Default, FALSE); // pro_brand
		$this->BuildSearchSql($sWhere, $this->pro_features, $Default, FALSE); // pro_features
		$this->BuildSearchSql($sWhere, $this->pro_model, $Default, FALSE); // pro_model
		$this->BuildSearchSql($sWhere, $this->post_date, $Default, FALSE); // post_date
		$this->BuildSearchSql($sWhere, $this->ads_id, $Default, FALSE); // ads_id
		$this->BuildSearchSql($sWhere, $this->pro_base_price, $Default, FALSE); // pro_base_price
		$this->BuildSearchSql($sWhere, $this->pro_sell_price, $Default, FALSE); // pro_sell_price
		$this->BuildSearchSql($sWhere, $this->featured_image, $Default, FALSE); // featured_image
		$this->BuildSearchSql($sWhere, $this->folder_image, $Default, FALSE); // folder_image
		$this->BuildSearchSql($sWhere, $this->img1, $Default, FALSE); // img1
		$this->BuildSearchSql($sWhere, $this->img2, $Default, FALSE); // img2
		$this->BuildSearchSql($sWhere, $this->img3, $Default, FALSE); // img3
		$this->BuildSearchSql($sWhere, $this->img4, $Default, FALSE); // img4
		$this->BuildSearchSql($sWhere, $this->img5, $Default, FALSE); // img5
		$this->BuildSearchSql($sWhere, $this->pro_status, $Default, FALSE); // pro_status

		// Set up search parm
		if (!$Default && $sWhere <> "" && in_array($this->Command, array("", "reset", "resetall"))) {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->product_id->AdvancedSearch->Save(); // product_id
			$this->cat_id->AdvancedSearch->Save(); // cat_id
			$this->company_id->AdvancedSearch->Save(); // company_id
			$this->pro_name->AdvancedSearch->Save(); // pro_name
			$this->pro_description->AdvancedSearch->Save(); // pro_description
			$this->pro_condition->AdvancedSearch->Save(); // pro_condition
			$this->pro_brand->AdvancedSearch->Save(); // pro_brand
			$this->pro_features->AdvancedSearch->Save(); // pro_features
			$this->pro_model->AdvancedSearch->Save(); // pro_model
			$this->post_date->AdvancedSearch->Save(); // post_date
			$this->ads_id->AdvancedSearch->Save(); // ads_id
			$this->pro_base_price->AdvancedSearch->Save(); // pro_base_price
			$this->pro_sell_price->AdvancedSearch->Save(); // pro_sell_price
			$this->featured_image->AdvancedSearch->Save(); // featured_image
			$this->folder_image->AdvancedSearch->Save(); // folder_image
			$this->img1->AdvancedSearch->Save(); // img1
			$this->img2->AdvancedSearch->Save(); // img2
			$this->img3->AdvancedSearch->Save(); // img3
			$this->img4->AdvancedSearch->Save(); // img4
			$this->img5->AdvancedSearch->Save(); // img5
			$this->pro_status->AdvancedSearch->Save(); // pro_status
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = $Fld->FldParm();
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1)
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->pro_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pro_description, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pro_condition, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pro_brand, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pro_features, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pro_model, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ads_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->featured_image, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->folder_image, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->img1, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->img2, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->img3, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->img4, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->img5, $arKeywords, $type);
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
		if ($this->product_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->cat_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->company_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pro_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pro_description->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pro_condition->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pro_brand->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pro_features->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pro_model->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->post_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->ads_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pro_base_price->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pro_sell_price->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->featured_image->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->folder_image->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->img1->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->img2->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->img3->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->img4->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->img5->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pro_status->AdvancedSearch->IssetSession())
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

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->product_id->AdvancedSearch->UnsetSession();
		$this->cat_id->AdvancedSearch->UnsetSession();
		$this->company_id->AdvancedSearch->UnsetSession();
		$this->pro_name->AdvancedSearch->UnsetSession();
		$this->pro_description->AdvancedSearch->UnsetSession();
		$this->pro_condition->AdvancedSearch->UnsetSession();
		$this->pro_brand->AdvancedSearch->UnsetSession();
		$this->pro_features->AdvancedSearch->UnsetSession();
		$this->pro_model->AdvancedSearch->UnsetSession();
		$this->post_date->AdvancedSearch->UnsetSession();
		$this->ads_id->AdvancedSearch->UnsetSession();
		$this->pro_base_price->AdvancedSearch->UnsetSession();
		$this->pro_sell_price->AdvancedSearch->UnsetSession();
		$this->featured_image->AdvancedSearch->UnsetSession();
		$this->folder_image->AdvancedSearch->UnsetSession();
		$this->img1->AdvancedSearch->UnsetSession();
		$this->img2->AdvancedSearch->UnsetSession();
		$this->img3->AdvancedSearch->UnsetSession();
		$this->img4->AdvancedSearch->UnsetSession();
		$this->img5->AdvancedSearch->UnsetSession();
		$this->pro_status->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->product_id->AdvancedSearch->Load();
		$this->cat_id->AdvancedSearch->Load();
		$this->company_id->AdvancedSearch->Load();
		$this->pro_name->AdvancedSearch->Load();
		$this->pro_description->AdvancedSearch->Load();
		$this->pro_condition->AdvancedSearch->Load();
		$this->pro_brand->AdvancedSearch->Load();
		$this->pro_features->AdvancedSearch->Load();
		$this->pro_model->AdvancedSearch->Load();
		$this->post_date->AdvancedSearch->Load();
		$this->ads_id->AdvancedSearch->Load();
		$this->pro_base_price->AdvancedSearch->Load();
		$this->pro_sell_price->AdvancedSearch->Load();
		$this->featured_image->AdvancedSearch->Load();
		$this->folder_image->AdvancedSearch->Load();
		$this->img1->AdvancedSearch->Load();
		$this->img2->AdvancedSearch->Load();
		$this->img3->AdvancedSearch->Load();
		$this->img4->AdvancedSearch->Load();
		$this->img5->AdvancedSearch->Load();
		$this->pro_status->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->product_id); // product_id
			$this->UpdateSort($this->cat_id); // cat_id
			$this->UpdateSort($this->company_id); // company_id
			$this->UpdateSort($this->pro_name); // pro_name
			$this->UpdateSort($this->pro_condition); // pro_condition
			$this->UpdateSort($this->pro_brand); // pro_brand
			$this->UpdateSort($this->pro_features); // pro_features
			$this->UpdateSort($this->pro_model); // pro_model
			$this->UpdateSort($this->post_date); // post_date
			$this->UpdateSort($this->ads_id); // ads_id
			$this->UpdateSort($this->pro_base_price); // pro_base_price
			$this->UpdateSort($this->pro_sell_price); // pro_sell_price
			$this->UpdateSort($this->featured_image); // featured_image
			$this->UpdateSort($this->folder_image); // folder_image
			$this->UpdateSort($this->img1); // img1
			$this->UpdateSort($this->img2); // img2
			$this->UpdateSort($this->img3); // img3
			$this->UpdateSort($this->img4); // img4
			$this->UpdateSort($this->img5); // img5
			$this->UpdateSort($this->pro_status); // pro_status
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
				$this->product_id->setSort("");
				$this->cat_id->setSort("");
				$this->company_id->setSort("");
				$this->pro_name->setSort("");
				$this->pro_condition->setSort("");
				$this->pro_brand->setSort("");
				$this->pro_features->setSort("");
				$this->pro_model->setSort("");
				$this->post_date->setSort("");
				$this->ads_id->setSort("");
				$this->pro_base_price->setSort("");
				$this->pro_sell_price->setSort("");
				$this->featured_image->setSort("");
				$this->folder_image->setSort("");
				$this->img1->setSort("");
				$this->img2->setSort("");
				$this->img3->setSort("");
				$this->img4->setSort("");
				$this->img5->setSort("");
				$this->pro_status->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->product_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->cat_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->company_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fproductslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fproductslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fproductslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fproductslistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// product_id

		$this->product_id->AdvancedSearch->SearchValue = @$_GET["x_product_id"];
		if ($this->product_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->product_id->AdvancedSearch->SearchOperator = @$_GET["z_product_id"];

		// cat_id
		$this->cat_id->AdvancedSearch->SearchValue = @$_GET["x_cat_id"];
		if ($this->cat_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->cat_id->AdvancedSearch->SearchOperator = @$_GET["z_cat_id"];

		// company_id
		$this->company_id->AdvancedSearch->SearchValue = @$_GET["x_company_id"];
		if ($this->company_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->company_id->AdvancedSearch->SearchOperator = @$_GET["z_company_id"];

		// pro_name
		$this->pro_name->AdvancedSearch->SearchValue = @$_GET["x_pro_name"];
		if ($this->pro_name->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pro_name->AdvancedSearch->SearchOperator = @$_GET["z_pro_name"];

		// pro_description
		$this->pro_description->AdvancedSearch->SearchValue = @$_GET["x_pro_description"];
		if ($this->pro_description->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pro_description->AdvancedSearch->SearchOperator = @$_GET["z_pro_description"];

		// pro_condition
		$this->pro_condition->AdvancedSearch->SearchValue = @$_GET["x_pro_condition"];
		if ($this->pro_condition->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pro_condition->AdvancedSearch->SearchOperator = @$_GET["z_pro_condition"];

		// pro_brand
		$this->pro_brand->AdvancedSearch->SearchValue = @$_GET["x_pro_brand"];
		if ($this->pro_brand->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pro_brand->AdvancedSearch->SearchOperator = @$_GET["z_pro_brand"];

		// pro_features
		$this->pro_features->AdvancedSearch->SearchValue = @$_GET["x_pro_features"];
		if ($this->pro_features->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pro_features->AdvancedSearch->SearchOperator = @$_GET["z_pro_features"];

		// pro_model
		$this->pro_model->AdvancedSearch->SearchValue = @$_GET["x_pro_model"];
		if ($this->pro_model->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pro_model->AdvancedSearch->SearchOperator = @$_GET["z_pro_model"];

		// post_date
		$this->post_date->AdvancedSearch->SearchValue = @$_GET["x_post_date"];
		if ($this->post_date->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->post_date->AdvancedSearch->SearchOperator = @$_GET["z_post_date"];

		// ads_id
		$this->ads_id->AdvancedSearch->SearchValue = @$_GET["x_ads_id"];
		if ($this->ads_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->ads_id->AdvancedSearch->SearchOperator = @$_GET["z_ads_id"];

		// pro_base_price
		$this->pro_base_price->AdvancedSearch->SearchValue = @$_GET["x_pro_base_price"];
		if ($this->pro_base_price->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pro_base_price->AdvancedSearch->SearchOperator = @$_GET["z_pro_base_price"];

		// pro_sell_price
		$this->pro_sell_price->AdvancedSearch->SearchValue = @$_GET["x_pro_sell_price"];
		if ($this->pro_sell_price->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pro_sell_price->AdvancedSearch->SearchOperator = @$_GET["z_pro_sell_price"];

		// featured_image
		$this->featured_image->AdvancedSearch->SearchValue = @$_GET["x_featured_image"];
		if ($this->featured_image->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->featured_image->AdvancedSearch->SearchOperator = @$_GET["z_featured_image"];

		// folder_image
		$this->folder_image->AdvancedSearch->SearchValue = @$_GET["x_folder_image"];
		if ($this->folder_image->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->folder_image->AdvancedSearch->SearchOperator = @$_GET["z_folder_image"];

		// img1
		$this->img1->AdvancedSearch->SearchValue = @$_GET["x_img1"];
		if ($this->img1->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->img1->AdvancedSearch->SearchOperator = @$_GET["z_img1"];

		// img2
		$this->img2->AdvancedSearch->SearchValue = @$_GET["x_img2"];
		if ($this->img2->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->img2->AdvancedSearch->SearchOperator = @$_GET["z_img2"];

		// img3
		$this->img3->AdvancedSearch->SearchValue = @$_GET["x_img3"];
		if ($this->img3->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->img3->AdvancedSearch->SearchOperator = @$_GET["z_img3"];

		// img4
		$this->img4->AdvancedSearch->SearchValue = @$_GET["x_img4"];
		if ($this->img4->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->img4->AdvancedSearch->SearchOperator = @$_GET["z_img4"];

		// img5
		$this->img5->AdvancedSearch->SearchValue = @$_GET["x_img5"];
		if ($this->img5->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->img5->AdvancedSearch->SearchOperator = @$_GET["z_img5"];

		// pro_status
		$this->pro_status->AdvancedSearch->SearchValue = @$_GET["x_pro_status"];
		if ($this->pro_status->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pro_status->AdvancedSearch->SearchOperator = @$_GET["z_pro_status"];
		if (is_array($this->pro_status->AdvancedSearch->SearchValue)) $this->pro_status->AdvancedSearch->SearchValue = implode(",", $this->pro_status->AdvancedSearch->SearchValue);
		if (is_array($this->pro_status->AdvancedSearch->SearchValue2)) $this->pro_status->AdvancedSearch->SearchValue2 = implode(",", $this->pro_status->AdvancedSearch->SearchValue2);
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
		$this->product_id->setDbValue($row['product_id']);
		$this->cat_id->setDbValue($row['cat_id']);
		$this->company_id->setDbValue($row['company_id']);
		$this->pro_name->setDbValue($row['pro_name']);
		$this->pro_description->setDbValue($row['pro_description']);
		$this->pro_condition->setDbValue($row['pro_condition']);
		$this->pro_brand->setDbValue($row['pro_brand']);
		$this->pro_features->setDbValue($row['pro_features']);
		$this->pro_model->setDbValue($row['pro_model']);
		$this->post_date->setDbValue($row['post_date']);
		$this->ads_id->setDbValue($row['ads_id']);
		$this->pro_base_price->setDbValue($row['pro_base_price']);
		$this->pro_sell_price->setDbValue($row['pro_sell_price']);
		$this->featured_image->setDbValue($row['featured_image']);
		$this->folder_image->setDbValue($row['folder_image']);
		$this->img1->setDbValue($row['img1']);
		$this->img2->setDbValue($row['img2']);
		$this->img3->setDbValue($row['img3']);
		$this->img4->setDbValue($row['img4']);
		$this->img5->setDbValue($row['img5']);
		$this->pro_status->setDbValue($row['pro_status']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['product_id'] = NULL;
		$row['cat_id'] = NULL;
		$row['company_id'] = NULL;
		$row['pro_name'] = NULL;
		$row['pro_description'] = NULL;
		$row['pro_condition'] = NULL;
		$row['pro_brand'] = NULL;
		$row['pro_features'] = NULL;
		$row['pro_model'] = NULL;
		$row['post_date'] = NULL;
		$row['ads_id'] = NULL;
		$row['pro_base_price'] = NULL;
		$row['pro_sell_price'] = NULL;
		$row['featured_image'] = NULL;
		$row['folder_image'] = NULL;
		$row['img1'] = NULL;
		$row['img2'] = NULL;
		$row['img3'] = NULL;
		$row['img4'] = NULL;
		$row['img5'] = NULL;
		$row['pro_status'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->product_id->DbValue = $row['product_id'];
		$this->cat_id->DbValue = $row['cat_id'];
		$this->company_id->DbValue = $row['company_id'];
		$this->pro_name->DbValue = $row['pro_name'];
		$this->pro_description->DbValue = $row['pro_description'];
		$this->pro_condition->DbValue = $row['pro_condition'];
		$this->pro_brand->DbValue = $row['pro_brand'];
		$this->pro_features->DbValue = $row['pro_features'];
		$this->pro_model->DbValue = $row['pro_model'];
		$this->post_date->DbValue = $row['post_date'];
		$this->ads_id->DbValue = $row['ads_id'];
		$this->pro_base_price->DbValue = $row['pro_base_price'];
		$this->pro_sell_price->DbValue = $row['pro_sell_price'];
		$this->featured_image->DbValue = $row['featured_image'];
		$this->folder_image->DbValue = $row['folder_image'];
		$this->img1->DbValue = $row['img1'];
		$this->img2->DbValue = $row['img2'];
		$this->img3->DbValue = $row['img3'];
		$this->img4->DbValue = $row['img4'];
		$this->img5->DbValue = $row['img5'];
		$this->pro_status->DbValue = $row['pro_status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("product_id")) <> "")
			$this->product_id->CurrentValue = $this->getKey("product_id"); // product_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("cat_id")) <> "")
			$this->cat_id->CurrentValue = $this->getKey("cat_id"); // cat_id
		else
			$bValidKey = FALSE;
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

		// Convert decimal values if posted back
		if ($this->pro_base_price->FormValue == $this->pro_base_price->CurrentValue && is_numeric(ew_StrToFloat($this->pro_base_price->CurrentValue)))
			$this->pro_base_price->CurrentValue = ew_StrToFloat($this->pro_base_price->CurrentValue);

		// Convert decimal values if posted back
		if ($this->pro_sell_price->FormValue == $this->pro_sell_price->CurrentValue && is_numeric(ew_StrToFloat($this->pro_sell_price->CurrentValue)))
			$this->pro_sell_price->CurrentValue = ew_StrToFloat($this->pro_sell_price->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// product_id
		// cat_id
		// company_id
		// pro_name
		// pro_description
		// pro_condition
		// pro_brand
		// pro_features
		// pro_model
		// post_date
		// ads_id
		// pro_base_price
		// pro_sell_price
		// featured_image
		// folder_image
		// img1
		// img2
		// img3
		// img4
		// img5
		// pro_status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// product_id
		$this->product_id->ViewValue = $this->product_id->CurrentValue;
		$this->product_id->ViewCustomAttributes = "";

		// cat_id
		$this->cat_id->ViewValue = $this->cat_id->CurrentValue;
		$this->cat_id->ViewCustomAttributes = "";

		// company_id
		$this->company_id->ViewValue = $this->company_id->CurrentValue;
		$this->company_id->ViewCustomAttributes = "";

		// pro_name
		$this->pro_name->ViewValue = $this->pro_name->CurrentValue;
		$this->pro_name->ViewCustomAttributes = "";

		// pro_condition
		$this->pro_condition->ViewValue = $this->pro_condition->CurrentValue;
		$this->pro_condition->ViewCustomAttributes = "";

		// pro_brand
		$this->pro_brand->ViewValue = $this->pro_brand->CurrentValue;
		$this->pro_brand->ViewCustomAttributes = "";

		// pro_features
		$this->pro_features->ViewValue = $this->pro_features->CurrentValue;
		$this->pro_features->ViewCustomAttributes = "";

		// pro_model
		$this->pro_model->ViewValue = $this->pro_model->CurrentValue;
		$this->pro_model->ViewCustomAttributes = "";

		// post_date
		$this->post_date->ViewValue = $this->post_date->CurrentValue;
		$this->post_date->ViewValue = ew_FormatDateTime($this->post_date->ViewValue, 0);
		$this->post_date->ViewCustomAttributes = "";

		// ads_id
		$this->ads_id->ViewValue = $this->ads_id->CurrentValue;
		$this->ads_id->ViewCustomAttributes = "";

		// pro_base_price
		$this->pro_base_price->ViewValue = $this->pro_base_price->CurrentValue;
		$this->pro_base_price->ViewCustomAttributes = "";

		// pro_sell_price
		$this->pro_sell_price->ViewValue = $this->pro_sell_price->CurrentValue;
		$this->pro_sell_price->ViewCustomAttributes = "";

		// featured_image
		$this->featured_image->ViewValue = $this->featured_image->CurrentValue;
		$this->featured_image->ViewCustomAttributes = "";

		// folder_image
		$this->folder_image->ViewValue = $this->folder_image->CurrentValue;
		$this->folder_image->ViewCustomAttributes = "";

		// img1
		$this->img1->ViewValue = $this->img1->CurrentValue;
		$this->img1->ViewCustomAttributes = "";

		// img2
		$this->img2->ViewValue = $this->img2->CurrentValue;
		$this->img2->ViewCustomAttributes = "";

		// img3
		$this->img3->ViewValue = $this->img3->CurrentValue;
		$this->img3->ViewCustomAttributes = "";

		// img4
		$this->img4->ViewValue = $this->img4->CurrentValue;
		$this->img4->ViewCustomAttributes = "";

		// img5
		$this->img5->ViewValue = $this->img5->CurrentValue;
		$this->img5->ViewCustomAttributes = "";

		// pro_status
		if (ew_ConvertToBool($this->pro_status->CurrentValue)) {
			$this->pro_status->ViewValue = $this->pro_status->FldTagCaption(1) <> "" ? $this->pro_status->FldTagCaption(1) : "Y";
		} else {
			$this->pro_status->ViewValue = $this->pro_status->FldTagCaption(2) <> "" ? $this->pro_status->FldTagCaption(2) : "N";
		}
		$this->pro_status->ViewCustomAttributes = "";

			// product_id
			$this->product_id->LinkCustomAttributes = "";
			$this->product_id->HrefValue = "";
			$this->product_id->TooltipValue = "";

			// cat_id
			$this->cat_id->LinkCustomAttributes = "";
			$this->cat_id->HrefValue = "";
			$this->cat_id->TooltipValue = "";

			// company_id
			$this->company_id->LinkCustomAttributes = "";
			$this->company_id->HrefValue = "";
			$this->company_id->TooltipValue = "";

			// pro_name
			$this->pro_name->LinkCustomAttributes = "";
			$this->pro_name->HrefValue = "";
			$this->pro_name->TooltipValue = "";

			// pro_condition
			$this->pro_condition->LinkCustomAttributes = "";
			$this->pro_condition->HrefValue = "";
			$this->pro_condition->TooltipValue = "";

			// pro_brand
			$this->pro_brand->LinkCustomAttributes = "";
			$this->pro_brand->HrefValue = "";
			$this->pro_brand->TooltipValue = "";

			// pro_features
			$this->pro_features->LinkCustomAttributes = "";
			$this->pro_features->HrefValue = "";
			$this->pro_features->TooltipValue = "";

			// pro_model
			$this->pro_model->LinkCustomAttributes = "";
			$this->pro_model->HrefValue = "";
			$this->pro_model->TooltipValue = "";

			// post_date
			$this->post_date->LinkCustomAttributes = "";
			$this->post_date->HrefValue = "";
			$this->post_date->TooltipValue = "";

			// ads_id
			$this->ads_id->LinkCustomAttributes = "";
			$this->ads_id->HrefValue = "";
			$this->ads_id->TooltipValue = "";

			// pro_base_price
			$this->pro_base_price->LinkCustomAttributes = "";
			$this->pro_base_price->HrefValue = "";
			$this->pro_base_price->TooltipValue = "";

			// pro_sell_price
			$this->pro_sell_price->LinkCustomAttributes = "";
			$this->pro_sell_price->HrefValue = "";
			$this->pro_sell_price->TooltipValue = "";

			// featured_image
			$this->featured_image->LinkCustomAttributes = "";
			$this->featured_image->HrefValue = "";
			$this->featured_image->TooltipValue = "";

			// folder_image
			$this->folder_image->LinkCustomAttributes = "";
			$this->folder_image->HrefValue = "";
			$this->folder_image->TooltipValue = "";

			// img1
			$this->img1->LinkCustomAttributes = "";
			$this->img1->HrefValue = "";
			$this->img1->TooltipValue = "";

			// img2
			$this->img2->LinkCustomAttributes = "";
			$this->img2->HrefValue = "";
			$this->img2->TooltipValue = "";

			// img3
			$this->img3->LinkCustomAttributes = "";
			$this->img3->HrefValue = "";
			$this->img3->TooltipValue = "";

			// img4
			$this->img4->LinkCustomAttributes = "";
			$this->img4->HrefValue = "";
			$this->img4->TooltipValue = "";

			// img5
			$this->img5->LinkCustomAttributes = "";
			$this->img5->HrefValue = "";
			$this->img5->TooltipValue = "";

			// pro_status
			$this->pro_status->LinkCustomAttributes = "";
			$this->pro_status->HrefValue = "";
			$this->pro_status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// product_id
			$this->product_id->EditAttrs["class"] = "form-control";
			$this->product_id->EditCustomAttributes = "";
			$this->product_id->EditValue = ew_HtmlEncode($this->product_id->AdvancedSearch->SearchValue);
			$this->product_id->PlaceHolder = ew_RemoveHtml($this->product_id->FldCaption());

			// cat_id
			$this->cat_id->EditAttrs["class"] = "form-control";
			$this->cat_id->EditCustomAttributes = "";
			$this->cat_id->EditValue = ew_HtmlEncode($this->cat_id->AdvancedSearch->SearchValue);
			$this->cat_id->PlaceHolder = ew_RemoveHtml($this->cat_id->FldCaption());

			// company_id
			$this->company_id->EditAttrs["class"] = "form-control";
			$this->company_id->EditCustomAttributes = "";
			$this->company_id->EditValue = ew_HtmlEncode($this->company_id->AdvancedSearch->SearchValue);
			$this->company_id->PlaceHolder = ew_RemoveHtml($this->company_id->FldCaption());

			// pro_name
			$this->pro_name->EditAttrs["class"] = "form-control";
			$this->pro_name->EditCustomAttributes = "";
			$this->pro_name->EditValue = ew_HtmlEncode($this->pro_name->AdvancedSearch->SearchValue);
			$this->pro_name->PlaceHolder = ew_RemoveHtml($this->pro_name->FldCaption());

			// pro_condition
			$this->pro_condition->EditAttrs["class"] = "form-control";
			$this->pro_condition->EditCustomAttributes = "";
			$this->pro_condition->EditValue = ew_HtmlEncode($this->pro_condition->AdvancedSearch->SearchValue);
			$this->pro_condition->PlaceHolder = ew_RemoveHtml($this->pro_condition->FldCaption());

			// pro_brand
			$this->pro_brand->EditAttrs["class"] = "form-control";
			$this->pro_brand->EditCustomAttributes = "";
			$this->pro_brand->EditValue = ew_HtmlEncode($this->pro_brand->AdvancedSearch->SearchValue);
			$this->pro_brand->PlaceHolder = ew_RemoveHtml($this->pro_brand->FldCaption());

			// pro_features
			$this->pro_features->EditAttrs["class"] = "form-control";
			$this->pro_features->EditCustomAttributes = "";
			$this->pro_features->EditValue = ew_HtmlEncode($this->pro_features->AdvancedSearch->SearchValue);
			$this->pro_features->PlaceHolder = ew_RemoveHtml($this->pro_features->FldCaption());

			// pro_model
			$this->pro_model->EditAttrs["class"] = "form-control";
			$this->pro_model->EditCustomAttributes = "";
			$this->pro_model->EditValue = ew_HtmlEncode($this->pro_model->AdvancedSearch->SearchValue);
			$this->pro_model->PlaceHolder = ew_RemoveHtml($this->pro_model->FldCaption());

			// post_date
			$this->post_date->EditAttrs["class"] = "form-control";
			$this->post_date->EditCustomAttributes = "";
			$this->post_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->post_date->AdvancedSearch->SearchValue, 0), 8));
			$this->post_date->PlaceHolder = ew_RemoveHtml($this->post_date->FldCaption());

			// ads_id
			$this->ads_id->EditAttrs["class"] = "form-control";
			$this->ads_id->EditCustomAttributes = "";
			$this->ads_id->EditValue = ew_HtmlEncode($this->ads_id->AdvancedSearch->SearchValue);
			$this->ads_id->PlaceHolder = ew_RemoveHtml($this->ads_id->FldCaption());

			// pro_base_price
			$this->pro_base_price->EditAttrs["class"] = "form-control";
			$this->pro_base_price->EditCustomAttributes = "";
			$this->pro_base_price->EditValue = ew_HtmlEncode($this->pro_base_price->AdvancedSearch->SearchValue);
			$this->pro_base_price->PlaceHolder = ew_RemoveHtml($this->pro_base_price->FldCaption());

			// pro_sell_price
			$this->pro_sell_price->EditAttrs["class"] = "form-control";
			$this->pro_sell_price->EditCustomAttributes = "";
			$this->pro_sell_price->EditValue = ew_HtmlEncode($this->pro_sell_price->AdvancedSearch->SearchValue);
			$this->pro_sell_price->PlaceHolder = ew_RemoveHtml($this->pro_sell_price->FldCaption());

			// featured_image
			$this->featured_image->EditAttrs["class"] = "form-control";
			$this->featured_image->EditCustomAttributes = "";
			$this->featured_image->EditValue = ew_HtmlEncode($this->featured_image->AdvancedSearch->SearchValue);
			$this->featured_image->PlaceHolder = ew_RemoveHtml($this->featured_image->FldCaption());

			// folder_image
			$this->folder_image->EditAttrs["class"] = "form-control";
			$this->folder_image->EditCustomAttributes = "";
			$this->folder_image->EditValue = ew_HtmlEncode($this->folder_image->AdvancedSearch->SearchValue);
			$this->folder_image->PlaceHolder = ew_RemoveHtml($this->folder_image->FldCaption());

			// img1
			$this->img1->EditAttrs["class"] = "form-control";
			$this->img1->EditCustomAttributes = "";
			$this->img1->EditValue = ew_HtmlEncode($this->img1->AdvancedSearch->SearchValue);
			$this->img1->PlaceHolder = ew_RemoveHtml($this->img1->FldCaption());

			// img2
			$this->img2->EditAttrs["class"] = "form-control";
			$this->img2->EditCustomAttributes = "";
			$this->img2->EditValue = ew_HtmlEncode($this->img2->AdvancedSearch->SearchValue);
			$this->img2->PlaceHolder = ew_RemoveHtml($this->img2->FldCaption());

			// img3
			$this->img3->EditAttrs["class"] = "form-control";
			$this->img3->EditCustomAttributes = "";
			$this->img3->EditValue = ew_HtmlEncode($this->img3->AdvancedSearch->SearchValue);
			$this->img3->PlaceHolder = ew_RemoveHtml($this->img3->FldCaption());

			// img4
			$this->img4->EditAttrs["class"] = "form-control";
			$this->img4->EditCustomAttributes = "";
			$this->img4->EditValue = ew_HtmlEncode($this->img4->AdvancedSearch->SearchValue);
			$this->img4->PlaceHolder = ew_RemoveHtml($this->img4->FldCaption());

			// img5
			$this->img5->EditAttrs["class"] = "form-control";
			$this->img5->EditCustomAttributes = "";
			$this->img5->EditValue = ew_HtmlEncode($this->img5->AdvancedSearch->SearchValue);
			$this->img5->PlaceHolder = ew_RemoveHtml($this->img5->FldCaption());

			// pro_status
			$this->pro_status->EditCustomAttributes = "";
			$this->pro_status->EditValue = $this->pro_status->Options(FALSE);
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->product_id->AdvancedSearch->Load();
		$this->cat_id->AdvancedSearch->Load();
		$this->company_id->AdvancedSearch->Load();
		$this->pro_name->AdvancedSearch->Load();
		$this->pro_description->AdvancedSearch->Load();
		$this->pro_condition->AdvancedSearch->Load();
		$this->pro_brand->AdvancedSearch->Load();
		$this->pro_features->AdvancedSearch->Load();
		$this->pro_model->AdvancedSearch->Load();
		$this->post_date->AdvancedSearch->Load();
		$this->ads_id->AdvancedSearch->Load();
		$this->pro_base_price->AdvancedSearch->Load();
		$this->pro_sell_price->AdvancedSearch->Load();
		$this->featured_image->AdvancedSearch->Load();
		$this->folder_image->AdvancedSearch->Load();
		$this->img1->AdvancedSearch->Load();
		$this->img2->AdvancedSearch->Load();
		$this->img3->AdvancedSearch->Load();
		$this->img4->AdvancedSearch->Load();
		$this->img5->AdvancedSearch->Load();
		$this->pro_status->AdvancedSearch->Load();
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
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
			}
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
			}
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
if (!isset($products_list)) $products_list = new cproducts_list();

// Page init
$products_list->Page_Init();

// Page main
$products_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$products_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fproductslist = new ew_Form("fproductslist", "list");
fproductslist.FormKeyCountName = '<?php echo $products_list->FormKeyCountName ?>';

// Form_CustomValidate event
fproductslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fproductslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fproductslist.Lists["x_pro_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fproductslist.Lists["x_pro_status[]"].Options = <?php echo json_encode($products_list->pro_status->Options()) ?>;

// Form object for search
var CurrentSearchForm = fproductslistsrch = new ew_Form("fproductslistsrch");

// Validate function for search
fproductslistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fproductslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fproductslistsrch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fproductslistsrch.Lists["x_pro_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fproductslistsrch.Lists["x_pro_status[]"].Options = <?php echo json_encode($products_list->pro_status->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($products_list->TotalRecs > 0 && $products_list->ExportOptions->Visible()) { ?>
<?php $products_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($products_list->SearchOptions->Visible()) { ?>
<?php $products_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($products_list->FilterOptions->Visible()) { ?>
<?php $products_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $products_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($products_list->TotalRecs <= 0)
			$products_list->TotalRecs = $products->ListRecordCount();
	} else {
		if (!$products_list->Recordset && ($products_list->Recordset = $products_list->LoadRecordset()))
			$products_list->TotalRecs = $products_list->Recordset->RecordCount();
	}
	$products_list->StartRec = 1;
	if ($products_list->DisplayRecs <= 0 || ($products->Export <> "" && $products->ExportAll)) // Display all records
		$products_list->DisplayRecs = $products_list->TotalRecs;
	if (!($products->Export <> "" && $products->ExportAll))
		$products_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$products_list->Recordset = $products_list->LoadRecordset($products_list->StartRec-1, $products_list->DisplayRecs);

	// Set no record found message
	if ($products->CurrentAction == "" && $products_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$products_list->setWarningMessage(ew_DeniedMsg());
		if ($products_list->SearchWhere == "0=101")
			$products_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$products_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$products_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($products->Export == "" && $products->CurrentAction == "") { ?>
<form name="fproductslistsrch" id="fproductslistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($products_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fproductslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="products">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$products_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$products->RowType = EW_ROWTYPE_SEARCH;

// Render row
$products->ResetAttrs();
$products_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($products->pro_status->Visible) { // pro_status ?>
	<div id="xsc_pro_status" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $products->pro_status->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_pro_status" id="z_pro_status" value="="></span>
		<span class="ewSearchField">
<?php
$selwrk = (ew_ConvertToBool($products->pro_status->AdvancedSearch->SearchValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="products" data-field="x_pro_status" name="x_pro_status[]" id="x_pro_status[]" value="1"<?php echo $selwrk ?><?php echo $products->pro_status->EditAttributes() ?>>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($products_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($products_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $products_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($products_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($products_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($products_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($products_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $products_list->ShowPageHeader(); ?>
<?php
$products_list->ShowMessage();
?>
<?php if ($products_list->TotalRecs > 0 || $products->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($products_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> products">
<form name="fproductslist" id="fproductslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($products_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $products_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="products">
<div id="gmp_products" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($products_list->TotalRecs > 0 || $products->CurrentAction == "gridedit") { ?>
<table id="tbl_productslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$products_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$products_list->RenderListOptions();

// Render list options (header, left)
$products_list->ListOptions->Render("header", "left");
?>
<?php if ($products->product_id->Visible) { // product_id ?>
	<?php if ($products->SortUrl($products->product_id) == "") { ?>
		<th data-name="product_id" class="<?php echo $products->product_id->HeaderCellClass() ?>"><div id="elh_products_product_id" class="products_product_id"><div class="ewTableHeaderCaption"><?php echo $products->product_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="product_id" class="<?php echo $products->product_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->product_id) ?>',1);"><div id="elh_products_product_id" class="products_product_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->product_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->product_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->product_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->cat_id->Visible) { // cat_id ?>
	<?php if ($products->SortUrl($products->cat_id) == "") { ?>
		<th data-name="cat_id" class="<?php echo $products->cat_id->HeaderCellClass() ?>"><div id="elh_products_cat_id" class="products_cat_id"><div class="ewTableHeaderCaption"><?php echo $products->cat_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cat_id" class="<?php echo $products->cat_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->cat_id) ?>',1);"><div id="elh_products_cat_id" class="products_cat_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->cat_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->cat_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->cat_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->company_id->Visible) { // company_id ?>
	<?php if ($products->SortUrl($products->company_id) == "") { ?>
		<th data-name="company_id" class="<?php echo $products->company_id->HeaderCellClass() ?>"><div id="elh_products_company_id" class="products_company_id"><div class="ewTableHeaderCaption"><?php echo $products->company_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="company_id" class="<?php echo $products->company_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->company_id) ?>',1);"><div id="elh_products_company_id" class="products_company_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->company_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->company_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->company_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->pro_name->Visible) { // pro_name ?>
	<?php if ($products->SortUrl($products->pro_name) == "") { ?>
		<th data-name="pro_name" class="<?php echo $products->pro_name->HeaderCellClass() ?>"><div id="elh_products_pro_name" class="products_pro_name"><div class="ewTableHeaderCaption"><?php echo $products->pro_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_name" class="<?php echo $products->pro_name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->pro_name) ?>',1);"><div id="elh_products_pro_name" class="products_pro_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->pro_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->pro_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->pro_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->pro_condition->Visible) { // pro_condition ?>
	<?php if ($products->SortUrl($products->pro_condition) == "") { ?>
		<th data-name="pro_condition" class="<?php echo $products->pro_condition->HeaderCellClass() ?>"><div id="elh_products_pro_condition" class="products_pro_condition"><div class="ewTableHeaderCaption"><?php echo $products->pro_condition->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_condition" class="<?php echo $products->pro_condition->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->pro_condition) ?>',1);"><div id="elh_products_pro_condition" class="products_pro_condition">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->pro_condition->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->pro_condition->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->pro_condition->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->pro_brand->Visible) { // pro_brand ?>
	<?php if ($products->SortUrl($products->pro_brand) == "") { ?>
		<th data-name="pro_brand" class="<?php echo $products->pro_brand->HeaderCellClass() ?>"><div id="elh_products_pro_brand" class="products_pro_brand"><div class="ewTableHeaderCaption"><?php echo $products->pro_brand->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_brand" class="<?php echo $products->pro_brand->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->pro_brand) ?>',1);"><div id="elh_products_pro_brand" class="products_pro_brand">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->pro_brand->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->pro_brand->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->pro_brand->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->pro_features->Visible) { // pro_features ?>
	<?php if ($products->SortUrl($products->pro_features) == "") { ?>
		<th data-name="pro_features" class="<?php echo $products->pro_features->HeaderCellClass() ?>"><div id="elh_products_pro_features" class="products_pro_features"><div class="ewTableHeaderCaption"><?php echo $products->pro_features->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_features" class="<?php echo $products->pro_features->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->pro_features) ?>',1);"><div id="elh_products_pro_features" class="products_pro_features">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->pro_features->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->pro_features->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->pro_features->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->pro_model->Visible) { // pro_model ?>
	<?php if ($products->SortUrl($products->pro_model) == "") { ?>
		<th data-name="pro_model" class="<?php echo $products->pro_model->HeaderCellClass() ?>"><div id="elh_products_pro_model" class="products_pro_model"><div class="ewTableHeaderCaption"><?php echo $products->pro_model->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_model" class="<?php echo $products->pro_model->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->pro_model) ?>',1);"><div id="elh_products_pro_model" class="products_pro_model">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->pro_model->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->pro_model->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->pro_model->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->post_date->Visible) { // post_date ?>
	<?php if ($products->SortUrl($products->post_date) == "") { ?>
		<th data-name="post_date" class="<?php echo $products->post_date->HeaderCellClass() ?>"><div id="elh_products_post_date" class="products_post_date"><div class="ewTableHeaderCaption"><?php echo $products->post_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="post_date" class="<?php echo $products->post_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->post_date) ?>',1);"><div id="elh_products_post_date" class="products_post_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->post_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->post_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->post_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->ads_id->Visible) { // ads_id ?>
	<?php if ($products->SortUrl($products->ads_id) == "") { ?>
		<th data-name="ads_id" class="<?php echo $products->ads_id->HeaderCellClass() ?>"><div id="elh_products_ads_id" class="products_ads_id"><div class="ewTableHeaderCaption"><?php echo $products->ads_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ads_id" class="<?php echo $products->ads_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->ads_id) ?>',1);"><div id="elh_products_ads_id" class="products_ads_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->ads_id->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->ads_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->ads_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->pro_base_price->Visible) { // pro_base_price ?>
	<?php if ($products->SortUrl($products->pro_base_price) == "") { ?>
		<th data-name="pro_base_price" class="<?php echo $products->pro_base_price->HeaderCellClass() ?>"><div id="elh_products_pro_base_price" class="products_pro_base_price"><div class="ewTableHeaderCaption"><?php echo $products->pro_base_price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_base_price" class="<?php echo $products->pro_base_price->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->pro_base_price) ?>',1);"><div id="elh_products_pro_base_price" class="products_pro_base_price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->pro_base_price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->pro_base_price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->pro_base_price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->pro_sell_price->Visible) { // pro_sell_price ?>
	<?php if ($products->SortUrl($products->pro_sell_price) == "") { ?>
		<th data-name="pro_sell_price" class="<?php echo $products->pro_sell_price->HeaderCellClass() ?>"><div id="elh_products_pro_sell_price" class="products_pro_sell_price"><div class="ewTableHeaderCaption"><?php echo $products->pro_sell_price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_sell_price" class="<?php echo $products->pro_sell_price->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->pro_sell_price) ?>',1);"><div id="elh_products_pro_sell_price" class="products_pro_sell_price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->pro_sell_price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->pro_sell_price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->pro_sell_price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->featured_image->Visible) { // featured_image ?>
	<?php if ($products->SortUrl($products->featured_image) == "") { ?>
		<th data-name="featured_image" class="<?php echo $products->featured_image->HeaderCellClass() ?>"><div id="elh_products_featured_image" class="products_featured_image"><div class="ewTableHeaderCaption"><?php echo $products->featured_image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="featured_image" class="<?php echo $products->featured_image->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->featured_image) ?>',1);"><div id="elh_products_featured_image" class="products_featured_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->featured_image->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->featured_image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->featured_image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->folder_image->Visible) { // folder_image ?>
	<?php if ($products->SortUrl($products->folder_image) == "") { ?>
		<th data-name="folder_image" class="<?php echo $products->folder_image->HeaderCellClass() ?>"><div id="elh_products_folder_image" class="products_folder_image"><div class="ewTableHeaderCaption"><?php echo $products->folder_image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="folder_image" class="<?php echo $products->folder_image->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->folder_image) ?>',1);"><div id="elh_products_folder_image" class="products_folder_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->folder_image->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->folder_image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->folder_image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->img1->Visible) { // img1 ?>
	<?php if ($products->SortUrl($products->img1) == "") { ?>
		<th data-name="img1" class="<?php echo $products->img1->HeaderCellClass() ?>"><div id="elh_products_img1" class="products_img1"><div class="ewTableHeaderCaption"><?php echo $products->img1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="img1" class="<?php echo $products->img1->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->img1) ?>',1);"><div id="elh_products_img1" class="products_img1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->img1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->img1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->img1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->img2->Visible) { // img2 ?>
	<?php if ($products->SortUrl($products->img2) == "") { ?>
		<th data-name="img2" class="<?php echo $products->img2->HeaderCellClass() ?>"><div id="elh_products_img2" class="products_img2"><div class="ewTableHeaderCaption"><?php echo $products->img2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="img2" class="<?php echo $products->img2->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->img2) ?>',1);"><div id="elh_products_img2" class="products_img2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->img2->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->img2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->img2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->img3->Visible) { // img3 ?>
	<?php if ($products->SortUrl($products->img3) == "") { ?>
		<th data-name="img3" class="<?php echo $products->img3->HeaderCellClass() ?>"><div id="elh_products_img3" class="products_img3"><div class="ewTableHeaderCaption"><?php echo $products->img3->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="img3" class="<?php echo $products->img3->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->img3) ?>',1);"><div id="elh_products_img3" class="products_img3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->img3->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->img3->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->img3->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->img4->Visible) { // img4 ?>
	<?php if ($products->SortUrl($products->img4) == "") { ?>
		<th data-name="img4" class="<?php echo $products->img4->HeaderCellClass() ?>"><div id="elh_products_img4" class="products_img4"><div class="ewTableHeaderCaption"><?php echo $products->img4->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="img4" class="<?php echo $products->img4->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->img4) ?>',1);"><div id="elh_products_img4" class="products_img4">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->img4->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->img4->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->img4->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->img5->Visible) { // img5 ?>
	<?php if ($products->SortUrl($products->img5) == "") { ?>
		<th data-name="img5" class="<?php echo $products->img5->HeaderCellClass() ?>"><div id="elh_products_img5" class="products_img5"><div class="ewTableHeaderCaption"><?php echo $products->img5->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="img5" class="<?php echo $products->img5->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->img5) ?>',1);"><div id="elh_products_img5" class="products_img5">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->img5->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->img5->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->img5->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->pro_status->Visible) { // pro_status ?>
	<?php if ($products->SortUrl($products->pro_status) == "") { ?>
		<th data-name="pro_status" class="<?php echo $products->pro_status->HeaderCellClass() ?>"><div id="elh_products_pro_status" class="products_pro_status"><div class="ewTableHeaderCaption"><?php echo $products->pro_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_status" class="<?php echo $products->pro_status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->pro_status) ?>',1);"><div id="elh_products_pro_status" class="products_pro_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->pro_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->pro_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->pro_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$products_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($products->ExportAll && $products->Export <> "") {
	$products_list->StopRec = $products_list->TotalRecs;
} else {

	// Set the last record to display
	if ($products_list->TotalRecs > $products_list->StartRec + $products_list->DisplayRecs - 1)
		$products_list->StopRec = $products_list->StartRec + $products_list->DisplayRecs - 1;
	else
		$products_list->StopRec = $products_list->TotalRecs;
}
$products_list->RecCnt = $products_list->StartRec - 1;
if ($products_list->Recordset && !$products_list->Recordset->EOF) {
	$products_list->Recordset->MoveFirst();
	$bSelectLimit = $products_list->UseSelectLimit;
	if (!$bSelectLimit && $products_list->StartRec > 1)
		$products_list->Recordset->Move($products_list->StartRec - 1);
} elseif (!$products->AllowAddDeleteRow && $products_list->StopRec == 0) {
	$products_list->StopRec = $products->GridAddRowCount;
}

// Initialize aggregate
$products->RowType = EW_ROWTYPE_AGGREGATEINIT;
$products->ResetAttrs();
$products_list->RenderRow();
while ($products_list->RecCnt < $products_list->StopRec) {
	$products_list->RecCnt++;
	if (intval($products_list->RecCnt) >= intval($products_list->StartRec)) {
		$products_list->RowCnt++;

		// Set up key count
		$products_list->KeyCount = $products_list->RowIndex;

		// Init row class and style
		$products->ResetAttrs();
		$products->CssClass = "";
		if ($products->CurrentAction == "gridadd") {
		} else {
			$products_list->LoadRowValues($products_list->Recordset); // Load row values
		}
		$products->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$products->RowAttrs = array_merge($products->RowAttrs, array('data-rowindex'=>$products_list->RowCnt, 'id'=>'r' . $products_list->RowCnt . '_products', 'data-rowtype'=>$products->RowType));

		// Render row
		$products_list->RenderRow();

		// Render list options
		$products_list->RenderListOptions();
?>
	<tr<?php echo $products->RowAttributes() ?>>
<?php

// Render list options (body, left)
$products_list->ListOptions->Render("body", "left", $products_list->RowCnt);
?>
	<?php if ($products->product_id->Visible) { // product_id ?>
		<td data-name="product_id"<?php echo $products->product_id->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_product_id" class="products_product_id">
<span<?php echo $products->product_id->ViewAttributes() ?>>
<?php echo $products->product_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->cat_id->Visible) { // cat_id ?>
		<td data-name="cat_id"<?php echo $products->cat_id->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_cat_id" class="products_cat_id">
<span<?php echo $products->cat_id->ViewAttributes() ?>>
<?php echo $products->cat_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->company_id->Visible) { // company_id ?>
		<td data-name="company_id"<?php echo $products->company_id->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_company_id" class="products_company_id">
<span<?php echo $products->company_id->ViewAttributes() ?>>
<?php echo $products->company_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->pro_name->Visible) { // pro_name ?>
		<td data-name="pro_name"<?php echo $products->pro_name->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_name" class="products_pro_name">
<span<?php echo $products->pro_name->ViewAttributes() ?>>
<?php echo $products->pro_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->pro_condition->Visible) { // pro_condition ?>
		<td data-name="pro_condition"<?php echo $products->pro_condition->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_condition" class="products_pro_condition">
<span<?php echo $products->pro_condition->ViewAttributes() ?>>
<?php echo $products->pro_condition->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->pro_brand->Visible) { // pro_brand ?>
		<td data-name="pro_brand"<?php echo $products->pro_brand->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_brand" class="products_pro_brand">
<span<?php echo $products->pro_brand->ViewAttributes() ?>>
<?php echo $products->pro_brand->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->pro_features->Visible) { // pro_features ?>
		<td data-name="pro_features"<?php echo $products->pro_features->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_features" class="products_pro_features">
<span<?php echo $products->pro_features->ViewAttributes() ?>>
<?php echo $products->pro_features->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->pro_model->Visible) { // pro_model ?>
		<td data-name="pro_model"<?php echo $products->pro_model->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_model" class="products_pro_model">
<span<?php echo $products->pro_model->ViewAttributes() ?>>
<?php echo $products->pro_model->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->post_date->Visible) { // post_date ?>
		<td data-name="post_date"<?php echo $products->post_date->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_post_date" class="products_post_date">
<span<?php echo $products->post_date->ViewAttributes() ?>>
<?php echo $products->post_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->ads_id->Visible) { // ads_id ?>
		<td data-name="ads_id"<?php echo $products->ads_id->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_ads_id" class="products_ads_id">
<span<?php echo $products->ads_id->ViewAttributes() ?>>
<?php echo $products->ads_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->pro_base_price->Visible) { // pro_base_price ?>
		<td data-name="pro_base_price"<?php echo $products->pro_base_price->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_base_price" class="products_pro_base_price">
<span<?php echo $products->pro_base_price->ViewAttributes() ?>>
<?php echo $products->pro_base_price->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->pro_sell_price->Visible) { // pro_sell_price ?>
		<td data-name="pro_sell_price"<?php echo $products->pro_sell_price->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_sell_price" class="products_pro_sell_price">
<span<?php echo $products->pro_sell_price->ViewAttributes() ?>>
<?php echo $products->pro_sell_price->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->featured_image->Visible) { // featured_image ?>
		<td data-name="featured_image"<?php echo $products->featured_image->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_featured_image" class="products_featured_image">
<span<?php echo $products->featured_image->ViewAttributes() ?>>
<?php echo $products->featured_image->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->folder_image->Visible) { // folder_image ?>
		<td data-name="folder_image"<?php echo $products->folder_image->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_folder_image" class="products_folder_image">
<span<?php echo $products->folder_image->ViewAttributes() ?>>
<?php echo $products->folder_image->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->img1->Visible) { // img1 ?>
		<td data-name="img1"<?php echo $products->img1->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_img1" class="products_img1">
<span<?php echo $products->img1->ViewAttributes() ?>>
<?php echo $products->img1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->img2->Visible) { // img2 ?>
		<td data-name="img2"<?php echo $products->img2->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_img2" class="products_img2">
<span<?php echo $products->img2->ViewAttributes() ?>>
<?php echo $products->img2->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->img3->Visible) { // img3 ?>
		<td data-name="img3"<?php echo $products->img3->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_img3" class="products_img3">
<span<?php echo $products->img3->ViewAttributes() ?>>
<?php echo $products->img3->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->img4->Visible) { // img4 ?>
		<td data-name="img4"<?php echo $products->img4->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_img4" class="products_img4">
<span<?php echo $products->img4->ViewAttributes() ?>>
<?php echo $products->img4->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->img5->Visible) { // img5 ?>
		<td data-name="img5"<?php echo $products->img5->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_img5" class="products_img5">
<span<?php echo $products->img5->ViewAttributes() ?>>
<?php echo $products->img5->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($products->pro_status->Visible) { // pro_status ?>
		<td data-name="pro_status"<?php echo $products->pro_status->CellAttributes() ?>>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_status" class="products_pro_status">
<span<?php echo $products->pro_status->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($products->pro_status->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $products->pro_status->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $products->pro_status->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$products_list->ListOptions->Render("body", "right", $products_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($products->CurrentAction <> "gridadd")
		$products_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($products->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($products_list->Recordset)
	$products_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($products->CurrentAction <> "gridadd" && $products->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($products_list->Pager)) $products_list->Pager = new cPrevNextPager($products_list->StartRec, $products_list->DisplayRecs, $products_list->TotalRecs, $products_list->AutoHidePager) ?>
<?php if ($products_list->Pager->RecordCount > 0 && $products_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($products_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $products_list->PageUrl() ?>start=<?php echo $products_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($products_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $products_list->PageUrl() ?>start=<?php echo $products_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $products_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($products_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $products_list->PageUrl() ?>start=<?php echo $products_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($products_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $products_list->PageUrl() ?>start=<?php echo $products_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $products_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($products_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $products_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $products_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $products_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($products_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($products_list->TotalRecs == 0 && $products->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($products_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fproductslistsrch.FilterList = <?php echo $products_list->GetFilterList() ?>;
fproductslistsrch.Init();
fproductslist.Init();
</script>
<?php
$products_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$products_list->Page_Terminate();
?>

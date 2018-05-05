<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "productsinfo.php" ?>
<?php include_once "companyinfo.php" ?>
<?php include_once "product_gallerygridcls.php" ?>
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
		$this->AddUrl = "productsadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
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
		$this->product_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->product_id->Visible = FALSE;
		$this->cat_id->SetVisibility();
		$this->company_id->SetVisibility();
		$this->pro_name->SetVisibility();
		$this->ads_id->SetVisibility();
		$this->pro_base_price->SetVisibility();
		$this->pro_sell_price->SetVisibility();
		$this->featured_image->SetVisibility();
		$this->lang->SetVisibility();

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

			// Get the keys for master table
			$sDetailTblVar = $this->getCurrentDetailTable();
			if ($sDetailTblVar <> "") {
				$DetailTblVar = explode(",", $sDetailTblVar);
				if (in_array("product_gallery", $DetailTblVar)) {

					// Process auto fill for detail table 'product_gallery'
					if (preg_match('/^fproduct_gallery(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["product_gallery_grid"])) $GLOBALS["product_gallery_grid"] = new cproduct_gallery_grid;
						$GLOBALS["product_gallery_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
			}
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
	var $product_gallery_Count;
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
		$this->setKey("product_id", ""); // Clear inline edit key
		$this->pro_base_price->FormValue = ""; // Clear form value
		$this->pro_sell_price->FormValue = ""; // Clear form value
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
		if (isset($_GET["product_id"])) {
			$this->product_id->setQueryStringValue($_GET["product_id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("product_id", $this->product_id->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("product_id")) <> strval($this->product_id->CurrentValue))
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
		if (count($arrKeyFlds) >= 1) {
			$this->product_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->product_id->FormValue))
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
					$sKey .= $this->product_id->CurrentValue;

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
		if ($objForm->HasValue("x_cat_id") && $objForm->HasValue("o_cat_id") && $this->cat_id->CurrentValue <> $this->cat_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_company_id") && $objForm->HasValue("o_company_id") && $this->company_id->CurrentValue <> $this->company_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pro_name") && $objForm->HasValue("o_pro_name") && $this->pro_name->CurrentValue <> $this->pro_name->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_ads_id") && $objForm->HasValue("o_ads_id") && $this->ads_id->CurrentValue <> $this->ads_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pro_base_price") && $objForm->HasValue("o_pro_base_price") && $this->pro_base_price->CurrentValue <> $this->pro_base_price->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pro_sell_price") && $objForm->HasValue("o_pro_sell_price") && $this->pro_sell_price->CurrentValue <> $this->pro_sell_price->OldValue)
			return FALSE;
		if (!ew_Empty($this->featured_image->Upload->Value))
			return FALSE;
		if ($objForm->HasValue("x_lang") && $objForm->HasValue("o_lang") && $this->lang->CurrentValue <> $this->lang->OldValue)
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
		$sFilterList = ew_Concat($sFilterList, $this->product_id->AdvancedSearch->ToJson(), ","); // Field product_id
		$sFilterList = ew_Concat($sFilterList, $this->cat_id->AdvancedSearch->ToJson(), ","); // Field cat_id
		$sFilterList = ew_Concat($sFilterList, $this->company_id->AdvancedSearch->ToJson(), ","); // Field company_id
		$sFilterList = ew_Concat($sFilterList, $this->pro_model->AdvancedSearch->ToJson(), ","); // Field pro_model
		$sFilterList = ew_Concat($sFilterList, $this->pro_name->AdvancedSearch->ToJson(), ","); // Field pro_name
		$sFilterList = ew_Concat($sFilterList, $this->pro_description->AdvancedSearch->ToJson(), ","); // Field pro_description
		$sFilterList = ew_Concat($sFilterList, $this->pro_condition->AdvancedSearch->ToJson(), ","); // Field pro_condition
		$sFilterList = ew_Concat($sFilterList, $this->pro_features->AdvancedSearch->ToJson(), ","); // Field pro_features
		$sFilterList = ew_Concat($sFilterList, $this->post_date->AdvancedSearch->ToJson(), ","); // Field post_date
		$sFilterList = ew_Concat($sFilterList, $this->ads_id->AdvancedSearch->ToJson(), ","); // Field ads_id
		$sFilterList = ew_Concat($sFilterList, $this->pro_base_price->AdvancedSearch->ToJson(), ","); // Field pro_base_price
		$sFilterList = ew_Concat($sFilterList, $this->pro_sell_price->AdvancedSearch->ToJson(), ","); // Field pro_sell_price
		$sFilterList = ew_Concat($sFilterList, $this->featured_image->AdvancedSearch->ToJson(), ","); // Field featured_image
		$sFilterList = ew_Concat($sFilterList, $this->folder_image->AdvancedSearch->ToJson(), ","); // Field folder_image
		$sFilterList = ew_Concat($sFilterList, $this->pro_status->AdvancedSearch->ToJson(), ","); // Field pro_status
		$sFilterList = ew_Concat($sFilterList, $this->branch_id->AdvancedSearch->ToJson(), ","); // Field branch_id
		$sFilterList = ew_Concat($sFilterList, $this->lang->AdvancedSearch->ToJson(), ","); // Field lang
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

		// Field pro_model
		$this->pro_model->AdvancedSearch->SearchValue = @$filter["x_pro_model"];
		$this->pro_model->AdvancedSearch->SearchOperator = @$filter["z_pro_model"];
		$this->pro_model->AdvancedSearch->SearchCondition = @$filter["v_pro_model"];
		$this->pro_model->AdvancedSearch->SearchValue2 = @$filter["y_pro_model"];
		$this->pro_model->AdvancedSearch->SearchOperator2 = @$filter["w_pro_model"];
		$this->pro_model->AdvancedSearch->Save();

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

		// Field pro_features
		$this->pro_features->AdvancedSearch->SearchValue = @$filter["x_pro_features"];
		$this->pro_features->AdvancedSearch->SearchOperator = @$filter["z_pro_features"];
		$this->pro_features->AdvancedSearch->SearchCondition = @$filter["v_pro_features"];
		$this->pro_features->AdvancedSearch->SearchValue2 = @$filter["y_pro_features"];
		$this->pro_features->AdvancedSearch->SearchOperator2 = @$filter["w_pro_features"];
		$this->pro_features->AdvancedSearch->Save();

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

		// Field pro_status
		$this->pro_status->AdvancedSearch->SearchValue = @$filter["x_pro_status"];
		$this->pro_status->AdvancedSearch->SearchOperator = @$filter["z_pro_status"];
		$this->pro_status->AdvancedSearch->SearchCondition = @$filter["v_pro_status"];
		$this->pro_status->AdvancedSearch->SearchValue2 = @$filter["y_pro_status"];
		$this->pro_status->AdvancedSearch->SearchOperator2 = @$filter["w_pro_status"];
		$this->pro_status->AdvancedSearch->Save();

		// Field branch_id
		$this->branch_id->AdvancedSearch->SearchValue = @$filter["x_branch_id"];
		$this->branch_id->AdvancedSearch->SearchOperator = @$filter["z_branch_id"];
		$this->branch_id->AdvancedSearch->SearchCondition = @$filter["v_branch_id"];
		$this->branch_id->AdvancedSearch->SearchValue2 = @$filter["y_branch_id"];
		$this->branch_id->AdvancedSearch->SearchOperator2 = @$filter["w_branch_id"];
		$this->branch_id->AdvancedSearch->Save();

		// Field lang
		$this->lang->AdvancedSearch->SearchValue = @$filter["x_lang"];
		$this->lang->AdvancedSearch->SearchOperator = @$filter["z_lang"];
		$this->lang->AdvancedSearch->SearchCondition = @$filter["v_lang"];
		$this->lang->AdvancedSearch->SearchValue2 = @$filter["y_lang"];
		$this->lang->AdvancedSearch->SearchOperator2 = @$filter["w_lang"];
		$this->lang->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->pro_model, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pro_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pro_description, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pro_condition, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pro_features, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ads_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->featured_image, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->folder_image, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->branch_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->lang, $arKeywords, $type);
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
			$this->UpdateSort($this->product_id, $bCtrl); // product_id
			$this->UpdateSort($this->cat_id, $bCtrl); // cat_id
			$this->UpdateSort($this->company_id, $bCtrl); // company_id
			$this->UpdateSort($this->pro_name, $bCtrl); // pro_name
			$this->UpdateSort($this->ads_id, $bCtrl); // ads_id
			$this->UpdateSort($this->pro_base_price, $bCtrl); // pro_base_price
			$this->UpdateSort($this->pro_sell_price, $bCtrl); // pro_sell_price
			$this->UpdateSort($this->featured_image, $bCtrl); // featured_image
			$this->UpdateSort($this->lang, $bCtrl); // lang
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
				$this->product_id->setSort("");
				$this->cat_id->setSort("");
				$this->company_id->setSort("");
				$this->pro_name->setSort("");
				$this->ads_id->setSort("");
				$this->pro_base_price->setSort("");
				$this->pro_sell_price->setSort("");
				$this->featured_image->setSort("");
				$this->lang->setSort("");
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

		// "detail_product_gallery"
		$item = &$this->ListOptions->Add("detail_product_gallery");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'product_gallery') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["product_gallery_grid"])) $GLOBALS["product_gallery_grid"] = new cproduct_gallery_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssClass = "text-nowrap";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = TRUE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("product_gallery");
		$this->DetailPages = $pages;

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
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->product_id->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"products\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "',btn:null});\">" . $Language->Phrase("ViewLink") . "</a>";
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
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"products\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'SaveBtn',url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("EditLink") . "</a>";
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
				$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-table=\"products\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->CopyUrl) . "'});\">" . $Language->Phrase("CopyLink") . "</a>";
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
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_product_gallery"
		$oListOpt = &$this->ListOptions->Items["detail_product_gallery"];
		if ($Security->AllowList(CurrentProjectID() . 'product_gallery')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("product_gallery", "TblCaption");
			$body .= "&nbsp;" . str_replace("%c", $this->product_gallery_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("product_gallerylist.php?" . EW_TABLE_SHOW_MASTER . "=products&fk_product_id=" . urlencode(strval($this->product_id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["product_gallery_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'product_gallery')) {
				$caption = $Language->Phrase("MasterDetailViewLink");
				$url = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=product_gallery");
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "product_gallery";
			}
			if ($GLOBALS["product_gallery_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'product_gallery')) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=product_gallery");
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "product_gallery";
			}
			if ($GLOBALS["product_gallery_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'product_gallery')) {
				$caption = $Language->Phrase("MasterDetailCopyLink");
				$url = $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=product_gallery");
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "product_gallery";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->product_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->product_id->CurrentValue . "\">";
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
			$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-table=\"products\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_product_gallery");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=product_gallery");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["product_gallery"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["product_gallery"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'product_gallery') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "product_gallery";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink);
			$caption = $Language->Phrase("AddMasterDetailLink");
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
			$item->Visible = ($DetailTableLink <> "" && $Security->CanAdd());

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detailadd_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fproductslist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"products\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'UpdateBtn',f:document.fproductslist,url:'" . $this->MultiUpdateUrl . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
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

		// Search highlight button
		$item = &$this->SearchOptions->Add("searchhighlight");
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewHighlight active\" title=\"" . $Language->Phrase("Highlight") . "\" data-caption=\"" . $Language->Phrase("Highlight") . "\" data-toggle=\"button\" data-form=\"fproductslistsrch\" data-name=\"" . $this->HighlightName() . "\">" . $Language->Phrase("HighlightBtn") . "</button>";
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
		$this->featured_image->Upload->Index = $objForm->Index;
		$this->featured_image->Upload->UploadFile();
		$this->featured_image->CurrentValue = $this->featured_image->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->product_id->CurrentValue = NULL;
		$this->product_id->OldValue = $this->product_id->CurrentValue;
		$this->cat_id->CurrentValue = NULL;
		$this->cat_id->OldValue = $this->cat_id->CurrentValue;
		$this->company_id->CurrentValue = NULL;
		$this->company_id->OldValue = $this->company_id->CurrentValue;
		$this->pro_model->CurrentValue = NULL;
		$this->pro_model->OldValue = $this->pro_model->CurrentValue;
		$this->pro_name->CurrentValue = NULL;
		$this->pro_name->OldValue = $this->pro_name->CurrentValue;
		$this->pro_description->CurrentValue = NULL;
		$this->pro_description->OldValue = $this->pro_description->CurrentValue;
		$this->pro_condition->CurrentValue = NULL;
		$this->pro_condition->OldValue = $this->pro_condition->CurrentValue;
		$this->pro_features->CurrentValue = NULL;
		$this->pro_features->OldValue = $this->pro_features->CurrentValue;
		$this->post_date->CurrentValue = NULL;
		$this->post_date->OldValue = $this->post_date->CurrentValue;
		$this->ads_id->CurrentValue = NULL;
		$this->ads_id->OldValue = $this->ads_id->CurrentValue;
		$this->pro_base_price->CurrentValue = NULL;
		$this->pro_base_price->OldValue = $this->pro_base_price->CurrentValue;
		$this->pro_sell_price->CurrentValue = NULL;
		$this->pro_sell_price->OldValue = $this->pro_sell_price->CurrentValue;
		$this->featured_image->Upload->DbValue = NULL;
		$this->featured_image->OldValue = $this->featured_image->Upload->DbValue;
		$this->folder_image->CurrentValue = NULL;
		$this->folder_image->OldValue = $this->folder_image->CurrentValue;
		$this->pro_status->CurrentValue = NULL;
		$this->pro_status->OldValue = $this->pro_status->CurrentValue;
		$this->branch_id->CurrentValue = NULL;
		$this->branch_id->OldValue = $this->branch_id->CurrentValue;
		$this->lang->CurrentValue = "english";
		$this->lang->OldValue = $this->lang->CurrentValue;
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
		if (!$this->product_id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->product_id->setFormValue($objForm->GetValue("x_product_id"));
		if (!$this->cat_id->FldIsDetailKey) {
			$this->cat_id->setFormValue($objForm->GetValue("x_cat_id"));
		}
		$this->cat_id->setOldValue($objForm->GetValue("o_cat_id"));
		if (!$this->company_id->FldIsDetailKey) {
			$this->company_id->setFormValue($objForm->GetValue("x_company_id"));
		}
		$this->company_id->setOldValue($objForm->GetValue("o_company_id"));
		if (!$this->pro_name->FldIsDetailKey) {
			$this->pro_name->setFormValue($objForm->GetValue("x_pro_name"));
		}
		$this->pro_name->setOldValue($objForm->GetValue("o_pro_name"));
		if (!$this->ads_id->FldIsDetailKey) {
			$this->ads_id->setFormValue($objForm->GetValue("x_ads_id"));
		}
		$this->ads_id->setOldValue($objForm->GetValue("o_ads_id"));
		if (!$this->pro_base_price->FldIsDetailKey) {
			$this->pro_base_price->setFormValue($objForm->GetValue("x_pro_base_price"));
		}
		$this->pro_base_price->setOldValue($objForm->GetValue("o_pro_base_price"));
		if (!$this->pro_sell_price->FldIsDetailKey) {
			$this->pro_sell_price->setFormValue($objForm->GetValue("x_pro_sell_price"));
		}
		$this->pro_sell_price->setOldValue($objForm->GetValue("o_pro_sell_price"));
		if (!$this->lang->FldIsDetailKey) {
			$this->lang->setFormValue($objForm->GetValue("x_lang"));
		}
		$this->lang->setOldValue($objForm->GetValue("o_lang"));
		if ($this->CurrentAction <> "overwrite")
			$this->HashValue = $objForm->GetValue("k_hash");
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->product_id->CurrentValue = $this->product_id->FormValue;
		$this->cat_id->CurrentValue = $this->cat_id->FormValue;
		$this->company_id->CurrentValue = $this->company_id->FormValue;
		$this->pro_name->CurrentValue = $this->pro_name->FormValue;
		$this->ads_id->CurrentValue = $this->ads_id->FormValue;
		$this->pro_base_price->CurrentValue = $this->pro_base_price->FormValue;
		$this->pro_sell_price->CurrentValue = $this->pro_sell_price->FormValue;
		$this->lang->CurrentValue = $this->lang->FormValue;
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
		$this->product_id->setDbValue($row['product_id']);
		$this->cat_id->setDbValue($row['cat_id']);
		if (array_key_exists('EV__cat_id', $rs->fields)) {
			$this->cat_id->VirtualValue = $rs->fields('EV__cat_id'); // Set up virtual field value
		} else {
			$this->cat_id->VirtualValue = ""; // Clear value
		}
		$this->company_id->setDbValue($row['company_id']);
		if (array_key_exists('EV__company_id', $rs->fields)) {
			$this->company_id->VirtualValue = $rs->fields('EV__company_id'); // Set up virtual field value
		} else {
			$this->company_id->VirtualValue = ""; // Clear value
		}
		$this->pro_model->setDbValue($row['pro_model']);
		if (array_key_exists('EV__pro_model', $rs->fields)) {
			$this->pro_model->VirtualValue = $rs->fields('EV__pro_model'); // Set up virtual field value
		} else {
			$this->pro_model->VirtualValue = ""; // Clear value
		}
		$this->pro_name->setDbValue($row['pro_name']);
		$this->pro_description->setDbValue($row['pro_description']);
		$this->pro_condition->setDbValue($row['pro_condition']);
		$this->pro_features->setDbValue($row['pro_features']);
		$this->post_date->setDbValue($row['post_date']);
		$this->ads_id->setDbValue($row['ads_id']);
		$this->pro_base_price->setDbValue($row['pro_base_price']);
		$this->pro_sell_price->setDbValue($row['pro_sell_price']);
		$this->featured_image->Upload->DbValue = $row['featured_image'];
		$this->featured_image->setDbValue($this->featured_image->Upload->DbValue);
		$this->folder_image->setDbValue($row['folder_image']);
		if (array_key_exists('EV__folder_image', $rs->fields)) {
			$this->folder_image->VirtualValue = $rs->fields('EV__folder_image'); // Set up virtual field value
		} else {
			$this->folder_image->VirtualValue = ""; // Clear value
		}
		$this->pro_status->setDbValue($row['pro_status']);
		$this->branch_id->setDbValue($row['branch_id']);
		$this->lang->setDbValue($row['lang']);
		if (!isset($GLOBALS["product_gallery_grid"])) $GLOBALS["product_gallery_grid"] = new cproduct_gallery_grid;
		$sDetailFilter = $GLOBALS["product_gallery"]->SqlDetailFilter_products();
		$sDetailFilter = str_replace("@product_id@", ew_AdjustSql($this->product_id->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["product_gallery"]->setCurrentMasterTable("products");
		$sDetailFilter = $GLOBALS["product_gallery"]->ApplyUserIDFilters($sDetailFilter);
		$this->product_gallery_Count = $GLOBALS["product_gallery"]->LoadRecordCount($sDetailFilter);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['product_id'] = $this->product_id->CurrentValue;
		$row['cat_id'] = $this->cat_id->CurrentValue;
		$row['company_id'] = $this->company_id->CurrentValue;
		$row['pro_model'] = $this->pro_model->CurrentValue;
		$row['pro_name'] = $this->pro_name->CurrentValue;
		$row['pro_description'] = $this->pro_description->CurrentValue;
		$row['pro_condition'] = $this->pro_condition->CurrentValue;
		$row['pro_features'] = $this->pro_features->CurrentValue;
		$row['post_date'] = $this->post_date->CurrentValue;
		$row['ads_id'] = $this->ads_id->CurrentValue;
		$row['pro_base_price'] = $this->pro_base_price->CurrentValue;
		$row['pro_sell_price'] = $this->pro_sell_price->CurrentValue;
		$row['featured_image'] = $this->featured_image->Upload->DbValue;
		$row['folder_image'] = $this->folder_image->CurrentValue;
		$row['pro_status'] = $this->pro_status->CurrentValue;
		$row['branch_id'] = $this->branch_id->CurrentValue;
		$row['lang'] = $this->lang->CurrentValue;
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
		$this->pro_model->DbValue = $row['pro_model'];
		$this->pro_name->DbValue = $row['pro_name'];
		$this->pro_description->DbValue = $row['pro_description'];
		$this->pro_condition->DbValue = $row['pro_condition'];
		$this->pro_features->DbValue = $row['pro_features'];
		$this->post_date->DbValue = $row['post_date'];
		$this->ads_id->DbValue = $row['ads_id'];
		$this->pro_base_price->DbValue = $row['pro_base_price'];
		$this->pro_sell_price->DbValue = $row['pro_sell_price'];
		$this->featured_image->Upload->DbValue = $row['featured_image'];
		$this->folder_image->DbValue = $row['folder_image'];
		$this->pro_status->DbValue = $row['pro_status'];
		$this->branch_id->DbValue = $row['branch_id'];
		$this->lang->DbValue = $row['lang'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("product_id")) <> "")
			$this->product_id->CurrentValue = $this->getKey("product_id"); // product_id
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
		// pro_model
		// pro_name
		// pro_description
		// pro_condition
		// pro_features
		// post_date
		// ads_id
		// pro_base_price
		// pro_sell_price
		// featured_image
		// folder_image
		// pro_status
		// branch_id
		// lang

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// product_id
		$this->product_id->ViewValue = $this->product_id->CurrentValue;
		$this->product_id->ViewCustomAttributes = "";

		// cat_id
		if ($this->cat_id->VirtualValue <> "") {
			$this->cat_id->ViewValue = $this->cat_id->VirtualValue;
		} else {
		if (strval($this->cat_id->CurrentValue) <> "") {
			$sFilterWrk = "`cat_id`" . ew_SearchString("=", $this->cat_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `cat_id`, `cat_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categories`";
		$sWhereWrk = "";
		$this->cat_id->LookupFilters = array("dx1" => '`cat_name`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->cat_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->cat_id->ViewValue = $this->cat_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->cat_id->ViewValue = $this->cat_id->CurrentValue;
			}
		} else {
			$this->cat_id->ViewValue = NULL;
		}
		}
		$this->cat_id->ViewCustomAttributes = "";

		// company_id
		if ($this->company_id->VirtualValue <> "") {
			$this->company_id->ViewValue = $this->company_id->VirtualValue;
		} else {
		if (strval($this->company_id->CurrentValue) <> "") {
			$sFilterWrk = "`company_id`" . ew_SearchString("=", $this->company_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT DISTINCT `company_id`, `com_fname` AS `DispFld`, `com_lname` AS `Disp2Fld`, `com_name` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `company`";
		$sWhereWrk = "";
		$this->company_id->LookupFilters = array("dx1" => '`com_fname`', "dx2" => '`com_lname`', "dx3" => '`com_name`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->company_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->company_id->ViewValue = $this->company_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->company_id->ViewValue = $this->company_id->CurrentValue;
			}
		} else {
			$this->company_id->ViewValue = NULL;
		}
		}
		$this->company_id->ViewCustomAttributes = "";

		// pro_model
		if ($this->pro_model->VirtualValue <> "") {
			$this->pro_model->ViewValue = $this->pro_model->VirtualValue;
		} else {
		if (strval($this->pro_model->CurrentValue) <> "") {
			$sFilterWrk = "`model_id`" . ew_SearchString("=", $this->pro_model->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `model_id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model`";
		$sWhereWrk = "";
		$this->pro_model->LookupFilters = array("dx1" => '`name`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pro_model, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pro_model->ViewValue = $this->pro_model->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pro_model->ViewValue = $this->pro_model->CurrentValue;
			}
		} else {
			$this->pro_model->ViewValue = NULL;
		}
		}
		$this->pro_model->ViewCustomAttributes = "";

		// pro_name
		$this->pro_name->ViewValue = $this->pro_name->CurrentValue;
		$this->pro_name->ViewCustomAttributes = "";

		// pro_condition
		if (strval($this->pro_condition->CurrentValue) <> "") {
			$this->pro_condition->ViewValue = $this->pro_condition->OptionCaption($this->pro_condition->CurrentValue);
		} else {
			$this->pro_condition->ViewValue = NULL;
		}
		$this->pro_condition->ViewCustomAttributes = "";

		// pro_features
		$this->pro_features->ViewValue = $this->pro_features->CurrentValue;
		$this->pro_features->ViewCustomAttributes = "";

		// post_date
		$this->post_date->ViewValue = $this->post_date->CurrentValue;
		$this->post_date->ViewValue = ew_FormatDateTime($this->post_date->ViewValue, 1);
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
		$this->featured_image->UploadPath = "../uploads/product/";
		if (!ew_Empty($this->featured_image->Upload->DbValue)) {
			$this->featured_image->ImageWidth = 0;
			$this->featured_image->ImageHeight = 94;
			$this->featured_image->ImageAlt = $this->featured_image->FldAlt();
			$this->featured_image->ViewValue = $this->featured_image->Upload->DbValue;
		} else {
			$this->featured_image->ViewValue = "";
		}
		$this->featured_image->ViewCustomAttributes = "";

		// folder_image
		if ($this->folder_image->VirtualValue <> "") {
			$this->folder_image->ViewValue = $this->folder_image->VirtualValue;
		} else {
		if (strval($this->folder_image->CurrentValue) <> "") {
			$arwrk = explode(",", $this->folder_image->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`pro_gallery_id`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT DISTINCT `pro_gallery_id`, `image` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `product_gallery`";
		$sWhereWrk = "";
		$this->folder_image->LookupFilters = array("dx1" => '`image`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->folder_image, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->folder_image->ViewValue = "";
				$ari = 0;
				while (!$rswrk->EOF) {
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->folder_image->ViewValue .= $this->folder_image->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->folder_image->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->Close();
			} else {
				$this->folder_image->ViewValue = $this->folder_image->CurrentValue;
			}
		} else {
			$this->folder_image->ViewValue = NULL;
		}
		}
		$this->folder_image->ViewCustomAttributes = "";

		// pro_status
		if (ew_ConvertToBool($this->pro_status->CurrentValue)) {
			$this->pro_status->ViewValue = $this->pro_status->FldTagCaption(1) <> "" ? $this->pro_status->FldTagCaption(1) : "Yes";
		} else {
			$this->pro_status->ViewValue = $this->pro_status->FldTagCaption(2) <> "" ? $this->pro_status->FldTagCaption(2) : "No";
		}
		$this->pro_status->ViewCustomAttributes = "";

		// branch_id
		if (strval($this->branch_id->CurrentValue) <> "") {
			$sFilterWrk = "`branch_id`" . ew_SearchString("=", $this->branch_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `branch_id`, `branch_id` AS `DispFld`, `name` AS `Disp2Fld`, `image` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `branch`";
		$sWhereWrk = "";
		$this->branch_id->LookupFilters = array("dx1" => '`branch_id`', "dx2" => '`name`', "dx3" => '`image`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->branch_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->branch_id->ViewValue = $this->branch_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->branch_id->ViewValue = $this->branch_id->CurrentValue;
			}
		} else {
			$this->branch_id->ViewValue = NULL;
		}
		$this->branch_id->ViewCustomAttributes = "";

		// lang
		if (strval($this->lang->CurrentValue) <> "") {
			$this->lang->ViewValue = $this->lang->OptionCaption($this->lang->CurrentValue);
		} else {
			$this->lang->ViewValue = NULL;
		}
		$this->lang->ViewCustomAttributes = "";

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
			if ($this->Export == "")
				$this->pro_name->ViewValue = $this->HighlightValue($this->pro_name);

			// ads_id
			$this->ads_id->LinkCustomAttributes = "";
			$this->ads_id->HrefValue = "";
			$this->ads_id->TooltipValue = "";
			if ($this->Export == "")
				$this->ads_id->ViewValue = $this->HighlightValue($this->ads_id);

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
			$this->featured_image->UploadPath = "../uploads/product/";
			if (!ew_Empty($this->featured_image->Upload->DbValue)) {
				$this->featured_image->HrefValue = ew_GetFileUploadUrl($this->featured_image, $this->featured_image->Upload->DbValue); // Add prefix/suffix
				$this->featured_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->featured_image->HrefValue = ew_FullUrl($this->featured_image->HrefValue, "href");
			} else {
				$this->featured_image->HrefValue = "";
			}
			$this->featured_image->HrefValue2 = $this->featured_image->UploadPath . $this->featured_image->Upload->DbValue;
			$this->featured_image->TooltipValue = "";
			if ($this->featured_image->UseColorbox) {
				if (ew_Empty($this->featured_image->TooltipValue))
					$this->featured_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->featured_image->LinkAttrs["data-rel"] = "products_x" . $this->RowCnt . "_featured_image";
				ew_AppendClass($this->featured_image->LinkAttrs["class"], "ewLightbox");
			}

			// lang
			$this->lang->LinkCustomAttributes = "";
			$this->lang->HrefValue = "";
			$this->lang->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// product_id
			// cat_id

			$this->cat_id->EditCustomAttributes = "";
			if (trim(strval($this->cat_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`cat_id`" . ew_SearchString("=", $this->cat_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `cat_id`, `cat_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `categories`";
			$sWhereWrk = "";
			$this->cat_id->LookupFilters = array("dx1" => '`cat_name`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->cat_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->cat_id->ViewValue = $this->cat_id->DisplayValue($arwrk);
			} else {
				$this->cat_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->cat_id->EditValue = $arwrk;

			// company_id
			$this->company_id->EditCustomAttributes = "";
			if (trim(strval($this->company_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`company_id`" . ew_SearchString("=", $this->company_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT DISTINCT `company_id`, `com_fname` AS `DispFld`, `com_lname` AS `Disp2Fld`, `com_name` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `company`";
			$sWhereWrk = "";
			$this->company_id->LookupFilters = array("dx1" => '`com_fname`', "dx2" => '`com_lname`', "dx3" => '`com_name`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->company_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$arwrk[3] = ew_HtmlEncode($rswrk->fields('Disp3Fld'));
				$this->company_id->ViewValue = $this->company_id->DisplayValue($arwrk);
			} else {
				$this->company_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->company_id->EditValue = $arwrk;

			// pro_name
			$this->pro_name->EditAttrs["class"] = "form-control";
			$this->pro_name->EditCustomAttributes = "";
			$this->pro_name->EditValue = ew_HtmlEncode($this->pro_name->CurrentValue);
			$this->pro_name->PlaceHolder = ew_RemoveHtml($this->pro_name->FldCaption());

			// ads_id
			$this->ads_id->EditAttrs["class"] = "form-control";
			$this->ads_id->EditCustomAttributes = "";
			$this->ads_id->EditValue = ew_HtmlEncode($this->ads_id->CurrentValue);
			$this->ads_id->PlaceHolder = ew_RemoveHtml($this->ads_id->FldCaption());

			// pro_base_price
			$this->pro_base_price->EditAttrs["class"] = "form-control";
			$this->pro_base_price->EditCustomAttributes = "";
			$this->pro_base_price->EditValue = ew_HtmlEncode($this->pro_base_price->CurrentValue);
			$this->pro_base_price->PlaceHolder = ew_RemoveHtml($this->pro_base_price->FldCaption());
			if (strval($this->pro_base_price->EditValue) <> "" && is_numeric($this->pro_base_price->EditValue)) {
			$this->pro_base_price->EditValue = ew_FormatNumber($this->pro_base_price->EditValue, -2, -1, -2, 0);
			$this->pro_base_price->OldValue = $this->pro_base_price->EditValue;
			}

			// pro_sell_price
			$this->pro_sell_price->EditAttrs["class"] = "form-control";
			$this->pro_sell_price->EditCustomAttributes = "";
			$this->pro_sell_price->EditValue = ew_HtmlEncode($this->pro_sell_price->CurrentValue);
			$this->pro_sell_price->PlaceHolder = ew_RemoveHtml($this->pro_sell_price->FldCaption());
			if (strval($this->pro_sell_price->EditValue) <> "" && is_numeric($this->pro_sell_price->EditValue)) {
			$this->pro_sell_price->EditValue = ew_FormatNumber($this->pro_sell_price->EditValue, -2, -1, -2, 0);
			$this->pro_sell_price->OldValue = $this->pro_sell_price->EditValue;
			}

			// featured_image
			$this->featured_image->EditAttrs["class"] = "form-control";
			$this->featured_image->EditCustomAttributes = "";
			$this->featured_image->UploadPath = "../uploads/product/";
			if (!ew_Empty($this->featured_image->Upload->DbValue)) {
				$this->featured_image->ImageWidth = 0;
				$this->featured_image->ImageHeight = 94;
				$this->featured_image->ImageAlt = $this->featured_image->FldAlt();
				$this->featured_image->EditValue = $this->featured_image->Upload->DbValue;
			} else {
				$this->featured_image->EditValue = "";
			}
			if (!ew_Empty($this->featured_image->CurrentValue))
					if ($this->RowIndex == '$rowindex$')
						$this->featured_image->Upload->FileName = "";
					else
						$this->featured_image->Upload->FileName = $this->featured_image->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->featured_image, $this->RowIndex);

			// lang
			$this->lang->EditCustomAttributes = "";
			$this->lang->EditValue = $this->lang->Options(TRUE);

			// Add refer script
			// product_id

			$this->product_id->LinkCustomAttributes = "";
			$this->product_id->HrefValue = "";

			// cat_id
			$this->cat_id->LinkCustomAttributes = "";
			$this->cat_id->HrefValue = "";

			// company_id
			$this->company_id->LinkCustomAttributes = "";
			$this->company_id->HrefValue = "";

			// pro_name
			$this->pro_name->LinkCustomAttributes = "";
			$this->pro_name->HrefValue = "";

			// ads_id
			$this->ads_id->LinkCustomAttributes = "";
			$this->ads_id->HrefValue = "";

			// pro_base_price
			$this->pro_base_price->LinkCustomAttributes = "";
			$this->pro_base_price->HrefValue = "";

			// pro_sell_price
			$this->pro_sell_price->LinkCustomAttributes = "";
			$this->pro_sell_price->HrefValue = "";

			// featured_image
			$this->featured_image->LinkCustomAttributes = "";
			$this->featured_image->UploadPath = "../uploads/product/";
			if (!ew_Empty($this->featured_image->Upload->DbValue)) {
				$this->featured_image->HrefValue = ew_GetFileUploadUrl($this->featured_image, $this->featured_image->Upload->DbValue); // Add prefix/suffix
				$this->featured_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->featured_image->HrefValue = ew_FullUrl($this->featured_image->HrefValue, "href");
			} else {
				$this->featured_image->HrefValue = "";
			}
			$this->featured_image->HrefValue2 = $this->featured_image->UploadPath . $this->featured_image->Upload->DbValue;

			// lang
			$this->lang->LinkCustomAttributes = "";
			$this->lang->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// product_id
			$this->product_id->EditAttrs["class"] = "form-control";
			$this->product_id->EditCustomAttributes = "";
			$this->product_id->EditValue = $this->product_id->CurrentValue;
			$this->product_id->ViewCustomAttributes = "";

			// cat_id
			$this->cat_id->EditCustomAttributes = "";
			if (trim(strval($this->cat_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`cat_id`" . ew_SearchString("=", $this->cat_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `cat_id`, `cat_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `categories`";
			$sWhereWrk = "";
			$this->cat_id->LookupFilters = array("dx1" => '`cat_name`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->cat_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->cat_id->ViewValue = $this->cat_id->DisplayValue($arwrk);
			} else {
				$this->cat_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->cat_id->EditValue = $arwrk;

			// company_id
			$this->company_id->EditCustomAttributes = "";
			if (trim(strval($this->company_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`company_id`" . ew_SearchString("=", $this->company_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT DISTINCT `company_id`, `com_fname` AS `DispFld`, `com_lname` AS `Disp2Fld`, `com_name` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `company`";
			$sWhereWrk = "";
			$this->company_id->LookupFilters = array("dx1" => '`com_fname`', "dx2" => '`com_lname`', "dx3" => '`com_name`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->company_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$arwrk[3] = ew_HtmlEncode($rswrk->fields('Disp3Fld'));
				$this->company_id->ViewValue = $this->company_id->DisplayValue($arwrk);
			} else {
				$this->company_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->company_id->EditValue = $arwrk;

			// pro_name
			$this->pro_name->EditAttrs["class"] = "form-control";
			$this->pro_name->EditCustomAttributes = "";
			$this->pro_name->EditValue = ew_HtmlEncode($this->pro_name->CurrentValue);
			$this->pro_name->PlaceHolder = ew_RemoveHtml($this->pro_name->FldCaption());

			// ads_id
			$this->ads_id->EditAttrs["class"] = "form-control";
			$this->ads_id->EditCustomAttributes = "";
			$this->ads_id->EditValue = ew_HtmlEncode($this->ads_id->CurrentValue);
			$this->ads_id->PlaceHolder = ew_RemoveHtml($this->ads_id->FldCaption());

			// pro_base_price
			$this->pro_base_price->EditAttrs["class"] = "form-control";
			$this->pro_base_price->EditCustomAttributes = "";
			$this->pro_base_price->EditValue = ew_HtmlEncode($this->pro_base_price->CurrentValue);
			$this->pro_base_price->PlaceHolder = ew_RemoveHtml($this->pro_base_price->FldCaption());
			if (strval($this->pro_base_price->EditValue) <> "" && is_numeric($this->pro_base_price->EditValue)) {
			$this->pro_base_price->EditValue = ew_FormatNumber($this->pro_base_price->EditValue, -2, -1, -2, 0);
			$this->pro_base_price->OldValue = $this->pro_base_price->EditValue;
			}

			// pro_sell_price
			$this->pro_sell_price->EditAttrs["class"] = "form-control";
			$this->pro_sell_price->EditCustomAttributes = "";
			$this->pro_sell_price->EditValue = ew_HtmlEncode($this->pro_sell_price->CurrentValue);
			$this->pro_sell_price->PlaceHolder = ew_RemoveHtml($this->pro_sell_price->FldCaption());
			if (strval($this->pro_sell_price->EditValue) <> "" && is_numeric($this->pro_sell_price->EditValue)) {
			$this->pro_sell_price->EditValue = ew_FormatNumber($this->pro_sell_price->EditValue, -2, -1, -2, 0);
			$this->pro_sell_price->OldValue = $this->pro_sell_price->EditValue;
			}

			// featured_image
			$this->featured_image->EditAttrs["class"] = "form-control";
			$this->featured_image->EditCustomAttributes = "";
			$this->featured_image->UploadPath = "../uploads/product/";
			if (!ew_Empty($this->featured_image->Upload->DbValue)) {
				$this->featured_image->ImageWidth = 0;
				$this->featured_image->ImageHeight = 94;
				$this->featured_image->ImageAlt = $this->featured_image->FldAlt();
				$this->featured_image->EditValue = $this->featured_image->Upload->DbValue;
			} else {
				$this->featured_image->EditValue = "";
			}
			if (!ew_Empty($this->featured_image->CurrentValue))
					if ($this->RowIndex == '$rowindex$')
						$this->featured_image->Upload->FileName = "";
					else
						$this->featured_image->Upload->FileName = $this->featured_image->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->featured_image, $this->RowIndex);

			// lang
			$this->lang->EditCustomAttributes = "";
			$this->lang->EditValue = $this->lang->Options(TRUE);

			// Edit refer script
			// product_id

			$this->product_id->LinkCustomAttributes = "";
			$this->product_id->HrefValue = "";

			// cat_id
			$this->cat_id->LinkCustomAttributes = "";
			$this->cat_id->HrefValue = "";

			// company_id
			$this->company_id->LinkCustomAttributes = "";
			$this->company_id->HrefValue = "";

			// pro_name
			$this->pro_name->LinkCustomAttributes = "";
			$this->pro_name->HrefValue = "";

			// ads_id
			$this->ads_id->LinkCustomAttributes = "";
			$this->ads_id->HrefValue = "";

			// pro_base_price
			$this->pro_base_price->LinkCustomAttributes = "";
			$this->pro_base_price->HrefValue = "";

			// pro_sell_price
			$this->pro_sell_price->LinkCustomAttributes = "";
			$this->pro_sell_price->HrefValue = "";

			// featured_image
			$this->featured_image->LinkCustomAttributes = "";
			$this->featured_image->UploadPath = "../uploads/product/";
			if (!ew_Empty($this->featured_image->Upload->DbValue)) {
				$this->featured_image->HrefValue = ew_GetFileUploadUrl($this->featured_image, $this->featured_image->Upload->DbValue); // Add prefix/suffix
				$this->featured_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->featured_image->HrefValue = ew_FullUrl($this->featured_image->HrefValue, "href");
			} else {
				$this->featured_image->HrefValue = "";
			}
			$this->featured_image->HrefValue2 = $this->featured_image->UploadPath . $this->featured_image->Upload->DbValue;

			// lang
			$this->lang->LinkCustomAttributes = "";
			$this->lang->HrefValue = "";
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
		if (!$this->cat_id->FldIsDetailKey && !is_null($this->cat_id->FormValue) && $this->cat_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cat_id->FldCaption(), $this->cat_id->ReqErrMsg));
		}
		if (!$this->company_id->FldIsDetailKey && !is_null($this->company_id->FormValue) && $this->company_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->company_id->FldCaption(), $this->company_id->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->pro_base_price->FormValue)) {
			ew_AddMessage($gsFormError, $this->pro_base_price->FldErrMsg());
		}
		if (!ew_CheckNumber($this->pro_sell_price->FormValue)) {
			ew_AddMessage($gsFormError, $this->pro_sell_price->FldErrMsg());
		}
		if ($this->featured_image->Upload->FileName == "" && !$this->featured_image->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->featured_image->FldCaption(), $this->featured_image->ReqErrMsg));
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
				$sThisKey .= $row['product_id'];

				// Delete old files
				$this->LoadDbValues($row);
				$this->featured_image->OldUploadPath = "../uploads/product/";
				$OldFiles = ew_Empty($row['featured_image']) ? array() : array($row['featured_image']);
				$OldFileCount = count($OldFiles);
				for ($i = 0; $i < $OldFileCount; $i++) {
					if (file_exists($this->featured_image->OldPhysicalUploadPath() . $OldFiles[$i]))
						@unlink($this->featured_image->OldPhysicalUploadPath() . $OldFiles[$i]);
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
			$this->featured_image->OldUploadPath = "../uploads/product/";
			$this->featured_image->UploadPath = $this->featured_image->OldUploadPath;
			$rsnew = array();

			// cat_id
			$this->cat_id->SetDbValueDef($rsnew, $this->cat_id->CurrentValue, 0, $this->cat_id->ReadOnly);

			// company_id
			$this->company_id->SetDbValueDef($rsnew, $this->company_id->CurrentValue, 0, $this->company_id->ReadOnly);

			// pro_name
			$this->pro_name->SetDbValueDef($rsnew, $this->pro_name->CurrentValue, NULL, $this->pro_name->ReadOnly);

			// ads_id
			$this->ads_id->SetDbValueDef($rsnew, $this->ads_id->CurrentValue, NULL, $this->ads_id->ReadOnly);

			// pro_base_price
			$this->pro_base_price->SetDbValueDef($rsnew, $this->pro_base_price->CurrentValue, NULL, $this->pro_base_price->ReadOnly);

			// pro_sell_price
			$this->pro_sell_price->SetDbValueDef($rsnew, $this->pro_sell_price->CurrentValue, NULL, $this->pro_sell_price->ReadOnly);

			// featured_image
			if ($this->featured_image->Visible && !$this->featured_image->ReadOnly && !$this->featured_image->Upload->KeepFile) {
				$this->featured_image->Upload->DbValue = $rsold['featured_image']; // Get original value
				if ($this->featured_image->Upload->FileName == "") {
					$rsnew['featured_image'] = NULL;
				} else {
					$rsnew['featured_image'] = $this->featured_image->Upload->FileName;
				}
				$this->featured_image->ImageWidth = 875; // Resize width
				$this->featured_image->ImageHeight = 665; // Resize height
			}

			// lang
			$this->lang->SetDbValueDef($rsnew, $this->lang->CurrentValue, "", $this->lang->ReadOnly);

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
			if ($this->featured_image->Visible && !$this->featured_image->Upload->KeepFile) {
				$this->featured_image->UploadPath = "../uploads/product/";
				$OldFiles = ew_Empty($this->featured_image->Upload->DbValue) ? array() : array($this->featured_image->Upload->DbValue);
				if (!ew_Empty($this->featured_image->Upload->FileName)) {
					$NewFiles = array($this->featured_image->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->featured_image->Upload->Index < 0) ? $this->featured_image->FldVar : substr($this->featured_image->FldVar, 0, 1) . $this->featured_image->Upload->Index . substr($this->featured_image->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->featured_image->TblVar) . $file)) {
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
								$file1 = ew_UploadFileNameEx($this->featured_image->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->featured_image->TblVar) . $file1) || file_exists($this->featured_image->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->featured_image->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->featured_image->TblVar) . $file, ew_UploadTempPath($fldvar, $this->featured_image->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->featured_image->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->featured_image->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->featured_image->SetDbValueDef($rsnew, $this->featured_image->Upload->FileName, "", $this->featured_image->ReadOnly);
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
					if ($this->featured_image->Visible && !$this->featured_image->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->featured_image->Upload->DbValue) ? array() : array($this->featured_image->Upload->DbValue);
						if (!ew_Empty($this->featured_image->Upload->FileName)) {
							$NewFiles = array($this->featured_image->Upload->FileName);
							$NewFiles2 = array($rsnew['featured_image']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->featured_image->Upload->Index < 0) ? $this->featured_image->FldVar : substr($this->featured_image->FldVar, 0, 1) . $this->featured_image->Upload->Index . substr($this->featured_image->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->featured_image->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->featured_image->Upload->ResizeAndSaveToFile($this->featured_image->ImageWidth, $this->featured_image->ImageHeight, EW_THUMBNAIL_DEFAULT_QUALITY, $NewFiles[$i], TRUE, $i)) {
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
								@unlink($this->featured_image->OldPhysicalUploadPath() . $OldFiles[$i]);
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

		// featured_image
		ew_CleanUploadTempPath($this->featured_image, $this->featured_image->Upload->Index);
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
		$sHash .= ew_GetFldHash($rs->fields('cat_id')); // cat_id
		$sHash .= ew_GetFldHash($rs->fields('company_id')); // company_id
		$sHash .= ew_GetFldHash($rs->fields('pro_name')); // pro_name
		$sHash .= ew_GetFldHash($rs->fields('ads_id')); // ads_id
		$sHash .= ew_GetFldHash($rs->fields('pro_base_price')); // pro_base_price
		$sHash .= ew_GetFldHash($rs->fields('pro_sell_price')); // pro_sell_price
		$sHash .= ew_GetFldHash($rs->fields('featured_image')); // featured_image
		$sHash .= ew_GetFldHash($rs->fields('lang')); // lang
		return md5($sHash);
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
			$this->featured_image->OldUploadPath = "../uploads/product/";
			$this->featured_image->UploadPath = $this->featured_image->OldUploadPath;
		}
		$rsnew = array();

		// cat_id
		$this->cat_id->SetDbValueDef($rsnew, $this->cat_id->CurrentValue, 0, FALSE);

		// company_id
		$this->company_id->SetDbValueDef($rsnew, $this->company_id->CurrentValue, 0, FALSE);

		// pro_name
		$this->pro_name->SetDbValueDef($rsnew, $this->pro_name->CurrentValue, NULL, FALSE);

		// ads_id
		$this->ads_id->SetDbValueDef($rsnew, $this->ads_id->CurrentValue, NULL, FALSE);

		// pro_base_price
		$this->pro_base_price->SetDbValueDef($rsnew, $this->pro_base_price->CurrentValue, NULL, FALSE);

		// pro_sell_price
		$this->pro_sell_price->SetDbValueDef($rsnew, $this->pro_sell_price->CurrentValue, NULL, FALSE);

		// featured_image
		if ($this->featured_image->Visible && !$this->featured_image->Upload->KeepFile) {
			$this->featured_image->Upload->DbValue = ""; // No need to delete old file
			if ($this->featured_image->Upload->FileName == "") {
				$rsnew['featured_image'] = NULL;
			} else {
				$rsnew['featured_image'] = $this->featured_image->Upload->FileName;
			}
			$this->featured_image->ImageWidth = 875; // Resize width
			$this->featured_image->ImageHeight = 665; // Resize height
		}

		// lang
		$this->lang->SetDbValueDef($rsnew, $this->lang->CurrentValue, "", strval($this->lang->CurrentValue) == "");
		if ($this->featured_image->Visible && !$this->featured_image->Upload->KeepFile) {
			$this->featured_image->UploadPath = "../uploads/product/";
			$OldFiles = ew_Empty($this->featured_image->Upload->DbValue) ? array() : array($this->featured_image->Upload->DbValue);
			if (!ew_Empty($this->featured_image->Upload->FileName)) {
				$NewFiles = array($this->featured_image->Upload->FileName);
				$NewFileCount = count($NewFiles);
				for ($i = 0; $i < $NewFileCount; $i++) {
					$fldvar = ($this->featured_image->Upload->Index < 0) ? $this->featured_image->FldVar : substr($this->featured_image->FldVar, 0, 1) . $this->featured_image->Upload->Index . substr($this->featured_image->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->featured_image->TblVar) . $file)) {
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
							$file1 = ew_UploadFileNameEx($this->featured_image->PhysicalUploadPath(), $file); // Get new file name
							if ($file1 <> $file) { // Rename temp file
								while (file_exists(ew_UploadTempPath($fldvar, $this->featured_image->TblVar) . $file1) || file_exists($this->featured_image->PhysicalUploadPath() . $file1)) // Make sure no file name clash
									$file1 = ew_UniqueFilename($this->featured_image->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
								rename(ew_UploadTempPath($fldvar, $this->featured_image->TblVar) . $file, ew_UploadTempPath($fldvar, $this->featured_image->TblVar) . $file1);
								$NewFiles[$i] = $file1;
							}
						}
					}
				}
				$this->featured_image->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
				$this->featured_image->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$this->featured_image->SetDbValueDef($rsnew, $this->featured_image->Upload->FileName, "", FALSE);
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if ($this->featured_image->Visible && !$this->featured_image->Upload->KeepFile) {
					$OldFiles = ew_Empty($this->featured_image->Upload->DbValue) ? array() : array($this->featured_image->Upload->DbValue);
					if (!ew_Empty($this->featured_image->Upload->FileName)) {
						$NewFiles = array($this->featured_image->Upload->FileName);
						$NewFiles2 = array($rsnew['featured_image']);
						$NewFileCount = count($NewFiles);
						for ($i = 0; $i < $NewFileCount; $i++) {
							$fldvar = ($this->featured_image->Upload->Index < 0) ? $this->featured_image->FldVar : substr($this->featured_image->FldVar, 0, 1) . $this->featured_image->Upload->Index . substr($this->featured_image->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->featured_image->TblVar) . $NewFiles[$i];
								if (file_exists($file)) {
									if (@$NewFiles2[$i] <> "") // Use correct file name
										$NewFiles[$i] = $NewFiles2[$i];
									if (!$this->featured_image->Upload->ResizeAndSaveToFile($this->featured_image->ImageWidth, $this->featured_image->ImageHeight, EW_THUMBNAIL_DEFAULT_QUALITY, $NewFiles[$i], TRUE, $i)) {
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
							@unlink($this->featured_image->OldPhysicalUploadPath() . $OldFiles[$i]);
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

		// featured_image
		ew_CleanUploadTempPath($this->featured_image, $this->featured_image->Upload->Index);
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
		$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.fproductslist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.fproductslist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.fproductslist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.fproductslist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.fproductslist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.fproductslist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.fproductslist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_products\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_products',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fproductslist,sel:true" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		case "x_cat_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `cat_id` AS `LinkFld`, `cat_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categories`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`cat_name`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`cat_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->cat_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_company_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT DISTINCT `company_id` AS `LinkFld`, `com_fname` AS `DispFld`, `com_lname` AS `Disp2Fld`, `com_name` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `company`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`com_fname`', "dx2" => '`com_lname`', "dx3" => '`com_name`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`company_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->company_id, $sWhereWrk); // Call Lookup Selecting
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
<?php if ($products->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fproductslist = new ew_Form("fproductslist", "list");
fproductslist.FormKeyCountName = '<?php echo $products_list->FormKeyCountName ?>';

// Validate form
fproductslist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_cat_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->cat_id->FldCaption(), $products->cat_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_company_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->company_id->FldCaption(), $products->company_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pro_base_price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($products->pro_base_price->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pro_sell_price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($products->pro_sell_price->FldErrMsg()) ?>");
			felm = this.GetElements("x" + infix + "_featured_image");
			elm = this.GetElements("fn_x" + infix + "_featured_image");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $products->featured_image->FldCaption(), $products->featured_image->ReqErrMsg)) ?>");

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
fproductslist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "cat_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "company_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pro_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "ads_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pro_base_price", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pro_sell_price", false)) return false;
	if (ew_ValueChanged(fobj, infix, "featured_image", false)) return false;
	if (ew_ValueChanged(fobj, infix, "lang", false)) return false;
	return true;
}

// Form_CustomValidate event
fproductslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fproductslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fproductslist.Lists["x_cat_id"] = {"LinkField":"x_cat_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_cat_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"categories"};
fproductslist.Lists["x_cat_id"].Data = "<?php echo $products_list->cat_id->LookupFilterQuery(FALSE, "list") ?>";
fproductslist.Lists["x_company_id"] = {"LinkField":"x_company_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_com_fname","x_com_lname","x_com_name",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"company"};
fproductslist.Lists["x_company_id"].Data = "<?php echo $products_list->company_id->LookupFilterQuery(FALSE, "list") ?>";
fproductslist.Lists["x_lang"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fproductslist.Lists["x_lang"].Options = <?php echo json_encode($products_list->lang->Options()) ?>;

// Form object for search
var CurrentSearchForm = fproductslistsrch = new ew_Form("fproductslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($products->Export == "") { ?>
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
<?php } ?>
<?php
if ($products->CurrentAction == "gridadd") {
	$products->CurrentFilter = "0=1";
	$products_list->StartRec = 1;
	$products_list->DisplayRecs = $products->GridAddRowCount;
	$products_list->TotalRecs = $products_list->DisplayRecs;
	$products_list->StopRec = $products_list->DisplayRecs;
} else {
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
<div id="xsr_1" class="ewRow">
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
<?php if ($products->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($products->CurrentAction <> "gridadd" && $products->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
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
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fproductslist" id="fproductslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($products_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $products_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="products">
<input type="hidden" name="exporttype" id="exporttype" value="">
<div id="gmp_products" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($products_list->TotalRecs > 0 || $products->CurrentAction == "add" || $products->CurrentAction == "copy" || $products->CurrentAction == "gridedit") { ?>
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
		<th data-name="product_id" class="<?php echo $products->product_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->product_id) ?>',2);"><div id="elh_products_product_id" class="products_product_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->product_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->product_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->product_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->cat_id->Visible) { // cat_id ?>
	<?php if ($products->SortUrl($products->cat_id) == "") { ?>
		<th data-name="cat_id" class="<?php echo $products->cat_id->HeaderCellClass() ?>"><div id="elh_products_cat_id" class="products_cat_id"><div class="ewTableHeaderCaption"><?php echo $products->cat_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cat_id" class="<?php echo $products->cat_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->cat_id) ?>',2);"><div id="elh_products_cat_id" class="products_cat_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->cat_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->cat_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->cat_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->company_id->Visible) { // company_id ?>
	<?php if ($products->SortUrl($products->company_id) == "") { ?>
		<th data-name="company_id" class="<?php echo $products->company_id->HeaderCellClass() ?>"><div id="elh_products_company_id" class="products_company_id"><div class="ewTableHeaderCaption"><?php echo $products->company_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="company_id" class="<?php echo $products->company_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->company_id) ?>',2);"><div id="elh_products_company_id" class="products_company_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->company_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->company_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->company_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->pro_name->Visible) { // pro_name ?>
	<?php if ($products->SortUrl($products->pro_name) == "") { ?>
		<th data-name="pro_name" class="<?php echo $products->pro_name->HeaderCellClass() ?>"><div id="elh_products_pro_name" class="products_pro_name"><div class="ewTableHeaderCaption"><?php echo $products->pro_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_name" class="<?php echo $products->pro_name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->pro_name) ?>',2);"><div id="elh_products_pro_name" class="products_pro_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->pro_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->pro_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->pro_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->ads_id->Visible) { // ads_id ?>
	<?php if ($products->SortUrl($products->ads_id) == "") { ?>
		<th data-name="ads_id" class="<?php echo $products->ads_id->HeaderCellClass() ?>"><div id="elh_products_ads_id" class="products_ads_id"><div class="ewTableHeaderCaption"><?php echo $products->ads_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ads_id" class="<?php echo $products->ads_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->ads_id) ?>',2);"><div id="elh_products_ads_id" class="products_ads_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->ads_id->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->ads_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->ads_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->pro_base_price->Visible) { // pro_base_price ?>
	<?php if ($products->SortUrl($products->pro_base_price) == "") { ?>
		<th data-name="pro_base_price" class="<?php echo $products->pro_base_price->HeaderCellClass() ?>"><div id="elh_products_pro_base_price" class="products_pro_base_price"><div class="ewTableHeaderCaption"><?php echo $products->pro_base_price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_base_price" class="<?php echo $products->pro_base_price->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->pro_base_price) ?>',2);"><div id="elh_products_pro_base_price" class="products_pro_base_price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->pro_base_price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->pro_base_price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->pro_base_price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->pro_sell_price->Visible) { // pro_sell_price ?>
	<?php if ($products->SortUrl($products->pro_sell_price) == "") { ?>
		<th data-name="pro_sell_price" class="<?php echo $products->pro_sell_price->HeaderCellClass() ?>"><div id="elh_products_pro_sell_price" class="products_pro_sell_price"><div class="ewTableHeaderCaption"><?php echo $products->pro_sell_price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_sell_price" class="<?php echo $products->pro_sell_price->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->pro_sell_price) ?>',2);"><div id="elh_products_pro_sell_price" class="products_pro_sell_price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->pro_sell_price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->pro_sell_price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->pro_sell_price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->featured_image->Visible) { // featured_image ?>
	<?php if ($products->SortUrl($products->featured_image) == "") { ?>
		<th data-name="featured_image" class="<?php echo $products->featured_image->HeaderCellClass() ?>"><div id="elh_products_featured_image" class="products_featured_image"><div class="ewTableHeaderCaption"><?php echo $products->featured_image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="featured_image" class="<?php echo $products->featured_image->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->featured_image) ?>',2);"><div id="elh_products_featured_image" class="products_featured_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->featured_image->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($products->featured_image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->featured_image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($products->lang->Visible) { // lang ?>
	<?php if ($products->SortUrl($products->lang) == "") { ?>
		<th data-name="lang" class="<?php echo $products->lang->HeaderCellClass() ?>"><div id="elh_products_lang" class="products_lang"><div class="ewTableHeaderCaption"><?php echo $products->lang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lang" class="<?php echo $products->lang->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $products->SortUrl($products->lang) ?>',2);"><div id="elh_products_lang" class="products_lang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $products->lang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($products->lang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($products->lang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
	if ($products->CurrentAction == "add" || $products->CurrentAction == "copy") {
		$products_list->RowIndex = 0;
		$products_list->KeyCount = $products_list->RowIndex;
		if ($products->CurrentAction == "add")
			$products_list->LoadRowValues();
		if ($products->EventCancelled) // Insert failed
			$products_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$products->ResetAttrs();
		$products->RowAttrs = array_merge($products->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_products', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$products->RowType = EW_ROWTYPE_ADD;

		// Render row
		$products_list->RenderRow();

		// Render list options
		$products_list->RenderListOptions();
		$products_list->StartRowCnt = 0;
?>
	<tr<?php echo $products->RowAttributes() ?>>
<?php

// Render list options (body, left)
$products_list->ListOptions->Render("body", "left", $products_list->RowCnt);
?>
	<?php if ($products->product_id->Visible) { // product_id ?>
		<td data-name="product_id">
<input type="hidden" data-table="products" data-field="x_product_id" name="o<?php echo $products_list->RowIndex ?>_product_id" id="o<?php echo $products_list->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($products->product_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->cat_id->Visible) { // cat_id ?>
		<td data-name="cat_id">
<span id="el<?php echo $products_list->RowCnt ?>_products_cat_id" class="form-group products_cat_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $products_list->RowIndex ?>_cat_id"><?php echo (strval($products->cat_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->cat_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->cat_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_cat_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->cat_id->ReadOnly || $products->cat_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_cat_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $products->cat_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $products_list->RowIndex ?>_cat_id" id="x<?php echo $products_list->RowIndex ?>_cat_id" value="<?php echo $products->cat_id->CurrentValue ?>"<?php echo $products->cat_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $products->cat_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_cat_id',url:'categoriesaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $products_list->RowIndex ?>_cat_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $products->cat_id->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="products" data-field="x_cat_id" name="o<?php echo $products_list->RowIndex ?>_cat_id" id="o<?php echo $products_list->RowIndex ?>_cat_id" value="<?php echo ew_HtmlEncode($products->cat_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->company_id->Visible) { // company_id ?>
		<td data-name="company_id">
<span id="el<?php echo $products_list->RowCnt ?>_products_company_id" class="form-group products_company_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $products_list->RowIndex ?>_company_id"><?php echo (strval($products->company_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->company_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->company_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_company_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->company_id->ReadOnly || $products->company_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_company_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $products->company_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $products_list->RowIndex ?>_company_id" id="x<?php echo $products_list->RowIndex ?>_company_id" value="<?php echo $products->company_id->CurrentValue ?>"<?php echo $products->company_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $products->company_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_company_id',url:'companyaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $products_list->RowIndex ?>_company_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $products->company_id->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="products" data-field="x_company_id" name="o<?php echo $products_list->RowIndex ?>_company_id" id="o<?php echo $products_list->RowIndex ?>_company_id" value="<?php echo ew_HtmlEncode($products->company_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->pro_name->Visible) { // pro_name ?>
		<td data-name="pro_name">
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_name" class="form-group products_pro_name">
<input type="text" data-table="products" data-field="x_pro_name" name="x<?php echo $products_list->RowIndex ?>_pro_name" id="x<?php echo $products_list->RowIndex ?>_pro_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->pro_name->getPlaceHolder()) ?>" value="<?php echo $products->pro_name->EditValue ?>"<?php echo $products->pro_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="products" data-field="x_pro_name" name="o<?php echo $products_list->RowIndex ?>_pro_name" id="o<?php echo $products_list->RowIndex ?>_pro_name" value="<?php echo ew_HtmlEncode($products->pro_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->ads_id->Visible) { // ads_id ?>
		<td data-name="ads_id">
<span id="el<?php echo $products_list->RowCnt ?>_products_ads_id" class="form-group products_ads_id">
<input type="text" data-table="products" data-field="x_ads_id" name="x<?php echo $products_list->RowIndex ?>_ads_id" id="x<?php echo $products_list->RowIndex ?>_ads_id" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->ads_id->getPlaceHolder()) ?>" value="<?php echo $products->ads_id->EditValue ?>"<?php echo $products->ads_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="products" data-field="x_ads_id" name="o<?php echo $products_list->RowIndex ?>_ads_id" id="o<?php echo $products_list->RowIndex ?>_ads_id" value="<?php echo ew_HtmlEncode($products->ads_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->pro_base_price->Visible) { // pro_base_price ?>
		<td data-name="pro_base_price">
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_base_price" class="form-group products_pro_base_price">
<input type="text" data-table="products" data-field="x_pro_base_price" name="x<?php echo $products_list->RowIndex ?>_pro_base_price" id="x<?php echo $products_list->RowIndex ?>_pro_base_price" size="30" placeholder="<?php echo ew_HtmlEncode($products->pro_base_price->getPlaceHolder()) ?>" value="<?php echo $products->pro_base_price->EditValue ?>"<?php echo $products->pro_base_price->EditAttributes() ?>>
</span>
<input type="hidden" data-table="products" data-field="x_pro_base_price" name="o<?php echo $products_list->RowIndex ?>_pro_base_price" id="o<?php echo $products_list->RowIndex ?>_pro_base_price" value="<?php echo ew_HtmlEncode($products->pro_base_price->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->pro_sell_price->Visible) { // pro_sell_price ?>
		<td data-name="pro_sell_price">
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_sell_price" class="form-group products_pro_sell_price">
<input type="text" data-table="products" data-field="x_pro_sell_price" name="x<?php echo $products_list->RowIndex ?>_pro_sell_price" id="x<?php echo $products_list->RowIndex ?>_pro_sell_price" size="30" placeholder="<?php echo ew_HtmlEncode($products->pro_sell_price->getPlaceHolder()) ?>" value="<?php echo $products->pro_sell_price->EditValue ?>"<?php echo $products->pro_sell_price->EditAttributes() ?>>
</span>
<input type="hidden" data-table="products" data-field="x_pro_sell_price" name="o<?php echo $products_list->RowIndex ?>_pro_sell_price" id="o<?php echo $products_list->RowIndex ?>_pro_sell_price" value="<?php echo ew_HtmlEncode($products->pro_sell_price->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->featured_image->Visible) { // featured_image ?>
		<td data-name="featured_image">
<span id="el<?php echo $products_list->RowCnt ?>_products_featured_image" class="form-group products_featured_image">
<div id="fd_x<?php echo $products_list->RowIndex ?>_featured_image">
<span title="<?php echo $products->featured_image->FldTitle() ? $products->featured_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($products->featured_image->ReadOnly || $products->featured_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="products" data-field="x_featured_image" name="x<?php echo $products_list->RowIndex ?>_featured_image" id="x<?php echo $products_list->RowIndex ?>_featured_image"<?php echo $products->featured_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fn_x<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo $products->featured_image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fa_x<?php echo $products_list->RowIndex ?>_featured_image" value="0">
<input type="hidden" name="fs_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fs_x<?php echo $products_list->RowIndex ?>_featured_image" value="250">
<input type="hidden" name="fx_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fx_x<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo $products->featured_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fm_x<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo $products->featured_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $products_list->RowIndex ?>_featured_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="products" data-field="x_featured_image" name="o<?php echo $products_list->RowIndex ?>_featured_image" id="o<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo ew_HtmlEncode($products->featured_image->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->lang->Visible) { // lang ?>
		<td data-name="lang">
<span id="el<?php echo $products_list->RowCnt ?>_products_lang" class="form-group products_lang">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($products->lang->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $products->lang->ViewValue ?>
	</span>
	<?php if (!$products->lang->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $products_list->RowIndex ?>_lang" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $products->lang->RadioButtonListHtml(TRUE, "x{$products_list->RowIndex}_lang") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $products_list->RowIndex ?>_lang" class="ewTemplate"><input type="radio" data-table="products" data-field="x_lang" data-value-separator="<?php echo $products->lang->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $products_list->RowIndex ?>_lang" id="x<?php echo $products_list->RowIndex ?>_lang" value="{value}"<?php echo $products->lang->EditAttributes() ?>></div>
</div>
</span>
<input type="hidden" data-table="products" data-field="x_lang" name="o<?php echo $products_list->RowIndex ?>_lang" id="o<?php echo $products_list->RowIndex ?>_lang" value="<?php echo ew_HtmlEncode($products->lang->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$products_list->ListOptions->Render("body", "right", $products_list->RowCnt);
?>
<script type="text/javascript">
fproductslist.UpdateOpts(<?php echo $products_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
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

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($products_list->FormKeyCountName) && ($products->CurrentAction == "gridadd" || $products->CurrentAction == "gridedit" || $products->CurrentAction == "F")) {
		$products_list->KeyCount = $objForm->GetValue($products_list->FormKeyCountName);
		$products_list->StopRec = $products_list->StartRec + $products_list->KeyCount - 1;
	}
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
$products_list->EditRowCnt = 0;
if ($products->CurrentAction == "edit")
	$products_list->RowIndex = 1;
if ($products->CurrentAction == "gridadd")
	$products_list->RowIndex = 0;
if ($products->CurrentAction == "gridedit")
	$products_list->RowIndex = 0;
while ($products_list->RecCnt < $products_list->StopRec) {
	$products_list->RecCnt++;
	if (intval($products_list->RecCnt) >= intval($products_list->StartRec)) {
		$products_list->RowCnt++;
		if ($products->CurrentAction == "gridadd" || $products->CurrentAction == "gridedit" || $products->CurrentAction == "F") {
			$products_list->RowIndex++;
			$objForm->Index = $products_list->RowIndex;
			if ($objForm->HasValue($products_list->FormActionName))
				$products_list->RowAction = strval($objForm->GetValue($products_list->FormActionName));
			elseif ($products->CurrentAction == "gridadd")
				$products_list->RowAction = "insert";
			else
				$products_list->RowAction = "";
		}

		// Set up key count
		$products_list->KeyCount = $products_list->RowIndex;

		// Init row class and style
		$products->ResetAttrs();
		$products->CssClass = "";
		if ($products->CurrentAction == "gridadd") {
			$products_list->LoadRowValues(); // Load default values
		} else {
			$products_list->LoadRowValues($products_list->Recordset); // Load row values
		}
		$products->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($products->CurrentAction == "gridadd") // Grid add
			$products->RowType = EW_ROWTYPE_ADD; // Render add
		if ($products->CurrentAction == "gridadd" && $products->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$products_list->RestoreCurrentRowFormValues($products_list->RowIndex); // Restore form values
		if ($products->CurrentAction == "edit") {
			if ($products_list->CheckInlineEditKey() && $products_list->EditRowCnt == 0) { // Inline edit
				$products->RowType = EW_ROWTYPE_EDIT; // Render edit
				if (!$products->EventCancelled)
					$products_list->HashValue = $products_list->GetRowHash($products_list->Recordset); // Get hash value for record
			}
		}
		if ($products->CurrentAction == "gridedit") { // Grid edit
			if ($products->EventCancelled) {
				$products_list->RestoreCurrentRowFormValues($products_list->RowIndex); // Restore form values
			}
			if ($products_list->RowAction == "insert")
				$products->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$products->RowType = EW_ROWTYPE_EDIT; // Render edit
			if (!$products->EventCancelled)
				$products_list->HashValue = $products_list->GetRowHash($products_list->Recordset); // Get hash value for record
		}
		if ($products->CurrentAction == "edit" && $products->RowType == EW_ROWTYPE_EDIT && $products->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$products_list->RestoreFormValues(); // Restore form values
		}
		if ($products->CurrentAction == "gridedit" && ($products->RowType == EW_ROWTYPE_EDIT || $products->RowType == EW_ROWTYPE_ADD) && $products->EventCancelled) // Update failed
			$products_list->RestoreCurrentRowFormValues($products_list->RowIndex); // Restore form values
		if ($products->RowType == EW_ROWTYPE_EDIT) // Edit row
			$products_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$products->RowAttrs = array_merge($products->RowAttrs, array('data-rowindex'=>$products_list->RowCnt, 'id'=>'r' . $products_list->RowCnt . '_products', 'data-rowtype'=>$products->RowType));

		// Render row
		$products_list->RenderRow();

		// Render list options
		$products_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($products_list->RowAction <> "delete" && $products_list->RowAction <> "insertdelete" && !($products_list->RowAction == "insert" && $products->CurrentAction == "F" && $products_list->EmptyRow())) {
?>
	<tr<?php echo $products->RowAttributes() ?>>
<?php

// Render list options (body, left)
$products_list->ListOptions->Render("body", "left", $products_list->RowCnt);
?>
	<?php if ($products->product_id->Visible) { // product_id ?>
		<td data-name="product_id"<?php echo $products->product_id->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="products" data-field="x_product_id" name="o<?php echo $products_list->RowIndex ?>_product_id" id="o<?php echo $products_list->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($products->product_id->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_product_id" class="form-group products_product_id">
<span<?php echo $products->product_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $products->product_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="products" data-field="x_product_id" name="x<?php echo $products_list->RowIndex ?>_product_id" id="x<?php echo $products_list->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($products->product_id->CurrentValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_product_id" class="products_product_id">
<span<?php echo $products->product_id->ViewAttributes() ?>>
<?php echo $products->product_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($products->cat_id->Visible) { // cat_id ?>
		<td data-name="cat_id"<?php echo $products->cat_id->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_cat_id" class="form-group products_cat_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $products_list->RowIndex ?>_cat_id"><?php echo (strval($products->cat_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->cat_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->cat_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_cat_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->cat_id->ReadOnly || $products->cat_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_cat_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $products->cat_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $products_list->RowIndex ?>_cat_id" id="x<?php echo $products_list->RowIndex ?>_cat_id" value="<?php echo $products->cat_id->CurrentValue ?>"<?php echo $products->cat_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $products->cat_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_cat_id',url:'categoriesaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $products_list->RowIndex ?>_cat_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $products->cat_id->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="products" data-field="x_cat_id" name="o<?php echo $products_list->RowIndex ?>_cat_id" id="o<?php echo $products_list->RowIndex ?>_cat_id" value="<?php echo ew_HtmlEncode($products->cat_id->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_cat_id" class="form-group products_cat_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $products_list->RowIndex ?>_cat_id"><?php echo (strval($products->cat_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->cat_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->cat_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_cat_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->cat_id->ReadOnly || $products->cat_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_cat_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $products->cat_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $products_list->RowIndex ?>_cat_id" id="x<?php echo $products_list->RowIndex ?>_cat_id" value="<?php echo $products->cat_id->CurrentValue ?>"<?php echo $products->cat_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $products->cat_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_cat_id',url:'categoriesaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $products_list->RowIndex ?>_cat_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $products->cat_id->FldCaption() ?></span></button>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_cat_id" class="products_cat_id">
<span<?php echo $products->cat_id->ViewAttributes() ?>>
<?php echo $products->cat_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($products->company_id->Visible) { // company_id ?>
		<td data-name="company_id"<?php echo $products->company_id->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_company_id" class="form-group products_company_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $products_list->RowIndex ?>_company_id"><?php echo (strval($products->company_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->company_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->company_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_company_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->company_id->ReadOnly || $products->company_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_company_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $products->company_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $products_list->RowIndex ?>_company_id" id="x<?php echo $products_list->RowIndex ?>_company_id" value="<?php echo $products->company_id->CurrentValue ?>"<?php echo $products->company_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $products->company_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_company_id',url:'companyaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $products_list->RowIndex ?>_company_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $products->company_id->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="products" data-field="x_company_id" name="o<?php echo $products_list->RowIndex ?>_company_id" id="o<?php echo $products_list->RowIndex ?>_company_id" value="<?php echo ew_HtmlEncode($products->company_id->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_company_id" class="form-group products_company_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $products_list->RowIndex ?>_company_id"><?php echo (strval($products->company_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->company_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->company_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_company_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->company_id->ReadOnly || $products->company_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_company_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $products->company_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $products_list->RowIndex ?>_company_id" id="x<?php echo $products_list->RowIndex ?>_company_id" value="<?php echo $products->company_id->CurrentValue ?>"<?php echo $products->company_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $products->company_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_company_id',url:'companyaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $products_list->RowIndex ?>_company_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $products->company_id->FldCaption() ?></span></button>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_company_id" class="products_company_id">
<span<?php echo $products->company_id->ViewAttributes() ?>>
<?php echo $products->company_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($products->pro_name->Visible) { // pro_name ?>
		<td data-name="pro_name"<?php echo $products->pro_name->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_name" class="form-group products_pro_name">
<input type="text" data-table="products" data-field="x_pro_name" name="x<?php echo $products_list->RowIndex ?>_pro_name" id="x<?php echo $products_list->RowIndex ?>_pro_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->pro_name->getPlaceHolder()) ?>" value="<?php echo $products->pro_name->EditValue ?>"<?php echo $products->pro_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="products" data-field="x_pro_name" name="o<?php echo $products_list->RowIndex ?>_pro_name" id="o<?php echo $products_list->RowIndex ?>_pro_name" value="<?php echo ew_HtmlEncode($products->pro_name->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_name" class="form-group products_pro_name">
<input type="text" data-table="products" data-field="x_pro_name" name="x<?php echo $products_list->RowIndex ?>_pro_name" id="x<?php echo $products_list->RowIndex ?>_pro_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->pro_name->getPlaceHolder()) ?>" value="<?php echo $products->pro_name->EditValue ?>"<?php echo $products->pro_name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_name" class="products_pro_name">
<span<?php echo $products->pro_name->ViewAttributes() ?>>
<?php echo $products->pro_name->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($products->ads_id->Visible) { // ads_id ?>
		<td data-name="ads_id"<?php echo $products->ads_id->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_ads_id" class="form-group products_ads_id">
<input type="text" data-table="products" data-field="x_ads_id" name="x<?php echo $products_list->RowIndex ?>_ads_id" id="x<?php echo $products_list->RowIndex ?>_ads_id" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->ads_id->getPlaceHolder()) ?>" value="<?php echo $products->ads_id->EditValue ?>"<?php echo $products->ads_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="products" data-field="x_ads_id" name="o<?php echo $products_list->RowIndex ?>_ads_id" id="o<?php echo $products_list->RowIndex ?>_ads_id" value="<?php echo ew_HtmlEncode($products->ads_id->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_ads_id" class="form-group products_ads_id">
<input type="text" data-table="products" data-field="x_ads_id" name="x<?php echo $products_list->RowIndex ?>_ads_id" id="x<?php echo $products_list->RowIndex ?>_ads_id" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->ads_id->getPlaceHolder()) ?>" value="<?php echo $products->ads_id->EditValue ?>"<?php echo $products->ads_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_ads_id" class="products_ads_id">
<span<?php echo $products->ads_id->ViewAttributes() ?>>
<?php echo $products->ads_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($products->pro_base_price->Visible) { // pro_base_price ?>
		<td data-name="pro_base_price"<?php echo $products->pro_base_price->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_base_price" class="form-group products_pro_base_price">
<input type="text" data-table="products" data-field="x_pro_base_price" name="x<?php echo $products_list->RowIndex ?>_pro_base_price" id="x<?php echo $products_list->RowIndex ?>_pro_base_price" size="30" placeholder="<?php echo ew_HtmlEncode($products->pro_base_price->getPlaceHolder()) ?>" value="<?php echo $products->pro_base_price->EditValue ?>"<?php echo $products->pro_base_price->EditAttributes() ?>>
</span>
<input type="hidden" data-table="products" data-field="x_pro_base_price" name="o<?php echo $products_list->RowIndex ?>_pro_base_price" id="o<?php echo $products_list->RowIndex ?>_pro_base_price" value="<?php echo ew_HtmlEncode($products->pro_base_price->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_base_price" class="form-group products_pro_base_price">
<input type="text" data-table="products" data-field="x_pro_base_price" name="x<?php echo $products_list->RowIndex ?>_pro_base_price" id="x<?php echo $products_list->RowIndex ?>_pro_base_price" size="30" placeholder="<?php echo ew_HtmlEncode($products->pro_base_price->getPlaceHolder()) ?>" value="<?php echo $products->pro_base_price->EditValue ?>"<?php echo $products->pro_base_price->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_base_price" class="products_pro_base_price">
<span<?php echo $products->pro_base_price->ViewAttributes() ?>>
<?php echo $products->pro_base_price->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($products->pro_sell_price->Visible) { // pro_sell_price ?>
		<td data-name="pro_sell_price"<?php echo $products->pro_sell_price->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_sell_price" class="form-group products_pro_sell_price">
<input type="text" data-table="products" data-field="x_pro_sell_price" name="x<?php echo $products_list->RowIndex ?>_pro_sell_price" id="x<?php echo $products_list->RowIndex ?>_pro_sell_price" size="30" placeholder="<?php echo ew_HtmlEncode($products->pro_sell_price->getPlaceHolder()) ?>" value="<?php echo $products->pro_sell_price->EditValue ?>"<?php echo $products->pro_sell_price->EditAttributes() ?>>
</span>
<input type="hidden" data-table="products" data-field="x_pro_sell_price" name="o<?php echo $products_list->RowIndex ?>_pro_sell_price" id="o<?php echo $products_list->RowIndex ?>_pro_sell_price" value="<?php echo ew_HtmlEncode($products->pro_sell_price->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_sell_price" class="form-group products_pro_sell_price">
<input type="text" data-table="products" data-field="x_pro_sell_price" name="x<?php echo $products_list->RowIndex ?>_pro_sell_price" id="x<?php echo $products_list->RowIndex ?>_pro_sell_price" size="30" placeholder="<?php echo ew_HtmlEncode($products->pro_sell_price->getPlaceHolder()) ?>" value="<?php echo $products->pro_sell_price->EditValue ?>"<?php echo $products->pro_sell_price->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_pro_sell_price" class="products_pro_sell_price">
<span<?php echo $products->pro_sell_price->ViewAttributes() ?>>
<?php echo $products->pro_sell_price->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($products->featured_image->Visible) { // featured_image ?>
		<td data-name="featured_image"<?php echo $products->featured_image->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_featured_image" class="form-group products_featured_image">
<div id="fd_x<?php echo $products_list->RowIndex ?>_featured_image">
<span title="<?php echo $products->featured_image->FldTitle() ? $products->featured_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($products->featured_image->ReadOnly || $products->featured_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="products" data-field="x_featured_image" name="x<?php echo $products_list->RowIndex ?>_featured_image" id="x<?php echo $products_list->RowIndex ?>_featured_image"<?php echo $products->featured_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fn_x<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo $products->featured_image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fa_x<?php echo $products_list->RowIndex ?>_featured_image" value="0">
<input type="hidden" name="fs_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fs_x<?php echo $products_list->RowIndex ?>_featured_image" value="250">
<input type="hidden" name="fx_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fx_x<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo $products->featured_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fm_x<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo $products->featured_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $products_list->RowIndex ?>_featured_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="products" data-field="x_featured_image" name="o<?php echo $products_list->RowIndex ?>_featured_image" id="o<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo ew_HtmlEncode($products->featured_image->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_featured_image" class="form-group products_featured_image">
<div id="fd_x<?php echo $products_list->RowIndex ?>_featured_image">
<span title="<?php echo $products->featured_image->FldTitle() ? $products->featured_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($products->featured_image->ReadOnly || $products->featured_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="products" data-field="x_featured_image" name="x<?php echo $products_list->RowIndex ?>_featured_image" id="x<?php echo $products_list->RowIndex ?>_featured_image"<?php echo $products->featured_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fn_x<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo $products->featured_image->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $products_list->RowIndex ?>_featured_image"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fa_x<?php echo $products_list->RowIndex ?>_featured_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fa_x<?php echo $products_list->RowIndex ?>_featured_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fs_x<?php echo $products_list->RowIndex ?>_featured_image" value="250">
<input type="hidden" name="fx_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fx_x<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo $products->featured_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fm_x<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo $products->featured_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $products_list->RowIndex ?>_featured_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_featured_image" class="products_featured_image">
<span>
<?php echo ew_GetFileViewTag($products->featured_image, $products->featured_image->ListViewValue()) ?>
</span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($products->lang->Visible) { // lang ?>
		<td data-name="lang"<?php echo $products->lang->CellAttributes() ?>>
<?php if ($products->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_lang" class="form-group products_lang">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($products->lang->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $products->lang->ViewValue ?>
	</span>
	<?php if (!$products->lang->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $products_list->RowIndex ?>_lang" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $products->lang->RadioButtonListHtml(TRUE, "x{$products_list->RowIndex}_lang") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $products_list->RowIndex ?>_lang" class="ewTemplate"><input type="radio" data-table="products" data-field="x_lang" data-value-separator="<?php echo $products->lang->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $products_list->RowIndex ?>_lang" id="x<?php echo $products_list->RowIndex ?>_lang" value="{value}"<?php echo $products->lang->EditAttributes() ?>></div>
</div>
</span>
<input type="hidden" data-table="products" data-field="x_lang" name="o<?php echo $products_list->RowIndex ?>_lang" id="o<?php echo $products_list->RowIndex ?>_lang" value="<?php echo ew_HtmlEncode($products->lang->OldValue) ?>">
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_lang" class="form-group products_lang">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($products->lang->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $products->lang->ViewValue ?>
	</span>
	<?php if (!$products->lang->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $products_list->RowIndex ?>_lang" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $products->lang->RadioButtonListHtml(TRUE, "x{$products_list->RowIndex}_lang") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $products_list->RowIndex ?>_lang" class="ewTemplate"><input type="radio" data-table="products" data-field="x_lang" data-value-separator="<?php echo $products->lang->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $products_list->RowIndex ?>_lang" id="x<?php echo $products_list->RowIndex ?>_lang" value="{value}"<?php echo $products->lang->EditAttributes() ?>></div>
</div>
</span>
<?php } ?>
<?php if ($products->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $products_list->RowCnt ?>_products_lang" class="products_lang">
<span<?php echo $products->lang->ViewAttributes() ?>>
<?php echo $products->lang->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$products_list->ListOptions->Render("body", "right", $products_list->RowCnt);
?>
	</tr>
<?php if ($products->RowType == EW_ROWTYPE_ADD || $products->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fproductslist.UpdateOpts(<?php echo $products_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($products->CurrentAction <> "gridadd")
		if (!$products_list->Recordset->EOF) $products_list->Recordset->MoveNext();
}
?>
<?php
	if ($products->CurrentAction == "gridadd" || $products->CurrentAction == "gridedit") {
		$products_list->RowIndex = '$rowindex$';
		$products_list->LoadRowValues();

		// Set row properties
		$products->ResetAttrs();
		$products->RowAttrs = array_merge($products->RowAttrs, array('data-rowindex'=>$products_list->RowIndex, 'id'=>'r0_products', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($products->RowAttrs["class"], "ewTemplate");
		$products->RowType = EW_ROWTYPE_ADD;

		// Render row
		$products_list->RenderRow();

		// Render list options
		$products_list->RenderListOptions();
		$products_list->StartRowCnt = 0;
?>
	<tr<?php echo $products->RowAttributes() ?>>
<?php

// Render list options (body, left)
$products_list->ListOptions->Render("body", "left", $products_list->RowIndex);
?>
	<?php if ($products->product_id->Visible) { // product_id ?>
		<td data-name="product_id">
<input type="hidden" data-table="products" data-field="x_product_id" name="o<?php echo $products_list->RowIndex ?>_product_id" id="o<?php echo $products_list->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($products->product_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->cat_id->Visible) { // cat_id ?>
		<td data-name="cat_id">
<span id="el$rowindex$_products_cat_id" class="form-group products_cat_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $products_list->RowIndex ?>_cat_id"><?php echo (strval($products->cat_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->cat_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->cat_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_cat_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->cat_id->ReadOnly || $products->cat_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_cat_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $products->cat_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $products_list->RowIndex ?>_cat_id" id="x<?php echo $products_list->RowIndex ?>_cat_id" value="<?php echo $products->cat_id->CurrentValue ?>"<?php echo $products->cat_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $products->cat_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_cat_id',url:'categoriesaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $products_list->RowIndex ?>_cat_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $products->cat_id->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="products" data-field="x_cat_id" name="o<?php echo $products_list->RowIndex ?>_cat_id" id="o<?php echo $products_list->RowIndex ?>_cat_id" value="<?php echo ew_HtmlEncode($products->cat_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->company_id->Visible) { // company_id ?>
		<td data-name="company_id">
<span id="el$rowindex$_products_company_id" class="form-group products_company_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $products_list->RowIndex ?>_company_id"><?php echo (strval($products->company_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->company_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->company_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_company_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->company_id->ReadOnly || $products->company_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_company_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $products->company_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $products_list->RowIndex ?>_company_id" id="x<?php echo $products_list->RowIndex ?>_company_id" value="<?php echo $products->company_id->CurrentValue ?>"<?php echo $products->company_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $products->company_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $products_list->RowIndex ?>_company_id',url:'companyaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $products_list->RowIndex ?>_company_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $products->company_id->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="products" data-field="x_company_id" name="o<?php echo $products_list->RowIndex ?>_company_id" id="o<?php echo $products_list->RowIndex ?>_company_id" value="<?php echo ew_HtmlEncode($products->company_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->pro_name->Visible) { // pro_name ?>
		<td data-name="pro_name">
<span id="el$rowindex$_products_pro_name" class="form-group products_pro_name">
<input type="text" data-table="products" data-field="x_pro_name" name="x<?php echo $products_list->RowIndex ?>_pro_name" id="x<?php echo $products_list->RowIndex ?>_pro_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->pro_name->getPlaceHolder()) ?>" value="<?php echo $products->pro_name->EditValue ?>"<?php echo $products->pro_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="products" data-field="x_pro_name" name="o<?php echo $products_list->RowIndex ?>_pro_name" id="o<?php echo $products_list->RowIndex ?>_pro_name" value="<?php echo ew_HtmlEncode($products->pro_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->ads_id->Visible) { // ads_id ?>
		<td data-name="ads_id">
<span id="el$rowindex$_products_ads_id" class="form-group products_ads_id">
<input type="text" data-table="products" data-field="x_ads_id" name="x<?php echo $products_list->RowIndex ?>_ads_id" id="x<?php echo $products_list->RowIndex ?>_ads_id" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->ads_id->getPlaceHolder()) ?>" value="<?php echo $products->ads_id->EditValue ?>"<?php echo $products->ads_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="products" data-field="x_ads_id" name="o<?php echo $products_list->RowIndex ?>_ads_id" id="o<?php echo $products_list->RowIndex ?>_ads_id" value="<?php echo ew_HtmlEncode($products->ads_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->pro_base_price->Visible) { // pro_base_price ?>
		<td data-name="pro_base_price">
<span id="el$rowindex$_products_pro_base_price" class="form-group products_pro_base_price">
<input type="text" data-table="products" data-field="x_pro_base_price" name="x<?php echo $products_list->RowIndex ?>_pro_base_price" id="x<?php echo $products_list->RowIndex ?>_pro_base_price" size="30" placeholder="<?php echo ew_HtmlEncode($products->pro_base_price->getPlaceHolder()) ?>" value="<?php echo $products->pro_base_price->EditValue ?>"<?php echo $products->pro_base_price->EditAttributes() ?>>
</span>
<input type="hidden" data-table="products" data-field="x_pro_base_price" name="o<?php echo $products_list->RowIndex ?>_pro_base_price" id="o<?php echo $products_list->RowIndex ?>_pro_base_price" value="<?php echo ew_HtmlEncode($products->pro_base_price->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->pro_sell_price->Visible) { // pro_sell_price ?>
		<td data-name="pro_sell_price">
<span id="el$rowindex$_products_pro_sell_price" class="form-group products_pro_sell_price">
<input type="text" data-table="products" data-field="x_pro_sell_price" name="x<?php echo $products_list->RowIndex ?>_pro_sell_price" id="x<?php echo $products_list->RowIndex ?>_pro_sell_price" size="30" placeholder="<?php echo ew_HtmlEncode($products->pro_sell_price->getPlaceHolder()) ?>" value="<?php echo $products->pro_sell_price->EditValue ?>"<?php echo $products->pro_sell_price->EditAttributes() ?>>
</span>
<input type="hidden" data-table="products" data-field="x_pro_sell_price" name="o<?php echo $products_list->RowIndex ?>_pro_sell_price" id="o<?php echo $products_list->RowIndex ?>_pro_sell_price" value="<?php echo ew_HtmlEncode($products->pro_sell_price->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->featured_image->Visible) { // featured_image ?>
		<td data-name="featured_image">
<span id="el$rowindex$_products_featured_image" class="form-group products_featured_image">
<div id="fd_x<?php echo $products_list->RowIndex ?>_featured_image">
<span title="<?php echo $products->featured_image->FldTitle() ? $products->featured_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($products->featured_image->ReadOnly || $products->featured_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="products" data-field="x_featured_image" name="x<?php echo $products_list->RowIndex ?>_featured_image" id="x<?php echo $products_list->RowIndex ?>_featured_image"<?php echo $products->featured_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fn_x<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo $products->featured_image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fa_x<?php echo $products_list->RowIndex ?>_featured_image" value="0">
<input type="hidden" name="fs_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fs_x<?php echo $products_list->RowIndex ?>_featured_image" value="250">
<input type="hidden" name="fx_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fx_x<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo $products->featured_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $products_list->RowIndex ?>_featured_image" id= "fm_x<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo $products->featured_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $products_list->RowIndex ?>_featured_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="products" data-field="x_featured_image" name="o<?php echo $products_list->RowIndex ?>_featured_image" id="o<?php echo $products_list->RowIndex ?>_featured_image" value="<?php echo ew_HtmlEncode($products->featured_image->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($products->lang->Visible) { // lang ?>
		<td data-name="lang">
<span id="el$rowindex$_products_lang" class="form-group products_lang">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($products->lang->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $products->lang->ViewValue ?>
	</span>
	<?php if (!$products->lang->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $products_list->RowIndex ?>_lang" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $products->lang->RadioButtonListHtml(TRUE, "x{$products_list->RowIndex}_lang") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $products_list->RowIndex ?>_lang" class="ewTemplate"><input type="radio" data-table="products" data-field="x_lang" data-value-separator="<?php echo $products->lang->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $products_list->RowIndex ?>_lang" id="x<?php echo $products_list->RowIndex ?>_lang" value="{value}"<?php echo $products->lang->EditAttributes() ?>></div>
</div>
</span>
<input type="hidden" data-table="products" data-field="x_lang" name="o<?php echo $products_list->RowIndex ?>_lang" id="o<?php echo $products_list->RowIndex ?>_lang" value="<?php echo ew_HtmlEncode($products->lang->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$products_list->ListOptions->Render("body", "right", $products_list->RowIndex);
?>
<script type="text/javascript">
fproductslist.UpdateOpts(<?php echo $products_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($products->CurrentAction == "add" || $products->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $products_list->FormKeyCountName ?>" id="<?php echo $products_list->FormKeyCountName ?>" value="<?php echo $products_list->KeyCount ?>">
<?php } ?>
<?php if ($products->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $products_list->FormKeyCountName ?>" id="<?php echo $products_list->FormKeyCountName ?>" value="<?php echo $products_list->KeyCount ?>">
<?php echo $products_list->MultiSelectKey ?>
<?php } ?>
<?php if ($products->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $products_list->FormKeyCountName ?>" id="<?php echo $products_list->FormKeyCountName ?>" value="<?php echo $products_list->KeyCount ?>">
<?php } ?>
<?php if ($products->CurrentAction == "gridedit") { ?>
<?php if ($products->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="a_list" id="a_list" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $products_list->FormKeyCountName ?>" id="<?php echo $products_list->FormKeyCountName ?>" value="<?php echo $products_list->KeyCount ?>">
<?php echo $products_list->MultiSelectKey ?>
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
<?php if ($products->Export == "") { ?>
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
<?php } ?>
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
<?php if ($products->Export == "") { ?>
<script type="text/javascript">
fproductslistsrch.FilterList = <?php echo $products_list->GetFilterList() ?>;
fproductslistsrch.Init();
fproductslist.Init();
</script>
<?php } ?>
<?php
$products_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($products->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$products_list->Page_Terminate();
?>

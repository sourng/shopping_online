<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "product_galleryinfo.php" ?>
<?php include_once "productsinfo.php" ?>
<?php include_once "companyinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$product_gallery_list = NULL; // Initialize page object first

class cproduct_gallery_list extends cproduct_gallery {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'product_gallery';

	// Page object name
	var $PageObjName = 'product_gallery_list';

	// Grid form hidden field names
	var $FormName = 'fproduct_gallerylist';
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

		// Table object (product_gallery)
		if (!isset($GLOBALS["product_gallery"]) || get_class($GLOBALS["product_gallery"]) == "cproduct_gallery") {
			$GLOBALS["product_gallery"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["product_gallery"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "product_galleryadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "product_gallerydelete.php";
		$this->MultiUpdateUrl = "product_galleryupdate.php";

		// Table object (products)
		if (!isset($GLOBALS['products'])) $GLOBALS['products'] = new cproducts();

		// Table object (company)
		if (!isset($GLOBALS['company'])) $GLOBALS['company'] = new ccompany();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'product_gallery', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fproduct_gallerylistsrch";

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
		$this->pro_gallery_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->pro_gallery_id->Visible = FALSE;
		$this->product_id->SetVisibility();
		$this->thumnail->SetVisibility();
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

		// Set up master detail parameters
		$this->SetupMasterParms();

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
		global $EW_EXPORT, $product_gallery;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($product_gallery);
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

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "products") {
			global $products;
			$rsmaster = $products->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("productslist.php"); // Return to master page
			} else {
				$products->LoadListRowValues($rsmaster);
				$products->RowType = EW_ROWTYPE_MASTER; // Master row
				$products->RenderListRow();
				$rsmaster->Close();
			}
		}

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
		$this->setKey("pro_gallery_id", ""); // Clear inline edit key
		$this->setKey("product_id", ""); // Clear inline edit key
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
		if (isset($_GET["pro_gallery_id"])) {
			$this->pro_gallery_id->setQueryStringValue($_GET["pro_gallery_id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if (isset($_GET["product_id"])) {
			$this->product_id->setQueryStringValue($_GET["product_id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("pro_gallery_id", $this->pro_gallery_id->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("pro_gallery_id")) <> strval($this->pro_gallery_id->CurrentValue))
			return FALSE;
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
		if (count($arrKeyFlds) >= 2) {
			$this->pro_gallery_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->pro_gallery_id->FormValue))
				return FALSE;
			$this->product_id->setFormValue($arrKeyFlds[1]);
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
					$sKey .= $this->pro_gallery_id->CurrentValue;
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
		if ($objForm->HasValue("x_product_id") && $objForm->HasValue("o_product_id") && $this->product_id->CurrentValue <> $this->product_id->OldValue)
			return FALSE;
		if (!ew_Empty($this->thumnail->Upload->Value))
			return FALSE;
		if (!ew_Empty($this->image->Upload->Value))
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
		$sFilterList = ew_Concat($sFilterList, $this->pro_gallery_id->AdvancedSearch->ToJson(), ","); // Field pro_gallery_id
		$sFilterList = ew_Concat($sFilterList, $this->product_id->AdvancedSearch->ToJson(), ","); // Field product_id
		$sFilterList = ew_Concat($sFilterList, $this->thumnail->AdvancedSearch->ToJson(), ","); // Field thumnail
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fproduct_gallerylistsrch", $filters);

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

		// Field pro_gallery_id
		$this->pro_gallery_id->AdvancedSearch->SearchValue = @$filter["x_pro_gallery_id"];
		$this->pro_gallery_id->AdvancedSearch->SearchOperator = @$filter["z_pro_gallery_id"];
		$this->pro_gallery_id->AdvancedSearch->SearchCondition = @$filter["v_pro_gallery_id"];
		$this->pro_gallery_id->AdvancedSearch->SearchValue2 = @$filter["y_pro_gallery_id"];
		$this->pro_gallery_id->AdvancedSearch->SearchOperator2 = @$filter["w_pro_gallery_id"];
		$this->pro_gallery_id->AdvancedSearch->Save();

		// Field product_id
		$this->product_id->AdvancedSearch->SearchValue = @$filter["x_product_id"];
		$this->product_id->AdvancedSearch->SearchOperator = @$filter["z_product_id"];
		$this->product_id->AdvancedSearch->SearchCondition = @$filter["v_product_id"];
		$this->product_id->AdvancedSearch->SearchValue2 = @$filter["y_product_id"];
		$this->product_id->AdvancedSearch->SearchOperator2 = @$filter["w_product_id"];
		$this->product_id->AdvancedSearch->Save();

		// Field thumnail
		$this->thumnail->AdvancedSearch->SearchValue = @$filter["x_thumnail"];
		$this->thumnail->AdvancedSearch->SearchOperator = @$filter["z_thumnail"];
		$this->thumnail->AdvancedSearch->SearchCondition = @$filter["v_thumnail"];
		$this->thumnail->AdvancedSearch->SearchValue2 = @$filter["y_thumnail"];
		$this->thumnail->AdvancedSearch->SearchOperator2 = @$filter["w_thumnail"];
		$this->thumnail->AdvancedSearch->Save();

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
		$this->BuildBasicSearchSQL($sWhere, $this->thumnail, $arKeywords, $type);
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
			$this->UpdateSort($this->pro_gallery_id, $bCtrl); // pro_gallery_id
			$this->UpdateSort($this->product_id, $bCtrl); // product_id
			$this->UpdateSort($this->thumnail, $bCtrl); // thumnail
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->product_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->setSessionOrderByList($sOrderBy);
				$this->pro_gallery_id->setSort("");
				$this->product_id->setSort("");
				$this->thumnail->setSort("");
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
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->pro_gallery_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->product_id->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"product_gallery\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "',btn:null});\">" . $Language->Phrase("ViewLink") . "</a>";
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
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"product_gallery\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'SaveBtn',url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("EditLink") . "</a>";
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
				$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-table=\"product_gallery\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->CopyUrl) . "'});\">" . $Language->Phrase("CopyLink") . "</a>";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->pro_gallery_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->product_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->pro_gallery_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->product_id->CurrentValue . "\">";
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
			$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-table=\"product_gallery\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("AddLink") . "</a>";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fproduct_gallerylist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"product_gallery\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'UpdateBtn',f:document.fproduct_gallerylist,url:'" . $this->MultiUpdateUrl . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fproduct_gallerylistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fproduct_gallerylistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fproduct_gallerylist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fproduct_gallerylistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Search highlight button
		$item = &$this->SearchOptions->Add("searchhighlight");
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewHighlight active\" title=\"" . $Language->Phrase("Highlight") . "\" data-caption=\"" . $Language->Phrase("Highlight") . "\" data-toggle=\"button\" data-form=\"fproduct_gallerylistsrch\" data-name=\"" . $this->HighlightName() . "\">" . $Language->Phrase("HighlightBtn") . "</button>";
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
		$this->thumnail->Upload->Index = $objForm->Index;
		$this->thumnail->Upload->UploadFile();
		$this->thumnail->CurrentValue = $this->thumnail->Upload->FileName;
		$this->image->Upload->Index = $objForm->Index;
		$this->image->Upload->UploadFile();
		$this->image->CurrentValue = $this->image->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->pro_gallery_id->CurrentValue = NULL;
		$this->pro_gallery_id->OldValue = $this->pro_gallery_id->CurrentValue;
		$this->product_id->CurrentValue = NULL;
		$this->product_id->OldValue = $this->product_id->CurrentValue;
		$this->thumnail->Upload->DbValue = NULL;
		$this->thumnail->OldValue = $this->thumnail->Upload->DbValue;
		$this->image->Upload->DbValue = NULL;
		$this->image->OldValue = $this->image->Upload->DbValue;
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
		if (!$this->pro_gallery_id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->pro_gallery_id->setFormValue($objForm->GetValue("x_pro_gallery_id"));
		if (!$this->product_id->FldIsDetailKey) {
			$this->product_id->setFormValue($objForm->GetValue("x_product_id"));
		}
		$this->product_id->setOldValue($objForm->GetValue("o_product_id"));
		if ($this->CurrentAction <> "overwrite")
			$this->HashValue = $objForm->GetValue("k_hash");
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->pro_gallery_id->CurrentValue = $this->pro_gallery_id->FormValue;
		$this->product_id->CurrentValue = $this->product_id->FormValue;
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
		$this->pro_gallery_id->setDbValue($row['pro_gallery_id']);
		$this->product_id->setDbValue($row['product_id']);
		if (array_key_exists('EV__product_id', $rs->fields)) {
			$this->product_id->VirtualValue = $rs->fields('EV__product_id'); // Set up virtual field value
		} else {
			$this->product_id->VirtualValue = ""; // Clear value
		}
		$this->thumnail->Upload->DbValue = $row['thumnail'];
		$this->thumnail->setDbValue($this->thumnail->Upload->DbValue);
		$this->image->Upload->DbValue = $row['image'];
		$this->image->setDbValue($this->image->Upload->DbValue);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['pro_gallery_id'] = $this->pro_gallery_id->CurrentValue;
		$row['product_id'] = $this->product_id->CurrentValue;
		$row['thumnail'] = $this->thumnail->Upload->DbValue;
		$row['image'] = $this->image->Upload->DbValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->pro_gallery_id->DbValue = $row['pro_gallery_id'];
		$this->product_id->DbValue = $row['product_id'];
		$this->thumnail->Upload->DbValue = $row['thumnail'];
		$this->image->Upload->DbValue = $row['image'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("pro_gallery_id")) <> "")
			$this->pro_gallery_id->CurrentValue = $this->getKey("pro_gallery_id"); // pro_gallery_id
		else
			$bValidKey = FALSE;
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

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// pro_gallery_id
		// product_id
		// thumnail
		// image

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// pro_gallery_id
		$this->pro_gallery_id->ViewValue = $this->pro_gallery_id->CurrentValue;
		$this->pro_gallery_id->ViewCustomAttributes = "";

		// product_id
		if ($this->product_id->VirtualValue <> "") {
			$this->product_id->ViewValue = $this->product_id->VirtualValue;
		} else {
		if (strval($this->product_id->CurrentValue) <> "") {
			$sFilterWrk = "`product_id`" . ew_SearchString("=", $this->product_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT DISTINCT `product_id`, `pro_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `products`";
		$sWhereWrk = "";
		$this->product_id->LookupFilters = array("dx1" => '`pro_name`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->product_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->product_id->ViewValue = $this->product_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->product_id->ViewValue = $this->product_id->CurrentValue;
			}
		} else {
			$this->product_id->ViewValue = NULL;
		}
		}
		$this->product_id->ViewCustomAttributes = "";

		// thumnail
		$this->thumnail->UploadPath = "../uploads/product/thumnail";
		if (!ew_Empty($this->thumnail->Upload->DbValue)) {
			$this->thumnail->ImageWidth = 0;
			$this->thumnail->ImageHeight = 64;
			$this->thumnail->ImageAlt = $this->thumnail->FldAlt();
			$this->thumnail->ViewValue = $this->thumnail->Upload->DbValue;
		} else {
			$this->thumnail->ViewValue = "";
		}
		$this->thumnail->ViewCustomAttributes = "";

		// image
		$this->image->UploadPath = "../uploads/product";
		if (!ew_Empty($this->image->Upload->DbValue)) {
			$this->image->ImageWidth = 0;
			$this->image->ImageHeight = 94;
			$this->image->ImageAlt = $this->image->FldAlt();
			$this->image->ViewValue = $this->image->Upload->DbValue;
		} else {
			$this->image->ViewValue = "";
		}
		$this->image->ViewCustomAttributes = "";

			// pro_gallery_id
			$this->pro_gallery_id->LinkCustomAttributes = "";
			$this->pro_gallery_id->HrefValue = "";
			$this->pro_gallery_id->TooltipValue = "";

			// product_id
			$this->product_id->LinkCustomAttributes = "";
			$this->product_id->HrefValue = "";
			$this->product_id->TooltipValue = "";

			// thumnail
			$this->thumnail->LinkCustomAttributes = "";
			$this->thumnail->UploadPath = "../uploads/product/thumnail";
			if (!ew_Empty($this->thumnail->Upload->DbValue)) {
				$this->thumnail->HrefValue = ew_GetFileUploadUrl($this->thumnail, $this->thumnail->Upload->DbValue); // Add prefix/suffix
				$this->thumnail->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->thumnail->HrefValue = ew_FullUrl($this->thumnail->HrefValue, "href");
			} else {
				$this->thumnail->HrefValue = "";
			}
			$this->thumnail->HrefValue2 = $this->thumnail->UploadPath . $this->thumnail->Upload->DbValue;
			$this->thumnail->TooltipValue = "";
			if ($this->thumnail->UseColorbox) {
				if (ew_Empty($this->thumnail->TooltipValue))
					$this->thumnail->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->thumnail->LinkAttrs["data-rel"] = "product_gallery_x" . $this->RowCnt . "_thumnail";
				ew_AppendClass($this->thumnail->LinkAttrs["class"], "ewLightbox");
			}

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->UploadPath = "../uploads/product";
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->HrefValue = ew_GetFileUploadUrl($this->image, $this->image->Upload->DbValue); // Add prefix/suffix
				$this->image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->image->HrefValue = ew_FullUrl($this->image->HrefValue, "href");
			} else {
				$this->image->HrefValue = "";
			}
			$this->image->HrefValue2 = $this->image->UploadPath . $this->image->Upload->DbValue;
			$this->image->TooltipValue = "";
			if ($this->image->UseColorbox) {
				if (ew_Empty($this->image->TooltipValue))
					$this->image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->image->LinkAttrs["data-rel"] = "product_gallery_x" . $this->RowCnt . "_image";
				ew_AppendClass($this->image->LinkAttrs["class"], "ewLightbox");
			}
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// pro_gallery_id
			// product_id

			$this->product_id->EditCustomAttributes = "";
			if ($this->product_id->getSessionValue() <> "") {
				$this->product_id->CurrentValue = $this->product_id->getSessionValue();
				$this->product_id->OldValue = $this->product_id->CurrentValue;
			if ($this->product_id->VirtualValue <> "") {
				$this->product_id->ViewValue = $this->product_id->VirtualValue;
			} else {
			if (strval($this->product_id->CurrentValue) <> "") {
				$sFilterWrk = "`product_id`" . ew_SearchString("=", $this->product_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT DISTINCT `product_id`, `pro_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `products`";
			$sWhereWrk = "";
			$this->product_id->LookupFilters = array("dx1" => '`pro_name`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->product_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->product_id->ViewValue = $this->product_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->product_id->ViewValue = $this->product_id->CurrentValue;
				}
			} else {
				$this->product_id->ViewValue = NULL;
			}
			}
			$this->product_id->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->product_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`product_id`" . ew_SearchString("=", $this->product_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT DISTINCT `product_id`, `pro_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `products`";
			$sWhereWrk = "";
			$this->product_id->LookupFilters = array("dx1" => '`pro_name`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->product_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->product_id->ViewValue = $this->product_id->DisplayValue($arwrk);
			} else {
				$this->product_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->product_id->EditValue = $arwrk;
			}

			// thumnail
			$this->thumnail->EditAttrs["class"] = "form-control";
			$this->thumnail->EditCustomAttributes = "";
			$this->thumnail->UploadPath = "../uploads/product/thumnail";
			if (!ew_Empty($this->thumnail->Upload->DbValue)) {
				$this->thumnail->ImageWidth = 0;
				$this->thumnail->ImageHeight = 64;
				$this->thumnail->ImageAlt = $this->thumnail->FldAlt();
				$this->thumnail->EditValue = $this->thumnail->Upload->DbValue;
			} else {
				$this->thumnail->EditValue = "";
			}
			if (!ew_Empty($this->thumnail->CurrentValue))
					if ($this->RowIndex == '$rowindex$')
						$this->thumnail->Upload->FileName = "";
					else
						$this->thumnail->Upload->FileName = $this->thumnail->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->thumnail, $this->RowIndex);

			// image
			$this->image->EditAttrs["class"] = "form-control";
			$this->image->EditCustomAttributes = "";
			$this->image->UploadPath = "../uploads/product";
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->ImageWidth = 0;
				$this->image->ImageHeight = 94;
				$this->image->ImageAlt = $this->image->FldAlt();
				$this->image->EditValue = $this->image->Upload->DbValue;
			} else {
				$this->image->EditValue = "";
			}
			if (!ew_Empty($this->image->CurrentValue))
					if ($this->RowIndex == '$rowindex$')
						$this->image->Upload->FileName = "";
					else
						$this->image->Upload->FileName = $this->image->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->image, $this->RowIndex);

			// Add refer script
			// pro_gallery_id

			$this->pro_gallery_id->LinkCustomAttributes = "";
			$this->pro_gallery_id->HrefValue = "";

			// product_id
			$this->product_id->LinkCustomAttributes = "";
			$this->product_id->HrefValue = "";

			// thumnail
			$this->thumnail->LinkCustomAttributes = "";
			$this->thumnail->UploadPath = "../uploads/product/thumnail";
			if (!ew_Empty($this->thumnail->Upload->DbValue)) {
				$this->thumnail->HrefValue = ew_GetFileUploadUrl($this->thumnail, $this->thumnail->Upload->DbValue); // Add prefix/suffix
				$this->thumnail->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->thumnail->HrefValue = ew_FullUrl($this->thumnail->HrefValue, "href");
			} else {
				$this->thumnail->HrefValue = "";
			}
			$this->thumnail->HrefValue2 = $this->thumnail->UploadPath . $this->thumnail->Upload->DbValue;

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->UploadPath = "../uploads/product";
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->HrefValue = ew_GetFileUploadUrl($this->image, $this->image->Upload->DbValue); // Add prefix/suffix
				$this->image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->image->HrefValue = ew_FullUrl($this->image->HrefValue, "href");
			} else {
				$this->image->HrefValue = "";
			}
			$this->image->HrefValue2 = $this->image->UploadPath . $this->image->Upload->DbValue;
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// pro_gallery_id
			$this->pro_gallery_id->EditAttrs["class"] = "form-control";
			$this->pro_gallery_id->EditCustomAttributes = "";
			$this->pro_gallery_id->EditValue = $this->pro_gallery_id->CurrentValue;
			$this->pro_gallery_id->ViewCustomAttributes = "";

			// product_id
			$this->product_id->EditAttrs["class"] = "form-control";
			$this->product_id->EditCustomAttributes = "";
			if ($this->product_id->VirtualValue <> "") {
				$this->product_id->EditValue = $this->product_id->VirtualValue;
			} else {
			if (strval($this->product_id->CurrentValue) <> "") {
				$sFilterWrk = "`product_id`" . ew_SearchString("=", $this->product_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT DISTINCT `product_id`, `pro_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `products`";
			$sWhereWrk = "";
			$this->product_id->LookupFilters = array("dx1" => '`pro_name`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->product_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->product_id->EditValue = $this->product_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->product_id->EditValue = $this->product_id->CurrentValue;
				}
			} else {
				$this->product_id->EditValue = NULL;
			}
			}
			$this->product_id->ViewCustomAttributes = "";

			// thumnail
			$this->thumnail->EditAttrs["class"] = "form-control";
			$this->thumnail->EditCustomAttributes = "";
			$this->thumnail->UploadPath = "../uploads/product/thumnail";
			if (!ew_Empty($this->thumnail->Upload->DbValue)) {
				$this->thumnail->ImageWidth = 0;
				$this->thumnail->ImageHeight = 64;
				$this->thumnail->ImageAlt = $this->thumnail->FldAlt();
				$this->thumnail->EditValue = $this->thumnail->Upload->DbValue;
			} else {
				$this->thumnail->EditValue = "";
			}
			if (!ew_Empty($this->thumnail->CurrentValue))
					if ($this->RowIndex == '$rowindex$')
						$this->thumnail->Upload->FileName = "";
					else
						$this->thumnail->Upload->FileName = $this->thumnail->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->thumnail, $this->RowIndex);

			// image
			$this->image->EditAttrs["class"] = "form-control";
			$this->image->EditCustomAttributes = "";
			$this->image->UploadPath = "../uploads/product";
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->ImageWidth = 0;
				$this->image->ImageHeight = 94;
				$this->image->ImageAlt = $this->image->FldAlt();
				$this->image->EditValue = $this->image->Upload->DbValue;
			} else {
				$this->image->EditValue = "";
			}
			if (!ew_Empty($this->image->CurrentValue))
					if ($this->RowIndex == '$rowindex$')
						$this->image->Upload->FileName = "";
					else
						$this->image->Upload->FileName = $this->image->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->image, $this->RowIndex);

			// Edit refer script
			// pro_gallery_id

			$this->pro_gallery_id->LinkCustomAttributes = "";
			$this->pro_gallery_id->HrefValue = "";

			// product_id
			$this->product_id->LinkCustomAttributes = "";
			$this->product_id->HrefValue = "";

			// thumnail
			$this->thumnail->LinkCustomAttributes = "";
			$this->thumnail->UploadPath = "../uploads/product/thumnail";
			if (!ew_Empty($this->thumnail->Upload->DbValue)) {
				$this->thumnail->HrefValue = ew_GetFileUploadUrl($this->thumnail, $this->thumnail->Upload->DbValue); // Add prefix/suffix
				$this->thumnail->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->thumnail->HrefValue = ew_FullUrl($this->thumnail->HrefValue, "href");
			} else {
				$this->thumnail->HrefValue = "";
			}
			$this->thumnail->HrefValue2 = $this->thumnail->UploadPath . $this->thumnail->Upload->DbValue;

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->UploadPath = "../uploads/product";
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->HrefValue = ew_GetFileUploadUrl($this->image, $this->image->Upload->DbValue); // Add prefix/suffix
				$this->image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->image->HrefValue = ew_FullUrl($this->image->HrefValue, "href");
			} else {
				$this->image->HrefValue = "";
			}
			$this->image->HrefValue2 = $this->image->UploadPath . $this->image->Upload->DbValue;
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
		if (!$this->product_id->FldIsDetailKey && !is_null($this->product_id->FormValue) && $this->product_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->product_id->FldCaption(), $this->product_id->ReqErrMsg));
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
				$sThisKey .= $row['pro_gallery_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['product_id'];

				// Delete old files
				$this->LoadDbValues($row);
				$this->thumnail->OldUploadPath = "../uploads/product/thumnail";
				$OldFiles = ew_Empty($row['thumnail']) ? array() : array($row['thumnail']);
				$OldFileCount = count($OldFiles);
				for ($i = 0; $i < $OldFileCount; $i++) {
					if (file_exists($this->thumnail->OldPhysicalUploadPath() . $OldFiles[$i]))
						@unlink($this->thumnail->OldPhysicalUploadPath() . $OldFiles[$i]);
				}
				$this->image->OldUploadPath = "../uploads/product";
				$OldFiles = ew_Empty($row['image']) ? array() : array($row['image']);
				$OldFileCount = count($OldFiles);
				for ($i = 0; $i < $OldFileCount; $i++) {
					if (file_exists($this->image->OldPhysicalUploadPath() . $OldFiles[$i]))
						@unlink($this->image->OldPhysicalUploadPath() . $OldFiles[$i]);
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
			$this->thumnail->OldUploadPath = "../uploads/product/thumnail";
			$this->thumnail->UploadPath = $this->thumnail->OldUploadPath;
			$this->image->OldUploadPath = "../uploads/product";
			$this->image->UploadPath = $this->image->OldUploadPath;
			$rsnew = array();

			// product_id
			// thumnail

			if ($this->thumnail->Visible && !$this->thumnail->ReadOnly && !$this->thumnail->Upload->KeepFile) {
				$this->thumnail->Upload->DbValue = $rsold['thumnail']; // Get original value
				if ($this->thumnail->Upload->FileName == "") {
					$rsnew['thumnail'] = NULL;
				} else {
					$rsnew['thumnail'] = $this->thumnail->Upload->FileName;
				}
				$this->thumnail->ImageWidth = 107; // Resize width
				$this->thumnail->ImageHeight = 105; // Resize height
			}

			// image
			if ($this->image->Visible && !$this->image->ReadOnly && !$this->image->Upload->KeepFile) {
				$this->image->Upload->DbValue = $rsold['image']; // Get original value
				if ($this->image->Upload->FileName == "") {
					$rsnew['image'] = NULL;
				} else {
					$rsnew['image'] = $this->image->Upload->FileName;
				}
				$this->image->ImageWidth = 875; // Resize width
				$this->image->ImageHeight = 665; // Resize height
			}

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

			// Check referential integrity for master table 'products'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_products();
			$KeyValue = isset($rsnew['product_id']) ? $rsnew['product_id'] : $rsold['product_id'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@product_id@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				if (!isset($GLOBALS["products"])) $GLOBALS["products"] = new cproducts();
				$rsmaster = $GLOBALS["products"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "products", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}
			if ($this->thumnail->Visible && !$this->thumnail->Upload->KeepFile) {
				$this->thumnail->UploadPath = "../uploads/product/thumnail";
				$OldFiles = ew_Empty($this->thumnail->Upload->DbValue) ? array() : array($this->thumnail->Upload->DbValue);
				if (!ew_Empty($this->thumnail->Upload->FileName)) {
					$NewFiles = array($this->thumnail->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->thumnail->Upload->Index < 0) ? $this->thumnail->FldVar : substr($this->thumnail->FldVar, 0, 1) . $this->thumnail->Upload->Index . substr($this->thumnail->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->thumnail->TblVar) . $file)) {
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
								$file1 = ew_UploadFileNameEx($this->thumnail->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->thumnail->TblVar) . $file1) || file_exists($this->thumnail->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->thumnail->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->thumnail->TblVar) . $file, ew_UploadTempPath($fldvar, $this->thumnail->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->thumnail->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->thumnail->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->thumnail->SetDbValueDef($rsnew, $this->thumnail->Upload->FileName, NULL, $this->thumnail->ReadOnly);
				}
			}
			if ($this->image->Visible && !$this->image->Upload->KeepFile) {
				$this->image->UploadPath = "../uploads/product";
				$OldFiles = ew_Empty($this->image->Upload->DbValue) ? array() : array($this->image->Upload->DbValue);
				if (!ew_Empty($this->image->Upload->FileName)) {
					$NewFiles = array($this->image->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->image->Upload->Index < 0) ? $this->image->FldVar : substr($this->image->FldVar, 0, 1) . $this->image->Upload->Index . substr($this->image->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file)) {
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
								$file1 = ew_UploadFileNameEx($this->image->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file1) || file_exists($this->image->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->image->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file, ew_UploadTempPath($fldvar, $this->image->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->image->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->image->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->image->SetDbValueDef($rsnew, $this->image->Upload->FileName, NULL, $this->image->ReadOnly);
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
					if ($this->thumnail->Visible && !$this->thumnail->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->thumnail->Upload->DbValue) ? array() : array($this->thumnail->Upload->DbValue);
						if (!ew_Empty($this->thumnail->Upload->FileName)) {
							$NewFiles = array($this->thumnail->Upload->FileName);
							$NewFiles2 = array($rsnew['thumnail']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->thumnail->Upload->Index < 0) ? $this->thumnail->FldVar : substr($this->thumnail->FldVar, 0, 1) . $this->thumnail->Upload->Index . substr($this->thumnail->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->thumnail->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->thumnail->Upload->ResizeAndSaveToFile($this->thumnail->ImageWidth, $this->thumnail->ImageHeight, EW_THUMBNAIL_DEFAULT_QUALITY, $NewFiles[$i], TRUE, $i)) {
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
								@unlink($this->thumnail->OldPhysicalUploadPath() . $OldFiles[$i]);
						}
					}
					if ($this->image->Visible && !$this->image->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->image->Upload->DbValue) ? array() : array($this->image->Upload->DbValue);
						if (!ew_Empty($this->image->Upload->FileName)) {
							$NewFiles = array($this->image->Upload->FileName);
							$NewFiles2 = array($rsnew['image']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->image->Upload->Index < 0) ? $this->image->FldVar : substr($this->image->FldVar, 0, 1) . $this->image->Upload->Index . substr($this->image->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->image->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->image->Upload->ResizeAndSaveToFile($this->image->ImageWidth, $this->image->ImageHeight, EW_THUMBNAIL_DEFAULT_QUALITY, $NewFiles[$i], TRUE, $i)) {
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
								@unlink($this->image->OldPhysicalUploadPath() . $OldFiles[$i]);
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

		// thumnail
		ew_CleanUploadTempPath($this->thumnail, $this->thumnail->Upload->Index);

		// image
		ew_CleanUploadTempPath($this->image, $this->image->Upload->Index);
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
		$sHash .= ew_GetFldHash($rs->fields('product_id')); // product_id
		$sHash .= ew_GetFldHash($rs->fields('thumnail')); // thumnail
		$sHash .= ew_GetFldHash($rs->fields('image')); // image
		return md5($sHash);
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;

		// Check referential integrity for master table 'products'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_products();
		if (strval($this->product_id->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@product_id@", ew_AdjustSql($this->product_id->CurrentValue, "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["products"])) $GLOBALS["products"] = new cproducts();
			$rsmaster = $GLOBALS["products"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "products", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
			$this->thumnail->OldUploadPath = "../uploads/product/thumnail";
			$this->thumnail->UploadPath = $this->thumnail->OldUploadPath;
			$this->image->OldUploadPath = "../uploads/product";
			$this->image->UploadPath = $this->image->OldUploadPath;
		}
		$rsnew = array();

		// product_id
		$this->product_id->SetDbValueDef($rsnew, $this->product_id->CurrentValue, 0, FALSE);

		// thumnail
		if ($this->thumnail->Visible && !$this->thumnail->Upload->KeepFile) {
			$this->thumnail->Upload->DbValue = ""; // No need to delete old file
			if ($this->thumnail->Upload->FileName == "") {
				$rsnew['thumnail'] = NULL;
			} else {
				$rsnew['thumnail'] = $this->thumnail->Upload->FileName;
			}
			$this->thumnail->ImageWidth = 107; // Resize width
			$this->thumnail->ImageHeight = 105; // Resize height
		}

		// image
		if ($this->image->Visible && !$this->image->Upload->KeepFile) {
			$this->image->Upload->DbValue = ""; // No need to delete old file
			if ($this->image->Upload->FileName == "") {
				$rsnew['image'] = NULL;
			} else {
				$rsnew['image'] = $this->image->Upload->FileName;
			}
			$this->image->ImageWidth = 875; // Resize width
			$this->image->ImageHeight = 665; // Resize height
		}
		if ($this->thumnail->Visible && !$this->thumnail->Upload->KeepFile) {
			$this->thumnail->UploadPath = "../uploads/product/thumnail";
			$OldFiles = ew_Empty($this->thumnail->Upload->DbValue) ? array() : array($this->thumnail->Upload->DbValue);
			if (!ew_Empty($this->thumnail->Upload->FileName)) {
				$NewFiles = array($this->thumnail->Upload->FileName);
				$NewFileCount = count($NewFiles);
				for ($i = 0; $i < $NewFileCount; $i++) {
					$fldvar = ($this->thumnail->Upload->Index < 0) ? $this->thumnail->FldVar : substr($this->thumnail->FldVar, 0, 1) . $this->thumnail->Upload->Index . substr($this->thumnail->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->thumnail->TblVar) . $file)) {
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
							$file1 = ew_UploadFileNameEx($this->thumnail->PhysicalUploadPath(), $file); // Get new file name
							if ($file1 <> $file) { // Rename temp file
								while (file_exists(ew_UploadTempPath($fldvar, $this->thumnail->TblVar) . $file1) || file_exists($this->thumnail->PhysicalUploadPath() . $file1)) // Make sure no file name clash
									$file1 = ew_UniqueFilename($this->thumnail->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
								rename(ew_UploadTempPath($fldvar, $this->thumnail->TblVar) . $file, ew_UploadTempPath($fldvar, $this->thumnail->TblVar) . $file1);
								$NewFiles[$i] = $file1;
							}
						}
					}
				}
				$this->thumnail->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
				$this->thumnail->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$this->thumnail->SetDbValueDef($rsnew, $this->thumnail->Upload->FileName, NULL, FALSE);
			}
		}
		if ($this->image->Visible && !$this->image->Upload->KeepFile) {
			$this->image->UploadPath = "../uploads/product";
			$OldFiles = ew_Empty($this->image->Upload->DbValue) ? array() : array($this->image->Upload->DbValue);
			if (!ew_Empty($this->image->Upload->FileName)) {
				$NewFiles = array($this->image->Upload->FileName);
				$NewFileCount = count($NewFiles);
				for ($i = 0; $i < $NewFileCount; $i++) {
					$fldvar = ($this->image->Upload->Index < 0) ? $this->image->FldVar : substr($this->image->FldVar, 0, 1) . $this->image->Upload->Index . substr($this->image->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file)) {
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
							$file1 = ew_UploadFileNameEx($this->image->PhysicalUploadPath(), $file); // Get new file name
							if ($file1 <> $file) { // Rename temp file
								while (file_exists(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file1) || file_exists($this->image->PhysicalUploadPath() . $file1)) // Make sure no file name clash
									$file1 = ew_UniqueFilename($this->image->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
								rename(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file, ew_UploadTempPath($fldvar, $this->image->TblVar) . $file1);
								$NewFiles[$i] = $file1;
							}
						}
					}
				}
				$this->image->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
				$this->image->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$this->image->SetDbValueDef($rsnew, $this->image->Upload->FileName, NULL, FALSE);
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['product_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if ($this->thumnail->Visible && !$this->thumnail->Upload->KeepFile) {
					$OldFiles = ew_Empty($this->thumnail->Upload->DbValue) ? array() : array($this->thumnail->Upload->DbValue);
					if (!ew_Empty($this->thumnail->Upload->FileName)) {
						$NewFiles = array($this->thumnail->Upload->FileName);
						$NewFiles2 = array($rsnew['thumnail']);
						$NewFileCount = count($NewFiles);
						for ($i = 0; $i < $NewFileCount; $i++) {
							$fldvar = ($this->thumnail->Upload->Index < 0) ? $this->thumnail->FldVar : substr($this->thumnail->FldVar, 0, 1) . $this->thumnail->Upload->Index . substr($this->thumnail->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->thumnail->TblVar) . $NewFiles[$i];
								if (file_exists($file)) {
									if (@$NewFiles2[$i] <> "") // Use correct file name
										$NewFiles[$i] = $NewFiles2[$i];
									if (!$this->thumnail->Upload->ResizeAndSaveToFile($this->thumnail->ImageWidth, $this->thumnail->ImageHeight, EW_THUMBNAIL_DEFAULT_QUALITY, $NewFiles[$i], TRUE, $i)) {
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
							@unlink($this->thumnail->OldPhysicalUploadPath() . $OldFiles[$i]);
					}
				}
				if ($this->image->Visible && !$this->image->Upload->KeepFile) {
					$OldFiles = ew_Empty($this->image->Upload->DbValue) ? array() : array($this->image->Upload->DbValue);
					if (!ew_Empty($this->image->Upload->FileName)) {
						$NewFiles = array($this->image->Upload->FileName);
						$NewFiles2 = array($rsnew['image']);
						$NewFileCount = count($NewFiles);
						for ($i = 0; $i < $NewFileCount; $i++) {
							$fldvar = ($this->image->Upload->Index < 0) ? $this->image->FldVar : substr($this->image->FldVar, 0, 1) . $this->image->Upload->Index . substr($this->image->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->image->TblVar) . $NewFiles[$i];
								if (file_exists($file)) {
									if (@$NewFiles2[$i] <> "") // Use correct file name
										$NewFiles[$i] = $NewFiles2[$i];
									if (!$this->image->Upload->ResizeAndSaveToFile($this->image->ImageWidth, $this->image->ImageHeight, EW_THUMBNAIL_DEFAULT_QUALITY, $NewFiles[$i], TRUE, $i)) {
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
							@unlink($this->image->OldPhysicalUploadPath() . $OldFiles[$i]);
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

		// thumnail
		ew_CleanUploadTempPath($this->thumnail, $this->thumnail->Upload->Index);

		// image
		ew_CleanUploadTempPath($this->image, $this->image->Upload->Index);
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
		$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.fproduct_gallerylist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.fproduct_gallerylist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.fproduct_gallerylist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.fproduct_gallerylist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.fproduct_gallerylist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.fproduct_gallerylist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.fproduct_gallerylist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_product_gallery\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_product_gallery',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fproduct_gallerylist,sel:true" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "products") {
			global $products;
			if (!isset($products)) $products = new cproducts;
			$rsmaster = $products->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$products;
					$products->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
					$Doc->Table = &$this;
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
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

	// Set up master/detail based on QueryString
	function SetupMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "products") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_product_id"] <> "") {
					$GLOBALS["products"]->product_id->setQueryStringValue($_GET["fk_product_id"]);
					$this->product_id->setQueryStringValue($GLOBALS["products"]->product_id->QueryStringValue);
					$this->product_id->setSessionValue($this->product_id->QueryStringValue);
					if (!is_numeric($GLOBALS["products"]->product_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "products") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_product_id"] <> "") {
					$GLOBALS["products"]->product_id->setFormValue($_POST["fk_product_id"]);
					$this->product_id->setFormValue($GLOBALS["products"]->product_id->FormValue);
					$this->product_id->setSessionValue($this->product_id->FormValue);
					if (!is_numeric($GLOBALS["products"]->product_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			if (!$this->IsAddOrEdit()) {
				$this->StartRec = 1;
				$this->setStartRecordNumber($this->StartRec);
			}

			// Clear previous master key from Session
			if ($sMasterTblVar <> "products") {
				if ($this->product_id->CurrentValue == "") $this->product_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
		case "x_product_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT DISTINCT `product_id` AS `LinkFld`, `pro_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `products`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`pro_name`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`product_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->product_id, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($product_gallery_list)) $product_gallery_list = new cproduct_gallery_list();

// Page init
$product_gallery_list->Page_Init();

// Page main
$product_gallery_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$product_gallery_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($product_gallery->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fproduct_gallerylist = new ew_Form("fproduct_gallerylist", "list");
fproduct_gallerylist.FormKeyCountName = '<?php echo $product_gallery_list->FormKeyCountName ?>';

// Validate form
fproduct_gallerylist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_product_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $product_gallery->product_id->FldCaption(), $product_gallery->product_id->ReqErrMsg)) ?>");

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
fproduct_gallerylist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "product_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "thumnail", false)) return false;
	if (ew_ValueChanged(fobj, infix, "image", false)) return false;
	return true;
}

// Form_CustomValidate event
fproduct_gallerylist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fproduct_gallerylist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fproduct_gallerylist.Lists["x_product_id"] = {"LinkField":"x_product_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_pro_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"products"};
fproduct_gallerylist.Lists["x_product_id"].Data = "<?php echo $product_gallery_list->product_id->LookupFilterQuery(FALSE, "list") ?>";

// Form object for search
var CurrentSearchForm = fproduct_gallerylistsrch = new ew_Form("fproduct_gallerylistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($product_gallery->Export == "") { ?>
<div class="ewToolbar">
<?php if ($product_gallery_list->TotalRecs > 0 && $product_gallery_list->ExportOptions->Visible()) { ?>
<?php $product_gallery_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($product_gallery_list->SearchOptions->Visible()) { ?>
<?php $product_gallery_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($product_gallery_list->FilterOptions->Visible()) { ?>
<?php $product_gallery_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($product_gallery->Export == "") || (EW_EXPORT_MASTER_RECORD && $product_gallery->Export == "print")) { ?>
<?php
if ($product_gallery_list->DbMasterFilter <> "" && $product_gallery->getCurrentMasterTable() == "products") {
	if ($product_gallery_list->MasterRecordExists) {
?>
<?php include_once "productsmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($product_gallery->CurrentAction == "gridadd") {
	$product_gallery->CurrentFilter = "0=1";
	$product_gallery_list->StartRec = 1;
	$product_gallery_list->DisplayRecs = $product_gallery->GridAddRowCount;
	$product_gallery_list->TotalRecs = $product_gallery_list->DisplayRecs;
	$product_gallery_list->StopRec = $product_gallery_list->DisplayRecs;
} else {
	$bSelectLimit = $product_gallery_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($product_gallery_list->TotalRecs <= 0)
			$product_gallery_list->TotalRecs = $product_gallery->ListRecordCount();
	} else {
		if (!$product_gallery_list->Recordset && ($product_gallery_list->Recordset = $product_gallery_list->LoadRecordset()))
			$product_gallery_list->TotalRecs = $product_gallery_list->Recordset->RecordCount();
	}
	$product_gallery_list->StartRec = 1;
	if ($product_gallery_list->DisplayRecs <= 0 || ($product_gallery->Export <> "" && $product_gallery->ExportAll)) // Display all records
		$product_gallery_list->DisplayRecs = $product_gallery_list->TotalRecs;
	if (!($product_gallery->Export <> "" && $product_gallery->ExportAll))
		$product_gallery_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$product_gallery_list->Recordset = $product_gallery_list->LoadRecordset($product_gallery_list->StartRec-1, $product_gallery_list->DisplayRecs);

	// Set no record found message
	if ($product_gallery->CurrentAction == "" && $product_gallery_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$product_gallery_list->setWarningMessage(ew_DeniedMsg());
		if ($product_gallery_list->SearchWhere == "0=101")
			$product_gallery_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$product_gallery_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$product_gallery_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($product_gallery->Export == "" && $product_gallery->CurrentAction == "") { ?>
<form name="fproduct_gallerylistsrch" id="fproduct_gallerylistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($product_gallery_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fproduct_gallerylistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="product_gallery">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($product_gallery_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($product_gallery_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $product_gallery_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($product_gallery_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($product_gallery_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($product_gallery_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($product_gallery_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $product_gallery_list->ShowPageHeader(); ?>
<?php
$product_gallery_list->ShowMessage();
?>
<?php if ($product_gallery_list->TotalRecs > 0 || $product_gallery->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($product_gallery_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> product_gallery">
<?php if ($product_gallery->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($product_gallery->CurrentAction <> "gridadd" && $product_gallery->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($product_gallery_list->Pager)) $product_gallery_list->Pager = new cPrevNextPager($product_gallery_list->StartRec, $product_gallery_list->DisplayRecs, $product_gallery_list->TotalRecs, $product_gallery_list->AutoHidePager) ?>
<?php if ($product_gallery_list->Pager->RecordCount > 0 && $product_gallery_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($product_gallery_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $product_gallery_list->PageUrl() ?>start=<?php echo $product_gallery_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($product_gallery_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $product_gallery_list->PageUrl() ?>start=<?php echo $product_gallery_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $product_gallery_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($product_gallery_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $product_gallery_list->PageUrl() ?>start=<?php echo $product_gallery_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($product_gallery_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $product_gallery_list->PageUrl() ?>start=<?php echo $product_gallery_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $product_gallery_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($product_gallery_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $product_gallery_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $product_gallery_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $product_gallery_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($product_gallery_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fproduct_gallerylist" id="fproduct_gallerylist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($product_gallery_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $product_gallery_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="product_gallery">
<input type="hidden" name="exporttype" id="exporttype" value="">
<?php if ($product_gallery->getCurrentMasterTable() == "products" && $product_gallery->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="products">
<input type="hidden" name="fk_product_id" value="<?php echo $product_gallery->product_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_product_gallery" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($product_gallery_list->TotalRecs > 0 || $product_gallery->CurrentAction == "add" || $product_gallery->CurrentAction == "copy" || $product_gallery->CurrentAction == "gridedit") { ?>
<table id="tbl_product_gallerylist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$product_gallery_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$product_gallery_list->RenderListOptions();

// Render list options (header, left)
$product_gallery_list->ListOptions->Render("header", "left");
?>
<?php if ($product_gallery->pro_gallery_id->Visible) { // pro_gallery_id ?>
	<?php if ($product_gallery->SortUrl($product_gallery->pro_gallery_id) == "") { ?>
		<th data-name="pro_gallery_id" class="<?php echo $product_gallery->pro_gallery_id->HeaderCellClass() ?>"><div id="elh_product_gallery_pro_gallery_id" class="product_gallery_pro_gallery_id"><div class="ewTableHeaderCaption"><?php echo $product_gallery->pro_gallery_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_gallery_id" class="<?php echo $product_gallery->pro_gallery_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $product_gallery->SortUrl($product_gallery->pro_gallery_id) ?>',2);"><div id="elh_product_gallery_pro_gallery_id" class="product_gallery_pro_gallery_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $product_gallery->pro_gallery_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($product_gallery->pro_gallery_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($product_gallery->pro_gallery_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($product_gallery->product_id->Visible) { // product_id ?>
	<?php if ($product_gallery->SortUrl($product_gallery->product_id) == "") { ?>
		<th data-name="product_id" class="<?php echo $product_gallery->product_id->HeaderCellClass() ?>"><div id="elh_product_gallery_product_id" class="product_gallery_product_id"><div class="ewTableHeaderCaption"><?php echo $product_gallery->product_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="product_id" class="<?php echo $product_gallery->product_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $product_gallery->SortUrl($product_gallery->product_id) ?>',2);"><div id="elh_product_gallery_product_id" class="product_gallery_product_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $product_gallery->product_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($product_gallery->product_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($product_gallery->product_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($product_gallery->thumnail->Visible) { // thumnail ?>
	<?php if ($product_gallery->SortUrl($product_gallery->thumnail) == "") { ?>
		<th data-name="thumnail" class="<?php echo $product_gallery->thumnail->HeaderCellClass() ?>"><div id="elh_product_gallery_thumnail" class="product_gallery_thumnail"><div class="ewTableHeaderCaption"><?php echo $product_gallery->thumnail->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="thumnail" class="<?php echo $product_gallery->thumnail->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $product_gallery->SortUrl($product_gallery->thumnail) ?>',2);"><div id="elh_product_gallery_thumnail" class="product_gallery_thumnail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $product_gallery->thumnail->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($product_gallery->thumnail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($product_gallery->thumnail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($product_gallery->image->Visible) { // image ?>
	<?php if ($product_gallery->SortUrl($product_gallery->image) == "") { ?>
		<th data-name="image" class="<?php echo $product_gallery->image->HeaderCellClass() ?>"><div id="elh_product_gallery_image" class="product_gallery_image"><div class="ewTableHeaderCaption"><?php echo $product_gallery->image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="image" class="<?php echo $product_gallery->image->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $product_gallery->SortUrl($product_gallery->image) ?>',2);"><div id="elh_product_gallery_image" class="product_gallery_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $product_gallery->image->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($product_gallery->image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($product_gallery->image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$product_gallery_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($product_gallery->CurrentAction == "add" || $product_gallery->CurrentAction == "copy") {
		$product_gallery_list->RowIndex = 0;
		$product_gallery_list->KeyCount = $product_gallery_list->RowIndex;
		if ($product_gallery->CurrentAction == "add")
			$product_gallery_list->LoadRowValues();
		if ($product_gallery->EventCancelled) // Insert failed
			$product_gallery_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$product_gallery->ResetAttrs();
		$product_gallery->RowAttrs = array_merge($product_gallery->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_product_gallery', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$product_gallery->RowType = EW_ROWTYPE_ADD;

		// Render row
		$product_gallery_list->RenderRow();

		// Render list options
		$product_gallery_list->RenderListOptions();
		$product_gallery_list->StartRowCnt = 0;
?>
	<tr<?php echo $product_gallery->RowAttributes() ?>>
<?php

// Render list options (body, left)
$product_gallery_list->ListOptions->Render("body", "left", $product_gallery_list->RowCnt);
?>
	<?php if ($product_gallery->pro_gallery_id->Visible) { // pro_gallery_id ?>
		<td data-name="pro_gallery_id">
<input type="hidden" data-table="product_gallery" data-field="x_pro_gallery_id" name="o<?php echo $product_gallery_list->RowIndex ?>_pro_gallery_id" id="o<?php echo $product_gallery_list->RowIndex ?>_pro_gallery_id" value="<?php echo ew_HtmlEncode($product_gallery->pro_gallery_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($product_gallery->product_id->Visible) { // product_id ?>
		<td data-name="product_id">
<?php if ($product_gallery->product_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_product_id" class="form-group product_gallery_product_id">
<span<?php echo $product_gallery->product_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->product_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $product_gallery_list->RowIndex ?>_product_id" name="x<?php echo $product_gallery_list->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_product_id" class="form-group product_gallery_product_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $product_gallery_list->RowIndex ?>_product_id"><?php echo (strval($product_gallery->product_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $product_gallery->product_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($product_gallery->product_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $product_gallery_list->RowIndex ?>_product_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($product_gallery->product_id->ReadOnly || $product_gallery->product_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $product_gallery->product_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $product_gallery_list->RowIndex ?>_product_id" id="x<?php echo $product_gallery_list->RowIndex ?>_product_id" value="<?php echo $product_gallery->product_id->CurrentValue ?>"<?php echo $product_gallery->product_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $product_gallery->product_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $product_gallery_list->RowIndex ?>_product_id',url:'productsaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $product_gallery_list->RowIndex ?>_product_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $product_gallery->product_id->FldCaption() ?></span></button>
</span>
<?php } ?>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="o<?php echo $product_gallery_list->RowIndex ?>_product_id" id="o<?php echo $product_gallery_list->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($product_gallery->thumnail->Visible) { // thumnail ?>
		<td data-name="thumnail">
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_thumnail" class="form-group product_gallery_thumnail">
<div id="fd_x<?php echo $product_gallery_list->RowIndex ?>_thumnail">
<span title="<?php echo $product_gallery->thumnail->FldTitle() ? $product_gallery->thumnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->thumnail->ReadOnly || $product_gallery->thumnail->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_thumnail" name="x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id="x<?php echo $product_gallery_list->RowIndex ?>_thumnail"<?php echo $product_gallery->thumnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fn_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fa_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="0">
<input type="hidden" name="fs_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fs_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fx_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fm_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_thumnail" name="o<?php echo $product_gallery_list->RowIndex ?>_thumnail" id="o<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo ew_HtmlEncode($product_gallery->thumnail->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($product_gallery->image->Visible) { // image ?>
		<td data-name="image">
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_image" class="form-group product_gallery_image">
<div id="fd_x<?php echo $product_gallery_list->RowIndex ?>_image">
<span title="<?php echo $product_gallery->image->FldTitle() ? $product_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->image->ReadOnly || $product_gallery->image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_image" name="x<?php echo $product_gallery_list->RowIndex ?>_image" id="x<?php echo $product_gallery_list->RowIndex ?>_image"<?php echo $product_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fn_x<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo $product_gallery->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fa_x<?php echo $product_gallery_list->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fs_x<?php echo $product_gallery_list->RowIndex ?>_image" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fx_x<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fm_x<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_list->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_image" name="o<?php echo $product_gallery_list->RowIndex ?>_image" id="o<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($product_gallery->image->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$product_gallery_list->ListOptions->Render("body", "right", $product_gallery_list->RowCnt);
?>
<script type="text/javascript">
fproduct_gallerylist.UpdateOpts(<?php echo $product_gallery_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($product_gallery->ExportAll && $product_gallery->Export <> "") {
	$product_gallery_list->StopRec = $product_gallery_list->TotalRecs;
} else {

	// Set the last record to display
	if ($product_gallery_list->TotalRecs > $product_gallery_list->StartRec + $product_gallery_list->DisplayRecs - 1)
		$product_gallery_list->StopRec = $product_gallery_list->StartRec + $product_gallery_list->DisplayRecs - 1;
	else
		$product_gallery_list->StopRec = $product_gallery_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($product_gallery_list->FormKeyCountName) && ($product_gallery->CurrentAction == "gridadd" || $product_gallery->CurrentAction == "gridedit" || $product_gallery->CurrentAction == "F")) {
		$product_gallery_list->KeyCount = $objForm->GetValue($product_gallery_list->FormKeyCountName);
		$product_gallery_list->StopRec = $product_gallery_list->StartRec + $product_gallery_list->KeyCount - 1;
	}
}
$product_gallery_list->RecCnt = $product_gallery_list->StartRec - 1;
if ($product_gallery_list->Recordset && !$product_gallery_list->Recordset->EOF) {
	$product_gallery_list->Recordset->MoveFirst();
	$bSelectLimit = $product_gallery_list->UseSelectLimit;
	if (!$bSelectLimit && $product_gallery_list->StartRec > 1)
		$product_gallery_list->Recordset->Move($product_gallery_list->StartRec - 1);
} elseif (!$product_gallery->AllowAddDeleteRow && $product_gallery_list->StopRec == 0) {
	$product_gallery_list->StopRec = $product_gallery->GridAddRowCount;
}

// Initialize aggregate
$product_gallery->RowType = EW_ROWTYPE_AGGREGATEINIT;
$product_gallery->ResetAttrs();
$product_gallery_list->RenderRow();
$product_gallery_list->EditRowCnt = 0;
if ($product_gallery->CurrentAction == "edit")
	$product_gallery_list->RowIndex = 1;
if ($product_gallery->CurrentAction == "gridadd")
	$product_gallery_list->RowIndex = 0;
if ($product_gallery->CurrentAction == "gridedit")
	$product_gallery_list->RowIndex = 0;
while ($product_gallery_list->RecCnt < $product_gallery_list->StopRec) {
	$product_gallery_list->RecCnt++;
	if (intval($product_gallery_list->RecCnt) >= intval($product_gallery_list->StartRec)) {
		$product_gallery_list->RowCnt++;
		if ($product_gallery->CurrentAction == "gridadd" || $product_gallery->CurrentAction == "gridedit" || $product_gallery->CurrentAction == "F") {
			$product_gallery_list->RowIndex++;
			$objForm->Index = $product_gallery_list->RowIndex;
			if ($objForm->HasValue($product_gallery_list->FormActionName))
				$product_gallery_list->RowAction = strval($objForm->GetValue($product_gallery_list->FormActionName));
			elseif ($product_gallery->CurrentAction == "gridadd")
				$product_gallery_list->RowAction = "insert";
			else
				$product_gallery_list->RowAction = "";
		}

		// Set up key count
		$product_gallery_list->KeyCount = $product_gallery_list->RowIndex;

		// Init row class and style
		$product_gallery->ResetAttrs();
		$product_gallery->CssClass = "";
		if ($product_gallery->CurrentAction == "gridadd") {
			$product_gallery_list->LoadRowValues(); // Load default values
		} else {
			$product_gallery_list->LoadRowValues($product_gallery_list->Recordset); // Load row values
		}
		$product_gallery->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($product_gallery->CurrentAction == "gridadd") // Grid add
			$product_gallery->RowType = EW_ROWTYPE_ADD; // Render add
		if ($product_gallery->CurrentAction == "gridadd" && $product_gallery->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$product_gallery_list->RestoreCurrentRowFormValues($product_gallery_list->RowIndex); // Restore form values
		if ($product_gallery->CurrentAction == "edit") {
			if ($product_gallery_list->CheckInlineEditKey() && $product_gallery_list->EditRowCnt == 0) { // Inline edit
				$product_gallery->RowType = EW_ROWTYPE_EDIT; // Render edit
				if (!$product_gallery->EventCancelled)
					$product_gallery_list->HashValue = $product_gallery_list->GetRowHash($product_gallery_list->Recordset); // Get hash value for record
			}
		}
		if ($product_gallery->CurrentAction == "gridedit") { // Grid edit
			if ($product_gallery->EventCancelled) {
				$product_gallery_list->RestoreCurrentRowFormValues($product_gallery_list->RowIndex); // Restore form values
			}
			if ($product_gallery_list->RowAction == "insert")
				$product_gallery->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$product_gallery->RowType = EW_ROWTYPE_EDIT; // Render edit
			if (!$product_gallery->EventCancelled)
				$product_gallery_list->HashValue = $product_gallery_list->GetRowHash($product_gallery_list->Recordset); // Get hash value for record
		}
		if ($product_gallery->CurrentAction == "edit" && $product_gallery->RowType == EW_ROWTYPE_EDIT && $product_gallery->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$product_gallery_list->RestoreFormValues(); // Restore form values
		}
		if ($product_gallery->CurrentAction == "gridedit" && ($product_gallery->RowType == EW_ROWTYPE_EDIT || $product_gallery->RowType == EW_ROWTYPE_ADD) && $product_gallery->EventCancelled) // Update failed
			$product_gallery_list->RestoreCurrentRowFormValues($product_gallery_list->RowIndex); // Restore form values
		if ($product_gallery->RowType == EW_ROWTYPE_EDIT) // Edit row
			$product_gallery_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$product_gallery->RowAttrs = array_merge($product_gallery->RowAttrs, array('data-rowindex'=>$product_gallery_list->RowCnt, 'id'=>'r' . $product_gallery_list->RowCnt . '_product_gallery', 'data-rowtype'=>$product_gallery->RowType));

		// Render row
		$product_gallery_list->RenderRow();

		// Render list options
		$product_gallery_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($product_gallery_list->RowAction <> "delete" && $product_gallery_list->RowAction <> "insertdelete" && !($product_gallery_list->RowAction == "insert" && $product_gallery->CurrentAction == "F" && $product_gallery_list->EmptyRow())) {
?>
	<tr<?php echo $product_gallery->RowAttributes() ?>>
<?php

// Render list options (body, left)
$product_gallery_list->ListOptions->Render("body", "left", $product_gallery_list->RowCnt);
?>
	<?php if ($product_gallery->pro_gallery_id->Visible) { // pro_gallery_id ?>
		<td data-name="pro_gallery_id"<?php echo $product_gallery->pro_gallery_id->CellAttributes() ?>>
<?php if ($product_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="product_gallery" data-field="x_pro_gallery_id" name="o<?php echo $product_gallery_list->RowIndex ?>_pro_gallery_id" id="o<?php echo $product_gallery_list->RowIndex ?>_pro_gallery_id" value="<?php echo ew_HtmlEncode($product_gallery->pro_gallery_id->OldValue) ?>">
<?php } ?>
<?php if ($product_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_pro_gallery_id" class="form-group product_gallery_pro_gallery_id">
<span<?php echo $product_gallery->pro_gallery_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->pro_gallery_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_pro_gallery_id" name="x<?php echo $product_gallery_list->RowIndex ?>_pro_gallery_id" id="x<?php echo $product_gallery_list->RowIndex ?>_pro_gallery_id" value="<?php echo ew_HtmlEncode($product_gallery->pro_gallery_id->CurrentValue) ?>">
<?php } ?>
<?php if ($product_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_pro_gallery_id" class="product_gallery_pro_gallery_id">
<span<?php echo $product_gallery->pro_gallery_id->ViewAttributes() ?>>
<?php echo $product_gallery->pro_gallery_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($product_gallery->product_id->Visible) { // product_id ?>
		<td data-name="product_id"<?php echo $product_gallery->product_id->CellAttributes() ?>>
<?php if ($product_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($product_gallery->product_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_product_id" class="form-group product_gallery_product_id">
<span<?php echo $product_gallery->product_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->product_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $product_gallery_list->RowIndex ?>_product_id" name="x<?php echo $product_gallery_list->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_product_id" class="form-group product_gallery_product_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $product_gallery_list->RowIndex ?>_product_id"><?php echo (strval($product_gallery->product_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $product_gallery->product_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($product_gallery->product_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $product_gallery_list->RowIndex ?>_product_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($product_gallery->product_id->ReadOnly || $product_gallery->product_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $product_gallery->product_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $product_gallery_list->RowIndex ?>_product_id" id="x<?php echo $product_gallery_list->RowIndex ?>_product_id" value="<?php echo $product_gallery->product_id->CurrentValue ?>"<?php echo $product_gallery->product_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $product_gallery->product_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $product_gallery_list->RowIndex ?>_product_id',url:'productsaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $product_gallery_list->RowIndex ?>_product_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $product_gallery->product_id->FldCaption() ?></span></button>
</span>
<?php } ?>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="o<?php echo $product_gallery_list->RowIndex ?>_product_id" id="o<?php echo $product_gallery_list->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->OldValue) ?>">
<?php } ?>
<?php if ($product_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_product_id" class="form-group product_gallery_product_id">
<span<?php echo $product_gallery->product_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->product_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="x<?php echo $product_gallery_list->RowIndex ?>_product_id" id="x<?php echo $product_gallery_list->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->CurrentValue) ?>">
<?php } ?>
<?php if ($product_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_product_id" class="product_gallery_product_id">
<span<?php echo $product_gallery->product_id->ViewAttributes() ?>>
<?php echo $product_gallery->product_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($product_gallery->thumnail->Visible) { // thumnail ?>
		<td data-name="thumnail"<?php echo $product_gallery->thumnail->CellAttributes() ?>>
<?php if ($product_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_thumnail" class="form-group product_gallery_thumnail">
<div id="fd_x<?php echo $product_gallery_list->RowIndex ?>_thumnail">
<span title="<?php echo $product_gallery->thumnail->FldTitle() ? $product_gallery->thumnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->thumnail->ReadOnly || $product_gallery->thumnail->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_thumnail" name="x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id="x<?php echo $product_gallery_list->RowIndex ?>_thumnail"<?php echo $product_gallery->thumnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fn_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fa_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="0">
<input type="hidden" name="fs_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fs_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fx_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fm_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_thumnail" name="o<?php echo $product_gallery_list->RowIndex ?>_thumnail" id="o<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo ew_HtmlEncode($product_gallery->thumnail->OldValue) ?>">
<?php } ?>
<?php if ($product_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_thumnail" class="form-group product_gallery_thumnail">
<div id="fd_x<?php echo $product_gallery_list->RowIndex ?>_thumnail">
<span title="<?php echo $product_gallery->thumnail->FldTitle() ? $product_gallery->thumnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->thumnail->ReadOnly || $product_gallery->thumnail->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_thumnail" name="x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id="x<?php echo $product_gallery_list->RowIndex ?>_thumnail"<?php echo $product_gallery->thumnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fn_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $product_gallery_list->RowIndex ?>_thumnail"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fa_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fa_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fs_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fx_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fm_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($product_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_thumnail" class="product_gallery_thumnail">
<span>
<?php echo ew_GetFileViewTag($product_gallery->thumnail, $product_gallery->thumnail->ListViewValue()) ?>
</span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($product_gallery->image->Visible) { // image ?>
		<td data-name="image"<?php echo $product_gallery->image->CellAttributes() ?>>
<?php if ($product_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_image" class="form-group product_gallery_image">
<div id="fd_x<?php echo $product_gallery_list->RowIndex ?>_image">
<span title="<?php echo $product_gallery->image->FldTitle() ? $product_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->image->ReadOnly || $product_gallery->image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_image" name="x<?php echo $product_gallery_list->RowIndex ?>_image" id="x<?php echo $product_gallery_list->RowIndex ?>_image"<?php echo $product_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fn_x<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo $product_gallery->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fa_x<?php echo $product_gallery_list->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fs_x<?php echo $product_gallery_list->RowIndex ?>_image" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fx_x<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fm_x<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_list->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_image" name="o<?php echo $product_gallery_list->RowIndex ?>_image" id="o<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($product_gallery->image->OldValue) ?>">
<?php } ?>
<?php if ($product_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_image" class="form-group product_gallery_image">
<div id="fd_x<?php echo $product_gallery_list->RowIndex ?>_image">
<span title="<?php echo $product_gallery->image->FldTitle() ? $product_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->image->ReadOnly || $product_gallery->image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_image" name="x<?php echo $product_gallery_list->RowIndex ?>_image" id="x<?php echo $product_gallery_list->RowIndex ?>_image"<?php echo $product_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fn_x<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo $product_gallery->image->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $product_gallery_list->RowIndex ?>_image"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fa_x<?php echo $product_gallery_list->RowIndex ?>_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fa_x<?php echo $product_gallery_list->RowIndex ?>_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fs_x<?php echo $product_gallery_list->RowIndex ?>_image" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fx_x<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fm_x<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_list->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($product_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $product_gallery_list->RowCnt ?>_product_gallery_image" class="product_gallery_image">
<span>
<?php echo ew_GetFileViewTag($product_gallery->image, $product_gallery->image->ListViewValue()) ?>
</span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$product_gallery_list->ListOptions->Render("body", "right", $product_gallery_list->RowCnt);
?>
	</tr>
<?php if ($product_gallery->RowType == EW_ROWTYPE_ADD || $product_gallery->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fproduct_gallerylist.UpdateOpts(<?php echo $product_gallery_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($product_gallery->CurrentAction <> "gridadd")
		if (!$product_gallery_list->Recordset->EOF) $product_gallery_list->Recordset->MoveNext();
}
?>
<?php
	if ($product_gallery->CurrentAction == "gridadd" || $product_gallery->CurrentAction == "gridedit") {
		$product_gallery_list->RowIndex = '$rowindex$';
		$product_gallery_list->LoadRowValues();

		// Set row properties
		$product_gallery->ResetAttrs();
		$product_gallery->RowAttrs = array_merge($product_gallery->RowAttrs, array('data-rowindex'=>$product_gallery_list->RowIndex, 'id'=>'r0_product_gallery', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($product_gallery->RowAttrs["class"], "ewTemplate");
		$product_gallery->RowType = EW_ROWTYPE_ADD;

		// Render row
		$product_gallery_list->RenderRow();

		// Render list options
		$product_gallery_list->RenderListOptions();
		$product_gallery_list->StartRowCnt = 0;
?>
	<tr<?php echo $product_gallery->RowAttributes() ?>>
<?php

// Render list options (body, left)
$product_gallery_list->ListOptions->Render("body", "left", $product_gallery_list->RowIndex);
?>
	<?php if ($product_gallery->pro_gallery_id->Visible) { // pro_gallery_id ?>
		<td data-name="pro_gallery_id">
<input type="hidden" data-table="product_gallery" data-field="x_pro_gallery_id" name="o<?php echo $product_gallery_list->RowIndex ?>_pro_gallery_id" id="o<?php echo $product_gallery_list->RowIndex ?>_pro_gallery_id" value="<?php echo ew_HtmlEncode($product_gallery->pro_gallery_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($product_gallery->product_id->Visible) { // product_id ?>
		<td data-name="product_id">
<?php if ($product_gallery->product_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_product_gallery_product_id" class="form-group product_gallery_product_id">
<span<?php echo $product_gallery->product_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->product_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $product_gallery_list->RowIndex ?>_product_id" name="x<?php echo $product_gallery_list->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_product_gallery_product_id" class="form-group product_gallery_product_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $product_gallery_list->RowIndex ?>_product_id"><?php echo (strval($product_gallery->product_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $product_gallery->product_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($product_gallery->product_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $product_gallery_list->RowIndex ?>_product_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($product_gallery->product_id->ReadOnly || $product_gallery->product_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $product_gallery->product_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $product_gallery_list->RowIndex ?>_product_id" id="x<?php echo $product_gallery_list->RowIndex ?>_product_id" value="<?php echo $product_gallery->product_id->CurrentValue ?>"<?php echo $product_gallery->product_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $product_gallery->product_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $product_gallery_list->RowIndex ?>_product_id',url:'productsaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $product_gallery_list->RowIndex ?>_product_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $product_gallery->product_id->FldCaption() ?></span></button>
</span>
<?php } ?>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="o<?php echo $product_gallery_list->RowIndex ?>_product_id" id="o<?php echo $product_gallery_list->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($product_gallery->thumnail->Visible) { // thumnail ?>
		<td data-name="thumnail">
<span id="el$rowindex$_product_gallery_thumnail" class="form-group product_gallery_thumnail">
<div id="fd_x<?php echo $product_gallery_list->RowIndex ?>_thumnail">
<span title="<?php echo $product_gallery->thumnail->FldTitle() ? $product_gallery->thumnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->thumnail->ReadOnly || $product_gallery->thumnail->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_thumnail" name="x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id="x<?php echo $product_gallery_list->RowIndex ?>_thumnail"<?php echo $product_gallery->thumnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fn_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fa_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="0">
<input type="hidden" name="fs_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fs_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fx_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" id= "fm_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_list->RowIndex ?>_thumnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_thumnail" name="o<?php echo $product_gallery_list->RowIndex ?>_thumnail" id="o<?php echo $product_gallery_list->RowIndex ?>_thumnail" value="<?php echo ew_HtmlEncode($product_gallery->thumnail->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($product_gallery->image->Visible) { // image ?>
		<td data-name="image">
<span id="el$rowindex$_product_gallery_image" class="form-group product_gallery_image">
<div id="fd_x<?php echo $product_gallery_list->RowIndex ?>_image">
<span title="<?php echo $product_gallery->image->FldTitle() ? $product_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->image->ReadOnly || $product_gallery->image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_image" name="x<?php echo $product_gallery_list->RowIndex ?>_image" id="x<?php echo $product_gallery_list->RowIndex ?>_image"<?php echo $product_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fn_x<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo $product_gallery->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fa_x<?php echo $product_gallery_list->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fs_x<?php echo $product_gallery_list->RowIndex ?>_image" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fx_x<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_list->RowIndex ?>_image" id= "fm_x<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_list->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_image" name="o<?php echo $product_gallery_list->RowIndex ?>_image" id="o<?php echo $product_gallery_list->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($product_gallery->image->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$product_gallery_list->ListOptions->Render("body", "right", $product_gallery_list->RowIndex);
?>
<script type="text/javascript">
fproduct_gallerylist.UpdateOpts(<?php echo $product_gallery_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($product_gallery->CurrentAction == "add" || $product_gallery->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $product_gallery_list->FormKeyCountName ?>" id="<?php echo $product_gallery_list->FormKeyCountName ?>" value="<?php echo $product_gallery_list->KeyCount ?>">
<?php } ?>
<?php if ($product_gallery->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $product_gallery_list->FormKeyCountName ?>" id="<?php echo $product_gallery_list->FormKeyCountName ?>" value="<?php echo $product_gallery_list->KeyCount ?>">
<?php echo $product_gallery_list->MultiSelectKey ?>
<?php } ?>
<?php if ($product_gallery->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $product_gallery_list->FormKeyCountName ?>" id="<?php echo $product_gallery_list->FormKeyCountName ?>" value="<?php echo $product_gallery_list->KeyCount ?>">
<?php } ?>
<?php if ($product_gallery->CurrentAction == "gridedit") { ?>
<?php if ($product_gallery->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="a_list" id="a_list" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $product_gallery_list->FormKeyCountName ?>" id="<?php echo $product_gallery_list->FormKeyCountName ?>" value="<?php echo $product_gallery_list->KeyCount ?>">
<?php echo $product_gallery_list->MultiSelectKey ?>
<?php } ?>
<?php if ($product_gallery->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($product_gallery_list->Recordset)
	$product_gallery_list->Recordset->Close();
?>
<?php if ($product_gallery->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($product_gallery->CurrentAction <> "gridadd" && $product_gallery->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($product_gallery_list->Pager)) $product_gallery_list->Pager = new cPrevNextPager($product_gallery_list->StartRec, $product_gallery_list->DisplayRecs, $product_gallery_list->TotalRecs, $product_gallery_list->AutoHidePager) ?>
<?php if ($product_gallery_list->Pager->RecordCount > 0 && $product_gallery_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($product_gallery_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $product_gallery_list->PageUrl() ?>start=<?php echo $product_gallery_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($product_gallery_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $product_gallery_list->PageUrl() ?>start=<?php echo $product_gallery_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $product_gallery_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($product_gallery_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $product_gallery_list->PageUrl() ?>start=<?php echo $product_gallery_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($product_gallery_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $product_gallery_list->PageUrl() ?>start=<?php echo $product_gallery_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $product_gallery_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($product_gallery_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $product_gallery_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $product_gallery_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $product_gallery_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($product_gallery_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($product_gallery_list->TotalRecs == 0 && $product_gallery->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($product_gallery_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($product_gallery->Export == "") { ?>
<script type="text/javascript">
fproduct_gallerylistsrch.FilterList = <?php echo $product_gallery_list->GetFilterList() ?>;
fproduct_gallerylistsrch.Init();
fproduct_gallerylist.Init();
</script>
<?php } ?>
<?php
$product_gallery_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($product_gallery->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$product_gallery_list->Page_Terminate();
?>

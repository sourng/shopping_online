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

$products_view = NULL; // Initialize page object first

class cproducts_view extends cproducts {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'products';

	// Page object name
	var $PageObjName = 'products_view';

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
		$KeyUrl = "";
		if (@$_GET["product_id"] <> "") {
			$this->RecKey["product_id"] = $_GET["product_id"];
			$KeyUrl .= "&amp;product_id=" . urlencode($this->RecKey["product_id"]);
		}
		if (@$_GET["cat_id"] <> "") {
			$this->RecKey["cat_id"] = $_GET["cat_id"];
			$KeyUrl .= "&amp;cat_id=" . urlencode($this->RecKey["cat_id"]);
		}
		if (@$_GET["company_id"] <> "") {
			$this->RecKey["company_id"] = $_GET["company_id"];
			$KeyUrl .= "&amp;company_id=" . urlencode($this->RecKey["company_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (company)
		if (!isset($GLOBALS['company'])) $GLOBALS['company'] = new ccompany();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("productslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->product_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->product_id->Visible = FALSE;
		$this->cat_id->SetVisibility();
		$this->company_id->SetVisibility();
		$this->pro_name->SetVisibility();
		$this->pro_description->SetVisibility();
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "productsview.php")
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["product_id"] <> "") {
				$this->product_id->setQueryStringValue($_GET["product_id"]);
				$this->RecKey["product_id"] = $this->product_id->QueryStringValue;
			} elseif (@$_POST["product_id"] <> "") {
				$this->product_id->setFormValue($_POST["product_id"]);
				$this->RecKey["product_id"] = $this->product_id->FormValue;
			} else {
				$sReturnUrl = "productslist.php"; // Return to list
			}
			if (@$_GET["cat_id"] <> "") {
				$this->cat_id->setQueryStringValue($_GET["cat_id"]);
				$this->RecKey["cat_id"] = $this->cat_id->QueryStringValue;
			} elseif (@$_POST["cat_id"] <> "") {
				$this->cat_id->setFormValue($_POST["cat_id"]);
				$this->RecKey["cat_id"] = $this->cat_id->FormValue;
			} else {
				$sReturnUrl = "productslist.php"; // Return to list
			}
			if (@$_GET["company_id"] <> "") {
				$this->company_id->setQueryStringValue($_GET["company_id"]);
				$this->RecKey["company_id"] = $this->company_id->QueryStringValue;
			} elseif (@$_POST["company_id"] <> "") {
				$this->company_id->setFormValue($_POST["company_id"]);
				$this->RecKey["company_id"] = $this->company_id->FormValue;
			} else {
				$sReturnUrl = "productslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "productslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "productslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->CopyUrl) . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddQuery($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

		// pro_description
		$this->pro_description->ViewValue = $this->pro_description->CurrentValue;
		$this->pro_description->ViewCustomAttributes = "";

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

			// pro_description
			$this->pro_description->LinkCustomAttributes = "";
			$this->pro_description->HrefValue = "";
			$this->pro_description->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("productslist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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
if (!isset($products_view)) $products_view = new cproducts_view();

// Page init
$products_view->Page_Init();

// Page main
$products_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$products_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fproductsview = new ew_Form("fproductsview", "view");

// Form_CustomValidate event
fproductsview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fproductsview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fproductsview.Lists["x_pro_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fproductsview.Lists["x_pro_status[]"].Options = <?php echo json_encode($products_view->pro_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $products_view->ExportOptions->Render("body") ?>
<?php
	foreach ($products_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $products_view->ShowPageHeader(); ?>
<?php
$products_view->ShowMessage();
?>
<form name="fproductsview" id="fproductsview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($products_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $products_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="products">
<input type="hidden" name="modal" value="<?php echo intval($products_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($products->product_id->Visible) { // product_id ?>
	<tr id="r_product_id">
		<td class="col-sm-2"><span id="elh_products_product_id"><?php echo $products->product_id->FldCaption() ?></span></td>
		<td data-name="product_id"<?php echo $products->product_id->CellAttributes() ?>>
<span id="el_products_product_id">
<span<?php echo $products->product_id->ViewAttributes() ?>>
<?php echo $products->product_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->cat_id->Visible) { // cat_id ?>
	<tr id="r_cat_id">
		<td class="col-sm-2"><span id="elh_products_cat_id"><?php echo $products->cat_id->FldCaption() ?></span></td>
		<td data-name="cat_id"<?php echo $products->cat_id->CellAttributes() ?>>
<span id="el_products_cat_id">
<span<?php echo $products->cat_id->ViewAttributes() ?>>
<?php echo $products->cat_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->company_id->Visible) { // company_id ?>
	<tr id="r_company_id">
		<td class="col-sm-2"><span id="elh_products_company_id"><?php echo $products->company_id->FldCaption() ?></span></td>
		<td data-name="company_id"<?php echo $products->company_id->CellAttributes() ?>>
<span id="el_products_company_id">
<span<?php echo $products->company_id->ViewAttributes() ?>>
<?php echo $products->company_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->pro_name->Visible) { // pro_name ?>
	<tr id="r_pro_name">
		<td class="col-sm-2"><span id="elh_products_pro_name"><?php echo $products->pro_name->FldCaption() ?></span></td>
		<td data-name="pro_name"<?php echo $products->pro_name->CellAttributes() ?>>
<span id="el_products_pro_name">
<span<?php echo $products->pro_name->ViewAttributes() ?>>
<?php echo $products->pro_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->pro_description->Visible) { // pro_description ?>
	<tr id="r_pro_description">
		<td class="col-sm-2"><span id="elh_products_pro_description"><?php echo $products->pro_description->FldCaption() ?></span></td>
		<td data-name="pro_description"<?php echo $products->pro_description->CellAttributes() ?>>
<span id="el_products_pro_description">
<span<?php echo $products->pro_description->ViewAttributes() ?>>
<?php echo $products->pro_description->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->pro_condition->Visible) { // pro_condition ?>
	<tr id="r_pro_condition">
		<td class="col-sm-2"><span id="elh_products_pro_condition"><?php echo $products->pro_condition->FldCaption() ?></span></td>
		<td data-name="pro_condition"<?php echo $products->pro_condition->CellAttributes() ?>>
<span id="el_products_pro_condition">
<span<?php echo $products->pro_condition->ViewAttributes() ?>>
<?php echo $products->pro_condition->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->pro_brand->Visible) { // pro_brand ?>
	<tr id="r_pro_brand">
		<td class="col-sm-2"><span id="elh_products_pro_brand"><?php echo $products->pro_brand->FldCaption() ?></span></td>
		<td data-name="pro_brand"<?php echo $products->pro_brand->CellAttributes() ?>>
<span id="el_products_pro_brand">
<span<?php echo $products->pro_brand->ViewAttributes() ?>>
<?php echo $products->pro_brand->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->pro_features->Visible) { // pro_features ?>
	<tr id="r_pro_features">
		<td class="col-sm-2"><span id="elh_products_pro_features"><?php echo $products->pro_features->FldCaption() ?></span></td>
		<td data-name="pro_features"<?php echo $products->pro_features->CellAttributes() ?>>
<span id="el_products_pro_features">
<span<?php echo $products->pro_features->ViewAttributes() ?>>
<?php echo $products->pro_features->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->pro_model->Visible) { // pro_model ?>
	<tr id="r_pro_model">
		<td class="col-sm-2"><span id="elh_products_pro_model"><?php echo $products->pro_model->FldCaption() ?></span></td>
		<td data-name="pro_model"<?php echo $products->pro_model->CellAttributes() ?>>
<span id="el_products_pro_model">
<span<?php echo $products->pro_model->ViewAttributes() ?>>
<?php echo $products->pro_model->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->post_date->Visible) { // post_date ?>
	<tr id="r_post_date">
		<td class="col-sm-2"><span id="elh_products_post_date"><?php echo $products->post_date->FldCaption() ?></span></td>
		<td data-name="post_date"<?php echo $products->post_date->CellAttributes() ?>>
<span id="el_products_post_date">
<span<?php echo $products->post_date->ViewAttributes() ?>>
<?php echo $products->post_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->ads_id->Visible) { // ads_id ?>
	<tr id="r_ads_id">
		<td class="col-sm-2"><span id="elh_products_ads_id"><?php echo $products->ads_id->FldCaption() ?></span></td>
		<td data-name="ads_id"<?php echo $products->ads_id->CellAttributes() ?>>
<span id="el_products_ads_id">
<span<?php echo $products->ads_id->ViewAttributes() ?>>
<?php echo $products->ads_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->pro_base_price->Visible) { // pro_base_price ?>
	<tr id="r_pro_base_price">
		<td class="col-sm-2"><span id="elh_products_pro_base_price"><?php echo $products->pro_base_price->FldCaption() ?></span></td>
		<td data-name="pro_base_price"<?php echo $products->pro_base_price->CellAttributes() ?>>
<span id="el_products_pro_base_price">
<span<?php echo $products->pro_base_price->ViewAttributes() ?>>
<?php echo $products->pro_base_price->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->pro_sell_price->Visible) { // pro_sell_price ?>
	<tr id="r_pro_sell_price">
		<td class="col-sm-2"><span id="elh_products_pro_sell_price"><?php echo $products->pro_sell_price->FldCaption() ?></span></td>
		<td data-name="pro_sell_price"<?php echo $products->pro_sell_price->CellAttributes() ?>>
<span id="el_products_pro_sell_price">
<span<?php echo $products->pro_sell_price->ViewAttributes() ?>>
<?php echo $products->pro_sell_price->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->featured_image->Visible) { // featured_image ?>
	<tr id="r_featured_image">
		<td class="col-sm-2"><span id="elh_products_featured_image"><?php echo $products->featured_image->FldCaption() ?></span></td>
		<td data-name="featured_image"<?php echo $products->featured_image->CellAttributes() ?>>
<span id="el_products_featured_image">
<span<?php echo $products->featured_image->ViewAttributes() ?>>
<?php echo $products->featured_image->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->folder_image->Visible) { // folder_image ?>
	<tr id="r_folder_image">
		<td class="col-sm-2"><span id="elh_products_folder_image"><?php echo $products->folder_image->FldCaption() ?></span></td>
		<td data-name="folder_image"<?php echo $products->folder_image->CellAttributes() ?>>
<span id="el_products_folder_image">
<span<?php echo $products->folder_image->ViewAttributes() ?>>
<?php echo $products->folder_image->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->img1->Visible) { // img1 ?>
	<tr id="r_img1">
		<td class="col-sm-2"><span id="elh_products_img1"><?php echo $products->img1->FldCaption() ?></span></td>
		<td data-name="img1"<?php echo $products->img1->CellAttributes() ?>>
<span id="el_products_img1">
<span<?php echo $products->img1->ViewAttributes() ?>>
<?php echo $products->img1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->img2->Visible) { // img2 ?>
	<tr id="r_img2">
		<td class="col-sm-2"><span id="elh_products_img2"><?php echo $products->img2->FldCaption() ?></span></td>
		<td data-name="img2"<?php echo $products->img2->CellAttributes() ?>>
<span id="el_products_img2">
<span<?php echo $products->img2->ViewAttributes() ?>>
<?php echo $products->img2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->img3->Visible) { // img3 ?>
	<tr id="r_img3">
		<td class="col-sm-2"><span id="elh_products_img3"><?php echo $products->img3->FldCaption() ?></span></td>
		<td data-name="img3"<?php echo $products->img3->CellAttributes() ?>>
<span id="el_products_img3">
<span<?php echo $products->img3->ViewAttributes() ?>>
<?php echo $products->img3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->img4->Visible) { // img4 ?>
	<tr id="r_img4">
		<td class="col-sm-2"><span id="elh_products_img4"><?php echo $products->img4->FldCaption() ?></span></td>
		<td data-name="img4"<?php echo $products->img4->CellAttributes() ?>>
<span id="el_products_img4">
<span<?php echo $products->img4->ViewAttributes() ?>>
<?php echo $products->img4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->img5->Visible) { // img5 ?>
	<tr id="r_img5">
		<td class="col-sm-2"><span id="elh_products_img5"><?php echo $products->img5->FldCaption() ?></span></td>
		<td data-name="img5"<?php echo $products->img5->CellAttributes() ?>>
<span id="el_products_img5">
<span<?php echo $products->img5->ViewAttributes() ?>>
<?php echo $products->img5->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($products->pro_status->Visible) { // pro_status ?>
	<tr id="r_pro_status">
		<td class="col-sm-2"><span id="elh_products_pro_status"><?php echo $products->pro_status->FldCaption() ?></span></td>
		<td data-name="pro_status"<?php echo $products->pro_status->CellAttributes() ?>>
<span id="el_products_pro_status">
<span<?php echo $products->pro_status->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($products->pro_status->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $products->pro_status->ViewValue ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $products->pro_status->ViewValue ?>" disabled>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fproductsview.Init();
</script>
<?php
$products_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$products_view->Page_Terminate();
?>

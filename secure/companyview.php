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

$company_view = NULL; // Initialize page object first

class ccompany_view extends ccompany {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'company';

	// Page object name
	var $PageObjName = 'company_view';

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
		$KeyUrl = "";
		if (@$_GET["company_id"] <> "") {
			$this->RecKey["company_id"] = $_GET["company_id"];
			$KeyUrl .= "&amp;company_id=" . urlencode($this->RecKey["company_id"]);
		}
		if (@$_GET["country_id"] <> "") {
			$this->RecKey["country_id"] = $_GET["country_id"];
			$KeyUrl .= "&amp;country_id=" . urlencode($this->RecKey["country_id"]);
		}
		if (@$_GET["province_id"] <> "") {
			$this->RecKey["province_id"] = $_GET["province_id"];
			$KeyUrl .= "&amp;province_id=" . urlencode($this->RecKey["province_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("companylist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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
		$this->com_username->SetVisibility();
		$this->com_password->SetVisibility();
		$this->com_online->SetVisibility();
		$this->com_activation->SetVisibility();
		$this->com_status->SetVisibility();
		$this->reg_date->SetVisibility();
		$this->country_id->SetVisibility();

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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "companyview.php")
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
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
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

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["company_id"] <> "") {
				$this->company_id->setQueryStringValue($_GET["company_id"]);
				$this->RecKey["company_id"] = $this->company_id->QueryStringValue;
			} elseif (@$_POST["company_id"] <> "") {
				$this->company_id->setFormValue($_POST["company_id"]);
				$this->RecKey["company_id"] = $this->company_id->FormValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}
			if (@$_GET["country_id"] <> "") {
				$this->country_id->setQueryStringValue($_GET["country_id"]);
				$this->RecKey["country_id"] = $this->country_id->QueryStringValue;
			} elseif (@$_POST["country_id"] <> "") {
				$this->country_id->setFormValue($_POST["country_id"]);
				$this->RecKey["country_id"] = $this->country_id->FormValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}
			if (@$_GET["province_id"] <> "") {
				$this->province_id->setQueryStringValue($_GET["province_id"]);
				$this->RecKey["province_id"] = $this->province_id->QueryStringValue;
			} elseif (@$_POST["province_id"] <> "") {
				$this->province_id->setFormValue($_POST["province_id"]);
				$this->RecKey["province_id"] = $this->province_id->FormValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("companylist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetupStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->company_id->CurrentValue) == strval($this->Recordset->fields('company_id')) && strval($this->country_id->CurrentValue) == strval($this->Recordset->fields('country_id')) && strval($this->province_id->CurrentValue) == strval($this->Recordset->fields('province_id'))) {
								$this->setStartRecordNumber($this->StartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->StartRec++;
								$this->Recordset->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "companylist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}
		} else {
			$sReturnUrl = "companylist.php"; // Not page request, return to list
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
		$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = TRUE;
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
		$row['com_username'] = NULL;
		$row['com_password'] = NULL;
		$row['com_online'] = NULL;
		$row['com_activation'] = NULL;
		$row['com_status'] = NULL;
		$row['reg_date'] = NULL;
		$row['country_id'] = NULL;
		$row['province_id'] = NULL;
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
				$this->com_logo->LinkAttrs["data-rel"] = "company_x_com_logo";
				ew_AppendClass($this->com_logo->LinkAttrs["class"], "ewLightbox");
			}

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

			// country_id
			$this->country_id->LinkCustomAttributes = "";
			$this->country_id->HrefValue = "";
			$this->country_id->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("companylist.php"), "", $this->TableVar, TRUE);
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
if (!isset($company_view)) $company_view = new ccompany_view();

// Page init
$company_view->Page_Init();

// Page main
$company_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$company_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fcompanyview = new ew_Form("fcompanyview", "view");

// Form_CustomValidate event
fcompanyview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcompanyview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcompanyview.Lists["x_com_online"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcompanyview.Lists["x_com_online"].Options = <?php echo json_encode($company_view->com_online->Options()) ?>;
fcompanyview.Lists["x_com_activation"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcompanyview.Lists["x_com_activation"].Options = <?php echo json_encode($company_view->com_activation->Options()) ?>;
fcompanyview.Lists["x_com_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcompanyview.Lists["x_com_status"].Options = <?php echo json_encode($company_view->com_status->Options()) ?>;
fcompanyview.Lists["x_country_id"] = {"LinkField":"x_country_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_country_name_kh","x_country_name_en","x_country_code",""],"ParentFields":[],"ChildFields":["x_province_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"country"};
fcompanyview.Lists["x_country_id"].Data = "<?php echo $company_view->country_id->LookupFilterQuery(FALSE, "view") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $company_view->ExportOptions->Render("body") ?>
<?php
	foreach ($company_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $company_view->ShowPageHeader(); ?>
<?php
$company_view->ShowMessage();
?>
<?php if (!$company_view->IsModal) { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($company_view->Pager)) $company_view->Pager = new cPrevNextPager($company_view->StartRec, $company_view->DisplayRecs, $company_view->TotalRecs, $company_view->AutoHidePager) ?>
<?php if ($company_view->Pager->RecordCount > 0 && $company_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($company_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $company_view->PageUrl() ?>start=<?php echo $company_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($company_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $company_view->PageUrl() ?>start=<?php echo $company_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $company_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($company_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $company_view->PageUrl() ?>start=<?php echo $company_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($company_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $company_view->PageUrl() ?>start=<?php echo $company_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $company_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fcompanyview" id="fcompanyview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($company_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $company_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="company">
<input type="hidden" name="modal" value="<?php echo intval($company_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($company->company_id->Visible) { // company_id ?>
	<tr id="r_company_id">
		<td class="col-sm-2"><span id="elh_company_company_id"><?php echo $company->company_id->FldCaption() ?></span></td>
		<td data-name="company_id"<?php echo $company->company_id->CellAttributes() ?>>
<span id="el_company_company_id">
<span<?php echo $company->company_id->ViewAttributes() ?>>
<?php echo $company->company_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_fname->Visible) { // com_fname ?>
	<tr id="r_com_fname">
		<td class="col-sm-2"><span id="elh_company_com_fname"><?php echo $company->com_fname->FldCaption() ?></span></td>
		<td data-name="com_fname"<?php echo $company->com_fname->CellAttributes() ?>>
<span id="el_company_com_fname">
<span<?php echo $company->com_fname->ViewAttributes() ?>>
<?php echo $company->com_fname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_lname->Visible) { // com_lname ?>
	<tr id="r_com_lname">
		<td class="col-sm-2"><span id="elh_company_com_lname"><?php echo $company->com_lname->FldCaption() ?></span></td>
		<td data-name="com_lname"<?php echo $company->com_lname->CellAttributes() ?>>
<span id="el_company_com_lname">
<span<?php echo $company->com_lname->ViewAttributes() ?>>
<?php echo $company->com_lname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_name->Visible) { // com_name ?>
	<tr id="r_com_name">
		<td class="col-sm-2"><span id="elh_company_com_name"><?php echo $company->com_name->FldCaption() ?></span></td>
		<td data-name="com_name"<?php echo $company->com_name->CellAttributes() ?>>
<span id="el_company_com_name">
<span<?php echo $company->com_name->ViewAttributes() ?>>
<?php echo $company->com_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_address->Visible) { // com_address ?>
	<tr id="r_com_address">
		<td class="col-sm-2"><span id="elh_company_com_address"><?php echo $company->com_address->FldCaption() ?></span></td>
		<td data-name="com_address"<?php echo $company->com_address->CellAttributes() ?>>
<span id="el_company_com_address">
<span<?php echo $company->com_address->ViewAttributes() ?>>
<?php echo $company->com_address->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_phone->Visible) { // com_phone ?>
	<tr id="r_com_phone">
		<td class="col-sm-2"><span id="elh_company_com_phone"><?php echo $company->com_phone->FldCaption() ?></span></td>
		<td data-name="com_phone"<?php echo $company->com_phone->CellAttributes() ?>>
<span id="el_company_com_phone">
<span<?php echo $company->com_phone->ViewAttributes() ?>>
<?php echo $company->com_phone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_email->Visible) { // com_email ?>
	<tr id="r_com_email">
		<td class="col-sm-2"><span id="elh_company_com_email"><?php echo $company->com_email->FldCaption() ?></span></td>
		<td data-name="com_email"<?php echo $company->com_email->CellAttributes() ?>>
<span id="el_company_com_email">
<span<?php echo $company->com_email->ViewAttributes() ?>>
<?php echo $company->com_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_fb->Visible) { // com_fb ?>
	<tr id="r_com_fb">
		<td class="col-sm-2"><span id="elh_company_com_fb"><?php echo $company->com_fb->FldCaption() ?></span></td>
		<td data-name="com_fb"<?php echo $company->com_fb->CellAttributes() ?>>
<span id="el_company_com_fb">
<span<?php echo $company->com_fb->ViewAttributes() ?>>
<?php echo $company->com_fb->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_tw->Visible) { // com_tw ?>
	<tr id="r_com_tw">
		<td class="col-sm-2"><span id="elh_company_com_tw"><?php echo $company->com_tw->FldCaption() ?></span></td>
		<td data-name="com_tw"<?php echo $company->com_tw->CellAttributes() ?>>
<span id="el_company_com_tw">
<span<?php echo $company->com_tw->ViewAttributes() ?>>
<?php echo $company->com_tw->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_yt->Visible) { // com_yt ?>
	<tr id="r_com_yt">
		<td class="col-sm-2"><span id="elh_company_com_yt"><?php echo $company->com_yt->FldCaption() ?></span></td>
		<td data-name="com_yt"<?php echo $company->com_yt->CellAttributes() ?>>
<span id="el_company_com_yt">
<span<?php echo $company->com_yt->ViewAttributes() ?>>
<?php echo $company->com_yt->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_logo->Visible) { // com_logo ?>
	<tr id="r_com_logo">
		<td class="col-sm-2"><span id="elh_company_com_logo"><?php echo $company->com_logo->FldCaption() ?></span></td>
		<td data-name="com_logo"<?php echo $company->com_logo->CellAttributes() ?>>
<span id="el_company_com_logo">
<span>
<?php echo ew_GetFileViewTag($company->com_logo, $company->com_logo->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_username->Visible) { // com_username ?>
	<tr id="r_com_username">
		<td class="col-sm-2"><span id="elh_company_com_username"><?php echo $company->com_username->FldCaption() ?></span></td>
		<td data-name="com_username"<?php echo $company->com_username->CellAttributes() ?>>
<span id="el_company_com_username">
<span<?php echo $company->com_username->ViewAttributes() ?>>
<?php echo $company->com_username->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_password->Visible) { // com_password ?>
	<tr id="r_com_password">
		<td class="col-sm-2"><span id="elh_company_com_password"><?php echo $company->com_password->FldCaption() ?></span></td>
		<td data-name="com_password"<?php echo $company->com_password->CellAttributes() ?>>
<span id="el_company_com_password">
<span<?php echo $company->com_password->ViewAttributes() ?>>
<?php echo $company->com_password->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_online->Visible) { // com_online ?>
	<tr id="r_com_online">
		<td class="col-sm-2"><span id="elh_company_com_online"><?php echo $company->com_online->FldCaption() ?></span></td>
		<td data-name="com_online"<?php echo $company->com_online->CellAttributes() ?>>
<span id="el_company_com_online">
<span<?php echo $company->com_online->ViewAttributes() ?>>
<?php echo $company->com_online->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_activation->Visible) { // com_activation ?>
	<tr id="r_com_activation">
		<td class="col-sm-2"><span id="elh_company_com_activation"><?php echo $company->com_activation->FldCaption() ?></span></td>
		<td data-name="com_activation"<?php echo $company->com_activation->CellAttributes() ?>>
<span id="el_company_com_activation">
<span<?php echo $company->com_activation->ViewAttributes() ?>>
<?php echo $company->com_activation->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->com_status->Visible) { // com_status ?>
	<tr id="r_com_status">
		<td class="col-sm-2"><span id="elh_company_com_status"><?php echo $company->com_status->FldCaption() ?></span></td>
		<td data-name="com_status"<?php echo $company->com_status->CellAttributes() ?>>
<span id="el_company_com_status">
<span<?php echo $company->com_status->ViewAttributes() ?>>
<?php echo $company->com_status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->reg_date->Visible) { // reg_date ?>
	<tr id="r_reg_date">
		<td class="col-sm-2"><span id="elh_company_reg_date"><?php echo $company->reg_date->FldCaption() ?></span></td>
		<td data-name="reg_date"<?php echo $company->reg_date->CellAttributes() ?>>
<span id="el_company_reg_date">
<span<?php echo $company->reg_date->ViewAttributes() ?>>
<?php echo $company->reg_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($company->country_id->Visible) { // country_id ?>
	<tr id="r_country_id">
		<td class="col-sm-2"><span id="elh_company_country_id"><?php echo $company->country_id->FldCaption() ?></span></td>
		<td data-name="country_id"<?php echo $company->country_id->CellAttributes() ?>>
<span id="el_company_country_id">
<span<?php echo $company->country_id->ViewAttributes() ?>>
<?php echo $company->country_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$company_view->IsModal) { ?>
<?php if (!isset($company_view->Pager)) $company_view->Pager = new cPrevNextPager($company_view->StartRec, $company_view->DisplayRecs, $company_view->TotalRecs, $company_view->AutoHidePager) ?>
<?php if ($company_view->Pager->RecordCount > 0 && $company_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($company_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $company_view->PageUrl() ?>start=<?php echo $company_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($company_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $company_view->PageUrl() ?>start=<?php echo $company_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $company_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($company_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $company_view->PageUrl() ?>start=<?php echo $company_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($company_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $company_view->PageUrl() ?>start=<?php echo $company_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $company_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fcompanyview.Init();
</script>
<?php
$company_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$company_view->Page_Terminate();
?>

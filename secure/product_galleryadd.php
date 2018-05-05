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

$product_gallery_add = NULL; // Initialize page object first

class cproduct_gallery_add extends cproduct_gallery {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'product_gallery';

	// Page object name
	var $PageObjName = 'product_gallery_add';

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

		// Table object (product_gallery)
		if (!isset($GLOBALS["product_gallery"]) || get_class($GLOBALS["product_gallery"]) == "cproduct_gallery") {
			$GLOBALS["product_gallery"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["product_gallery"];
		}

		// Table object (products)
		if (!isset($GLOBALS['products'])) $GLOBALS['products'] = new cproducts();

		// Table object (company)
		if (!isset($GLOBALS['company'])) $GLOBALS['company'] = new ccompany();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("product_gallerylist.php"));
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "product_galleryview.php")
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

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
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up master/detail parameters
		$this->SetupMasterParms();

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["pro_gallery_id"] != "") {
				$this->pro_gallery_id->setQueryStringValue($_GET["pro_gallery_id"]);
				$this->setKey("pro_gallery_id", $this->pro_gallery_id->CurrentValue); // Set up key
			} else {
				$this->setKey("pro_gallery_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["product_id"] != "") {
				$this->product_id->setQueryStringValue($_GET["product_id"]);
				$this->setKey("product_id", $this->product_id->CurrentValue); // Set up key
			} else {
				$this->setKey("product_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("product_gallerylist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "product_gallerylist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "product_galleryview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		if ($this->CurrentAction == "F") { // Confirm page
			$this->RowType = EW_ROWTYPE_VIEW; // Render view type
		} else {
			$this->RowType = EW_ROWTYPE_ADD; // Render add type
		}

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
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
		$this->thumnail->CurrentValue = NULL; // Clear file related field
		$this->image->Upload->DbValue = NULL;
		$this->image->OldValue = $this->image->Upload->DbValue;
		$this->image->CurrentValue = NULL; // Clear file related field
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->product_id->FldIsDetailKey) {
			$this->product_id->setFormValue($objForm->GetValue("x_product_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->product_id->CurrentValue = $this->product_id->FormValue;
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
				$this->thumnail->LinkAttrs["data-rel"] = "product_gallery_x_thumnail";
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
				$this->image->LinkAttrs["data-rel"] = "product_gallery_x_image";
				ew_AppendClass($this->image->LinkAttrs["class"], "ewLightbox");
			}
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// product_id
			$this->product_id->EditCustomAttributes = "";
			if ($this->product_id->getSessionValue() <> "") {
				$this->product_id->CurrentValue = $this->product_id->getSessionValue();
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
					$this->thumnail->Upload->FileName = $this->thumnail->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->thumnail);

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
					$this->image->Upload->FileName = $this->image->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->image);

			// Add refer script
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("product_gallerylist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($product_gallery_add)) $product_gallery_add = new cproduct_gallery_add();

// Page init
$product_gallery_add->Page_Init();

// Page main
$product_gallery_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$product_gallery_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fproduct_galleryadd = new ew_Form("fproduct_galleryadd", "add");

// Validate form
fproduct_galleryadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_product_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $product_gallery->product_id->FldCaption(), $product_gallery->product_id->ReqErrMsg)) ?>");

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
fproduct_galleryadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fproduct_galleryadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fproduct_galleryadd.Lists["x_product_id"] = {"LinkField":"x_product_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_pro_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"products"};
fproduct_galleryadd.Lists["x_product_id"].Data = "<?php echo $product_gallery_add->product_id->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $product_gallery_add->ShowPageHeader(); ?>
<?php
$product_gallery_add->ShowMessage();
?>
<form name="fproduct_galleryadd" id="fproduct_galleryadd" class="<?php echo $product_gallery_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($product_gallery_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $product_gallery_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="product_gallery">
<?php if ($product_gallery->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } else { ?>
<input type="hidden" name="a_add" id="a_add" value="F">
<?php } ?>
<input type="hidden" name="modal" value="<?php echo intval($product_gallery_add->IsModal) ?>">
<?php if ($product_gallery->getCurrentMasterTable() == "products") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="products">
<input type="hidden" name="fk_product_id" value="<?php echo $product_gallery->product_id->getSessionValue() ?>">
<?php } ?>
<div class="ewAddDiv"><!-- page* -->
<?php if ($product_gallery->product_id->Visible) { // product_id ?>
	<div id="r_product_id" class="form-group">
		<label id="elh_product_gallery_product_id" for="x_product_id" class="<?php echo $product_gallery_add->LeftColumnClass ?>"><?php echo $product_gallery->product_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $product_gallery_add->RightColumnClass ?>"><div<?php echo $product_gallery->product_id->CellAttributes() ?>>
<?php if ($product_gallery->CurrentAction <> "F") { ?>
<?php if ($product_gallery->product_id->getSessionValue() <> "") { ?>
<span id="el_product_gallery_product_id">
<span<?php echo $product_gallery->product_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->product_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_product_id" name="x_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_product_gallery_product_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_product_id"><?php echo (strval($product_gallery->product_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $product_gallery->product_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($product_gallery->product_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_product_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($product_gallery->product_id->ReadOnly || $product_gallery->product_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $product_gallery->product_id->DisplayValueSeparatorAttribute() ?>" name="x_product_id" id="x_product_id" value="<?php echo $product_gallery->product_id->CurrentValue ?>"<?php echo $product_gallery->product_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $product_gallery->product_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_product_id',url:'productsaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_product_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $product_gallery->product_id->FldCaption() ?></span></button>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_product_gallery_product_id">
<span<?php echo $product_gallery->product_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->product_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="x_product_id" id="x_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->FormValue) ?>">
<?php } ?>
<?php echo $product_gallery->product_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($product_gallery->thumnail->Visible) { // thumnail ?>
	<div id="r_thumnail" class="form-group">
		<label id="elh_product_gallery_thumnail" class="<?php echo $product_gallery_add->LeftColumnClass ?>"><?php echo $product_gallery->thumnail->FldCaption() ?></label>
		<div class="<?php echo $product_gallery_add->RightColumnClass ?>"><div<?php echo $product_gallery->thumnail->CellAttributes() ?>>
<span id="el_product_gallery_thumnail">
<div id="fd_x_thumnail">
<span title="<?php echo $product_gallery->thumnail->FldTitle() ? $product_gallery->thumnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->thumnail->ReadOnly || $product_gallery->thumnail->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_thumnail" name="x_thumnail" id="x_thumnail"<?php echo $product_gallery->thumnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_thumnail" id= "fn_x_thumnail" value="<?php echo $product_gallery->thumnail->Upload->FileName ?>">
<input type="hidden" name="fa_x_thumnail" id= "fa_x_thumnail" value="0">
<input type="hidden" name="fs_x_thumnail" id= "fs_x_thumnail" value="250">
<input type="hidden" name="fx_x_thumnail" id= "fx_x_thumnail" value="<?php echo $product_gallery->thumnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_thumnail" id= "fm_x_thumnail" value="<?php echo $product_gallery->thumnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x_thumnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $product_gallery->thumnail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($product_gallery->image->Visible) { // image ?>
	<div id="r_image" class="form-group">
		<label id="elh_product_gallery_image" class="<?php echo $product_gallery_add->LeftColumnClass ?>"><?php echo $product_gallery->image->FldCaption() ?></label>
		<div class="<?php echo $product_gallery_add->RightColumnClass ?>"><div<?php echo $product_gallery->image->CellAttributes() ?>>
<span id="el_product_gallery_image">
<div id="fd_x_image">
<span title="<?php echo $product_gallery->image->FldTitle() ? $product_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->image->ReadOnly || $product_gallery->image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_image" name="x_image" id="x_image"<?php echo $product_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_image" id= "fn_x_image" value="<?php echo $product_gallery->image->Upload->FileName ?>">
<input type="hidden" name="fa_x_image" id= "fa_x_image" value="0">
<input type="hidden" name="fs_x_image" id= "fs_x_image" value="250">
<input type="hidden" name="fx_x_image" id= "fx_x_image" value="<?php echo $product_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_image" id= "fm_x_image" value="<?php echo $product_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $product_gallery->image->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$product_gallery_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $product_gallery_add->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($product_gallery->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_add.value='F';"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $product_gallery_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_add.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fproduct_galleryadd.Init();
</script>
<?php
$product_gallery_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$product_gallery_add->Page_Terminate();
?>

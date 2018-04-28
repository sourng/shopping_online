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

$products_add = NULL; // Initialize page object first

class cproducts_add extends cproducts {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'products';

	// Page object name
	var $PageObjName = 'products_add';

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

		// Table object (products)
		if (!isset($GLOBALS["products"]) || get_class($GLOBALS["products"]) == "cproducts") {
			$GLOBALS["products"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["products"];
		}

		// Table object (company)
		if (!isset($GLOBALS['company'])) $GLOBALS['company'] = new ccompany();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("productslist.php"));
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

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["product_id"] != "") {
				$this->product_id->setQueryStringValue($_GET["product_id"]);
				$this->setKey("product_id", $this->product_id->CurrentValue); // Set up key
			} else {
				$this->setKey("product_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["cat_id"] != "") {
				$this->cat_id->setQueryStringValue($_GET["cat_id"]);
				$this->setKey("cat_id", $this->cat_id->CurrentValue); // Set up key
			} else {
				$this->setKey("cat_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["company_id"] != "") {
				$this->company_id->setQueryStringValue($_GET["company_id"]);
				$this->setKey("company_id", $this->company_id->CurrentValue); // Set up key
			} else {
				$this->setKey("company_id", ""); // Clear key
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
					$this->Page_Terminate("productslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "productslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "productsview.php")
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
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->product_id->CurrentValue = NULL;
		$this->product_id->OldValue = $this->product_id->CurrentValue;
		$this->cat_id->CurrentValue = NULL;
		$this->cat_id->OldValue = $this->cat_id->CurrentValue;
		$this->company_id->CurrentValue = NULL;
		$this->company_id->OldValue = $this->company_id->CurrentValue;
		$this->pro_name->CurrentValue = NULL;
		$this->pro_name->OldValue = $this->pro_name->CurrentValue;
		$this->pro_description->CurrentValue = NULL;
		$this->pro_description->OldValue = $this->pro_description->CurrentValue;
		$this->pro_condition->CurrentValue = NULL;
		$this->pro_condition->OldValue = $this->pro_condition->CurrentValue;
		$this->pro_brand->CurrentValue = NULL;
		$this->pro_brand->OldValue = $this->pro_brand->CurrentValue;
		$this->pro_features->CurrentValue = NULL;
		$this->pro_features->OldValue = $this->pro_features->CurrentValue;
		$this->pro_model->CurrentValue = NULL;
		$this->pro_model->OldValue = $this->pro_model->CurrentValue;
		$this->post_date->CurrentValue = NULL;
		$this->post_date->OldValue = $this->post_date->CurrentValue;
		$this->ads_id->CurrentValue = NULL;
		$this->ads_id->OldValue = $this->ads_id->CurrentValue;
		$this->pro_base_price->CurrentValue = NULL;
		$this->pro_base_price->OldValue = $this->pro_base_price->CurrentValue;
		$this->pro_sell_price->CurrentValue = NULL;
		$this->pro_sell_price->OldValue = $this->pro_sell_price->CurrentValue;
		$this->featured_image->CurrentValue = NULL;
		$this->featured_image->OldValue = $this->featured_image->CurrentValue;
		$this->folder_image->CurrentValue = NULL;
		$this->folder_image->OldValue = $this->folder_image->CurrentValue;
		$this->img1->CurrentValue = NULL;
		$this->img1->OldValue = $this->img1->CurrentValue;
		$this->img2->CurrentValue = NULL;
		$this->img2->OldValue = $this->img2->CurrentValue;
		$this->img3->CurrentValue = NULL;
		$this->img3->OldValue = $this->img3->CurrentValue;
		$this->img4->CurrentValue = NULL;
		$this->img4->OldValue = $this->img4->CurrentValue;
		$this->img5->CurrentValue = NULL;
		$this->img5->OldValue = $this->img5->CurrentValue;
		$this->pro_status->CurrentValue = NULL;
		$this->pro_status->OldValue = $this->pro_status->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->cat_id->FldIsDetailKey) {
			$this->cat_id->setFormValue($objForm->GetValue("x_cat_id"));
		}
		if (!$this->company_id->FldIsDetailKey) {
			$this->company_id->setFormValue($objForm->GetValue("x_company_id"));
		}
		if (!$this->pro_name->FldIsDetailKey) {
			$this->pro_name->setFormValue($objForm->GetValue("x_pro_name"));
		}
		if (!$this->pro_description->FldIsDetailKey) {
			$this->pro_description->setFormValue($objForm->GetValue("x_pro_description"));
		}
		if (!$this->pro_condition->FldIsDetailKey) {
			$this->pro_condition->setFormValue($objForm->GetValue("x_pro_condition"));
		}
		if (!$this->pro_brand->FldIsDetailKey) {
			$this->pro_brand->setFormValue($objForm->GetValue("x_pro_brand"));
		}
		if (!$this->pro_features->FldIsDetailKey) {
			$this->pro_features->setFormValue($objForm->GetValue("x_pro_features"));
		}
		if (!$this->pro_model->FldIsDetailKey) {
			$this->pro_model->setFormValue($objForm->GetValue("x_pro_model"));
		}
		if (!$this->post_date->FldIsDetailKey) {
			$this->post_date->setFormValue($objForm->GetValue("x_post_date"));
			$this->post_date->CurrentValue = ew_UnFormatDateTime($this->post_date->CurrentValue, 0);
		}
		if (!$this->ads_id->FldIsDetailKey) {
			$this->ads_id->setFormValue($objForm->GetValue("x_ads_id"));
		}
		if (!$this->pro_base_price->FldIsDetailKey) {
			$this->pro_base_price->setFormValue($objForm->GetValue("x_pro_base_price"));
		}
		if (!$this->pro_sell_price->FldIsDetailKey) {
			$this->pro_sell_price->setFormValue($objForm->GetValue("x_pro_sell_price"));
		}
		if (!$this->featured_image->FldIsDetailKey) {
			$this->featured_image->setFormValue($objForm->GetValue("x_featured_image"));
		}
		if (!$this->folder_image->FldIsDetailKey) {
			$this->folder_image->setFormValue($objForm->GetValue("x_folder_image"));
		}
		if (!$this->img1->FldIsDetailKey) {
			$this->img1->setFormValue($objForm->GetValue("x_img1"));
		}
		if (!$this->img2->FldIsDetailKey) {
			$this->img2->setFormValue($objForm->GetValue("x_img2"));
		}
		if (!$this->img3->FldIsDetailKey) {
			$this->img3->setFormValue($objForm->GetValue("x_img3"));
		}
		if (!$this->img4->FldIsDetailKey) {
			$this->img4->setFormValue($objForm->GetValue("x_img4"));
		}
		if (!$this->img5->FldIsDetailKey) {
			$this->img5->setFormValue($objForm->GetValue("x_img5"));
		}
		if (!$this->pro_status->FldIsDetailKey) {
			$this->pro_status->setFormValue($objForm->GetValue("x_pro_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->cat_id->CurrentValue = $this->cat_id->FormValue;
		$this->company_id->CurrentValue = $this->company_id->FormValue;
		$this->pro_name->CurrentValue = $this->pro_name->FormValue;
		$this->pro_description->CurrentValue = $this->pro_description->FormValue;
		$this->pro_condition->CurrentValue = $this->pro_condition->FormValue;
		$this->pro_brand->CurrentValue = $this->pro_brand->FormValue;
		$this->pro_features->CurrentValue = $this->pro_features->FormValue;
		$this->pro_model->CurrentValue = $this->pro_model->FormValue;
		$this->post_date->CurrentValue = $this->post_date->FormValue;
		$this->post_date->CurrentValue = ew_UnFormatDateTime($this->post_date->CurrentValue, 0);
		$this->ads_id->CurrentValue = $this->ads_id->FormValue;
		$this->pro_base_price->CurrentValue = $this->pro_base_price->FormValue;
		$this->pro_sell_price->CurrentValue = $this->pro_sell_price->FormValue;
		$this->featured_image->CurrentValue = $this->featured_image->FormValue;
		$this->folder_image->CurrentValue = $this->folder_image->FormValue;
		$this->img1->CurrentValue = $this->img1->FormValue;
		$this->img2->CurrentValue = $this->img2->FormValue;
		$this->img3->CurrentValue = $this->img3->FormValue;
		$this->img4->CurrentValue = $this->img4->FormValue;
		$this->img5->CurrentValue = $this->img5->FormValue;
		$this->pro_status->CurrentValue = $this->pro_status->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['product_id'] = $this->product_id->CurrentValue;
		$row['cat_id'] = $this->cat_id->CurrentValue;
		$row['company_id'] = $this->company_id->CurrentValue;
		$row['pro_name'] = $this->pro_name->CurrentValue;
		$row['pro_description'] = $this->pro_description->CurrentValue;
		$row['pro_condition'] = $this->pro_condition->CurrentValue;
		$row['pro_brand'] = $this->pro_brand->CurrentValue;
		$row['pro_features'] = $this->pro_features->CurrentValue;
		$row['pro_model'] = $this->pro_model->CurrentValue;
		$row['post_date'] = $this->post_date->CurrentValue;
		$row['ads_id'] = $this->ads_id->CurrentValue;
		$row['pro_base_price'] = $this->pro_base_price->CurrentValue;
		$row['pro_sell_price'] = $this->pro_sell_price->CurrentValue;
		$row['featured_image'] = $this->featured_image->CurrentValue;
		$row['folder_image'] = $this->folder_image->CurrentValue;
		$row['img1'] = $this->img1->CurrentValue;
		$row['img2'] = $this->img2->CurrentValue;
		$row['img3'] = $this->img3->CurrentValue;
		$row['img4'] = $this->img4->CurrentValue;
		$row['img5'] = $this->img5->CurrentValue;
		$row['pro_status'] = $this->pro_status->CurrentValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// cat_id
			$this->cat_id->EditAttrs["class"] = "form-control";
			$this->cat_id->EditCustomAttributes = "";
			$this->cat_id->EditValue = ew_HtmlEncode($this->cat_id->CurrentValue);
			$this->cat_id->PlaceHolder = ew_RemoveHtml($this->cat_id->FldCaption());

			// company_id
			$this->company_id->EditAttrs["class"] = "form-control";
			$this->company_id->EditCustomAttributes = "";
			$this->company_id->EditValue = ew_HtmlEncode($this->company_id->CurrentValue);
			$this->company_id->PlaceHolder = ew_RemoveHtml($this->company_id->FldCaption());

			// pro_name
			$this->pro_name->EditAttrs["class"] = "form-control";
			$this->pro_name->EditCustomAttributes = "";
			$this->pro_name->EditValue = ew_HtmlEncode($this->pro_name->CurrentValue);
			$this->pro_name->PlaceHolder = ew_RemoveHtml($this->pro_name->FldCaption());

			// pro_description
			$this->pro_description->EditAttrs["class"] = "form-control";
			$this->pro_description->EditCustomAttributes = "";
			$this->pro_description->EditValue = ew_HtmlEncode($this->pro_description->CurrentValue);
			$this->pro_description->PlaceHolder = ew_RemoveHtml($this->pro_description->FldCaption());

			// pro_condition
			$this->pro_condition->EditAttrs["class"] = "form-control";
			$this->pro_condition->EditCustomAttributes = "";
			$this->pro_condition->EditValue = ew_HtmlEncode($this->pro_condition->CurrentValue);
			$this->pro_condition->PlaceHolder = ew_RemoveHtml($this->pro_condition->FldCaption());

			// pro_brand
			$this->pro_brand->EditAttrs["class"] = "form-control";
			$this->pro_brand->EditCustomAttributes = "";
			$this->pro_brand->EditValue = ew_HtmlEncode($this->pro_brand->CurrentValue);
			$this->pro_brand->PlaceHolder = ew_RemoveHtml($this->pro_brand->FldCaption());

			// pro_features
			$this->pro_features->EditAttrs["class"] = "form-control";
			$this->pro_features->EditCustomAttributes = "";
			$this->pro_features->EditValue = ew_HtmlEncode($this->pro_features->CurrentValue);
			$this->pro_features->PlaceHolder = ew_RemoveHtml($this->pro_features->FldCaption());

			// pro_model
			$this->pro_model->EditAttrs["class"] = "form-control";
			$this->pro_model->EditCustomAttributes = "";
			$this->pro_model->EditValue = ew_HtmlEncode($this->pro_model->CurrentValue);
			$this->pro_model->PlaceHolder = ew_RemoveHtml($this->pro_model->FldCaption());

			// post_date
			$this->post_date->EditAttrs["class"] = "form-control";
			$this->post_date->EditCustomAttributes = "";
			$this->post_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->post_date->CurrentValue, 8));
			$this->post_date->PlaceHolder = ew_RemoveHtml($this->post_date->FldCaption());

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
			if (strval($this->pro_base_price->EditValue) <> "" && is_numeric($this->pro_base_price->EditValue)) $this->pro_base_price->EditValue = ew_FormatNumber($this->pro_base_price->EditValue, -2, -1, -2, 0);

			// pro_sell_price
			$this->pro_sell_price->EditAttrs["class"] = "form-control";
			$this->pro_sell_price->EditCustomAttributes = "";
			$this->pro_sell_price->EditValue = ew_HtmlEncode($this->pro_sell_price->CurrentValue);
			$this->pro_sell_price->PlaceHolder = ew_RemoveHtml($this->pro_sell_price->FldCaption());
			if (strval($this->pro_sell_price->EditValue) <> "" && is_numeric($this->pro_sell_price->EditValue)) $this->pro_sell_price->EditValue = ew_FormatNumber($this->pro_sell_price->EditValue, -2, -1, -2, 0);

			// featured_image
			$this->featured_image->EditAttrs["class"] = "form-control";
			$this->featured_image->EditCustomAttributes = "";
			$this->featured_image->EditValue = ew_HtmlEncode($this->featured_image->CurrentValue);
			$this->featured_image->PlaceHolder = ew_RemoveHtml($this->featured_image->FldCaption());

			// folder_image
			$this->folder_image->EditAttrs["class"] = "form-control";
			$this->folder_image->EditCustomAttributes = "";
			$this->folder_image->EditValue = ew_HtmlEncode($this->folder_image->CurrentValue);
			$this->folder_image->PlaceHolder = ew_RemoveHtml($this->folder_image->FldCaption());

			// img1
			$this->img1->EditAttrs["class"] = "form-control";
			$this->img1->EditCustomAttributes = "";
			$this->img1->EditValue = ew_HtmlEncode($this->img1->CurrentValue);
			$this->img1->PlaceHolder = ew_RemoveHtml($this->img1->FldCaption());

			// img2
			$this->img2->EditAttrs["class"] = "form-control";
			$this->img2->EditCustomAttributes = "";
			$this->img2->EditValue = ew_HtmlEncode($this->img2->CurrentValue);
			$this->img2->PlaceHolder = ew_RemoveHtml($this->img2->FldCaption());

			// img3
			$this->img3->EditAttrs["class"] = "form-control";
			$this->img3->EditCustomAttributes = "";
			$this->img3->EditValue = ew_HtmlEncode($this->img3->CurrentValue);
			$this->img3->PlaceHolder = ew_RemoveHtml($this->img3->FldCaption());

			// img4
			$this->img4->EditAttrs["class"] = "form-control";
			$this->img4->EditCustomAttributes = "";
			$this->img4->EditValue = ew_HtmlEncode($this->img4->CurrentValue);
			$this->img4->PlaceHolder = ew_RemoveHtml($this->img4->FldCaption());

			// img5
			$this->img5->EditAttrs["class"] = "form-control";
			$this->img5->EditCustomAttributes = "";
			$this->img5->EditValue = ew_HtmlEncode($this->img5->CurrentValue);
			$this->img5->PlaceHolder = ew_RemoveHtml($this->img5->FldCaption());

			// pro_status
			$this->pro_status->EditCustomAttributes = "";
			$this->pro_status->EditValue = $this->pro_status->Options(FALSE);

			// Add refer script
			// cat_id

			$this->cat_id->LinkCustomAttributes = "";
			$this->cat_id->HrefValue = "";

			// company_id
			$this->company_id->LinkCustomAttributes = "";
			$this->company_id->HrefValue = "";

			// pro_name
			$this->pro_name->LinkCustomAttributes = "";
			$this->pro_name->HrefValue = "";

			// pro_description
			$this->pro_description->LinkCustomAttributes = "";
			$this->pro_description->HrefValue = "";

			// pro_condition
			$this->pro_condition->LinkCustomAttributes = "";
			$this->pro_condition->HrefValue = "";

			// pro_brand
			$this->pro_brand->LinkCustomAttributes = "";
			$this->pro_brand->HrefValue = "";

			// pro_features
			$this->pro_features->LinkCustomAttributes = "";
			$this->pro_features->HrefValue = "";

			// pro_model
			$this->pro_model->LinkCustomAttributes = "";
			$this->pro_model->HrefValue = "";

			// post_date
			$this->post_date->LinkCustomAttributes = "";
			$this->post_date->HrefValue = "";

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
			$this->featured_image->HrefValue = "";

			// folder_image
			$this->folder_image->LinkCustomAttributes = "";
			$this->folder_image->HrefValue = "";

			// img1
			$this->img1->LinkCustomAttributes = "";
			$this->img1->HrefValue = "";

			// img2
			$this->img2->LinkCustomAttributes = "";
			$this->img2->HrefValue = "";

			// img3
			$this->img3->LinkCustomAttributes = "";
			$this->img3->HrefValue = "";

			// img4
			$this->img4->LinkCustomAttributes = "";
			$this->img4->HrefValue = "";

			// img5
			$this->img5->LinkCustomAttributes = "";
			$this->img5->HrefValue = "";

			// pro_status
			$this->pro_status->LinkCustomAttributes = "";
			$this->pro_status->HrefValue = "";
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
		if (!ew_CheckInteger($this->cat_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->cat_id->FldErrMsg());
		}
		if (!$this->company_id->FldIsDetailKey && !is_null($this->company_id->FormValue) && $this->company_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->company_id->FldCaption(), $this->company_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->company_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->company_id->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->post_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->post_date->FldErrMsg());
		}
		if (!ew_CheckNumber($this->pro_base_price->FormValue)) {
			ew_AddMessage($gsFormError, $this->pro_base_price->FldErrMsg());
		}
		if (!ew_CheckNumber($this->pro_sell_price->FormValue)) {
			ew_AddMessage($gsFormError, $this->pro_sell_price->FldErrMsg());
		}
		if (!$this->featured_image->FldIsDetailKey && !is_null($this->featured_image->FormValue) && $this->featured_image->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->featured_image->FldCaption(), $this->featured_image->ReqErrMsg));
		}
		if (!$this->folder_image->FldIsDetailKey && !is_null($this->folder_image->FormValue) && $this->folder_image->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->folder_image->FldCaption(), $this->folder_image->ReqErrMsg));
		}
		if (!$this->img1->FldIsDetailKey && !is_null($this->img1->FormValue) && $this->img1->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->img1->FldCaption(), $this->img1->ReqErrMsg));
		}
		if (!$this->img2->FldIsDetailKey && !is_null($this->img2->FormValue) && $this->img2->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->img2->FldCaption(), $this->img2->ReqErrMsg));
		}
		if (!$this->img3->FldIsDetailKey && !is_null($this->img3->FormValue) && $this->img3->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->img3->FldCaption(), $this->img3->ReqErrMsg));
		}
		if (!$this->img4->FldIsDetailKey && !is_null($this->img4->FormValue) && $this->img4->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->img4->FldCaption(), $this->img4->ReqErrMsg));
		}
		if (!$this->img5->FldIsDetailKey && !is_null($this->img5->FormValue) && $this->img5->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->img5->FldCaption(), $this->img5->ReqErrMsg));
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
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// cat_id
		$this->cat_id->SetDbValueDef($rsnew, $this->cat_id->CurrentValue, 0, FALSE);

		// company_id
		$this->company_id->SetDbValueDef($rsnew, $this->company_id->CurrentValue, 0, FALSE);

		// pro_name
		$this->pro_name->SetDbValueDef($rsnew, $this->pro_name->CurrentValue, NULL, FALSE);

		// pro_description
		$this->pro_description->SetDbValueDef($rsnew, $this->pro_description->CurrentValue, NULL, FALSE);

		// pro_condition
		$this->pro_condition->SetDbValueDef($rsnew, $this->pro_condition->CurrentValue, NULL, FALSE);

		// pro_brand
		$this->pro_brand->SetDbValueDef($rsnew, $this->pro_brand->CurrentValue, NULL, FALSE);

		// pro_features
		$this->pro_features->SetDbValueDef($rsnew, $this->pro_features->CurrentValue, NULL, FALSE);

		// pro_model
		$this->pro_model->SetDbValueDef($rsnew, $this->pro_model->CurrentValue, NULL, FALSE);

		// post_date
		$this->post_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->post_date->CurrentValue, 0), NULL, FALSE);

		// ads_id
		$this->ads_id->SetDbValueDef($rsnew, $this->ads_id->CurrentValue, NULL, FALSE);

		// pro_base_price
		$this->pro_base_price->SetDbValueDef($rsnew, $this->pro_base_price->CurrentValue, NULL, FALSE);

		// pro_sell_price
		$this->pro_sell_price->SetDbValueDef($rsnew, $this->pro_sell_price->CurrentValue, NULL, FALSE);

		// featured_image
		$this->featured_image->SetDbValueDef($rsnew, $this->featured_image->CurrentValue, "", FALSE);

		// folder_image
		$this->folder_image->SetDbValueDef($rsnew, $this->folder_image->CurrentValue, "", FALSE);

		// img1
		$this->img1->SetDbValueDef($rsnew, $this->img1->CurrentValue, "", FALSE);

		// img2
		$this->img2->SetDbValueDef($rsnew, $this->img2->CurrentValue, "", FALSE);

		// img3
		$this->img3->SetDbValueDef($rsnew, $this->img3->CurrentValue, "", FALSE);

		// img4
		$this->img4->SetDbValueDef($rsnew, $this->img4->CurrentValue, "", FALSE);

		// img5
		$this->img5->SetDbValueDef($rsnew, $this->img5->CurrentValue, "", FALSE);

		// pro_status
		$tmpBool = $this->pro_status->CurrentValue;
		if ($tmpBool <> "Y" && $tmpBool <> "N")
			$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
		$this->pro_status->SetDbValueDef($rsnew, $tmpBool, "N", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['cat_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['company_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
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
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("productslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($products_add)) $products_add = new cproducts_add();

// Page init
$products_add->Page_Init();

// Page main
$products_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$products_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fproductsadd = new ew_Form("fproductsadd", "add");

// Validate form
fproductsadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_cat_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->cat_id->FldCaption(), $products->cat_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cat_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($products->cat_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_company_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->company_id->FldCaption(), $products->company_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_company_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($products->company_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_post_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($products->post_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pro_base_price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($products->pro_base_price->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pro_sell_price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($products->pro_sell_price->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_featured_image");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->featured_image->FldCaption(), $products->featured_image->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_folder_image");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->folder_image->FldCaption(), $products->folder_image->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_img1");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->img1->FldCaption(), $products->img1->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_img2");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->img2->FldCaption(), $products->img2->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_img3");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->img3->FldCaption(), $products->img3->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_img4");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->img4->FldCaption(), $products->img4->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_img5");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->img5->FldCaption(), $products->img5->ReqErrMsg)) ?>");

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
fproductsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fproductsadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fproductsadd.Lists["x_pro_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fproductsadd.Lists["x_pro_status[]"].Options = <?php echo json_encode($products_add->pro_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $products_add->ShowPageHeader(); ?>
<?php
$products_add->ShowMessage();
?>
<form name="fproductsadd" id="fproductsadd" class="<?php echo $products_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($products_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $products_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="products">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($products_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($products->cat_id->Visible) { // cat_id ?>
	<div id="r_cat_id" class="form-group">
		<label id="elh_products_cat_id" for="x_cat_id" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->cat_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->cat_id->CellAttributes() ?>>
<span id="el_products_cat_id">
<input type="text" data-table="products" data-field="x_cat_id" name="x_cat_id" id="x_cat_id" size="30" placeholder="<?php echo ew_HtmlEncode($products->cat_id->getPlaceHolder()) ?>" value="<?php echo $products->cat_id->EditValue ?>"<?php echo $products->cat_id->EditAttributes() ?>>
</span>
<?php echo $products->cat_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->company_id->Visible) { // company_id ?>
	<div id="r_company_id" class="form-group">
		<label id="elh_products_company_id" for="x_company_id" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->company_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->company_id->CellAttributes() ?>>
<span id="el_products_company_id">
<input type="text" data-table="products" data-field="x_company_id" name="x_company_id" id="x_company_id" size="30" placeholder="<?php echo ew_HtmlEncode($products->company_id->getPlaceHolder()) ?>" value="<?php echo $products->company_id->EditValue ?>"<?php echo $products->company_id->EditAttributes() ?>>
</span>
<?php echo $products->company_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->pro_name->Visible) { // pro_name ?>
	<div id="r_pro_name" class="form-group">
		<label id="elh_products_pro_name" for="x_pro_name" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->pro_name->FldCaption() ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->pro_name->CellAttributes() ?>>
<span id="el_products_pro_name">
<input type="text" data-table="products" data-field="x_pro_name" name="x_pro_name" id="x_pro_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->pro_name->getPlaceHolder()) ?>" value="<?php echo $products->pro_name->EditValue ?>"<?php echo $products->pro_name->EditAttributes() ?>>
</span>
<?php echo $products->pro_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->pro_description->Visible) { // pro_description ?>
	<div id="r_pro_description" class="form-group">
		<label id="elh_products_pro_description" for="x_pro_description" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->pro_description->FldCaption() ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->pro_description->CellAttributes() ?>>
<span id="el_products_pro_description">
<textarea data-table="products" data-field="x_pro_description" name="x_pro_description" id="x_pro_description" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($products->pro_description->getPlaceHolder()) ?>"<?php echo $products->pro_description->EditAttributes() ?>><?php echo $products->pro_description->EditValue ?></textarea>
</span>
<?php echo $products->pro_description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->pro_condition->Visible) { // pro_condition ?>
	<div id="r_pro_condition" class="form-group">
		<label id="elh_products_pro_condition" for="x_pro_condition" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->pro_condition->FldCaption() ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->pro_condition->CellAttributes() ?>>
<span id="el_products_pro_condition">
<input type="text" data-table="products" data-field="x_pro_condition" name="x_pro_condition" id="x_pro_condition" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->pro_condition->getPlaceHolder()) ?>" value="<?php echo $products->pro_condition->EditValue ?>"<?php echo $products->pro_condition->EditAttributes() ?>>
</span>
<?php echo $products->pro_condition->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->pro_brand->Visible) { // pro_brand ?>
	<div id="r_pro_brand" class="form-group">
		<label id="elh_products_pro_brand" for="x_pro_brand" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->pro_brand->FldCaption() ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->pro_brand->CellAttributes() ?>>
<span id="el_products_pro_brand">
<input type="text" data-table="products" data-field="x_pro_brand" name="x_pro_brand" id="x_pro_brand" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->pro_brand->getPlaceHolder()) ?>" value="<?php echo $products->pro_brand->EditValue ?>"<?php echo $products->pro_brand->EditAttributes() ?>>
</span>
<?php echo $products->pro_brand->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->pro_features->Visible) { // pro_features ?>
	<div id="r_pro_features" class="form-group">
		<label id="elh_products_pro_features" for="x_pro_features" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->pro_features->FldCaption() ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->pro_features->CellAttributes() ?>>
<span id="el_products_pro_features">
<input type="text" data-table="products" data-field="x_pro_features" name="x_pro_features" id="x_pro_features" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->pro_features->getPlaceHolder()) ?>" value="<?php echo $products->pro_features->EditValue ?>"<?php echo $products->pro_features->EditAttributes() ?>>
</span>
<?php echo $products->pro_features->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->pro_model->Visible) { // pro_model ?>
	<div id="r_pro_model" class="form-group">
		<label id="elh_products_pro_model" for="x_pro_model" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->pro_model->FldCaption() ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->pro_model->CellAttributes() ?>>
<span id="el_products_pro_model">
<input type="text" data-table="products" data-field="x_pro_model" name="x_pro_model" id="x_pro_model" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->pro_model->getPlaceHolder()) ?>" value="<?php echo $products->pro_model->EditValue ?>"<?php echo $products->pro_model->EditAttributes() ?>>
</span>
<?php echo $products->pro_model->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->post_date->Visible) { // post_date ?>
	<div id="r_post_date" class="form-group">
		<label id="elh_products_post_date" for="x_post_date" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->post_date->FldCaption() ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->post_date->CellAttributes() ?>>
<span id="el_products_post_date">
<input type="text" data-table="products" data-field="x_post_date" name="x_post_date" id="x_post_date" placeholder="<?php echo ew_HtmlEncode($products->post_date->getPlaceHolder()) ?>" value="<?php echo $products->post_date->EditValue ?>"<?php echo $products->post_date->EditAttributes() ?>>
</span>
<?php echo $products->post_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->ads_id->Visible) { // ads_id ?>
	<div id="r_ads_id" class="form-group">
		<label id="elh_products_ads_id" for="x_ads_id" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->ads_id->FldCaption() ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->ads_id->CellAttributes() ?>>
<span id="el_products_ads_id">
<input type="text" data-table="products" data-field="x_ads_id" name="x_ads_id" id="x_ads_id" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->ads_id->getPlaceHolder()) ?>" value="<?php echo $products->ads_id->EditValue ?>"<?php echo $products->ads_id->EditAttributes() ?>>
</span>
<?php echo $products->ads_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->pro_base_price->Visible) { // pro_base_price ?>
	<div id="r_pro_base_price" class="form-group">
		<label id="elh_products_pro_base_price" for="x_pro_base_price" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->pro_base_price->FldCaption() ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->pro_base_price->CellAttributes() ?>>
<span id="el_products_pro_base_price">
<input type="text" data-table="products" data-field="x_pro_base_price" name="x_pro_base_price" id="x_pro_base_price" size="30" placeholder="<?php echo ew_HtmlEncode($products->pro_base_price->getPlaceHolder()) ?>" value="<?php echo $products->pro_base_price->EditValue ?>"<?php echo $products->pro_base_price->EditAttributes() ?>>
</span>
<?php echo $products->pro_base_price->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->pro_sell_price->Visible) { // pro_sell_price ?>
	<div id="r_pro_sell_price" class="form-group">
		<label id="elh_products_pro_sell_price" for="x_pro_sell_price" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->pro_sell_price->FldCaption() ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->pro_sell_price->CellAttributes() ?>>
<span id="el_products_pro_sell_price">
<input type="text" data-table="products" data-field="x_pro_sell_price" name="x_pro_sell_price" id="x_pro_sell_price" size="30" placeholder="<?php echo ew_HtmlEncode($products->pro_sell_price->getPlaceHolder()) ?>" value="<?php echo $products->pro_sell_price->EditValue ?>"<?php echo $products->pro_sell_price->EditAttributes() ?>>
</span>
<?php echo $products->pro_sell_price->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->featured_image->Visible) { // featured_image ?>
	<div id="r_featured_image" class="form-group">
		<label id="elh_products_featured_image" for="x_featured_image" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->featured_image->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->featured_image->CellAttributes() ?>>
<span id="el_products_featured_image">
<input type="text" data-table="products" data-field="x_featured_image" name="x_featured_image" id="x_featured_image" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->featured_image->getPlaceHolder()) ?>" value="<?php echo $products->featured_image->EditValue ?>"<?php echo $products->featured_image->EditAttributes() ?>>
</span>
<?php echo $products->featured_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->folder_image->Visible) { // folder_image ?>
	<div id="r_folder_image" class="form-group">
		<label id="elh_products_folder_image" for="x_folder_image" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->folder_image->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->folder_image->CellAttributes() ?>>
<span id="el_products_folder_image">
<input type="text" data-table="products" data-field="x_folder_image" name="x_folder_image" id="x_folder_image" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->folder_image->getPlaceHolder()) ?>" value="<?php echo $products->folder_image->EditValue ?>"<?php echo $products->folder_image->EditAttributes() ?>>
</span>
<?php echo $products->folder_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->img1->Visible) { // img1 ?>
	<div id="r_img1" class="form-group">
		<label id="elh_products_img1" for="x_img1" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->img1->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->img1->CellAttributes() ?>>
<span id="el_products_img1">
<input type="text" data-table="products" data-field="x_img1" name="x_img1" id="x_img1" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->img1->getPlaceHolder()) ?>" value="<?php echo $products->img1->EditValue ?>"<?php echo $products->img1->EditAttributes() ?>>
</span>
<?php echo $products->img1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->img2->Visible) { // img2 ?>
	<div id="r_img2" class="form-group">
		<label id="elh_products_img2" for="x_img2" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->img2->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->img2->CellAttributes() ?>>
<span id="el_products_img2">
<input type="text" data-table="products" data-field="x_img2" name="x_img2" id="x_img2" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->img2->getPlaceHolder()) ?>" value="<?php echo $products->img2->EditValue ?>"<?php echo $products->img2->EditAttributes() ?>>
</span>
<?php echo $products->img2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->img3->Visible) { // img3 ?>
	<div id="r_img3" class="form-group">
		<label id="elh_products_img3" for="x_img3" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->img3->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->img3->CellAttributes() ?>>
<span id="el_products_img3">
<input type="text" data-table="products" data-field="x_img3" name="x_img3" id="x_img3" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->img3->getPlaceHolder()) ?>" value="<?php echo $products->img3->EditValue ?>"<?php echo $products->img3->EditAttributes() ?>>
</span>
<?php echo $products->img3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->img4->Visible) { // img4 ?>
	<div id="r_img4" class="form-group">
		<label id="elh_products_img4" for="x_img4" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->img4->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->img4->CellAttributes() ?>>
<span id="el_products_img4">
<input type="text" data-table="products" data-field="x_img4" name="x_img4" id="x_img4" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->img4->getPlaceHolder()) ?>" value="<?php echo $products->img4->EditValue ?>"<?php echo $products->img4->EditAttributes() ?>>
</span>
<?php echo $products->img4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->img5->Visible) { // img5 ?>
	<div id="r_img5" class="form-group">
		<label id="elh_products_img5" for="x_img5" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->img5->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->img5->CellAttributes() ?>>
<span id="el_products_img5">
<input type="text" data-table="products" data-field="x_img5" name="x_img5" id="x_img5" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->img5->getPlaceHolder()) ?>" value="<?php echo $products->img5->EditValue ?>"<?php echo $products->img5->EditAttributes() ?>>
</span>
<?php echo $products->img5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($products->pro_status->Visible) { // pro_status ?>
	<div id="r_pro_status" class="form-group">
		<label id="elh_products_pro_status" class="<?php echo $products_add->LeftColumnClass ?>"><?php echo $products->pro_status->FldCaption() ?></label>
		<div class="<?php echo $products_add->RightColumnClass ?>"><div<?php echo $products->pro_status->CellAttributes() ?>>
<span id="el_products_pro_status">
<?php
$selwrk = (ew_ConvertToBool($products->pro_status->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="products" data-field="x_pro_status" name="x_pro_status[]" id="x_pro_status[]" value="1"<?php echo $selwrk ?><?php echo $products->pro_status->EditAttributes() ?>>
</span>
<?php echo $products->pro_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$products_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $products_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $products_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fproductsadd.Init();
</script>
<?php
$products_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$products_add->Page_Terminate();
?>

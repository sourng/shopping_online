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

$products_addopt = NULL; // Initialize page object first

class cproducts_addopt extends cproducts {

	// Page ID
	var $PageID = 'addopt';

	// Project ID
	var $ProjectID = '{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}';

	// Table name
	var $TableName = 'products';

	// Page object name
	var $PageObjName = 'products_addopt';

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
			define("EW_PAGE_ID", 'addopt', TRUE);

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
		$this->pro_model->SetVisibility();
		$this->pro_name->SetVisibility();
		$this->pro_description->SetVisibility();
		$this->pro_condition->SetVisibility();
		$this->pro_features->SetVisibility();
		$this->post_date->SetVisibility();
		$this->ads_id->SetVisibility();
		$this->pro_base_price->SetVisibility();
		$this->pro_sell_price->SetVisibility();
		$this->featured_image->SetVisibility();
		$this->folder_image->SetVisibility();
		$this->pro_status->SetVisibility();
		$this->branch_id->SetVisibility();
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
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		set_error_handler("ew_ErrorHandler");

		// Set up Breadcrumb
		//$this->SetupBreadcrumb(); // Not used

		$this->LoadRowValues(); // Load default values

		// Process form if post back
		if ($objForm->GetValue("a_addopt") <> "") {
			$this->CurrentAction = $objForm->GetValue("a_addopt"); // Get form action
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back
			$this->CurrentAction = "I"; // Display blank record
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow()) { // Add successful
					$row = array();
					$row["x_product_id"] = $this->product_id->DbValue;
					$row["x_cat_id"] = $this->cat_id->DbValue;
					$row["x_company_id"] = $this->company_id->DbValue;
					$row["x_pro_model"] = $this->pro_model->DbValue;
					$row["x_pro_name"] = ew_ConvertToUtf8($this->pro_name->DbValue);
					$row["x_pro_description"] = ew_ConvertToUtf8($this->pro_description->DbValue);
					$row["x_pro_condition"] = ew_ConvertToUtf8($this->pro_condition->DbValue);
					$row["x_pro_features"] = ew_ConvertToUtf8($this->pro_features->DbValue);
					$row["x_post_date"] = $this->post_date->DbValue;
					$row["x_ads_id"] = ew_ConvertToUtf8($this->ads_id->DbValue);
					$row["x_pro_base_price"] = $this->pro_base_price->DbValue;
					$row["x_pro_sell_price"] = $this->pro_sell_price->DbValue;
					$row["x_featured_image"] = ew_ConvertToUtf8($this->featured_image->DbValue);
					$row["x_folder_image"] = ew_ConvertToUtf8($this->folder_image->DbValue);
					$row["x_pro_status"] = ew_ConvertToUtf8($this->pro_status->DbValue);
					$row["x_branch_id"] = ew_ConvertToUtf8($this->branch_id->DbValue);
					$row["x_lang"] = ew_ConvertToUtf8($this->lang->DbValue);
					if (!EW_DEBUG_ENABLED && ob_get_length())
						ob_end_clean();
					ew_Header(FALSE, "utf-8", TRUE);
					echo ew_ArrayToJson(array($row));
				} else {
					$this->ShowMessage();
				}
				$this->Page_Terminate();
				exit();
		}

		// Render row
		$this->RowType = EW_ROWTYPE_ADD; // Render add type
		$this->ResetAttrs();
		$this->RenderRow();
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
		$this->featured_image->CurrentValue = NULL; // Clear file related field
		$this->folder_image->CurrentValue = NULL;
		$this->folder_image->OldValue = $this->folder_image->CurrentValue;
		$this->pro_status->CurrentValue = NULL;
		$this->pro_status->OldValue = $this->pro_status->CurrentValue;
		$this->branch_id->CurrentValue = NULL;
		$this->branch_id->OldValue = $this->branch_id->CurrentValue;
		$this->lang->CurrentValue = "english";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->cat_id->FldIsDetailKey) {
			$this->cat_id->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_cat_id")));
		}
		if (!$this->company_id->FldIsDetailKey) {
			$this->company_id->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_company_id")));
		}
		if (!$this->pro_model->FldIsDetailKey) {
			$this->pro_model->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_pro_model")));
		}
		if (!$this->pro_name->FldIsDetailKey) {
			$this->pro_name->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_pro_name")));
		}
		if (!$this->pro_description->FldIsDetailKey) {
			$this->pro_description->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_pro_description")));
		}
		if (!$this->pro_condition->FldIsDetailKey) {
			$this->pro_condition->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_pro_condition")));
		}
		if (!$this->pro_features->FldIsDetailKey) {
			$this->pro_features->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_pro_features")));
		}
		if (!$this->post_date->FldIsDetailKey) {
			$this->post_date->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_post_date")));
			$this->post_date->CurrentValue = ew_UnFormatDateTime($this->post_date->CurrentValue, 0);
		}
		if (!$this->ads_id->FldIsDetailKey) {
			$this->ads_id->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_ads_id")));
		}
		if (!$this->pro_base_price->FldIsDetailKey) {
			$this->pro_base_price->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_pro_base_price")));
		}
		if (!$this->pro_sell_price->FldIsDetailKey) {
			$this->pro_sell_price->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_pro_sell_price")));
		}
		if (!$this->folder_image->FldIsDetailKey) {
			$this->folder_image->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_folder_image")));
		}
		if (!$this->pro_status->FldIsDetailKey) {
			$this->pro_status->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_pro_status")));
		}
		if (!$this->branch_id->FldIsDetailKey) {
			$this->branch_id->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_branch_id")));
		}
		if (!$this->lang->FldIsDetailKey) {
			$this->lang->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_lang")));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->cat_id->CurrentValue = ew_ConvertToUtf8($this->cat_id->FormValue);
		$this->company_id->CurrentValue = ew_ConvertToUtf8($this->company_id->FormValue);
		$this->pro_model->CurrentValue = ew_ConvertToUtf8($this->pro_model->FormValue);
		$this->pro_name->CurrentValue = ew_ConvertToUtf8($this->pro_name->FormValue);
		$this->pro_description->CurrentValue = ew_ConvertToUtf8($this->pro_description->FormValue);
		$this->pro_condition->CurrentValue = ew_ConvertToUtf8($this->pro_condition->FormValue);
		$this->pro_features->CurrentValue = ew_ConvertToUtf8($this->pro_features->FormValue);
		$this->post_date->CurrentValue = ew_ConvertToUtf8($this->post_date->FormValue);
		$this->post_date->CurrentValue = ew_UnFormatDateTime($this->post_date->CurrentValue, 0);
		$this->ads_id->CurrentValue = ew_ConvertToUtf8($this->ads_id->FormValue);
		$this->pro_base_price->CurrentValue = ew_ConvertToUtf8($this->pro_base_price->FormValue);
		$this->pro_sell_price->CurrentValue = ew_ConvertToUtf8($this->pro_sell_price->FormValue);
		$this->folder_image->CurrentValue = ew_ConvertToUtf8($this->folder_image->FormValue);
		$this->pro_status->CurrentValue = ew_ConvertToUtf8($this->pro_status->FormValue);
		$this->branch_id->CurrentValue = ew_ConvertToUtf8($this->branch_id->FormValue);
		$this->lang->CurrentValue = ew_ConvertToUtf8($this->lang->FormValue);
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
		$this->pro_status->setDbValue($row['pro_status']);
		$this->branch_id->setDbValue($row['branch_id']);
		$this->lang->setDbValue($row['lang']);
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

		// pro_description
		$this->pro_description->ViewValue = $this->pro_description->CurrentValue;
		$this->pro_description->ViewCustomAttributes = "";

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
		if (strval($this->folder_image->CurrentValue) <> "") {
			$arwrk = explode(",", $this->folder_image->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`pro_gallery_id`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT `pro_gallery_id`, `image` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `product_gallery`";
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

			// cat_id
			$this->cat_id->LinkCustomAttributes = "";
			$this->cat_id->HrefValue = "";
			$this->cat_id->TooltipValue = "";

			// company_id
			$this->company_id->LinkCustomAttributes = "";
			$this->company_id->HrefValue = "";
			$this->company_id->TooltipValue = "";

			// pro_model
			$this->pro_model->LinkCustomAttributes = "";
			$this->pro_model->HrefValue = "";
			$this->pro_model->TooltipValue = "";

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

			// pro_features
			$this->pro_features->LinkCustomAttributes = "";
			$this->pro_features->HrefValue = "";
			$this->pro_features->TooltipValue = "";

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
				$this->featured_image->LinkAttrs["data-rel"] = "products_x_featured_image";
				ew_AppendClass($this->featured_image->LinkAttrs["class"], "ewLightbox");
			}

			// folder_image
			$this->folder_image->LinkCustomAttributes = "";
			$this->folder_image->HrefValue = "";
			$this->folder_image->TooltipValue = "";

			// pro_status
			$this->pro_status->LinkCustomAttributes = "";
			$this->pro_status->HrefValue = "";
			$this->pro_status->TooltipValue = "";

			// branch_id
			$this->branch_id->LinkCustomAttributes = "";
			$this->branch_id->HrefValue = "";
			$this->branch_id->TooltipValue = "";

			// lang
			$this->lang->LinkCustomAttributes = "";
			$this->lang->HrefValue = "";
			$this->lang->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// pro_model
			$this->pro_model->EditCustomAttributes = "";
			if (trim(strval($this->pro_model->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`model_id`" . ew_SearchString("=", $this->pro_model->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `model_id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `model`";
			$sWhereWrk = "";
			$this->pro_model->LookupFilters = array("dx1" => '`name`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pro_model, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->pro_model->ViewValue = $this->pro_model->DisplayValue($arwrk);
			} else {
				$this->pro_model->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pro_model->EditValue = $arwrk;

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
			$this->pro_condition->EditValue = $this->pro_condition->Options(TRUE);

			// pro_features
			$this->pro_features->EditAttrs["class"] = "form-control";
			$this->pro_features->EditCustomAttributes = "";
			$this->pro_features->EditValue = ew_HtmlEncode($this->pro_features->CurrentValue);
			$this->pro_features->PlaceHolder = ew_RemoveHtml($this->pro_features->FldCaption());

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
					$this->featured_image->Upload->FileName = $this->featured_image->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->featured_image);

			// folder_image
			$this->folder_image->EditCustomAttributes = "";
			if (trim(strval($this->folder_image->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$arwrk = explode(",", $this->folder_image->CurrentValue);
				$sFilterWrk = "";
				foreach ($arwrk as $wrk) {
					if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
					$sFilterWrk .= "`pro_gallery_id`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
				}
			}
			$sSqlWrk = "SELECT `pro_gallery_id`, `image` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `product_gallery`";
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->folder_image->ViewValue .= $this->folder_image->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->folder_image->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->MoveFirst();
			} else {
				$this->folder_image->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->folder_image->EditValue = $arwrk;

			// pro_status
			$this->pro_status->EditCustomAttributes = "";
			$this->pro_status->EditValue = $this->pro_status->Options(FALSE);

			// branch_id
			$this->branch_id->EditCustomAttributes = "";
			if (trim(strval($this->branch_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`branch_id`" . ew_SearchString("=", $this->branch_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `branch_id`, `branch_id` AS `DispFld`, `name` AS `Disp2Fld`, `image` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `branch`";
			$sWhereWrk = "";
			$this->branch_id->LookupFilters = array("dx1" => '`branch_id`', "dx2" => '`name`', "dx3" => '`image`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->branch_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$arwrk[3] = ew_HtmlEncode($rswrk->fields('Disp3Fld'));
				$this->branch_id->ViewValue = $this->branch_id->DisplayValue($arwrk);
			} else {
				$this->branch_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->branch_id->EditValue = $arwrk;

			// lang
			$this->lang->EditCustomAttributes = "";
			$this->lang->EditValue = $this->lang->Options(TRUE);

			// Add refer script
			// cat_id

			$this->cat_id->LinkCustomAttributes = "";
			$this->cat_id->HrefValue = "";

			// company_id
			$this->company_id->LinkCustomAttributes = "";
			$this->company_id->HrefValue = "";

			// pro_model
			$this->pro_model->LinkCustomAttributes = "";
			$this->pro_model->HrefValue = "";

			// pro_name
			$this->pro_name->LinkCustomAttributes = "";
			$this->pro_name->HrefValue = "";

			// pro_description
			$this->pro_description->LinkCustomAttributes = "";
			$this->pro_description->HrefValue = "";

			// pro_condition
			$this->pro_condition->LinkCustomAttributes = "";
			$this->pro_condition->HrefValue = "";

			// pro_features
			$this->pro_features->LinkCustomAttributes = "";
			$this->pro_features->HrefValue = "";

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
			$this->featured_image->UploadPath = "../uploads/product/";
			if (!ew_Empty($this->featured_image->Upload->DbValue)) {
				$this->featured_image->HrefValue = ew_GetFileUploadUrl($this->featured_image, $this->featured_image->Upload->DbValue); // Add prefix/suffix
				$this->featured_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->featured_image->HrefValue = ew_FullUrl($this->featured_image->HrefValue, "href");
			} else {
				$this->featured_image->HrefValue = "";
			}
			$this->featured_image->HrefValue2 = $this->featured_image->UploadPath . $this->featured_image->Upload->DbValue;

			// folder_image
			$this->folder_image->LinkCustomAttributes = "";
			$this->folder_image->HrefValue = "";

			// pro_status
			$this->pro_status->LinkCustomAttributes = "";
			$this->pro_status->HrefValue = "";

			// branch_id
			$this->branch_id->LinkCustomAttributes = "";
			$this->branch_id->HrefValue = "";

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
		if (!ew_CheckDateDef($this->post_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->post_date->FldErrMsg());
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
		if ($this->folder_image->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->folder_image->FldCaption(), $this->folder_image->ReqErrMsg));
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
			$this->featured_image->OldUploadPath = "../uploads/product/";
			$this->featured_image->UploadPath = $this->featured_image->OldUploadPath;
		}
		$rsnew = array();

		// cat_id
		$this->cat_id->SetDbValueDef($rsnew, $this->cat_id->CurrentValue, 0, FALSE);

		// company_id
		$this->company_id->SetDbValueDef($rsnew, $this->company_id->CurrentValue, 0, FALSE);

		// pro_model
		$this->pro_model->SetDbValueDef($rsnew, $this->pro_model->CurrentValue, NULL, FALSE);

		// pro_name
		$this->pro_name->SetDbValueDef($rsnew, $this->pro_name->CurrentValue, NULL, FALSE);

		// pro_description
		$this->pro_description->SetDbValueDef($rsnew, $this->pro_description->CurrentValue, NULL, FALSE);

		// pro_condition
		$this->pro_condition->SetDbValueDef($rsnew, $this->pro_condition->CurrentValue, NULL, FALSE);

		// pro_features
		$this->pro_features->SetDbValueDef($rsnew, $this->pro_features->CurrentValue, NULL, FALSE);

		// post_date
		$this->post_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->post_date->CurrentValue, 0), NULL, FALSE);

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

		// folder_image
		$this->folder_image->SetDbValueDef($rsnew, $this->folder_image->CurrentValue, "", FALSE);

		// pro_status
		$tmpBool = $this->pro_status->CurrentValue;
		if ($tmpBool <> "Y" && $tmpBool <> "N")
			$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
		$this->pro_status->SetDbValueDef($rsnew, $tmpBool, "N", FALSE);

		// branch_id
		$this->branch_id->SetDbValueDef($rsnew, $this->branch_id->CurrentValue, NULL, FALSE);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("productslist.php"), "", $this->TableVar, TRUE);
		$PageId = "addopt";
		$Breadcrumb->Add("addopt", $PageId, $url);
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
		case "x_pro_model":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `model_id` AS `LinkFld`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`name`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`model_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->pro_model, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_folder_image":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `pro_gallery_id` AS `LinkFld`, `image` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `product_gallery`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`image`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`pro_gallery_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->folder_image, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_branch_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `branch_id` AS `LinkFld`, `branch_id` AS `DispFld`, `name` AS `Disp2Fld`, `image` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `branch`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`branch_id`', "dx2" => '`name`', "dx3" => '`image`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`branch_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->branch_id, $sWhereWrk); // Call Lookup Selecting
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

	// Custom validate event
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
if (!isset($products_addopt)) $products_addopt = new cproducts_addopt();

// Page init
$products_addopt->Page_Init();

// Page main
$products_addopt->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$products_addopt->Page_Render();
?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "addopt";
var CurrentForm = fproductsaddopt = new ew_Form("fproductsaddopt", "addopt");

// Validate form
fproductsaddopt.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_company_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->company_id->FldCaption(), $products->company_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_post_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($products->post_date->FldErrMsg()) ?>");
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
			elm = this.GetElements("x" + infix + "_folder_image[]");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $products->folder_image->FldCaption(), $products->folder_image->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fproductsaddopt.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fproductsaddopt.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fproductsaddopt.Lists["x_cat_id"] = {"LinkField":"x_cat_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_cat_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"categories"};
fproductsaddopt.Lists["x_cat_id"].Data = "<?php echo $products_addopt->cat_id->LookupFilterQuery(FALSE, "addopt") ?>";
fproductsaddopt.Lists["x_company_id"] = {"LinkField":"x_company_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_com_fname","x_com_lname","x_com_name",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"company"};
fproductsaddopt.Lists["x_company_id"].Data = "<?php echo $products_addopt->company_id->LookupFilterQuery(FALSE, "addopt") ?>";
fproductsaddopt.Lists["x_pro_model"] = {"LinkField":"x_model_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"model"};
fproductsaddopt.Lists["x_pro_model"].Data = "<?php echo $products_addopt->pro_model->LookupFilterQuery(FALSE, "addopt") ?>";
fproductsaddopt.Lists["x_pro_condition"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fproductsaddopt.Lists["x_pro_condition"].Options = <?php echo json_encode($products_addopt->pro_condition->Options()) ?>;
fproductsaddopt.Lists["x_folder_image[]"] = {"LinkField":"x_pro_gallery_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_image","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"product_gallery"};
fproductsaddopt.Lists["x_folder_image[]"].Data = "<?php echo $products_addopt->folder_image->LookupFilterQuery(FALSE, "addopt") ?>";
fproductsaddopt.Lists["x_pro_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fproductsaddopt.Lists["x_pro_status[]"].Options = <?php echo json_encode($products_addopt->pro_status->Options()) ?>;
fproductsaddopt.Lists["x_branch_id"] = {"LinkField":"x_branch_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_branch_id","x_name","x_image",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"branch"};
fproductsaddopt.Lists["x_branch_id"].Data = "<?php echo $products_addopt->branch_id->LookupFilterQuery(FALSE, "addopt") ?>";
fproductsaddopt.Lists["x_lang"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fproductsaddopt.Lists["x_lang"].Options = <?php echo json_encode($products_addopt->lang->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php
$products_addopt->ShowMessage();
?>
<form name="fproductsaddopt" id="fproductsaddopt" class="ewForm form-horizontal" action="productsaddopt.php" method="post">
<?php if ($products_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $products_addopt->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="products">
<input type="hidden" name="a_addopt" id="a_addopt" value="A">
<?php if ($products->cat_id->Visible) { // cat_id ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_cat_id"><?php echo $products->cat_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_cat_id"><?php echo (strval($products->cat_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->cat_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->cat_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_cat_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->cat_id->ReadOnly || $products->cat_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_cat_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $products->cat_id->DisplayValueSeparatorAttribute() ?>" name="x_cat_id" id="x_cat_id" value="<?php echo $products->cat_id->CurrentValue ?>"<?php echo $products->cat_id->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($products->company_id->Visible) { // company_id ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_company_id"><?php echo $products->company_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_company_id"><?php echo (strval($products->company_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->company_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->company_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_company_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->company_id->ReadOnly || $products->company_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_company_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $products->company_id->DisplayValueSeparatorAttribute() ?>" name="x_company_id" id="x_company_id" value="<?php echo $products->company_id->CurrentValue ?>"<?php echo $products->company_id->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($products->pro_model->Visible) { // pro_model ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_pro_model"><?php echo $products->pro_model->FldCaption() ?></label>
		<div class="col-sm-10">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_pro_model"><?php echo (strval($products->pro_model->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->pro_model->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->pro_model->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_pro_model',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->pro_model->ReadOnly || $products->pro_model->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_pro_model" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $products->pro_model->DisplayValueSeparatorAttribute() ?>" name="x_pro_model" id="x_pro_model" value="<?php echo $products->pro_model->CurrentValue ?>"<?php echo $products->pro_model->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($products->pro_name->Visible) { // pro_name ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_pro_name"><?php echo $products->pro_name->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="products" data-field="x_pro_name" name="x_pro_name" id="x_pro_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->pro_name->getPlaceHolder()) ?>" value="<?php echo $products->pro_name->EditValue ?>"<?php echo $products->pro_name->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($products->pro_description->Visible) { // pro_description ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel"><?php echo $products->pro_description->FldCaption() ?></label>
		<div class="col-sm-10">
<?php ew_AppendClass($products->pro_description->EditAttrs["class"], "editor"); ?>
<textarea data-table="products" data-field="x_pro_description" name="x_pro_description" id="x_pro_description" cols="45" rows="4" placeholder="<?php echo ew_HtmlEncode($products->pro_description->getPlaceHolder()) ?>"<?php echo $products->pro_description->EditAttributes() ?>><?php echo $products->pro_description->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fproductsaddopt", "x_pro_description", 45, 4, <?php echo ($products->pro_description->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</div>
	</div>
<?php } ?>
<?php if ($products->pro_condition->Visible) { // pro_condition ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_pro_condition"><?php echo $products->pro_condition->FldCaption() ?></label>
		<div class="col-sm-10">
<select data-table="products" data-field="x_pro_condition" data-value-separator="<?php echo $products->pro_condition->DisplayValueSeparatorAttribute() ?>" id="x_pro_condition" name="x_pro_condition"<?php echo $products->pro_condition->EditAttributes() ?>>
<?php echo $products->pro_condition->SelectOptionListHtml("x_pro_condition") ?>
</select>
</div>
	</div>
<?php } ?>
<?php if ($products->pro_features->Visible) { // pro_features ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_pro_features"><?php echo $products->pro_features->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="products" data-field="x_pro_features" name="x_pro_features" id="x_pro_features" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->pro_features->getPlaceHolder()) ?>" value="<?php echo $products->pro_features->EditValue ?>"<?php echo $products->pro_features->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($products->post_date->Visible) { // post_date ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_post_date"><?php echo $products->post_date->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="products" data-field="x_post_date" name="x_post_date" id="x_post_date" placeholder="<?php echo ew_HtmlEncode($products->post_date->getPlaceHolder()) ?>" value="<?php echo $products->post_date->EditValue ?>"<?php echo $products->post_date->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($products->ads_id->Visible) { // ads_id ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_ads_id"><?php echo $products->ads_id->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="products" data-field="x_ads_id" name="x_ads_id" id="x_ads_id" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($products->ads_id->getPlaceHolder()) ?>" value="<?php echo $products->ads_id->EditValue ?>"<?php echo $products->ads_id->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($products->pro_base_price->Visible) { // pro_base_price ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_pro_base_price"><?php echo $products->pro_base_price->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="products" data-field="x_pro_base_price" name="x_pro_base_price" id="x_pro_base_price" size="30" placeholder="<?php echo ew_HtmlEncode($products->pro_base_price->getPlaceHolder()) ?>" value="<?php echo $products->pro_base_price->EditValue ?>"<?php echo $products->pro_base_price->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($products->pro_sell_price->Visible) { // pro_sell_price ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_pro_sell_price"><?php echo $products->pro_sell_price->FldCaption() ?></label>
		<div class="col-sm-10">
<input type="text" data-table="products" data-field="x_pro_sell_price" name="x_pro_sell_price" id="x_pro_sell_price" size="30" placeholder="<?php echo ew_HtmlEncode($products->pro_sell_price->getPlaceHolder()) ?>" value="<?php echo $products->pro_sell_price->EditValue ?>"<?php echo $products->pro_sell_price->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($products->featured_image->Visible) { // featured_image ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel"><?php echo $products->featured_image->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10">
<div id="fd_x_featured_image">
<span title="<?php echo $products->featured_image->FldTitle() ? $products->featured_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($products->featured_image->ReadOnly || $products->featured_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="products" data-field="x_featured_image" name="x_featured_image" id="x_featured_image"<?php echo $products->featured_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_featured_image" id= "fn_x_featured_image" value="<?php echo $products->featured_image->Upload->FileName ?>">
<input type="hidden" name="fa_x_featured_image" id= "fa_x_featured_image" value="0">
<input type="hidden" name="fs_x_featured_image" id= "fs_x_featured_image" value="250">
<input type="hidden" name="fx_x_featured_image" id= "fx_x_featured_image" value="<?php echo $products->featured_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_featured_image" id= "fm_x_featured_image" value="<?php echo $products->featured_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_featured_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</div>
	</div>
<?php } ?>
<?php if ($products->folder_image->Visible) { // folder_image ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_folder_image"><?php echo $products->folder_image->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_folder_image"><?php echo (strval($products->folder_image->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->folder_image->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->folder_image->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_folder_image[]',m:1,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->folder_image->ReadOnly || $products->folder_image->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_folder_image" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $products->folder_image->DisplayValueSeparatorAttribute() ?>" name="x_folder_image[]" id="x_folder_image[]" value="<?php echo $products->folder_image->CurrentValue ?>"<?php echo $products->folder_image->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($products->pro_status->Visible) { // pro_status ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel"><?php echo $products->pro_status->FldCaption() ?></label>
		<div class="col-sm-10">
<?php
$selwrk = (ew_ConvertToBool($products->pro_status->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="products" data-field="x_pro_status" name="x_pro_status[]" id="x_pro_status[]" value="1"<?php echo $selwrk ?><?php echo $products->pro_status->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($products->branch_id->Visible) { // branch_id ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_branch_id"><?php echo $products->branch_id->FldCaption() ?></label>
		<div class="col-sm-10">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_branch_id"><?php echo (strval($products->branch_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $products->branch_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($products->branch_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_branch_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($products->branch_id->ReadOnly || $products->branch_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="products" data-field="x_branch_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $products->branch_id->DisplayValueSeparatorAttribute() ?>" name="x_branch_id" id="x_branch_id" value="<?php echo $products->branch_id->CurrentValue ?>"<?php echo $products->branch_id->EditAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($products->lang->Visible) { // lang ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="x_lang"><?php echo $products->lang->FldCaption() ?></label>
		<div class="col-sm-10">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($products->lang->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $products->lang->ViewValue ?>
	</span>
	<?php if (!$products->lang->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_lang" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $products->lang->RadioButtonListHtml(TRUE, "x_lang") ?>
		</div>
	</div>
	<div id="tp_x_lang" class="ewTemplate"><input type="radio" data-table="products" data-field="x_lang" data-value-separator="<?php echo $products->lang->DisplayValueSeparatorAttribute() ?>" name="x_lang" id="x_lang" value="{value}"<?php echo $products->lang->EditAttributes() ?>></div>
</div>
</div>
	</div>
<?php } ?>
</form>
<script type="text/javascript">
fproductsaddopt.Init();
</script>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$products_addopt->Page_Terminate();
?>
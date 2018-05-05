<?php include_once "companyinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($product_gallery_grid)) $product_gallery_grid = new cproduct_gallery_grid();

// Page init
$product_gallery_grid->Page_Init();

// Page main
$product_gallery_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$product_gallery_grid->Page_Render();
?>
<?php if ($product_gallery->Export == "") { ?>
<script type="text/javascript">

// Form object
var fproduct_gallerygrid = new ew_Form("fproduct_gallerygrid", "grid");
fproduct_gallerygrid.FormKeyCountName = '<?php echo $product_gallery_grid->FormKeyCountName ?>';

// Validate form
fproduct_gallerygrid.Validate = function() {
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
	return true;
}

// Check empty row
fproduct_gallerygrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "product_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "thumnail", false)) return false;
	if (ew_ValueChanged(fobj, infix, "image", false)) return false;
	return true;
}

// Form_CustomValidate event
fproduct_gallerygrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fproduct_gallerygrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fproduct_gallerygrid.Lists["x_product_id"] = {"LinkField":"x_product_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_pro_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"products"};
fproduct_gallerygrid.Lists["x_product_id"].Data = "<?php echo $product_gallery_grid->product_id->LookupFilterQuery(FALSE, "grid") ?>";

// Form object for search
</script>
<?php } ?>
<?php
if ($product_gallery->CurrentAction == "gridadd") {
	if ($product_gallery->CurrentMode == "copy") {
		$bSelectLimit = $product_gallery_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$product_gallery_grid->TotalRecs = $product_gallery->ListRecordCount();
			$product_gallery_grid->Recordset = $product_gallery_grid->LoadRecordset($product_gallery_grid->StartRec-1, $product_gallery_grid->DisplayRecs);
		} else {
			if ($product_gallery_grid->Recordset = $product_gallery_grid->LoadRecordset())
				$product_gallery_grid->TotalRecs = $product_gallery_grid->Recordset->RecordCount();
		}
		$product_gallery_grid->StartRec = 1;
		$product_gallery_grid->DisplayRecs = $product_gallery_grid->TotalRecs;
	} else {
		$product_gallery->CurrentFilter = "0=1";
		$product_gallery_grid->StartRec = 1;
		$product_gallery_grid->DisplayRecs = $product_gallery->GridAddRowCount;
	}
	$product_gallery_grid->TotalRecs = $product_gallery_grid->DisplayRecs;
	$product_gallery_grid->StopRec = $product_gallery_grid->DisplayRecs;
} else {
	$bSelectLimit = $product_gallery_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($product_gallery_grid->TotalRecs <= 0)
			$product_gallery_grid->TotalRecs = $product_gallery->ListRecordCount();
	} else {
		if (!$product_gallery_grid->Recordset && ($product_gallery_grid->Recordset = $product_gallery_grid->LoadRecordset()))
			$product_gallery_grid->TotalRecs = $product_gallery_grid->Recordset->RecordCount();
	}
	$product_gallery_grid->StartRec = 1;
	$product_gallery_grid->DisplayRecs = $product_gallery_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$product_gallery_grid->Recordset = $product_gallery_grid->LoadRecordset($product_gallery_grid->StartRec-1, $product_gallery_grid->DisplayRecs);

	// Set no record found message
	if ($product_gallery->CurrentAction == "" && $product_gallery_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$product_gallery_grid->setWarningMessage(ew_DeniedMsg());
		if ($product_gallery_grid->SearchWhere == "0=101")
			$product_gallery_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$product_gallery_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$product_gallery_grid->RenderOtherOptions();
?>
<?php $product_gallery_grid->ShowPageHeader(); ?>
<?php
$product_gallery_grid->ShowMessage();
?>
<?php if ($product_gallery_grid->TotalRecs > 0 || $product_gallery->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($product_gallery_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> product_gallery">
<div id="fproduct_gallerygrid" class="ewForm ewListForm form-inline">
<?php if ($product_gallery_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($product_gallery_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_product_gallery" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_product_gallerygrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$product_gallery_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$product_gallery_grid->RenderListOptions();

// Render list options (header, left)
$product_gallery_grid->ListOptions->Render("header", "left");
?>
<?php if ($product_gallery->pro_gallery_id->Visible) { // pro_gallery_id ?>
	<?php if ($product_gallery->SortUrl($product_gallery->pro_gallery_id) == "") { ?>
		<th data-name="pro_gallery_id" class="<?php echo $product_gallery->pro_gallery_id->HeaderCellClass() ?>"><div id="elh_product_gallery_pro_gallery_id" class="product_gallery_pro_gallery_id"><div class="ewTableHeaderCaption"><?php echo $product_gallery->pro_gallery_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pro_gallery_id" class="<?php echo $product_gallery->pro_gallery_id->HeaderCellClass() ?>"><div><div id="elh_product_gallery_pro_gallery_id" class="product_gallery_pro_gallery_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $product_gallery->pro_gallery_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($product_gallery->pro_gallery_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($product_gallery->pro_gallery_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($product_gallery->product_id->Visible) { // product_id ?>
	<?php if ($product_gallery->SortUrl($product_gallery->product_id) == "") { ?>
		<th data-name="product_id" class="<?php echo $product_gallery->product_id->HeaderCellClass() ?>"><div id="elh_product_gallery_product_id" class="product_gallery_product_id"><div class="ewTableHeaderCaption"><?php echo $product_gallery->product_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="product_id" class="<?php echo $product_gallery->product_id->HeaderCellClass() ?>"><div><div id="elh_product_gallery_product_id" class="product_gallery_product_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $product_gallery->product_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($product_gallery->product_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($product_gallery->product_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($product_gallery->thumnail->Visible) { // thumnail ?>
	<?php if ($product_gallery->SortUrl($product_gallery->thumnail) == "") { ?>
		<th data-name="thumnail" class="<?php echo $product_gallery->thumnail->HeaderCellClass() ?>"><div id="elh_product_gallery_thumnail" class="product_gallery_thumnail"><div class="ewTableHeaderCaption"><?php echo $product_gallery->thumnail->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="thumnail" class="<?php echo $product_gallery->thumnail->HeaderCellClass() ?>"><div><div id="elh_product_gallery_thumnail" class="product_gallery_thumnail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $product_gallery->thumnail->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($product_gallery->thumnail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($product_gallery->thumnail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($product_gallery->image->Visible) { // image ?>
	<?php if ($product_gallery->SortUrl($product_gallery->image) == "") { ?>
		<th data-name="image" class="<?php echo $product_gallery->image->HeaderCellClass() ?>"><div id="elh_product_gallery_image" class="product_gallery_image"><div class="ewTableHeaderCaption"><?php echo $product_gallery->image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="image" class="<?php echo $product_gallery->image->HeaderCellClass() ?>"><div><div id="elh_product_gallery_image" class="product_gallery_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $product_gallery->image->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($product_gallery->image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($product_gallery->image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$product_gallery_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$product_gallery_grid->StartRec = 1;
$product_gallery_grid->StopRec = $product_gallery_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($product_gallery_grid->FormKeyCountName) && ($product_gallery->CurrentAction == "gridadd" || $product_gallery->CurrentAction == "gridedit" || $product_gallery->CurrentAction == "F")) {
		$product_gallery_grid->KeyCount = $objForm->GetValue($product_gallery_grid->FormKeyCountName);
		$product_gallery_grid->StopRec = $product_gallery_grid->StartRec + $product_gallery_grid->KeyCount - 1;
	}
}
$product_gallery_grid->RecCnt = $product_gallery_grid->StartRec - 1;
if ($product_gallery_grid->Recordset && !$product_gallery_grid->Recordset->EOF) {
	$product_gallery_grid->Recordset->MoveFirst();
	$bSelectLimit = $product_gallery_grid->UseSelectLimit;
	if (!$bSelectLimit && $product_gallery_grid->StartRec > 1)
		$product_gallery_grid->Recordset->Move($product_gallery_grid->StartRec - 1);
} elseif (!$product_gallery->AllowAddDeleteRow && $product_gallery_grid->StopRec == 0) {
	$product_gallery_grid->StopRec = $product_gallery->GridAddRowCount;
}

// Initialize aggregate
$product_gallery->RowType = EW_ROWTYPE_AGGREGATEINIT;
$product_gallery->ResetAttrs();
$product_gallery_grid->RenderRow();
if ($product_gallery->CurrentAction == "gridadd")
	$product_gallery_grid->RowIndex = 0;
if ($product_gallery->CurrentAction == "gridedit")
	$product_gallery_grid->RowIndex = 0;
while ($product_gallery_grid->RecCnt < $product_gallery_grid->StopRec) {
	$product_gallery_grid->RecCnt++;
	if (intval($product_gallery_grid->RecCnt) >= intval($product_gallery_grid->StartRec)) {
		$product_gallery_grid->RowCnt++;
		if ($product_gallery->CurrentAction == "gridadd" || $product_gallery->CurrentAction == "gridedit" || $product_gallery->CurrentAction == "F") {
			$product_gallery_grid->RowIndex++;
			$objForm->Index = $product_gallery_grid->RowIndex;
			if ($objForm->HasValue($product_gallery_grid->FormActionName))
				$product_gallery_grid->RowAction = strval($objForm->GetValue($product_gallery_grid->FormActionName));
			elseif ($product_gallery->CurrentAction == "gridadd")
				$product_gallery_grid->RowAction = "insert";
			else
				$product_gallery_grid->RowAction = "";
		}

		// Set up key count
		$product_gallery_grid->KeyCount = $product_gallery_grid->RowIndex;

		// Init row class and style
		$product_gallery->ResetAttrs();
		$product_gallery->CssClass = "";
		if ($product_gallery->CurrentAction == "gridadd") {
			if ($product_gallery->CurrentMode == "copy") {
				$product_gallery_grid->LoadRowValues($product_gallery_grid->Recordset); // Load row values
				$product_gallery_grid->SetRecordKey($product_gallery_grid->RowOldKey, $product_gallery_grid->Recordset); // Set old record key
			} else {
				$product_gallery_grid->LoadRowValues(); // Load default values
				$product_gallery_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$product_gallery_grid->LoadRowValues($product_gallery_grid->Recordset); // Load row values
		}
		$product_gallery->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($product_gallery->CurrentAction == "gridadd") // Grid add
			$product_gallery->RowType = EW_ROWTYPE_ADD; // Render add
		if ($product_gallery->CurrentAction == "gridadd" && $product_gallery->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$product_gallery_grid->RestoreCurrentRowFormValues($product_gallery_grid->RowIndex); // Restore form values
		if ($product_gallery->CurrentAction == "gridedit") { // Grid edit
			if ($product_gallery->EventCancelled) {
				$product_gallery_grid->RestoreCurrentRowFormValues($product_gallery_grid->RowIndex); // Restore form values
			}
			if ($product_gallery_grid->RowAction == "insert")
				$product_gallery->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$product_gallery->RowType = EW_ROWTYPE_EDIT; // Render edit
			if (!$product_gallery->EventCancelled)
				$product_gallery_grid->HashValue = $product_gallery_grid->GetRowHash($product_gallery_grid->Recordset); // Get hash value for record
		}
		if ($product_gallery->CurrentAction == "gridedit" && ($product_gallery->RowType == EW_ROWTYPE_EDIT || $product_gallery->RowType == EW_ROWTYPE_ADD) && $product_gallery->EventCancelled) // Update failed
			$product_gallery_grid->RestoreCurrentRowFormValues($product_gallery_grid->RowIndex); // Restore form values
		if ($product_gallery->RowType == EW_ROWTYPE_EDIT) // Edit row
			$product_gallery_grid->EditRowCnt++;
		if ($product_gallery->CurrentAction == "F") // Confirm row
			$product_gallery_grid->RestoreCurrentRowFormValues($product_gallery_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$product_gallery->RowAttrs = array_merge($product_gallery->RowAttrs, array('data-rowindex'=>$product_gallery_grid->RowCnt, 'id'=>'r' . $product_gallery_grid->RowCnt . '_product_gallery', 'data-rowtype'=>$product_gallery->RowType));

		// Render row
		$product_gallery_grid->RenderRow();

		// Render list options
		$product_gallery_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($product_gallery_grid->RowAction <> "delete" && $product_gallery_grid->RowAction <> "insertdelete" && !($product_gallery_grid->RowAction == "insert" && $product_gallery->CurrentAction == "F" && $product_gallery_grid->EmptyRow())) {
?>
	<tr<?php echo $product_gallery->RowAttributes() ?>>
<?php

// Render list options (body, left)
$product_gallery_grid->ListOptions->Render("body", "left", $product_gallery_grid->RowCnt);
?>
	<?php if ($product_gallery->pro_gallery_id->Visible) { // pro_gallery_id ?>
		<td data-name="pro_gallery_id"<?php echo $product_gallery->pro_gallery_id->CellAttributes() ?>>
<?php if ($product_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="product_gallery" data-field="x_pro_gallery_id" name="o<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" id="o<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" value="<?php echo ew_HtmlEncode($product_gallery->pro_gallery_id->OldValue) ?>">
<?php } ?>
<?php if ($product_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $product_gallery_grid->RowCnt ?>_product_gallery_pro_gallery_id" class="form-group product_gallery_pro_gallery_id">
<span<?php echo $product_gallery->pro_gallery_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->pro_gallery_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_pro_gallery_id" name="x<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" id="x<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" value="<?php echo ew_HtmlEncode($product_gallery->pro_gallery_id->CurrentValue) ?>">
<?php } ?>
<?php if ($product_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $product_gallery_grid->RowCnt ?>_product_gallery_pro_gallery_id" class="product_gallery_pro_gallery_id">
<span<?php echo $product_gallery->pro_gallery_id->ViewAttributes() ?>>
<?php echo $product_gallery->pro_gallery_id->ListViewValue() ?></span>
</span>
<?php if ($product_gallery->CurrentAction <> "F") { ?>
<input type="hidden" data-table="product_gallery" data-field="x_pro_gallery_id" name="x<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" id="x<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" value="<?php echo ew_HtmlEncode($product_gallery->pro_gallery_id->FormValue) ?>">
<input type="hidden" data-table="product_gallery" data-field="x_pro_gallery_id" name="o<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" id="o<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" value="<?php echo ew_HtmlEncode($product_gallery->pro_gallery_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="product_gallery" data-field="x_pro_gallery_id" name="fproduct_gallerygrid$x<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" id="fproduct_gallerygrid$x<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" value="<?php echo ew_HtmlEncode($product_gallery->pro_gallery_id->FormValue) ?>">
<input type="hidden" data-table="product_gallery" data-field="x_pro_gallery_id" name="fproduct_gallerygrid$o<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" id="fproduct_gallerygrid$o<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" value="<?php echo ew_HtmlEncode($product_gallery->pro_gallery_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($product_gallery->product_id->Visible) { // product_id ?>
		<td data-name="product_id"<?php echo $product_gallery->product_id->CellAttributes() ?>>
<?php if ($product_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($product_gallery->product_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $product_gallery_grid->RowCnt ?>_product_gallery_product_id" class="form-group product_gallery_product_id">
<span<?php echo $product_gallery->product_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->product_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" name="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $product_gallery_grid->RowCnt ?>_product_gallery_product_id" class="form-group product_gallery_product_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $product_gallery_grid->RowIndex ?>_product_id"><?php echo (strval($product_gallery->product_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $product_gallery->product_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($product_gallery->product_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $product_gallery_grid->RowIndex ?>_product_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($product_gallery->product_id->ReadOnly || $product_gallery->product_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $product_gallery->product_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" id="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" value="<?php echo $product_gallery->product_id->CurrentValue ?>"<?php echo $product_gallery->product_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $product_gallery->product_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $product_gallery_grid->RowIndex ?>_product_id',url:'productsaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $product_gallery_grid->RowIndex ?>_product_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $product_gallery->product_id->FldCaption() ?></span></button>
</span>
<?php } ?>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="o<?php echo $product_gallery_grid->RowIndex ?>_product_id" id="o<?php echo $product_gallery_grid->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->OldValue) ?>">
<?php } ?>
<?php if ($product_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $product_gallery_grid->RowCnt ?>_product_gallery_product_id" class="form-group product_gallery_product_id">
<span<?php echo $product_gallery->product_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->product_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" id="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->CurrentValue) ?>">
<?php } ?>
<?php if ($product_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $product_gallery_grid->RowCnt ?>_product_gallery_product_id" class="product_gallery_product_id">
<span<?php echo $product_gallery->product_id->ViewAttributes() ?>>
<?php echo $product_gallery->product_id->ListViewValue() ?></span>
</span>
<?php if ($product_gallery->CurrentAction <> "F") { ?>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" id="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->FormValue) ?>">
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="o<?php echo $product_gallery_grid->RowIndex ?>_product_id" id="o<?php echo $product_gallery_grid->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="fproduct_gallerygrid$x<?php echo $product_gallery_grid->RowIndex ?>_product_id" id="fproduct_gallerygrid$x<?php echo $product_gallery_grid->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->FormValue) ?>">
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="fproduct_gallerygrid$o<?php echo $product_gallery_grid->RowIndex ?>_product_id" id="fproduct_gallerygrid$o<?php echo $product_gallery_grid->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($product_gallery->thumnail->Visible) { // thumnail ?>
		<td data-name="thumnail"<?php echo $product_gallery->thumnail->CellAttributes() ?>>
<?php if ($product_gallery_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_product_gallery_thumnail" class="form-group product_gallery_thumnail">
<div id="fd_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail">
<span title="<?php echo $product_gallery->thumnail->FldTitle() ? $product_gallery->thumnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->thumnail->ReadOnly || $product_gallery->thumnail->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_thumnail" name="x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id="x<?php echo $product_gallery_grid->RowIndex ?>_thumnail"<?php echo $product_gallery->thumnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fn_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fa_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="0">
<input type="hidden" name="fs_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fs_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fx_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fm_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_thumnail" name="o<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id="o<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="<?php echo ew_HtmlEncode($product_gallery->thumnail->OldValue) ?>">
<?php } elseif ($product_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $product_gallery_grid->RowCnt ?>_product_gallery_thumnail" class="product_gallery_thumnail">
<span>
<?php echo ew_GetFileViewTag($product_gallery->thumnail, $product_gallery->thumnail->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $product_gallery_grid->RowCnt ?>_product_gallery_thumnail" class="form-group product_gallery_thumnail">
<div id="fd_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail">
<span title="<?php echo $product_gallery->thumnail->FldTitle() ? $product_gallery->thumnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->thumnail->ReadOnly || $product_gallery->thumnail->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_thumnail" name="x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id="x<?php echo $product_gallery_grid->RowIndex ?>_thumnail"<?php echo $product_gallery->thumnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fn_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fa_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fa_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fs_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fx_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fm_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($product_gallery->image->Visible) { // image ?>
		<td data-name="image"<?php echo $product_gallery->image->CellAttributes() ?>>
<?php if ($product_gallery_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_product_gallery_image" class="form-group product_gallery_image">
<div id="fd_x<?php echo $product_gallery_grid->RowIndex ?>_image">
<span title="<?php echo $product_gallery->image->FldTitle() ? $product_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->image->ReadOnly || $product_gallery->image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_image" name="x<?php echo $product_gallery_grid->RowIndex ?>_image" id="x<?php echo $product_gallery_grid->RowIndex ?>_image"<?php echo $product_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fn_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="<?php echo $product_gallery->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fa_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fs_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fx_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fm_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_grid->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_image" name="o<?php echo $product_gallery_grid->RowIndex ?>_image" id="o<?php echo $product_gallery_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($product_gallery->image->OldValue) ?>">
<?php } elseif ($product_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $product_gallery_grid->RowCnt ?>_product_gallery_image" class="product_gallery_image">
<span>
<?php echo ew_GetFileViewTag($product_gallery->image, $product_gallery->image->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $product_gallery_grid->RowCnt ?>_product_gallery_image" class="form-group product_gallery_image">
<div id="fd_x<?php echo $product_gallery_grid->RowIndex ?>_image">
<span title="<?php echo $product_gallery->image->FldTitle() ? $product_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->image->ReadOnly || $product_gallery->image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_image" name="x<?php echo $product_gallery_grid->RowIndex ?>_image" id="x<?php echo $product_gallery_grid->RowIndex ?>_image"<?php echo $product_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fn_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="<?php echo $product_gallery->image->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $product_gallery_grid->RowIndex ?>_image"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fa_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fa_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fs_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fx_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fm_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_grid->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$product_gallery_grid->ListOptions->Render("body", "right", $product_gallery_grid->RowCnt);
?>
	</tr>
<?php if ($product_gallery->RowType == EW_ROWTYPE_ADD || $product_gallery->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fproduct_gallerygrid.UpdateOpts(<?php echo $product_gallery_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($product_gallery->CurrentAction <> "gridadd" || $product_gallery->CurrentMode == "copy")
		if (!$product_gallery_grid->Recordset->EOF) $product_gallery_grid->Recordset->MoveNext();
}
?>
<?php
	if ($product_gallery->CurrentMode == "add" || $product_gallery->CurrentMode == "copy" || $product_gallery->CurrentMode == "edit") {
		$product_gallery_grid->RowIndex = '$rowindex$';
		$product_gallery_grid->LoadRowValues();

		// Set row properties
		$product_gallery->ResetAttrs();
		$product_gallery->RowAttrs = array_merge($product_gallery->RowAttrs, array('data-rowindex'=>$product_gallery_grid->RowIndex, 'id'=>'r0_product_gallery', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($product_gallery->RowAttrs["class"], "ewTemplate");
		$product_gallery->RowType = EW_ROWTYPE_ADD;

		// Render row
		$product_gallery_grid->RenderRow();

		// Render list options
		$product_gallery_grid->RenderListOptions();
		$product_gallery_grid->StartRowCnt = 0;
?>
	<tr<?php echo $product_gallery->RowAttributes() ?>>
<?php

// Render list options (body, left)
$product_gallery_grid->ListOptions->Render("body", "left", $product_gallery_grid->RowIndex);
?>
	<?php if ($product_gallery->pro_gallery_id->Visible) { // pro_gallery_id ?>
		<td data-name="pro_gallery_id">
<?php if ($product_gallery->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_product_gallery_pro_gallery_id" class="form-group product_gallery_pro_gallery_id">
<span<?php echo $product_gallery->pro_gallery_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->pro_gallery_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_pro_gallery_id" name="x<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" id="x<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" value="<?php echo ew_HtmlEncode($product_gallery->pro_gallery_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="product_gallery" data-field="x_pro_gallery_id" name="o<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" id="o<?php echo $product_gallery_grid->RowIndex ?>_pro_gallery_id" value="<?php echo ew_HtmlEncode($product_gallery->pro_gallery_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($product_gallery->product_id->Visible) { // product_id ?>
		<td data-name="product_id">
<?php if ($product_gallery->CurrentAction <> "F") { ?>
<?php if ($product_gallery->product_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_product_gallery_product_id" class="form-group product_gallery_product_id">
<span<?php echo $product_gallery->product_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->product_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" name="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_product_gallery_product_id" class="form-group product_gallery_product_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $product_gallery_grid->RowIndex ?>_product_id"><?php echo (strval($product_gallery->product_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $product_gallery->product_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($product_gallery->product_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $product_gallery_grid->RowIndex ?>_product_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($product_gallery->product_id->ReadOnly || $product_gallery->product_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $product_gallery->product_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" id="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" value="<?php echo $product_gallery->product_id->CurrentValue ?>"<?php echo $product_gallery->product_id->EditAttributes() ?>>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $product_gallery->product_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $product_gallery_grid->RowIndex ?>_product_id',url:'productsaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $product_gallery_grid->RowIndex ?>_product_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $product_gallery->product_id->FldCaption() ?></span></button>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_product_gallery_product_id" class="form-group product_gallery_product_id">
<span<?php echo $product_gallery->product_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $product_gallery->product_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" id="x<?php echo $product_gallery_grid->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="product_gallery" data-field="x_product_id" name="o<?php echo $product_gallery_grid->RowIndex ?>_product_id" id="o<?php echo $product_gallery_grid->RowIndex ?>_product_id" value="<?php echo ew_HtmlEncode($product_gallery->product_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($product_gallery->thumnail->Visible) { // thumnail ?>
		<td data-name="thumnail">
<span id="el$rowindex$_product_gallery_thumnail" class="form-group product_gallery_thumnail">
<div id="fd_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail">
<span title="<?php echo $product_gallery->thumnail->FldTitle() ? $product_gallery->thumnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->thumnail->ReadOnly || $product_gallery->thumnail->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_thumnail" name="x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id="x<?php echo $product_gallery_grid->RowIndex ?>_thumnail"<?php echo $product_gallery->thumnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fn_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fa_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="0">
<input type="hidden" name="fs_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fs_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fx_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id= "fm_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="<?php echo $product_gallery->thumnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_grid->RowIndex ?>_thumnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_thumnail" name="o<?php echo $product_gallery_grid->RowIndex ?>_thumnail" id="o<?php echo $product_gallery_grid->RowIndex ?>_thumnail" value="<?php echo ew_HtmlEncode($product_gallery->thumnail->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($product_gallery->image->Visible) { // image ?>
		<td data-name="image">
<span id="el$rowindex$_product_gallery_image" class="form-group product_gallery_image">
<div id="fd_x<?php echo $product_gallery_grid->RowIndex ?>_image">
<span title="<?php echo $product_gallery->image->FldTitle() ? $product_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($product_gallery->image->ReadOnly || $product_gallery->image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="product_gallery" data-field="x_image" name="x<?php echo $product_gallery_grid->RowIndex ?>_image" id="x<?php echo $product_gallery_grid->RowIndex ?>_image"<?php echo $product_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fn_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="<?php echo $product_gallery->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fa_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fs_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="250">
<input type="hidden" name="fx_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fx_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $product_gallery_grid->RowIndex ?>_image" id= "fm_x<?php echo $product_gallery_grid->RowIndex ?>_image" value="<?php echo $product_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $product_gallery_grid->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="product_gallery" data-field="x_image" name="o<?php echo $product_gallery_grid->RowIndex ?>_image" id="o<?php echo $product_gallery_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($product_gallery->image->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$product_gallery_grid->ListOptions->Render("body", "right", $product_gallery_grid->RowIndex);
?>
<script type="text/javascript">
fproduct_gallerygrid.UpdateOpts(<?php echo $product_gallery_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($product_gallery->CurrentMode == "add" || $product_gallery->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $product_gallery_grid->FormKeyCountName ?>" id="<?php echo $product_gallery_grid->FormKeyCountName ?>" value="<?php echo $product_gallery_grid->KeyCount ?>">
<?php echo $product_gallery_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($product_gallery->CurrentMode == "edit") { ?>
<?php if ($product_gallery->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="a_list" id="a_list" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $product_gallery_grid->FormKeyCountName ?>" id="<?php echo $product_gallery_grid->FormKeyCountName ?>" value="<?php echo $product_gallery_grid->KeyCount ?>">
<?php echo $product_gallery_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($product_gallery->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fproduct_gallerygrid">
</div>
<?php

// Close recordset
if ($product_gallery_grid->Recordset)
	$product_gallery_grid->Recordset->Close();
?>
<?php if ($product_gallery_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($product_gallery_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($product_gallery_grid->TotalRecs == 0 && $product_gallery->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($product_gallery_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($product_gallery->Export == "") { ?>
<script type="text/javascript">
fproduct_gallerygrid.Init();
</script>
<?php } ?>
<?php
$product_gallery_grid->Page_Terminate();
?>

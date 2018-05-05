<?php

// product_id
// cat_id
// company_id
// pro_name
// ads_id
// pro_base_price
// pro_sell_price
// featured_image
// lang

?>
<?php if ($products->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_productsmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($products->product_id->Visible) { // product_id ?>
		<tr id="r_product_id">
			<td class="col-sm-2"><?php echo $products->product_id->FldCaption() ?></td>
			<td<?php echo $products->product_id->CellAttributes() ?>>
<span id="el_products_product_id">
<span<?php echo $products->product_id->ViewAttributes() ?>>
<?php echo $products->product_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($products->cat_id->Visible) { // cat_id ?>
		<tr id="r_cat_id">
			<td class="col-sm-2"><?php echo $products->cat_id->FldCaption() ?></td>
			<td<?php echo $products->cat_id->CellAttributes() ?>>
<span id="el_products_cat_id">
<span<?php echo $products->cat_id->ViewAttributes() ?>>
<?php echo $products->cat_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($products->company_id->Visible) { // company_id ?>
		<tr id="r_company_id">
			<td class="col-sm-2"><?php echo $products->company_id->FldCaption() ?></td>
			<td<?php echo $products->company_id->CellAttributes() ?>>
<span id="el_products_company_id">
<span<?php echo $products->company_id->ViewAttributes() ?>>
<?php echo $products->company_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($products->pro_name->Visible) { // pro_name ?>
		<tr id="r_pro_name">
			<td class="col-sm-2"><?php echo $products->pro_name->FldCaption() ?></td>
			<td<?php echo $products->pro_name->CellAttributes() ?>>
<span id="el_products_pro_name">
<span<?php echo $products->pro_name->ViewAttributes() ?>>
<?php echo $products->pro_name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($products->ads_id->Visible) { // ads_id ?>
		<tr id="r_ads_id">
			<td class="col-sm-2"><?php echo $products->ads_id->FldCaption() ?></td>
			<td<?php echo $products->ads_id->CellAttributes() ?>>
<span id="el_products_ads_id">
<span<?php echo $products->ads_id->ViewAttributes() ?>>
<?php echo $products->ads_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($products->pro_base_price->Visible) { // pro_base_price ?>
		<tr id="r_pro_base_price">
			<td class="col-sm-2"><?php echo $products->pro_base_price->FldCaption() ?></td>
			<td<?php echo $products->pro_base_price->CellAttributes() ?>>
<span id="el_products_pro_base_price">
<span<?php echo $products->pro_base_price->ViewAttributes() ?>>
<?php echo $products->pro_base_price->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($products->pro_sell_price->Visible) { // pro_sell_price ?>
		<tr id="r_pro_sell_price">
			<td class="col-sm-2"><?php echo $products->pro_sell_price->FldCaption() ?></td>
			<td<?php echo $products->pro_sell_price->CellAttributes() ?>>
<span id="el_products_pro_sell_price">
<span<?php echo $products->pro_sell_price->ViewAttributes() ?>>
<?php echo $products->pro_sell_price->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($products->featured_image->Visible) { // featured_image ?>
		<tr id="r_featured_image">
			<td class="col-sm-2"><?php echo $products->featured_image->FldCaption() ?></td>
			<td<?php echo $products->featured_image->CellAttributes() ?>>
<span id="el_products_featured_image">
<span>
<?php echo ew_GetFileViewTag($products->featured_image, $products->featured_image->ListViewValue()) ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($products->lang->Visible) { // lang ?>
		<tr id="r_lang">
			<td class="col-sm-2"><?php echo $products->lang->FldCaption() ?></td>
			<td<?php echo $products->lang->CellAttributes() ?>>
<span id="el_products_lang">
<span<?php echo $products->lang->ViewAttributes() ?>>
<?php echo $products->lang->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>

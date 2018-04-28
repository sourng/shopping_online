<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(1, "mi_categories", $Language->MenuPhrase("1", "MenuText"), "categorieslist.php", -1, "", IsLoggedIn() || AllowListMenu('{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}categories'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(2, "mi_company", $Language->MenuPhrase("2", "MenuText"), "companylist.php", -1, "", IsLoggedIn() || AllowListMenu('{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}company'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_country", $Language->MenuPhrase("3", "MenuText"), "countrylist.php", -1, "", IsLoggedIn() || AllowListMenu('{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}country'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_products", $Language->MenuPhrase("4", "MenuText"), "productslist.php", -1, "", IsLoggedIn() || AllowListMenu('{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}products'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(5, "mi_province", $Language->MenuPhrase("5", "MenuText"), "provincelist.php", -1, "", IsLoggedIn() || AllowListMenu('{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}province'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(6, "mi_tbl_pages", $Language->MenuPhrase("6", "MenuText"), "tbl_pageslist.php", -1, "", IsLoggedIn() || AllowListMenu('{F38FCD2E-3638-4192-9CEA-A2A8E31F8537}tbl_pages'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
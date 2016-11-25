<!-- Begin Main Menu -->
<div class="ewMenu">
<?php $RootMenu = new crMenu(EWR_MENUBAR_ID); ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(30, "mi__62A64863264A639_62D635635_62764464562F63163364A646", $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("30", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "_62A64863264A639_62D635635_62764464562F63163364A646smry.php", -1, "", TRUE, FALSE);
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->

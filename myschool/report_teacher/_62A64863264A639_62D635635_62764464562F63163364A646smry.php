<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg9.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn9.php" ?>
<?php include_once "phprptinc/ewrusrfn9.php" ?>
<?php include_once "_62A64863264A639_62D635635_62764464562F63163364A646smryinfo.php" ?>
<?php

//
// Page class
//

$p_62A64863264A639_62D635635_62764464562F63163364A646_summary = NULL; // Initialize page object first

class crp_62A64863264A639_62D635635_62764464562F63163364A646_summary extends cr_62A64863264A639_62D635635_62764464562F63163364A646 {

	// Page ID
	var $PageID = 'summary';

	// Project ID
	var $ProjectID = "{46C8A1B4-004B-47CC-B641-FBBA5E422C62}";

	// Page object name
	var $PageObjName = 'p_62A64863264A639_62D635635_62764464562F63163364A646_summary';

	// Page name
	function PageName() {
		return ewr_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewr_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportPdfUrl;
	var $ReportTableClass;
	var $ReportTableStyle = "";

	// Custom export
	var $ExportPrintCustom = FALSE;
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EWR_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EWR_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EWR_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EWR_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_WARNING_MESSAGE], $v);
	}

		// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EWR_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EWR_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EWR_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EWR_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog ewDisplayTable\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") // Header exists, display
			echo $sHeader;
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") // Fotoer exists, display
			echo $sFooter;
	}

	// Validate page request
	function IsPageRequest() {
		if ($this->UseTokenInUrl) {
			if (ewr_IsHttpPost())
				return ($this->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EWR_CHECK_TOKEN;
	var $CheckTokenFn = "ewr_CheckToken";
	var $CreateTokenFn = "ewr_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ewr_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EWR_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EWR_TOKEN_NAME]);
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
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (_62A64863264A639_62D635635_62764464562F63163364A646)
		if (!isset($GLOBALS["_62A64863264A639_62D635635_62764464562F63163364A646"])) {
			$GLOBALS["_62A64863264A639_62D635635_62764464562F63163364A646"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["_62A64863264A639_62D635635_62764464562F63163364A646"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'توزيع حصص المدرسين', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new crTimer();

		// Open connection
		if (!isset($conn)) $conn = ewr_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new crListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Search options
		$this->SearchOptions = new crListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Filter options
		$this->FilterOptions = new crListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption f_62A64863264A639_62D635635_62764464562F63163364A646summary";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $gsEmailContentType, $ReportLanguage, $Security;
		global $gsCustomExport;

		// Get export parameters
		if (@$_GET["export"] <> "")
			$this->Export = strtolower($_GET["export"]);
		elseif (@$_POST["export"] <> "")
			$this->Export = strtolower($_POST["export"]);
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$gsEmailContentType = @$_POST["contenttype"]; // Get email content type

		// Setup placeholder
		$this->teachername->PlaceHolder = $this->teachername->FldCaption();
		$this->subjectname->PlaceHolder = $this->subjectname->FldCaption();
		$this->classname->PlaceHolder = $this->classname->FldCaption();

		// Setup export options
		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $ReportLanguage->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	// Set up export options
	function SetupExportOptions() {
		global $ReportLanguage;
		$exportid = session_id();

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" href=\"" . $this->ExportPrintUrl . "\">" . $ReportLanguage->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" href=\"" . $this->ExportExcelUrl . "\">" . $ReportLanguage->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" href=\"" . $this->ExportWordUrl . "\">" . $ReportLanguage->Phrase("ExportToWord") . "</a>";

		//$item->Visible = FALSE;
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"" . $this->ExportPdfUrl . "\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Uncomment codes below to show export to Pdf link
//		$item->Visible = FALSE;
		// Export to Email

		$item = &$this->ExportOptions->Add("email");
		$url = $this->PageUrl() . "export=email";
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf__62A64863264A639_62D635635_62764464562F63163364A646\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf__62A64863264A639_62D635635_62764464562F63163364A646',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = $this->ExportOptions->UseDropDownButton;
		$this->ExportOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Filter panel button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"f_62A64863264A639_62D635635_62764464562F63163364A646summary\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Reset filter
		$item = &$this->SearchOptions->Add("resetfilter");
		$item->Body = "<button type=\"button\" class=\"btn btn-default\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" onclick=\"location='" . ewr_CurrentPage() . "?cmd=reset'\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</button>";
		$item->Visible = TRUE;

		// Button group for reset filter
		$this->SearchOptions->UseButtonGroup = TRUE;

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"f_62A64863264A639_62D635635_62764464562F63163364A646summary\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"f_62A64863264A639_62D635635_62764464562F63163364A646summary\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton; // v8
		$this->FilterOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Set up options (extended)
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($this->Export <> "") {
			$this->ExportOptions->HideAllOptions();
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}

		// Set up table class
		if ($this->Export == "word" || $this->Export == "excel" || $this->Export == "pdf")
			$this->ReportTableClass = "ewTable";
		else
			$this->ReportTableClass = "table ewTable";
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $ReportLanguage, $EWR_EXPORT, $gsExportFile;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if ($this->Export <> "" && array_key_exists($this->Export, $EWR_EXPORT)) {
			$sContent = ob_get_contents();

			// Remove all <div data-tagid="..." id="orig..." class="hide">...</div> (for customviewtag export, except "googlemaps")
			if (preg_match_all('/<div\s+data-tagid=[\'"]([\s\S]*?)[\'"]\s+id=[\'"]orig([\s\S]*?)[\'"]\s+class\s*=\s*[\'"]hide[\'"]>([\s\S]*?)<\/div\s*>/i', $sContent, $divmatches, PREG_SET_ORDER)) {
				foreach ($divmatches as $divmatch) {
					if ($divmatch[1] <> "googlemaps")
						$sContent = str_replace($divmatch[0], '', $sContent);
				}
			}
			$fn = $EWR_EXPORT[$this->Export];
			if ($this->Export == "email") { // Email
				ob_end_clean();
				echo $this->$fn($sContent);
				ewr_CloseConn(); // Close connection
				exit();
			} else {
				$this->$fn($sContent);
			}
		}

		 // Close connection
		ewr_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWR_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Initialize common variables
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $FilterOptions; // Filter options

	// Paging variables
	var $RecIndex = 0; // Record index
	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $GrpCounter = array(); // Group counter
	var $DisplayGrps = 10; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $PageFirstGroupFilter = "";
	var $UserIDFilter = "";
	var $DrillDown = FALSE;
	var $DrillDownInPanel = FALSE;
	var $DrillDownList = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $PopupName = "";
	var $PopupValue = "";
	var $FilterApplied;
	var $SearchCommand = FALSE;
	var $ShowHeader;
	var $GrpFldCount = 0;
	var $SubGrpFldCount = 0;
	var $DtlFldCount = 0;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandCnt, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;
	var $GrandSummarySetup = FALSE;
	var $GrpIdx;

	//
	// Page main
	//
	function Page_Main() {
		global $rs;
		global $rsgrp;
		global $Security;
		global $gsFormError;
		global $gbDrillDownInPanel;
		global $ReportBreadcrumb;
		global $ReportLanguage;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 8;
		$nGrps = 2;
		$this->Val = &ewr_InitArray($nDtls, 0);
		$this->Cnt = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandCnt = &ewr_InitArray($nDtls, 0);
		$this->GrandSmry = &ewr_InitArray($nDtls, 0);
		$this->GrandMn = &ewr_InitArray($nDtls, NULL);
		$this->GrandMx = &ewr_InitArray($nDtls, NULL);

		// Set up array if accumulation required: array(Accum, SkipNullOrZero)
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Check if search command
		$this->SearchCommand = (@$_GET["cmd"] == "search");

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$this->Page_FilterLoad();

		// Set up popup filter
		$this->SetupPopup();

		// Load group db values if necessary
		$this->LoadGroupDbValues();

		// Handle Ajax popup
		$this->ProcessAjaxPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Restore filter list
		$this->RestoreFilterList();

		// Build extended filter
		$sExtendedFilter = $this->GetExtendedFilter();
		ewr_AddFilter($this->Filter, $sExtendedFilter);

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewr_SetDebugMsg("popup filter: " . $sPopupFilter);
		ewr_AddFilter($this->Filter, $sPopupFilter);

		// Check if filter applied
		$this->FilterApplied = $this->CheckFilter();

		// Call Page Selecting event
		$this->Page_Selecting($this->Filter);
		$this->SearchOptions->GetItem("resetfilter")->Visible = $this->FilterApplied;

		// Get sort
		$this->Sort = $this->GetSort();

		// Get total group count
		$sGrpSort = ewr_UpdateSortFields($this->getSqlOrderByGroup(), $this->Sort, 2); // Get grouping field only
		$sSql = ewr_BuildReportSql($this->getSqlSelectGroup(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderByGroup(), $this->Filter, $sGrpSort);
		$this->TotalGrps = $this->GetGrpCnt($sSql);
		if ($this->DisplayGrps <= 0 || $this->DrillDown) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowHeader = ($this->TotalGrps > 0);

		// Set up start position if not export all
		if ($this->ExportAll && $this->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Set no record found message
		if ($this->TotalGrps == 0) {
				if ($this->Filter == "0=101") {
					$this->setWarningMessage($ReportLanguage->Phrase("EnterSearchCriteria"));
				} else {
					$this->setWarningMessage($ReportLanguage->Phrase("NoRecord"));
				}
		}

		// Hide export options if export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Hide search/filter options if export/drilldown
		if ($this->Export <> "" || $this->DrillDown) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}

		// Get current page groups
		$rsgrp = $this->GetGrpRs($sSql, $this->StartGrp, $this->DisplayGrps);

		// Init detail recordset
		$rs = NULL;
		$this->SetupFieldCount();
	}

	// Check level break
	function ChkLvlBreak($lvl) {
		switch ($lvl) {
			case 1:
				return (is_null($this->teachername->CurrentValue) && !is_null($this->teachername->OldValue)) ||
					(!is_null($this->teachername->CurrentValue) && is_null($this->teachername->OldValue)) ||
					($this->teachername->GroupValue() <> $this->teachername->GroupOldValue());
		}
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				if ($this->Col[$iy][0]) { // Accumulate required
					$valwrk = $this->Val[$iy];
					if (is_null($valwrk)) {
						if (!$this->Col[$iy][1])
							$this->Cnt[$ix][$iy]++;
					} else {
						$accum = (!$this->Col[$iy][1] || !is_numeric($valwrk) || $valwrk <> 0);
						if ($accum) {
							$this->Cnt[$ix][$iy]++;
							if (is_numeric($valwrk)) {
								$this->Smry[$ix][$iy] += $valwrk;
								if (is_null($this->Mn[$ix][$iy])) {
									$this->Mn[$ix][$iy] = $valwrk;
									$this->Mx[$ix][$iy] = $valwrk;
								} else {
									if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
									if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
								}
							}
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy][0]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->TotCount++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy][0]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {
					if (!$this->Col[$iy][1])
						$this->GrandCnt[$iy]++;
				} else {
					if (!$this->Col[$iy][1] || $valwrk <> 0) {
						$this->GrandCnt[$iy]++;
						$this->GrandSmry[$iy] += $valwrk;
						if (is_null($this->GrandMn[$iy])) {
							$this->GrandMn[$iy] = $valwrk;
							$this->GrandMx[$iy] = $valwrk;
						} else {
							if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
							if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
						}
					}
				}
			}
		}
	}

	// Get group count
	function GetGrpCnt($sql) {
		$conn = &$this->Connection();
		$rsgrpcnt = $conn->Execute($sql);
		$grpcnt = ($rsgrpcnt) ? $rsgrpcnt->RecordCount() : 0;
		if ($rsgrpcnt) $rsgrpcnt->Close();
		return $grpcnt;
	}

	// Get group recordset
	function GetGrpRs($wrksql, $start = -1, $grps = -1) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->SelectLimit($wrksql, $grps, $start - 1);
		$conn->raiseErrorFn = '';
		return $rswrk;
	}

	// Get group row values
	function GetGrpRow($opt) {
		global $rsgrp;
		if (!$rsgrp)
			return;
		if ($opt == 1) { // Get first group

			//$rsgrp->MoveFirst(); // NOTE: no need to move position
			$this->teachername->setDbValue(""); // Init first value
		} else { // Get next group
			$rsgrp->MoveNext();
		}
		if (!$rsgrp->EOF)
			$this->teachername->setDbValue($rsgrp->fields[0]);
		if ($rsgrp->EOF) {
			$this->teachername->setDbValue("");
		}
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
			if ($this->GrpCount == 1) {
				$this->FirstRowData = array();
				$this->FirstRowData['time_start'] = ewr_Conv($rs->fields('time_start'),3);
				$this->FirstRowData['time_start_min'] = ewr_Conv($rs->fields('time_start_min'),3);
				$this->FirstRowData['time_end'] = ewr_Conv($rs->fields('time_end'),3);
				$this->FirstRowData['time_end_min'] = ewr_Conv($rs->fields('time_end_min'),3);
				$this->FirstRowData['subject_id'] = ewr_Conv($rs->fields('subject_id'),3);
			}
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			if ($opt <> 1) {
				if (is_array($this->teachername->GroupDbValues))
					$this->teachername->setDbValue(@$this->teachername->GroupDbValues[$rs->fields('teachername')]);
				else
					$this->teachername->setDbValue(ewr_GroupValue($this->teachername, $rs->fields('teachername')));
			}
			$this->subjectname->setDbValue($rs->fields('subjectname'));
			$this->classname->setDbValue($rs->fields('classname'));
			$this->day->setDbValue($rs->fields('day'));
			$this->time_start->setDbValue($rs->fields('time_start'));
			$this->time_start_min->setDbValue($rs->fields('time_start_min'));
			$this->time_end->setDbValue($rs->fields('time_end'));
			$this->time_end_min->setDbValue($rs->fields('time_end_min'));
			$this->subject_id->setDbValue($rs->fields('subject_id'));
			$this->Val[1] = $this->subjectname->CurrentValue;
			$this->Val[2] = $this->classname->CurrentValue;
			$this->Val[3] = $this->day->CurrentValue;
			$this->Val[4] = $this->time_start->CurrentValue;
			$this->Val[5] = $this->time_start_min->CurrentValue;
			$this->Val[6] = $this->time_end->CurrentValue;
			$this->Val[7] = $this->time_end_min->CurrentValue;
		} else {
			$this->teachername->setDbValue("");
			$this->subjectname->setDbValue("");
			$this->classname->setDbValue("");
			$this->day->setDbValue("");
			$this->time_start->setDbValue("");
			$this->time_start_min->setDbValue("");
			$this->time_end->setDbValue("");
			$this->time_end_min->setDbValue("");
			$this->subject_id->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWR_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWR_TABLE_START_GROUP];
			$this->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$this->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $this->getStartGroup();
			}
		} else {
			$this->StartGrp = $this->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$this->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$this->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$this->setStartGroup($this->StartGrp);
		}
	}

	// Load group db values if necessary
	function LoadGroupDbValues() {
		$conn = &$this->Connection();
	}

	// Process Ajax popup
	function ProcessAjaxPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		$fld = NULL;
		if (@$_GET["popup"] <> "") {
			$popupname = $_GET["popup"];

			// Check popup name
			// Output data as Json

			if (!is_null($fld)) {
				$jsdb = ewr_GetJsDb($fld, $fld->FldType);
				ob_end_clean();
				echo $jsdb;
				exit();
			}
		}
	}

	// Set up popup
	function SetupPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		if ($this->DrillDown)
			return;

		// Process post back form
		if (ewr_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = ewr_StripSlashes($_POST["sel_$sName"]);
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWR_INIT_VALUE;
					$this->PopupName = $sName;
					if (ewr_IsAdvancedFilterValue($arValues) || $arValues == EWR_INIT_VALUE)
						$this->PopupValue = $arValues;
					if (!ewr_MatchedArray($arValues, $_SESSION["sel_$sName"])) {
						if ($this->HasSessionFilterValues($sName))
							$this->ClearExtFilter = $sName; // Clear extended filter for this field
					}
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = ewr_StripSlashes(@$_POST["rf_$sName"]);
					$_SESSION["rt_$sName"] = ewr_StripSlashes(@$_POST["rt_$sName"]);
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		$this->StartGrp = 1;
		$this->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		$sWrk = @$_GET[EWR_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // Display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 10; // Non-numeric, load default
				}
			}
			$this->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$this->setStartGroup($this->StartGrp);
		} else {
			if ($this->getGroupPerPage() <> "") {
				$this->DisplayGrps = $this->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 10; // Load default
			}
		}
	}

	// Render row
	function RenderRow() {
		global $rs, $Security, $ReportLanguage;
		$conn = &$this->Connection();
		if ($this->RowTotalType == EWR_ROWTOTAL_GRAND && !$this->GrandSummarySetup) { // Grand total
			$bGotCount = FALSE;
			$bGotSummary = FALSE;

			// Get total count from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectCount(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
				$bGotCount = TRUE;
			} else {
				$this->TotCount = 0;
			}
		$bGotSummary = TRUE;

			// Accumulate grand summary from detail records
			if (!$bGotCount || !$bGotSummary) {
				$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
				$rs = $conn->Execute($sSql);
				if ($rs) {
					$this->GetRow(1);
					while (!$rs->EOF) {
						$this->AccumulateGrandSummary();
						$this->GetRow(2);
					}
					$rs->Close();
				}
			}
			$this->GrandSummarySetup = TRUE; // No need to set up again
		}

		// Call Row_Rendering event
		$this->Row_Rendering();

		//
		// Render view codes
		//

		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row
			$this->RowAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel; // Set up row class

			// teachername
			$this->teachername->GroupViewValue = $this->teachername->GroupOldValue();
			$this->teachername->CellAttrs["class"] = ($this->RowGroupLevel == 1) ? "ewRptGrpSummary1" : "ewRptGrpField1";
			$this->teachername->GroupViewValue = ewr_DisplayGroupValue($this->teachername, $this->teachername->GroupViewValue);
			$this->teachername->GroupSummaryOldValue = $this->teachername->GroupSummaryValue;
			$this->teachername->GroupSummaryValue = $this->teachername->GroupViewValue;
			$this->teachername->GroupSummaryViewValue = ($this->teachername->GroupSummaryOldValue <> $this->teachername->GroupSummaryValue) ? $this->teachername->GroupSummaryValue : "&nbsp;";

			// teachername
			$this->teachername->HrefValue = "";

			// subjectname
			$this->subjectname->HrefValue = "";

			// classname
			$this->classname->HrefValue = "";

			// day
			$this->day->HrefValue = "";

			// time_start
			$this->time_start->HrefValue = "";

			// time_start_min
			$this->time_start_min->HrefValue = "";

			// time_end
			$this->time_end->HrefValue = "";

			// time_end_min
			$this->time_end_min->HrefValue = "";
		} else {

			// teachername
			$this->teachername->GroupViewValue = $this->teachername->GroupValue();
			$this->teachername->CellAttrs["class"] = "ewRptGrpField1";
			$this->teachername->GroupViewValue = ewr_DisplayGroupValue($this->teachername, $this->teachername->GroupViewValue);
			if ($this->teachername->GroupValue() == $this->teachername->GroupOldValue() && !$this->ChkLvlBreak(1))
				$this->teachername->GroupViewValue = "&nbsp;";

			// subjectname
			$this->subjectname->ViewValue = $this->subjectname->CurrentValue;
			$this->subjectname->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// classname
			$this->classname->ViewValue = $this->classname->CurrentValue;
			$this->classname->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// day
			$this->day->ViewValue = $this->day->CurrentValue;
			$this->day->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// time_start
			$this->time_start->ViewValue = $this->time_start->CurrentValue;
			$this->time_start->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// time_start_min
			$this->time_start_min->ViewValue = $this->time_start_min->CurrentValue;
			$this->time_start_min->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// time_end
			$this->time_end->ViewValue = $this->time_end->CurrentValue;
			$this->time_end->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// time_end_min
			$this->time_end_min->ViewValue = $this->time_end_min->CurrentValue;
			$this->time_end_min->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// teachername
			$this->teachername->HrefValue = "";

			// subjectname
			$this->subjectname->HrefValue = "";

			// classname
			$this->classname->HrefValue = "";

			// day
			$this->day->HrefValue = "";

			// time_start
			$this->time_start->HrefValue = "";

			// time_start_min
			$this->time_start_min->HrefValue = "";

			// time_end
			$this->time_end->HrefValue = "";

			// time_end_min
			$this->time_end_min->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row

			// teachername
			$CurrentValue = $this->teachername->GroupViewValue;
			$ViewValue = &$this->teachername->GroupViewValue;
			$ViewAttrs = &$this->teachername->ViewAttrs;
			$CellAttrs = &$this->teachername->CellAttrs;
			$HrefValue = &$this->teachername->HrefValue;
			$LinkAttrs = &$this->teachername->LinkAttrs;
			$this->Cell_Rendered($this->teachername, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		} else {

			// teachername
			$CurrentValue = $this->teachername->GroupValue();
			$ViewValue = &$this->teachername->GroupViewValue;
			$ViewAttrs = &$this->teachername->ViewAttrs;
			$CellAttrs = &$this->teachername->CellAttrs;
			$HrefValue = &$this->teachername->HrefValue;
			$LinkAttrs = &$this->teachername->LinkAttrs;
			$this->Cell_Rendered($this->teachername, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// subjectname
			$CurrentValue = $this->subjectname->CurrentValue;
			$ViewValue = &$this->subjectname->ViewValue;
			$ViewAttrs = &$this->subjectname->ViewAttrs;
			$CellAttrs = &$this->subjectname->CellAttrs;
			$HrefValue = &$this->subjectname->HrefValue;
			$LinkAttrs = &$this->subjectname->LinkAttrs;
			$this->Cell_Rendered($this->subjectname, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// classname
			$CurrentValue = $this->classname->CurrentValue;
			$ViewValue = &$this->classname->ViewValue;
			$ViewAttrs = &$this->classname->ViewAttrs;
			$CellAttrs = &$this->classname->CellAttrs;
			$HrefValue = &$this->classname->HrefValue;
			$LinkAttrs = &$this->classname->LinkAttrs;
			$this->Cell_Rendered($this->classname, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// day
			$CurrentValue = $this->day->CurrentValue;
			$ViewValue = &$this->day->ViewValue;
			$ViewAttrs = &$this->day->ViewAttrs;
			$CellAttrs = &$this->day->CellAttrs;
			$HrefValue = &$this->day->HrefValue;
			$LinkAttrs = &$this->day->LinkAttrs;
			$this->Cell_Rendered($this->day, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// time_start
			$CurrentValue = $this->time_start->CurrentValue;
			$ViewValue = &$this->time_start->ViewValue;
			$ViewAttrs = &$this->time_start->ViewAttrs;
			$CellAttrs = &$this->time_start->CellAttrs;
			$HrefValue = &$this->time_start->HrefValue;
			$LinkAttrs = &$this->time_start->LinkAttrs;
			$this->Cell_Rendered($this->time_start, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// time_start_min
			$CurrentValue = $this->time_start_min->CurrentValue;
			$ViewValue = &$this->time_start_min->ViewValue;
			$ViewAttrs = &$this->time_start_min->ViewAttrs;
			$CellAttrs = &$this->time_start_min->CellAttrs;
			$HrefValue = &$this->time_start_min->HrefValue;
			$LinkAttrs = &$this->time_start_min->LinkAttrs;
			$this->Cell_Rendered($this->time_start_min, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// time_end
			$CurrentValue = $this->time_end->CurrentValue;
			$ViewValue = &$this->time_end->ViewValue;
			$ViewAttrs = &$this->time_end->ViewAttrs;
			$CellAttrs = &$this->time_end->CellAttrs;
			$HrefValue = &$this->time_end->HrefValue;
			$LinkAttrs = &$this->time_end->LinkAttrs;
			$this->Cell_Rendered($this->time_end, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// time_end_min
			$CurrentValue = $this->time_end_min->CurrentValue;
			$ViewValue = &$this->time_end_min->ViewValue;
			$ViewAttrs = &$this->time_end_min->ViewAttrs;
			$CellAttrs = &$this->time_end_min->CellAttrs;
			$HrefValue = &$this->time_end_min->HrefValue;
			$LinkAttrs = &$this->time_end_min->LinkAttrs;
			$this->Cell_Rendered($this->time_end_min, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		}

		// Call Row_Rendered event
		$this->Row_Rendered();
		$this->SetupFieldCount();
	}

	// Setup field count
	function SetupFieldCount() {
		$this->GrpFldCount = 0;
		$this->SubGrpFldCount = 0;
		$this->DtlFldCount = 0;
		if ($this->teachername->Visible) $this->GrpFldCount += 1;
		if ($this->subjectname->Visible) $this->DtlFldCount += 1;
		if ($this->classname->Visible) $this->DtlFldCount += 1;
		if ($this->day->Visible) $this->DtlFldCount += 1;
		if ($this->time_start->Visible) $this->DtlFldCount += 1;
		if ($this->time_start_min->Visible) $this->DtlFldCount += 1;
		if ($this->time_end->Visible) $this->DtlFldCount += 1;
		if ($this->time_end_min->Visible) $this->DtlFldCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("summary", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage;
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $gsFormError;
		$sFilter = "";
		if ($this->DrillDown)
			return "";
		$bPostBack = ewr_IsHttpPost();
		$bRestoreSession = TRUE;
		$bSetupFilter = FALSE;

		// Reset extended filter if filter changed
		if ($bPostBack) {

		// Reset search command
		} elseif (@$_GET["cmd"] == "reset") {

			// Load default values
			$this->SetSessionFilterValues($this->teachername->SearchValue, $this->teachername->SearchOperator, $this->teachername->SearchCondition, $this->teachername->SearchValue2, $this->teachername->SearchOperator2, 'teachername'); // Field teachername
			$this->SetSessionFilterValues($this->subjectname->SearchValue, $this->subjectname->SearchOperator, $this->subjectname->SearchCondition, $this->subjectname->SearchValue2, $this->subjectname->SearchOperator2, 'subjectname'); // Field subjectname
			$this->SetSessionFilterValues($this->classname->SearchValue, $this->classname->SearchOperator, $this->classname->SearchCondition, $this->classname->SearchValue2, $this->classname->SearchOperator2, 'classname'); // Field classname

			//$bSetupFilter = TRUE; // No need to set up, just use default
		} else {
			$bRestoreSession = !$this->SearchCommand;

			// Field teachername
			if ($this->GetFilterValues($this->teachername)) {
				$bSetupFilter = TRUE;
			}

			// Field subjectname
			if ($this->GetFilterValues($this->subjectname)) {
				$bSetupFilter = TRUE;
			}

			// Field classname
			if ($this->GetFilterValues($this->classname)) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setFailureMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {
			$this->GetSessionFilterValues($this->teachername); // Field teachername
			$this->GetSessionFilterValues($this->subjectname); // Field subjectname
			$this->GetSessionFilterValues($this->classname); // Field classname
		}

		// Call page filter validated event
		$this->Page_FilterValidated();

		// Build SQL
		$this->BuildExtendedFilter($this->teachername, $sFilter, FALSE, TRUE); // Field teachername
		$this->BuildExtendedFilter($this->subjectname, $sFilter, FALSE, TRUE); // Field subjectname
		$this->BuildExtendedFilter($this->classname, $sFilter, FALSE, TRUE); // Field classname

		// Save parms to session
		$this->SetSessionFilterValues($this->teachername->SearchValue, $this->teachername->SearchOperator, $this->teachername->SearchCondition, $this->teachername->SearchValue2, $this->teachername->SearchOperator2, 'teachername'); // Field teachername
		$this->SetSessionFilterValues($this->subjectname->SearchValue, $this->subjectname->SearchOperator, $this->subjectname->SearchCondition, $this->subjectname->SearchValue2, $this->subjectname->SearchOperator2, 'subjectname'); // Field subjectname
		$this->SetSessionFilterValues($this->classname->SearchValue, $this->classname->SearchOperator, $this->classname->SearchCondition, $this->classname->SearchValue2, $this->classname->SearchOperator2, 'classname'); // Field classname

		// Setup filter
		if ($bSetupFilter) {
		}
		return $sFilter;
	}

	// Build dropdown filter
	function BuildDropDownFilter(&$fld, &$FilterClause, $FldOpr, $Default = FALSE, $SaveFilter = FALSE) {
		$FldVal = ($Default) ? $fld->DefaultDropDownValue : $fld->DropDownValue;
		$sSql = "";
		if (is_array($FldVal)) {
			foreach ($FldVal as $val) {
				$sWrk = $this->GetDropDownFilter($fld, $val, $FldOpr);

				// Call Page Filtering event
				if (substr($val, 0, 2) <> "@@") $this->Page_Filtering($fld, $sWrk, "dropdown", $FldOpr, $val);
				if ($sWrk <> "") {
					if ($sSql <> "")
						$sSql .= " OR " . $sWrk;
					else
						$sSql = $sWrk;
				}
			}
		} else {
			$sSql = $this->GetDropDownFilter($fld, $FldVal, $FldOpr);

			// Call Page Filtering event
			if (substr($FldVal, 0, 2) <> "@@") $this->Page_Filtering($fld, $sSql, "dropdown", $FldOpr, $FldVal);
		}
		if ($sSql <> "") {
			ewr_AddFilter($FilterClause, $sSql);
			if ($SaveFilter) $fld->CurrentFilter = $sSql;
		}
	}

	function GetDropDownFilter(&$fld, $FldVal, $FldOpr) {
		$FldName = $fld->FldName;
		$FldExpression = $fld->FldExpression;
		$FldDataType = $fld->FldDataType;
		$FldDelimiter = $fld->FldDelimiter;
		$FldVal = strval($FldVal);
		if ($FldOpr == "") $FldOpr = "=";
		$sWrk = "";
		if ($FldVal == EWR_NULL_VALUE) {
			$sWrk = $FldExpression . " IS NULL";
		} elseif ($FldVal == EWR_NOT_NULL_VALUE) {
			$sWrk = $FldExpression . " IS NOT NULL";
		} elseif ($FldVal == EWR_EMPTY_VALUE) {
			$sWrk = $FldExpression . " = ''";
		} elseif ($FldVal == EWR_ALL_VALUE) {
			$sWrk = "1 = 1";
		} else {
			if (substr($FldVal, 0, 2) == "@@") {
				$sWrk = $this->GetCustomFilter($fld, $FldVal);
			} elseif ($FldDelimiter <> "" && trim($FldVal) <> "") {
				$sWrk = ewr_GetMultiSearchSql($FldExpression, trim($FldVal), $this->DBID);
			} else {
				if ($FldVal <> "" && $FldVal <> EWR_INIT_VALUE) {
					if ($FldDataType == EWR_DATATYPE_DATE && $FldOpr <> "") {
						$sWrk = ewr_DateFilterString($FldExpression, $FldOpr, $FldVal, $FldDataType, $this->DBID);
					} else {
						$sWrk = ewr_FilterString($FldOpr, $FldVal, $FldDataType, $this->DBID);
						if ($sWrk <> "") $sWrk = $FldExpression . $sWrk;
					}
				}
			}
		}
		return $sWrk;
	}

	// Get custom filter
	function GetCustomFilter(&$fld, $FldVal) {
		$sWrk = "";
		if (is_array($fld->AdvancedFilters)) {
			foreach ($fld->AdvancedFilters as $filter) {
				if ($filter->ID == $FldVal && $filter->Enabled) {
					$sFld = $fld->FldExpression;
					$sFn = $filter->FunctionName;
					$wrkid = (substr($filter->ID,0,2) == "@@") ? substr($filter->ID,2) : $filter->ID;
					if ($sFn <> "")
						$sWrk = $sFn($sFld);
					else
						$sWrk = "";
					$this->Page_Filtering($fld, $sWrk, "custom", $wrkid);
					break;
				}
			}
		}
		return $sWrk;
	}

	// Build extended filter
	function BuildExtendedFilter(&$fld, &$FilterClause, $Default = FALSE, $SaveFilter = FALSE) {
		$sWrk = ewr_GetExtendedFilter($fld, $Default, $this->DBID);
		if (!$Default)
			$this->Page_Filtering($fld, $sWrk, "extended", $fld->SearchOperator, $fld->SearchValue, $fld->SearchCondition, $fld->SearchOperator2, $fld->SearchValue2);
		if ($sWrk <> "") {
			ewr_AddFilter($FilterClause, $sWrk);
			if ($SaveFilter) $fld->CurrentFilter = $sWrk;
		}
	}

	// Get drop down value from querystring
	function GetDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return FALSE; // Skip post back
		if (isset($_GET["so_$parm"]))
			$fld->SearchOperator = ewr_StripSlashes(@$_GET["so_$parm"]);
		if (isset($_GET["sv_$parm"])) {
			$fld->DropDownValue = ewr_StripSlashes(@$_GET["sv_$parm"]);
			return TRUE;
		}
		return FALSE;
	}

	// Get filter values from querystring
	function GetFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return; // Skip post back
		$got = FALSE;
		if (isset($_GET["sv_$parm"])) {
			$fld->SearchValue = ewr_StripSlashes(@$_GET["sv_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["so_$parm"])) {
			$fld->SearchOperator = ewr_StripSlashes(@$_GET["so_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["sc_$parm"])) {
			$fld->SearchCondition = ewr_StripSlashes(@$_GET["sc_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["sv2_$parm"])) {
			$fld->SearchValue2 = ewr_StripSlashes(@$_GET["sv2_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["so2_$parm"])) {
			$fld->SearchOperator2 = ewr_StripSlashes($_GET["so2_$parm"]);
			$got = TRUE;
		}
		return $got;
	}

	// Set default ext filter
	function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2) {
		$fld->DefaultSearchValue = $sv1; // Default ext filter value 1
		$fld->DefaultSearchValue2 = $sv2; // Default ext filter value 2 (if operator 2 is enabled)
		$fld->DefaultSearchOperator = $so1; // Default search operator 1
		$fld->DefaultSearchOperator2 = $so2; // Default search operator 2 (if operator 2 is enabled)
		$fld->DefaultSearchCondition = $sc; // Default search condition (if operator 2 is enabled)
	}

	// Apply default ext filter
	function ApplyDefaultExtFilter(&$fld) {
		$fld->SearchValue = $fld->DefaultSearchValue;
		$fld->SearchValue2 = $fld->DefaultSearchValue2;
		$fld->SearchOperator = $fld->DefaultSearchOperator;
		$fld->SearchOperator2 = $fld->DefaultSearchOperator2;
		$fld->SearchCondition = $fld->DefaultSearchCondition;
	}

	// Check if Text Filter applied
	function TextFilterApplied(&$fld) {
		return (strval($fld->SearchValue) <> strval($fld->DefaultSearchValue) ||
			strval($fld->SearchValue2) <> strval($fld->DefaultSearchValue2) ||
			(strval($fld->SearchValue) <> "" &&
				strval($fld->SearchOperator) <> strval($fld->DefaultSearchOperator)) ||
			(strval($fld->SearchValue2) <> "" &&
				strval($fld->SearchOperator2) <> strval($fld->DefaultSearchOperator2)) ||
			strval($fld->SearchCondition) <> strval($fld->DefaultSearchCondition));
	}

	// Check if Non-Text Filter applied
	function NonTextFilterApplied(&$fld) {
		if (is_array($fld->DropDownValue)) {
			if (is_array($fld->DefaultDropDownValue)) {
				if (count($fld->DefaultDropDownValue) <> count($fld->DropDownValue))
					return TRUE;
				else
					return (count(array_diff($fld->DefaultDropDownValue, $fld->DropDownValue)) <> 0);
			} else {
				return TRUE;
			}
		} else {
			if (is_array($fld->DefaultDropDownValue))
				return TRUE;
			else
				$v1 = strval($fld->DefaultDropDownValue);
			if ($v1 == EWR_INIT_VALUE)
				$v1 = "";
			$v2 = strval($fld->DropDownValue);
			if ($v2 == EWR_INIT_VALUE || $v2 == EWR_ALL_VALUE)
				$v2 = "";
			return ($v1 <> $v2);
		}
	}

	// Get dropdown value from session
	function GetSessionDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->DropDownValue, 'sv__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (array_key_exists($sn, $_SESSION))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $so, $parm) {
		$_SESSION['sv__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm] = $sv;
		$_SESSION['so__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm] = $so;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm] = $sv1;
		$_SESSION['so__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm] = $so1;
		$_SESSION['sc__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm] = $sc;
		$_SESSION['sv2__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm] = $sv2;
		$_SESSION['so2__62A64863264A639_62D635635_62764464562F63163364A646_' . $parm] = $so2;
	}

	// Check if has Session filter values
	function HasSessionFilterValues($parm) {
		return ((@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv2_' . $parm] <> "" && @$_SESSION['sv2_' . $parm] <> EWR_INIT_VALUE));
	}

	// Dropdown filter exist
	function DropDownFilterExist(&$fld, $FldOpr) {
		$sWrk = "";
		$this->BuildDropDownFilter($fld, $sWrk, $FldOpr);
		return ($sWrk <> "");
	}

	// Extended filter exist
	function ExtendedFilterExist(&$fld) {
		$sExtWrk = "";
		$this->BuildExtendedFilter($fld, $sExtWrk);
		return ($sExtWrk <> "");
	}

	// Validate form
	function ValidateForm() {
		global $ReportLanguage, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EWR_SERVER_VALIDATE)
			return ($gsFormError == "");

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<p>&nbsp;</p>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel__62A64863264A639_62D635635_62764464562F63163364A646_$parm"] = "";
		$_SESSION["rf__62A64863264A639_62D635635_62764464562F63163364A646_$parm"] = "";
		$_SESSION["rt__62A64863264A639_62D635635_62764464562F63163364A646_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		$fld = &$this->fields($parm);
		$fld->SelectionList = @$_SESSION["sel__62A64863264A639_62D635635_62764464562F63163364A646_$parm"];
		$fld->RangeFrom = @$_SESSION["rf__62A64863264A639_62D635635_62764464562F63163364A646_$parm"];
		$fld->RangeTo = @$_SESSION["rt__62A64863264A639_62D635635_62764464562F63163364A646_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {

		/**
		* Set up default values for non Text filters
		*/

		/**
		* Set up default values for extended filters
		* function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2)
		* Parameters:
		* $fld - Field object
		* $so1 - Default search operator 1
		* $sv1 - Default ext filter value 1
		* $sc - Default search condition (if operator 2 is enabled)
		* $so2 - Default search operator 2 (if operator 2 is enabled)
		* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
		*/

		// Field teachername
		$this->SetDefaultExtFilter($this->teachername, "LIKE", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->teachername);

		// Field subjectname
		$this->SetDefaultExtFilter($this->subjectname, "LIKE", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->subjectname);

		// Field classname
		$this->SetDefaultExtFilter($this->classname, "LIKE", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->classname);

		/**
		* Set up default values for popup filters
		*/
	}

	// Check if filter applied
	function CheckFilter() {

		// Check teachername text filter
		if ($this->TextFilterApplied($this->teachername))
			return TRUE;

		// Check subjectname text filter
		if ($this->TextFilterApplied($this->subjectname))
			return TRUE;

		// Check classname text filter
		if ($this->TextFilterApplied($this->classname))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList() {
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field teachername
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->teachername, $sExtWrk);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->teachername->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field subjectname
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->subjectname, $sExtWrk);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->subjectname->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field classname
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->classname, $sExtWrk);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->classname->FldCaption() . "</span>" . $sFilter . "</div>";
		$divstyle = "";
		$divdataclass = "";

		// Show Filters
		if ($sFilterList <> "") {
			$sMessage = "<div class=\"ewDisplayTable\"" . $divstyle . "><div id=\"ewrFilterList\" class=\"alert alert-info\"" . $divdataclass . "><div id=\"ewrCurrentFilters\">" . $ReportLanguage->Phrase("CurrentFilters") . "</div>" . $sFilterList . "</div></div>";
			$this->Message_Showing($sMessage, "");
			echo $sMessage;
		}
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";

		// Field teachername
		$sWrk = "";
		if ($this->teachername->SearchValue <> "" || $this->teachername->SearchValue2 <> "") {
			$sWrk = "\"sv_teachername\":\"" . ewr_JsEncode2($this->teachername->SearchValue) . "\"," .
				"\"so_teachername\":\"" . ewr_JsEncode2($this->teachername->SearchOperator) . "\"," .
				"\"sc_teachername\":\"" . ewr_JsEncode2($this->teachername->SearchCondition) . "\"," .
				"\"sv2_teachername\":\"" . ewr_JsEncode2($this->teachername->SearchValue2) . "\"," .
				"\"so2_teachername\":\"" . ewr_JsEncode2($this->teachername->SearchOperator2) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field subjectname
		$sWrk = "";
		if ($this->subjectname->SearchValue <> "" || $this->subjectname->SearchValue2 <> "") {
			$sWrk = "\"sv_subjectname\":\"" . ewr_JsEncode2($this->subjectname->SearchValue) . "\"," .
				"\"so_subjectname\":\"" . ewr_JsEncode2($this->subjectname->SearchOperator) . "\"," .
				"\"sc_subjectname\":\"" . ewr_JsEncode2($this->subjectname->SearchCondition) . "\"," .
				"\"sv2_subjectname\":\"" . ewr_JsEncode2($this->subjectname->SearchValue2) . "\"," .
				"\"so2_subjectname\":\"" . ewr_JsEncode2($this->subjectname->SearchOperator2) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field classname
		$sWrk = "";
		if ($this->classname->SearchValue <> "" || $this->classname->SearchValue2 <> "") {
			$sWrk = "\"sv_classname\":\"" . ewr_JsEncode2($this->classname->SearchValue) . "\"," .
				"\"so_classname\":\"" . ewr_JsEncode2($this->classname->SearchOperator) . "\"," .
				"\"sc_classname\":\"" . ewr_JsEncode2($this->classname->SearchCondition) . "\"," .
				"\"sv2_classname\":\"" . ewr_JsEncode2($this->classname->SearchValue2) . "\"," .
				"\"so2_classname\":\"" . ewr_JsEncode2($this->classname->SearchOperator2) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Return filter list in json
		if ($sFilterList <> "")
			return "{" . $sFilterList . "}";
		else
			return "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ewr_StripSlashes(@$_POST["filter"]), TRUE);

		// Field teachername
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_teachername", $filter) || array_key_exists("so_teachername", $filter) ||
			array_key_exists("sc_teachername", $filter) ||
			array_key_exists("sv2_teachername", $filter) || array_key_exists("so2_teachername", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_teachername"], @$filter["so_teachername"], @$filter["sc_teachername"], @$filter["sv2_teachername"], @$filter["so2_teachername"], "teachername");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "teachername");
		}

		// Field subjectname
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_subjectname", $filter) || array_key_exists("so_subjectname", $filter) ||
			array_key_exists("sc_subjectname", $filter) ||
			array_key_exists("sv2_subjectname", $filter) || array_key_exists("so2_subjectname", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_subjectname"], @$filter["so_subjectname"], @$filter["sc_subjectname"], @$filter["sv2_subjectname"], @$filter["so2_subjectname"], "subjectname");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "subjectname");
		}

		// Field classname
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_classname", $filter) || array_key_exists("so_classname", $filter) ||
			array_key_exists("sc_classname", $filter) ||
			array_key_exists("sv2_classname", $filter) || array_key_exists("so2_classname", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_classname"], @$filter["so_classname"], @$filter["sc_classname"], @$filter["sv2_classname"], @$filter["so2_classname"], "classname");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "classname");
		}
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWR_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		if ($this->DrillDown)
			return "";

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$this->setOrderBy("");
				$this->setStartGroup(1);
				$this->teachername->setSort("");
				$this->subjectname->setSort("");
				$this->classname->setSort("");
				$this->day->setSort("");
				$this->time_start->setSort("");
				$this->time_start_min->setSort("");
				$this->time_end->setSort("");
				$this->time_end_min->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$this->CurrentOrder = ewr_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $this->SortSql();
			$this->setOrderBy($sSortSql);
			$this->setStartGroup(1);
		}
		return $this->getOrderBy();
	}

	// Export to HTML
	function ExportHtml($html) {

		//global $gsExportFile;
		//header('Content-Type: text/html' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
		//header('Content-Disposition: attachment; filename=' . $gsExportFile . '.html');
		//echo $html;

	} 

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
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
<?php ewr_Header(FALSE) ?>
<?php

// Create page object
if (!isset($p_62A64863264A639_62D635635_62764464562F63163364A646_summary)) $p_62A64863264A639_62D635635_62764464562F63163364A646_summary = new crp_62A64863264A639_62D635635_62764464562F63163364A646_summary();
if (isset($Page)) $OldPage = $Page;
$Page = &$p_62A64863264A639_62D635635_62764464562F63163364A646_summary;

// Page init
$Page->Page_Init();

// Page main
$Page->Page_Main();

// Global Page Rendering event (in ewrusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php include_once "phprptinc/header.php" ?>
<?php if ($Page->Export == "" || $Page->Export == "print" || $Page->Export == "email" && @$gsEmailContentType == "url") { ?>
<script type="text/javascript">

// Create page object
var p_62A64863264A639_62D635635_62764464562F63163364A646_summary = new ewr_Page("p_62A64863264A639_62D635635_62764464562F63163364A646_summary");

// Page properties
p_62A64863264A639_62D635635_62764464562F63163364A646_summary.PageID = "summary"; // Page ID
var EWR_PAGE_ID = p_62A64863264A639_62D635635_62764464562F63163364A646_summary.PageID;

// Extend page with Chart_Rendering function
p_62A64863264A639_62D635635_62764464562F63163364A646_summary.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
p_62A64863264A639_62D635635_62764464562F63163364A646_summary.Chart_Rendered = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Form object
var CurrentForm = f_62A64863264A639_62D635635_62764464562F63163364A646summary = new ewr_Form("f_62A64863264A639_62D635635_62764464562F63163364A646summary");

// Validate method
f_62A64863264A639_62D635635_62764464562F63163364A646summary.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
f_62A64863264A639_62D635635_62764464562F63163364A646summary.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EWR_CLIENT_VALIDATE) { ?>
f_62A64863264A639_62D635635_62764464562F63163364A646summary.ValidateRequired = true; // Uses JavaScript validation
<?php } else { ?>
f_62A64863264A639_62D635635_62764464562F63163364A646summary.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($Page->Export == "") { ?>
<!-- container (begin) -->
<div id="ewContainer" class="ewContainer">
<!-- top container (begin) -->
<div id="ewTop" class="ewTop">
<a id="top"></a>
<?php } ?>
<!-- top slot -->
<div class="ewToolbar">
<?php if ($Page->Export == "" && (!$Page->DrillDown || !$Page->DrillDownInPanel)) { ?>
<?php if ($ReportBreadcrumb) $ReportBreadcrumb->Render(); ?>
<?php } ?>
<?php
if (!$Page->DrillDownInPanel) {
	$Page->ExportOptions->Render("body");
	$Page->SearchOptions->Render("body");
	$Page->FilterOptions->Render("body");
}
?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<?php echo $ReportLanguage->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $Page->ShowPageHeader(); ?>
<?php $Page->ShowMessage(); ?>
<?php if ($Page->Export == "") { ?>
</div>
<!-- top container (end) -->
	<!-- left container (begin) -->
	<div id="ewLeft" class="ewLeft">
<?php } ?>
	<!-- Left slot -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- left container (end) -->
	<!-- center container - report (begin) -->
	<div id="ewCenter" class="ewCenter">
<?php } ?>
	<!-- center slot -->
<!-- summary report starts -->
<div id="report_summary">
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<!-- Search form (begin) -->
<form name="f_62A64863264A639_62D635635_62764464562F63163364A646summary" id="f_62A64863264A639_62D635635_62764464562F63163364A646summary" class="form-inline ewForm ewExtFilterForm" action="<?php echo ewr_CurrentPage() ?>">
<?php $SearchPanelClass = ($Page->Filter <> "") ? " in" : " in"; ?>
<div id="f_62A64863264A639_62D635635_62764464562F63163364A646summary_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ewRow">
<div id="c_teachername" class="ewCell form-group">
	<label for="sv_teachername" class="ewSearchCaption ewLabel"><?php echo $Page->teachername->FldCaption() ?></label>
	<span class="ewSearchOperator"><?php echo $ReportLanguage->Phrase("LIKE"); ?><input type="hidden" name="so_teachername" id="so_teachername" value="LIKE"></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->teachername->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="_62A64863264A639_62D635635_62764464562F63163364A646" data-field="x_teachername" id="sv_teachername" name="sv_teachername" placeholder="<?php echo $Page->teachername->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->teachername->SearchValue) ?>"<?php echo $Page->teachername->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_2" class="ewRow">
<div id="c_subjectname" class="ewCell form-group">
	<label for="sv_subjectname" class="ewSearchCaption ewLabel"><?php echo $Page->subjectname->FldCaption() ?></label>
	<span class="ewSearchOperator"><?php echo $ReportLanguage->Phrase("LIKE"); ?><input type="hidden" name="so_subjectname" id="so_subjectname" value="LIKE"></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->subjectname->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="_62A64863264A639_62D635635_62764464562F63163364A646" data-field="x_subjectname" id="sv_subjectname" name="sv_subjectname" placeholder="<?php echo $Page->subjectname->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->subjectname->SearchValue) ?>"<?php echo $Page->subjectname->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_3" class="ewRow">
<div id="c_classname" class="ewCell form-group">
	<label for="sv_classname" class="ewSearchCaption ewLabel"><?php echo $Page->classname->FldCaption() ?></label>
	<span class="ewSearchOperator"><?php echo $ReportLanguage->Phrase("LIKE"); ?><input type="hidden" name="so_classname" id="so_classname" value="LIKE"></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->classname->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="_62A64863264A639_62D635635_62764464562F63163364A646" data-field="x_classname" id="sv_classname" name="sv_classname" placeholder="<?php echo $Page->classname->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->classname->SearchValue) ?>"<?php echo $Page->classname->EditAttributes() ?>>
</span>
</div>
</div>
<div class="ewRow"><input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-primary" value="<?php echo $ReportLanguage->Phrase("Search") ?>">
<input type="reset" name="btnreset" id="btnreset" class="btn hide" value="<?php echo $ReportLanguage->Phrase("Reset") ?>"></div>
</div>
</form>
<script type="text/javascript">
f_62A64863264A639_62D635635_62764464562F63163364A646summary.Init();
f_62A64863264A639_62D635635_62764464562F63163364A646summary.FilterList = <?php echo $Page->GetFilterList() ?>;
</script>
<!-- Search form (end) -->
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->ShowFilterList() ?>
<?php } ?>
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGrp = $Page->TotalGrps;
} else {
	$Page->StopGrp = $Page->StartGrp + $Page->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGrp) > intval($Page->TotalGrps))
	$Page->StopGrp = $Page->TotalGrps;
$Page->RecCount = 0;
$Page->RecIndex = 0;

// Get first row
if ($Page->TotalGrps > 0) {
	$Page->GetGrpRow(1);
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray($Page->StopGrp - $Page->StartGrp + 1, -1);
while ($rsgrp && !$rsgrp->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<?php if ($Page->GrpCount > 1) { ?>
</tbody>
</table>
</div>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php include "_62A64863264A639_62D635635_62764464562F63163364A646smrypager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<span data-class="tpb<?php echo $Page->GrpCount-1 ?>__62A64863264A639_62D635635_62764464562F63163364A646"><?php echo $Page->PageBreakContent ?></span>
<?php } ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<!-- Report grid (begin) -->
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->teachername->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="teachername"><div class="_62A64863264A639_62D635635_62764464562F63163364A646_teachername"><span class="ewTableHeaderCaption"><?php echo $Page->teachername->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="teachername">
<?php if ($Page->SortUrl($Page->teachername) == "") { ?>
		<div class="ewTableHeaderBtn _62A64863264A639_62D635635_62764464562F63163364A646_teachername">
			<span class="ewTableHeaderCaption"><?php echo $Page->teachername->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer _62A64863264A639_62D635635_62764464562F63163364A646_teachername" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->teachername) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->teachername->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->teachername->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->teachername->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->subjectname->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="subjectname"><div class="_62A64863264A639_62D635635_62764464562F63163364A646_subjectname"><span class="ewTableHeaderCaption"><?php echo $Page->subjectname->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="subjectname">
<?php if ($Page->SortUrl($Page->subjectname) == "") { ?>
		<div class="ewTableHeaderBtn _62A64863264A639_62D635635_62764464562F63163364A646_subjectname">
			<span class="ewTableHeaderCaption"><?php echo $Page->subjectname->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer _62A64863264A639_62D635635_62764464562F63163364A646_subjectname" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->subjectname) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->subjectname->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->subjectname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->subjectname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->classname->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="classname"><div class="_62A64863264A639_62D635635_62764464562F63163364A646_classname"><span class="ewTableHeaderCaption"><?php echo $Page->classname->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="classname">
<?php if ($Page->SortUrl($Page->classname) == "") { ?>
		<div class="ewTableHeaderBtn _62A64863264A639_62D635635_62764464562F63163364A646_classname">
			<span class="ewTableHeaderCaption"><?php echo $Page->classname->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer _62A64863264A639_62D635635_62764464562F63163364A646_classname" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->classname) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->classname->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->classname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->classname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->day->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="day"><div class="_62A64863264A639_62D635635_62764464562F63163364A646_day"><span class="ewTableHeaderCaption"><?php echo $Page->day->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="day">
<?php if ($Page->SortUrl($Page->day) == "") { ?>
		<div class="ewTableHeaderBtn _62A64863264A639_62D635635_62764464562F63163364A646_day">
			<span class="ewTableHeaderCaption"><?php echo $Page->day->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer _62A64863264A639_62D635635_62764464562F63163364A646_day" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->day) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->day->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->day->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->day->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->time_start->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="time_start"><div class="_62A64863264A639_62D635635_62764464562F63163364A646_time_start"><span class="ewTableHeaderCaption"><?php echo $Page->time_start->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="time_start">
<?php if ($Page->SortUrl($Page->time_start) == "") { ?>
		<div class="ewTableHeaderBtn _62A64863264A639_62D635635_62764464562F63163364A646_time_start">
			<span class="ewTableHeaderCaption"><?php echo $Page->time_start->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer _62A64863264A639_62D635635_62764464562F63163364A646_time_start" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->time_start) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->time_start->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->time_start->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->time_start->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->time_start_min->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="time_start_min"><div class="_62A64863264A639_62D635635_62764464562F63163364A646_time_start_min"><span class="ewTableHeaderCaption"><?php echo $Page->time_start_min->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="time_start_min">
<?php if ($Page->SortUrl($Page->time_start_min) == "") { ?>
		<div class="ewTableHeaderBtn _62A64863264A639_62D635635_62764464562F63163364A646_time_start_min">
			<span class="ewTableHeaderCaption"><?php echo $Page->time_start_min->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer _62A64863264A639_62D635635_62764464562F63163364A646_time_start_min" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->time_start_min) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->time_start_min->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->time_start_min->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->time_start_min->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->time_end->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="time_end"><div class="_62A64863264A639_62D635635_62764464562F63163364A646_time_end"><span class="ewTableHeaderCaption"><?php echo $Page->time_end->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="time_end">
<?php if ($Page->SortUrl($Page->time_end) == "") { ?>
		<div class="ewTableHeaderBtn _62A64863264A639_62D635635_62764464562F63163364A646_time_end">
			<span class="ewTableHeaderCaption"><?php echo $Page->time_end->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer _62A64863264A639_62D635635_62764464562F63163364A646_time_end" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->time_end) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->time_end->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->time_end->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->time_end->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->time_end_min->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="time_end_min"><div class="_62A64863264A639_62D635635_62764464562F63163364A646_time_end_min"><span class="ewTableHeaderCaption"><?php echo $Page->time_end_min->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="time_end_min">
<?php if ($Page->SortUrl($Page->time_end_min) == "") { ?>
		<div class="ewTableHeaderBtn _62A64863264A639_62D635635_62764464562F63163364A646_time_end_min">
			<span class="ewTableHeaderCaption"><?php echo $Page->time_end_min->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer _62A64863264A639_62D635635_62764464562F63163364A646_time_end_min" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->time_end_min) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->time_end_min->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->time_end_min->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->time_end_min->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGrps == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}

	// Build detail SQL
	$sWhere = ewr_DetailFilterSQL($Page->teachername, $Page->getSqlFirstGroupField(), $Page->teachername->GroupValue(), $Page->DBID);
	if ($Page->PageFirstGroupFilter <> "") $Page->PageFirstGroupFilter .= " OR ";
	$Page->PageFirstGroupFilter .= $sWhere;
	if ($Page->Filter != "")
		$sWhere = "($Page->Filter) AND ($sWhere)";
	$sSql = ewr_BuildReportSql($Page->getSqlSelect(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $sWhere, $Page->Sort);
	$rs = $conn->Execute($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		$Page->GetRow(1);
	$Page->GrpIdx[$Page->GrpCount] = $rsdtlcnt;
	while ($rs && !$rs->EOF) { // Loop detail records
		$Page->RecCount++;
		$Page->RecIndex++;

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->teachername->Visible) { ?>
		<td data-field="teachername"<?php echo $Page->teachername->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>__62A64863264A639_62D635635_62764464562F63163364A646_teachername"<?php echo $Page->teachername->ViewAttributes() ?>><?php echo $Page->teachername->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->subjectname->Visible) { ?>
		<td data-field="subjectname"<?php echo $Page->subjectname->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>__62A64863264A639_62D635635_62764464562F63163364A646_subjectname"<?php echo $Page->subjectname->ViewAttributes() ?>><?php echo $Page->subjectname->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->classname->Visible) { ?>
		<td data-field="classname"<?php echo $Page->classname->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>__62A64863264A639_62D635635_62764464562F63163364A646_classname"<?php echo $Page->classname->ViewAttributes() ?>><?php echo $Page->classname->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->day->Visible) { ?>
		<td data-field="day"<?php echo $Page->day->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>__62A64863264A639_62D635635_62764464562F63163364A646_day"<?php echo $Page->day->ViewAttributes() ?>><?php echo $Page->day->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->time_start->Visible) { ?>
		<td data-field="time_start"<?php echo $Page->time_start->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>__62A64863264A639_62D635635_62764464562F63163364A646_time_start"<?php echo $Page->time_start->ViewAttributes() ?>><?php echo $Page->time_start->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->time_start_min->Visible) { ?>
		<td data-field="time_start_min"<?php echo $Page->time_start_min->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>__62A64863264A639_62D635635_62764464562F63163364A646_time_start_min"<?php echo $Page->time_start_min->ViewAttributes() ?>><?php echo $Page->time_start_min->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->time_end->Visible) { ?>
		<td data-field="time_end"<?php echo $Page->time_end->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>__62A64863264A639_62D635635_62764464562F63163364A646_time_end"<?php echo $Page->time_end->ViewAttributes() ?>><?php echo $Page->time_end->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->time_end_min->Visible) { ?>
		<td data-field="time_end_min"<?php echo $Page->time_end_min->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>__62A64863264A639_62D635635_62764464562F63163364A646_time_end_min"<?php echo $Page->time_end_min->ViewAttributes() ?>><?php echo $Page->time_end_min->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php
		if ($Page->teachername->Visible) {
?>
<?php
			$Page->ResetAttrs();
			$Page->RowType = EWR_ROWTYPE_TOTAL;
			$Page->RowTotalType = EWR_ROWTOTAL_GROUP;
			$Page->RowTotalSubType = EWR_ROWTOTAL_FOOTER;
			$Page->RowGroupLevel = 1;
			$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->GrpFldCount + $Page->DtlFldCount > 0) { ?>
		<td colspan="<?php echo ($Page->GrpFldCount + $Page->DtlFldCount) ?>"<?php echo $Page->teachername->CellAttributes() ?>><?php echo str_replace(array("%v", "%c"), array($Page->teachername->GroupViewValue, $Page->teachername->FldCaption()), $ReportLanguage->Phrase("RptSumHead")) ?> <span class="ewDirLtr">(<?php echo ewr_FormatNumber($Page->Cnt[1][0],0,-2,-2,-2) ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</span></td>
<?php } ?>
</tr>
<?php

			// Reset level 1 summary
			$Page->ResetLevelSummary(1);
		} // End show footer check
?>
<?php

	// Next group
	$Page->GetGrpRow(2);

	// Show header if page break
	if ($Page->Export <> "")
		$Page->ShowHeader = ($Page->ExportPageBreakCount == 0) ? FALSE : ($Page->GrpCount % $Page->ExportPageBreakCount == 0);

	// Page_Breaking server event
	if ($Page->ShowHeader)
		$Page->Page_Breaking($Page->ShowHeader, $Page->PageBreakContent);
	$Page->GrpCount++;

	// Handle EOF
	if (!$rsgrp || $rsgrp->EOF)
		$Page->ShowHeader = FALSE;
} // End while
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
<?php
	$Page->ResetAttrs();
	$Page->RowType = EWR_ROWTYPE_TOTAL;
	$Page->RowTotalType = EWR_ROWTOTAL_GRAND;
	$Page->RowTotalSubType = EWR_ROWTOTAL_FOOTER;
	$Page->RowAttrs["class"] = "ewRptGrandSummary";
	$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>><td colspan="<?php echo ($Page->GrpFldCount + $Page->DtlFldCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> <span class="ewDirLtr">(<?php echo ewr_FormatNumber($Page->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</span></td></tr>
	</tfoot>
<?php } elseif (!$Page->ShowHeader && FALSE) { // No header displayed ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<!-- Report grid (begin) -->
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
<?php if ($Page->TotalGrps > 0 || FALSE) { // Show footer ?>
</table>
</div>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php include "_62A64863264A639_62D635635_62764464562F63163364A646smrypager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
</div>
<!-- Summary Report Ends -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- center container - report (end) -->
	<!-- right container (begin) -->
	<div id="ewRight" class="ewRight">
<?php } ?>
	<!-- Right slot -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- right container (end) -->
<div class="clearfix"></div>
<!-- bottom container (begin) -->
<div id="ewBottom" class="ewBottom">
<?php } ?>
	<!-- Bottom slot -->
<?php if ($Page->Export == "") { ?>
	</div>
<!-- Bottom Container (End) -->
</div>
<!-- Table Container (End) -->
<?php } ?>
<?php $Page->ShowPageFooter(); ?>
<?php if (EWR_DEBUG_ENABLED) echo ewr_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php" ?>
<?php
$Page->Page_Terminate();
if (isset($OldPage)) $Page = $OldPage;
?>

<?php

// Global variable for table object
$_62A64863264A639_62D635635_62764464562F63163364A646 = NULL;

//
// Table class for توزيع حصص المدرسين
//
class cr_62A64863264A639_62D635635_62764464562F63163364A646 extends crTableBase {
	var $teachername;
	var $subjectname;
	var $classname;
	var $day;
	var $time_start;
	var $time_start_min;
	var $time_end;
	var $time_end_min;
	var $subject_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage;
		$this->TableVar = '_62A64863264A639_62D635635_62764464562F63163364A646';
		$this->TableName = 'توزيع حصص المدرسين';
		$this->TableType = 'REPORT';
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// teachername
		$this->teachername = new crField('_62A64863264A639_62D635635_62764464562F63163364A646', 'توزيع حصص المدرسين', 'x_teachername', 'teachername', '`teachername`', 201, EWR_DATATYPE_MEMO, -1);
		$this->teachername->GroupingFieldId = 1;
		$this->fields['teachername'] = &$this->teachername;
		$this->teachername->DateFilter = "";
		$this->teachername->SqlSelect = "";
		$this->teachername->SqlOrderBy = "";
		$this->teachername->FldGroupByType = "";
		$this->teachername->FldGroupInt = "0";
		$this->teachername->FldGroupSql = "";

		// subjectname
		$this->subjectname = new crField('_62A64863264A639_62D635635_62764464562F63163364A646', 'توزيع حصص المدرسين', 'x_subjectname', 'subjectname', '`subjectname`', 201, EWR_DATATYPE_MEMO, -1);
		$this->fields['subjectname'] = &$this->subjectname;
		$this->subjectname->DateFilter = "";
		$this->subjectname->SqlSelect = "";
		$this->subjectname->SqlOrderBy = "";

		// classname
		$this->classname = new crField('_62A64863264A639_62D635635_62764464562F63163364A646', 'توزيع حصص المدرسين', 'x_classname', 'classname', '`classname`', 201, EWR_DATATYPE_MEMO, -1);
		$this->fields['classname'] = &$this->classname;
		$this->classname->DateFilter = "";
		$this->classname->SqlSelect = "";
		$this->classname->SqlOrderBy = "";

		// day
		$this->day = new crField('_62A64863264A639_62D635635_62764464562F63163364A646', 'توزيع حصص المدرسين', 'x_day', 'day', '`day`', 201, EWR_DATATYPE_MEMO, -1);
		$this->fields['day'] = &$this->day;
		$this->day->DateFilter = "";
		$this->day->SqlSelect = "";
		$this->day->SqlOrderBy = "";

		// time_start
		$this->time_start = new crField('_62A64863264A639_62D635635_62764464562F63163364A646', 'توزيع حصص المدرسين', 'x_time_start', 'time_start', '`time_start`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->time_start->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['time_start'] = &$this->time_start;
		$this->time_start->DateFilter = "";
		$this->time_start->SqlSelect = "";
		$this->time_start->SqlOrderBy = "";

		// time_start_min
		$this->time_start_min = new crField('_62A64863264A639_62D635635_62764464562F63163364A646', 'توزيع حصص المدرسين', 'x_time_start_min', 'time_start_min', '`time_start_min`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->time_start_min->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['time_start_min'] = &$this->time_start_min;
		$this->time_start_min->DateFilter = "";
		$this->time_start_min->SqlSelect = "";
		$this->time_start_min->SqlOrderBy = "";

		// time_end
		$this->time_end = new crField('_62A64863264A639_62D635635_62764464562F63163364A646', 'توزيع حصص المدرسين', 'x_time_end', 'time_end', '`time_end`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->time_end->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['time_end'] = &$this->time_end;
		$this->time_end->DateFilter = "";
		$this->time_end->SqlSelect = "";
		$this->time_end->SqlOrderBy = "";

		// time_end_min
		$this->time_end_min = new crField('_62A64863264A639_62D635635_62764464562F63163364A646', 'توزيع حصص المدرسين', 'x_time_end_min', 'time_end_min', '`time_end_min`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->time_end_min->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['time_end_min'] = &$this->time_end_min;
		$this->time_end_min->DateFilter = "";
		$this->time_end_min->SqlSelect = "";
		$this->time_end_min->SqlOrderBy = "";

		// subject_id
		$this->subject_id = new crField('_62A64863264A639_62D635635_62764464562F63163364A646', 'توزيع حصص المدرسين', 'x_subject_id', 'subject_id', '`subject_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->subject_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['subject_id'] = &$this->subject_id;
		$this->subject_id->DateFilter = "";
		$this->subject_id->SqlSelect = "";
		$this->subject_id->SqlOrderBy = "";
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
		} else {
			if ($ofld->GroupingFieldId == 0) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = "";
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fld->FldExpression, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fld->FldExpression . " " . $fld->getSort();
				} else {
					if ($sDtlSortSql <> "") $sDtlSortSql .= ", ";
					$sDtlSortSql .= $fld->FldExpression . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ",";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	// From

	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`teacherroutine`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}

	// Select
	var $_SqlSelect = "";

	function getSqlSelect() {
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}

	// Where
	var $_SqlWhere = "";

	function getSqlWhere() {
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}

	// Group By
	var $_SqlGroupBy = "";

	function getSqlGroupBy() {
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}

	// Having
	var $_SqlHaving = "";

	function getSqlHaving() {
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}

	// Order By
	var $_SqlOrderBy = "";

	function getSqlOrderBy() {
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`teachername` ASC";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Table Level Group SQL
	// First Group Field

	var $_SqlFirstGroupField = "";

	function getSqlFirstGroupField() {
		return ($this->_SqlFirstGroupField <> "") ? $this->_SqlFirstGroupField : "`teachername`";
	}

	function SqlFirstGroupField() { // For backward compatibility
		return $this->getSqlFirstGroupField();
	}

	function setSqlFirstGroupField($v) {
		$this->_SqlFirstGroupField = $v;
	}

	// Select Group
	var $_SqlSelectGroup = "";

	function getSqlSelectGroup() {
		return ($this->_SqlSelectGroup <> "") ? $this->_SqlSelectGroup : "SELECT DISTINCT " . $this->getSqlFirstGroupField() . " FROM " . $this->getSqlFrom();
	}

	function SqlSelectGroup() { // For backward compatibility
		return $this->getSqlSelectGroup();
	}

	function setSqlSelectGroup($v) {
		$this->_SqlSelectGroup = $v;
	}

	// Order By Group
	var $_SqlOrderByGroup = "";

	function getSqlOrderByGroup() {
		return ($this->_SqlOrderByGroup <> "") ? $this->_SqlOrderByGroup : "`teachername` ASC";
	}

	function SqlOrderByGroup() { // For backward compatibility
		return $this->getSqlOrderByGroup();
	}

	function setSqlOrderByGroup($v) {
		$this->_SqlOrderByGroup = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelectAgg() { // For backward compatibility
		return $this->getSqlSelectAgg();
	}

	function setSqlSelectAgg($v) {
		$this->_SqlSelectAgg = $v;
	}

	// Aggregate Prefix
	var $_SqlAggPfx = "";

	function getSqlAggPfx() {
		return ($this->_SqlAggPfx <> "") ? $this->_SqlAggPfx : "";
	}

	function SqlAggPfx() { // For backward compatibility
		return $this->getSqlAggPfx();
	}

	function setSqlAggPfx($v) {
		$this->_SqlAggPfx = $v;
	}

	// Aggregate Suffix
	var $_SqlAggSfx = "";

	function getSqlAggSfx() {
		return ($this->_SqlAggSfx <> "") ? $this->_SqlAggSfx : "";
	}

	function SqlAggSfx() { // For backward compatibility
		return $this->getSqlAggSfx();
	}

	function setSqlAggSfx($v) {
		$this->_SqlAggSfx = $v;
	}

	// Select Count
	var $_SqlSelectCount = "";

	function getSqlSelectCount() {
		return ($this->_SqlSelectCount <> "") ? $this->_SqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}

	function SqlSelectCount() { // For backward compatibility
		return $this->getSqlSelectCount();
	}

	function setSqlSelectCount($v) {
		$this->_SqlSelectCount = $v;
	}

	// Sort URL
	function SortUrl(&$fld) {
		return "";
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here	
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//ewr_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		// if ($typ == "dropdown" && $fld->FldName == "MyField") // Dropdown filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "extended" && $fld->FldName == "MyField") // Extended filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "popup" && $fld->FldName == "MyField") // Popup filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "custom" && $opr == "..." && $fld->FldName == "MyField") // Custom filter, $opr is the custom filter ID
		//     $filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>

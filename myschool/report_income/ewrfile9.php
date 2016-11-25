<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg9.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn9.php" ?>
<?php include_once "phprptinc/ewrusrfn9.php" ?>
<?php
ewr_Header(FALSE);
$file = new crfile;
$file->Page_Main();

//
// Page class for file viewer
//
class crfile {

	// Page ID
	var $PageID = "file";

	// Project ID
	var $ProjectID = "{57832F63-0CE7-4A4C-BDE6-22DC1803B07B}";

	// Page object name
	var $PageObjName = "file";

	// Page name
	function PageName() {
		return ewr_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		return ewr_CurrentPage() . "?";
	}

	// Main
	// - Uncomment ** for database connectivity / Page_Loading / Page_Unloaded server event
	function Page_Main() {

		//**global $conn;
		$GLOBALS["Page"] = &$this;

		//**$conn = ewr_Connect();
		// Get fn / table name parameters

		$key = EWR_RANDOM_KEY . session_id();
		$fn = (@$_GET["fn"] <> "") ? ewr_StripSlashes($_GET["fn"]) : "";
		if ($fn <> "" && EWR_ENCRYPT_FILE_PATH)
			$fn = ewr_Decrypt($fn, $key);
		$table = (@$_GET["t"] <> "") ? ewr_StripSlashes($_GET["t"]) : "";
		if ($table <> "" && EWR_ENCRYPT_FILE_PATH)
			$table = ewr_Decrypt($table, $key);

		// Global Page Loading event (in userfn*.php)
		//**Page_Loading();
		// Get resize parameters

		$resize = (@$_GET["resize"] <> "");
		$width = (@$_GET["width"] <> "") ? $_GET["width"] : 0;
		$height = (@$_GET["height"] <> "") ? $_GET["height"] : 0;
		if (@$_GET["width"] == "" && @$_GET["height"] == "") {
			$width = EWR_THUMBNAIL_DEFAULT_WIDTH;
			$height = EWR_THUMBNAIL_DEFAULT_HEIGHT;
		}

		// Resize image from physical file
		if ($fn <> "") {
			$fn = str_replace("\0", "", $fn);
			$info = pathinfo($fn);
			$fn = ewr_PathCombine(ewr_AppRoot(), $info["dirname"], TRUE) . $info["basename"];
			if (file_exists($fn) || @fopen($fn, "rb") !== FALSE) { // Allow remote file
				if (ob_get_length())
					ob_end_clean();
				$pathinfo = pathinfo($fn);
				$ext = strtolower(@$pathinfo["extension"]);
				$ct = ewr_ContentType("", $fn);
				if ($ct <> "")
					header("Content-type: " . $ct);
				header("Content-Disposition: attachment; filename=\"" . $pathinfo["basename"] . "\"");
				if (in_array($ext, explode(",", EWR_IMAGE_ALLOWED_FILE_EXT))) {
					$size = @getimagesize($fn);
					if ($size)
						header("Content-type: {$size['mime']}");
					if ($width > 0 || $height > 0)
						echo ewr_ResizeFileToBinary($fn, $width, $height);
					else
						echo file_get_contents($fn);
				} elseif (in_array($ext, explode(",", EWR_DOWNLOAD_ALLOWED_FILE_EXT))) {
					echo file_get_contents($fn);
				}
			}
		}

		// Global Page Unloaded event (in userfn*.php)
		//**Page_Unloaded();
		 // Close connection
		//**ewr_CloseConn();

	}
}
?>

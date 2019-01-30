<?php

/* --------------------------------------------------
	SYSTEM ERROR LOG
-------------------------------------------------- */
if (!defined('_CTTA_ERROR_LOG_')) {
	define('_CTTA_ERROR_LOG_', false); //enable error log
}
if (!defined('_CTTA_ERROR_LOG_FOLDER_')) {
	define('_CTTA_ERROR_LOG_FOLDER_', 'log/XMLError'); //write to a log file
}
if (!defined('_CTTA_ERROR_LOG_FILENAME_')) {
	define('_CTTA_ERROR_LOG_FILENAME_', 'log-' . date('Y-m-d') . '.log'); //write to a log file
}

/* --------------------------------------------------
	SYSTEM ERROR Handler
-------------------------------------------------- */
set_error_handler(function($number, $error){
    if (preg_match('/^DOMDocument::(load|loadXML|loadHTMLFile)\(\): (.+)$/', $error, $m) === 1) {
		$str = date('Y-m-d H:i:s') . ' ' . print_r($m[0], true);
		if (_CTTA_ERROR_LOG_) {
			$logFolder = _CTTA_ERROR_LOG_FOLDER_;
			if (!is_dir($logFolder)) {
				mkdir($logFolder, 0777, true);
			}
			$path = $logFolder . DIRECTORY_SEPARATOR . _CTTA_ERROR_LOG_FILENAME_;
			file_put_contents($path, $str . "\n", FILE_APPEND | LOCK_EX);
		}
    }
});

/**
 * Convert Tag to Array
 *
 * @category Convert
 * @package Class
 * @example
 * ```php
 * $convert = new ConvertTagToArray;
 * $array = $convert->convertHTML($HTMLFilePath);
 * ```
 * @version 0.04
 * @since 2016-09-17
 * @author Syahrul Farhan
 */
class ConvertTagToArray {

	/**
	 * Main function to convert the XML
	 * @param string $file Path of the XML file
	 * @return array|false XML array, false if error
	 */
	public function convertXML($file) {
		$doc = new DOMDocument();
		if ($doc->load($file, LIBXML_DTDLOAD) !== false) {
			$tags = $this->getArray($doc->documentElement, false);
			return $tags;
		} else {
			return false;
		}
	}

	/**
	 * Main function to convert XML String to Array
	 * @param string $str XML String
	 * @return array|false XML array, false if error
	 */
	public function convertXMLStr($str) {
		$doc = new DOMDocument();
		if ($doc->loadXML($str, LIBXML_DTDLOAD) !== false) {
			$tags = $this->getArray($doc->documentElement, false);
			return $tags;
		} else {
			return false;
		}
	}

	/**
	 * Main function to convert the HTML
	 * @param string $file Path of the HTML file
	 * @return array HTML array
	 */
	public function convertHTML($file) {
		libxml_use_internal_errors(true);
		$doc = new DOMDocument();
		$doc->loadHTMLFile($file);
		$tags = $this->getArray($doc->documentElement, true);
		return $tags;
	}

	/**
	 * Function to do all the convertion works
	 * @param DOM $node DOMDocument object
	 * @return array HTML array
	 */
	public function getArray($node, $HTML) {
		$arr = $attrContent = array();
		$continue = true;
		if ($node->nodeType == XML_CDATA_SECTION_NODE) {
			$arr['val'] = $node->textContent;
		} else {
			$arr['tag'] = $node->nodeName;
		}
	    if ($node->hasAttributes()) {
	        foreach ($node->attributes as $attr) {
				if (isset($attr->nodeName) && isset($attr->nodeValue)) {
					$attrContent['attr'][$attr->nodeName] = $attr->nodeValue;
				}
	        }
	    }
		if ($node->hasChildNodes() && $continue) {
			if ((is_array($attrContent)) && (count($attrContent))) {
				$arr = array_merge($arr, $attrContent);
			}
			if ($node->childNodes->length > 0) {
				foreach ($node->childNodes as $childNode) {
					if ($childNode->nodeType != XML_TEXT_NODE) {
						$child = $this->getArray($childNode, $HTML);
						if ((is_array($child)) && (count($child))) {
							$arr['child'][] = $child;
						}
					} else {
						$str = preg_replace('!\s+!', ' ', $childNode->nodeValue);
						if (!empty($str)) {
							$arr['child'][]['val'] = $str;
						}
					}
				}
			}
		}
		if ((is_array($attrContent)) && (count($attrContent))) {
			$arr = array_merge($arr, $attrContent);
		}
	    return $arr;
	}

}

?>

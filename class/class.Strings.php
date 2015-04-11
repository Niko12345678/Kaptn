<?php

	// ====================================================================================== //
	// GAMMA FRAMEWORK - Strings static class                                                 //
	// Copyright (C) 2010 Lorenzo Stanco                                                      //
	// ====================================================================================== //
	
	/**
	 * Useful static methods to work with strings
	 * @author Lorenzo Stanco
	 */
	
	class Strings {
		
		/** Convert characters to HTML entities
		 * @param String $string String to escape
		 * @param Bool $all_whitespaces If TRUE (default) convert all whitespace to &amp;nbsp;
		 * @param Bool $xhtml If TRUE, make &lt;br/&gt; as XHTML (default: FALSE) */
		public static function html($string, $all_whitespaces = true, $xhtml = false) {
			$ret = nl2br(htmlentities_utf8($string));
			$ret = str_replace('<br />', ($xhtml ? '<br/>' : '<br>'), $ret);
			if ($all_whitespaces) $ret = str_replace("\t", '    ', $ret);
			if ($all_whitespaces) $ret = preg_replace('/[ ]{2}/', '&nbsp; ', $ret);
			return $ret;
		}

		/** Convert characters (&, ", ', < and >) to XML entities */
		public static function xml($string) {
			$ar1 = array('&', '"', "'", '<', '>');
			$ar2 = array('&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;');
			return str_replace($ar1, $ar2, $string);
		}
		
		/** Encodes a PHP variable into javascript representation.
		 * 
		 * Copied from Yii Framework: http://www.yiiframework.com/doc/api/1.1/CJavaScript 
		 * Yii Framework is released under the terms of the BSD License. */
		public static function javascriptEncode($value) {
			if      (is_string($value))  return "'" . self::javascriptQuote($value) . "'";
			else if	($value === null)    return 'null';
			else if	(is_bool($value))    return $value ? 'true' : 'false';
			else if	(is_integer($value)) return "$value";
			else if	(is_float($value))   return rtrim(sprintf('%.16F', $value), '0');
			else if	(is_object($value))  return self::javascriptEncode(get_object_vars($value));
			else if	(is_array($value)) {
				$es = array();
				if (($n = count($value)) > 0 && array_keys($value) !== range(0, $n-1)) {
					foreach ($value as $k=>$v) $es[] = "'" . self::javascriptQuote($k) . "':" . self::javascriptEncode($v);
					return '{' . implode(',', $es) . '}';
				} else {
					foreach ($value as $v) $es[] = self::javascriptEncode($v);
					return '[' . implode(',', $es) . ']';
				}
			} else return '';
		}
		
		/** Quotes a javascript string. 
		 * 
		 * After processing, the string can be safely enclosed 
		 * within a pair of quotation marks and serve as a javascript string.
		 * 
		 * Copied from Yii Framework: http://www.yiiframework.com/doc/api/1.1/CJavaScript 
		 * Yii Framework is released under the terms of the BSD License. */
		public static function javascriptQuote($js) {
			return strtr($js, array("\t"=>'\t', "\n"=>'\n', "\r"=>'\r', '"'=>'\"', '\''=>'\\\'', '\\'=>'\\\\', '</'=>'<\/'));
		}

		/** Remove non-alphanumeric characters from a string.
		 * @param String $string Input string
		 * @param Bool $to_lower If TRUE (default) lower case the string */
		public static function onlyAlphanum($string, $to_lower = true) {
			$ret = preg_replace("/[^a-zA-Z0-9]/", "", $string);
			return ($to_lower ? strtolower($ret) : $ret);
		}
		
		/** Truncate a string after n chars
		 * @param String $string The string to truncate
		 * @param Int $n Maximum number of chars
		 * @param String $append To string to append if trucation is done (default: '...') */
		public static function truncate($string, $n, $append = '...') {
			$n = intval($n);
			if (strlen($string) <= $n) return $string;
			return (substr($string, 0, $n) . $append);
		}
		
		/** Truncates text.
		 * 
		 * Cuts a string and replaces the last characters with the ending if the text is longer than length.<br>
		 * This is a more complex version of truncate() that handle words and HTML code correctly.
		 *
		 * Copied from CakePHP framework: http://www.gsdesign.ro/blog/cut-html-string-without-breaking-the-tags/ 
		 * CakePHP is licensed under the MIT license.
		 *
		 * @param String $text String to truncate.
		 * @param Int $length Length of returned string, including ellipsis (default 100)
		 * @param String $ending Ending to be appended to the trimmed string (default '...').
		 * @param Bool $exact If FALSE, text will not be cut mid-word (default TRUE)
		 * @param Bool $considerHtml If TRUE, HTML tags would be handled correctly (default FALSE) */
		public static function truncateText($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
			if ($considerHtml) {
				if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) return $text;
				preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
				$total_length = strlen($ending);
				$open_tags = array();
				$truncate = '';
				foreach ($lines as $line_matchings) {
					if (!empty($line_matchings[1])) {
						if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
						} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
							$pos = array_search($tag_matchings[1], $open_tags);
							if ($pos !== false) unset($open_tags[$pos]);
						} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
							array_unshift($open_tags, strtolower($tag_matchings[1]));
						}
						$truncate .= $line_matchings[1];
					}
					$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
					if ($total_length+$content_length> $length) {
						$left = $length - $total_length;
						$entities_length = 0;
						if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
							foreach ($entities[0] as $entity) {
								if ($entity[1]+1-$entities_length <= $left) {
									$left--;
									$entities_length += strlen($entity[0]);
								} else {
									break;
								}
							}
						}
						$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
						break;
					} else {
						$truncate .= $line_matchings[2];
						$total_length += $content_length;
					}
					if ($total_length>= $length) break;
				}
			} else {
				if (strlen($text) <= $length) return $text;
				else $truncate = substr($text, 0, $length - strlen($ending));
			}
			if (!$exact) {
				$spacepos = strrpos($truncate, ' ');
				if (isset($spacepos)) $truncate = substr($truncate, 0, $spacepos);
			}
			$truncate .= $ending;
			if ($considerHtml) foreach ($open_tags as $tag) $truncate .= '</' . $tag . '>';
			return $truncate;
		}
		
		/** Encode an email address
		 * @param String $email_address Input email address
		 * @param Bool $mailto Add the mailto: command */
		public static function encodeEmail($email_address, $mailto = false) {
			$ret = '';
			if ($mailto) $email_address = 'mailto:' . $email_address;
			$strlen = strlen($email_address);
			for ($i = 0; $i < $strlen; $i++)
				$ret .= '&#' . ord($email_address[$i]) . ';';
			return $ret;
		}

		/** Split a string by string, as PHP explode().
		 * @param String $delimiter The boundary string.
		 * @param String $string The input string.
		 * @param Int $limit As $limit in PHP explode(), default NULL.
		 * @return Array An array of strings or an empty array if $string or $delimiter is empty (this is the difference from PHP explode()). */
		public static function explode($delimiter, $string, $limit = null) {
			if (empty($string) || empty($delimiter)) return array();
			return (is_null($limit) ? explode($delimiter, $string) : explode($delimiter, $string, $limit));
		}
		
		/** Checks if a target string (haystack) starts with a specified string (needle) */
		public static function startsWith($haystack, $needle) {
			return (strpos($haystack, $needle) === 0);
		}
		
		/** Checks if a target string (haystack) ends with a specified string (needle) */
		public static function endsWith($haystack, $needle) {
			return (strrpos($haystack, $needle) === (strlen($haystack) - strlen($needle)));
		}

		/** Append a slash at the end of a file path, if none */
		public static function slashAppend($path) {
			if (substr($path, -1) != '/') return $path . '/';
			return $path;
		}

		/** Remove slash from the end of a file path, if one */
		public static function slashRemove($path) {
			if (substr($path, -1) == '/') return substr($path, 0, -1);
			return $path;
		}
		
		/** Create a http:// URL starting from a given string. */
		public static function toURL($string) {
			$expr = '/^(http|https|ftp|files|http):\\/\\//i';
			if (preg_match($expr, $string)) return $string;
			return 'http://' . $string;
		}
		
		/** Get the name of a website host from a giver URL */
		public static function getWebsiteHost($url, $strip_www = false) {
			$url = self::toURL($url);
			$expr = '/^(http|https|ftp|files|http):\\/\\/([^\\/]*)/i';
			$matches = array();
			if (!preg_match($expr, $url, $matches)) return false;
			$host = $matches[2];
			if ($strip_www) if (Strings::startsWith(strtolower($host), 'www.')) return substr($host, 4);
			return $host; 
		}
		
		/** Returns the extension of a filename, or FALSE if no extension */
		public static function filenameExtension($filename) {
			$pos = strrpos($filename, '.');
			if ($pos === false) return false;
			return substr($filename, $pos + 1);
		}

		/** Read last lines froma  file
		 * @param String $file Filepath
		 * @param Int $lines Line to read, default 1 */
		public static function readFileLastLines($file, $lines = 1) {

			// Ensure 1 line
			$lines = abs(intval($lines));
			if (!$lines) $lines = 1;

			// Start reading characters from the end of file
			if (($f = @fopen($file, "r")) === false) return '';
			$pos = -2;
			while ($lines && !fseek($f, $pos, SEEK_END)) {
				if (fgetc($f) == "\n") $lines--;
				$pos--;
			}

			// Rewind when file has no more lines (fseek "overflow")
			if ($lines) rewind($f);

			// Read until OEF, close file and return
			$t = fread($f, -$pos);
			fclose($f);
			return trim($t);

		}

		/** Outputs a filesize in human readable format.
		 * @param Int $val Filesize in bytes
		 * @param Int $round Decimals (default to 0)
		 * @return String */
		public static function humanizeFilesize($val, $round = 0) {
			$unit = array('','K','M','G','T','P','E','Z','Y');
			do { $val /= 1024; array_shift($unit); } while ($val >= 1000);
			return sprintf('%.'.intval($round).'f', $val) . ' ' . array_shift($unit) . 'B';
		}
		
		/** Encodes an ISO-8859-1 string or a whole multi-level
		 * array of strings to UTF-8.
		 * @param String/Array $arg A string or an array of strings
		 * @return String/Array UTF encoded string */
		public static function utf8Encode($arg) {
			if (is_object($arg)) $arg = get_object_vars($arg);
			if (!is_array($arg)) return utf8_encode($arg);
			foreach ($arg as $k => $v) $arg[$k] = self::utf8Encode($v);
			return $arg;
		}

		/** Converts a string or a whole multi-level array of strings
		 * encoded with UTF-8 to single-byte ISO-8859-1.
		 * @param String/Array $arg A string or an array of strings
		 * @return String/Array Decoded string  */
		public static function utf8Decode($arg) {
			if (is_object($arg)) $arg = get_object_vars($arg);
			if (!is_array($arg)) return utf8_decode($arg);
			foreach ($arg as $k => $v) $arg[$k] = self::utf8Decode($v);
			return $arg;
		}

		/** Converts a string encoded with UTF-8 to single-byte ASCII.
		 * 
		 * Characters can't be represented as ASCII byte will approximated through one or several
		 * similarly looking characters. This will remove all accents from the string.
		 * @param String $string A UTF-8 string
		 * @return String ASCII decoded string */
		public static function utf8TranslitToASCII($string) {
			return iconv('UTF-8', 'ASCII//TRANSLIT', $string);
		}
		
		/** Return a lowercase string with only ASCII alfanumeric chars, with - instead of other characters.
		 * 
		 * Characters can't be represented as ASCII byte will approximated through one or several
		 * similarly looking characters. This will remove all accents from the string.
		 * @param String $string Input string 
		 * @param Bool $utf8Input TRUE (default) if the input string is UTF-8, FALSE if it's ISO-8859-1
		 * @return String ASCII cleaned string */
		public static function urlify($string, $utf8Input = true) {
			$string = strtolower(iconv($utf8Input ? 'UTF-8' : 'ISO-8859-1', 'ASCII//TRANSLIT', $string));
			$string = preg_replace('/[^a-z0-9]+/', '-', $string);
			$string = trim($string, '-');
			if (empty($string)) return '-';
			return $string;
		}
		
		/** Returns the first non-empty passed argument or NULL if all passed arguments are empty */
		public static function coalesce() {
			foreach (func_get_args() as $arg) if (!empty($arg)) return $arg;
			return null;
		}

	}
	
	// ====================================================================================== //
	// Copyright (C) 2010 Lorenzo Stanco                                                      //
	// ====================================================================================== //
	
?>
<?php

	// ====================================================================================== //
	// GAMMA FRAMEWORK - Feed entry class                                                     //
	// Copyright (C) 2010 Lorenzo Stanco                                                      //
	// ====================================================================================== //

	/**
	 * Class for feed entries
	 * @author Lorenzo
	 */

	class FeedEntry {

		/**
		 * Article title.
		 * @var String
		 */
		public $title   = null;
		
		/**
		 * Article URL
		 * @var String
		 */
		public $link    = null;
		
		/**
		 * Article identifier, if NULL $link will be used.
		 * @var String
		 */
		public $guid    = null;
		
		/**
		 * Publication date, integer timestamps will be converted to RFC 2822 formatted date, strings will be used as given.
		 * @var Int/String
		 */
		public $pubDate = null;
		
		/**
		 * Article content.
		 * @var String
		 */
		public $content = null;
		
		/**
		 * Article creator.
		 * @var String
		 */
		public $creator = null;

		/** Feed entry constructor
		 * @param String $title Entry title */
		public function  __construct($title = null) {
			$this->title = $title;
		}

		/** Get XML code for this entry */
		public function getXML() {
			$item  = "<item>\n";
			$item .= '  <title>' . Strings::xml($this->title) . '</title>' . "\n";
			$item .= '  <link>'  . Strings::xml($this->link ) . '</link>'  . "\n";
			$item .= '  <guid isPermaLink="' . (empty($this->guid) ? 'true' : 'false') . '">'  . Strings::xml(empty($this->guid) ? $this->link : $this->guid) . '</guid>'  . "\n";
			if (!empty($this->pubDate)) $item .= '  <pubDate>' . Strings::xml((is_numeric($this->pubDate) ? date('r', $this->pubDate) : $this->pubDate)) . '</pubDate>' . "\n";
			if (!empty($this->content)) $item .= '  <description>' . '<![CDATA[' . str_replace(']]>', ']] >', $this->content) . ']]>' . '</description>' . "\n";
			if (!empty($this->creator)) $item .= '  <dc:creator>'  . Strings::xml($this->creator) . '</dc:creator>'  . "\n";
			$item .= "</item>\n\n";
			return $item;
		}

	}

	// ====================================================================================== //
	// Copyright (C) 2010 Lorenzo Stanco                                                      //
	// ====================================================================================== //
	
?>
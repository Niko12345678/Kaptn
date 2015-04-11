<?php

	// ====================================================================================== //
	// GAMMA FRAMEWORK - Feed creation class                                                  //
	// Copyright (C) 2010 Lorenzo Stanco                                                      //
	// ====================================================================================== //

	/**
	 * Class for feed creating
	 * @author Lorenzo
	 */

	class Feed {

		public $feed_title   = null;
		public $feed_link    = null;
		public $description  = null;
		public $website_link = null;
		public $lastBuildDate = null;

		private $items = array();

		/** Feed construct.
		 * @param String $feed_title Feed title
		 * @param String $feed_link Feed link
		 * @param String $description Description, optional
		 * @param String $website_link Website link, if NULL will be loaded from confifiguration */
		public function  __construct($feed_title = null, $feed_link = null, $description = null, $website_link = null) {
			$this->feed_title   = $feed_title;
			$this->feed_link    = $feed_link;
			$this->description  = $description;
			$this->website_link = $website_link;
			if (is_null($this->website_link)) $this->website_link = Config::$WEBSITE_URL;
		}

		/** Add a feed entry to the feed
		 * @param FeedEntry $feed_entry The entry
		 * @return Feed */
		public function addEntry($feed_entry) {
			$this->items[] = $feed_entry->getXML();
			return $this;
		}

		/** Reverse entries order
		 * @return Feed */
		public function reverseItems() {
			$this->items = array_reverse($this->items);
			return $this;
		}

		/** Save the feed to a file
		 * @throws FeedException on save failure
		 * @return Feed */
		public function saveToFile($filepath) {
			$ret = @file_put_contents($filepath, $this->getXML());
			if ($ret === false) throw new FeedException();
			return $this;
		}

		/** Output the feed as XML
		 * @return Feed */
		public function output() {
			header('Content-Type: text/xml; charset=utf-8');
			echo $this->getXML();
			return $this;
		}

		/** Get the feed XML **/
		public function getXML() {
			
			// Build date
			if (empty($this->lastBuildDate)) $this->lastBuildDate = time();

			// Header
			$xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
			$xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/">' . "\n";
			$xml .= '<channel>' . "\n\n";
			$xml .= '  <title>' . Strings::xml($this->feed_title  ) . '</title>' . "\n";
			$xml .= '  <link>'  . Strings::xml($this->website_link) . '</link>'  . "\n";
			$xml .= '  <atom:link href="' . Strings::xml($this->feed_link) . '" rel="self" type="application/rss+xml" />' . "\n";
			if (!empty($this->description)) $xml .= '  <description>' . Strings::xml($this->description) . '</description>'  . "\n";
			$xml .= '  <lastBuildDate>' . Strings::xml((is_numeric($this->lastBuildDate) ? date('r', $this->lastBuildDate) : $this->lastBuildDate)) . '</lastBuildDate>'  . "\n\n";

			// Items
			foreach ($this->items as $item) $xml .= $item;

			// End
			$xml .= '</channel>' . "\n";
			$xml .= '</rss>';
			return $xml;

		}

	}

	/** Feed exception class */
	class FeedException extends Exception {}

	// ====================================================================================== //
	// Copyright (C) 2010 Lorenzo Stanco                                                      //
	// ====================================================================================== //
	
?>
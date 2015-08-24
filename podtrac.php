<?php
/*
Plugin Name: Add Podtrac to Blubrry PowerPress
Version: 0.5
Description: Add a filter to bring Podtrac settings to PowerPress
Author: Jake Spurlock
Author URI: http://jakespurlock.com
*/

/**
 * If we have the option enabled for the measurement service, filter that onto the URL.
 *
 * @param  string     $html_link_tag The URL pointing to the file download.
 * @return string                    The URL pointing to the file download.
 */
function podtrac_download_url_filter( $html_link_tag ) {

	// The Regular Expression filter
	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

	// Check if there is a url in the text
	if ( preg_match( $reg_exUrl, $html_link_tag, $url ) ) {
		$parsed = parse_url( $url[0] );
		$full   = 'http://www.podtrac.com/pts/redirect.mp3/';
		$full  .= $parsed['host'];
		$full  .= $parsed['path'];
		$full  .= ( isset( $parsed['query'] ) ) ? '"' : '';

		return "\t\t" . str_replace( $url[0], $full, $html_link_tag );

	} else {

		return $html_link_tag;
	}

}

add_filter( 'rss_enclosure', 'podtrac_download_url_filter' );
add_filter( 'wp_audio_shortcode', 'podtrac_download_url_filter' );
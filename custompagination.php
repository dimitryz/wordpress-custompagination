<?php
/*
Plugin Name: Custom Pagination
Description: Turns post links with the Link URL 'page:next|prev|first|last|1|2|3|...' into an actual link to the corresponding page. If the page is invalid, the link is hidden. Developed for DateDaily.com 
Author: Dimitry Zolotaryov
Version: 1.0.2
Author URI: http://webit.ca
*/

add_action( 'the_content', 'cp_parse_content' );
add_action( 'admin_head', 'cp_in_admin' );

// indicates the number of links found
$_cp_links_found = 0;

// true indicates that the request is for the admin section
$_cp_in_admin = false;

/**
 * Flags the request as being in the admin.
 * 
 */
function cp_in_admin() {
	global $_cp_in_admin;
	$_cp_in_admin = true;
}

/**
 * Parses the text in search of marks to link to a different page.
 *
 * @param string $text The body of the post
 * @return string The body, formatted
 */
function cp_parse_content( $text ) {
	global $_cp_links_found, $_cp_in_admin;
	if ( $_cp_in_admin ) return $text;
	$_cp_links_found = 0;
	return preg_replace_callback(
		'/<a[^>]+href="page:(\d|next|previous|prev|first|last)"[^>]*>(.*)<\\/a>/siU',
		'_cp_replace_callback', $text );
	
}

/**
 * Function returns true if there were links found in the text of
 * the post. Otherwise, a false is returned.
 * 
 * @return boolean True or false
 */
function cp_link_found() {
	global $_cp_links_found;
	return $_cp_links_found > 0;
}

/**
 * Callback function called by a custom regular expression that finds links
 * to pages of a post.
 * 
 * For: /<a[^>]+href="page:(\d|next|previous|prev)"[^>]*>([^<]*)<\\/a>/
 *
 * @param array $matches Requires 3 matches: The full link, the page ID, and 
 * 						  the content in the link.
 * @return str The formated string or only the text
 */
function _cp_replace_callback( $matches ) {
	global $post, $page, $numpages, $_cp_links_found;
	
	$_cp_links_found++;
	
	if ( count( $matches ) < 3 ) {
		return $matches[ 0 ];
	}
	$pageid = $matches[ 1 ];
	$linkto = false;
	switch ( strtolower( $matches[ 1 ] ) ) {
		case 'first':
			if ( $page != 1 ) {
				$linkto = 1;
			}
			break;
		case 'last':
			if ( $page != $numpages ) {
				$linkto = $numpages;
			}
			break;
		case 'next':
			if ( $page < $numpages ) {
				$linkto = $page + 1;
			}
			break;
		case 'prev':
		case 'previous':
			if ( $page > 1 ) {
				$linkto = $page - 1;
			}
			break;
		default:
			$pageid = intval( $pageid );
			if ( $pageid > 0 || $pageid <= $numpages ) {
				$linkto = $pageid;
			}
	}
	if ( $linkto !== false ) {
		
		$anchor = $matches[ 0 ];
		
		// builds the URL structure
		if ( '' == get_option('permalink_structure')
			 || in_array($post->post_status, array('draft', 'pending')) )
			$link = get_permalink() . '&amp;page=' . $linkto;
		else
			$link = trailingslashit(get_permalink())
					. user_trailingslashit($linkto, 'single_paged');

		// adds the class name "page" to the link
		$classname = ' page ';
		if ( strpos( $matches[ 0 ], 'class="' ) !== false ) {
			$anchor = str_replace( 'class="',
								   'class="' . $classname,
									$anchor );			
		} else {
			$anchor = str_replace( '<a ',
								   '<a class="' . $classname . '" ',
								   $anchor );
		}
		
		return str_replace( 'href="page:' . $pageid . '"',
							'href="' . $link . '"',
							$anchor );
	} else {
		// no link, no text
		return '';
	}
}

?>

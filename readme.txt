=== Plugin Name ===
Contributors: dimitryz
Funded by: Mate1 Inc.
Tags: editing, pagination
Requires at least: 2.8
Tested up to: 4.1
Stable tag: 1.0.2

The Custom Pagination plugin allows a user to insert custom next, previous or numbered page links into a post.

== Description ==

With the Custom Pagination plugin, a user may customize the look of a post's next and previous links using the HTML editor. It is built by [WebIT.ca (Dimitry Zolotaryov)](http://webit.ca) and funded by [DateDaily.com](http://datedaily.com): an online dating and relationship blog.

The link is created by selecting the text label within a post's body and clicking the link icon. In the Link URL field, the following values will produce a link to another page:

* _page:next_ links to the next page
* _page:prev_ or _page:previous_ links to the previous page
* _page:first_ links to the first page of the post
* _page:last_ links to the last page of a post
* _page:n_ links to the nth page of a post (e.g. page:2 for the second page)

If link is directing to a page that does not exist -- for instance _page:next_ on the last page --, the link and the link text do not appear.

All links processed by Custom Pagination will have the added class name 'page'. If you wish to style such links, in your CSS, add the line:

    a.page { /* page style goes here */ }

For more information, visit the [Custom Pagination plugin homepage](http://webit.ca/2009/08/custom-pagination-plugin-for-wordpress/).

== Screenshots ==

1. Selecting text for a link to the next page
2. Adding the next page link text
3. The generated link

== Installation ==

1. Copy or upload the `custom-pagination` directory into your `/wp-content/plugins/` directory 
1. If you downloaded a zipped copy (i.e. `custom-pagination.zip`), use the 'Plugins' > 'Add New' section of WordPress to upload it
1. Activate the plugin through the 'Plugins' menu in WordPress

Done.

Actually, if you wish to use WordPress pagination when there is no Custom Pagination on a page, you may use the following PHP code:

	// inside single.php
	// displays the standard pagination when no custom pagination link is found
	if ( ! cp_link_found() )
  		wp_link_pages(array('next_or_number' => 'next', 'nextpagelink'=>'Next page &raquo;', 'previouspagelink'=>'&laquo; Previous page'));	
  	 

== Frequently Asked Questions ==

*Will the pagination work with custom permalinks?*

It should.

*What is the cost of the plugin?*

This plugin is provided free of charge thanks to the good people at [Mate1 Inc](http://mate1.com) and the site [DateDaily.com](http://datedaily.com). You may use the Custom Pagination plugin for any purpose provided you keep the comment section of the custompagination.php file.

*How do I remove the default pagination*

If you are seeing the default pagination in your posts, you probably have the following code in you `content.php` theme file. Remove it and the default pagination should disappear. 

<pre><code>
    wp_link_pages( array(
        'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
        'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
        'separator'   => '<span class="screen-reader-text">, </span>',
    ) );
</code></pre>

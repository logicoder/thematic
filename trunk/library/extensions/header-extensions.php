<?php


// Creates the DOCTYPE section
function thematic_create_doctype() {
    $content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
    $content .= '<html xmlns="http://www.w3.org/1999/xhtml"';
    echo apply_filters('thematic_create_doctype', $content);
} // end thematic_create_doctype


// Located in header.php 
// Creates the content of the Title tag
// Credits: Tarski Theme
function thematic_doctitle() {
    $site_name = get_bloginfo('name');
    $separator = '|';
        	
    if ( is_single() ) {
      $content = single_post_title('', FALSE);
    }
    elseif ( is_home() || is_front_page() ) { 
      $content = get_bloginfo('description');
    }
    elseif ( is_page() ) { 
      $content = single_post_title('', FALSE); 
    }
    elseif ( is_search() ) { 
      $content = __('Search Results for:', 'thematic'); 
      $content .= ' ' . wp_specialchars(stripslashes(get_search_query()), true);
    }
    elseif ( is_category() ) {
      $content = __('Category Archives:', 'thematic');
      $content .= ' ' . single_cat_title("", false);;
    }
    elseif ( is_tag() ) { 
      $content = __('Tag Archives:', 'thematic');
      $content .= ' ' . thematic_tag_query();
    }
    elseif ( is_404() ) { 
      $content = __('Not Found', 'thematic'); 
    }
    else { 
      $content = get_bloginfo('description');
    }

    if (get_query_var('paged')) {
      $content .= ' ' .$separator. ' ';
      $content .= 'Page';
      $content .= ' ';
      $content .= get_query_var('paged');
    }

    if($content) {
      if ( is_home() || is_front_page() ) {
          $elements = array(
            'site_name' => $site_name,
            'separator' => $separator,
            'content' => $content
          );
      }
      else {
          $elements = array(
            'content' => $content
          );
      }  
    } else {
      $elements = array(
        'site_name' => $site_name
      );
    }

    // Filters should return an array
    $elements = apply_filters('thematic_doctitle', $elements);
	
    // But if they don't, it won't try to implode
    if(is_array($elements)) {
      $doctitle = implode(' ', $elements);
    }
    else {
      $doctitle = $elements;
    }
    
    $doctitle = "\t" . "<title>" . $doctitle . "</title>" . "\n\n";
      
    echo $doctitle;
} // end thematic_doctitle


// Creates the content-type section
function thematic_create_contenttype() {
    $content  = "\t";
    $content .= "<meta http-equiv=\"Content-Type\" content=\"";
    $content .= get_bloginfo('html_type'); 
    $content .= "; charset=";
    $content .= get_bloginfo('charset');
    $content .= "\"";
    $content .= "/>";
    $content .= "\n\n";
    echo apply_filters('thematic_create_contenttype', $content);
} // end thematic_create_contenttype


// Creates the canonical URL
function thematic_canonical_url() {
    if ( is_singular() ) {
        $canonical_url ="\t";
        $canonical_url .= '<link rel="canonical" href="' . get_permalink() . '"/>';
        $canonical_url .= "\n\n";        
        echo apply_filters('thematic_canonical_url', $canonical_url);
    }
} // end thematic_canonical_url


// switch use of thematic_the_excerpt() - default: ON
function thematic_use_excerpt() {
    $display = TRUE;
    $display = apply_filters('thematic_use_excerpt', $display);
    return $display;
} // end thematic_use_excerpt


// switch use of thematic_the_excerpt() - default: OFF
function thematic_use_autoexcerpt() {
    $display = FALSE;
    $display = apply_filters('thematic_use_autoexcerpt', $display);
    return $display;
} // end thematic_use_autoexcerpt


// Creates the meta-tag description
function thematic_create_description() {
    if (is_single() || is_page() ) {
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                if (thematic_the_excerpt() == "") {
                    if (thematic_use_autoexcerpt()) {
                        $content ="\t";
                        $content .= "<meta name=\"description\" content=\"";
                        $content .= thematic_excerpt_rss();
                        $content .= "\" />";
                        $content .= "\n\n";
                    }
                } else {
                    if (thematic_use_excerpt()) {
                        $content ="\t";
                        $content .= "<meta name=\"description\" content=\"";
                        $content .= thematic_the_excerpt();
                        $content .= "\" />";
                        $content .= "\n\n";
                    }
                }
            }
        }
    } elseif ( is_home() || is_front_page() ) {
        $content ="\t";
        $content .= "<meta name=\"description\" content=\"";
        $content .= get_bloginfo('description');
        $content .= "\" />";
        $content .= "\n\n";
    }
    echo apply_filters ('thematic_create_description', $content);
} // end thematic_create_description


// meta-tag description is switchable using a filter
function thematic_show_description() {
    $display = TRUE;
    $display = apply_filters('thematic_show_description', $display);
    if ($display) {
        thematic_create_description();
    }
} // end thematic_show_description


// create meta-tag robots
function thematic_create_robots() {
    $content = "\t";
    if((is_home() && ($paged < 2 )) || is_front_page() || is_single() || is_page() || is_attachment()) {
      $content .= "<meta name=\"robots\" content=\"index,follow\" />";
    } elseif (is_search()) {
        $content .= "<meta name=\"robots\" content=\"noindex,nofollow\" />";
    } else {	
        $content .= "<meta name=\"robots\" content=\"noindex,follow\" />";
    }
    $content .= "\n\n";
    if (get_option('blog_public')) {
    		echo apply_filters('thematic_create_robots', $content);
    }
} // end thematic_create_robots


// meta-tag robots is switchable using a filter
function thematic_show_robots() {
    $display = TRUE;
    $display = apply_filters('thematic_show_robots', $display);
    if ($display) {
        thematic_create_robots();
    }
} // end thematic_show_robots


// Located in header.php
// creates link to style.css
function thematic_create_stylesheet() {
    $content = "\t";
    $content .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"";
    $content .= get_bloginfo('stylesheet_url');
    $content .= "\" />";
    $content .= "\n\n";
    echo apply_filters('thematic_create_stylesheet', $content);
}


// rss usage is switchable using a filter
function thematic_show_rss() {
    $display = TRUE;
    apply_filters('thematic_show_rss', $display);
    if ($display) {
        $content = "\t";
        $content .= "<link rel=\"alternate\" type=\"application/rss+xml\" href=\"";
        $content .= get_bloginfo('rss2_url');
        $content .= "\" title=\"";
        $content .= wp_specialchars(get_bloginfo('name'), 1);
        $content .= " " . __('Posts RSS feed', 'thematic');
        $content .= "\" />";
        $content .= "\n";
        echo apply_filters('thematic_rss', $content);
    }
} // end thematic_show_rss


// comments rss usage is switchable using a filter
function thematic_show_commentsrss() {
    $display = TRUE;
    apply_filters('thematic_show_commentsrss', $display);
    if ($display) {
        $content = "\t";
        $content .= "<link rel=\"alternate\" type=\"application/rss+xml\" href=\"";
        $content .= get_bloginfo('comments_rss2_url');
        $content .= "\" title=\"";
        $content .= wp_specialchars(get_bloginfo('name'), 1);
        $content .= " " . __('Comments RSS feed', 'thematic');
        $content .= "\" />";
        $content .= "\n\n";
        echo apply_filters('thematic_commentrss', $content);
    }
} // end thematic_show_commentsrss


// pingback usage is switchable using a filter
function thematic_show_pingback() {
    $display = TRUE;
    apply_filters('thematic_show_pingback', $display);
    if ($display) {
        $content = "\t";
        $content .= "<link rel=\"pingback\" href=\"";
        $content .= get_bloginfo('pingback_url');
        $content .= "\" />";
        $content .= "\n\n";
        echo $content;
    }
} // end thematic_show_pingback


// comment reply usage is switchable using a filter
function thematic_show_commentreply() {
    $display = TRUE;
    apply_filters('thematic_show_commentreply', $display);
    if ($display)
        if ( is_singular() ) 
            wp_enqueue_script( 'comment-reply' ); // support for comment threading
} // end thematic_show_commentreply


// Add ID and CLASS attributes to the first <ul> occurence in wp_page_menu
function thematic_add_menuclass($ulclass) {
	return preg_replace('/<ul>/', '<ul class="sf-menu">', $ulclass, 1);
} // end thematic_add_menuclass
add_filter('wp_page_menu','thematic_add_menuclass');


// Just after the opening body tag, before anything else.
function thematic_before() {
    do_action('thematic_before');
} // end thematic_before


// Just before the header div
function thematic_aboveheader() {
    do_action('thematic_aboveheader');
} // end thematic_aboveheader


// Used to hook in the HTML and PHP that creates the content of div id="header">
function thematic_header() {
    do_action('thematic_header');
} // end thematic_header


// Functions that hook into thematic_header()

		// Open #branding
		// In the header div
		function thematic_brandingopen() { ?>
		    	<div id="branding">
		<?php }
		add_action('thematic_header','thematic_brandingopen',1);
		
		
		// Create the blog title
		// In the header div
		function thematic_blogtitle() { ?>
		    		<div id="blog-title"><span><a href="<?php bloginfo('url') ?>/" title="<?php bloginfo('name') ?>" rel="home"><?php bloginfo('name') ?></a></span></div>
		<?php }
		add_action('thematic_header','thematic_blogtitle',3);
		
		
		// Create the blog description
		// In the header div
		function thematic_blogdescription() {
		    		if (is_home() || is_front_page()) { ?>
		    		<h1 id="blog-description"><?php bloginfo('description') ?></h1>
		    		<?php } else { ?>	
		    		<div id="blog-description"><?php bloginfo('description') ?></div>
		    		<?php }
		}
		add_action('thematic_header','thematic_blogdescription',5);
		
		
		// Close #branding
		// In the header div
		function thematic_brandingclose() { ?>
		    	</div><!--  #branding -->
		<?php }
		add_action('thematic_header','thematic_brandingclose',7);
		
		
		// Create #access
		// In the header div
		function thematic_access() { ?>
		    	<div id="access">
		    		<div class="skip-link"><a href="#content" title="<?php _e('Skip navigation to the content', 'thematic'); ?>"><?php _e('Skip to content', 'thematic'); ?></a></div>
		            <?php wp_page_menu('sort_column=menu_order') ?>
		        </div><!-- #access -->
		<?php }
		add_action('thematic_header','thematic_access',9);
		

// End of functions that hook into thematic_header()

		
// Just after the header div
function thematic_belowheader() {
    do_action('thematic_belowheader');
} // end thematic_belowheader
		

?>
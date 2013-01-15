<?php
/*
Plugin Name: Advanced Sitemap Generator
Plugin URI: http://www.csschopper.com/
Description: powerfull plugin to show all your pages and post on front end in a sitemap.
Version: 1.0.0
Author: Deepak Tripathi
Author URI: http://www.csschopper.com/
Author Email: deepak@sparxtechnologies.com
License: GPL
*/


// Hook for adding admin menus
add_action('admin_menu', 'custom_function');

function custom_function()
{
    add_options_page('sitemap', 'sitemap', 'manage_options', 'sitemapgenerator', 'sitemapfunction');
}

function sitemapfunction()
{
    ?>
<div><h2>Sitemap Setting</h2></div>
  <p>This plugin is the most powerfull plugin which easily display you post and page through shortcode on front end.You just need to put shortcode([sitemap]) on your page/post.</p>
      <p>If you want to exclude pages then put ([sitemap excludepage="1,4"]) where 1,4 are the page id seperated by the comma's.</p>
      <p>If you want to exclude categories then put ([sitemap excludepage="1,4" excludecat="6,3"]) where 6,3 are the category id seperated by the comma's.</p>
      <p>If you want to exclude post then put ([sitemap excludepage="1,4" excludecat="6,3" excludepost="1,183"]) where 1,183 are the post id seperated by the comma's.</p>
  </p> </br></br>
   <div>
       <h2>Screenshot1</h2>
  <div><img src="<?php echo plugins_url() ?>/sitemap-generator/images/screenshot-1.jpg" width="1100"/></div>
   </br><hr></br>
  <h2>Screenshot2</h2>
  <div><img src="<?php echo plugins_url() ?>/sitemap-generator/images/screenshot-2.jpg" width="1100"/></div>
  </br><hr></br></br>
  </div>

<?php
    
}
add_shortcode( 'sitemap', 'sitemap_function' );

function sitemap_function($atts)
{
    extract(shortcode_atts(array(
			"excludepage" => 0,
                        "excludecat" => 0,
                        "excludepost" => 0,
			), $atts));
    
    echo '<div class="manage-pagepost">';
    $args=array(
        'exclude'  => $atts[excludepage],
        'title_li' => ''
    );
    echo '<ul class="manage_page">';
    echo '<h3>Pages</h3>';
    wp_list_pages($args);
    echo '</ul>';
   echo '<ul class="manage_post">';
     echo '<h3>posts</h3>';
     $arr=explode(',',$atts[excludecat]);
     for($i=0;$i<count($arr);$i++)
     {
         $arr_new[]='-'.$arr[$i];
     }
     
     $excludecat=implode(',',$arr_new);
    
     
     $str=explode(',',$atts[excludepost]);
     $args = array(
	'post_type' => 'post',
	'cat' => $excludecat,
	'post__not_in' => $str
	
);
     query_posts($args);
    if (have_posts()) : while (have_posts()) : the_post();
       ?>
<li>
      <a href="<?php the_permalink();?>"><?php the_title();?></a>
</li>
<?php
     endwhile;
     endif;
     wp_reset_query();
    echo '</ul>';
    echo '</div>';
}
?>

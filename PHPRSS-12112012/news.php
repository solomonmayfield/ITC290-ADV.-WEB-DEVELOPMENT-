<?php
/**
 * news.php is a sample RSS feed aggregator page 
 *
 * @package nmRSS
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 1.0 2010/12/01
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see simplepie.inc 
 * @todo none
 */

//$error_reporting = 2047; #loosens error reporting for this page due to deprecation
//$error_handler = 'none'; #overrides 'custom' error handler for this page due to deprecation 
  
require 'inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
//include PHYSICAL_PATH . 'simplepie/SimplePieAutoloader.php';
//include PHYSICAL_PATH . 'simplepie/idn/idna_convert.class.php';
$cacheLocation = INCLUDE_PATH . 'feed-cache'; //server writable folder must be declared
$feedTerms = 'christmas+grinch'; #plus sign separated list of news 'search' terms!
$config->titleTag = "Grinch News!"; #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = 'Grinchy Christmas news!  All the lastest about the Grinch! ' . $config->metaDescription; #Add news topics to meta description.
$config->metaKeywords = 'grinch,grinches,christmas,whoville,cindy lou who,' . $config->metaKeywords; #Add news topics to meta description.

#add styles to the news items via loadhead
$config->loadhead = '
	<style type="text/css">
	div.header {
		border-bottom:1px solid #999;
	}
	div.item {
		padding:2px 0;
		border-bottom:1px solid #999;
	}
	</style>
';

/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# END CONFIG AREA ---------------------------------------------------------- 

#address of news feed - using google news!
$feedURL = 'http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&q=' . $feedTerms . '&cf=all&output=rss';

//$feedURL = 'http://zephir.seattlecentral.edu/~bnewman/fl10/grinch.xml';
$feed = new SimplePie(); #create default instance of SimplePie() object - no parameters passed this version
$feed->enable_cache(true);
$feed->set_cache_location($cacheLocation);#must create server writable dir here
$feed->set_cache_duration(15);
$feed->set_feed_url($feedURL); #pass URL of the desired feed
//$feed->force_feed(true); #if feed balks, use this little command!
$feed->init(); #initialize object
$feed->handle_content_type(); # Make sure that the content is sent to the browser as text/html & UTF-8 character set

get_header(); #defaults to theme header or header_inc.php
?>
<div class="header">
	<h3 align="center"><a href="<?php echo $feed->get_permalink(); ?>"><?=$config->titleTag;?></a></h3>
	<p><em>(News feed provided by <?php echo $feed->get_description(); ?>)</em></p>
</div>
<?php
/*
Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
*/
foreach ($feed->get_items() as $item):
?>
	<div class="item">
		<?php echo $item->get_description(); ?>
		<p><small><?php echo $item->get_date('j F Y | g:i a'); ?></small></p>
	</div>

<?php 
endforeach;
get_footer(); #defaults to theme header or footer_inc.php
?>

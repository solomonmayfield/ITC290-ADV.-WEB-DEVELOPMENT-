<?php
/**
 * read_feed_test.php is a test of PHP's simpleXML support
 *
 * @package nmRSS
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 1.0 2010/12/09
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @todo none
 */
 
$request = "http://rss.news.yahoo.com/rss/software";
$response = file_get_contents($request);
$xml = simplexml_load_string($response);
echo '<h3 align="center">' . $xml->channel->title . '</h3>';
foreach($xml->channel->item AS $story)
{
	echo '<div align="center"><a href="' . $story->link . '">' . $story->title . '</a></div>'; 
	echo '<p>' . $story->description . '</p><br /><br />';
}

?>
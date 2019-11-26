<?php
/**
 * feedwriter_db_test.php is a sample RSS feed aggregator page 
 *
 * @package nmRSS
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 1.0 2010/12/01
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see FeedWriter.php 
 * @todo none
 */
 
require 'inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

include PHYSICAL_PATH . 'feedwriter/FeedWriter.php'; #Path to FeedWriter include file

$sql = "blah";


// This is a minimum example of using the Universal Feed Generator Class
include("FeedWriter.php");

//Creating an instance of FeedWriter class. 
$TestFeed = new FeedWriter(RSS2);

//Setting the channel elements
//Use wrapper functions for common channel elements
$TestFeed->setTitle('Testing & Checking the RSS writer class');
$TestFeed->setLink('http://www.ajaxray.com/projects/rss');
$TestFeed->setDescription('This is test of creating a RSS 2.0 feed Universal Feed Writer');

//Image title and link must match with the 'title' and 'link' channel elements for valid RSS 2.0
$TestFeed->setImage('Testing the RSS writer class','http://www.ajaxray.com/projects/rss','http://www.rightbrainsolution.com/images/logo.gif');

# create mysqli (improved) connection to MySQL
$iConn = IDB::conn();

$result = mysqli_query($iConn,$sql) or die(trigger_error(mysqli_error($iConn), E_USER_ERROR));


while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	//Create an empty FeedItem
	$newItem = $TestFeed->createNewItem();
	
	//Add elements to the feed item    
	$newItem->setTitle($row['title']);
	$newItem->setLink($row['link']);
	$newItem->setDate($row['create_date']);
	$newItem->setDescription($row['description']);
	
	//Now add the feed item
	$TestFeed->addItem($newItem);
}

//OK. Everything is done. Now genarate the feed.
$TestFeed->genarateFeed();
?>
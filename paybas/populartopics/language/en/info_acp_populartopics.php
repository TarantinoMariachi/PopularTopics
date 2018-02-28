<?php
/**
 *
 * @package Popular Topics Extension
 * English translation by PayBas
 *
 * @copyright (c) 2015 PayBas
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * Based on the original NV Popular Topics by Joas Schilling (nickvergessen)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge(
	$lang, array(
	//forum acp
	'POPULAR_TOPICS_LIST'            => 'Display on “popular topics”',
	'POPULAR_TOPICS_LIST_EXPLAIN'    => 'Enable to display topics in this forum in the “popular topics” extension.',

	//acp title
	'POPULAR_TOPICS'                 => 'Popular Topics',
	'PT_CONFIG'                     => 'Configuration',
	'POPULAR_TOPICS_EXPLAIN'         => 'On this page you can change the settings specific for the Popular Topics extension.<br /><br />Specific forums can be included or excluded by editing the respective forums in your ACP.<br />Also be sure to check your user permissions, which allow users to change some of the settings found below for themselves.',

	//global settings
	'PT_GLOBAL_SETTINGS'            => 'Global Settings',
	'PT_DISPLAY_INDEX'              => 'Display on Index page',
	'PT_NUMBER'                     => 'Number of Popular topics to show',
	'PT_NUMBER_EXP'                 => 'Maximum number of topics to display per page.',
	'PT_PAGE_NUMBER'                => 'Show all popular topic pages.',
	'PT_PAGE_NUMBER_EXP'            => 'Check to override the maximum number of pages shown',
	'PT_PAGE_NUMBERMAX'             => 'Maximum number of pages',
	'PT_PAGE_NUMBERMAX_EXP'         => 'Set the page maximum (1-999) to display in the popular topics pagination unless overridden.',
	'PT_MIN_TOPIC_LEVEL'            => 'Minimum topic type level',
	'PT_MIN_TOPIC_LEVEL_EXP'        => 'Determines the minimum level of the topic-type to display. It will only display topics of the set level, and higher.',
	'PT_ANTI_TOPICS'                => 'Excluded topic ID’s',
	'PT_ANTI_TOPICS_EXP'            => 'The IDs of topics to exclude, separated by “,” (Example: 7,9)<br />The value 0 disables this behaviour.',
	'PT_PARENTS'                    => 'Display parent forums',
	'PT_PARENTS_EXP'                => 'Display parent forums inside the topic row of popular topics.',

	//User Overridable settings. these apply for anon users and can be overridden by UCP
	'PT_OVERRIDABLE'                => 'UCP overridable Settings',
	'PT_LOCATION'                   => 'Display location',
	'PT_LOCATION_EXP'               => 'Select location to display popular topics.',
	'PT_TOP'                        => 'Show on top',
	'PT_BOTTOM'                     => 'Show on bottom',
	'PT_SIDE'                       => 'Show on side',
	'PT_SORT_START_TIME'            => 'Sort by topic start time',
	'PT_SORT_START_TIME_EXP'        => 'Enable to sort popular topics by the starting time of the topic, instead of the last post time.',
	'PT_UNREAD_ONLY'                => 'Only display unread topics',
	'PT_UNREAD_ONLY_EXP'            => 'Enable to only display unread topics (whether they are “popular” or not). This function uses the same settings (excluding forums/topics etc.) as normal mode. Note: this only works for logged-in users; guests will get the normal list.',
	'PT_RESET_DEFAULT'              => 'Reset user settings',
	'PT_RESET_DEFAULT_EXP'          => 'Reset user settings to default.',

	//Enable for extensions
	'PT_NICKVERGESSEN_NEWSPAGE'     => 'Support for NewsPage Extension',
	'PT_VIEW_ON'                    => 'Display popular topics on:',

	//Version checker
	'PT_VERSION_CHECK'				=> 'Version Check',
	'PT_LATEST_VERSION'				=> 'Latest version',
	'PT_EXT_VERSION'				=> 'Extension version',
	'PT_VERSION_ERROR'				=> 'Unable to check latest version!',
	'PT_CHECK_UPDATE'				=> 'Check <a href="http://www.avathar.be/bbdkp/index.php">avathar.be</a> to see if there are updates available.',

	//Donation
	'PT_DONATE_URL'             => 'http://www.avathar.be/bbdkp/app.php/page/donate',
	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
	'PAYPAL_ALT'                => 'Donate using PayPal',
	'PT_DONATE'					=> 'Donate to PopularTopics',
	'PT_DONATE_SHORT'			=> 'Make a donation to PopularTopics',
	'PT_DONATE_EXPLAIN'			=> 'PopularTopics is 100% free. It is a hobby project that I am spending my time and money on, just for the fun of it. If you enjoy using PopularTopics, please consider making a donation. I would really appreciate it. No strings attached.',
	)
);

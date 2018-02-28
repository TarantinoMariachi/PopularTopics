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
	'ACL_U_PT_VIEW'            => 'Popular Topics: can view Popular topics.',
	'ACL_U_PT_ENABLE'          => 'Popular Topics: can enable or disable Displaying Popular Topics.',
	'ACL_U_PT_LOCATION'        => 'Popular Topics: can select display location of Popular topics blocks.',
	'ACL_U_PT_SORT_START_TIME' => 'Popular Topics: can change topic sort order.',
	'ACL_U_PT_UNREAD_ONLY'     => 'Popular Topics: can change setting to only display unread topics.',
	'ACL_U_PT_NUMBER'          => 'Popular Topics: can change setting of number of popular topics to show per page.',
	)
);

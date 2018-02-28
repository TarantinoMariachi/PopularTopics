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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge(
	$lang, array(
	'PT_ENABLE'              => 'Display popular topics',
	'PT_BOTTOM'              => 'Show on bottom',
	'PT_SIDE'                => 'Show on side',
	'PT_TOP'                 => 'Show on top',
	'PT_LOCATION'            => 'Select location',
	'PT_LOCATION_EXP'        => 'Select location to display popular topics.',
	'PT_NUMBER'              => 'Number of popular topics to show',
	'PT_NUMBER_EXP'          => 'Maximum number of topics to display per page.',
	'PT_SORT_START_TIME'     => 'Sort popular topics by topic start time',
	'PT_SORT_START_TIME_EXP' => 'Instead of sorting them by last post time.',
	'PT_UNREAD_ONLY'         => 'Only display unread topics in popular topics',
	)
);

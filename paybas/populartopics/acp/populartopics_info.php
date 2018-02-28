<?php
/**
 *
 * @package Popular Topics Extension
 * @copyright (c) 2015 PayBas
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * Based on the original NV Popular Topics by Joas Schilling (nickvergessen)
 */

namespace paybas\populartopics\acp;

/**
 * Class populartopics_info
 *
 * @package paybas\populartopics\acp
 */
class populartopics_info
{
	/**
	 * @return array
	 */
	public function module()
	{
		return array(
		'filename'    => '\paybas\populartopics\populartopics_module',
		'title'        => 'POPULAR_TOPICS',
		'modes'        => array(
		'populartopics_config' => array('title' => 'PT_CONFIG', 'auth' => 'ext_paybas/populartopics && acl_a_board', 'cat' => array('POPULAR_TOPICS')),
		),
		);
	}
}

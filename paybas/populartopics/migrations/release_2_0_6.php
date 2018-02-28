<?php
/**
 *
 * @package Popular Topics Extension
 * @copyright (c) 2015 PayBas
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * Based on the original NV Popular Topics by Joas Schilling (nickvergessen)
 */

namespace paybas\populartopics\migrations;

class release_2_0_6 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['pt_version']) && version_compare($this->config['pt_version'], '2.0.6', '>=');
	}

	static public function depends_on()
	{
		return array(
			'\paybas\populartopics\migrations\release_2_0_5',
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns'    => array(
				$this->table_prefix . 'users' => array(
					'user_pt_enable'          => array('BOOL', 1),
					'user_pt_alt_location'    => array('BOOL', 0),
					'user_pt_sort_start_time' => array('BOOL', 0),
					'user_pt_unread_only'     => array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'    => array(
				$this->table_prefix . 'users' => array(
					'user_pt_enable',
					'user_pt_alt_location',
					'user_pt_sort_start_time',
					'user_pt_unread_only',
				),
			),
		);
	}

	public function update_data()
	{
		return array(
			array('config.remove', array('pt_unreadonly')),
			array('config.add', array('pt_unread_only', 0)),
			array('config.add', array('pt_alt_location', 0)),
			array('config.update', array('pt_version', '2.0.6')),
			array('permission.add', array('u_pt_view')),
			array('permission.add', array('u_pt_enable')),
			array('permission.add', array('u_pt_alt_location')),
			array('permission.add', array('u_pt_sort_start_time')),
			array('permission.add', array('u_pt_unread_only')),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_pt_view')),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_pt_enable')),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_pt_alt_location')),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_pt_sort_start_time')),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_pt_unread_only')),
			array('permission.permission_set', array('GUESTS', 'u_pt_view', 'group')),
		);
	}

	public function revert_data()
	{
		return array(
			array('config.remove', array('pt_unread_only')),
			array('config.remove', array('pt_alt_location')),

			array('permission.remove', array('u_pt_view')),
			array('permission.remove', array('u_pt_enable')),
			array('permission.remove', array('u_pt_alt_location')),
			array('permission.remove', array('u_pt_sort_start_time')),
			array('permission.remove', array('u_pt_unread_only')),

		);
	}
}

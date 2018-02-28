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

class release_2_1_0 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['pt_version']) && version_compare($this->config['pt_version'], '2.1.0', '>=');
	}

	static public function depends_on()
	{
		return array(
			'\paybas\populartopics\migrations\release_2_0_6',
		);
	}

	public function update_schema()
	{
		return array(
			'drop_columns'    => array(
				$this->table_prefix . 'users' => array(
					'user_pt_alt_location',
				),
			),

			'add_columns'    => array(
				$this->table_prefix . 'users' => array(
					'user_pt_location'    => array('VCHAR:10', 'PT_TOP'),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'		=> array(
				$this->table_prefix . 'users'		=> array(
					'user_pt_location',
					'user_pt_alt_location',
				),
			),

		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('pt_version', '2.1.0')),
			array('config.remove', array('pt_alt_location')),
			array('config.add',    array('pt_location', 'PT_TOP')),

			array('permission.remove', array('u_pt_alt_location')),
			array('permission.add', array('u_pt_location')),

			array('permission.permission_set', array('ROLE_USER_FULL', 'u_pt_location')),

		);
	}

	public function revert_data()
	{
		return array(
			array('config.remove', array('pt_location')),
			array('permission.remove', array('u_pt_location')),

		);
	}
}

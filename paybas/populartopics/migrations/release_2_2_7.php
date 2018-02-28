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

class release_2_2_7 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['pt_version']) && version_compare($this->config['pt_version'], '2.2.7', '>=');
	}

	static public function depends_on()
	{
		return array(
			'\paybas\populartopics\migrations\release_2_2_6',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('pt_version', '2.2.7')),
			array('permission.add', array('u_pt_number')),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_pt_number')),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_pt_view')),
		);
	}

	public function revert_data()
	{
		return array(
			array('permission.remove', array('u_pt_number')),
			array('config.update', array('pt_version', '2.2.6')),
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns'    => array(
				$this->table_prefix . 'users' => array(
					'user_pt_number'      => array('UINT', 5),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'    => array(
				$this->table_prefix . 'users' => array(
					'user_pt_number',
				),
			),
		);
	}
}

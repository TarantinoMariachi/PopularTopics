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

class release_2_1_2 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['pt_version']) && version_compare($this->config['pt_version'], '2.1.2', '>=');
	}

	static public function depends_on()
	{
		return array(
			'\paybas\populartopics\migrations\release_2_1_1',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('pt_version', '2.1.2')),
			array('permission.remove', array('u_pt_view')),
			array('permission.add', array('u_pt_view')),
			array('permission.permission_set', array('REGISTERED', 'u_pt_view', 'group')),
			array('permission.permission_set', array('GUESTS', 'u_pt_view', 'group')),
		);

	}


}

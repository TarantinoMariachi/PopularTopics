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

class release_2_1_3 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['pt_version']) && version_compare($this->config['pt_version'], '2.1.3', '>=');
	}

	static public function depends_on()
	{
		return array(
			'\paybas\populartopics\migrations\release_2_1_2',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('pt_version', '2.1.3')),
			array('custom', array(array($this, 'update_default_ptloc'))),
		);

	}

	public function update_default_ptloc()
	{
		$pt_location = 'PT_TOP';
		$this->config->set('pt_location', $pt_location);
		$sql = 'UPDATE ' . USERS_TABLE . " SET user_pt_location = '" . $pt_location . "' ";
		$this->db->sql_query($sql);
	}

}

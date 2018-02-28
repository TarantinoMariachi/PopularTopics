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

class release_2_0_4 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['pt_version']) && version_compare($this->config['pt_version'], '2.0.4', '>=');
	}

	static public function depends_on()
	{
		return array(
		'\paybas\populartopics\migrations\release_2_0_0',
		);
	}

	public function update_data()
	{
		return array(
		array('config.update', array('pt_version', '2.0.4')),
		array('config.add', array('pt_min_topic_level', 0)),
		);
	}
}

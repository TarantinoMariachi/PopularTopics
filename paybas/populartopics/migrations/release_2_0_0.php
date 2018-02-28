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

class release_2_0_0 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['pt_version']) && version_compare($this->config['pt_version'], '2.0.0', '>=');
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'forums' => array(
					'forum_popular_topics' => array('TINT:1', 1),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'forums' => array(
					'forum_popular_topics',
				),
			),
		);
	}

	public function update_data()
	{
		return array(

			// Remove old config if it exists
			array('if', array(
				isset($this->config['populartopics']),
				array('config.remove', array('populartopics')),
			)),
			array('if', array(
				isset($this->config['pt_mod_version']),
				array('config.remove', array('pt_mod_version')),
			)),
			array('if', array(
				isset($this->config['pt_version']),
				array('config.remove', array('pt_version')),
			)),
			array('if', array(
				isset($this->config['pt_number']),
				array('config.remove', array('pt_number')),
			)),
			array('if', array(
				isset($this->config['pt_page_number']),
				array('config.remove', array('pt_page_number')),
			)),
			array('if', array(
				isset($this->config['pt_anti_topics']),
				array('config.remove', array('pt_anti_topics')),
			)),
			array('if', array(
				isset($this->config['pt_parents']),
				array('config.remove', array('pt_parents')),
			)),
			array('if', array(
				isset($this->config['pt_index']),
				array('config.remove', array('pt_index')),
			)),

			// Add new config vars
			array('config.add', array('pt_version', '2.0.0')),
			array('config.add', array('pt_number', 5)),
			array('config.add', array('pt_page_number', 0)),
			array('config.add', array('pt_anti_topics', 0)),
			array('config.add', array('pt_parents', 1)),
			array('config.add', array('pt_unreadonly', 0)),
			array('config.add', array('pt_index', 1)),

			// Remove old (v1) modules
			array('if', array(
				array('module.exists', array('acp', 'POPULAR_TOPICS_MOD', array(
					'module_basename'    => 'populartopics',
					'modes'    => array('overview'),
				),
				)),
				array('module.remove', array('acp', 'POPULAR_TOPICS_MOD', array(
					'module_basename'    => 'populartopics',
					'modes'    => array('overview'),
				),
				)),
			)),
			array('if', array(
				array('module.exists', array('acp', 'ACP_CAT_DOT_MODS', 'POPULAR_TOPICS_MOD')),
				array('module.remove', array('acp', 'ACP_CAT_DOT_MODS', 'POPULAR_TOPICS_MOD')),
			)),

			// Remove early beta modules
			array('if', array(
				array('module.exists', array('acp', 'ACP_CAT_DOT_MODS', array(
					'module_basename'    => '\paybas\populartopics\acp\populartopics_module',
					'modes'    => array('populartopics_config'),
				),
				)),
				array('module.remove', array('acp', 'ACP_CAT_DOT_MODS', array(
					'module_basename'    => '\paybas\populartopics\acp\populartopics_module',
					'modes'    => array('populartopics_config'),
				),
				)),
			)),

			array('if', array(
				array('module.exists', array('acp', 'ACP_CAT_DOT_MODS', 'POPULAR_TOPICS_EXT')),
				array('module.remove', array('acp', 'ACP_CAT_DOT_MODS', 'POPULAR_TOPICS_EXT')),
			)),

			// Add new modules
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'POPULAR_TOPICS'
			)),

			array('module.add', array(
				'acp',
				'POPULAR_TOPICS',
				array(
					'module_basename'    => '\paybas\populartopics\acp\populartopics_module',
					'modes'    => array('populartopics_config'),
				),
			)),
		);
	}

	public function revert_data()
	{
		return array(
			array('config.remove', array('pt_version')),
			array('config.remove', array('pt_number')),
			array('config.remove', array('pt_page_number')),
			array('config.remove', array('pt_anti_topics')),
			array('config.remove', array('pt_parents')),
			array('config.remove', array('pt_unreadonly')),
			array('config.remove', array('pt_index')),

			array('module.remove', array(
				'acp',
				'POPULAR_TOPICS',
				array(
					'module_basename'    => '\paybas\populartopics\acp\populartopics_module',
					'modes'    => array('populartopics_config'),
				),
			)),
			array('module.remove', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'POPULAR_TOPICS'
			)),
		);
	}
}

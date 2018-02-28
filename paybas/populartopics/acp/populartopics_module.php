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

use paybas\populartopics\core\admin;

/**
 * Class populartopics_module
 *
 * @package paybas\populartopics\acp
 */
class populartopics_module extends admin
{
	public $u_action;

	/**
	 * @param $id
	 * @param $mode
	 */
	public function main($id, $mode)
	{
		global $config, $phpbb_extension_manager, $request, $template, $user, $db, $phpbb_container;

		$language = $phpbb_container->get('language');
		$language->add_lang('acp/common');
		$language->add_lang('ucp');
		$language->add_lang('viewforum');

		$this->tpl_name = 'acp_populartopics';
		$this->page_title = $user->lang('POPULAR_TOPICS');

		$form_key = 'acp_populartopics';
		add_form_key($form_key);

		//version check
		$ext_manager = $phpbb_container->get('ext.manager');
		$ext_meta_manager = $ext_manager->create_extension_metadata_manager('paybas/populartopics', $phpbb_container->get('template'));
		$meta_data  = $ext_meta_manager->get_metadata();
		$ext_version  = $meta_data['version'];
		$versionurl = $meta_data['extra']['version-check']['host'].$meta_data['extra']['version-check']['directory'].'/'.$meta_data['extra']['version-check']['filename'];
		$latest_version  = $this->version_check($versionurl, $request->variable('versioncheck_force', false));

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			/*
			* acp options for everyone
			*/

			//enable-disable paging
			$pt_page_number = $request->variable('pt_page_number', '');
			$config->set('pt_page_number', $pt_page_number == 'on' ? 1 : 0 );

			// maximum number of pages
			$pt_page_numbermax = $request->variable('pt_page_numbermax', 0);
			$config->set('pt_page_numbermax', $pt_page_numbermax);

			$pt_min_topic_level = $request->variable('pt_min_topic_level', 0);
			$config->set('pt_min_topic_level', $pt_min_topic_level);

			// variable should be '' as it is a string ("1, 2, 3928") here, not an integer.
			$pt_anti_topics = $request->variable('pt_anti_topics', '');
			$config->set('pt_anti_topics', $pt_anti_topics);

			$pt_parents = $request->variable('pt_parents', false);
			$config->set('pt_parents', $pt_parents);

			// Enable on other extension pages?
			$pt_on_newspage = $request->variable('pt_on_newspage', 0);
			$config->set('pt_on_newspage', $pt_on_newspage);

			/*
			 *  default positions, modifiable by ucp
	         */
			//number of most popular topics shown per page
			$pt_number = $request->variable('pt_number', 5);
			$config->set('pt_number', $pt_number);

			$pt_enable = $request->variable('pt_enable', 0);
			$config->set('pt_index', $pt_enable);

			$pt_location = $request->variable('pt_location', '');
			$config->set('pt_location', $pt_location);

			$pt_sort_start_time = $request->variable('pt_sort_start_time', false);
			$config->set('pt_sort_start_time', $pt_sort_start_time);

			$pt_unread_only = $request->variable('pt_unread_only', false);
			$config->set('pt_unread_only', $pt_unread_only);

			trigger_error($user->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$topic_types = array (
			0 => $language->lang('POST') ,
			1 => $language->lang('POST_STICKY'),
			2 => $language->lang('ANNOUNCEMENTS'),
			3 => $language->lang('GLOBAL_ANNOUNCEMENT'),
		);

		foreach ($topic_types as $key => $topic_type)
		{
			$template->assign_block_vars(
				'topiclevel_row',
				array(
					'VALUE'    => $key,
					'SELECTED' => ($config['pt_min_topic_level'] == $key) ? ' selected="selected"' : '',
					'OPTION'   => $topic_type,
				)
			);
		}

		$display_types = array (
			'PT_TOP'    => $language->lang('PT_TOP'),
			'PT_BOTTOM' => $language->lang('PT_BOTTOM'),
			'PT_SIDE'   => $language->lang('PT_SIDE'),
		);

		foreach ($display_types as $key => $display_type)
		{
			$template->assign_block_vars(
				'location_row',
				array(
					'VALUE'    => $key,
					'SELECTED' => ($config['pt_location'] == $key) ? ' selected="selected"' : '',
					'OPTION'   => $display_type,
				)
			);
		}

		$template->assign_vars(
			array(
				'U_ACTION'           => $this->u_action,
				'PT_INDEX'           => isset($config['pt_index']) ? $config['pt_index'] : false,
				'PT_PAGE_NUMBER'     => ((isset($config['pt_page_number']) ? $config['pt_page_number'] : '') == '1') ? 'checked="checked"' : '',
				'PT_PAGE_NUMBERMAX'  => isset($config['pt_page_numbermax']) ? $config['pt_page_numbermax'] : '',
				'PT_ANTI_TOPICS'     => isset($config['pt_anti_topics']) ? $config['pt_anti_topics'] : '',
				'PT_PARENTS'         => isset($config['pt_parents']) ? $config['pt_parents'] : false,
				'PT_NUMBER'          => isset($config['pt_number']) ? $config['pt_number'] : '',
				'PT_SORT_START_TIME' => isset($config['pt_sort_start_time']) ? $config['pt_sort_start_time'] : false,
				'PT_UNREAD_ONLY'     => isset($config['pt_unread_only']) ? $config['pt_unread_only'] : false,
				'PT_ON_NEWSPAGE'     => isset($config['pt_on_newspage']) ? $config['pt_on_newspage'] : false,
				'S_PT_NEWSPAGE'      => $phpbb_extension_manager->is_enabled('nickvergessen/newspage'),
				'S_PT_OK'           => version_compare($ext_version, $latest_version, '=='),
				'S_PT_OLD'          => version_compare($ext_version, $latest_version, '<'),
				'S_PT_DEV'          => version_compare($ext_version, $latest_version, '>'),
				'EXT_VERSION'           => $ext_version,
				'U_VERSIONCHECK_FORCE'  => append_sid($this->u_action . '&amp;versioncheck_force=1'),
				'PT_LATESTVERSION'      => $latest_version,
			)
		);

		//reset user preferences
		if ($request->is_set_post('pt_reset_default'))
		{
			$pt_unread_only = isset($config['pt_unread_only']) ? ($config['pt_unread_only']=='' ? 0 :$config['pt_unread_only'])  : 0;
			$pt_sort_start_time = isset($config['pt_sort_start_time']) ?  ($config['pt_sort_start_time']=='' ? 0 : $config['pt_sort_start_time'])  : 0;
			$pt_enable =  isset($config['pt_index']) ? ($config['pt_index']== '' ? 0 : $config['pt_index']) : 0;
			$pt_location = $config['pt_location'];
			$pt_number = isset($config['pt_number']) ? ($config['pt_number']=='' ? 0 :$config['pt_number'])  : 5;

			$sql = 'UPDATE ' . USERS_TABLE . ' SET
			user_pt_enable = ' . (int) $pt_enable . ',
			user_pt_sort_start_time = ' . (int) $pt_sort_start_time . ',
			user_pt_unread_only = ' . (int) $pt_unread_only . ',
			user_pt_number = ' . (int) $pt_number . ",
			user_pt_location =  '" . $db->sql_escape($pt_location) . "'" ;

			$db->sql_query($sql);
		}

	}

	/**
	 * retrieve latest version
	 *
	 * @param  bool $force_update Ignores cached data. Defaults to false.
	 * @param  int  $ttl          Cache version information for $ttl seconds. Defaults to 86400 (24 hours).
	 * @return bool
	 */
	public final function version_check($versionurl, $force_update = false, $ttl = 86400)
	{
		global $user, $cache;

		//get latest productversion from cache
		$latest_version = $cache->get('populartopics_versioncheck');

		//if update is forced or cache expired then make the call to refresh latest productversion
		if ($latest_version === false || $force_update)
		{
			$data = parent::curl($versionurl, false, false, false);
			if (0 === count($data) )
			{
				$cache->destroy('populartopics_versioncheck');
				return false;
			}

			$response = $data['response'];
			$latest_version = json_decode($response, true);
			$latest_version = $latest_version['stable']['3.2']['current'];

			//put this info in the cache
			$cache->put('populartopics_versioncheck', $latest_version, $ttl);

		}

		return $latest_version;
	}
}

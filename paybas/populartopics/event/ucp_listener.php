<?php
/**
 *
 * @package Popular Topics Extension
 * @copyright (c) 2015 PayBas
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * Based on the original NV Popular Topics by Joas Schilling (nickvergessen)
 */

namespace paybas\populartopics\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\language\language;

/**
 * An EventSubscriber knows himself what events he is interested in.
 * If an EventSubscriber is added to an EventDispatcherInterface, the manager invokes
 * {@link getSubscribedEvents} and registers the subscriber as a listener for all
 * returned events.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Jonathan Wage <jonwage@gmail.com>
 * @author Roman Borschel <roman@code-factory.org>
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class ucp_listener implements EventSubscriberInterface
{
	/**
	* @var \phpbb\auth\auth
	*/
	protected $auth;

	/**
	* @var \phpbb\config\config
	*/
	protected $config;

	/**
	* @var \phpbb\request\request
	*/
	protected $request;

	/**
	* @var \phpbb\template\template
	*/
	protected $template;

	/**
	* @var \phpbb\user
	*/
	protected $user;

	/**
	 * @var language
	 */
	protected $language;

	/**
	 * ucp_listener constructor.
	 *
	 * @param \phpbb\auth\auth         $auth
	 * @param \phpbb\config\config     $config
	 * @param \phpbb\request\request   $request
	 * @param \phpbb\template\template $template
	 * @param \phpbb\user              $user
	 * @param \phpbb\language\language $language
	 */
	public function __construct(\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\language\language $language)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
	}

	/**
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return array(
		'core.ucp_prefs_view_data'        => 'ucp_prefs_get_data',
		'core.ucp_prefs_view_update_data' => 'ucp_prefs_set_data',
		);
	}

	/**
	 * @param $event
	 */
	public function ucp_prefs_get_data($event)
	{
		// Request the user option vars and add them to the data array
		$event['data'] = array_merge(
			$event['data'], array(
			'pt_enable'          => $this->request->variable('pt_enable', (int) $this->user->data['user_pt_enable']),
			'pt_location'        => $this->request->variable('pt_location', $this->user->data['user_pt_location']),
			'pt_number'          => $this->request->variable('pt_number', $this->user->data['user_pt_number']),
			'pt_sort_start_time' => $this->request->variable('pt_sort_start_time', (int) $this->user->data['user_pt_sort_start_time']),
			'pt_unread_only'     => $this->request->variable('pt_unread_only', (int) $this->user->data['user_pt_unread_only']),
			)
		);

		// Output the data vars to the template (except on form submit)
		if (!$event['submit'] && $this->auth->acl_get('u_pt_view'))
		{
			$this->language->add_lang('populartopics_ucp', 'paybas/populartopics');

			$template_vars = array();

			if ($this->auth->acl_get('u_pt_enable') || $this->auth->acl_get('u_pt_location') || $this->auth->acl_get('u_pt_sort_start_time') || $this->auth->acl_get('u_pt_unread_only'))
			{
				$template_vars += array(
				'S_PT_SHOW' => true,
				);
			}

			if ($this->auth->acl_get('u_pt_enable'))
			{
				$template_vars += array(
				'A_PT_ENABLE' => true,
				'S_PT_ENABLE' => $event['data']['pt_enable'],
				);
			}

			if ($this->auth->acl_get('u_pt_location'))
			{

				$template_vars += array(
					'A_PT_LOCATION' => true,
				);

				$display_types = array (
					'PT_TOP'    => $this->language->lang('PT_TOP'),
					'PT_BOTTOM' => $this->language->lang('PT_BOTTOM'),
					'PT_SIDE'   => $this->language->lang('PT_SIDE'),
				);

				foreach ($display_types as $key => $display_type)
				{
					$this->template->assign_block_vars(
						'location_row',
						array(
							'VALUE'    => $key,
							'SELECTED' => ($event['data']['pt_location'] == $key) ? ' selected="selected"' : '',
							'OPTION'   => $display_type,
						)
					);
				}
			}

			if ($this->auth->acl_get('u_pt_number'))
			{
				$template_vars += array(
					'A_PT_NUMBER' => true,
					'PT_NUMBER' => $event['data']['pt_number'],
				);
			}

			if ($this->auth->acl_get('u_pt_sort_start_time'))
			{
				$template_vars += array(
				'A_PT_SORT_START_TIME' => true,
				'S_PT_SORT_START_TIME' => $event['data']['pt_sort_start_time'],
				);
			}

			if ($this->auth->acl_get('u_pt_unread_only'))
			{
				$template_vars += array(
				'A_PT_UNREAD_ONLY' => true,
				'S_PT_UNREAD_ONLY' => $event['data']['pt_unread_only'],
				);
			}

			$this->template->assign_vars($template_vars);
		}
	}

	/**
	 * @param $event
	 */
	public function ucp_prefs_set_data($event)
	{
		$event['sql_ary'] = array_merge(
			$event['sql_ary'], array(
			'user_pt_enable'          => $event['data']['pt_enable'],
			'user_pt_location'        => $event['data']['pt_location'],
			'user_pt_number'          => $event['data']['pt_number'],
			'user_pt_sort_start_time' => $event['data']['pt_sort_start_time'],
			'user_pt_unread_only'     => $event['data']['pt_unread_only'],
			)
		);
	}
}

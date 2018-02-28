<?php
/**
 *
 * @package Popular Topics Extension
 * @copyright (c) 2015 PayBas
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * Based on the original NV Popular Topics by Joas Schilling (nickvergessen)
 *
 */

namespace paybas\populartopics\event;

use paybas\populartopics\core\populartopics;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

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
class listener implements EventSubscriberInterface
{
	/* @var populartopics */
	protected $pt_functions;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/**
	 * listener constructor.
	 *
	 * @param \paybas\populartopics\core\populartopics $functions
	 * @param \phpbb\config\config                   $config
	 * @param \phpbb\request\request                 $request
	 */
	public function __construct(populartopics $functions, \phpbb\config\config $config, \phpbb\request\request $request)
	{
		$this->pt_functions = $functions;
		$this->config = $config;
		$this->request = $request;
	}

	/**
	 * Returns an array of event names this subscriber wants to listen to.
	 *
	 * The array keys are event names and the value can be:
	 *
	 *  * The method name to call (priority defaults to 0)
	 *  * An array composed of the method name to call and the priority
	 *  * An array of arrays composed of the method names to call and respective
	 *    priorities, or 0 if unset
	 *
	 * For instance:
	 *
	 *  * array('eventName' => 'methodName')
	 *  * array('eventName' => array('methodName', $priority))
	 *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
	 *
	 * @return array The event names to listen to
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.index_modify_page_title'           => 'display_pt',
			'nickvergessen.newspage.newspage'        => 'display_pt_newspage',
			'core.acp_manage_forums_request_data'    => 'acp_manage_forums_request_data',
			'core.acp_manage_forums_initialise_data' => 'acp_manage_forums_initialise_data',
			'core.acp_manage_forums_display_form'    => 'acp_manage_forums_display_form',
			'core.permissions'                       => 'add_permission',
		);
	}

	// The main magic
	public function display_pt()
	{
		if (isset($this->config['pt_index']) && $this->config['pt_index'])
		{
			$this->pt_functions->display_popular_topics();
		}
	}

	// nickvergessen's newspage ext
	public function display_pt_newspage()
	{
		if (isset($this->config['pt_on_newspage']) && $this->config['pt_on_newspage'])
		{
			$this->pt_functions->display_popular_topics();
		}
	}

	// Submit form (add/update)
	/**
	 * @param $event
	 */
	public function acp_manage_forums_request_data($event)
	{
		$array = $event['forum_data'];
		$array['forum_popular_topics'] = $this->request->variable('forum_popular_topics', 1);
		$event['forum_data'] = $array;
	}

	// Default settings for new forums
	/**
	 * @param $event
	 */
	public function acp_manage_forums_initialise_data($event)
	{
		if ($event['action'] == 'add')
		{
			$array = $event['forum_data'];
			$array['forum_popular_topics'] = '1';
			$event['forum_data'] = $array;
		}
	}

	// ACP forums template output
	/**
	 * @param $event
	 */
	public function acp_manage_forums_display_form($event)
	{
		$array = $event['template_data'];
		$array['POPULAR_TOPICS'] = $event['forum_data']['forum_popular_topics'];
		$event['template_data'] = $array;
	}

	/**
	 * Add permissions
	 * @param array $event
	 * @return null
	 * @access public
	 */
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_pt_view'] = array('lang' => 'ACL_U_PT_VIEW', 'cat' => 'misc');
		$permissions['u_pt_enable'] = array('lang' => 'ACL_U_PT_ENABLE', 'cat' => 'misc');
		$permissions['u_pt_location'] = array('lang' => 'ACL_U_PT_LOCATION', 'cat' => 'misc');
		$permissions['u_pt_sort_start_time'] = array('lang' => 'ACL_U_PT_SORT_START_TIME', 'cat' => 'misc');
		$permissions['u_pt_unread_only'] = array('lang' => 'ACL_U_PT_UNREAD_ONLY', 'cat' => 'misc');
		$permissions['u_pt_number'] = array('lang' => 'ACL_U_PT_NUMBER', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}
}

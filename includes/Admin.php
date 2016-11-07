<?php
namespace GeorgeRujoiu\GameBattleStats;

use GeorgeRujoiu\GameBattleStats\AbstractSingleton;
use GeorgeRujoiu\GameBattleStats\Admin\Database;
use GeorgeRujoiu\GameBattleStats\Admin\Platforms;
use GeorgeRujoiu\GameBattleStats\Admin\Tournaments;

class Admin extends AbstractSingleton
{
	private $pageTitle = 'GameBattleStats Platforms';

	private $menuTitle = 'GameBattleStats';

	private $mainSlug = 'gbs';

	private $tournamentsSlug = 'gbstournaments';

	private $capability = 'manage_options';

	public $platforms;

	protected function __construct()
	{
		if (!current_user_can('manage_options')) {
			return;
		}

		# load the platforms
		$this->platforms = Platforms::getInstance();

		# create the administration menus
		add_action('admin_menu', [$this, 'buildMenus']);

		# load extra scripts
		add_action('admin_enqueue_scripts', [$this, 'loadScripts']);
	}

	public function buildMenus()
	{
		add_menu_page(
			$this->pageTitle,
			$this->menuTitle,
			$this->capability,
			$this->mainSlug,
			[$this, 'pageHtml']
		);

		$this->addSubMenu(
			$this->mainSlug,
			$this->platforms::PAGE_TITLE,
			$this->platforms::MENU_TITLE,
			$this->capability,
			$this->platforms::MENU_SLUG,
			$this->platforms,
			'form'
		);
	}

	/**
	 * Create an admin sub menu page
	 * 
	 * @param $parentSlug string
	 * @param $pageTitle string
	 * @param $menuTitle string
	 * @param $capability string
	 * @param $menuSlug string
	 * @param $callableFunction string
	 * 
	 * @return string | false
	 */
	private function addSubMenu(
		$parentSlug,
		$pageTitle,
		$menuTitle,
		$capability = 'manage_options',
		$menuSlug,
		$scope,
		$callableFunction
	) {
		return add_submenu_page(
			$parentSlug,
			$pageTitle,
			$menuTitle,
			$capability,
			$menuSlug,
			[$scope, $callableFunction]
		);
	}

	public function addTournamentsMenu()
	{
		add_submenu_page(
			$this->mainSlug,
			'Tournaments',
			'Tournaments',
			$this->capability,
			$this->tournamentsSlug,
			[$this, 'tournamentsHtml']
		);
	}

	public function pageHtml()
	{
		$pageTitle = esc_html(get_admin_page_title());

		echo <<<HTML
		<div class="wrap">
			<h1>{$pageTitle}</h1>

			<table class="table table-striped">
				<tr>
					<th>Platform</th>
					<th>Actions</th>
				</tr>
HTML;
				foreach($this->platforms->get() as $platform):
					$editUrl = get_admin_url(null, 'admin.php');
					$removeUrl = get_admin_url(null, 'admin-post.php?action=remove_platform&id='.$platform->id);
					echo <<<HTML
						<tr><td>{$platform->name}</td>
						  <td>
						  	<span onclick="location.href = '{$editUrl}'" class="glyphicon glyphicon-edit"></span>
						  	<span  class="glyphicon glyphicon-remove"
						  		onclick="return confirm('Are you sure you want to remove this platform?')
						  		? location.href = '{$removeUrl}':'';"></span>
						  </td>
					</tr>
HTML;
				endforeach;
		echo <<<HTML
			</table>
		</div>
HTML;
	}

	public function loadScripts()
	{
		# Load bootstrap css
		wp_enqueue_style(
			'bootstrap',
			plugin_dir_url(__DIR__).'admin/css/bootstrap.min.css',
			[],
			''
		);
	}
}
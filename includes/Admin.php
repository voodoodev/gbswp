<?php
namespace GeorgeRujoiu\GameBattleStats;

use GeorgeRujoiu\GameBattleStats\AbstractSingleton;
use GeorgeRujoiu\GameBattleStats\Admin\Platforms;

class Admin extends AbstractSingleton
{
	private $pageTitle = 'GameBattleStats Platforms';

	private $menuTitle = 'GameBattleStats';

	private $mainSlug = 'gbs';

	private $tournamentsSlug = 'gbstournaments';

	private $capability = 'manage_options';

	private $prefixedTable;

	public $platforms;

	protected function __construct()
	{
		global $wpdb;

		# prefix the table name before adding to the db
		$this->prefixedTable = $wpdb->prefix;

		$this->platforms = new Platforms([
			'parent' => $this->mainSlug
		]);

		add_action('admin_menu', [$this, 'addMenu']);

		add_action('admin_menu', [$this, 'addTournamentsMenu']);

		add_action('admin_enqueue_scripts', [$this, 'loadScripts']);

		if (isset($_POST['action'])) {
			do_action('add_platform');
		}
	}

	/**
	 * Add the main plugin admin page and menu
	 */
	public function addMenu()
	{
		add_menu_page(
			$this->pageTitle,
			$this->menuTitle,
			$this->capability,
			$this->mainSlug,
			[$this, 'pageHtml']
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
		if (!current_user_can('manage_options')) {
			return;
		}

		$pageTitle = esc_html(get_admin_page_title());

		?>

		<div class="wrap">
			<h1><?= $this->pageTitle ?></h1>

			<table class="table table-striped">
				<tr>
					<th>Platform</th>
					<th>Actions</th>
				</tr>
				<?php
				foreach($this->getData('platforms') as $platform):
					echo <<<HTML
						<tr><td>{$platform->name}</td>
						  <td><a href="'.get_admin_url(null, 'admin.php?page=gbs&remove={$platform->id}" class="glyphicon glyphicon-remove"></a></td>
					</tr>
HTML;
				endforeach;
				?>
			</table>
		</div>

		<?php
	}

	public function manipulatePlatform($action='add')
	{
		global $wpdb;

		switch($action){
			case 'delete':
				$wpdb->delete($this->prefixedTable.'platforms', [
					'id' => $_POST['platforms-id']
				]);
				break;
			case 'add':
				$wpdb->insert($this->prefixedTable.'platforms', [
					'name' => $_POST['platform-name']
				]);
				break;
		}

		wp_redirect(get_admin_url(null, 'admin.php?page=gbs'));
	}

	public function tournamentsHtml()
	{
		if (!current_user_can('manage_options')) {
			return;
		}

		$pageTitle = esc_html(get_admin_page_title());

		?>

		<div class="wrap">
			<h1><?= $this->pageTitle ?></h1>

			<table class="table table-striped">
				<tr>
					<th>Tournaments</th>
				</tr>
				<?php
				foreach($this->getData('tournaments') as $tournament):
					echo '<tr><td>'.$tournament->name.'</td></tr>';
				endforeach;
				?>
			</table>
		</div>

		<?php
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

	public function getData($table, $limit = 'all')
	{
		global $wpdb;

		switch ($limit) {
			case 'all':
				$result = $wpdb->get_results(
					'SELECT id, name FROM '.$wpdb->prefix.$table
				);
			break;
		}

		if (is_null($result))
		{
			$result = [];
		}

		return $result;
	}
}
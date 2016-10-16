<?php
namespace GeorgeRujoiu\GameBattleStats;

use GeorgeRujoiu\GameBattleStats\AbstractSingleton;

class Admin extends AbstractSingleton
{
	private $pageTitle = 'GameBattleStats Platforms';

	private $menuTitle = 'GameBattleStats';

	private $mainSlug = 'gbs';

	private $capability = 'manage_options';

	protected function __construct()
	{
		add_action('admin_menu', [$this, 'addMenu']);
		add_action('admin_menu', [$this, 'addPlatformsMenu']);

		add_action('admin_enqueue_scripts', [$this, 'loadScripts']);
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

	/**
	 * Add the subpages and menus
	 */
	public function addPlatformsMenu()
	{
		add_submenu_page(
			$this->mainSlug,
			'Add platform',
			'Add platform',
			$this->capability,
			'platforms',
			[$this, 'addPlatformsHtml']
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
				</tr>
				<?php
				foreach($this->getPlatforms() as $platform):
					echo '<tr><td>'.$platform->name.'</td></tr>';
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

	public function getPlatforms($limit = 'all')
	{
		global $wpdb;

		switch ($limit) {
			case 'all':
				$result = $wpdb->get_results(
					'SELECT name FROM '.$wpdb->prefix.'platforms'
				);
			break;
		}

		if (is_null($result))
		{
			$result = [];
		}

		return $result;
	}

	public function addPlatformsHtml()
	{
		?>
		<div class="wrap">
			<h1><?= esc_html(get_admin_page_title()) ?></h1>
			<form action="" method="post">
				<div class="form-group">
					<label for="platform-name"><?php _e('Platform name') ?></label>
					<input type="text" name="platform-name" id="platform-name"
						placeholder="<?php _e('Enter the platform name here') ?>" 
						class="form-control">
				</div>
				<input type="submit" class="btn btn-submit" value="<?php _e('Add') ?>">
			</form>
		</div>
		<?php
	}
}
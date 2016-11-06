<?php
namespace GeorgeRujoiu\GameBattleStats\Admin;

class Platforms {

	private $config;

	public function __construct(array $config)
	{
		$this->config = $config;

		add_action('admin_menu', [$this, 'addPlatformsMenu']);

		if (isset($_POST['action'])) {
			do_action('add_platform');
		}
	}

	public function addPlatformsMenu()
	{
		add_submenu_page(
			$this->config['parent'],
			'Add platform',
			'Add platform',
			'manage_options',
			'platforms',
			[$this, 'addPlatformsHtml']
		);
	}

	public function addPlatformsHtml()
	{
		?>
		<div class="wrap">
			<h1><?= esc_html(get_admin_page_title()) ?></h1>
			<form action="" method="post">
				<div class="form-group">
					<input type="hidden" name="action" value="add_platform">
					<label for="platform-name"><?php _e('Platform name') ?></label>
					<input type="text" name="platform-name" id="platform-name"
						placeholder="<?php _e('Enter the platform name here') ?>" 
						class="form-control" required>
				</div>
				<input type="submit" class="btn btn-submit" value="<?php _e('Add') ?>">
			</form>
		</div>
		<?php
	}
}
<?php
namespace GeorgeRujoiu\GameBattleStats\Admin;

use GeorgeRujoiu\GameBattleStats\AbstractSingleton;
use GeorgeRujoiu\GameBattleStats\Admin\Database;

class Platforms extends AbstractSingleton {

	const
		PAGE_TITLE = 'Add Platform',
		MENU_TITLE = 'Add Platform',
		MENU_SLUG = 'platforms',

		TABLE = 'platforms'
	;

	protected function __construct()
	{
		add_action('admin_post_add_platform', [$this, 'save']);
		add_action('admin_post_remove_platform', [$this, 'remove']);
	}

	public function get()
	{
		return Database::getInstance()->select(
			self::TABLE,
			['id', 'name']
		);
	}

	public function save()
	{
		Database::getInstance()->insert(
			self::TABLE,
			['name'=>$_POST['platform-name']]
		);

		wp_redirect(admin_url('admin.php?page=gbs'));
	}

	public function remove()
	{
		Database::getInstance()->delete(
			self::TABLE,
			['id'=>$_GET['id']]
		);

		wp_redirect(admin_url('admin.php?page=gbs'));
	}

	public function form()
	{
		$title = __(get_admin_page_title());
		$placeholder = __('Enter the platform name here');
		$button = __('Add');
		$action = esc_url(admin_url('admin-post.php'));

		echo <<<HTML
		<div class="wrap">
			<h1>{$title}</h1>
			<form action="{$action}" method="post">
				<div class="form-group">
					<input type="hidden" name="action" value="add_platform">
					<label for="platform-name"></label>
					<input type="text" name="platform-name" id="platform-name"
						placeholder="{$placeholder}" 
						class="form-control" required>
				</div>
				<input type="submit" class="btn btn-submit" value="{$button}">
			</form>
		</div>
HTML;
	}
}
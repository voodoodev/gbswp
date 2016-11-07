<?php
namespace GeorgeRujoiu\GameBattleStats\Admin;

use GeorgeRujoiu\GameBattleStats\AbstractSingleton;

class Tournaments extends AbstractSingleton
{

	const
		PAGE_TITLE = 'Tournaments',
		MENU_TITLE = 'Tournaments',
		MENU_SLUG = 'tournaments'
	;

	protected function __construct()
	{
	}

	public function form()
	{
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
}
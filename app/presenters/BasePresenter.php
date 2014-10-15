<?php

namespace App\Presenters;

use LeonardoCA\Bootstrap\Components\FlashMessagesControl;
use Nette,
	App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	protected function beforeRender()
	{
		parent::beforeRender();
		if ($this->isAjax) {
			$this->redrawControl('flashMessages');
		}
	}

	/**
	 * Flash messages component
	 *
	 * @returns FlashMessagesControl
	 */
	public function createComponentFlashMessages()
	{
		return new FlashMessagesControl;
	}

}

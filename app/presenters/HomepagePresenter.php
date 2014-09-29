<?php

namespace App\Presenters;

use App\Model;
use Kdyby\Replicator;
use LeonardoCA\Forms\Rendering\Bs3FormRenderer;
use Nette;
use Nette\Application\UI;
use Nette\ComponentModel\IContainer;
use Nette\Forms\Container;
use Nette\Forms\Controls;
use Tracy\Dumper;

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->testFormValues =
			Dumper::toHtml($this['testForm']->getValues());
	}



	public function createComponentTestForm()
	{
		$form = new Nette\Application\UI\Form();
		$addEventHandler = callback($this, 'handleAddItem');
		$removeEventHandler = callback($this, 'handleRemoveItem');
		$form->addGroup('Footer menu');
		$form->addDynamic(
			'sections',
			function (Container $column) use (
				$removeEventHandler, $addEventHandler
			) {
				$column->addText('title', 'Column Title')->getControlPrototype()
					->addClass('col-sm-5')->addAttributes(['placeholder' => 'Column Title']);
				$column->addDynamic(
					'menuItems',
					function (Container $menuItems) use ($removeEventHandler) {
						$menuItems->addText('text', 'Text')
							->getControlPrototype()->addClass('col-sm-5')
							->addAttributes(['placeholder' => 'Text']);
						$menuItems->addText('url', 'Url')->getControlPrototype()
							->addClass('col-sm-5')->addAttributes(
							['placeholder' => 'Url']
						);
						$menuItems->addSubmit('remove', '-')
							->setValidationScope(false)
							->setAttribute('class', 'btn btn-danger btn-sm')
							->addRemoveOnClick($removeEventHandler);
						$this->controlsInit($menuItems);
					},
					1,
					true
				)->addSubmit('add', '+')
					->setValidationScope(false)
					->setAttribute('class', 'btn btn-success btn-sm')
					->addCreateOnClick(true, $addEventHandler);
				$column->addSubmit('remove', '-')
					->setValidationScope(false)
					->setAttribute('class', 'btn btn-sm btn-danger')
					->addRemoveOnClick($removeEventHandler);
				$this->controlsInit($column);
			},
			2,
			true
		)->addSubmit('add', '+')
			->setValidationScope(false)
			->setAttribute('class', 'btn btn-sm btn-success')
			->addCreateOnClick(true, $addEventHandler);
		$form->addGroup();
		$form->addSubmit('submit', 'Save');
		$form->addSubmit('cancel', 'Cancel');

		$this->controlsInit($form);
		$form->getElementPrototype()->addClass('form-horizontal');

		$form->onSuccess[] = $this->processTestForm;
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}



	private function controlsInit($container)
	{
		foreach ($container->getControls() as $control) {
			if ($control instanceof Controls\Button) {
//				$markAsPrimary = $control === $primaryButton
//					|| (!isset($this->primary) && empty($usedPrimary)
//						&& $control->parent instanceof Form);
//				if ($markAsPrimary) {
//					$class = 'btn btn-primary';
//					$usedPrimary = true;
//				} else {
//					$class = 'btn btn-default';
//				}
				if ($control->getName() == 'submit') {
					$class = 'btn btn-primary';
				} else {
					$class = 'btn btn-default';
				}
				$control->getControlPrototype()->addClass($class);

			} elseif ($control instanceof Controls\TextBase
				|| $control instanceof Controls\SelectBox
				|| $control instanceof Controls\MultiSelectBox
			) {
				$control->getControlPrototype()->addClass('form-control');

			} elseif ($control instanceof Controls\Checkbox
				|| $control instanceof Controls\CheckboxList
				|| $control instanceof Controls\RadioList
			) {
				$control->getSeparatorPrototype()->setName('div')->addClass(
					$control->getControlPrototype()->type
				);
			}
		}
	}



	public function processTestForm(UI\Form $form, $values)
	{
		//$this->flashMessage('Form processing');
	}



	/**
	 * Handle add item
	 *
	 * @param Replicator\Container $replicator
	 * @param IContainer           $item
	 */
	public function handleAddItem(
		Replicator\Container $replicator, IContainer $item
	) {
		//$this->flashMessage('Form add');
	}



	/**
	 * Handle remove item
	 *
	 * @param Replicator\Container $replicator
	 * @param IContainer           $item
	 */
	public function handleRemoveItem(
		Replicator\Container $replicator, IContainer $item
	) {
		//$this->flashMessage('Form remove');
	}

}

<?php
/**
 * This file is part of nette-test
 * Copyright (c) 2014 Leonardoca
 * For the full copyright and license information
 * please view the file license.txt that was distributed with this source code.
 */

namespace App\Examples\Replicator;

use Kdyby\Replicator;
use LeonardoCA\Forms\Rendering\Bs3FormRenderer;
use Nette;
use Nette\Application\UI;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\Forms\Container;
use Nette\Forms\Controls;

class NestedSortableReplicators extends Control
{

	/** @var callable[] */
	public $onRender = [];



	public function __construct()
	{
	}



	public function render()
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/NestedSortableReplicators.latte');
		$this->onRender(['form' => $this['form']]);
		$template->render();
	}



	protected function createComponentForm()
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
					->addClass('col-sm-5')->addAttributes(
						['placeholder' => 'Column Title']
					);
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
							->setAttribute('class', 'btn-danger btn-sm')
							->setAttribute('data-replicator-item-remove', 'yes')
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
					->setAttribute('class', 'btn-sm btn-danger')
					->setAttribute('data-replicator-item-remove', 'yes')
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

		$form->onSuccess[] = $this->processForm;
		$form->setRenderer(new Bs3FormRenderer);
		//sdump($form);
		return $form;
	}



	private function controlsInit($container)
	{
		foreach ($container->getControls() as $control) {
			if ($control instanceof Controls\Button) {
				if ($control->getName() == 'submit') {
					$class = 'btn btn-primary ajax';
				} else {
					$class = 'btn btn-default ajax';
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



	public function processForm(Form $form, $values)
	{
		$form->parent->invalidateControl('replicator-snippet');
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
		$replicator->form->parent->invalidateControl();
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
		$replicator->form->parent->invalidateControl();
	}

}

<?php

namespace App\Presenters;

use Nette;
use Nette\Forms\Controls;
use Nette\Forms\Container;
use Nette\Forms\Controls\SubmitButton;
use Nette\Application\UI;
use App\Model;
use Nextras\Forms\Rendering\Bs3FormRenderer;
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

		$form->addGroup('Personal data');
		$form->addText('name', 'Your name')
			->setRequired('Enter your name');
		$form->addRadioList(
			'gender',
			'Your gender',
			array(
				'male',
				'female',
			)
		);
		$form->addCheckboxList(
			'colors',
			'Favorite colors:',
			array(
				'red',
				'green',
				'blue',
			)
		);
		$form->addSelect(
			'country',
			'Country',
			array(
				'Burundi',
				'Qumran',
				'Saint Georges Island',
			)
		);
		$form->addTextArea('note', 'Comment');

		$form->addGroup('Addresses');
		$removeEvent = callback($this, 'MyFormRemoveElementClicked');
		$users = $form->addDynamic(
			'users',
			function (Container $user) use ($removeEvent) {
				$user->addText('name', 'Name');
				$user->addText('surname', 'surname');
				$addresses = $user->addDynamic(
					'addresses',
					function (Container $address) use ($removeEvent) {
						$address->addText('street', 'Street');
						$address->addText('city', 'City');
						$address->addText('zip', 'Zip');
						$address->addCheckbox('send', 'Ship to address');
						$removeBtn = $address->addSubmit('remove', '-')
							->setValidationScope(false);
						$removeBtn->getControlPrototype()->addClass(
							'btn-danger'
						);
						$removeBtn->onClick[] = $removeEvent;
					},
					1,
					true
				);
				$addBtn = $addresses->addSubmit('add', '+')
					->setValidationScope(false);
				$addBtn->getControlPrototype()->addClass('btn-success');
				$addBtn->onClick[] = callback($this, 'MyFormAddElementClicked');
				$removeBtn = $user->addSubmit('remove', '-')
					->setValidationScope(false);
				$removeBtn->getControlPrototype()->addClass('btn-danger');
				$removeBtn->onClick[] = $removeEvent;
			},
			1,
			true
		);
		$addBtn = $users->addSubmit('add', '+')
			->setValidationScope(false);
		$addBtn->getControlPrototype()->addClass('btn-success');
		$addBtn->onClick[] = callback($this, 'MyFormAddElementClicked');

		$form->addGroup();
		$form->addSubmit('submit', 'Send');
		$form->addSubmit('cancel', 'Cancel');

		$form->onSuccess[] = $this->processTestForm;

		$form->setRenderer(new Bs3FormRenderer);

		return $form;
	}



	public function processTestForm(UI\Form $form, $values)
	{
		$this->flashMessage('Form processing');
	}



	public function MyFormAddElementClicked(SubmitButton $button)
	{
		$button->parent->createOne();
	}



	public function MyFormRemoveElementClicked(SubmitButton $button)
	{
		// first parent is container
		// second parent is it's replicator
		$users = $button->parent->parent;
		$users->remove($button->parent, true);
	}

}

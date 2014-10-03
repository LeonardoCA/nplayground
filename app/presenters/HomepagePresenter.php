<?php

namespace App\Presenters;

use App\Examples\Replicator\NestedSortableReplicators;
use App\Model;

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	/** @var array Data */
	public $componentData;



	public function createComponentTestedComponent()
	{
		$control = new NestedSortableReplicators;
		$control->onRender[] = $this->onComponentRender;
		return $control;
	}



	public function onComponentRender($data)
	{
		$this->componentData = $data;
	}

}

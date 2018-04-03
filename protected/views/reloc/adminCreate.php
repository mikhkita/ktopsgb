<div class="b-popup">
	<h1>Добавление <?=$this->adminMenu["cur"]->rod_name?></h1>

	<?php $this->renderPartial("_form", array("model" => $model, "workers" => $workers, "planks" => $planks, "reloc" => $reloc, "salary" => $salary, "labels" => $labels)); ?>
</div>
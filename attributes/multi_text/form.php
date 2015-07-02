<?php
defined('C5_EXECUTE') or die('Access Denied.');

$list = unserialize($fields);
if (!is_array($list)) {
    return;
}

foreach ($list['handle'] as $key => $item) {
    ?>
    <div class="row">
        <label class="col-lg-2 col-sm-4 control-label"><?= tc('MultiTextLabel', $list['name'][$key]) ?></label>

        <div class="col-lg-10 col-sm-8">
            <?= $form->text($this->field($item), $value[$item]) ?>
        </div>
    </div>
<?php } ?>
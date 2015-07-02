<?php
defined('C5_EXECUTE') or die('Access Denied.');
?>
<fieldset>
    <legend><?= t('Attribute Configuration') ?></legend>
    <div class="clearfix">
        <label><?= t('Attribute Fields') ?></label>

        <div class="input">
            <table class="table table-bordered table-striped" id="multi-text-fields">
                <thead>
                <tr>
                    <th><?= t('Handle') ?></th>
                    <th><?= t('Name') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php

                $list = unserialize($fields);
                if (is_array($list)) {
                    foreach ($list['handle'] as $key => $item) {
                        ?>
                        <tr>
                            <td><input name="fields[handle][]" value="<?= h($item) ?>"></td>
                            <td><input name="fields[name][]" value="<?= h($list['name'][$key]) ?>"></td>
                            <td>
                                <button class="remove btn btn-default"><?= t('Remove') ?></button>
                            </td>
                        </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th><input type="form-control" id="add-handle"></th>
                    <th><input type="form-control" id="add-name"></th>
                    <th>
                        <button class="add btn btn-default"><?= t('Add') ?></button>
                    </th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
    <div class="clearfix">
        <label><?= t('Show Labels') ?></label>

        <div class="input">
            <input type="checkbox" name="showLabels" <?= $showLabels ? 'checked="checked"' : '' ?>>

        </div>
    </div>
</fieldset>

<script type="text/javascript">
    $(document).ready(function () {
        $("#multi-text-fields").on("click", ".remove", function (event) {
            $(this).parents("tr").remove();
        });
        $("#multi-text-fields").on("click", ".add", function (event) {
            event.preventDefault();
            var handle = $("#add-handle").val(),
                name = $("#add-name").val();
            $("#multi-text-fields tbody").append('<tr><td><input name="fields[handle][]" value="' + handle + '"></td><td><input name="fields[name][]" value="' + name + '"></td><td><button class="remove btn btn-default"><?= t('Remove') ?></button></td></tr>');

            $("#add-handle, #add-name").val("");
        })
        var fixHelper = function (e, ui) {
            ui.children().each(function () {
                $(this).width($(this).width());
            });
            return ui;
        };

        $("#multi-text-fields tbody").sortable({helper: fixHelper});
    });
</script>
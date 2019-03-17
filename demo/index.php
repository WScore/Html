<?php
/**
 * WScore.HTML sample code
 */

use WScore\Html\Form;
use WScore\Html\Html;

require_once __DIR__ . '/../vendor/autoload.php';

?>
<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WScore.HTML Samples</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">

    <h1>WScore.HTML Samples</h1>
    <hr>
    <?= Form::open('nowhere.php'); ?>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <?= Form::input('email', 'email')->class('form-control')->placeholder('Enter email') ?>
    </div>

    <?=
    Html::create('div')
        ->class('form-group')
        ->setContents(
            Html::label('Example Select')->for('select-sample'),
            Form::choices('select-sample', [
                'select' => 'Drop Down List',
                'radio' => 'Radio Button',
                'checkbox' => 'Check Box',
            ])->class('form-control')->expand(false)
        )
    ?>

    <?=
    Html::div(
        Html::label('Example Select')->for('select-sample'),
        Form::choices('select-sample', [
            'select' => 'Drop Down List',
            'radio' => 'Radio Button',
            'checkbox' => 'Check Box',
        ], 'radio')->class('form-control')
            ->expand(false)
            ->multiple()
            ->style('width:16rem')
    )->class('form-group')
    ?>

    <label>Simple Radio Buttons and Checkboxes</label>
    <div class="form-check">
        <?= Form::input('radio', 'radio', 'radio')->class('form-check-input') ?>
        <label for="radio">Radio Buttons</label>
    </div>
    <div class="form-check">
        <?= Form::input('checkbox', 'check', 'check')->class('form-check-input') ?>
        <label for="check">Checkboxes</label>
    </div>

    <?php $form = Form::choices('choices', [
        'val1' => 'value 1',
        'val2' => 'value 2',
        'val3' => 'value 3',
        'val4' => 'value 4',
    ], ['val1', 'val3'])->class('form-check-input');
    ?>
    <label>Form::choice Radio Button Example</label>
    <?php showChoiceList($form); ?>
    <label>Form::choice Checkbox Example</label>
    <?php $form->multiple(); showChoiceList($form); ?>

    <?= Form::input('submit', '', 'submit button here')->class('btn btn-primary') ?>
    <?= Form::close(); ?>

    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>

</div>
</body>
</html>
<?php

function showChoiceList(\WScore\Html\Tags\Choices $form)
{
    foreach ($form->getChoices() as $choice): ?>
        <div class="form-check">
            <?= $choice->class('form-check-input') ?>
            <label for="<?= $choice->get('id'); ?>"><?= $choice->getLabel(); ?></label>
        </div>
    <?php endforeach;
}


<?
/**
 * @var boolean $acceptResetPassword
 */
$this->registerCssFile('/templates/A1/css/style.css');
$this->registerCssFile('/templates/A1/css/responsive.css');
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
];
?>
<?php //else:

if($acceptResetPassword){

$form = \yii\widgets\ActiveForm::begin(['enableClientValidation' => true,
    'action' => '/account/reset-password',
    'options' =>
    ['class' => 'signin','id' => 'repeatPassword','action'=>'/account/reset-password']]); ?>
    <span class="wrap wrap-email">
<?= $form
    ->field($model, 'password', $fieldOptions1)
    ->label(false)
    ->textInput(['placeholder' => $model->getAttributeLabel('password'),'class' => 'input-with-icon wrap__email','type' => 'password'])
?>
        <?= $form
            ->field($model, 'passwordRepeat', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('passwordRepeat'),'class' => 'input-with-icon wrap__email','type' => 'password'])
        ?>
        <span class="wrap-btn">
                   <?= \yii\helpers\Html::submitButton('Отправить', ['class' => 'button-orange login']) ?>
            </span>
        <?php \yii\widgets\ActiveForm::end();
}else{
$form = \yii\widgets\ActiveForm::begin(['class' => 'signin', 'enableClientValidation' => true,'options' =>
    ['class' => 'signin','action'=>['/account/login']]]); ?>
<span class="wrap wrap-email">
                    <?= $form
                        ->field($model, 'email', $fieldOptions1)
                        ->label(false)
                        ->textInput(['placeholder' => $model->getAttributeLabel('email'),'class' => 'input-with-icon wrap__email','type' => 'email']) ?>

    <span class="wrap-btn">
                   <?= \yii\helpers\Html::submitButton('Отправить', ['class' => 'button-orange login']) ?>
            </span>
<?php \yii\widgets\ActiveForm::end();

}
?>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CountryLangContent2 */

$this->title = Yii::t('app', 'Create Country Lang Content');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Country Lang Contents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-lang-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

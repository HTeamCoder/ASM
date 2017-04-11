<?php
/**
 * Created by PhpStorm.
 * User: HungLuongHien
 * Date: 6/23/2016
 * Time: 1:11 PM
 */
\backend\assets\Qltk2Asset::register($this);
$this->beginPage();
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title><?=\yii\helpers\Html::encode($this->title); ?></title>
    <?= \yii\helpers\Html::csrfMetaTags() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/favicon.ico"/>
</head>

<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
<?php $this->beginBody(); ?>
    <?=$this->render('header.php');?>
    <div class="clearfix"></div>
    <?=$this->render('content.php', ['content' => $content]);?>
<?php \yii\bootstrap\Modal::begin(
    [
        'header' => '<div id="header-detail-modal"></div>',
        'size' => \yii\bootstrap\Modal::SIZE_LARGE,
        'options' => [
            'id' => 'modal-xemchitiet'
        ]
    ]
)?>
<div class="thongbao"></div>
<div id="detail-hbl"></div>
<?php \yii\bootstrap\Modal::end()?>
<?php $this->endBody(); ?>
</body>

</html>
<?php $this->endPage() ?>
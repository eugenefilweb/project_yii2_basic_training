<?php

namespace app\assets;

use yii\web\AssetBundle;

class ModernizeAsset extends AssetBundle
{
    public $sourcePath = '@webroot/modernize/assets';
    public $css = [
      'css/styles.min.css',
      'css/style.css',
        // Add any additional CSS files from the template if needed
    ];
    public $js = [
        'libs/bootstrap/dist/js/bootstrap.bundle.min.js',
        'libs/apexcharts/dist/apexcharts.min.js',
        'libs/simplebar/dist/simplebar.js',
        'js/app.min.js',
        'js/dashboard.js',
        'js/sidebarmenu.js',
        // Add any additional JS files from the template if needed
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
        // Add any other dependencies (if required)
    ];
}

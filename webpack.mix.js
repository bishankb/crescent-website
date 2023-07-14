let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/*
 |--------------------------------------------------------------------------
 | Backend
 |--------------------------------------------------------------------------
 |
 */
mix.scripts([
    'node_modules/jquery/dist/jquery.js',
    'node_modules/bootstrap/dist/js/bootstrap.js',
    'node_modules/jquery-validation/dist/jquery.validate.js',
    'node_modules/datatables.net/js/jquery.dataTables.js',
    'node_modules/datatables.net-bs/js/dataTables.bootstrap.js',
    'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
    'node_modules/select2/dist/js/select2.js',
    'node_modules/toastr/toastr.js',
    'resources/assets/iCheck/icheck.js',
	'resources/assets/adminlte/js/adminlte.js',
    'resources/assets/adminlte/js/page/dashboard2.js', 
    'resources/assets/backend/js/custom.js',
], 'public/js/backend.js');

mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.css',
    'node_modules/datatables.net-bs/css/dataTables.bootstrap.css',
    'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
    'node_modules/select2/dist/css/select2.css',
    'node_modules/toastr/build/toastr.css',
    'resources/assets/iCheck/square/blue.css',
    'node_modules/font-awesome/css/font-awesome.css',
    'node_modules/ionicons/dist/css/ionicons.css',
    'resources/assets/toggleSwitch/toggle-switch.css',
    'resources/assets/adminlte/css/AdminLTE.css',
    'resources/assets/adminlte/css/skins/_all-skins.min.css',
    'resources/assets/backend/css/custom.css',
], 'public/css/backend.css');

mix.copyDirectory('resources/assets/backend/images', 'public/images');
mix.copyDirectory('node_modules/bootstrap/fonts', 'public/fonts');
mix.copyDirectory('node_modules/font-awesome/fonts', 'public/fonts');
mix.copyDirectory('node_modules/ionicons/dist/fonts', 'public/fonts');

/*
 |--------------------------------------------------------------------------
 | Frontend
 |--------------------------------------------------------------------------
 |
 */
mix.scripts([
    'resources/assets/frontend/js/jquery-2.2.4.min.js',
    'node_modules/jquery-validation/dist/jquery.validate.js',
    'resources/assets/frontend/js/bootstrap.min.js',
    'node_modules/toastr/toastr.js',
    'resources/assets/frontend/js/easing.min.js', 
    'resources/assets/frontend/js/hobverIntent.js',
    'resources/assets/frontend/js/superfish.min.js',
    'resources/assets/frontend/js/jquery.ajaxchimp.min.js',
    'resources/assets/frontend/js/jquery.magnific-popup.min.js',
    'resources/assets/frontend/js/owl.carousel.min.js',
    'resources/assets/frontend/js/jquery.sticky.js',
    'resources/assets/frontend/js/jquery.nice-select.min.js',
    'resources/assets/frontend/js/waypoints.min.js',
    'resources/assets/frontend/js/jquery.counterup.min.js',
    'resources/assets/frontend/js/parallax.min.js',
    'resources/assets/frontend/js/mail-script.js',
    'resources/assets/frontend/js/main.js',
    'resources/assets/frontend/js/custom.js',
], 'public/js/frontend.js');

mix.styles([
    'resources/assets/frontend/css/bootstrap.css',
    'resources/assets/frontend/css/linearicons.css',
    'resources/assets/frontend/css/font-awesome.min.css',
    'resources/assets/frontend/css/bootstrap.css',
    'node_modules/toastr/build/toastr.css',
    'resources/assets/frontend/css/magnific-popup.css',
    'resources/assets/frontend/css/nice-select.css',
    'resources/assets/frontend/css/animate.min.css',
    'resources/assets/frontend/css/owl.carousel.css',
    'resources/assets/frontend/css/main.css',
    'resources/assets/frontend/css/custom.css',
], 'public/css/frontend.css');

mix.copyDirectory('resources/assets/frontend/img', 'public/images');
mix.copyDirectory('resources/assets/frontend/fonts', 'public/fonts');

/*
 |--------------------------------------------------------------------------
 | Error Page
 |--------------------------------------------------------------------------
 |
 */

mix.styles([
    'node_modules/font-awesome/css/font-awesome.css',
    'resources/assets/error/css/style.css',
], 'public/css/error.css');

mix.copyDirectory('resources/assets/error/images', 'public/images');
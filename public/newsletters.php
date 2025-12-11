<?php

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Http\Kernel;


define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)/*->send()*/;

//$kernel->terminate($request, $response);

?>

<?php if (isset($_POST['act']) && $_POST['act'] != "") {?>
<?php 

$newsletter = DB::select("select * from newsletters where email like '".$_POST['act']."'");

if(count($newsletter) > 0){
$status = "Déjà inscrit";

}else{
$newsletter = new Newsletter();
$newsletter->nom = $_POST['act'];
$newsletter->email = $_POST['act'];
$newsletter->newslettertype_id = 1;
$newsletter->pays_id = 1;
$newsletter->spotlight = 0;
$newsletter->etat = 1;
//Schema::disableForeignKeyConstraints();
$newsletter->save();
//Schema::enableForeignKeyConstraints();

$status = "E-mail bien enrégistré dans le newsletter.";
}
?>

<input type="email" name="email" class="email" value="" placeholder="E-mail" autocomplete="on" required="">
<span class="help-block"><?php echo $status; ?></span>

<?php }else{?>

<input type="email" name="email" class="email" value="" placeholder="E-mail" autocomplete="on" required="">

<?php }?>



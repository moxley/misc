<?php
require './lib/boot.php';
html_head();
?>

<h1>Welcome to Foo Ba Personals</h1>

<div id="blockIndex">

<?php
require_once './register.inc.php';
register_html(array());
?>

</div><!-- #blockIndex -->

<div id="blockLoginWrapper" style="display: none">
<?php
require_once './login.inc.php';
login_html();
?>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#blockLogin .notRegistered").hide();
    $("#blockLogin .cancel").show();
    $("#blockLogin .cancel").click(function() {
        $.unblockUI();
    });
    
    $("a.login").click(function() {
        $.blockUI({message: $('#blockLogin')});
        return false;
    });
});
</script>

<?php
html_foot();

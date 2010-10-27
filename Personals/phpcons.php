<?php
/**
 * PHP Console.
 */
require './lib/boot.php';

require_user();

$code = av($_POST, 'code', 'echo "Hello\n";');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!$code) {
		$output = '';
	}
	else {
		ob_start();
		eval($code);
		$output = ob_get_clean();
	}
}
?>
<h1>PHP Console</h1>

<form method="POST" action="">
	<textarea name="code" cols="80" rows="10" style="font-family: monospace"><?php echo h($code) ?></textarea><br/>
	<input type="submit" value="Execute"/>
</form>

<?php if (isset($output)): ?>
Output:
<pre class="output"><?php echo h($output); ?></pre>
<?php endif ?>

<style type="text/css">
textarea, pre.output {
  width: 800px;
}
pre.output {
  background-color: #ddd;
  padding: 0.5em;
}
</style>

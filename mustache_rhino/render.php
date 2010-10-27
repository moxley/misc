<?php
/**
 * Convert a block into HTML.
 */
function renderMustacheJS($data)
{
    $params = array(
        'templatesDir' => dirname(__FILE__),
        'template'     => 'sample',
        'mustacheFile' => dirname(__FILE__) . '/mustache.js',
        'data'         => $data
    );
    
    $result = executeJSScript(dirname(__FILE__) . '/render.js', json_encode($params), $errorString, $output);
    if ($result === false) {
        echo "Error: $errorString\n";
        echo "Output: $output\n";
    }
    return $result;
}

function executeJSScript($scriptFile, $inputString, &$errorString, &$output) {
    $jar = dirname(__FILE__) . "/js.jar";
    $cmd = "java -cp $jar org.mozilla.javascript.tools.shell.Main $scriptFile";
    $pipes = array();
    $cwd = dirname(__FILE__);
    $descriptorSpec = array(0 => array('pipe', 'r'), 1 => array('pipe', 'w'), 2 => array('pipe', 'w'));
    $env = array();
    $proc = proc_open($cmd, $descriptorSpec, $pipes, $cwd, $env);
    if (!$proc) {
        $errorStrintg = "Command failed: $cmf";
        return false;
    }
    else {
        fwrite($pipes[0], $inputString);
        fclose($pipes[0]);
        
        $errorString = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
    
        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
    }
    
    if ($errorString) {
        return false;
    }
    
    return $output;
}


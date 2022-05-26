<?php
// get the q parameter from URL
$q = $_REQUEST["q"];

function my_shell_exec($cmd, &$stdout=null, &$stderr=null) {
    $env = array('LANG' => 'ru_RU.utf-8','PYTHONIOENCODING' => 'utf-8');
    $proc = proc_open($cmd,[
        1 => ['pipe','w'],
        2 => ['pipe','w'],
    ],$pipes,NULL,$env);
    $stdout = stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[2]);
    return proc_close($proc);
}

echo "<html><body><pre>";

my_shell_exec('python3 planbuilder.py'.$q, $result, $error);

echo $result;

echo "</pre></body></html>";

?>

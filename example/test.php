<?php

$path = array($_SERVER['DOCUMENT_ROOT'] . '/views');         // your view file path, it's an array
$cachePath = $_SERVER['DOCUMENT_ROOT'] . '/cache_path';     // compiled file path

$compiler = new \phptemplate\compilers\BladeCompiler();

// you can add a custom directive if you want
$compiler->directive('datetime', function($timestamp) {
    return preg_replace('/(\(\d+\))/', '<?php echo date("Y-m-d H:i:s", $1); ?>', $timestamp);
});

$engine = new \phptemplate\engines\CompilerEngine($compiler);
$finder = new \phptemplate\FileViewFinder($path);

// if your view file extension is not php or blade.php, use this to add it
//$finder->addExtension('tpl');
// get an instance of factory
$factory = new \phptemplate\Factory($engine, $finder);

// render the template file and echo it
echo $factory->make('child', array('records' => array('a' => 1, 'b' => 2), 'name' => 'John Doe'))->render();

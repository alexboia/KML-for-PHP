<?php
define('KAMELPHP_TESTS_DIR', __DIR__);
define('KAMELPHP_ROOT_DIR', realpath(__DIR__ . '/..'));
define('KAMELPHP_SRC_DIR', realpath(KAMELPHP_ROOT_DIR . '/src'));

$autoloadPrefixes = array(
	'KamelPhp\\Tests' => KAMELPHP_TESTS_DIR,
	'KamelPhp' => KAMELPHP_SRC_DIR,
);

spl_autoload_register(function($className) use ($autoloadPrefixes) {
	__kamelphp_tests_autoload($className, $autoloadPrefixes);
});

function __kamelphp_tests_autoload($className, $autoloadPrefixes) {
	$classPath = null;
	$separator = '\\';

	foreach ($autoloadPrefixes as $prefix => $searchDir) {
		$checkPrefix = $prefix . $separator;
		if (strpos($className, $checkPrefix) === 0) {
			$classPath = str_replace($checkPrefix, '', $className);
			$classPath = __kamelphp_tests_get_relative_path($classPath, $separator, null);
			$classPath = $searchDir . '/' . $classPath . '.php';
			break;
		}
	}

	if (!empty($classPath) && file_exists($classPath)) {
		require_once $classPath;
	}
}

function __kamelphp_tests_get_relative_path($className, $separator, $transform = 'lcfirst') {
	$classPath = array();
	$pathParts = explode($separator, $className);
	$className = array_pop($pathParts);
	foreach ($pathParts as $namePart) {
		if (!empty($transform) && is_callable($transform)) {
			$namePart = $transform($namePart);
		}
		
		$classPath[] = $namePart;
	}
	$classPath[] = $className;
	return implode('/', $classPath);
}
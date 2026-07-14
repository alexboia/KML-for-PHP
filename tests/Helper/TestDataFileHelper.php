<?php
namespace KamelPhp\Tests\Helper { 
	trait TestDataFileHelper {
		protected static function _readTestDataFileContents(string $fileName): string|false {
			return file_get_contents(self::_determineDataFilePath($fileName));
		}

		protected static function _determineDataFilePath(string $fileName): string|false {
			return realpath(self::_determineTestDataDir() . '/' . $fileName);
		}

		protected static function _determineTestDataDir(): string|false {
			return realpath(self::_getRootTestsDir() . '/' . 'assets');
		}

		protected abstract static function _getRootTestsDir();
	}
}
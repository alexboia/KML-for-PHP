<?php
namespace KamelPhp\Tests\Helper { 
	trait TestDataFileHelper {
		protected static function _readTestDataFileContents($fileName) {
			return file_get_contents(self::_determineDataFilePath($fileName));
		}

		protected static function _determineDataFilePath($fileName) {
			return realpath(self::_determineTestDataDir() . '/' . $fileName);
		}

		protected static function _determineTestDataDir() {
			return realpath(self::_getRootTestsDir() . '/' . 'assets');
		}

		protected abstract static function _getRootTestsDir();
	}
}
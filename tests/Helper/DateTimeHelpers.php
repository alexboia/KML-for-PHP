<?php
namespace KamelPhp\Tests\Helper {

    use DateTime;

	trait DateTimeHelpers {
		protected function _assertDateTime(DateTime $actual, 
			$expectedYear, 
			$expectedMonth = null, 
			$expectedDay = null, 
			$expectedHour = null, 
			$expectedMinute = null, 
			$expectedSecond = null, 
			$expectedMs = null, 
			$expectedTz = null) {

			$this->assertEquals($expectedYear, $actual->format('Y'));

			if ($expectedMonth !== null) {
				$this->assertEquals($expectedMonth, intval($actual->format('m')));
			}

			if ($expectedDay !== null) {
				$this->assertEquals($expectedDay, intval($actual->format('d')));
			}

			if ($expectedHour !== null) {
				$this->assertEquals($expectedHour, intval($actual->format('H')));
			}

			if ($expectedMinute !== null) {
				$this->assertEquals($expectedMinute, intval($actual->format('i')));
			}

			if ($expectedSecond !== null) {
				$this->assertEquals($expectedSecond, intval($actual->format('s')));
			}

			if ($expectedMs !== null) {
				$this->assertEquals($expectedMs, intval($actual->format('v')));
			}

			if ($expectedTz !== null) {
				$this->assertEquals($expectedTz, $actual->format('P'));
			}
		}

		abstract public static function assertEquals(mixed $expected, mixed $actual, string $message = ''): void;
	}
}
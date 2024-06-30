<?php
namespace KamelPhp\Tests {

    use PHPUnit\Framework\TestCase;
	use KamelPhp\KmlParser\LatLngAlt;

	class LibKmlParserLatLngAltTests extends TestCase {

		public function test_canParseTupleString_withAlt() {
			$latLng = new LatLngAlt('-90.86948943473118,48.25450093195546,110');

			$this->assertTrue($latLng->hasLongitude());
			$this->assertTrue($latLng->hasLatitude());
			$this->assertTrue($latLng->hasAltitude());

			$this->assertEquals(-90.86948943473118, $latLng->getLongitude(), '', 0.0001);
			$this->assertEquals(48.25450093195546, $latLng->getLatitude(), '', 0.0001);
			$this->assertEquals(110, $latLng->getAltitude(), '', 0.0001);

			$this->assertFalse($latLng->isEmpty());
		}

		public function test_canParseTupleString_withoutAlt() {
			$latLng = new LatLngAlt('-90.86948943473118,48.25450093195546');

			$this->assertTrue($latLng->hasLongitude());
			$this->assertTrue($latLng->hasLatitude());
			$this->assertFalse($latLng->hasAltitude());

			$this->assertEquals(-90.86948943473118, $latLng->getLongitude(), '', 0.0001);
			$this->assertEquals(48.25450093195546, $latLng->getLatitude(), '', 0.0001);
			$this->assertNull($latLng->getAltitude());

			$this->assertFalse($latLng->isEmpty());
		}

		public function test_tryParseEmptyTupleString() {
			$latLng = new LatLngAlt('');

			$this->assertFalse($latLng->hasLongitude());
			$this->assertFalse($latLng->hasLatitude());
			$this->assertFalse($latLng->hasAltitude());

			$this->assertNull($latLng->getLongitude());
			$this->assertNull($latLng->getLatitude());
			$this->assertNull($latLng->getAltitude());

			$this->assertTrue($latLng->isEmpty());
		}
	}
}
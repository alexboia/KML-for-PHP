<?php
namespace KamelPhp\Tests {

    use KamelPhp\KmlParser\LatLngAltCollection;
    use PHPUnit\Framework\TestCase;

	class LibKmlParserLatLngAltCollectionTests extends TestCase {
		public function test_canParseTuplesString_withAlt() {
			$latLngCollection = new LatLngAltCollection('-122.364167,37.824787,50 -122.363917,37.824423,55');
	
			$this->assertEquals(2, count($latLngCollection));
	
			$p0 = $latLngCollection[0];
			$this->assertTrue($p0->hasLongitude());
			$this->assertTrue($p0->hasLatitude());
			$this->assertTrue($p0->hasAltitude());
			$this->assertFalse($p0->isEmpty());
	
			$this->assertEquals(-122.364167, $p0->getLongitude(), '', 0.0001);
			$this->assertEquals(37.824787, $p0->getLatitude(), '', 0.0001);
			$this->assertEquals(50, $p0->getAltitude(), '', 0.0001);
	
			$p1 = $latLngCollection[1];
			$this->assertTrue($p1->hasLongitude());
			$this->assertTrue($p1->hasLatitude());
			$this->assertTrue($p1->hasAltitude());
			$this->assertFalse($p1->isEmpty());
	
			$this->assertEquals(-122.363917, $p1->getLongitude(), '', 0.0001);
			$this->assertEquals(37.824423, $p1->getLatitude(), '', 0.0001);
			$this->assertEquals(55, $p1->getAltitude(), '', 0.0001);
		}
	
		public function test_canParseTupleStrings_withoutAlt() {
			$latLngCollection = new LatLngAltCollection('-122.364167,37.824787 -122.363917,37.824423');
	
			$this->assertEquals(2, count($latLngCollection));
	
			$p0 = $latLngCollection[0];
			$this->assertTrue($p0->hasLongitude());
			$this->assertTrue($p0->hasLatitude());
			$this->assertFalse($p0->hasAltitude());
			$this->assertFalse($p0->isEmpty());
	
			$this->assertEquals(-122.364167, $p0->getLongitude(), '', 0.0001);
			$this->assertEquals(37.824787, $p0->getLatitude(), '', 0.0001);
			$this->assertNull($p0->getAltitude());
	
			$p1 = $latLngCollection[1];
			$this->assertTrue($p1->hasLongitude());
			$this->assertTrue($p1->hasLatitude());
			$this->assertFalse($p1->hasAltitude());
			$this->assertFalse($p1->isEmpty());
	
			$this->assertEquals(-122.363917, $p1->getLongitude(), '', 0.0001);
			$this->assertEquals(37.824423, $p1->getLatitude(), '', 0.0001);
			$this->assertNull($p1->getAltitude());
		}
	
		public function test_tryParseEmptyTupleString() {
			$latLngCollection = new LatLngAltCollection('');
			$this->assertEquals(0, count($latLngCollection));
		}
	}
}
<?php
namespace KamelPhp\Tests {

    use KamelPhp\KmlParser\Entities\LinearRing;
    use KamelPhp\KmlParser\Entities\LineString;
    use KamelPhp\KmlParser\Entities\MultiGeometry;
    use KamelPhp\KmlParser\Entities\Placemark;
    use KamelPhp\KmlParser\Entities\Point;
    use KamelPhp\KmlParser\Entities\Polygon;
    use KamelPhp\KmlParser\Parser;
    use KamelPhp\Tests\Helper\TestDataFileHelper;
    use PHPUnit\Framework\TestCase;

	class LibKmlParserPlacemarkTests extends TestCase {
		use TestDataFileHelper;

		public function test_canParse_withPoint(): void {
			$this->_runPlacemarkTest('kml/test-kml-placemark-with-point.kml', 
				function(Placemark $placemark) {
					$this->assertEquals('Placemark with Point', $placemark->getName());
	
					$this->assertTrue($placemark->hasPoint());
					$this->assertFalse($placemark->hasLineString());
					$this->assertFalse($placemark->hasLinearRing());
					$this->assertFalse($placemark->hasPolygon());
					$this->assertFalse($placemark->hasMultiGeometry());
	
					$point = $placemark->getPoint();
					$this->assertNotNull($point);
					$this->_assertExpectedPoint($point);
				}
			);
		}

		private function _assertExpectedPoint(Point $point): void {
			$this->assertTrue($point->hasCoordinate());
		
			$coord = $point->getCoordinate();
			$this->assertNotNull($coord);
	
			$latLng = $coord->getLatLngAlt();
			$this->assertEquals(-90.86948943473118, $latLng->getLongitude());
			$this->assertEquals(48.25450093195546, $latLng->getLatitude());
			$this->assertEquals(123.456, $latLng->getAltitude());
		}

		public function test_canParse_withLineString(): void {
			$this->_runPlacemarkTest('kml/test-kml-placemark-with-lineString.kml', 
				function(Placemark $placemark) {
					$this->assertEquals('Placemark with LineString', $placemark->getName());
	
					$this->assertFalse($placemark->hasPoint());
					$this->assertTrue($placemark->hasLineString());
					$this->assertFalse($placemark->hasLinearRing());
					$this->assertFalse($placemark->hasPolygon());
					$this->assertFalse($placemark->hasMultiGeometry());
	
					$lineString = $placemark->getLineString();
					$this->assertNotNull($lineString);
					$this->_assertExpectedLineString($lineString);
				}
			);
		}

		private function _assertExpectedLineString(LineString $lineString): void {
			$this->assertTrue($lineString->hasCoordinates());
	
			$coords = $lineString->getCoordinates();
			$this->assertNotNull($coords);
			
			$latLngCollection = $coords->getLatLngAltCollection();
			$this->assertNotNull($latLngCollection);
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

		public function test_canParse_withLinearRing(): void {
			$this->_runPlacemarkTest('kml/test-kml-placemark-with-linearRing.kml', 
				function(Placemark $placemark) {
					$this->assertEquals('Placemark with LinearRing', $placemark->getName());
	
					$this->assertFalse($placemark->hasPoint());
					$this->assertFalse($placemark->hasLineString());
					$this->assertTrue($placemark->hasLinearRing());
					$this->assertFalse($placemark->hasPolygon());
					$this->assertFalse($placemark->hasMultiGeometry());
	
					$linearRing = $placemark->getLinearRing();
					$this->assertNotNull($linearRing);
					$this->_assertExpectedLinearRing($linearRing);
				}
			);
		}

		private function _assertExpectedLinearRing(LinearRing $linearRing): void {
			$this->assertTrue($linearRing->hasCoordinates());
	
			$coords = $linearRing->getCoordinates();
			$this->assertNotNull($coords);
			
			$latLngCollection = $coords->getLatLngAltCollection();
			$this->assertNotNull($latLngCollection);
			$this->assertEquals(5, count($latLngCollection));
	
			$p0 = $latLngCollection[0];
			$this->assertTrue($p0->hasLongitude());
			$this->assertTrue($p0->hasLatitude());
			$this->assertTrue($p0->hasAltitude());
			$this->assertFalse($p0->isEmpty());
	
			$this->assertEquals(-122.365662, $p0->getLongitude(), '', 0.0001);
			$this->assertEquals(37.826988, $p0->getLatitude(), '', 0.0001);
			$this->assertEquals(0, $p0->getAltitude(), '', 0.0001);
	
			$p1 = $latLngCollection[1];
			$this->assertTrue($p1->hasLongitude());
			$this->assertTrue($p1->hasLatitude());
			$this->assertTrue($p1->hasAltitude());
			$this->assertFalse($p1->isEmpty());
	
			$this->assertEquals(-122.365202, $p1->getLongitude(), '', 0.0001);
			$this->assertEquals(37.826302, $p1->getLatitude(), '', 0.0001);
			$this->assertEquals(55, $p1->getAltitude(), '', 0.0001);
	
			$p4 = $latLngCollection[4];
			$this->assertTrue($p4->hasLongitude());
			$this->assertTrue($p4->hasLatitude());
			$this->assertTrue($p4->hasAltitude());
			$this->assertFalse($p4->isEmpty());
	
			$this->assertEquals(-122.365662, $p4->getLongitude(), '', 0.0001);
			$this->assertEquals(37.826988, $p4->getLatitude(), '', 0.0001);
			$this->assertEquals(55, $p4->getAltitude(), '', 0.0001);
		}

		public function test_canParse_withPolygon(): void {
			$this->_runPlacemarkTest('kml/test-kml-placemark-with-polygon.kml', 
				function(Placemark $placemark) {
					$this->assertEquals('Placemark with Polygon', $placemark->getName());
	
					$this->assertFalse($placemark->hasPoint());
					$this->assertFalse($placemark->hasLineString());
					$this->assertFalse($placemark->hasLinearRing());
					$this->assertTrue($placemark->hasPolygon());
					$this->assertFalse($placemark->hasMultiGeometry());
	
					$polygon = $placemark->getPolygon();
					$this->assertNotNull($polygon);
					$this->_assertExpectedPolygon($polygon);				
				}
			);
		}

		private function _assertExpectedPolygon(Polygon $polygon): void {
			$this->assertTrue($polygon->hasOuterBoundary());
			$this->assertTrue($polygon->hasInnerBoundary());
			$this->assertEquals(1, count($polygon->getInnerBoundary()));
	
			$this->_assertExpectedOuterBoundary($polygon->getOuterBoundary());
			$this->_assertExpectedInnerBoundary($polygon->getInnerBoundary()[0]);
		}

		private function _assertExpectedOuterBoundary(LinearRing $linearRing): void {
			$this->assertTrue($linearRing->hasCoordinates());
	
			$coords = $linearRing->getCoordinates();
			$this->assertNotNull($coords);
			
			$latLngCollection = $coords->getLatLngAltCollection();
			$this->assertNotNull($latLngCollection);
			$this->assertEquals(5, count($latLngCollection));
	
			$p0 = $latLngCollection[0];
			$this->assertTrue($p0->hasLongitude());
			$this->assertTrue($p0->hasLatitude());
			$this->assertTrue($p0->hasAltitude());
			$this->assertFalse($p0->isEmpty());
	
			$this->assertEquals(-122.366278, $p0->getLongitude(), '', 0.0001);
			$this->assertEquals(37.818844, $p0->getLatitude(), '', 0.0001);
			$this->assertEquals(30, $p0->getAltitude(), '', 0.0001);
	
			$p1 = $latLngCollection[1];
			$this->assertTrue($p1->hasLongitude());
			$this->assertTrue($p1->hasLatitude());
			$this->assertTrue($p1->hasAltitude());
			$this->assertFalse($p1->isEmpty());
	
			$this->assertEquals(-122.365248, $p1->getLongitude(), '', 0.0001);
			$this->assertEquals(37.819267, $p1->getLatitude(), '', 0.0001);
			$this->assertEquals(35, $p1->getAltitude(), '', 0.0001);
	
			$p4 = $latLngCollection[4];
			$this->assertTrue($p4->hasLongitude());
			$this->assertTrue($p4->hasLatitude());
			$this->assertTrue($p4->hasAltitude());
			$this->assertFalse($p4->isEmpty());
	
			$this->assertEquals(-122.366278, $p4->getLongitude(), '', 0.0001);
			$this->assertEquals(37.818844, $p4->getLatitude(), '', 0.0001);
			$this->assertEquals(30, $p4->getAltitude(), '', 0.0001);
		}

		private function _assertExpectedInnerBoundary(LinearRing $linearRing): void {
			$this->assertTrue($linearRing->hasCoordinates());
	
			$coords = $linearRing->getCoordinates();
			$this->assertNotNull($coords);
			
			$latLngCollection = $coords->getLatLngAltCollection();
			$this->assertNotNull($latLngCollection);
			$this->assertEquals(5, count($latLngCollection));
	
			$p0 = $latLngCollection[0];
			$this->assertTrue($p0->hasLongitude());
			$this->assertTrue($p0->hasLatitude());
			$this->assertTrue($p0->hasAltitude());
			$this->assertFalse($p0->isEmpty());
	
			$this->assertEquals(-122.366212, $p0->getLongitude(), '', 0.0001);
			$this->assertEquals(37.818977, $p0->getLatitude(), '', 0.0001);
			$this->assertEquals(30, $p0->getAltitude(), '', 0.0001);
	
			$p1 = $latLngCollection[1];
			$this->assertTrue($p1->hasLongitude());
			$this->assertTrue($p1->hasLatitude());
			$this->assertTrue($p1->hasAltitude());
			$this->assertFalse($p1->isEmpty());
	
			$this->assertEquals(-122.365424, $p1->getLongitude(), '', 0.0001);
			$this->assertEquals(37.819294, $p1->getLatitude(), '', 0.0001);
			$this->assertEquals(45, $p1->getAltitude(), '', 0.0001);
	
			$p4 = $latLngCollection[4];
			$this->assertTrue($p4->hasLongitude());
			$this->assertTrue($p4->hasLatitude());
			$this->assertTrue($p4->hasAltitude());
			$this->assertFalse($p4->isEmpty());
	
			$this->assertEquals(-122.366212, $p4->getLongitude(), '', 0.0001);
			$this->assertEquals(37.818977, $p4->getLatitude(), '', 0.0001);
			$this->assertEquals(30, $p4->getAltitude(), '', 0.0001);
		}

		public function test_canParse_withMultiGeometry(): void {
			$this->_runPlacemarkTest('kml/test-kml-placemark-with-multiGeometry.kml', 
				function(Placemark $placemark) {
					$this->assertEquals('Placemark with MultiGeometry', $placemark->getName());
	
					$this->assertFalse($placemark->hasPoint());
					$this->assertFalse($placemark->hasLineString());
					$this->assertFalse($placemark->hasLinearRing());
					$this->assertFalse($placemark->hasPolygon());
					$this->assertTrue($placemark->hasMultiGeometry());
	
					$multiGeometry = $placemark->getMultiGeometry();
					$this->assertNotNull($multiGeometry);
					$this->_assertExpectedMultiGeometry($multiGeometry);				
				}
			);
		}

		private function _assertExpectedMultiGeometry(MultiGeometry $multiGeometry): void {
			$this->assertTrue($multiGeometry->hasPoints());
			$this->assertTrue($multiGeometry->hasLinearRings());
			$this->assertTrue($multiGeometry->hasPolygons());
			$this->assertTrue($multiGeometry->hasLineStrings());
	
			$points = $multiGeometry->getPoints();
			$this->assertEquals(1, count($points));
			$this->assertNotNull($points[0]);
			$this->_assertExpectedPoint($points[0]);
	
			$lineStrings = $multiGeometry->getLineStrings();
			$this->assertEquals(1, count($lineStrings));
			$this->assertNotNull($lineStrings[0]);
			$this->_assertExpectedLineString($lineStrings[0]);
	
			$linearRings = $multiGeometry->getLinearRings();
			$this->assertEquals(1, count($linearRings));
			$this->assertNotNull($linearRings[0]);
			$this->_assertExpectedLinearRing($linearRings[0]);
	
			$polygons = $multiGeometry->getPolygons();
			$this->assertEquals(1, count($polygons));
			$this->assertNotNull($polygons[0]);
			$this->_assertExpectedPolygon($polygons[0]);
		}

		private function _runPlacemarkTest(string $file, callable $asserter): void {
			$fileContents = $this->_readTestDataFileContents($file); 
			$kmlParser = Parser::fromString($fileContents);
			$kml = $kmlParser->getKml();
			
			$document = $kml->getDocument();
			$this->assertNotNull($document);
			$this->assertEquals(basename($file), $document->getName());
	
			$placemarks = $document->getPlacemarks();
			$this->assertNotNull($placemarks);
			$this->assertEquals(1, count($placemarks));
			
			$pk0 = $placemarks[0];
			$this->assertNotNull($pk0);
			$asserter($pk0);
		}

		protected static function _getRootTestsDir() {
			return __DIR__;
		}
	}
}
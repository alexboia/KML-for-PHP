<?php
namespace KamelPhp\Tests {

    use KamelPhp\KmlParser\Entities\Kml;
    use KamelPhp\KmlParser\Exceptions\InvalidKmlRootElementException;
    use KamelPhp\KmlParser\Parser;
    use KamelPhp\Tests\Helper\TestDataFileHelper;
    use PHPUnit\Framework\TestCase;

	class LibKmlParserTests extends TestCase {
		use TestDataFileHelper;

		public function test_canParseEmptyKml(): void {
			$fileContents = $this->_readTestDataFileContents('kml/test-kml-empty.kml'); 
			$kmlParser = Parser::fromString($fileContents);
			$kml = $kmlParser->getKml();
			$this->assertNotNull($kml);
			$this->_assertEmptyKml($kml);
		}
		
		private function _assertEmptyKml(Kml $kml): void {
			$this->assertFalse($kml->hasDocument());
			$this->assertFalse($kml->hasFolder());
		}

		public function test_tryParseKmlFileWithInvalidRoot_shouldThrowException(): void {
			$this->expectException(InvalidKmlRootElementException::class);
			$fileContents = $this->_readTestDataFileContents('kml/test-kml-invalidRoot.kml'); 
			Parser::fromString($fileContents);
		}

		public function test_canParseKml_documentAsRoot_noFolders_singlePlacemark(): void {
			$fileContents = $this->_readTestDataFileContents('kml/test-kml-document-as-root-no-folders.kml'); 
			$kmlParser = Parser::fromString($fileContents);
			
			$kml = $kmlParser->getKml();
			$this->assertTrue($kml->hasDocument());
			$this->assertFalse($kml->hasFolder());
	
			$document = $kml->getDocument();
			$this->assertNotNull($document);
	
			$this->assertTrue($document->hasName());
			$this->assertEquals('Azuga - Zizin - Vama Buzaului - Brasov.kml', $document->getName());
	
			$this->assertTrue($document->hasPlacemarks());
	
			$placemarks = $document->getPlacemarks();
			$this->assertEquals(1, count($placemarks));
	
			$pk0 = $placemarks[0];
			$this->assertNotNull($pk0);
			$this->assertTrue($pk0->hasName());
			$this->assertEquals('Azuga - Zizin - Vama Buzaului - Brasov', $pk0->getName());
	
			$this->assertTrue($pk0->hasLineString());
			$this->assertFalse($pk0->hasLinearRing());
			$this->assertFalse($pk0->hasPoint());
			$this->assertFalse($pk0->hasPolygon());
			$this->assertFalse($pk0->hasMultiGeometry());
	
			$ls0 = $pk0->getLineString();
			$this->assertNotNull($ls0);
			$this->assertTrue($ls0->hasCoordinates());
	
			$coords0 = $ls0->getCoordinates();
			$this->assertNotNull($coords0);
	
			$latLngs0 = $coords0->getLatLngAltCollection();
			$this->assertNotNull($latLngs0);
	
			$this->assertGreaterThan(10, count($latLngs0));
	
			$p0 = $latLngs0[0];
			$this->assertTrue($p0->hasLongitude());
			$this->assertTrue($p0->hasLatitude());
			$this->assertTrue($p0->hasAltitude());
			$this->assertFalse($p0->isEmpty());
	
			$this->assertEquals(25.55129386596317, $p0->getLongitude(), '', 0.0001);
			$this->assertEquals(45.44035592109068, $p0->getLatitude(), '', 0.0001);
			$this->assertEquals(0, $p0->getAltitude(), '', 0.0001);
	
	
			$pN = $latLngs0[count($latLngs0) - 1];
			$this->assertTrue($pN->hasLongitude());
			$this->assertTrue($pN->hasLatitude());
			$this->assertTrue($pN->hasAltitude());
			$this->assertFalse($pN->isEmpty());
	
			$this->assertEquals(25.99871164164519, $pN->getLongitude(), '', 0.0001);
			$this->assertEquals(45.65004792577662, $pN->getLatitude(), '', 0.0001);
			$this->assertEquals(0, $pN->getAltitude(), '', 0.0001);
		}

		protected static function _getRootTestsDir() {
			return __DIR__;
		}
	}
}
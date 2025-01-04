<h1 align="center">KML for PHP library (KamelPhp)</h1>

A PHP KML parser library initially developed as part of the [WP-Trip-Summary WordPress plug-in](https://github.com/alexboia/WP-Trip-Summary/). 
It is based on [Stepan Daleky's KML parser on GitLab](https://gitlab.com/stepandalecky/kml-parser) and has now been extracted as a separate library to ease up on the code base a bit.

## About

Currently, the KML documents are parsed as follows:

- Either root KML folder or root KML document is considered, not both (first it checks for a root folder and, if not found for a root document);
- A KML container is searched, in this order, for: folders, documents and placemarks;
- For a placemark, `Point`, `Linestring`, `LinearRing`, `Polygon` and `MultiGeometry` geometries are supported;
- Neither folder, nor document metadata is stored;

- A `Point` geometry is read as a document-level waypoint, regardless of where it is found in the KML file;
- For a `Point` geometry, the name and description metadata are stored;

- A `LineString` is read as a track part with a single track segment;
- For a `LineString` geometry, only the name metadata is stored;

- A `LinearRing` is read as a track part with a single track segment;
- For a `LinearRing` geometry, only the name metadata is stored;

- A `Polygon` is read as two track parts: one for the outer boundary `LinearRing`, the other for the inner boundary `LinearRing`;
- For a `Polygon` geometry, only the name metadata is stored, for each of the resulting track parts;

- A `MultiGeometry` is processed by reading its individual parts, not as a whole, obeying the above-mentioned rules.

## Usage

### Using the parser directly

```PHP
use KamelPhp\KmlParser\Parser;

$kmlParser = Parser::fromString($fileContents);
//OR
$kmlParser = Parser::fromFile($filePath);

//And then get the KML root and do your thing with it.
$kml = $kmlParser->getKml();
```

Some samples:
- The built-in [`Processor`]()
- The [current set of tests for the parser class]()

### Using the processor


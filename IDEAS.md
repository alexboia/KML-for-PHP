# KamelPhp Ideas

This file collects lightweight ways to make the library more useful without turning it into a large KML framework.

## Guiding Direction

Keep the library focused on common KML reading use cases: extracting placemarks, geometries, coordinates, and basic metadata from real-world KML files.

The library should remain small, dependency-light, and easy to understand. New features should mostly improve convenience, robustness, and interoperability.

## Useful Additions

### 1. Convenience APIs for Common Use Cases

Add small helper APIs for tasks users usually want immediately:

- get all placemarks from the document tree;
- walk placemarks recursively;
- extract all points, line strings, polygons, or tracks;
- calculate a bounding box;
- count coordinates/geometries;
- read common feature metadata without traversing the full object graph manually.

These APIs would sit above the existing entity model and avoid forcing users to understand every KML container detail.

### 2. Lightweight Traversal Before Full Streaming

Add ergonomic traversal over the current `SimpleXMLElement`-backed model:

- `walkPlacemarks(callable $callback)`;
- `walkGeometries(callable $callback)`;
- a more convenient processor/delegate base class;
- optional filters for geometry type or visibility.

This does not reduce memory usage significantly, because the XML is still loaded in memory, but it makes the library much easier to consume.

### 3. Optional Streaming Parser for Large Files

For genuinely large KML files, add a separate `XMLReader`-based streaming API instead of replacing the current parser.

Possible shape:

```php
foreach (PlacemarkStream::fromFile($path) as $placemark) {
    // Process one placemark at a time.
}
```

Keep the streaming subset intentionally small:

- `Placemark`;
- `Point`;
- `LineString`;
- `LinearRing`;
- `Polygon`;
- `MultiGeometry`;
- `name`;
- `description`;
- minimal `ExtendedData`.

The streaming parser should be positioned as a memory-friendly reader for common extraction scenarios, not as a complete KML implementation.

### 4. Ready-to-Use Derived Data

Add small value helpers that are useful in map/trip/route applications:

- bounding box;
- simple centroid;
- coordinate count;
- geometry type summary;
- track/route extraction;
- conversion to simple arrays.

Avoid heavy GIS operations. Anything involving projection, topology, simplification, or spatial indexing belongs outside this library.

### 5. Minimal GeoJSON Export

Add optional export helpers for common geometries:

- `Point`;
- `LineString`;
- `Polygon`;
- `MultiGeometry` as `GeometryCollection`;
- `Feature` with basic properties.

This would make the library immediately useful in web mapping workflows without adding external dependencies.

### 6. More Tolerant Parsing

Introduce parser options that let callers choose between strict behavior and pragmatic real-world parsing.

Potential tolerance features:

- ignore unsupported KML elements;
- skip invalid coordinates instead of failing the full parse;
- collect warnings for skipped or malformed values;
- accept missing optional feature fields;
- choose how to handle duplicate elements where only one was expected;
- optionally normalize whitespace-heavy coordinate blocks;
- optionally ignore invalid altitude values while keeping latitude/longitude;
- optionally clamp coordinates to valid latitude/longitude ranges;
- optionally process invisible features or skip them.

Strict mode should remain the safest default for structural errors. Tolerant mode should be explicit.

### 7. Easier Processor Delegates

The current delegate interface is powerful but verbose. Add an abstract/default delegate with no-op methods and sensible defaults so users can override only what they need.

Example:

```php
final class MyDelegate extends DefaultDelegate {
    public function processLineString(LineString $lineString, FeatureMetadata $metadata): void {
        // Use only line strings.
    }
}
```

### 8. Documentation Recipes

Add copy-paste examples for common workflows:

- parse a KML file;
- list all placemarks;
- extract a route;
- get all points;
- calculate a bounding box;
- convert simple geometries to GeoJSON;
- process a large file with the streaming API, if added.

### 9. Small API Cleanup

Potential cleanup items:

- fix the internal `Placemerk` typo while keeping a backward-compatible alias for a while;
- make nullable/empty return behavior more consistent;
- document which parts of KML are supported;
- document limitations as design choices, not just missing features.

## Things to Avoid for Now

Avoid adding these unless there is a concrete use case:

- complete KML standard coverage;
- full XSD validation;
- full KMZ handling;
- style rendering;
- network links;
- Google `gx:*` extensions;
- advanced GIS operations;
- a complete writer/generator API;
- external runtime dependencies.

These can quickly make the library heavy and harder to maintain.

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Using a Layer.Text to display markers</title>
    <link rel="stylesheet" href="http://openlayers.org/dev/theme/default/style.css" type="text/css">
    <link rel="stylesheet" href="http://openlayers.org/dev/examples/style.css" type="text/css">
    <link rel="stylesheet" href="templates/style.css" type="text/css">
    <script src="http://openlayers.org/api/2.11/OpenLayers.js "></script>
    <script type="text/javascript">
        var map, layer;

        function init(){
            OpenLayers.ProxyHost="/proxy/?url=";
            map = new OpenLayers.Map('map');
            layer = new OpenLayers.Layer.WMS( "OpenLayers WMS", 
                "http://vmap0.tiles.osgeo.org/wms/vmap0", {layers: 'basic'} );
                
            map.addLayer(layer);

            var openl = new OpenLayers.Layer.Text( "open", {location: "./maptextfile.php?type=open"} );
            map.addLayer(openl);
            
            var wepl = new OpenLayers.Layer.Text( "wep", {location: "./maptextfile.php?type=wep",isBaseLayer: false, visibility: false} );
            map.addLayer(wepl);
            
            var otherl = new OpenLayers.Layer.Text( "other", {location: "./maptextfile.php?type=other",isBaseLayer: false, visibility: false} );
            map.addLayer(otherl);

            map.addControl(new OpenLayers.Control.LayerSwitcher());
            map.zoomToMaxExtent();
        }
    </script>
  </head>
  <body onload="init()"> 
    <div id="map" class="smallmap"></div>
  </body>
</html>

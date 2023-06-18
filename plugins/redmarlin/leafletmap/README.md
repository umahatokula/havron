Simple plugin for displaying map with marked location using [Leaflet.js](http://leafletjs.com) and OpenStreet Maps.

Alternative for those who don't want to or can't use Google Maps or other commercial products.

You can set map center,  zoom level,  point a marker on the screen and set marker popup text. You can also disable or enable  zoom by scroll behavior,  for example to have full width maps than don't disrupt page scrolling.

The functionality is limited but allows you to quickly add a map with marker to any page.
For most use cases this should be more than enough.

###Features:###
* Based on Leaflet 0.7.7
* You can customize map center, zoom, marker location and marker popup text
* Only one marker possible at this time
* All js, css and img files are included in the plugin
* Zoom control, zoom by scroll can be disabled until clicked on the map

###TODO LIST###
* Add other layers like Mapquest Open, cycle map, etc.

For installation, usage and configuration instructions see Documentation.


##Installation##

Install the plugin directly from the marketplace 
Go to October *Backend  Settings->Updates->Install Plugins*
Type *RedMarlin.LeafletMap* and install the plugin

You can also download the plugin directly from the [Github](https://github.com/RedMarlin/OctoberCMS-Feaflet-Map).
Unpack it to *plugins/redmalin/leafletmap* directory. Logout and login into the backend, and the plugin should be installed now.



##Configuration#
LeafletMap component settings

* **Latitude and Longitude** - Coordinates for the map center separated by coma ie. 50.002, -0.09. Check Get OSM Coordinates chapter to learn how to find your coordinates.
Zoom – initial map zoom level. Should be a number.
* **Marker Coordinates** – latitude and longitude in the same format like map center coordinates. If this field is left empty no marker will be shown.
* **Marker Text** –  A short description that will be displayed  in a popup (when clicked on marker). It could be ie. address.
* **Zoom Control** – Lets you control zoom behavior. By default the zooming feature by scroll/mouse wheel is disabled until visitor clicks on the map.


##Usage##
Add the component to your page and configure it.
Add it to your page following the code:
```
<div id="leafmap"></div>
{% component 'LeafletMap' %}
```

The leafletmap div needs to have height defined. This height is defined by css shipped with the plugin. It is set to 400px.
To change this value or to move height definition to your theme edit css file:
*plugins/redmarlin/leafletmap/assets/css/leaflet.css*
At the end of the file you will have the following line:
```
#leafmap { height: 400px }
```
Change the height value as you see fit or delete it from leaflet.css to move it to another file.

##Getting OSM coordinates and zoom settings##
To find your coordinates and desired zoom level go to [OSM page](https://www.openstreetmap.org)
find desired location on the map (using search or just moving through the map with your mouse).
Double click on the desired location on the map. 
The map will center automatically on the selected location.
Mouse scroll to set desired zoom level.
When everything is set click on the Share icon on the right side of the screen.
![img](http://redmarlin.net/octoberplugins/snapshot55.jpg)
In the Geo URI check this string:
```
geo:41.6591,-4.7287?z=15
```
Paste the selected numbers to Component settings. The *?z=15* defines the zoom level (15 in the example).
Alternatively you could just check the link bar of your browser:
```
map=15/41.6591/-4.7287
```
![img](http://redmarlin.net/octoberplugins/snapshot54.jpg)
The first number after *map=* string is zoom level (15), then you have latitude and longitude divided by "/".

##Contact##
If you have any questions just ask!  

 You can contact us at:
* [October Marketplace](http://octobercms.com/author/RedMarlin)
* [Redmarlin Page](http://redmarlin.net/contact)

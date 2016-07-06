[//]: # (keyword|concept_3d)
<div class='gama-keyword-style' id ='132_0_1_concept-3d'></div>
[//]: # (keyword|concept_shapefile)
<div class='gama-keyword-style' id ='132_1_99_concept-shapefile'></div>
[//]: # (keyword|concept_texture)
<div class='gama-keyword-style' id ='132_2_117_concept-texture'></div>
# Visualization of GIS data ## {#visualization-of-gis-data}


_Author :  Patrick Taillandier_

 this model shows how to visualize GIS data without having to create agents  


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\3D Visualization\3D Visualization GIS Visualization\gis_displays_graphics-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\3D Visualization\3D Visualization GIS Visualization\gis_displays_graphics-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\3D Visualization\3D Visualization GIS Visualization\gis_displays_image-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\3D Visualization\3D Visualization GIS Visualization\gis_displays_image-10.png){.img-responsive}

Code of the model : 

```

model GIS_visualization

global {
	file shape_file_buildings <- shape_file("../includes/building.shp");
	geometry shape <- envelope(shape_file_buildings);
	string texture <- "../images/building_texture/texture1.jpg";
	string roof_texture <- "../images/building_texture/roof_top.png";	
}

experiment GIS_visualization type: gui {
	output {
		// display of buildings in 3D with texture and with reading their HEIGHT attribute from the shapefile
		display gis_displays_graphics type: opengl light: true {
			graphics "Buildings as shapes" refresh: false {
				loop bd over: shape_file_buildings {
					draw bd depth: rnd(50) + 50 texture:[roof_texture,texture] border:false;
				}
			}
		}
		
		//display of the building as an image
		display gis_displays_image type: opengl {
			image "Buildings as images" gis: shape_file_buildings.path color: rgb("gray") refresh: false;
		}
	}
}
```
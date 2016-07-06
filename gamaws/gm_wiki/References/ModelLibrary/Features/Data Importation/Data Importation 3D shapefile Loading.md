[//]: # (keyword|operator_shape_file)
<div class='gama-keyword-style' id ='157_0_476_operator-shape-file'></div>
[//]: # (keyword|concept_3d)
<div class='gama-keyword-style' id ='157_1_1_concept-3d'></div>
[//]: # (keyword|concept_shapefile)
<div class='gama-keyword-style' id ='157_2_99_concept-shapefile'></div>
[//]: # (keyword|concept_load_file)
<div class='gama-keyword-style' id ='157_3_65_concept-load-file'></div>
# 3D shapefile loading ## {#3d-shapefile-loading}


_Author :  _

Model which shows how to create a shape using a 3D Shapefile after this one has been loaded. 


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Data Importation\Data Importation 3D shapefile Loading\city_display-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Data Importation\Data Importation 3D shapefile Loading\city_display-10.png){.img-responsive}

Code of the model : 

```
model shapefile_loading

global {
	
	//file variable that will store the shape file
	file shape_file_gis_3d_objects <- shape_file('../includes/Mobilier.shp', 0);
	geometry shape <- envelope(shape_file_gis_3d_objects);
	init {
		create gis_3d_object from: shape_file_gis_3d_objects;
	}
}

species gis_3d_object {
	aspect base {
		draw shape at:{world.shape.width/2,world.shape.height/2,0};
	}
}

experiment display_shape type: gui {

	output {
		display city_display type: opengl draw_env:false{
			species gis_3d_object aspect: base;
		}

	}
}

```
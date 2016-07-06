[//]: # (keyword|concept_grid)
<div class='gama-keyword-style' id ='158_0_51_concept-grid'></div>
[//]: # (keyword|concept_load_file)
<div class='gama-keyword-style' id ='158_1_65_concept-load-file'></div>
[//]: # (keyword|concept_asc)
<div class='gama-keyword-style' id ='158_2_8_concept-asc'></div>
# ESRI ASCII to grid model ## {#esri-ascii-to-grid-model}


_Author :  Patrick Taillandier_

Model which shows how to initialize a grid using a ESRI ASCII file


Code of the model : 

```

model ascimport

global {
	//definiton of the file to import
	file grid_data <- file('../includes/hab10.asc') ;
	
	//computation of the environment size from the geotiff file
	geometry shape <- envelope(grid_data);	
}



//definition of the grid from the asc file: the width and height of the grid are directly read from the asc file. The values of the asc file are stored in the grid_value attribute of the cells.
grid cell file: grid_data{
	init {
		color<- grid_value = 0.0 ? #black  : (grid_value = 1.0  ? #green :   #yellow);
	}
}

experiment gridloading type: gui {
	output {
		display "As DEM" type: opengl{
			grid cell lines: #gray elevation: grid_value * 300 ;
		}
		
		display "As 2D grid"  type: java2D {
			grid cell lines: #black;
		}
	} 
}


```
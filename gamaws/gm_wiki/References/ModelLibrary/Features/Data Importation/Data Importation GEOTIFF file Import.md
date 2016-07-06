[//]: # (keyword|operator_max_of)
<div class='gama-keyword-style' id ='163_0_386_operator-max-of'></div>
[//]: # (keyword|operator_min_of)
<div class='gama-keyword-style' id ='163_1_393_operator-min-of'></div>
[//]: # (keyword|concept_load_file)
<div class='gama-keyword-style' id ='163_2_65_concept-load-file'></div>
[//]: # (keyword|concept_tif)
<div class='gama-keyword-style' id ='163_3_118_concept-tif'></div>
[//]: # (keyword|concept_gis)
<div class='gama-keyword-style' id ='163_4_45_concept-gis'></div>
[//]: # (keyword|concept_grid)
<div class='gama-keyword-style' id ='163_5_51_concept-grid'></div>
# GeoTIFF file to Grid of Cells  ## {#geotiff-file-to-grid-of-cells}


_Author :  Patrick Taillandier_

Model which shows how to create a grid of cells by using a GeoTIFF File. 


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Data Importation\Data Importation GEOTIFF file Import\test-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Data Importation\Data Importation GEOTIFF file Import\test-10.png){.img-responsive}

Code of the model : 

```

model geotiffimport

global {
	//definiton of the file to import
	file grid_data <- file('../includes/bogota_grid.tif') ;
	
	//computation of the environment size from the geotiff file
	geometry shape <- envelope(grid_data);	
	
	float max_value;
	float min_value;
	init {
		max_value <- cell max_of (each.grid_value);
		min_value <- cell min_of (each.grid_value);
		ask cell {
			int val <- int(255 * ( 1  - (grid_value - min_value) /(max_value - min_value)));
			color <- rgb(val,val,val);
		}
	}
}

//definition of the grid from the geotiff file: the width and height of the grid are directly read from the asc file. The values of the asc file are stored in the grid_value attribute of the cells.
grid cell file: grid_data;

experiment show_example type: gui {
	output {
		display test {
			grid cell lines: #black;
		}
	} 
}
```
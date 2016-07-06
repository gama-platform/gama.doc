[//]: # (keyword|statement_save)
<div class='gama-keyword-style' id ='221_0_622_statement-save'></div>
[//]: # (keyword|concept_save_file)
<div class='gama-keyword-style' id ='221_1_95_concept-save-file'></div>
[//]: # (keyword|concept_asc)
<div class='gama-keyword-style' id ='221_2_8_concept-asc'></div>
# Save to Ascii ## {#save-to-ascii}


_Author : Patrick Taillandier_

This is a model that shows how to save a grid inside a ASCII File to reuse it later or to keep it.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Save statement\Save statement Save_to_asc\map-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Save statement\Save statement Save_to_asc\map-10.png){.img-responsive}

Code of the model : 

```

model SavetoAsc

global {
	init {	
		//save grid "grid_value" attribute into the asc file.
		save cell to:"../results/grid.asc" type:"asc";
	}
}

//Grid that will be saved in the ASC File
grid cell width: 50 height: 50 {
	float grid_value <- self distance_to world.location;
	rgb color <- rgb(255 * (1 - grid_value / 50), 0,0);
}

experiment main type: gui {
	output {
		display map {
			grid cell lines: #black;
		}
	}
}
```
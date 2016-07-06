[//]: # (keyword|operator_get)
<div class='gama-keyword-style' id ='162_0_308_operator-get'></div>
[//]: # (keyword|operator_group_by)
<div class='gama-keyword-style' id ='162_1_320_operator-group-by'></div>
[//]: # (keyword|operator_rnd_color)
<div class='gama-keyword-style' id ='162_2_459_operator-rnd-color'></div>
[//]: # (keyword|constant_#brown)
<div class='gama-keyword-style' id ='162_3_1178_constant--brown'></div>
[//]: # (keyword|concept_dxf)
<div class='gama-keyword-style' id ='162_4_35_concept-dxf'></div>
[//]: # (keyword|concept_load_file)
<div class='gama-keyword-style' id ='162_5_65_concept-load-file'></div>
# DXF to Agents Model ## {#dxf-to-agents-model}


_Author :  Patrick Taillandier_

Model which shows how to create agents by importing data of a DXF file


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Data Importation\Data Importation DXF Agents\map-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Data Importation\Data Importation DXF Agents\map-10.png){.img-responsive}

Code of the model : 

```

model DXFAgents 

global {
	file house_file <- file("../includes/house.dxf");
	
	//compute the environment size from the dxf file envelope
	geometry shape <- envelope(house_file);
	
	init {
		//create house_element agents from the dxf file and initialized the layer attribute of the agents from the the file
		create house_element from: house_file with: [layer::string(get("layer"))];
				create house_element from: house_file with: [layer::string(get("layer"))];
						create house_element from: house_file with: [layer::string(get("layer"))];
		//define a random color for each layer
		map layers <- list(house_element) group_by each.layer;
		loop la over: layers.keys {
			rgb col <- rnd_color(255);
			ask layers[la] {color <- col;}
		}
	}
}

species house_element {
	string layer;
	rgb color;
	aspect default {
		draw shape color: color;
	}
} 

experiment DXFAgents type: gui {
	output {
		display map {
			species house_element;
		}
		
		display "As_Image" {
			graphics "House" {
				draw house_file color: #brown ;
			}
		}
	}
	
	
}
```
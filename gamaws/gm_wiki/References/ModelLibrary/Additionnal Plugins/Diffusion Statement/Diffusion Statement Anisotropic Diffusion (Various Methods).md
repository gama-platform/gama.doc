[//]: # (keyword|operator_hsb)
<div class='gama-keyword-style' id ='98_0_324_operator-hsb'></div>
[//]: # (keyword|statement_diffuse)
<div class='gama-keyword-style' id ='98_1_580_statement-diffuse'></div>
[//]: # (keyword|type_matrix)
<div class='gama-keyword-style' id ='98_2_1556_type-matrix'></div>
[//]: # (keyword|concept_diffusion)
<div class='gama-keyword-style' id ='98_3_1602_concept-diffusion'></div>
[//]: # (keyword|concept_matrix)
<div class='gama-keyword-style' id ='98_4_70_concept-matrix'></div>
[//]: # (keyword|concept_math)
<div class='gama-keyword-style' id ='98_5_69_concept-math'></div>
[//]: # (keyword|concept_elevation)
<div class='gama-keyword-style' id ='98_6_1603_concept-elevation'></div>
# Anisotropic diffusion with several computation method ## {#anisotropic-diffusion-with-several-computation-method}


_Author : Benoit Gaudou_

This model is used to show two different computation methods to use diffusion : with the dot product method and with the convolution method. The cell at the center of the grid emit a pheromon at each step, which is spread through the grid thanks to the diffusion mechanism, using a particular matrix of diffusion. 


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Diffusion Statement\Diffusion Statement Anisotropic Diffusion (Various Methods)\convol-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Diffusion Statement\Diffusion Statement Anisotropic Diffusion (Various Methods){.img-responsive}\convol-10.png)

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Diffusion Statement\Diffusion Statement Anisotropic Diffusion (Various Methods)\dot-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Diffusion Statement\Diffusion Statement Anisotropic Diffusion (Various Methods){.img-responsive}\dot-10.png)

Code of the model : 

```

model diffusion_computation_method

global{
	int size <- 64; // better to have a pow of 2 for the size of the grid
  	geometry shape <- envelope(square(size) * 10);
  	cells_dot selected_cells_dot;
  	cells_convol selected_cells_convol;
  	// Declare the anisotropic matrix (diffuse to the left-upper direction)
  	matrix<float> mat_diff <- matrix([
									[2/9,2/9,1/9],
									[2/9,1/9,0.0],
									[1/9,0.0,0.0]]);

	// Initialize the emiter cell as the cell at the center of the word
	init {
		selected_cells_dot <- location as cells_dot;
  		selected_cells_convol <- location as cells_convol;
	}
	reflex new_Value {
		ask(selected_cells_dot){
			phero <- 1.0;
		}
		ask(selected_cells_convol){
			phero <- 1.0;
		}		
	}

	reflex diff {
		// Declare a diffusion on the grid "cells_dot" (with a dot product computation) and on "cells_convol" (with a convol computation). 
		// The value of the diffusion will be store in the new variable "phero" of the cell.
		diffuse var: phero on: cells_dot matrix: mat_diff method: "dot_product";	
		diffuse var: phero on: cells_convol matrix: mat_diff method: "convolution";			
	}
}


grid cells_dot height: size width: size {
	// "phero" is the variable storing the value of the diffusion
	float phero  <- 0.0;
	// The color of the cell is linked to the value of "phero".
	rgb color <- hsb(phero,1.0,1.0) update: hsb(phero,1.0,1.0);
	// Update the "grid_value", which will be used for the elevation of the cell
	float grid_value update: phero * 100;
} 

grid cells_convol height: size width: size {
	// "phero" is the variable storing the value of the diffusion
	float phero  <- 0.0;
	// The color of the cell is linked to the value of "phero".
	rgb color <- hsb(phero,1.0,1.0) update: hsb(phero,1.0,1.0);
	// Update the "grid_value", which will be used for the elevation of the cell
	float grid_value update: phero * 100;
} 


experiment diffusion type: gui {
	output {
		display dot type: opengl {
			// Display the grid with elevation
			grid cells_dot elevation: true triangulation: true;
		}
		display convol type: opengl {
			// Display the grid with elevation
			grid cells_convol elevation: true triangulation: true;
		}
	}
}
```
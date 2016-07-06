[//]: # (keyword|operator_hsb)
<div class='gama-keyword-style' id ='96_0_324_operator-hsb'></div>
[//]: # (keyword|statement_diffuse)
<div class='gama-keyword-style' id ='96_1_580_statement-diffuse'></div>
[//]: # (keyword|type_matrix)
<div class='gama-keyword-style' id ='96_2_1556_type-matrix'></div>
[//]: # (keyword|concept_diffusion)
<div class='gama-keyword-style' id ='96_3_1602_concept-diffusion'></div>
[//]: # (keyword|concept_matrix)
<div class='gama-keyword-style' id ='96_4_70_concept-matrix'></div>
[//]: # (keyword|concept_math)
<div class='gama-keyword-style' id ='96_5_69_concept-math'></div>
[//]: # (keyword|concept_elevation)
<div class='gama-keyword-style' id ='96_6_1603_concept-elevation'></div>
# Anisotropic diffusion (Simple) ## {#anisotropic-diffusion-simple}


_Author : Benoit Gaudou_

This model is used to show how to construct an anisotropic diffusion through a grid. The cell at the center of the grid emit a pheromon at each step, which is spread through the grid thanks to the diffusion mechanism, using a particular matrix of diffusion.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Diffusion Statement\Diffusion Statement Anisotropic Diffusion (Simple)\a-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Diffusion Statement\Diffusion Statement Anisotropic Diffusion (Simple){.img-responsive}\a-10.png)

Code of the model : 

```

model anisotropic_diffusion

global {
	int size <- 64; // better to have a pow of 2 for the size of the grid
  	geometry shape <- envelope(square(size) * 10);
  	cells selected_cells;
  	
  	// Declare the anisotropic matrix (diffuse to the left-upper direction)
	matrix<float> mat_diff <- matrix([
									[4/9,2/9,0/9],
									[2/9,1/9,0.0],
									[0/9,0.0,0.0]]);
	
	reflex diff { 
		diffuse var: phero on: cells matrix:mat_diff;
	}

	// Initialize the emiter cell as the cell at the center of the word
	init {
		selected_cells <- location as cells;
	}
	reflex new_Value {
		ask selected_cells {
			phero <- 1.0;
		}
	}
}


grid cells height: size width: size {
	// "phero" is the variable storing the value of the diffusion
	float phero  <- 0.0;
	// the color of the cell is linked to the value of "phero".
	rgb color <- hsb(phero,1.0,1.0) update: hsb(phero,1.0,1.0);
	// Update the "grid_value", which will be used for the elevation of the cell
	float grid_value update: phero * 100;
} 


experiment diffusion type: gui {
	output {
		display a type: opengl {
			// Display the grid with elevation
			grid cells elevation: true triangulation: true;
		}
	}
}
```
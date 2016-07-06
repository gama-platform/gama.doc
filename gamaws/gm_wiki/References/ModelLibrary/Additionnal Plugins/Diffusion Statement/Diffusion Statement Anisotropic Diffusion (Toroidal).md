[//]: # (keyword|operator_hsb)
<div class='gama-keyword-style' id ='97_0_324_operator-hsb'></div>
[//]: # (keyword|statement_diffuse)
<div class='gama-keyword-style' id ='97_1_580_statement-diffuse'></div>
[//]: # (keyword|type_matrix)
<div class='gama-keyword-style' id ='97_2_1556_type-matrix'></div>
[//]: # (keyword|concept_diffusion)
<div class='gama-keyword-style' id ='97_3_1602_concept-diffusion'></div>
[//]: # (keyword|concept_matrix)
<div class='gama-keyword-style' id ='97_4_70_concept-matrix'></div>
[//]: # (keyword|concept_math)
<div class='gama-keyword-style' id ='97_5_69_concept-math'></div>
[//]: # (keyword|concept_elevation)
<div class='gama-keyword-style' id ='97_6_1603_concept-elevation'></div>
# Anisotropic diffusion (Toroidal) ## {#anisotropic-diffusion-toroidal}


_Author : Benoit Gaudou_

This model is used to show how to construct an anisotropic diffusion through a grid. The cell at the center of the grid emit a pheromon at each step, which is spread through the grid thanks to the diffusion mechanism, using a particular matrix of diffusion, in a toroidal world.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Diffusion Statement\Diffusion Statement Anisotropic Diffusion (Toroidal)\a-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Diffusion Statement\Diffusion Statement Anisotropic Diffusion (Toroidal){.img-responsive}\a-10.png)

Code of the model : 

```

model anisotropic_diffusion_torus

global torus: true {
	int size <- 64; // better to have a pow of 2 for the size of the grid
  	geometry shape <- envelope(square(size) * 10);
  	cells selected_cells;
  	matrix<float> mat_diff <- matrix([
									[4/9,2/9,0/9],
									[2/9,1/9,0.0],
									[0/9,0.0,0.0]]);
	init {
		selected_cells <- location as cells;
	}
	reflex new_Value {
		ask selected_cells{
			phero <- 1.0;
		}  
	}

	reflex diff {
		diffuse var: phero on: cells matrix: mat_diff method:dot_product;	
	}
}


grid cells height: size width: size  {
	float phero  <- 0.0;
	rgb color <- hsb(phero,1.0,1.0) update: hsb(phero,1.0,1.0);
	float grid_value update: phero * 100;
} 


experiment diffusion type: gui {
	output {
		display a type: opengl {
			grid cells elevation: true triangulation: true;
		}
	}
}
```
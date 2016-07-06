[//]: # (keyword|operator_cube)
<div class='gama-keyword-style' id ='244_0_249_operator-cube'></div>
[//]: # (keyword|operator_select)
<div class='gama-keyword-style' id ='244_1_469_operator-select'></div>
[//]: # (keyword|skill_moving3D)
<div class='gama-keyword-style' id ='244_2_1160_skill-moving3D'></div>
[//]: # (keyword|concept_3d)
<div class='gama-keyword-style' id ='244_3_1_concept-3d'></div>
[//]: # (keyword|concept_light)
<div class='gama-keyword-style' id ='244_4_63_concept-light'></div>
[//]: # (keyword|concept_grid)
<div class='gama-keyword-style' id ='244_5_51_concept-grid'></div>
[//]: # (keyword|concept_neighbors)
<div class='gama-keyword-style' id ='244_6_74_concept-neighbors'></div>
# Moving cells with neighbors ## {#moving-cells-with-neighbors}


_Author : Arnaud Grignard_

Third part of the tutorial : Tuto3D


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\3D\3D Model 03\View1-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\3D\3D Model 03\View1-10.png){.img-responsive}

Code of the model : 

```

model Tuto3D

global {
	geometry shape <- cube(100);
	init { 
		create cells number: 1000{ 
			location <- {rnd(100), rnd(100), rnd(100)};	
		} 
	}  
} 
    
species cells skills: [moving3D] {  
	rgb color;
	list<cells> neighbors;
	int offset;
	
	reflex move {
      do wander;	
	}	
	
	reflex computeNeighbors {
      neighbors <- cells select ((each distance_to self) < 10);
    }
		
	aspect default {
		draw sphere(10) color:#orange;
		loop pp over: neighbors {
			draw line([self.location,pp.location]);
		}	
    }
}

experiment Display  type: gui {
	output {
		display View1 type:opengl background:rgb(10,40,55) {
			species cells aspect: default;
		}
	}
}


```
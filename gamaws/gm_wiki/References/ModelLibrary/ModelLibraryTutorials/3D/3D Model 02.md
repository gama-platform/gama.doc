[//]: # (keyword|operator_cube)
<div class='gama-keyword-style' id ='243_0_249_operator-cube'></div>
[//]: # (keyword|skill_moving3D)
<div class='gama-keyword-style' id ='243_1_1160_skill-moving3D'></div>
[//]: # (keyword|concept_grid)
<div class='gama-keyword-style' id ='243_2_51_concept-grid'></div>
[//]: # (keyword|concept_agent_movement)
<div class='gama-keyword-style' id ='243_3_4_concept-agent-movement'></div>
# Moving cells ## {#moving-cells}


_Author : Arnaud Grignard_

Second part of the tutorial : Tuto3D


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\3D\3D Model 02\View1-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\3D\3D Model 02\View1-10.png){.img-responsive}

Code of the model : 

```
model Tuto3D   

global {
  int nb_cells <-100;
  int environmentSize <-100;
  geometry shape <- cube(environmentSize);	
  init { 
    create cells number: nb_cells { 
      location <- {rnd(environmentSize), rnd(environmentSize), rnd(environmentSize)};       
    } 
  }  
} 
  
species cells skills:[moving3D]{  
	
  reflex move{
  	do move;
  }	                    
  aspect default {
    draw sphere(environmentSize*0.01) color:#blue;   
  }
}

experiment Display  type: gui {
  parameter "Initial number of cells: " var: nb_cells min: 1 max: 1000 category: "Cells" ;
  output {
    display View1 type:opengl{
      graphics "env"{
      	draw cube(environmentSize) color: #black empty:true;	
      }
      species cells;
    }
  }
}
```
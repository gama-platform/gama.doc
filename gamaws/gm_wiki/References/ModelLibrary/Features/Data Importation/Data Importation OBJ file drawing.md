[//]: # (keyword|operator_\:\:)
<div class='gama-keyword-style' id ='166_0_133_operator-----'></div>
[//]: # (keyword|concept_load_file)
<div class='gama-keyword-style' id ='166_1_65_concept-load-file'></div>
[//]: # (keyword|concept_3d)
<div class='gama-keyword-style' id ='166_2_1_concept-3d'></div>
[//]: # (keyword|concept_skill)
<div class='gama-keyword-style' id ='166_3_101_concept-skill'></div>
[//]: # (keyword|concept_obj)
<div class='gama-keyword-style' id ='166_4_77_concept-obj'></div>
# OBJ File to Geometry ## {#obj-file-to-geometry}


_Author :  Arnaud Grignard_

Model which shows how to use a OBJ File to draw a complex geometry. The geometry is simply used, in this case, to draw the agents.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Data Importation\Data Importation OBJ file drawing\ComplexObject-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Data Importation\Data Importation OBJ file drawing\ComplexObject-10.png){.img-responsive}

Code of the model : 

```


model obj_drawing   

global {
	geometry shape <- square(40);

	init { 
		create object number: 30;
	}  
} 

species object skills: [moving]{
	rgb color <- rgb(rnd(255),rnd(255),rnd(255));
	int size <- rnd(10) + 1;
	int rot <- 1000 + rnd(1000);
	reflex m when: every(100) {
		do wander amplitude: 30 speed: 0.001;
	}
	aspect obj {
		draw file("../includes/teapot.obj") color: color size: size rotate: cycle/rot::{0,1,0};
	}
}	

experiment Display  type: gui {
	output {
		display ComplexObject type: opengl background:°orange{
			species object aspect:obj;				
		}
	}
}
```
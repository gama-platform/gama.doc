[//]: # (keyword|concept_load_file)
<div class='gama-keyword-style' id ='167_0_65_concept-load-file'></div>
[//]: # (keyword|concept_3d)
<div class='gama-keyword-style' id ='167_1_1_concept-3d'></div>
[//]: # (keyword|concept_skill)
<div class='gama-keyword-style' id ='167_2_101_concept-skill'></div>
[//]: # (keyword|concept_obj)
<div class='gama-keyword-style' id ='167_3_77_concept-obj'></div>
# Complex Object Loading ## {#complex-object-loading}


_Author :  Arnaud Grignard_

Provides a  complex geometry to agents (svg,obj or 3ds are accepted). The geometry becomes that of the agents.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Data Importation\Data Importation OBJ file loading\complex-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Data Importation\Data Importation OBJ file loading\complex-10.png){.img-responsive}

Code of the model : 

```

model obj_loading   

global {

	init { 
		create object;
	}  
} 

species object skills:[moving]{
	
	geometry shape <- obj_file("../includes/teapot.obj") as geometry;
	
	reflex move{
		do wander;
	}
	aspect obj {
		draw shape;
	}
			
}	

experiment Display  type: gui {
	output {
		display complex  background:#gray type: opengl{
		  species object aspect:obj;				
		}
	}
}
```
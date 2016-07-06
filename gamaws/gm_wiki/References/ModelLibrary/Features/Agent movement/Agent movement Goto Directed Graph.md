[//]: # (keyword|operator_polyline)
<div class='gama-keyword-style' id ='137_0_433_operator-polyline'></div>
[//]: # (keyword|operator_reverse)
<div class='gama-keyword-style' id ='137_1_452_operator-reverse'></div>
[//]: # (keyword|operator_directed)
<div class='gama-keyword-style' id ='137_2_261_operator-directed'></div>
[//]: # (keyword|statement_switch)
<div class='gama-keyword-style' id ='137_3_631_statement-switch'></div>
[//]: # (keyword|statement_match)
<div class='gama-keyword-style' id ='137_4_604_statement-match'></div>
[//]: # (keyword|type_path)
<div class='gama-keyword-style' id ='137_5_1559_type-path'></div>
[//]: # (keyword|concept_graph)
<div class='gama-keyword-style' id ='137_6_47_concept-graph'></div>
[//]: # (keyword|concept_agent_movement)
<div class='gama-keyword-style' id ='137_7_4_concept-agent-movement'></div>
[//]: # (keyword|concept_skill)
<div class='gama-keyword-style' id ='137_8_101_concept-skill'></div>
#  Directed Graph Model ## {#directed-graph-model}


_Author :  Patrick Taillandier_

Model representing how to directed graph using GIS Data for the road networks : the GIS contains a column defining the direction of the roads and people moving from one random point to another on this graph


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Agent movement\Agent movement Goto Directed Graph\map-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Agent movement\Agent movement Goto Directed Graph\map-10.png){.img-responsive}

Code of the model : 

```

model simplemodel

global {
	file road_file <- file("../includes/gis/roads.shp");
	geometry shape <- envelope(road_file);
	graph the_graph; 
	
	init {
		create road from: road_file with:[direction::int(read("DIRECTION"))] {
			switch direction {
				match 0 {color <- #green;}
				match 1 {color <- #red;
					//inversion of the road geometry
					shape <- polyline(reverse(shape.points));
				}
				match 2 {color <- #blue;
					//bidirectional: creation of the inverse road
					create road {
						shape <- polyline(reverse(myself.shape.points));
						direction <- 2;
						color <- #blue;
					}
				} 
			}
		}
		//The operator directed modify the graph created by as_edge_graph(road) to a directed graph
		the_graph <- directed(as_edge_graph(road)) ;
		
		
		create people number: 1000 {
			//The operator any_location_in returns a random point located in one of the road agents
			target <- any_location_in(one_of (road)) ;
			location <- any_location_in (one_of(road));
			source <- location;
		} 
	}
}

species road {
	int direction;
	rgb color;
	aspect geom {
		draw shape color: color;
	}
}
//The people agents use the skill moving which have built-in variables such as speed, target, location, heading and built-in operators
species people skills: [moving] {
	point target;
	path my_path; 
	point source;
	string r_s;
	string r_t; 
	aspect circle {
		draw circle(10) color: #green;
	}
	
	reflex movement {
		
		//The operator goto is a built-in operator derivated from the moving skill, moving the agent from its location to its target, 
		//   restricted by the on variable, with the speed and returning the path followed
		my_path <- self goto (on:the_graph, target:target, speed:10, return_path: true);
		
		//If the agent arrived to its target location, then it choose randomly an other target on the road
		if (target = location) {			
			target <- any_location_in(one_of (road)) ;
			source <- location;
		}
	}
}

experiment simplemodel type: gui {
	output {
		display map {
			species road aspect: geom;
			species people aspect: circle;
		}
	}
}
```
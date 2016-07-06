[//]: # (keyword|operator_path_between)
<div class='gama-keyword-style' id ='204_0_421_operator-path-between'></div>
[//]: # (keyword|operator_node)
<div class='gama-keyword-style' id ='204_1_402_operator-node'></div>
[//]: # (keyword|operator_edge)
<div class='gama-keyword-style' id ='204_2_269_operator-edge'></div>
[//]: # (keyword|operator_link)
<div class='gama-keyword-style' id ='204_3_374_operator-link'></div>
[//]: # (keyword|type_path)
<div class='gama-keyword-style' id ='204_4_1559_type-path'></div>
[//]: # (keyword|concept_graph)
<div class='gama-keyword-style' id ='204_5_47_concept-graph'></div>
[//]: # (keyword|concept_load_file)
<div class='gama-keyword-style' id ='204_6_65_concept-load-file'></div>
[//]: # (keyword|concept_skill)
<div class='gama-keyword-style' id ='204_7_101_concept-skill'></div>
# Multigraph ## {#multigraph}


_Author : Patrick Taillandier_

This model shows how to build a graph on which people agents will move with GIS Shapefile, but also to generate an other graph representing the friendship between the people agents, people agents trying to be closer spatially to each other


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Graphs\Graphs Multigraph\friendship-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Graphs\Graphs Multigraph\friendship-10.png){.img-responsive}

Code of the model : 

```

model multigraph

global {
	file shape_file_in <- file('../includes/road.shp') ;
	file shape_file_bounds <- file('../includes/bounds.shp') ;
	geometry shape <- envelope(shape_file_bounds);
	
	//spatial graph representing the road network
	graph road_graph; 
	
	//social graph (not spatial) representing the frienship links between people
	graph friendship_graph <- graph([]);
	
	init {
		create road from: shape_file_in;
		
		//creation of th road graph from the road agents
		road_graph <- as_edge_graph(road);
		
		//creation of 50 people agent, and add each people agent as a node in the friendship graph
		create people number: 50 {
			add node(self) to: friendship_graph;
		}
		
		//creation of 50 friendship link between people agents
		loop times: 50 {
			people p1 <- one_of(people);
			people p2 <- one_of(list(people) - p1);
			create friendship_link  {
				add edge (p1, p2, self) to: friendship_graph;
				shape <- link(p1,p2);
			}
		}
	}
}

species people skills: [moving]{
	point location <- any_location_in(one_of(road));
	people target_people <- one_of(people);
	point target <- target_people.location;
	float size <- 3.0;
	
	//action that make recompute the size of the agents as the distance between it and its target people in the friendship graph (the farthest, the biggest)
	action updateSize {
		path friendship_path <- path_between(friendship_graph,self,target_people);
		if (friendship_path != nil) {
			size <-max([2,length( friendship_path.edges)]) as float;
		}
	}
	
	//the agent moves toward its target, when reaching it, it chooses another target as the location of one of the people agent
	reflex movement {
		if (location distance_to target < 5.0) {
			target_people <- one_of(people);
			target <- target_people.location;
			do updateSize;
		}
		do goto on:road_graph target:target speed:1 + rnd(2);
	}
	aspect default {
		draw circle(size) color: #red;
	}	
}
	
species friendship_link {
	
	aspect default {
		draw shape color: #blue;
	}
}
	
species road  {
	aspect default {
		draw shape color:#black ;
	}
} 


experiment multigraph type: gui {
	output {
		display friendship type: opengl{
			species road ;
			species friendship_link ;
			species people;
		}
	}
}
```
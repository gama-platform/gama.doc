[//]: # (keyword|operator_path_between)
<div class='gama-keyword-style' id ='136_0_421_operator-path-between'></div>
[//]: # (keyword|operator_with_weights)
<div class='gama-keyword-style' id ='136_1_559_operator-with-weights'></div>
[//]: # (keyword|operator_as_map)
<div class='gama-keyword-style' id ='136_2_192_operator-as-map'></div>
[//]: # (keyword|operator_\:\:)
<div class='gama-keyword-style' id ='136_3_133_operator-----'></div>
[//]: # (keyword|type_path)
<div class='gama-keyword-style' id ='136_4_1559_type-path'></div>
[//]: # (keyword|concept_graph)
<div class='gama-keyword-style' id ='136_5_47_concept-graph'></div>
[//]: # (keyword|concept_agent_movement)
<div class='gama-keyword-style' id ='136_6_4_concept-agent-movement'></div>
[//]: # (keyword|concept_skill)
<div class='gama-keyword-style' id ='136_7_101_concept-skill'></div>
#  Follow Weighted Network ## {#follow-weighted-network}


_Author :  Martine Taillandier_

Model representing how to make a weighted graph and the impacts of the weights on the time to follow the path for the agents. Two agents are represented to show this difference : one knowing the weights and following a fast path, an other following a path longer without knowing it's a longer path.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Agent movement\Agent movement Follow Weighted Network (Agents)\map-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Agent movement\Agent movement Follow Weighted Network (Agents){.img-responsive}\map-10.png)

Code of the model : 

```

model weightperagents

global {
	map<road, float> roads_weight;
	graph road_network;
	float slow_coeff <- 3.0;
	init {
		//This road will be slow
		create road {
			shape <- line ([{10,50},{90,50}]);
			slow <- true;
		}
		//The others will be faster
		create road {
			shape <- line ([{10,50},{10,10}]);
			slow <- false;
		}
		create road {
			shape <- line ([{10,10},{90,10}]);
			slow <- false;
		}
		create road {
			shape <- line ([{90,10},{90,50}]);
			slow <- false;
		}
		
		//Weights map of the graph for those who will know the shortest road by taking into account the weight of the edges
		roads_weight <- road as_map (each:: each.shape.perimeter * (each.slow ? slow_coeff : 1.0));
		road_network <- as_edge_graph(road);
		
		//people with information about the traffic
		create people {
			color <- #blue;
			size <- 2.0;
			roads_knowledge <- roads_weight;
		}
		
		//people without information about the traffic
		create people {
			color <- #yellow;
			size <- 1.0;
			roads_knowledge <- road as_map (each:: each.shape.perimeter);
		}
	}
	
}

species road {
	bool slow;
	aspect geom {
		draw shape color: slow ? #red : #green;
	}
}
	
species people skills: [moving] {
	map<road, float> roads_knowledge;
	point the_target;
	rgb color;
	float size;
	path path_to_follow;
	
	init {
		the_target <- {90,50};
		location <- {10,50};
	}
		
	reflex movement when: location != the_target{
		if (path_to_follow = nil) {
			
			//Find the shortest path using the agent's own weights to compute the shortest path
			path_to_follow <- path_between(road_network with_weights roads_knowledge, location,the_target);
		}
		//the agent follows the path it computed but with the real weights of the graph
		do follow path:path_to_follow speed: 5 move_weights: roads_weight;
	}
		
	aspect base {
		draw circle(size) color: color;
	}
}

experiment weightperagents type: gui {
	float minimum_cycle_duration <- 0.1;
	output {
		display map {
			species road aspect: geom;
			species people aspect: base;
		}
	}
}
```
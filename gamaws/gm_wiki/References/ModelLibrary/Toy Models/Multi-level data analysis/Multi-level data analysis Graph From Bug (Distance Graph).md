[//]: # (keyword|operator_hsb)
<div class='gama-keyword-style' id ='332_0_324_operator-hsb'></div>
[//]: # (keyword|operator_as_distance_graph)
<div class='gama-keyword-style' id ='332_1_185_operator-as-distance-graph'></div>
[//]: # (keyword|concept_graph)
<div class='gama-keyword-style' id ='332_2_47_concept-graph'></div>
[//]: # (keyword|concept_mirror)
<div class='gama-keyword-style' id ='332_3_71_concept-mirror'></div>
[//]: # (keyword|concept_3d)
<div class='gama-keyword-style' id ='332_4_1_concept-3d'></div>
# SpatialGraph ## {#spatialgraph}


_Author : Arnaud Grignard_

From the reference model "bug.gaml" a spatial graph is created. We create a species node that mirrors the species bug and then a spatial graph is creating using as_distance_graph operator.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Multi-level data analysis\Multi-level data analysis Graph From Bug (Distance Graph)\graph_view-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Multi-level data analysis\Multi-level data analysis Graph From Bug (Distance Graph){.img-responsive}\graph_view-10.png)

Code of the model : 

```

model SpatialGraph
//Import the model Common Bug Species model
import '../includes/Common Bug Species.gaml'


global { 
	//Graph that will be computed at each step linking the bug agents according to their distance
	graph myGraph;
	//Minimal distance to consider two nodes agents (ie the bug) as connected
	float distance parameter: 'Distance' min: 1.0 <- 10.0 category: 'Model';
	
	//Reflex to update the graph when cycle is greater than 0. Important because the mirroring has one step late from
	//the original species, and at step 0, the mirroring species aren't created
	reflex updateGraph when:(cycle>0){
		//Kill all the edge agent to create a new graph
		ask edge_agent {
			do die;
		}
		//Create a new graph using the distance to compute the edges
		myGraph <- as_distance_graph(node_agent, ["distance"::distance, "species"::edge_agent]);
	}
}
//Species node_agent mirroring the bug species
species node_agent mirrors: list(bug) {
	//Each location will be the one of the bug at the previous step
	point location <- target.location update: target.location;
	aspect base {
		draw sphere(1.1) color: #green; 
	}
}
//Species to represent the edge of the graph
species edge_agent {
	aspect base {
		draw shape color: #green;
	}
}

experiment spatialGraph type: gui {
	output {	
	 display graph_view type: opengl {
	 	    species bug aspect:base;
			species node_agent aspect: base position:{0,0,0.1};
			species edge_agent aspect: base position:{0,0,0.1};
		}
	}
}
```
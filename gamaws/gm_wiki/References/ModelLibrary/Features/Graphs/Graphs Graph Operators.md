[//]: # (keyword|operator_as_distance_graph)
<div class='gama-keyword-style' id ='202_0_185_operator-as-distance-graph'></div>
[//]: # (keyword|operator_betweenness_centrality)
<div class='gama-keyword-style' id ='202_1_207_operator-betweenness-centrality'></div>
[//]: # (keyword|operator_degree_of)
<div class='gama-keyword-style' id ='202_2_255_operator-degree-of'></div>
[//]: # (keyword|operator_nb_cycles)
<div class='gama-keyword-style' id ='202_3_396_operator-nb-cycles'></div>
[//]: # (keyword|operator_alpha_index)
<div class='gama-keyword-style' id ='202_4_170_operator-alpha-index'></div>
[//]: # (keyword|operator_beta_index)
<div class='gama-keyword-style' id ='202_5_205_operator-beta-index'></div>
[//]: # (keyword|operator_gamma_index)
<div class='gama-keyword-style' id ='202_6_300_operator-gamma-index'></div>
[//]: # (keyword|operator_connectivity_index)
<div class='gama-keyword-style' id ='202_7_229_operator-connectivity-index'></div>
[//]: # (keyword|operator_connected_components_of)
<div class='gama-keyword-style' id ='202_8_228_operator-connected-components-of'></div>
[//]: # (keyword|constant_#lightgray)
<div class='gama-keyword-style' id ='202_9_1256_constant--lightgray'></div>
[//]: # (keyword|concept_graph)
<div class='gama-keyword-style' id ='202_10_47_concept-graph'></div>
# Graph Operators ## {#graph-operators}


_Author : Patrick Taillandier_

Model to show how to use the different existing operators for the graph species


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Graphs\Graphs Graph Operators\map-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Graphs\Graphs Graph Operators\map-10.png){.img-responsive}

Code of the model : 

```

model graphoperators

global {
	graph<geometry,geometry> the_graph;
	init {
		create people number: 50;
		
		//creation of the graph: all vertices that are at distance <= 20 are connected
		the_graph <- as_distance_graph(people, 20);
		
		//compute the betweenness_centrality of each vertice
		map<people,float> bc <- map<people, float>(betweenness_centrality(the_graph));
		float max_centrality <- max(bc.values);
		float min_centrality <- min(bc.values);
		ask people {
			centrality <- (bc[self] - min_centrality) / (max_centrality - min_centrality);
			centrality_color <- rgb(255, int(255 * (1 - centrality)), int(255 * (1 - centrality)));
		}
		write "mean vertice degree: " + mean(the_graph.vertices collect (the_graph degree_of each));
		write "nb_cycles: " + nb_cycles(the_graph);
		write "alpha_index: " + alpha_index(the_graph);
		write "beta_index: " + beta_index(the_graph);
		write "gamma_index: " + gamma_index(the_graph);
		write "connectivity_index: " + connectivity_index(the_graph);
		write "connected_components_of: " + connected_components_of(the_graph);
		
	}
}

species people {
	float centrality;
	rgb centrality_color;
	aspect centrality{
		draw circle(1) color: centrality_color;
		
	}
}

experiment graphoperators type: gui {
	
	output {
		display map background:#lightgray{
			graphics "edges" {
				loop edge over: the_graph.edges {
					draw edge color: #black;
				}
 			}
 			species people aspect: centrality;
			
		}
	}
}
```
[//]: # (keyword|operator_generate_barabasi_albert)
<div class='gama-keyword-style' id ='199_0_302_operator-generate-barabasi-albert'></div>
[//]: # (keyword|operator_generate_watts_strogatz)
<div class='gama-keyword-style' id ='199_1_304_operator-generate-watts-strogatz'></div>
[//]: # (keyword|operator_generate_complete_graph)
<div class='gama-keyword-style' id ='199_2_303_operator-generate-complete-graph'></div>
[//]: # (keyword|statement_switch)
<div class='gama-keyword-style' id ='199_3_631_statement-switch'></div>
[//]: # (keyword|statement_match)
<div class='gama-keyword-style' id ='199_4_604_statement-match'></div>
[//]: # (keyword|concept_graph)
<div class='gama-keyword-style' id ='199_5_47_concept-graph'></div>
# Graph Generation ## {#graph-generation}


_Author : Patrick Taillandier_

Model which shows how to create three kind of graphs : a scale-free graph, a small-world graph, a complete graph and a complete graph with a radius.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Graphs\Graphs Classic Graph Generation\map-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Graphs\Graphs Classic Graph Generation\map-10.png){.img-responsive}

Code of the model : 

```

model classicgraphgeneration

global {
	graph the_graph ;
	string graph_type <- "small-world";
	int nb_nodes <- 500;
	float p <- 0.0;
	int k <- 4;
	int m <- 4;
	int radius <- 20;
	
	init {
		switch graph_type {
			match "scale-free" {
				the_graph <- generate_barabasi_albert(node_agent, edge_agent, nb_nodes,m, true);	
			}
			match "small-world" {
				the_graph <- generate_watts_strogatz(node_agent, edge_agent, nb_nodes, p, k, true);	
			}
			match "complete" {
				the_graph <- generate_complete_graph(node_agent, edge_agent, nb_nodes,true);	
			}
			match "complete-with-radius" {
				the_graph <- generate_complete_graph(node_agent, edge_agent, nb_nodes, radius,true);	
			}		
		}
		write the_graph;
		write "Edges : "+length(the_graph.edges);
		write "Nodes : "+length(the_graph.vertices);
	}
	
}

species edge_agent {
	aspect default {	
		draw shape color: #black;
	}
}

species node_agent {
	aspect default {	
		draw circle(1) color: #red;
	}
}

experiment loadgraph type: gui {
	parameter "Graph type" var: graph_type among: [ "scale-free", "small-world", "complete"];
	parameter "Number of nodes" var: nb_nodes min: 5 ;
	parameter "Probability to rewire an edge (beta)" var: p min: 0.0 max: 1.0 category: "small-world";
	parameter "Base degree of each node. k must be even" var: k min: 2 max: 10 category: "small-world";
	parameter "Number of edges added per novel node" var: m min: 1 max: 10 category: "scale-free";
	
	output {
		display map type: opengl{
			species edge_agent ;
			species node_agent ;
		}
	}
}
```
[//]: # (keyword|operator_load_shortest_paths)
<div class='gama-keyword-style' id ='205_0_379_operator-load-shortest-paths'></div>
[//]: # (keyword|operator_all_pairs_shortest_path)
<div class='gama-keyword-style' id ='205_1_169_operator-all-pairs-shortest-path'></div>
[//]: # (keyword|operator_path_between)
<div class='gama-keyword-style' id ='205_2_421_operator-path-between'></div>
[//]: # (keyword|operator_paths_between)
<div class='gama-keyword-style' id ='205_3_423_operator-paths-between'></div>
[//]: # (keyword|operator_\:\:)
<div class='gama-keyword-style' id ='205_4_133_operator-----'></div>
[//]: # (keyword|statement_save)
<div class='gama-keyword-style' id ='205_5_622_statement-save'></div>
[//]: # (keyword|constant_#cyan)
<div class='gama-keyword-style' id ='205_6_1189_constant--cyan'></div>
[//]: # (keyword|constant_#magenta)
<div class='gama-keyword-style' id ='205_7_1273_constant--magenta'></div>
[//]: # (keyword|type_path)
<div class='gama-keyword-style' id ='205_8_1559_type-path'></div>
[//]: # (keyword|type_matrix)
<div class='gama-keyword-style' id ='205_9_1556_type-matrix'></div>
[//]: # (keyword|concept_graph)
<div class='gama-keyword-style' id ='205_10_47_concept-graph'></div>
[//]: # (keyword|concept_load_file)
<div class='gama-keyword-style' id ='205_11_65_concept-load-file'></div>
[//]: # (keyword|concept_shortest_path)
<div class='gama-keyword-style' id ='205_12_100_concept-shortest-path'></div>
[//]: # (keyword|concept_save_file)
<div class='gama-keyword-style' id ='205_13_95_concept-save-file'></div>
# ShortestPath ## {#shortestpath}


_Author : Patrick Taillandier_

This model shows how get the shortest path from one point to another on a graph. The experiment proposes two displays : one to show the shortest path, an other to show the first k shortest paths. 


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Graphs\Graphs Shortest paths\map_k_shortest_paths-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Graphs\Graphs Shortest paths\map_k_shortest_paths-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Graphs\Graphs Shortest paths\map_shortest_path-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Graphs\Graphs Shortest paths\map_shortest_path-10.png){.img-responsive}

Code of the model : 

```

model ShortestPath

global {
	file shape_file_in <- file('../includes/road.shp') ;
	file shape_file_bounds <- file('../includes/bounds.shp') ;
	geometry shape <- envelope(shape_file_bounds);
	graph road_graph; 
	point source;
	point target;
	path shortest_path;
	list<path> k_shortest_paths;
	int k <- 3; 
	list<rgb> colors <- [#red,#green,#blue,#pink,#cyan,#magenta,#yellow];
	bool save_shortest_paths <- false;
	bool load_shortest_paths <- false;
	string shortest_paths_file <- "../includes/shortest_paths.csv";
	
	init {
		create road from: shape_file_in;
		road_graph <- as_edge_graph(road);
		
		//computes all the shortest paths, puts them in a matrix, then saves the matrix in a file
		if save_shortest_paths {
			matrix ssp <- all_pairs_shortest_path(road_graph);
			write "Matrix of all shortest paths: " + ssp;
			save ssp type:"text" to:shortest_paths_file;
			
		//loads the file of the shortest paths as a matrix and uses it to initialize all the shortest paths of the graph
		} else if load_shortest_paths {
			road_graph <- road_graph load_shortest_paths matrix(file(shortest_paths_file));
		}
	}
	
	reflex compute_shortest_paths {
		source <- point(one_of(road_graph.vertices));
		target <- point(one_of(road_graph.vertices));
		if (source != target) {
			shortest_path <- path_between (road_graph, source,target);
			k_shortest_paths <- list<path>(paths_between(road_graph,source::target,k));	
		}
	}
}

species road  {
	aspect base {
		draw shape color: #black ;
	} 
}

experiment ShortestPath type: gui {
	parameter "number of shortest paths (k)" var: k min: 1 max: 7;
	parameter "Computed all the shortest paths and save the results" var: save_shortest_paths;
	parameter "Load the shortest paths from the file" var: load_shortest_paths;
	
	output {
		display map_shortest_path {
			species road aspect: base;
			graphics "shortest path" {
				if (shortest_path != nil) {
					draw circle(5) at: source color: #green;
					draw circle(5) at: target color: #cyan;
					draw (shortest_path.shape + 2.0) color: #magenta;
				}
			}
		}
		display map_k_shortest_paths {
			species road aspect: base;
			graphics "k shortest paths" {
				if (shortest_path != nil) {
					draw circle(5) at: source color: #green;
					draw circle(5) at: target color: #cyan;
					loop i from: 0 to: length(k_shortest_paths) - 1{
						draw ((k_shortest_paths[i]).shape + 2.0) color: colors[i];
					}
				}
			}
		}
	}
}
```
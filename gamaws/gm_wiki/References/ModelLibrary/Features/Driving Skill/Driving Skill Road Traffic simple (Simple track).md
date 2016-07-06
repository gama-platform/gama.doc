[//]: # (keyword|operator_with_min_of)
<div class='gama-keyword-style' id ='196_0_554_operator-with-min-of'></div>
[//]: # (keyword|operator_select)
<div class='gama-keyword-style' id ='196_1_469_operator-select'></div>
[//]: # (keyword|operator_last)
<div class='gama-keyword-style' id ='196_2_368_operator-last'></div>
[//]: # (keyword|statement_switch)
<div class='gama-keyword-style' id ='196_3_631_statement-switch'></div>
[//]: # (keyword|statement_match)
<div class='gama-keyword-style' id ='196_4_604_statement-match'></div>
[//]: # (keyword|skill_driving)
<div class='gama-keyword-style' id ='196_5_1154_skill-driving'></div>
[//]: # (keyword|type_species)
<div class='gama-keyword-style' id ='196_6_1565_type-species'></div>
[//]: # (keyword|concept_shapefile)
<div class='gama-keyword-style' id ='196_7_99_concept-shapefile'></div>
[//]: # (keyword|concept_graph)
<div class='gama-keyword-style' id ='196_8_47_concept-graph'></div>
[//]: # (keyword|concept_agent_movement)
<div class='gama-keyword-style' id ='196_9_4_concept-agent-movement'></div>
[//]: # (keyword|concept_skill)
<div class='gama-keyword-style' id ='196_10_101_concept-skill'></div>
[//]: # (keyword|concept_transport)
<div class='gama-keyword-style' id ='196_11_123_concept-transport'></div>
# Easy Road Network  ## {#easy-road-network}


_Author : Patrick Taillandier_

Model using shapefiles to create roads using shapefiles with people driving on these roads. The model take into account the number of lanes of the roads.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Driving Skill\Driving Skill Road Traffic simple (Simple track)\city_display-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\Driving Skill\Driving Skill Road Traffic simple (Simple track){.img-responsive}\city_display-10.png)

Code of the model : 

```
  
 
model RoadTrafficSimple 
  
global {  
	file shape_file_roads  <- file("../includes/RoadCircleLanes.shp") ;
	file shape_file_bounds <- file("../includes/BoundsLaneRoad.shp") ;
	geometry shape <- envelope(shape_file_bounds);
	
	graph the_graph;  
	list roadsList of: road ; 
		
	
	init {  
		create road from: shape_file_roads with: [nbLanes::int(read("lanes"))] {
			geom_visu <- shape + nbLanes;
		}
		the_graph <- as_edge_graph(road);
	}   
	
	reflex createPeople when: cycle mod 20 = 0 and cycle < 400{
		roadsList <- (road as list);  
		create people number: 1 { 
			speed <-  (2.0 + 2 * length(people as list)) ;
			currentRoad <- first (roadsList);
			source <- first((currentRoad.shape).points);
			location <- source; 
			target <- last((currentRoad.shape).points);
			living_space <- 10.0;
			tolerance <- 0.1;
			lanes_attribute <- "nbLanes";
			obstacle_species <- [species(self)]; 
		}  
	}   
} 
	
species road  { 
	int nbLanes; 
	geometry geom_visu;
	aspect base {    
		draw geom_visu color: #black ;
	} 
}

species people skills: [driving]{ 
	float speed; 
	rgb color <- rgb(rnd(255),rnd(255),rnd(255)) ; 
	point target <- nil ; 
	point source <- nil;
	road currentRoad <- nil;
	reflex move when: target != nil {
		do goto_driving target: target on: the_graph speed: speed ; 
		switch target { 
			match location {
				currentRoad <- (roadsList select (each != currentRoad)) with_min_of (each distance_to self);
				source <- location;
				list<point> rls <- (currentRoad.shape).points;
				target <- first (rls) = source ? last(rls):first(rls);
			}
		}
	}
		
	aspect base {
		draw circle(10) color: color;
	}
}

experiment Simple type: gui {
	parameter "Shapefile for the roads:" var: shape_file_roads category: "GIS" ;
	parameter "Shapefile for the bounds:" var: shape_file_bounds category: "GIS" ;
	
	output {
		display city_display {
			species road aspect: base ;
			species people aspect: base;
		}
	}
}




```
[//]: # (keyword|operator_osm_file)
<div class='gama-keyword-style' id ='193_0_413_operator-osm-file'></div>
[//]: # (keyword|operator_covers)
<div class='gama-keyword-style' id ='193_1_244_operator-covers'></div>
[//]: # (keyword|operator_get)
<div class='gama-keyword-style' id ='193_2_308_operator-get'></div>
[//]: # (keyword|operator_not)
<div class='gama-keyword-style' id ='193_3_405_operator-not'></div>
[//]: # (keyword|operator_in)
<div class='gama-keyword-style' id ='193_4_328_operator-in'></div>
[//]: # (keyword|operator_last)
<div class='gama-keyword-style' id ='193_5_368_operator-last'></div>
[//]: # (keyword|statement_put)
<div class='gama-keyword-style' id ='193_6_614_statement-put'></div>
[//]: # (keyword|statement_save)
<div class='gama-keyword-style' id ='193_7_622_statement-save'></div>
[//]: # (keyword|concept_load_file)
<div class='gama-keyword-style' id ='193_8_65_concept-load-file'></div>
[//]: # (keyword|concept_gis)
<div class='gama-keyword-style' id ='193_9_45_concept-gis'></div>
[//]: # (keyword|concept_shapefile)
<div class='gama-keyword-style' id ='193_10_99_concept-shapefile'></div>
[//]: # (keyword|concept_save_file)
<div class='gama-keyword-style' id ='193_11_95_concept-save-file'></div>
[//]: # (keyword|concept_osm)
<div class='gama-keyword-style' id ='193_12_82_concept-osm'></div>
# OSM Loading Driving ## {#osm-loading-driving}


_Author : Patrick Taillandier_

Model to show how to import OSM Files, using them to create agents for a road network, and saving the different agents in shapefiles. The first goal of this model is to prepare data for the driving skill models.


Code of the model : 

```


model OSMdata_to_shapefile 
 
global{
	//map used to filter the object to build from the OSM file according to attributes. for an exhaustive list, see: http://wiki.openstreetmap.org/wiki/Map_Features
	map filtering <- map(["highway"::["primary", "secondary", "tertiary", "motorway", "living_street","residential", "unclassified"]]);
	
	//OSM file to load
	file<geometry> osmfile <-  file<geometry>(osm_file("../includes/rouen.gz", filtering))  ;
	
	geometry shape <- envelope(osmfile);
	graph the_graph; 
	map<point, intersection> nodes_map;
	
	

	init {
		write "OSM file loaded: " + length(osmfile) + " geometries";
		
		//from the OSM file, creation of the selected agents
		loop geom over: osmfile {
			if (shape covers geom) {
				string highway_str <- string(geom get ("highway"));
				if (length(geom.points) = 1 ) {
					if ( highway_str != nil ) {
						string crossing <- string(geom get ("crossing"));
						create intersection with: [shape ::geom, type:: highway_str, crossing::crossing] {
							nodes_map[location] <- self;
						}
					}
				} else {
					string oneway <- string(geom get ("oneway"));
					float maxspeed_val <- float(geom get ("maxspeed"));
					string lanes_str <- string(geom get ("lanes"));
					int lanes_val <- empty(lanes_str) ? 1 : ((length(lanes_str) > 1) ? int(first(lanes_str)) : int(lanes_str));
					create road with: [shape ::geom, type:: highway_str, oneway::oneway, maxspeed::maxspeed_val, lanes::lanes_val] {
						if lanes < 1 {lanes <- 1;} //default value for the lanes attribute
						if maxspeed = 0 {maxspeed <- 50.0;} //default value for the maxspeed attribute
					}
				}	
			}
		}
		write "Road and node agents created";
		
		ask road {
			point ptF <- first(shape.points);
			if (not(ptF in nodes_map)) {
				create intersection with:[location::ptF] {
					nodes_map[location] <- self;
				}	
			}
			point ptL <- last(shape.points);
			if (not(ptL in nodes_map)) {
				create intersection with:[location::ptL] {
					nodes_map[location] <- self;
				}
			}
		}
			
		write "Supplementary node agents created";
		ask intersection {
			if (empty (road overlapping (self))) {
				do die;
			}
		}
		
		write "node agents filtered";
		
		//Save all the road agents inside the file with the path written, using the with: facet to make a link between attributes and columns of the resulting shapefiles. 
		save road type:"shp" to:"../includes/roads.shp" with:[lanes::"lanes",maxspeed::"maxspeed", oneway::"oneway"] ;
		save intersection type:"shp" to:"../includes/nodes.shp" with:[type::"type", crossing::"crossing"] ;
		write "road and node shapefile saved";
	}
}
	

species road{
	rgb color <- rgb(rnd(255),rnd(255),rnd(255));
	string type;
	string oneway;
	float maxspeed;
	int lanes;
	aspect base_ligne {
		draw shape color: color; 
	}
	
} 
	
species intersection {
	string type;
	string crossing;
	aspect base { 
		draw square(3) color: #red ;
	}
} 
	

experiment fromOSMtoShapefiles type: gui {
	output {
		display map type: opengl {
			graphics "world" {
				draw world.shape.contour;
			}
			species road aspect: base_ligne  refresh: false  ;
			species intersection aspect: base   refresh: false ;
		}
	}
}
```
[//]: # (keyword|architecture_fsm)
<div class='gama-keyword-style' id ='288_0_1569_architecture-fsm'></div>
[//]: # (keyword|statement_state)
<div class='gama-keyword-style' id ='288_1_629_statement-state'></div>
[//]: # (keyword|statement_transition)
<div class='gama-keyword-style' id ='288_2_636_statement-transition'></div>
[//]: # (keyword|statement_enter)
<div class='gama-keyword-style' id ='288_3_587_statement-enter'></div>
[//]: # (keyword|skill_fsm)
<div class='gama-keyword-style' id ='288_4_1607_skill-fsm'></div>
[//]: # (keyword|constant_#cyan)
<div class='gama-keyword-style' id ='288_5_1189_constant--cyan'></div>
[//]: # (keyword|constant_#magenta)
<div class='gama-keyword-style' id ='288_6_1273_constant--magenta'></div>
[//]: # (keyword|concept_gui)
<div class='gama-keyword-style' id ='288_7_52_concept-gui'></div>
[//]: # (keyword|concept_skill)
<div class='gama-keyword-style' id ='288_8_101_concept-skill'></div>
[//]: # (keyword|concept_grid)
<div class='gama-keyword-style' id ='288_9_51_concept-grid'></div>
# Ant Sorting ## {#ant-sorting}


_Author : _

This model is loosely based on the behavior of ants sorting different elements in their nest. A of mobile agents - the ants - is placed on a grid. The grid itself contains cells of different colors. Each step, the agents move randomly. If they enter a colored cell, they pick this color if its density in the neighbourhood is less than *number_of_objects_around*. If they have picked a color, they drop it on a black cell if they have encountered at least *number_of_objects_in_history* cells with the same color.\n After a while, colors begin to be aggregated.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Ants (Foraging and Sorting)\Ants (Foraging and Sorting) Ant Sorting\OpenGL-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Toy Models\Ants (Foraging and Sorting){.img-responsive}\Ants (Foraging and Sorting) Ant Sorting\OpenGL-10.png)

Code of the model : 

```

model ant_sort

global  {
	// Parameters 
	int number_of_different_colors <- 5 max: 9 ;
	int density_percent <- 30 min: 0 max: 99 ;
	int number_of_objects_in_history <- 3 min: 0 ;
	int number_of_objects_around  <- 5 min: 0 max: 8;
	int width_and_height_of_grid <- 128 max: 400 min: 10 ;  
	int ants <- 20 min: 1 ;
	
	//Action to kill all the ants
	action kill_all {
		ask ant {do die;}
	}
	
	//Action to create all the ants
	action create_all {
		create ant number: ants;
	}

	rgb black <- #black  ;	
	const colors type: list<rgb> <- [#yellow,#red, #orange, #blue, #green,#cyan, #gray,#pink,#magenta] ;
	//Action to write the description of the model
	action description {
		write "\n Description. \n This model is loosely based on the behavior of ants sorting different elements in their nest. \n A of mobile agents - the ants - is placed on a grid. The grid itself contains cells of different colors. Each step, the agents move randomly. If they enter a colored cell, they pick this color if its density in the neighbourhood is less than *number_of_objects_around*. If they have picked a color, they drop it on a black cell if they have encountered at least *number_of_objects_in_history* cells with the same color.\n After a while, colors begin to be aggregated. " ;	
	}  
	init { 
		do description ;
		do create_all;
	} 
}
//Species ant that will move and follow a final state machine
species ant skills: [ moving ] control: fsm { 
	rgb color <- #white ; 
	ant_grid place -> {ant_grid (location)} ;
	
	//Reflex to make the ant wander
	reflex wandering { 
		do wander amplitude: 120;
	}
	//Initial state that will change to full
	state empty initial: true {
		transition to: full when: (place.color != black) and ( (place.neighbors count (each.color = place.color)) < (rnd(number_of_objects_around))) {
			color <- place.color ;
			place.color <- black ; 
		}
	}
	//State full that will change to black if the place color is empty and drop the color inside it
	state full {
		enter { 
			int encountered <- 0; 
		}
		if place.color = color { 
			encountered <- encountered + 1 ;
		}
		transition to: empty when: (place.color = black) and (encountered > number_of_objects_in_history) {
			place.color <- color ;
			color <- black ;
		}
	}
	aspect default {
		draw file("../images/ant_normal.svg") size:5 color: color rotate: heading - 90;
		draw circle(5) empty: true color: color;
	}
}
//Grid that will use the density to determine the color
grid ant_grid width: width_and_height_of_grid height: width_and_height_of_grid neighbors: 8 use_regular_agents: false frequency: 0{
	rgb color <- (rnd(100)) < density_percent ? (colors at rnd(number_of_different_colors - 1)) : #black ;
}


	
experiment sort type: gui{
	parameter "Number of colors:" var: number_of_different_colors category: "Environment" ;
	parameter "Density of colors:" var: density_percent category: "Environment" ;
	parameter "Number of similar colors in memory necessary to put down:" var: number_of_objects_in_history category: "Agents" ;
	parameter "Number of similar colors in perception necessary to pick up:" var: number_of_objects_around category: "Agents" ;
	parameter "Width and height of the grid:" var: width_and_height_of_grid category: "Environment" ;
	parameter "Number of agents:" var: ants category: "Agents" ;
	
	output {
		display OpenGL type: opengl  {
			grid ant_grid ;
			species ant transparency: 0.2 ;
		}
	}
}


```
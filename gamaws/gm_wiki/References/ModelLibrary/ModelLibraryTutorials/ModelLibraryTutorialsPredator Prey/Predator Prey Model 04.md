[//]: # (keyword|concept_inspector)
<div class='gama-keyword-style' id ='257_0_60_concept-inspector'></div>
[//]: # (keyword|concept_monitor)
<div class='gama-keyword-style' id ='257_1_1612_concept-monitor'></div>
# Use of Inspectors/monitors ## {#use-of-inspectorsmonitors}


4th part of the tutorial : Predator Prey


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\Predator Prey\Predator Prey Model 04\main_display-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Tutorials\Predator Prey\Predator Prey Model 04\main_display-10.png){.img-responsive}

Code of the model : 

```

model prey_predator

global {
	int nb_preys_init <- 200 ;
	float prey_max_energy <- 1.0;
	float prey_max_transfert <- 0.1;
	float prey_energy_consum <- 0.05;
	int nb_preys -> {length (prey)};
	
	init {
		create prey number: nb_preys_init ;
	}
}
species prey {
	float size <- 1.0 ;
	rgb color <- #blue;
	float max_energy <- prey_max_energy ;
	float max_transfert <- prey_max_transfert ;
	float energy_consum <- prey_energy_consum ;
		
	vegetation_cell myCell <- one_of (vegetation_cell) ; 
	float energy <- (rnd(1000) / 1000) * max_energy  update: energy - energy_consum max: max_energy ;
		
	init { 
		location <- myCell.location;
	}
		
	reflex basic_move { 
		myCell <- one_of (myCell.neighbours) ;
		location <- myCell.location ;
	}
	reflex eat when: myCell.food > 0 { 
		float energy_transfert <- min([max_transfert, myCell.food]) ;
		myCell.food <- myCell.food - energy_transfert ;
		energy <- energy + energy_transfert ;
	}
	reflex die when: energy <= 0 {
		do die ;
	}

	aspect base {
		draw circle(size) color: color ;
	}
}

grid vegetation_cell width: 50 height: 50 neighbors: 4 {
	float maxFood <- 1.0 ;
	float foodProd <- (rnd(1000) / 1000) * 0.01 ;
	float food <- (rnd(1000) / 1000) max: maxFood update: food + foodProd ;
	rgb color <- rgb(int(255 * (1 - food)), 255, int(255 * (1 - food))) update: rgb(int(255 * (1 - food)), 255, int(255 *(1 - food))) ;
	list<vegetation_cell> neighbours  <- (self neighbors_at 2);
}

experiment prey_predator type: gui {
	parameter "Initial number of preys: " var: nb_preys_init min: 1 max: 1000 category: "Prey" ;
	parameter "Prey max energy: " var: prey_max_energy category: "Prey" ;
	parameter "Prey max transfert: " var: prey_max_transfert  category: "Prey" ;
	parameter "Prey energy consumption: " var: prey_energy_consum  category: "Prey" ;
	output {
		display main_display {
			grid vegetation_cell lines: #black ;
			species prey aspect: base ;
		}
		monitor "Number of preys" value: nb_preys ;
	}
}
```
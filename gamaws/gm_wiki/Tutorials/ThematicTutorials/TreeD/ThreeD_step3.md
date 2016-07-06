# 3. Connections ## {#3-connections}









## Formulation ## {#formulation}
  * Mapping the network of connection

<a href='http://www.youtube.com/watch?feature=player_embedded&v=6ZlBU6xTcfw' target='_blank'><img src='http://img.youtube.com/vi/6ZlBU6xTcfw/0.jpg' width='425' height=344 /></a>





## Model Definition ## {#model-definition}
In this final step we will display edges between cells that are within a given distance.

### Cells update ## {#cells-update}

We add a new reflex to collect the neighbours of the cell that are within a certain distance :

```
species cells skills:[moving3D]{
...
reflex computeNeighbours {
                neighbours <- cells select ((each distance_to self) < 10);
        }  	
}
```

Then we update the cell aspect as follows. For each elements (cells) of the **neighbours** list we draw a line between this neighbour's location and the current cell's location.
```
aspect default {
                draw sphere(1) color:rgb(rnd(255),rnd(255),rnd(255));
                loop pp over: neighbours {
                        draw line([self.location,pp.location]);
                }       
        }
```





## Complete Model ## {#complete-model}

The GIT version of the model can be found here [Model 03.gaml](https://github.com/gama-platform/gama/tree/master/msi.gama.models/models/Tutorials/3D/models/Model 03.gaml)

```
model model3   

global {
	init { 
		create cells number: 1000{ 
			location <- {rnd(100), rnd(100), rnd(100)};	
		} 
	}  
} 
    
species cells skills: [moving] {  
	rgb color;
	list<cells> neighbours;
	int offset;
	
	reflex move {
		do wander_3D;	
	}	
	
	reflex computeNeighbours {
		neighbours <- cells select ((each distance_to self) < 10);
        }
		
	aspect default {
		draw sphere(1) color:#orange;
		loop pp over: neighbours {
			draw line([self.location,pp.location]);
		}	
	}
}

experiment Display  type: gui {
	output {
		display View1 type:opengl background:rgb(10,40,55) {
			species cells;
		}
	}
}
```
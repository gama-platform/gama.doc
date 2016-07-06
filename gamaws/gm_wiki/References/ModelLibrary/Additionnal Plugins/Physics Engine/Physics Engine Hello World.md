[//]: # (keyword|skill_physics)
<div class='gama-keyword-style' id ='122_0_1162_skill-physics'></div>
[//]: # (keyword|concept_physics_engine)
<div class='gama-keyword-style' id ='122_1_1605_concept-physics-engine'></div>
[//]: # (keyword|concept_skill)
<div class='gama-keyword-style' id ='122_2_101_concept-skill'></div>
[//]: # (keyword|concept_spatial_computation)
<div class='gama-keyword-style' id ='122_3_103_concept-spatial-computation'></div>
[//]: # (keyword|concept_3d)
<div class='gama-keyword-style' id ='122_4_1_concept-3d'></div>
# Falling Balls ## {#falling-balls}


_Author : Arnaud Grignard_

This is a model that shows how the physics engine work by displaying two species (a floor and balls). Ball agents use the skill physical3D. The ball agents fall on a floor and fall from the floor to the void. 


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Physics Engine\Physics Engine Hello World\Rain-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Physics Engine\Physics Engine Hello World\Rain-10.png){.img-responsive}

Code of the model : 

```

model FallingHelloWorld



global {
	int environment_size <- 500; 
 
	 
	int number_of_ball parameter: 'Number of ball' min:1 <- 100  category: 'Model'; 
	int ball_radius parameter: 'Ball radius' min:1 <- 25  category: 'Model'; 
	
	file imageRaster <- file('./../images/wood-floor.jpg') ;
	geometry shape <- square(environment_size);
	
	
	//Physic World used to simulate gravity and compute forces
	physic_world world2;
	
	
	init {
		create ball number: number_of_ball{
			location <-  {rnd(environment_size),rnd(environment_size),rnd(environment_size)};
            radius <-float(rnd(ball_radius)+1);
            //Bounds to compute the collision for the ball agents
			collisionBound <-  ["shape"::"sphere","radius"::radius];
			mass <-1.0;
		}
		
		create ground {
			location <- {environment_size/2,environment_size/2,0};
            //Bounds to compute the collision for the floor agent
			collisionBound <-  ["shape"::"floor","x"::environment_size/2, "y":: environment_size/2, "z"::0];
			mass <-0.0;
		}

		create physic_world{
		  world2 <- self;
		  //Add to the agents that will be used to compute the forces.
		  ask world2 {agents <-  (ball as list) + (ground as list);}
		  //Boolean to set gravity 	
		  world2.gravity <- true;
		}
	}
	
	//Reflex to compute the forces at each step
	reflex computeForces  {
	  ask world2 {do compute_forces step: 1;}
	} 			
} 


species physic_world parent: physical_world ;

species ground skills: [physics]{    	
	aspect image{
		draw imageRaster size: environment_size;
	}
}
 
species ball skills: [physics] {  
	rgb color <- rgb (217,229,143); 
	float radius;

	aspect sphere{
		draw sphere(radius) color: color ;
	}	
}
experiment Falling_Hello_world type: gui {
	init{
		minimum_cycle_duration <-0.001;
	}
	
	output {		
		display Rain  type: opengl background:rgb(0,58,64) draw_env:false{
			species ground aspect:image;
		    species ball aspect:sphere;			
		}
	}
}

```
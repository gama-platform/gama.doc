[//]: # (keyword|architecture_user_only)
<div class='gama-keyword-style' id ='239_0_1576_architecture-user-only'></div>
[//]: # (keyword|operator_among)
<div class='gama-keyword-style' id ='239_1_171_operator-among'></div>
[//]: # (keyword|statement_user_panel)
<div class='gama-keyword-style' id ='239_2_641_statement-user-panel'></div>
[//]: # (keyword|statement_transition)
<div class='gama-keyword-style' id ='239_3_636_statement-transition'></div>
[//]: # (keyword|statement_user_command)
<div class='gama-keyword-style' id ='239_4_638_statement-user-command'></div>
[//]: # (keyword|statement_user_input)
<div class='gama-keyword-style' id ='239_5_640_statement-user-input'></div>
[//]: # (keyword|skill_user_only)
<div class='gama-keyword-style' id ='239_6_1611_skill-user-only'></div>
[//]: # (keyword|concept_gui)
<div class='gama-keyword-style' id ='239_7_52_concept-gui'></div>
[//]: # (keyword|concept_architecture)
<div class='gama-keyword-style' id ='239_8_6_concept-architecture'></div>
# User Command ## {#user-command}


_Author : Patrick Taillandier_

Model which shows how to use the advanced user control, to create and kill agents. 


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\User Interaction\User Interaction User Control Architecture\map-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\User Interaction\User Interaction User Control Architecture\map-10.png){.img-responsive}

Code of the model : 

```


model user_control

global {

	int nbAgent <- 10;
	bool advanced_user_control <- false;
	init {
		create cell number: nbAgent {
			color <-°green;
		}
		create user;
	}
}

species cell {
	rgb color;	
	aspect default {
		draw circle(1) color: color;
	}
}

species user control:user_only {
   user_panel "Default" initial: true {
      transition to: "Basic Control" when: every (10) and !advanced_user_control;
      transition to: "Advanced Control" when: every(10) and advanced_user_control;
   }
   
   user_panel "Basic Control" {
      user_command "Kill one cell" {
         ask (one_of(cell)){
            do die;
         }
      }
      user_command "Create one cell" {
        create cell { 
			color <-°green; 
		}
      } 
      transition to: "Default" when: true;                    
   }
   user_panel "Advanced Control" {
      user_command "Kill cells" color: #red continue: true{
        user_input "Number" returns: number type: int <- 10;
        ask (number among list(cell)){
           do die;
        }
      }
      user_command "Create cells" color: #green {
        user_input "Number" returns: number type: int <- 10;
        create cell number: number ;
      } 
      transition to: "Default" when: true;        
   }
}


experiment Displays type: gui {
	parameter "advanced user control" var: advanced_user_control <- false;
	output { 
		display map { 
			species cell;
		}
	}
}
```
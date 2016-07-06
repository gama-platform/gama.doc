[//]: # (keyword|statement_equation)
<div class='gama-keyword-style' id ='318_0_588_statement-equation'></div>
[//]: # (keyword|statement_solve)
<div class='gama-keyword-style' id ='318_1_627_statement-solve'></div>
[//]: # (keyword|constant_#lightgray)
<div class='gama-keyword-style' id ='318_2_1256_constant--lightgray'></div>
[//]: # (keyword|concept_math)
<div class='gama-keyword-style' id ='318_3_69_concept-math'></div>
[//]: # (keyword|concept_equation)
<div class='gama-keyword-style' id ='318_4_38_concept-equation'></div>
# simple_ODE_SIR_Predefined ## {#simple-ode-sir-predefined}


_Author : hqnghi _

A simple example of ODE use into agents with the example of the SIR equation system.


Code of the model : 

```
 
model simple_ODE_SIR_Predefined

global {
	init {
		create predefined_ODE_SIR_agent number: 1;
	}
}

//Species which represent the Ordinary Differential Equations System 
species predefined_ODE_SIR_agent {
	//Variable to represent the discrete time for integration
	float t;
 	//Total Population 
   	int N <- 500;
   	//Number of infected
	float I <- 1.0; 
	//Number of susceptible
	float S <- N - I; 
	//Number of recovered
	float R <- 0.0; 

	//Rate of transmission success for each infected
  	float beta <- 0.4;
  	//Rate of passing to resistant
   	float gamma <- 0.01; 
   		
   	float h <- 0.1;

	// Parameters must follow exact order S, I, R, t  and N,beta,gamma		
	equation eqSIR type:SIR vars: [S,I,R,t] params: [N,beta,gamma] ;

	reflex solving {solve eqSIR method:rk4 step:h cycle_length:int(1/h);}
}


experiment mysimulation type : gui {
	output {	
		display display_charts {
			chart 'SIR_agent' type : series background : #lightgray {
				data "S" value : first(predefined_ODE_SIR_agent).S color : #green;
				data "I" value : first(predefined_ODE_SIR_agent).I color : #red;
				data "R" value : first(predefined_ODE_SIR_agent).R color : #blue;
			}
		}
	}
}
```
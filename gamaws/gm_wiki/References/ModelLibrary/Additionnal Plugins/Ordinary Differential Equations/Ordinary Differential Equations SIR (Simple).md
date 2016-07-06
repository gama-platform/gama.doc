[//]: # (keyword|operator_diff)
<div class='gama-keyword-style' id ='119_0_259_operator-diff'></div>
[//]: # (keyword|statement_equation)
<div class='gama-keyword-style' id ='119_1_588_statement-equation'></div>
[//]: # (keyword|statement_\=)
<div class='gama-keyword-style' id ='119_2_563_statement---'></div>
[//]: # (keyword|statement_solve)
<div class='gama-keyword-style' id ='119_3_627_statement-solve'></div>
[//]: # (keyword|concept_equation)
<div class='gama-keyword-style' id ='119_4_38_concept-equation'></div>
[//]: # (keyword|concept_math)
<div class='gama-keyword-style' id ='119_5_69_concept-math'></div>
# SIR (Simple) ## {#sir-simple}


_Author : hqnghi_

A simple example of ODE use into agents with the example of the SIR equation system.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Ordinary Differential Equations\Ordinary Differential Equations SIR (Simple)\display_charts-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Ordinary Differential Equations\Ordinary Differential Equations SIR (Simple){.img-responsive}\display_charts-10.png)

Code of the model : 

```

model simple_ODE_SIR

global {
	init{
		create agent_with_SIR_dynamic number:1;
	}
}


species agent_with_SIR_dynamic {
	int N <- 1500 ;
	int iInit <- 1;		

    float t;  
	float S <- N - float(iInit); 	      
	float I <- float(iInit); 
	float R <- 0.0; 
	
	float alpha <- 0.2 min: 0.0 max: 1.0;
	float beta <- 0.8 min: 0.0 max: 1.0;

	float h <- 0.01;
   
	equation SIR{ 
		diff(S,t) = (- beta * S * I / N);
		diff(I,t) = (beta * S * I / N) - (alpha * I);
		diff(R,t) = (alpha * I);
	}
                
    reflex solving {
    	solve SIR method: "rk4" step: h cycle_length: 1/h ;
    }    
}


experiment maths type: gui {
	output { 
		display display_charts {
			chart "SIR_agent" type: series background: #white {
				data 'S' value: first(list(agent_with_SIR_dynamic)).S color: #green ;				
				data 'I' value: first(list(agent_with_SIR_dynamic)).I color: #red ;
				data 'R' value: first(list(agent_with_SIR_dynamic)).R color: #blue ;
			}
		}
	}
}
```
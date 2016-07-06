[//]: # (keyword|operator_diff)
<div class='gama-keyword-style' id ='118_0_259_operator-diff'></div>
[//]: # (keyword|statement_equation)
<div class='gama-keyword-style' id ='118_1_588_statement-equation'></div>
[//]: # (keyword|statement_\=)
<div class='gama-keyword-style' id ='118_2_563_statement---'></div>
[//]: # (keyword|statement_solve)
<div class='gama-keyword-style' id ='118_3_627_statement-solve'></div>
[//]: # (keyword|concept_equation)
<div class='gama-keyword-style' id ='118_4_38_concept-equation'></div>
[//]: # (keyword|concept_math)
<div class='gama-keyword-style' id ='118_5_69_concept-math'></div>
# SIR (Influence of Integration Step).gaml ## {#sir-influence-of-integration-stepgaml}


_Author : hqnghi_

A SIR model to illustrate the impact of the change of the integration parameters.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Ordinary Differential Equations\Ordinary Differential Equations SIR (Influence of Integration Step)\SIR_1-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Ordinary Differential Equations\Ordinary Differential Equations SIR (Influence of Integration Step){.img-responsive}\SIR_1-10.png)

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Ordinary Differential Equations\Ordinary Differential Equations SIR (Influence of Integration Step)\SIR_10-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Ordinary Differential Equations\Ordinary Differential Equations SIR (Influence of Integration Step){.img-responsive}\SIR_10-10.png)

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Ordinary Differential Equations\Ordinary Differential Equations SIR (Influence of Integration Step)\SIR_100-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Additionnal Plugins\Ordinary Differential Equations\Ordinary Differential Equations SIR (Influence of Integration Step){.img-responsive}\SIR_100-10.png)

Code of the model : 

```

model SIR_influence_of_integration_step

global { 
	float beta <- 0.8 ; 	
	float delta <- 0.01 ; 
	
	float s1 <- 1.0;
	float s2 <- 10.0;
	float s3 <- 100.0;
	
	init {
		create SIR_agt with: [h::1,mycycle::s1];
		create SIR_agt with: [h::0.1,mycycle::s2];
		create SIR_agt with: [h::0.01,mycycle::s3];	
  	}  
}



species SIR_agt {
	int N <- 500;
    float t;    

	float I <- 1.0; 
	float S <- N - I; 
	float R <- 0.0; 
		
   	float h;
    float mycycle <- 1.0;   		
		
	equation SIR{ 
		diff(S,t) = (- beta * S * I / N);
		diff(I,t) = (beta * S * I / N) - (delta * I);
		diff(R,t) = (delta * I);
	} 

	reflex solving {
		solve SIR method: "rk4" step: h cycle_length:mycycle ;
	}      
}


experiment mysimulation1 type: gui { 
 	output { 
		display SIR_1  {
			chart "SI - h=1" type: series background: #white {
				data 'S' value: first(SIR_agt where (each.mycycle = s1)).S color: #green;				
				data 'I' value: first(SIR_agt where (each.mycycle = s1)).I color: #red ;
				data 'R' value: first(SIR_agt where (each.mycycle = s1)).R color: #blue ;				
			}
		}
		
		display SIR_10 {
			chart "SI - h=0.1" type: series background: #white{
				data 'S' value: first(SIR_agt where (each.mycycle = s2)).S color: #green;				
				data 'I' value: first(SIR_agt where (each.mycycle = s2)).I color: #red ;
				data 'R' value: first(SIR_agt where (each.mycycle = s2)).R color: #blue ;				
			}
		}
		
		display SIR_100  {
			chart "SI - h=0.01" type: series background: #white {
				data 'S' value: first(SIR_agt where (each.mycycle = s3)).S color: #green;				
				data 'I' value: first(SIR_agt where (each.mycycle = s3)).I color: #red ;
				data 'R' value: first(SIR_agt where (each.mycycle = s3)).R color: #blue ;				
			}
		}	
	}
}
```
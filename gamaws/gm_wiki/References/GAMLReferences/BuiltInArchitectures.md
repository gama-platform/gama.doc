# Built-in Architectures ## {#built-in-architectures}
 	
----

**This file is automatically generated from java files. Do Not Edit It.**

----


## INTRODUCTION ## {#introduction}

[Top of the page](references#table-of-contents) 

----

## Table of Contents ## {#table-of-contents}
<wiki:toc max_depth="3" />
	[fsm](references#fsm), [probabilistic_tasks](references#probabilistic_tasks), [reflex](references#reflex), [simple_bdi](references#simple_bdi), [sorted_tasks](references#sorted_tasks), [user_first](references#user_first), [user_last](references#user_last), [user_only](references#user_only), [weighted_tasks](references#weighted_tasks), 

----
[//]: # (keyword|architecture_fsm)
<div class='gama-keyword-style' id ='390_0_1569_architecture-fsm'></div>
## fsm  ## {#fsm}
### Variables ## {#variables}
	   
* **`state`** (string): Returns the current state in which the agent is   
* **`states`** (list): Returns the list of all possible states the agents can be in 
 	
### Actions  ## {#actions}
		

[Top of the page](references#table-of-contents) 
	

----
[//]: # (keyword|architecture_probabilistic_tasks)
<div class='gama-keyword-style' id ='390_1_1570_architecture-probabilistic-tasks'></div>
## probabilistic_tasks  ## {#probabilistic-tasks}
### Variables ## {#variables}
	 
 	
### Actions  ## {#actions}
		

[Top of the page](references#table-of-contents) 
	

----
[//]: # (keyword|architecture_reflex)
<div class='gama-keyword-style' id ='390_2_1571_architecture-reflex'></div>
## reflex  ## {#reflex}
### Variables ## {#variables}
	 
 	
### Actions  ## {#actions}
		

[Top of the page](references#table-of-contents) 
	

----
[//]: # (keyword|architecture_simple_bdi)
<div class='gama-keyword-style' id ='390_3_1572_architecture-simple-bdi'></div>
## simple_bdi  ## {#simple-bdi}
### Variables ## {#variables}
	   
* **`belief_base`** (list):    
* **`charisma`** (float):    
* **`current_plan`** (any type):    
* **`desire_base`** (list):    
* **`emotion_base`** (list):    
* **`intention_base`** (list):    
* **`intention_persistence`** (float): intention persistence   
* **`plan_base`** (list):    
* **`plan_persistence`** (float): plan persistence   
* **`probabilistic_choice`** (boolean):    
* **`receptivity`** (float):    
* **`thinking`** (list):    
* **`uncertainty_base`** (list):    
* **`use_emotions_architecture`** (boolean):  
 	
### Actions  ## {#actions}
	  
	 
#### **`add_belief`** ## {#add-belief}
add the predicate in the belief base.
* returns: bool 			
* **`predicate`** (map): predicate to add as a belief  
	 
#### **`add_desire`** ## {#add-desire}
adds the predicates is in the desire base.
* returns: bool 			
* **`predicate`** (546704): predicate to add 			
* **`todo`** (546704): add the desire as a subintention of this parameter  
	 
#### **`add_emotion`** ## {#add-emotion}
add the emotion to the emotion base.
* returns: bool 			
* **`emotion`** (546706): emotion to add to the base  
	 
#### **`add_intention`** ## {#add-intention}
check if the predicates is in the desire base.
* returns: bool 			
* **`predicate`** (map): predicate to check  
	 
#### **`add_subintention`** ## {#add-subintention}
adds the predicates is in the desire base.
* returns: bool 			
* **`predicate`** (546704): predicate name 			
* **`subintentions`** (546704): the subintention to add to the predicate 			
* **`add_as_desire`** (boolean): add the subintention as a desire as well (by default, false)  
	 
#### **`add_uncertainty`** ## {#add-uncertainty}
add a predicate in the uncertainty base.
* returns: bool 			
* **`predicate`** (map): predicate to check  
	 
#### **`clear_beliefs`** ## {#clear-beliefs}
clear the belief base
* returns: bool  
	 
#### **`clear_desires`** ## {#clear-desires}
clear the desire base
* returns: bool  
	 
#### **`clear_intentions`** ## {#clear-intentions}
clear the intention base
* returns: bool  
	 
#### **`current_intention_on_hold`** ## {#current-intention-on-hold}
puts the current intention on hold until the specified condition is reached or all subintentions are reached (not in desire base anymore).
* returns: bool 			
* **`until`** (any type): the current intention is put on hold (fited plan are not considered) until specific condition is reached. Can be an expression (which will be tested), a list (of subintentions), or nil (by default the condition will be the current list of subintentions of the intention)  
	 
#### **`get_belief`** ## {#get-belief}
get the predicate in the belief base (if several, returns the first one).
* returns: predicate 			
* **`predicate`** (546704): predicate to get  
	 
#### **`get_belief_with_name`** ## {#get-belief-with-name}
get the predicates is in the belief base (if several, returns the first one).
* returns: predicate 			
* **`name`** (string): name of the predicate to check  
	 
#### **`get_beliefs`** ## {#get-beliefs}
get the list of predicates is in the belief base
* returns: msi.gama.util.IList<msi.gaml.architecture.simplebdi.Predicate> 			
* **`predicate`** (546704): name of the predicates to check  
	 
#### **`get_beliefs_with_name`** ## {#get-beliefs-with-name}
get the list of predicates is in the belief base with the given name.
* returns: java.util.List<msi.gaml.architecture.simplebdi.Predicate> 			
* **`name`** (string): name of the predicates to check  
	 
#### **`get_current_intention`** ## {#get-current-intention}
returns the current intention (last entry of intention base).
* returns: predicate  
	 
#### **`get_desire`** ## {#get-desire}
get the predicates is in the desire base (if several, returns the first one).
* returns: predicate 			
* **`predicate`** (546704): predicate to check  
	 
#### **`get_desire_with_name`** ## {#get-desire-with-name}
get the predicates is in the belief base (if several, returns the first one).
* returns: predicate 			
* **`name`** (string): name of the predicate to check  
	 
#### **`get_desires`** ## {#get-desires}
get the list of predicates is in the belief base
* returns: msi.gama.util.IList<msi.gaml.architecture.simplebdi.Predicate> 			
* **`predicate`** (546704): name of the predicates to check  
	 
#### **`get_desires_with_name`** ## {#get-desires-with-name}
get the list of predicates is in the belief base with the given name.
* returns: java.util.List<msi.gaml.architecture.simplebdi.Predicate> 			
* **`name`** (string): name of the predicates to check  
	 
#### **`get_emotion`** ## {#get-emotion}
get the emotion in the emotion base (if several, returns the first one).
* returns: emotion 			
* **`emotion`** (546706): emotion to get  
	 
#### **`get_intention`** ## {#get-intention}
get the predicates is in the belief base (if several, returns the first one).
* returns: predicate 			
* **`predicate`** (546704): predicate to check  
	 
#### **`get_intention_with_name`** ## {#get-intention-with-name}
get the predicates is in the belief base (if several, returns the first one).
* returns: predicate 			
* **`name`** (string): name of the predicate to check  
	 
#### **`get_intentions`** ## {#get-intentions}
get the list of predicates is in the belief base
* returns: msi.gama.util.IList<msi.gaml.architecture.simplebdi.Predicate> 			
* **`predicate`** (546704): name of the predicates to check  
	 
#### **`get_intentions_with_name`** ## {#get-intentions-with-name}
get the list of predicates is in the belief base with the given name.
* returns: java.util.List<msi.gaml.architecture.simplebdi.Predicate> 			
* **`name`** (string): name of the predicates to check  
	 
#### **`get_plans`** ## {#get-plans}
get the list of plans.
* returns: java.util.List<msi.gaml.architecture.simplebdi.BDIPlan>  
	 
#### **`get_uncertainty`** ## {#get-uncertainty}
get the predicates is in the uncertainty base (if several, returns the first one).
* returns: predicate 			
* **`predicate`** (546704): predicate to check  
	 
#### **`has_belief`** ## {#has-belief}
check if the predicates is in the belief base.
* returns: bool 			
* **`predicate`** (546704): predicate to check  
	 
#### **`has_desire`** ## {#has-desire}
check if the predicates is in the desire base.
* returns: bool 			
* **`predicate`** (546704): predicate to check  
	 
#### **`has_emotion`** ## {#has-emotion}
check if the emotion is in the belief base.
* returns: bool 			
* **`emotion`** (546706): emotion to check  
	 
#### **`has_uncertainty`** ## {#has-uncertainty}
check if the predicates is in the uncertainty base.
* returns: bool 			
* **`predicate`** (546704): predicate to check  
	 
#### **`is_current_intention`** ## {#is-current-intention}
check if the predicates is the current intention (last entry of intention base).
* returns: bool 			
* **`predicate`** (546704): predicate to check  
	 
#### **`remove_all_beliefs`** ## {#remove-all-beliefs}
removes the predicates from the belief base.
* returns: bool 			
* **`predicate`** (546704): predicate to remove  
	 
#### **`remove_belief`** ## {#remove-belief}
removes the predicate from the belief base.
* returns: bool 			
* **`predicate`** (546704): predicate to remove  
	 
#### **`remove_desire`** ## {#remove-desire}
removes the predicates from the desire base.
* returns: bool 			
* **`predicate`** (546704): predicate to add  
	 
#### **`remove_emotion`** ## {#remove-emotion}
removes the emotion from the emotion base.
* returns: bool 			
* **`emotion`** (546706): emotion to remove  
	 
#### **`remove_intention`** ## {#remove-intention}
removes the predicates from the desire base.
* returns: bool 			
* **`predicate`** (546704): predicate to add 			
* **`desire_also`** (boolean): removes also desire  
	 
#### **`remove_uncertainty`** ## {#remove-uncertainty}
removes the predicates from the desire base.
* returns: bool 			
* **`predicate`** (546704): predicate to add  
	 
#### **`replace_belief`** ## {#replace-belief}
replace the old predicate by the new one.
* returns: bool 			
* **`old_predicate`** (546704): predicate to remove 			
* **`predicate`** (546704): predicate to add	

[Top of the page](references#table-of-contents) 
	

----
[//]: # (keyword|architecture_sorted_tasks)
<div class='gama-keyword-style' id ='390_4_1573_architecture-sorted-tasks'></div>
## sorted_tasks  ## {#sorted-tasks}
### Variables ## {#variables}
	 
 	
### Actions  ## {#actions}
		

[Top of the page](references#table-of-contents) 
	

----
[//]: # (keyword|architecture_user_first)
<div class='gama-keyword-style' id ='390_5_1574_architecture-user-first'></div>
## user_first  ## {#user-first}
### Variables ## {#variables}
	 
 	
### Actions  ## {#actions}
		

[Top of the page](references#table-of-contents) 
	

----
[//]: # (keyword|architecture_user_last)
<div class='gama-keyword-style' id ='390_6_1575_architecture-user-last'></div>
## user_last  ## {#user-last}
### Variables ## {#variables}
	 
 	
### Actions  ## {#actions}
		

[Top of the page](references#table-of-contents) 
	

----
[//]: # (keyword|architecture_user_only)
<div class='gama-keyword-style' id ='390_7_1576_architecture-user-only'></div>
## user_only  ## {#user-only}
### Variables ## {#variables}
	 
 	
### Actions  ## {#actions}
		

[Top of the page](references#table-of-contents) 
	

----
[//]: # (keyword|architecture_weighted_tasks)
<div class='gama-keyword-style' id ='390_8_1577_architecture-weighted-tasks'></div>
## weighted_tasks  ## {#weighted-tasks}
### Variables ## {#variables}
	 
 	
### Actions  ## {#actions}
		

[Top of the page](references#table-of-contents) 
	
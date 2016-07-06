[//]: # (startConcept|interaction_between_agents)
<section class='concept-graph' markdown='1' id ='concept_18_0_6_interaction-between-agents'>
# Interaction between agents ## {#interaction-between-agents}

In this part, we will learn how interaction between agents works. We will also present you a bunch of operators useful for your modelling. 

## Index ## {#index}

* [The ask statement](tutorials#the-ask-statement)
* [Pseudo variables](tutorials#pseudo-variables)
* [Some useful interaction operators](tutorials#some-useful-interaction-operators)
* [Example](tutorials#example)

## The ask statement ## {#the-ask-statement}

[//]: # (keyword|statement_ask)
<div class='gama-keyword-style' id ='18_0_568_statement-ask'></div>
The `ask` statement can be used in any reflex or action scope. It is used to specify the interaction between the instances of your species and the other agents. You only have to specify the species of the agents you want to interact with. Here are the different ways of calling the ask statement:

-	If you want to interact with one particular agent (for example, defined as an attribute of your species):

```
species my_species {
	agent target;
	reflex update {
		ask target {
			// statements
		}
	}
}
```

-	If you want to interact with a group of agents:

```
species my_species {
	list<agent> targets;
	reflex update {
		ask targets {
			// statements
		}
	}
}
```

-	If you want to interact with agents, as if they were instance of a certain species (can raise an error if it's not the case!):

```
species my_species {
	list<agent> targets;
	reflex update {
		ask targets as:my_species {
			// statements
		}
	}
}
```

-	If you want to interact with all the agent of a species:

```
species my_species {
	list<agent> targets;
	reflex update {
		ask other_species {
			// statements
		}
	}
}

species other_species {
}
```

Note that you can use the attribute _population_ of `species` if you find it more explicit:

```
ask other_species.population
```

-	If you want to interact with all the agent of a particular species from a list of agents (for example, using the global variable "agents"):

```
species my_specie {
	reflex update {
		ask species of_species my_specie {
			// statements
		}
	}
}
```

## Pseudo variables ## {#pseudo-variables}

[//]: # (keyword|concept_pseudo_variable)
<div class='gama-keyword-style' id ='18_1_1593_concept-pseudo-variable'></div>
Once you are in the ask scope, you can use some pseudo variables to refer to the receiver agent (the one specify just after the ask statement) or the transmitter agent (the agent which is asking). 
We use the pseudo variable `self` to refer to the receiver agent, and the pseudo variable `myself` to refer to the transmitter agent. The pseudo variable `self` can be omitted when calling actions or attributes.

```
species speciesA {
	init {
		name <- "speciesA";
	}
	reflex update {
		ask speciesB {
write name; // output : "speciesB"			
write self.name; // output : "speciesB"
			write myself.name; // output : "speciesA"
		}
	}
}

species speciesB {
	init {
		name <- "speciesB";
	}
}
```

Now, if we introduce a third species, we can write an `ask` statement inside another. 

```
species speciesA {
	init {
		name <- "speciesA";
	}
	reflex update {
		ask speciesB {
			write self.name; // output : "speciesB"
			write myself.name; // output : "speciesA"
			ask speciesC {
				write self.name; // output : "speciesC"
				write myself.name; // output : "speciesB"
			}
		}
	}
}

species speciesB {
	init {
		name <- "speciesB";
	}
}

species speciesC {
	init {
		name <- "speciesC";
	}
}
```

Nb: try to avoid multiple imbrications of ask statements. Most of the time, there is another way to do the same thing.

## Some useful interaction operators ## {#some-useful-interaction-operators}

[//]: # (keyword|operator_at_distance)
<div class='gama-keyword-style' id ='18_2_200_operator-at-distance'></div>
The operator `at_distance` can be used to know the list of agents that are in a certain distance from another agent.

```
species my_species {
	reflex update {
		list<agent> neighbours <- agents at_distance(5);
		// neighbours contains the list of all the agents located at a distance <= 5 from the caller agent.
	}
}
```

[//]: # (keyword|operator_closest_to)
<div class='gama-keyword-style' id ='18_3_222_operator-closest-to'></div>
The operator `closest_to` returns the closest agent of a position among a container.

```
species my_species {
	reflex update {
		agent agentA <- agents closest_to(self);
		// agentA contains the closest agent from the caller agent.
		agent agentB <- other_specie closest_to({2,3});
		// agentB contains the closest instance of other_specie from the location {2,3}.
	}
}

species other_specie {
}
```

## Example ## {#example}

[//]: # (keyword|operator_polyline)
<div class='gama-keyword-style' id ='18_4_433_operator-polyline'></div>
To practice those notions, here is a short basic example. Let's build a model with a fix number of agents with a circle shape. They can move randomly on the environment, and when they are close enough from another agent, a line is displayed between them. This line is destroyed when the distance between the two agents is too important.
Hint: use the operator `polyline` to construct a line. List the points between angle brackets `[]`.

![images/connect_the_neighbours.png](gm_wiki/resources/images/manipulateBasicSpecies/connect_the_neighbours.png){.img-responsive} 

Here is one example of implementation:

```
model connect_the_neighbours

global{
	float speed <- 0.2;
	float distance_to_intercept <- 10.0;
	int number_of_circle <- 100;
	init {
		create my_species number:number_of_circle;
	}
}

species my_species {
	reflex move {
		location <- {location.x+rnd(-speed,speed),location.y+rnd(-speed,speed)};
	}
	aspect default {
		draw circle(1);
		ask my_species at_distance(distance_to_intercept) {
			draw polyline([self.location,myself.location]) color:#black;
		}
	}
}

experiment my_experiment type:gui
{
	output{
		display myDisplay {
			species my_species aspect:default;
		}
	}
}
```
[//]: # (endConcept|interaction_between_agents)
</section>
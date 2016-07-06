[//]: # (startConcept|monitors_and_inspectors)
<section class='concept-graph' markdown='1' id ='concept_31_0_21_monitors-and-inspectors'>
# Defining monitors and inspectors ## {#defining-monitors-and-inspectors}

Other outputs can be very useful to study better the behavior of your agents.

## Index ## {#index}

* [Define a monitor](tutorials#define-a-monitor)
* [Define an inspector](tutorials#define-an-inspector)

[//]: # (keyword|concept_monitor)
<div class='gama-keyword-style' id ='31_0_1612_concept-monitor'></div>
## Define a monitor ## {#define-a-monitor}

[//]: # (keyword|statement_monitor)
<div class='gama-keyword-style' id ='31_1_606_statement-monitor'></div>
A [monitor](references#InspectorsAndMonitors#monitor){.internal-link-anchor} allows to follow the value of an arbitrary expression in GAML. It will appear, in the User Interface, in a small window on its own and be recomputed every time step (or according to its refresh facet). 

Definition of a monitor: 

```
monitor monitor_name value: an_expression refresh:boolean_statement;
```

with:
* `value:` mandatory, the expression whose value will be displayed by the monitor.
* `refresh:` bool statement, optional : the new value is computed if the bool statement returns true.

Example:

```
experiment my_experiment type: gui {
	output {
		monitor monitor_name value: cycle refresh:every(1);
	}
}
```

NB : you can also declare monitors during the simulation, by clicking on the button "Add new monitor", and specifying the name of the variable you want to follow.

[//]: # (keyword|concept_inspector)
<div class='gama-keyword-style' id ='31_2_60_concept-inspector'></div>
## Define an inspector ## {#define-an-inspector}

[//]: # (keyword|statement_inspector)
<div class='gama-keyword-style' id ='31_3_1677_statement-inspector'></div>
During the simulation, the user interface of GAMA provides the user the possibility to [inspect an agent](references#InspectorsAndMonitors), or a group of agents. But you can also define the inspector you want directly from your model, as an output of the experiment.

Use the statement `inspect` to define your inspector, in the output scope of your gui experiment. The inspector has to be named (using the facet `name`), a value has to be specified (with the `value` facet).

```
inspect name:"inspector_name" value:the_value_you_want_to_display;
```

Note that you can inspect any type of species (regular species, grid species, even the world...).

The optional facet `type` is used to specify the type of your inspector. 2 values are possible : 
* _agent_ (default value) if you want to display the information as a regular [agent inspector](references#InspectorsAndMonitors#agent-inspector){.internal-link-anchor}. Note that if you want to inspect a large number of agents, this can take a lot of time. In this case, prefer the other type _table_
* _table_ if you want to display the information as an [agent browser](references#InspectorsAndMonitors#agent-browser){.internal-link-anchor}

The optional facet `attribute` is used to filter the attributes you want to be displayed in your inspector.

**Beware** : only one agent inspector (`type:agent`) can be used for an experiment. Beside, you can add as many agent browser (`type:table`) as you want for your experiment.

Example of implementation :

```
model new

global {
	init {
		create my_species number:3;
	}
}

species my_species {
	int int_attr <- 6;
	string str_attr <- "my_value";
	string str_attr_not_important <- "blabla";
}

grid my_grid_species width: 10 height: 10 {
	int rnd_value <- rnd(5);
}

experiment my_experiment type:gui {
	output {
		inspect name:"my_species_inspector" value:my_species attributes:["int_attr","str_attr"];
		inspect name:"my_species_browser" value:my_species type:table;
		inspect name:"my_grid_species_browser" value:5 among my_grid_species type:table;
	}
}
```

Another statement, `browse`, is doing a similar thing, but preferring the _table_ type (if you want to browse an agent species, the default type will be the _table_ type).
[//]: # (endConcept|monitors_and_inspectors)
</section>
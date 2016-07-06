
# The Graphical Editor ## {#the-graphical-editor}


The graphical editor that allow to build diagram (gadl files) is based on the [Graphiti](http://www.eclipse.org/graphiti/) Eclipse plugin. It allows to define a GAMA model through a graphical interface. It a allows as well to produce a graphical model (diagram) from a gaml model.

![images/graphical_editor/gm_predator_prey.png](gm_wiki/resources/images/graphical_editor/gm_predator_prey.png){.img-responsive}

## Table of contents  ## {#table-of-contents}

* [The Graphical Editor](references#the-graphical-editor)
	* [Installing the graphical editor](references#installing-the-graphical-editor)
	* [Creating a first model](references#creating-a-first-model)
	* [Status of models in editors](references#status-of-models-in-editors)
	* [Diagram definition framework](references#diagram-definition-framework)
	* [Features](references#features)
		* [agents](references#agents)
			* [species](references#species)
			* [grid](references#grid)
			* [Inheriting link](references#inheriting-link)
			* [world](references#world)
		* [agent features](references#agent-features)
			* [action](references#action)
			* [reflex](references#reflex)
			* [aspect](references#aspect)
		* [experiment](references#experiment)
			* [GUI experiment](references#gui-experiment)
			* [display](references#display)
			* [batch experiment](references#batch-experiment)
	* [Pictogram color modification](references#pictogram-color-modification)
	* [GAML Model generation](references#gaml-model-generation)


## Installing the graphical editor ## {#installing-the-graphical-editor}
Using the graphical editor requires to install the graphical modeling plug-in. See [here](G__InstallingPlugins) for information about plug-ins and their installation.

The graphical editor plug-in is called **Graphical\_modeling** and is directly available from GAMA update site **https://gama-platform.googlecode.com/svn/update_site/*.**


![install](gm_wiki/resources/images/graphical_editor/installing_graphical_editor.JPG){.img-responsive}


Note that the graphical editor is still under development. Updates of the plug-in will be add to the GAMA website. After installing the plug-in (and periodically), check for updates for this plug-in: in the "Help" menu, choose "Check for Updates" and install the proposed updates for the graphical modeling plug-in.




## Creating a first model ## {#creating-a-first-model}

A new diagram can be created in a new GAMA project. First, right click on a project, then select "New" on the contextual menu.
In the New Wizard, select "GAMA -> Model Diagram", then "Next>"
![images/graphical_editor/newDiagram.png](gm_wiki/resources/images/graphical_editor/newDiagram.png){.img-responsive}

In the next Wizard dialog, select the type of diagram (Empty, Skeleton or Example) then the name of the file and the author.

![images/graphical_editor/modeldiagramNew.png](gm_wiki/resources/images/graphical_editor/modeldiagramNew.png){.img-responsive} 

Skeleton and Example diagram types allow to add to the diagram some basic features.





## Status of models in editors ## {#status-of-models-in-editors}

Similarly to GAML editor, the graphical editor proposes a live display of errors and model statuses. A graphical model can actually be in three different states, which are visually accessible above the editing area: **Functional** (orange color), **Experimentable** (green color) and **InError** (red color). See [the section on model compilation](CompilingModels161) for more precise information about these statuses.

In its initial state, a model is always in the **Functional** state, which means it compiles without problems, but cannot be used to launch experiments. The **InError** state occurs when the file contains errors (syntactic or semantic ones).

Reaching the **Experimentable** state requires that all errors are eliminated and that at least one experiment is defined in the model. The experiment is immediately displayed as a button in the toolbar, and clicking on it will allow to launch this experiment on your model.

Experiment buttons are updated in real-time to reflect what's in your code. If more than one experiment is defined, corresponding buttons will be displayed in addition to the first one.





## Diagram definition framework ## {#diagram-definition-framework}

The following figure presents the editing framework:
![images/graphical_editor/framework.png](gm_wiki/resources/images/graphical_editor/framework.png){.img-responsive}





## Features ## {#features}

### agents ## {#agents}
#### species ## {#species}

![images/graphical_editor/species.png](gm_wiki/resources/images/graphical_editor/species.png){.img-responsive}

The species feature allows to define a species with a continuous topology. A species is always a micro-species of another species. The top level (macro-species of all species) is the world species.

  * **source**: a species (macro-species)
  * **target**: -
![images/graphical_editor/Frame_Speciesdef1.png](gm_wiki/resources/images/graphical_editor/Frame_Speciesdef1.png){.img-responsive}

![images/graphical_editor/Frame_Speciesdef2.png](gm_wiki/resources/images/graphical_editor/Frame_Speciesdef2.png){.img-responsive}

#### grid ## {#grid}

![images/graphical_editor/grid.png](gm_wiki/resources/images/graphical_editor/grid.png){.img-responsive}

The grid feature allows to define a [species](Species151) with a [grid topology](Sections151#environment){.internal-link-anchor}. A grid is always a micro-species of another species.

  * **source**: a species (macro-species)
  * **target**: -

![images/graphical_editor/Frame_grid.png](gm_wiki/resources/images/graphical_editor/Frame_grid.png){.img-responsive}

#### Inheriting link ## {#inheriting-link}
The inheriting link feature allows to define an inheriting link between two species.

  * **source**: a species (parent)
  * **target**: a species (child)

![images/graphical_editor/inhereting_link.png](gm_wiki/resources/images/graphical_editor/inhereting_link.png){.img-responsive}


#### world ## {#world}

![images/graphical_editor/world.png](gm_wiki/resources/images/graphical_editor/world.png){.img-responsive}

When a model is created, a world species is always defined. It represent the global part of the model. The world species, which is unique, is the top level species. All other species are micro-species of the world species.

![images/graphical_editor/Frame_world.png](gm_wiki/resources/images/graphical_editor/Frame_world.png){.img-responsive}

### agent features ## {#agent-features}

#### action ## {#action}
![images/graphical_editor/action.png](gm_wiki/resources/images/graphical_editor/action.png){.img-responsive}

The action feature allows to define an action for a species.

  * **source**: a species (owner of the action)
  * **target**: -

![images/graphical_editor/Frame_action.png](gm_wiki/resources/images/graphical_editor/Frame_action.png){.img-responsive}

#### reflex ## {#reflex}
![images/graphical_editor/reflex.png](gm_wiki/resources/images/graphical_editor/reflex.png){.img-responsive}

The reflex feature allows to define a reflex for a species.

  * **source**: a species (owner of the reflex)
  * **target**: -

![images/graphical_editor/Frame_reflex.png](gm_wiki/resources/images/graphical_editor/Frame_reflex.png){.img-responsive}

#### aspect ## {#aspect}
![images/graphical_editor/aspect.png](gm_wiki/resources/images/graphical_editor/aspect.png){.img-responsive}

The aspect feature allows to define an aspect for a species.

  * **source**: a species (owner of the aspect)
  * **target**: -

![images/graphical_editor/Frame_aspect.png](gm_wiki/resources/images/graphical_editor/Frame_aspect.png){.img-responsive}


![images/graphical_editor/Frame_Aspect_layer.png](gm_wiki/resources/images/graphical_editor/Frame_Aspect_layer.png){.img-responsive}
### experiment ## {#experiment}
#### GUI experiment ## {#gui-experiment}

![images/graphical_editor/guiXP.png](gm_wiki/resources/images/graphical_editor/guiXP.png){.img-responsive}

The GUI Experiment feature allows to define a GUI experiment.

  * **source**: world species
  * **target**: -

![images/graphical_editor/Frame_Experiment.png](gm_wiki/resources/images/graphical_editor/Frame_Experiment.png){.img-responsive}

#### display ## {#display}

![images/graphical_editor/display.png](gm_wiki/resources/images/graphical_editor/display.png){.img-responsive}

The display feature allows to define a display.

  * **source**: GUI experiment
  * **target**: -

![images/graphical_editor/Frame_display.png](gm_wiki/resources/images/graphical_editor/Frame_display.png){.img-responsive}


![images/graphical_editor/Frame_layer_display.png](gm_wiki/resources/images/graphical_editor/Frame_layer_display.png){.img-responsive}

#### batch experiment ## {#batch-experiment}

![images/graphical_editor/batchxp.png](gm_wiki/resources/images/graphical_editor/batchxp.png){.img-responsive}

The Batch Experiment feature allows to define a Batch experiment.

  * **source**: world species
  * **target**: -





## Pictogram color modification ## {#pictogram-color-modification}
It is possible to change the color of a pictogram.
  * Right click on a pictogram, then select the "Chance the color".





## GAML Model generation ## {#gaml-model-generation}
It is possible to automatically generate a Gaml model from a diagram.
  * Right click on the graphical framework (where the diagram is defined), then select the "Generate Gaml model".
A new GAML model with the same name as the diagram is created (and open).
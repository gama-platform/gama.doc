[//]: # (keyword|operator_not)
<div class='gama-keyword-style' id ='236_0_405_operator-not'></div>
[//]: # (keyword|statement_event)
<div class='gama-keyword-style' id ='236_1_590_statement-event'></div>
[//]: # (keyword|concept_gui)
<div class='gama-keyword-style' id ='236_2_52_concept-gui'></div>
# Event Feature ## {#event-feature}


_Author : Arnaud Grignard & Patrick Taillandier_

Model which shows how to use the event layer to trigger an action according to an event occuring in the display. The experiment has two displays : one for the changing color event, one for the changing shape event.


![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\User Interaction\User Interaction Event Layer\View_change_color-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\User Interaction\User Interaction Event Layer\View_change_color-10.png){.img-responsive}

![F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\User Interaction\User Interaction Event Layer\View_change_shape-10.png](F:\Gama\GamaWiki\resources\images\modelLibraryScreenshots\Features\User Interaction\User Interaction Event Layer\View_change_shape-10.png){.img-responsive}

Code of the model : 

```
model event_layer_model


global
{

//number of agents to create
	int nbAgent <- 500;
	init
	{

	//creation of the agents
		create cell number: nbAgent
		{
			color <- °green;
		}

	}

	//Action to change the color of the agents, according to the point to know which agents we're in intersection with the point
	action change_color (point loc, list<cell> selected_agents)
	{

	//change the color of the agents
		ask selected_agents
		{
			color <- color = °green ? °pink : °green;
		}

	}

	//Action to change the shape of the agents, according to the point to know which agents we're in intersection with the point
	action change_shape (point loc, list<cell> selected_agents)
	{
		ask selected_agents
		{

		//change the bool attribute is_square to change the shape in the display
			is_square <- not (is_square);
		}

	}

}

//Species cells moving randomly
species cell skills: [moving]
{
	rgb color;
	bool is_square <- false;
	reflex mm
	{
		do wander amplitude: 30;
	}

	aspect default
	{
		draw is_square ? square(2) : circle(1) color: color;
	}

}

experiment Displays type: gui
{
	output
	{
		display View_change_color
		{
			species cell aspect: default;

			//event, launches the action change_color if the event mouse_down (ie. the user clicks on the layer event) is triggered
			event [mouse_down] action: change_color;
		}

		display View_change_shape type: opengl
		{
			species cell;

			//event, launches the action change_shape if the event mouse_down (ie. the user clicks on the layer event) is triggered
			event [mouse_down] action: change_shape;
		}

	}

}

```
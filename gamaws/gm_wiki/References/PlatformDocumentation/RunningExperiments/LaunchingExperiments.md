
# Launching Experiments from the User Interface ## {#launching-experiments-from-the-user-interface}



GAMA supports multiple ways of launching experiments from within the Modeling Perspective, in editors or in the [navigator](references#NavigatingWorkspace).


## Table of contents  ## {#table-of-contents}

* [Launching Experiments from the User Interface](references#launching-experiments-from-the-user-interface)
	* [From an Editor](references#from-an-editor)
	* [From the Navigator](references#from-the-navigator)
	* [Running Experiments Automatically](references#running-experiments-automatically)
	* [Running Several Simulations](references#running-several-simulations)



## From an Editor ## {#from-an-editor}
As already mentioned on [this page](references#GamlEditorGeneralities), GAML editors will provide the easiest way to launch experiments. Whenever a model that contains the definition of experiments is validated, these experiments will appear as distinct buttons, in the order in which they are defined in the file, in the header ribbon above the text. Simply clicking one of these buttons launches the corresponding experiment.

![images/editor_launch.png](gm_wiki/resources/images/runningExperiments/editor_launch.png){.img-responsive}

For each of those launching buttons, you can see 2 different pictograms, showing the type of experiment. An experiment can either be a [GUI Experiment](tutorials#DefiningGUIExperiment) or a [Batch Experiment](tutorials#BatchExperiments).

![images/editor_different_types_of_experiment.png](gm_wiki/resources/images/runningExperiments/editor_different_types_of_experiment.png){.img-responsive}


## From the Navigator ## {#from-the-navigator}
You can also launch your experiments from the navigator, by expanding a model and double clicking on one of the experiments available (The number of experiments for each model is visible also in the navigator). As for the editor, the two types of experimentations (gui and batch) are differentiated by a pictogram.

![images/navigator_launch.png](gm_wiki/resources/images/runningExperiments/navigator_launch.png){.img-responsive}


## Running Experiments Automatically ## {#running-experiments-automatically}
Once an experiment has been launched (unless it is run in [headless](references#Headless) mode, of course), it normally displays its views and waits from an input from the user, usually a click on the "Run" or "Step" buttons (see [here](references#MenusAndCommands)).

It is however possible to make experiments run directly once launched, without requiring any intervention from the user.  To install this feature, [open the preferences of GAMA](references#Preferences). On the first tab, simply check "Auto-run experiments when they are launched" (which is unchecked by default) and hit "OK" to dismiss the dialog. Next time you'll launch an experiment, it will run automatically (this option also applies to experiments launched from the command line).

![images/prefs_auto_run.png](gm_wiki/resources/images/runningExperiments/prefs_auto_run.png){.img-responsive}

## Running Several Simulations ## {#running-several-simulations}

It is possible in GAMA to run several simulations. Each simulation will be launched with the same seed (which means that if the parameters are the same, then the result will be exactly the same). All those simulations are synchronized in the same cycle.

To run several experiments, you have to [write it directly in your model](LaunchSeveralSimulations).

![images/run_several_simulations.png](gm_wiki/resources/images/runningExperiments/run_several_simulations.png){.img-responsive}
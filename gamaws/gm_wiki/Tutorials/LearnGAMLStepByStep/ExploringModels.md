[//]: # (keyword|concept_experiment)
<div class='gama-keyword-style' id ='34_0_39_concept-experiment'></div>
[//]: # (keyword|concept_batch)
<div class='gama-keyword-style' id ='34_1_12_concept-batch'></div>
# Exploring Models ## {#exploring-models}

We just learnt how to launch GUI Experiments from GAMA. A GUI Experiment will start with a particular set of input, compute several outputs, and will stop at the end (if asked).

In order to explore models (by automatically running the Experiment using several configurations to analyze the outputs), a first approach is to run several simulations from the same experiment, considering each simulation as an agent. A second approach, much more efficient for larger explorations, is to run an other type of experiment : the **Batch Experiment**.

We will start this part by learning how to [**run several simulations**](tutorials#RunSeveralSimulations) from the same experiment. Then, we will see how [**batch experiments**](tutorials#BatchExperiments) work, and we will focus on how to use those batch experiments to explore models by using [**exploration methods**](tutorials#ExplorationMethods).
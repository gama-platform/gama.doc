[//]: # (startConcept|runtime_and_schedulers)
<section class='concept-graph' markdown='1' id ='concept_39_0_27_runtime-and-schedulers'>
[//]: # (keyword|concept_scheduler)
<div class='gama-keyword-style' id ='39_0_96_concept-scheduler'></div>
# Runtime Concepts ## {#runtime-concepts}

When a model is being simulated, a number of algorithms are applied, for instance to determine the order in which to run the different agents, or the order in which the initialization of agents is performed, etc. This section details some of them, which can be important when building models and understanding how they will be effectively simulated.


## Table of contents  ## {#table-of-contents}

* [Simulation initialization](tutorials#simulation-initialization)
* [Agents Creation](tutorials#agents-creation)
* [Agents Step](tutorials#agents-step)
* [Schedule Agents](tutorials#schedule-agents)


## Simulation initialization ## {#simulation-initialization}
Once the user launches an experiment, GAMA starts the initialization of the simulation.
First it creates a [`world` agent](tutorials#GlobalSpecies).

It initializes all its attributes with their init values. This includes its shape (that will be used as environment of the simulation).

If a species of type [grid](tutorials#GridSpecies) exists in the model, agents of species are created.

Finally the `init` statement is executed. It should include the creation of all the other agents of [regular species](tutorials#RegularSpecies) of the simulation. After their creation and initialization, they are added in the list `members` the `world` (that contains all the micro-agent of the `world`).

[//]: # (keyword|concept_optimization)
<div class='gama-keyword-style' id ='39_1_81_concept-optimization'></div>
[//]: # (keyword|statement_create)
<div class='gama-keyword-style' id ='39_2_576_statement-create'></div>
[//]: # (keyword|concept_init)
<div class='gama-keyword-style' id ='39_3_59_concept-init'></div>
## Agents Creation ## {#agents-creation}
Except [`grid`](tutorials#GridSpecies) agents, other agents are created using the [`create` statement](references#Statements#create){.internal-link-anchor}. It is used to allocate memory for each agent and to initialize all its attributes.

If no explicit initialization exists for an attribute, it will get the default value corresponding to its [type](references#DataTypes).

The initialization of an attribute can be located at several places in the code; they are executed in the following order (which means that, if several ways are used, the attribute will finally have the value of the last applied one):
* using the `from:` facet of the `create` statement;
* in the embedded block of the `create` statement;
* in the attribute declaration, using the `init` facet;
* in the `init` block of the species.

[//]: # (keyword|concept_cycle)
<div class='gama-keyword-style' id ='39_4_27_concept-cycle'></div>
## Agents Step ## {#agents-step}
When an agent is asked to _step_, it means that it is expected to update its variables, run its behaviors and then _step_ its micro-agents (if any).

```
step of agent agent_a
    {
        species_a <- agent_a.species
        architecture_a <- species_a.architecture
        ask architecture_a to step agent_a {
             ask agent_a to update species_a.variables
             ask agent_a to run architecture_a.behaviors
        }

        ask each micro-population mp of agent_a to step {
            list<agent> sub-agents <- mp.compute_agents_to_schedule
            ask each agent_b of sub-agents to step //… recursive call...
        }
    }

```

## Schedule Agents ## {#schedule-agents}

The global scheduling of agents is then simply the application of this previous _step_ to the _experiment agent_, keeping in mind that this agent has only one micro-population (of simulation agents, each instance of the model species), and that the simulation(s) inside this population contain(s), in turn, all the "regular" populations of agents of the model.

To influence this schedule, then, one possible way is to change the way populations compute their lists of agents to schedule, which can be done in a model by providing custom definitions to the "schedules:" facet of one or several species.

[//]: # (keyword|concept_random)
<div class='gama-keyword-style' id ='39_5_89_concept-random'></div>
A practical application of this facet is to reduce simulation artifacts created by the default scheduling of populations, which is sequential (i.e. their agents are executed in turn in their order of creation). To enable a pseudo-parallel scheduling based on a random scheduling recomputed at each step, one has simply to define the corresponding species like in the following example:

```
species A schedules: shuffle(A) {…}
```

Moving further, it is possible to enable a completely random scheduling that will eliminate the sequential scheduling of populations:

```
global schedules: [world] + shuffle(A + B + C) {…}

species A schedules: [] {…}
species B schedules: [] {…}
species C schedules: [] {…}
```

It is important to (1) explicitly invoke the scheduling of the world (although it doesn't have to be the first); (2) suppress the population-based scheduling to avoid having agent being scheduled 2 times (one time in the custom definition, one time by their population).

Other schemes are possible. For instance, the following definition will completely suppress the default scheduling mechanism to replace it with a custom scheduler that will execute the world, then all agents of species A in a random way and then all agents of species B in their order of creation:

```
global schedules: [world] + shuffle(A) + B {…} // explicit scheduling in the world

species A schedules [];

species B schedules: [];

```

Complex conditions can be used to express which agents need to be scheduled each step. For instance, in the following definition, only agents of A that return true to a particular condition are scheduled:

```
species A schedules: A where each.can_be_scheduled() {

    bool can_be_scheduled() {
         …
         returns true_or_false;
    }
}
```

Be aware that enabling a custom scheduling can potentially end up in non-functional simulations. For example, the following definitions will result in a simulation that will **never be executed**:

```
global schedules: [] {}; // the world is NEVER scheduled
 
species my_scheduler schedules: [world] ; // so its micro-species 'my_scheduler' is NOT scheduled either. 
```

and this one will result in an **infinite loop** (which will trigger a stack overflow at some point):

```
global {} // The world is normally scheduled...

species my_scheduler schedules: [world]; // … but schedules itself again as a consequence of scheduling the micro-species 'my_scheduler'
```
[//]: # (endConcept|runtime_and_schedulers)
</section>
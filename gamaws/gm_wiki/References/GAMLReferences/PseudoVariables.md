[//]: # (keyword|concept_pseudo_variable)
<div class='gama-keyword-style' id ='397_0_1593_concept-pseudo-variable'></div>
# Pseudo-variables ## {#pseudo-variables}



The expressions known as **pseudo-variables** are special read-only variables that are not declared anywhere (at least not in a species), and which represent a value that changes depending on the context of execution.


## Table of contents  ## {#table-of-contents}

* [Pseudo-variables](references#pseudo-variables)
	* [self](references#self)
	* [myself](references#myself)
	* [each](references#each)



## self ## {#self}
The pseudo-variable `self` always holds a reference to the agent executing the current statement.

  * Example (sets the `friend` attribute of another random agent of the same species to `self` and conversely):

```
friend potential_friend <- one_of (species(self) - self);
if potential_friend != nil {
    potential_friend.friend <- self;
    friend <- potential_friend;
}
```




## myself ## {#myself}
`myself` plays the same role as `self` but in remotely-executed code (`ask`, `create`, `capture` and `release` statements), where it represents the _calling_ agent when the code is executed by the _remote_ agent.

  * Example (asks the first agent of my species to set its color to my color):

```
ask first (species (self)){
    color <- myself.color;
}
```

  * Example (create 10 new agents of the species of my species, share the energy between them, turn them towards me, and make them move 4 times to get closer to me):

```
create species (self) number: 10 {
   energy <- myself.energy / 10.0;
   loop times: 4 {
       heading <- towards (myself);
       do move;
   }
}
```




## each ## {#each}
`each` is available only in the right-hand argument of [iterators](references#Operators#Iterator-operators){.internal-link-anchor}.  It is a pseudo-variable that represents, in turn, each of the elements of the left-hand container. It can then take any type depending on the context.

  * Example:

```
    list<string> names <- my_species collect each.name;  // each is of type my_species
    int max <- max(['aa', 'bbb', 'cccc'] collect length(each)); // each is of type string
```
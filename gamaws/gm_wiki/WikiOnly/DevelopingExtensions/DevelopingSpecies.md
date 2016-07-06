# Developing Species ## {#developing-species}



Additional [built-in species](references#BuiltInSpecies) can be defined in Java in order to be used in GAML models. Additional attributes and actions can be defined. It could be very useful in order to define its behavior thanks to external libraries (e.g. [mulit-criteria decision-making](references#OtherBuiltInSpecies), [database connection](references#OtherBuiltInSpecies)...).

A new built-in species extends the `GamlAgent` class, which defines the basic GAML agents. As a consequence, new built-in species have all the attributes (`name`, `shape`, ...) and actions (`die`...) of [regular species](references#AgentBuiltIn).






## Implementation ## {#implementation}

A new species can be **any Java class** that:
  * extends the `GamlAgent` class,
  * begins by the [@species](wikionly#DevelopingIndexAnnotations#species){.internal-link-anchor}: `@species(name = "name_of_the_species_gaml")`,
```
@species(name = "multicriteria_analyzer")
public class MulticriteriaAnalyzer extends GamlAgent {
```

[Similarly to skills](wikionly#DevelopingSkills), a species can define additional attributes and actions.

### Additional attributes ## {#additional-attributes}

Defining new attributes needs:
  * to add [@vars](wikionly#DevelopingIndexAnnotations#vars){.internal-link-anchor} (and one embedded [@var](wikionly#DevelopingIndexAnnotations#var){.internal-link-anchor} per additional attribute) annotation on top of the class,
  * to define [@setter](wikionly#DevelopingIndexAnnotations#setter){.internal-link-anchor} and [@getter](wikionly#DevelopingIndexAnnotations#getter){.internal-link-anchor} annotations to the accessors methods.

For example, regular species are defined with the following annotation:
```
@vars({ @var(name = IKeyword.NAME, type = IType.STRING), @var(name = IKeyword.PEERS, type = IType.LIST),
	@var(name = IKeyword.HOST, type = IType.AGENT),
	@var(name = IKeyword.LOCATION, type = IType.POINT, depends_on = IKeyword.SHAPE),
	@var(name = IKeyword.SHAPE, type = IType.GEOMETRY) })
```

And accessors are defined using:
```
@getter(IKeyword.NAME)
public abstract String getName();

@setter(IKeyword.NAME)
public abstract void setName(String name);
```

### Additional actions ## {#additional-actions}

An additional action is a method annotated by the [@action](wikionly#DevelopingIndexAnnotations#action){.internal-link-anchor} annotation.
```
@action(name = ISpecies.stepActionName)
public Object _step_(final IScope scope) {
```






## Annotations ## {#annotations}
### @species ## {#species}
This annotation represents a "species" in GAML. The class annotated with this annotation will be the support of a species of agents.

This annotation contains:
  * **name** (string): _the name of the species that will be created with this class as base. Must be unique throughout GAML_.
  * **skills** (set of strings, empty by default): _An array of skill names that will be automatically attached to this species._ Example: ```
 @species(value="animal" skills={"moving"}) ```
  * **internal** (boolean, false by default): _whether this species is for internal use only_.
  * **doc** (set of @doc, empty by default): _the documentation attached to this operator._

All these annotations are defined in the `GamlAnnotations.java` file of the `msi.gama.processor` plug-in.
[//]: # (startConcept|programming_basis)
<section class='concept-graph' markdown='1' id ='concept_13_0_2_programming-basis'>
# Basic programming concepts in GAML ## {#basic-programming-concepts-in-gaml}

In this part, we will focus on the very basic structures in GAML, such as how to declare a variable, how to use loops, or how to manipulate lists. 
We will overfly quickly all those basic programming concepts, admitting that you already have some basics in coding.

## Index ## {#index}
	
* [Variables](tutorials#variables)
  * [Basic types](tutorials#basic-types)
  * [The point type](tutorials#the-point-type)
  * [A word about dimensions](tutorials#a-word-about-dimensions)
* [Declare variables using facet](tutorials#declare-variables-using-facet)
* [Operators in GAMA](tutorials#operators-in-gama)
  * [Logical operators](tutorials#logical-operators)
  * [Comparison operators](tutorials#comparison-operators)
  * [Type casting operators](tutorials#type-casting-operators)
  * [Other operators](tutorials#other-operators)
* [Conditional structures](tutorials#conditional-structures)
* [Loop](tutorials#loop)
* [Manipulate containers](tutorials#manipulate-containers)
* [Random values](tutorials#random-values)

## Variables ## {#variables}

Variables are declared very easily in GAML, starting with the keyword for the type, following by the name you want for your variable. 
NB: The declaration has to be inside the `global` scope, or inside the `species` scope.

```
typeName myVariableName;
```

### Basic types ## {#basic-types}

[//]: # (keyword|type_int)
<div class='gama-keyword-style' id ='13_0_1553_type-int'></div>
[//]: # (keyword|type_float)
<div class='gama-keyword-style' id ='13_1_1549_type-float'></div>
[//]: # (keyword|type_string)
<div class='gama-keyword-style' id ='13_2_1566_type-string'></div>
[//]: # (keyword|type_bool)
<div class='gama-keyword-style' id ='13_3_1543_type-bool'></div>
[//]: # (keyword|operator_<-)
<div class='gama-keyword-style' id ='13_4_1681_operator---'></div>
All the "basic" types are present in GAML:`int`, `float`, `string`, `bool`.
The operator for the affectation in GAML is `<-` (the operator `=` is used to test the equality).

```
int integerVariable <- 3;
float floatVariable <- 2.5;
string stringVariable <- "test"; // you can also write simple ' : <- 'test'
bool booleanVariable <- true; // or false
```

[//]: # (keyword|concept_write)
<div class='gama-keyword-style' id ='13_5_129_concept-write'></div>
To follow the behavior of variable, we can write their value in the console. Let's go back to our basic skeleton of a model, and let's create a reflex in the global scope (to be short, a reflex is a function that is executed in each step. We will come back to this concept later). The `write` function works very easily, simply writing down the keyword `write` and the name of the variable we want to be displayed.

```
model firstModel

global {
	int integerVariable <- 3;
	float floatVariable <- 2.5;
	string stringVariable <- "test"; // you can also write simple ' : <- 'test'
	bool booleanVariable <- true; // or false
	reflex writeDebug {
		write integerVariable;
		write floatVariable;
		write stringVariable;
		write booleanVariable;
	}
}

experiment myExperiment
{
}
```

The function `write` is overloaded for each type of variable (even for the more complex type, such as containers).

[//]: # (keyword|concept_nil)
<div class='gama-keyword-style' id ='13_6_1578_concept-nil'></div>
Note that before being initialized, a variable has the value `nil`.

```
reflex update {
	string my_string;
	write my_string; // this will write "nil".
	int my_int;
	write my_int; // this will write "0", which is the default value for int.
}
```

`nil` is also a literal you can use to initialize your variable (you can learn more about the concept of literal in this [page](references#Literals)).

```
reflex update {
	string my_string <- "a string";
	my_string <- nil;
	write my_string; // this will write "nil".
	int my_int <- 6;
	my_int <- nil;
	write my_int; // this will write "0", which is the default value for int.
}
```

[//]: # (keyword|type_point)
<div class='gama-keyword-style' id ='13_7_1560_type-point'></div>
### The point type ## {#the-point-type}

Another variable type you should know is the point variable. This type of variable is used to describe coordinates. It is in fact a complex variable, composed of two float variables (or three if you are working in 3D). To declare it, you have to use the curly bracket `{`:

```
point p <- {0.2,2.4};
```

The first field is related to the x value, and the second, to the y value. You can easily get this value as following:

```
point p <- {0.2,2.4};
write p.x; // the output will be 0.2
write p.y; // the output will be 2.4
```

You can't modify directly the value. But if you want, you can do a simple operation to get what you want:

```
point p <- {0.2,2.4};
p <- p + {0.0,1.0};
write p.y; // the output will be 3.4
```

[//]: # (keyword|concept_dimension)
<div class='gama-keyword-style' id ='13_8_32_concept-dimension'></div>
### A world about dimensions ## {#a-world-about-dimensions}

When manipulating float values, you can specify the dimension of your value. Dimensions are preceded by # or ° (exactly the same).

```
float a <- 5°m;
float b <- 4#cm;
float c <- a + b; // c is equal to 5.0399999 (it's not equal to 5.04 because it is a float value, not as precise as int)
```

[//]: # (keyword|concept_facet)
<div class='gama-keyword-style' id ='13_9_40_concept-facet'></div>
## Declare variables using facet ## {#declare-variables-using-facet}

Facets are used to describe the behavior of a variable during its declaration, by adding the keyword `facet` just after the variable name, followed by the value you want for the facet (or also just after the initial value).

```
type variableName <- initialValue facet1:valueForFacet1 facet2:valueForFacet2;
// or:
type variableName facet1:valueForFacet1 facet2:valueForFacet2;
variableName <- initialValue;
```

[//]: # (keyword|concept_update)
<div class='gama-keyword-style' id ='13_10_126_concept-update'></div>
You can use the facet `update` if you want to change the value of your variable. For example, to increment your integer variable each step, you can do as follow:

```
int integerVariable <- 3 min:0 max:10 update:integerVariable+1;
// nb: the operator "++" doesn't exist in gaml.
```

You can use the facet `min` and `max` to constraint the value in a specific range of values:

```
int integerVariable <- 3 min:0 max:10 update:integerVariable+1;
// the result will be 3 - 4 - 5 - 6 - 7 - 8 - 9 - 10 - 10 - 10 - ...
```

[//]: # (keyword|concept_enumeration)
<div class='gama-keyword-style' id ='13_11_37_concept-enumeration'></div>
The facet `among` can also be useful (that can be seen as an enum):

```
string fruits <- "banana" among:["pear","apple","banana"];
```

[//]: # (keyword|concept_operator)
<div class='gama-keyword-style' id ='13_12_80_concept-operator'></div>
## Operators in GAMA ## {#operators-in-gama}

In GAML language, you can use a lot of different operators. They are all listed in this [page](references#Operators), but here are the most useful ones:

[//]: # (keyword|operator_+)
<div class='gama-keyword-style' id ='13_13_142_operator--'></div>
[//]: # (keyword|operator_-)
<div class='gama-keyword-style' id ='13_14_131_operator--'></div>
[//]: # (keyword|operator_*)
<div class='gama-keyword-style' id ='13_15_141_operator--'></div>
[//]: # (keyword|operator_/)
<div class='gama-keyword-style' id ='13_16_137_operator--'></div>
[//]: # (keyword|operator_^)
<div class='gama-keyword-style' id ='13_17_139_operator--'></div>
**-	Mathematical operators**

The basic arithmetical operators, such as `+`(add), `-`(substract), `*`(multiply), `/`(divide), `^`(power) are used this way: 

FirstOperand Operator SecondOperand --> ex: 5 * 3; // return 15

[//]: # (keyword|operator_cos)
<div class='gama-keyword-style' id ='13_18_241_operator-cos'></div>
[//]: # (keyword|operator_sin)
<div class='gama-keyword-style' id ='13_19_482_operator-sin'></div>
[//]: # (keyword|operator_tan)
<div class='gama-keyword-style' id ='13_20_514_operator-tan'></div>
[//]: # (keyword|operator_sqrt)
<div class='gama-keyword-style' id ='13_21_499_operator-sqrt'></div>
[//]: # (keyword|operator_round)
<div class='gama-keyword-style' id ='13_22_461_operator-round'></div>
Some other operators, such as `cos`(cosinus), `sin`(sinus), `tan`(tangent), `sqrt`(square root), `round`(rounding) etc... are used this way:

```
Operator(Operand) --> ex: sqrt(49); // return 7
```

###	Logical operators ## {#logical-operators}

[//]: # (keyword|concept_logical)
<div class='gama-keyword-style' id ='13_23_66_concept-logical'></div>
[//]: # (keyword|operator_and)
<div class='gama-keyword-style' id ='13_24_173_operator-and'></div>
[//]: # (keyword|operator_or)
<div class='gama-keyword-style' id ='13_25_412_operator-or'></div>
[//]: # (keyword|operator_!)
<div class='gama-keyword-style' id ='13_26_134_operator--'></div>
Logical operators such as `and`(and), `or`(inclusive or) are used the same way as basic arithmetical operators. The operator `!`(negation) has to be placed just before the operand. They return a boolean result.

```
FirstOperand Operator SecondOperand --> ex: true or false; // return true
NegationOperator Operand --> ex: !(true or false); // return false
```

[//]: # (keyword|operator_!=)
<div class='gama-keyword-style' id ='13_27_135_operator---'></div>
[//]: # (keyword|operator_<)
<div class='gama-keyword-style' id ='13_28_143_operator--'></div>
[//]: # (keyword|operator_>)
<div class='gama-keyword-style' id ='13_29_147_operator--'></div>
[//]: # (keyword|operator_=)
<div class='gama-keyword-style' id ='13_30_146_operator--'></div>
### Comparison operators ## {#comparison-operators}

The comparison operators `!=`(different than), `<`(smaller than), `<=`(smaller of equal), `=`(equal), `>`(bigger than), `>=`(bigger or equal) are used the same way as basic arithmetical operators:

```
FirstOperand Operator SecondOperand --> ex: 5 < 3; // return false
```

[//]: # (keyword|concept_cast)
<div class='gama-keyword-style' id ='13_31_16_concept-cast'></div>
[//]: # (keyword|operator_int)
<div class='gama-keyword-style' id ='13_32_335_operator-int'></div>
### Type casting operators ## {#type-casting-operators}

You can cast an operand to a special type using casting operator:
	
```
Operator(Operand); --> ex: int(2.1); // return 2
```

### Other operators ## {#other-operators}

A lot of other operators exist in GAML. The standard way to use those operators is as followed:

```
Operator(FirstOperand,SecondOperand,...) --> ex: rnd(1,8);
```

Some others are used in a more intuitive way:

```
FirstOperand Operator SecondOperand --> ex: 2[6,4,5] contains(5);
```

[//]: # (keyword|concept_condition)
<div class='gama-keyword-style' id ='13_33_23_concept-condition'></div>
[//]: # (keyword|statement_if)
<div class='gama-keyword-style' id ='13_34_599_statement-if'></div>
[//]: # (keyword|statement_else)
<div class='gama-keyword-style' id ='13_35_586_statement-else'></div>
## Conditional structures ## {#conditional-structures}

You can write if/else if/else in GAML:

```
if (integerVariable<0) {
	write "my value is negative !! The exact value is " + integerVariable;
}
else if (integerVariable>0) {
	write "my value is positive !! The exact value is " + integerVariable;
}
else if (integerVariable=0) {
	write "my value is equal to 0 !!";
}
else {
	write "hey... This is not possible, right ?";
}
```

[//]: # (keyword|concept_ternary)
<div class='gama-keyword-style' id ='13_36_114_concept-ternary'></div>
GAML also accepts ternary operator:

```
stringVariable <- (booleanVariable) ? "booleanVariable = true" : "booleanVariable = false";
```

[//]: # (keyword|concept_loop)
<div class='gama-keyword-style' id ='13_37_67_concept-loop'></div>
[//]: # (keyword|statement_loop)
<div class='gama-keyword-style' id ='13_38_603_statement-loop'></div>
## Loop ## {#loop}

Loops in GAML are designed by the keyword `loop`. As for variables, a loop have multiple facet to determine its behavior:

-	The facet `times`, to repeat a fixed number of times a set of statements:

```
loop times: 2 {
write "helloWorld";
} 
// the output will be helloWorld - helloWorld
```

-	The facet `while`, to repeat a set of statements while a condition is true:

```
loop while: (true) {
}
// infinity loop
```

-	The facet `from` / `to`, to repeat a set of statements while an index iterates over a range of values with a fixed step of 1:

```
loop i from:0 to: 5 { // or loop name:i from:0 to:5 -> the name is also a facet
	write i;
}
// the output will be 0 - 1 - 2 - 3 - 4 - 5
```

-	The facet `from` / `to` combine with the facet `step` to choose the step:

```
loop i from:0 to: 5 step: 2 {
	write i;
}
// the output will be 0 - 2 - 4
```

-	The facet over to browse containers, as we will see in the next part.

[//]: # (keyword|statement_break)
<div class='gama-keyword-style' id ='13_39_571_statement-break'></div>
Nb: you can interrupt a loop at any time by using the `break` statement.

[//]: # (keyword|concept_container)
<div class='gama-keyword-style' id ='13_40_25_concept-container'></div>
[//]: # (keyword|type_list)
<div class='gama-keyword-style' id ='13_41_1554_type-list'></div>
## Manipulate containers ## {#manipulate-containers}

We saw in the previous parts "simple" types of variable. You also have a multiple containers types, such as list, matrix, map, pair... In this section, we will only focus on the container `list` (you can learn the other by reading the [section about datatypes](references#DataTypes#complex-built-in-types){.internal-link-anchor}).

**How to declare a list?**

To declare a list, you can either or not specify the type of the data of its elements:

```
list<int> listOfInt <- [5,4,9,8];
list listWithoutType <- [2,4.6,"oij",["hoh",0.0]];
```

[//]: # (keyword|operator_length)
<div class='gama-keyword-style' id ='13_42_372_operator-length'></div>
[//]: # (keyword|operator_empty)
<div class='gama-keyword-style' id ='13_43_276_operator-empty'></div>
**How to know the number of elements of a list?**

To know the number of element of a list, you can use the operator `length` that returns the number of elements (note that this operator also works with strings).

```
int numberOfElements <- length([12,13]); // will return 2
int numberOfElements <- length([]); // will return 0
int numberOfElements <- length("stuff"); // will return 5
```

There is an other operator, `empty`, that returns you a boolean telling you if the list is empty or not.

```
bool isEmpty <- empty([12,13]); // will return false
bool isEmpty <- empty([]); // will return true
bool isEmpty <- empty("stuff"); // will return false
```

[//]: # (keyword|operator_at)
<div class='gama-keyword-style' id ='13_44_199_operator-at'></div>
**How to get an element from a list?**

To get an element from a list by its index, you have to use the operator `at` (nb: it is indeed an operator, and not a facet, so no ":" after the keyword).

```
int theFirstElementOfTheList <- [5,4,9,8] at 0; // this will return 5
int theThirdElementOfTheList <- [5,4,9,8] at 2; // this will return 9
```

[//]: # (keyword|operator_last_index)
<div class='gama-keyword-style' id ='13_45_1682_operator-last-index'></div>
[//]: # (keyword|operator_index_of)
<div class='gama-keyword-style' id ='13_46_333_operator-index-of'></div>
**How to know the index of an element of a list?**

You can know the index of the first occurrence of a value in a list using the operator `index_of`.
You can know the index of the last occurrence of a value in a list using the operator `last_index_of`.

```
int result <- [4,2,3,4,5,4] last_index_of 4;  // result equals 5
int result <- [4,2,3,4,5,4] index_of 4;  // result equals 0
```

[//]: # (keyword|operator_contains)
<div class='gama-keyword-style' id ='13_47_231_operator-contains'></div>
**How to know if an element exists in a list?**

You can use the operator `contains` (return a boolean):

```
bool result <- [{1,2}, {3,4}, {5,6}] contains {3,4};  // result equals true
```

[//]: # (keyword|statement_remove)
<div class='gama-keyword-style' id ='13_48_618_statement-remove'></div>
[//]: # (keyword|statement_add)
<div class='gama-keyword-style' id ='13_49_565_statement-add'></div>
[//]: # (keyword|statement_put)
<div class='gama-keyword-style' id ='13_50_614_statement-put'></div>
**How to insert/remove an element to/from a list?**

For those operation, no operator are available, but you can use a statement instead. The statements `add` and `put` are used to insert/modify an element, while the statement `remove` is used to remove an element. Here are some example of how to use those 3 statements with the most common facets:

```
list<int> list_int <- [1,5,7,6,7];
remove from:list_int index:1; // remove the 2nd element of the list
write list_int; // the output is : [1,7,6,7]
remove item:7 from:list_int; // remove the 1st occurrence of 7
write list_int; // the output is : [1,6,7]
add item:9 to: list_int at: 2; // add 9 in the 3rd position
write list_int; // the output is : [1,6,9,7]
add 0 to: list_int; // add 0 in the last position
write list_int; // the output is : [1,6,9,7,0]
put 3 in: list_int at: 0; // put 3 in the 1st position
write list_int; // the output is : [3,6,9,7,0]
put 2 in: list_int key: 2; // put 2 in the 3rd position
write list_int; // the output is : [3,6,2,7,0]
```

**How to add 2 lists?**

You can add 2 lists by creating a third one and browsing the 2 first one, but you can do it much easily by using the operator `+` : 

```
list<int> list_int1 <- [1,5,7,6,7];
list<int> list_int2 <- [6,9];
list<int> list_int_result <- list_int1 + list_int2;
```


**How to browse a list?**

You can use the facet `over` of a loop:

```
list<int> exampleOfList <- [4,2,3,4,5,4];
loop i over:exampleOfList {
	write i;
}
// the output will be 4 - 2 - 3 - 4 - 5 - 4
```

[//]: # (keyword|concept_filter)
<div class='gama-keyword-style' id ='13_51_42_concept-filter'></div>
**How to filter a list?**

If you want to get all the elements of a list that fulfill a particular condition, you need the operator where. In the condition, you can design all the element of a particular list by using the pseudo variable **`each`** as followed:

```
list<int> exampleOfList <- [4,2,3,4,5,4] where (each <= 3); 
// the list is now [2,3]
```

Other useful operators for the manipulation of lists:

Here are some other operators which can be useful to manipulate lists: `sort`, `sort_by`, `shuffle`, `reverse`, `collect`, `accumulate`, `among`. Please read the GAML Reference if you want to know more about those operators.

[//]: # (keyword|concept_random)
<div class='gama-keyword-style' id ='13_52_89_concept-random'></div>
[//]: # (keyword|concept_probability)
<div class='gama-keyword-style' id ='13_53_87_concept-probability'></div>
## Random values ## {#random-values}

When you will implement your model, you will have to manipulate some random values quite often. 

[//]: # (keyword|operator_rnd)
<div class='gama-keyword-style' id ='13_54_457_operator-rnd'></div>
To get a random value in a range of value, use the operator [`rnd`](references#Operators#rnd){.internal-link-anchor}. You can use this operator in many ways:

```
int var0 <- rnd (2);    // var0 equals 0, 1 or 2
float var1 <- rnd (1000) / 1000;    // var1 equals a float between 0 and 1 with a precision of 0.001
point var2 <- rnd ({2.0, 4.0}, {2.0, 5.0, 10.0}, 1);    // var2 equals a point with x = 2.0, y equal to 2.0, 3.0 or 4.0 and z between 0.0 and 10.0 every 1.0
float var3 <- rnd (2.0, 4.0, 0.5);  // var3 equals a float number between 2.0 and 4.0 every 0.5
float var4 <- rnd(3.4);     // var4 equals a random float between 0.0 and 3.4
int var5 <- rnd (2, 12, 4);     // var5 equals 2, 6 or 10
point var6 <- rnd ({2.5,3, 0.0});   // var6 equals {x,y} with x in [0.0,2.0], y in [0.0,3.0], z = 0.0
int var7 <- rnd (2, 4);     // var7 equals 2, 3 or 4
point var8 <- rnd ({2.0, 4.0}, {2.0, 5.0, 10.0});   // var8 equals a point with x = 2.0, y between 2.0 and 4.0 and z between 0.0 and 10.0
float var9 <- rnd (2.0, 4.0);   // var9 equals a float number between 2.0 and 4.0
```

[//]: # (keyword|operator_flip)
<div class='gama-keyword-style' id ='13_55_291_operator-flip'></div>
Use the operator [`flip`](references#Operators#flip){.internal-link-anchor} if you want to pick a boolean value with a certain probability:

```
bool result <- flip(0.2); // result will have 20% of chance to be true
```

[//]: # (keyword|operator_shuffle)
<div class='gama-keyword-style' id ='13_56_477_operator-shuffle'></div>
You can use randomness in list, by using the operator [`shuffle`](references#Operators#shuffle){.internal-link-anchor}, or also by using the operator [`among`](references#Operators#among){.internal-link-anchor} to pick randomly one (or several) element of your list:

```
list TwoRandomValuesFromTheList <- 2 among [5,4,9,8];
// the list will be for example [5,9].
```

[//]: # (keyword|concept_distribution)
<div class='gama-keyword-style' id ='13_57_34_concept-distribution'></div>
You can use probabilistic laws, using operators such as [`gauss`](references#Operators#gauss){.internal-link-anchor}, [`poisson`](references#Operators#poisson){.internal-link-anchor}, [`binomial`](references#Operators#binomial){.internal-link-anchor}, or [`truncated_gauss`](references#Operators#truncated_gauss){.internal-link-anchor} (we invite you to read the documentation for those operators).
[//]: # (endConcept|programming_basis)
</section>
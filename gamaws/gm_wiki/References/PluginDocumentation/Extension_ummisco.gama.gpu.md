# Extension ## {#extension}

----

 ummisco.gama.gpu

## Table of Contents ## {#table-of-contents}
### Operators ## {#operators}
[CPU_path_between](references#cpu_path_between), [GPU_path_between](references#gpu_path_between), 

### Statements ## {#statements}


### Skills ## {#skills}


### Architectures ## {#architectures}



### Species ## {#species}



----

## Operators ## {#operators}
	
    	
----
[//]: # (keyword|operator_CPU_path_between)
<div class='gama-keyword-style' id ='410_0_1633_operator-CPU-path-between'></div>
### `CPU_path_between` ## {#cpu-path-between}

#### Possible use:  ## {#possible-use}
  *  **`CPU_path_between`** (`graph`, `geometry`, `geometry`) --->  `path` 

#### Result:  ## {#result}
The shortest path between a list of two objects in a graph computed with CPU

#### Examples:  ## {#examples}
```
path var0 <- my_graph CPU_path_between (ag1:: ag2); 	// var0 equals A path between ag1 and ag2
```
  

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_GPU_path_between)
<div class='gama-keyword-style' id ='410_1_1634_operator-GPU-path-between'></div>
### `GPU_path_between` ## {#gpu-path-between}

#### Possible use:  ## {#possible-use}
  *  **`GPU_path_between`** (`graph`, `geometry`, `geometry`) --->  `path` 

#### Result:  ## {#result}
The shortest path between a list of two objects in a graph computed with GPU

#### Examples:  ## {#examples}
```
path var0 <- my_graph GPU_path_between (ag1:: ag2); 	// var0 equals A path between ag1 and ag2
```
  

[Top of the page](references#table-of-contents)
  	

----

## Skills ## {#skills}
	

----

## Statements ## {#statements}
		
	
----

## Species ## {#species}
	
	
----

## Architectures  ## {#architectures}
	
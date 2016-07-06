[//]: # (startConcept|call_r)
<section class='concept-graph' markdown='1' id ='concept_47_0_35_call-r'>
[//]: # (keyword|concept_r)
<div class='gama-keyword-style' id ='47_0_88_concept-r'></div>
# Calling R ## {#calling-r}


## Introduction ## {#introduction}



R language is one of powerful data mining tools, and its community is very large in the world (See the website: http://www.r-project.org/). Adding the R language into GAMA is our strong endeavors to accelerate many statistical, data mining tools into GAMA.

RCaller 2.0 package (Website: http://code.google.com/p/rcaller/) is used for GAMA 1.6.1.


## Table of contents  ## {#table-of-contents}

* [Introduction](tutorials#introduction)
	* [Configuration in GAMA](tutorials#configuration-in-gama)
	* [Calling R from GAML](tutorials#calling-r-from-gaml)
		* [Calling the built-in operators](tutorials#calling-the-built-in-operators)
			* [Example 1](tutorials#example-1)
		* [Calling R codes from a text file (.txt) WITHOUT the parameters](tutorials#calling-r-codes-from-a-text-file-txt-without-the-parameters)
			* [Example 2](tutorials#example-2)
			* [Correlation.R file](tutorials#correlationr-file)
		* [Output](tutorials#output)
			* [Example 3](tutorials#example-3)
			* [RandomForest.R file](tutorials#randomforestr-file)
* [Load the package:](tutorials#load-the-package)
* [Read data from iris:](tutorials#read-data-from-iris)
* [Build the decision tree:](tutorials#build-the-decision-tree)
* [Build the random forest of 50 decision trees:](tutorials#build-the-random-forest-of-50-decision-trees)
* [Predict the acceptance of test set:](tutorials#predict-the-acceptance-of-test-set)
* [Calculate the accuracy:](tutorials#calculate-the-accuracy)
			* [Output](tutorials#output)
		* [Calling R codes from a text file (.R, .txt) WITH the parameters](tutorials#calling-r-codes-from-a-text-file-r-txt-with-the-parameters)
			* [Example 4](tutorials#example-4)
			* [Mean.R file](tutorials#meanr-file)
		* [Output](tutorials#output)
			* [Example 5](tutorials#example-5)
			* [AddParam.R file](tutorials#addparamr-file)
			* [Output](tutorials#output)




## Configuration in GAMA ## {#configuration-in-gama}
1) Install R language into your computer.

2) In GAMA, select menu option: **Edit\Preferences**.

3) In "**Config RScript's path**", browse to your "**Rscript**" file (R language installed in your system).

**Notes**: Ensure that install.packages("Runiversal") is already applied in R environment.





## Calling R from GAML ## {#calling-r-from-gaml}

### Calling the built-in operators ## {#calling-the-built-in-operators}

#### Example 1 ## {#example-1}

```
model CallingR

global {
	list X <- [2, 3, 1];
	list Y <- [2, 12, 4]; 

	list result;
	
	init{
		write corR(X, Y); // -> 0.755928946018454
		write meanR(X); // -> 2.0
	}
}
```


### Calling R codes from a text file (**.R,**.txt) WITHOUT the parameters ## {#calling-r-codes-from-a-text-file-rtxt-without-the-parameters}

Using **R\_compute(String RFile)** operator. This operator DOESN’T ALLOW to add any parameters form the GAML code. All inputs is directly added into the R codes.
**Remarks**: Don’t let any white lines at the end of R codes. **R\_compute** will return the last variable of R file, this parameter can be a basic type or a list.  Please ensure that the called packages must be installed before using.

#### Example 2  ## {#example-2}
```
model CallingR

global
{
	list result;

	init{
		result <- R_compute("C:/YourPath/Correlation.R");
		write result at 0;
	}
}
```
Above syntax is deprecated, use following syntax with R_file instead of R_compute:

```
model CallingR

global
{
	file result;

	init{
		result <- R_file("C:/YourPath/Correlation.R");
		write result.contents;
	}
}
```
#### Correlation.R file ## {#correlationr-file}
```
x <- c(1, 2, 3)

y <- c(1, 2, 4)

result <- cor(x, y, method = "pearson")
```

### Output ## {#output}

`result::[0.981980506061966]`


#### Example 3 ## {#example-3}
```
model CallingR

global
{
	list result;

	init{
		result <- R_compute("C:/YourPath/RandomForest.R");

		write result at 0;
	}
}
```

#### RandomForest.R file ## {#randomforestr-file}

```
# Load the package: ## {#load-the-package}

library(randomForest)

# Read data from iris: ## {#read-data-from-iris}

data(iris)

nrow<-length(iris[,1])

ncol<-length(iris[1,])

idx<-sample(nrow,replace=FALSE)

trainrow<-round(2*nrow/3)

trainset<-iris[idx[1:trainrow],]

# Build the decision tree: ## {#build-the-decision-tree}

trainset<-iris[idx[1:trainrow],]

testset<-iris[idx[(trainrow+1):nrow],]

# Build the random forest of 50 decision trees: ## {#build-the-random-forest-of-50-decision-trees}

model<-randomForest(x= trainset[,-ncol], y= trainset[,ncol], mtry=3, ntree=50)

# Predict the acceptance of test set:  ## {#predict-the-acceptance-of-test-set}

pred<-predict(model, testset[,-ncol], type="class")

# Calculate the accuracy: ## {#calculate-the-accuracy}

acc<-sum(pred==testset[, ncol])/(nrow-trainrow)
```

#### Output ## {#output}

`acc::[0.98]`

### Calling R codes from a text file (.R, .txt) WITH the parameters ## {#calling-r-codes-from-a-text-file-r-txt-with-the-parameters}

Using **R\_compute\_param(String RFile, List vectorParam)** operator. This operator ALLOWS to add the parameters from the GAML code.

**Remarks**: Don’t let any white lines at the end of R codes. **R\_compute\_param** will return the last variable of R file, this parameter can be a basic type or a list. Please ensure that the called packages must be installed before using.

#### Example 4 ## {#example-4}

```
model CallingR

global
{
	list X <- [2, 3, 1];
	list result;

	init{
		result <- R_compute_param("C:/YourPath/Mean.R", X);
		write result at 0;
	}
}
```

#### Mean.R file ## {#meanr-file}

`result <- mean(vectorParam)`

### Output ## {#output}

`result::[3.33333333333333]`

#### Example 5 ## {#example-5}

```
model CallingR

global {
	list X <- [2, 3, 1];
	list result;
	
        init{
		result <- R_compute_param("C:/YourPath/AddParam.R", X);
		write result at 0;
	}
}
```

#### AddParam.R file ## {#addparamr-file}

`v1 <- vectorParam[1]`

`v2<-vectorParam[2]`

`v3<-vectorParam[3]`

`result<-v1+v2+v3`

#### Output ## {#output}

`result::[10]`
[//]: # (endConcept|call_r)
</section>
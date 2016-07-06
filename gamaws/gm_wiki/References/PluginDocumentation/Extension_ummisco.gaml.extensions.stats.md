# Extension ## {#extension}

----

 ummisco.gaml.extensions.stats

## Table of Contents ## {#table-of-contents}
### Operators ## {#operators}
[auto_correlation](references#auto_correlation), [beta](references#beta), [binomial_coeff](references#binomial_coeff), [binomial_complemented](references#binomial_complemented), [binomial_sum](references#binomial_sum), [chi_square](references#chi_square), [chi_square_complemented](references#chi_square_complemented), [correlation](references#correlation), [covariance](references#covariance), [dnorm](references#dnorm), [durbin_watson](references#durbin_watson), [gamma](references#gamma), [gamma_distribution](references#gamma_distribution), [gamma_distribution_complemented](references#gamma_distribution_complemented), [incomplete_beta](references#incomplete_beta), [incomplete_gamma](references#incomplete_gamma), [incomplete_gamma_complement](references#incomplete_gamma_complement), [kurtosis](references#kurtosis), [lgamma](references#lgamma), [log_gamma](references#log_gamma), [moment](references#moment), [normal_area](references#normal_area), [normal_density](references#normal_density), [normal_inverse](references#normal_inverse), [pbinom](references#pbinom), [pchisq](references#pchisq), [percentile](references#percentile), [pgamma](references#pgamma), [pnorm](references#pnorm), [pValue_for_fStat](references#pvalue_for_fstat), [pValue_for_tStat](references#pvalue_for_tstat), [quantile](references#quantile), [quantile_inverse](references#quantile_inverse), [rank_interpolated](references#rank_interpolated), [rms](references#rms), [skew](references#skew), [student_area](references#student_area), [student_t_inverse](references#student_t_inverse), [variance](references#variance), 

### Statements ## {#statements}


### Skills ## {#skills}


### Architectures ## {#architectures}



### Species ## {#species}



----

## Operators ## {#operators}
	
    	
----
[//]: # (keyword|operator_auto_correlation)
<div class='gama-keyword-style' id ='413_0_1639_operator-auto-correlation'></div>
### `auto_correlation` ## {#auto-correlation}

#### Possible use:  ## {#possible-use}
  * `container` **`auto_correlation`** `int` --->  `float` 

#### Result:  ## {#result}
Returns the auto-correlation of a data sequence

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_beta)
<div class='gama-keyword-style' id ='413_1_1640_operator-beta'></div>
### `beta` ## {#beta}

#### Possible use:  ## {#possible-use}
  * `float` **`beta`** `float` --->  `float` 

#### Result:  ## {#result}
Returns the beta function with arguments a, b.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_binomial_coeff)
<div class='gama-keyword-style' id ='413_2_1641_operator-binomial-coeff'></div>
### `binomial_coeff` ## {#binomial-coeff}

#### Possible use:  ## {#possible-use}
  * `int` **`binomial_coeff`** `int` --->  `float` 

#### Result:  ## {#result}
Returns n choose k as a double. Note the integerization of the double return value.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_binomial_complemented)
<div class='gama-keyword-style' id ='413_3_1642_operator-binomial-complemented'></div>
### `binomial_complemented` ## {#binomial-complemented}

#### Possible use:  ## {#possible-use}
  *  **`binomial_complemented`** (`int`, `int`, `float`) --->  `float` 

#### Result:  ## {#result}
Returns the sum of the terms k+1 through n of the Binomial probability density, where n is the number of trials and P is the probability of success in the range 0 to 1.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_binomial_sum)
<div class='gama-keyword-style' id ='413_4_1643_operator-binomial-sum'></div>
### `binomial_sum` ## {#binomial-sum}

#### Possible use:  ## {#possible-use}
  *  **`binomial_sum`** (`int`, `int`, `float`) --->  `float` 

#### Result:  ## {#result}
Returns the sum of the terms 0 through k of the Binomial probability density, where n is the number of trials and p is the probability of success in the range 0 to 1.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_chi_square)
<div class='gama-keyword-style' id ='413_5_1644_operator-chi-square'></div>
### `chi_square` ## {#chi-square}

#### Possible use:  ## {#possible-use}
  * `float` **`chi_square`** `float` --->  `float` 

#### Result:  ## {#result}
Returns the area under the left hand tail (from 0 to x) of the Chi square probability density function with df degrees of freedom.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_chi_square_complemented)
<div class='gama-keyword-style' id ='413_6_1645_operator-chi-square-complemented'></div>
### `chi_square_complemented` ## {#chi-square-complemented}

#### Possible use:  ## {#possible-use}
  * `float` **`chi_square_complemented`** `float` --->  `float` 

#### Result:  ## {#result}
Returns the area under the right hand tail (from x to infinity) of the Chi square probability density function with df degrees of freedom.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_correlation)
<div class='gama-keyword-style' id ='413_7_1646_operator-correlation'></div>
### `correlation` ## {#correlation}

#### Possible use:  ## {#possible-use}
  * `container` **`correlation`** `container` --->  `float` 

#### Result:  ## {#result}
Returns the correlation of two data sequences

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_covariance)
<div class='gama-keyword-style' id ='413_8_1647_operator-covariance'></div>
### `covariance` ## {#covariance}

#### Possible use:  ## {#possible-use}
  * `container` **`covariance`** `container` --->  `float` 

#### Result:  ## {#result}
Returns the covariance of two data sequences

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_dnorm)
<div class='gama-keyword-style' id ='413_9_1648_operator-dnorm'></div>
### `dnorm` ## {#dnorm}
Same signification as [normal_density](references#normal_density)

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_durbin_watson)
<div class='gama-keyword-style' id ='413_10_1649_operator-durbin-watson'></div>
### `durbin_watson` ## {#durbin-watson}

#### Possible use:  ## {#possible-use}
  *  **`durbin_watson`** (`container`) --->  `float` 

#### Result:  ## {#result}
Durbin-Watson computation

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_gamma)
<div class='gama-keyword-style' id ='413_11_1650_operator-gamma'></div>
### `gamma` ## {#gamma}

#### Possible use:  ## {#possible-use}
  *  **`gamma`** (`float`) --->  `float` 

#### Result:  ## {#result}
Returns the value of the Gamma function at x.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_gamma_distribution)
<div class='gama-keyword-style' id ='413_12_1651_operator-gamma-distribution'></div>
### `gamma_distribution` ## {#gamma-distribution}

#### Possible use:  ## {#possible-use}
  *  **`gamma_distribution`** (`float`, `float`, `float`) --->  `float` 

#### Result:  ## {#result}
Returns the integral from zero to x of the gamma probability density function.  

#### Comment:  ## {#comment}
incomplete_gamma(a,x) is equal to pgamma(a,1,x).

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_gamma_distribution_complemented)
<div class='gama-keyword-style' id ='413_13_1652_operator-gamma-distribution-complemented'></div>
### `gamma_distribution_complemented` ## {#gamma-distribution-complemented}

#### Possible use:  ## {#possible-use}
  *  **`gamma_distribution_complemented`** (`float`, `float`, `float`) --->  `float` 

#### Result:  ## {#result}
Returns the integral from x to infinity of the gamma probability density function.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_incomplete_beta)
<div class='gama-keyword-style' id ='413_14_1653_operator-incomplete-beta'></div>
### `incomplete_beta` ## {#incomplete-beta}

#### Possible use:  ## {#possible-use}
  *  **`incomplete_beta`** (`float`, `float`, `float`) --->  `float` 

#### Result:  ## {#result}
Returns the regularized integral of the beta function with arguments a and b, from zero to x.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_incomplete_gamma)
<div class='gama-keyword-style' id ='413_15_1654_operator-incomplete-gamma'></div>
### `incomplete_gamma` ## {#incomplete-gamma}

#### Possible use:  ## {#possible-use}
  * `float` **`incomplete_gamma`** `float` --->  `float` 

#### Result:  ## {#result}
 Returns the regularized integral of the Gamma function with argument a to the integration end point x.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_incomplete_gamma_complement)
<div class='gama-keyword-style' id ='413_16_1655_operator-incomplete-gamma-complement'></div>
### `incomplete_gamma_complement` ## {#incomplete-gamma-complement}

#### Possible use:  ## {#possible-use}
  * `float` **`incomplete_gamma_complement`** `float` --->  `float` 

#### Result:  ## {#result}
Returns the complemented regularized incomplete Gamma function of the argument a and integration start point x.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_kurtosis)
<div class='gama-keyword-style' id ='413_17_1656_operator-kurtosis'></div>
### `kurtosis` ## {#kurtosis}

#### Possible use:  ## {#possible-use}
  *  **`kurtosis`** (`container`) --->  `float`
  * `float` **`kurtosis`** `float` --->  `float` 

#### Result:  ## {#result}
Returns the kurtosis (aka excess) of a data sequence/nReturns the kurtosis (aka excess) of a data sequence

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_lgamma)
<div class='gama-keyword-style' id ='413_18_1657_operator-lgamma'></div>
### `lgamma` ## {#lgamma}
Same signification as [log_gamma](references#log_gamma)

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_log_gamma)
<div class='gama-keyword-style' id ='413_19_1658_operator-log-gamma'></div>
### `log_gamma` ## {#log-gamma}

#### Possible use:  ## {#possible-use}
  *  **`log_gamma`** (`float`) --->  `float` 

#### Result:  ## {#result}
Returns the log of the value of the Gamma function at x.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_moment)
<div class='gama-keyword-style' id ='413_20_1659_operator-moment'></div>
### `moment` ## {#moment}

#### Possible use:  ## {#possible-use}
  *  **`moment`** (`container`, `int`, `float`) --->  `float` 

#### Result:  ## {#result}
Returns the moment of k-th order with constant c of a data sequence

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_normal_area)
<div class='gama-keyword-style' id ='413_21_1660_operator-normal-area'></div>
### `normal_area` ## {#normal-area}

#### Possible use:  ## {#possible-use}
  *  **`normal_area`** (`float`, `float`, `float`) --->  `float` 

#### Result:  ## {#result}
Returns the area to the left of x in the normal distribution with the given mean and standard deviation.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_normal_density)
<div class='gama-keyword-style' id ='413_22_1661_operator-normal-density'></div>
### `normal_density` ## {#normal-density}

#### Possible use:  ## {#possible-use}
  *  **`normal_density`** (`float`, `float`, `float`) --->  `float` 

#### Result:  ## {#result}
Returns the probability of x in the normal distribution with the given mean and standard deviation.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_normal_inverse)
<div class='gama-keyword-style' id ='413_23_1662_operator-normal-inverse'></div>
### `normal_inverse` ## {#normal-inverse}

#### Possible use:  ## {#possible-use}
  *  **`normal_inverse`** (`float`, `float`, `float`) --->  `float` 

#### Result:  ## {#result}
Returns the x in the normal distribution with the given mean and standard deviation, to the left of which lies the given area. normal.Inverse returns the value in terms of standard deviations from the mean, so we need to adjust it for the given mean and standard deviation.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_pbinom)
<div class='gama-keyword-style' id ='413_24_1663_operator-pbinom'></div>
### `pbinom` ## {#pbinom}
Same signification as [binomial_sum](references#binomial_sum)

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_pchisq)
<div class='gama-keyword-style' id ='413_25_1664_operator-pchisq'></div>
### `pchisq` ## {#pchisq}
Same signification as [chi_square](references#chi_square)

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_percentile)
<div class='gama-keyword-style' id ='413_26_1665_operator-percentile'></div>
### `percentile` ## {#percentile}
Same signification as [quantile_inverse](references#quantile_inverse)

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_pgamma)
<div class='gama-keyword-style' id ='413_27_1666_operator-pgamma'></div>
### `pgamma` ## {#pgamma}
Same signification as [gamma_distribution](references#gamma_distribution)

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_pnorm)
<div class='gama-keyword-style' id ='413_28_1667_operator-pnorm'></div>
### `pnorm` ## {#pnorm}
Same signification as [normal_area](references#normal_area)

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_pValue_for_fStat)
<div class='gama-keyword-style' id ='413_29_1668_operator-pValue-for-fStat'></div>
### `pValue_for_fStat` ## {#pvalue-for-fstat}

#### Possible use:  ## {#possible-use}
  *  **`pValue_for_fStat`** (`float`, `int`, `int`) --->  `float` 

#### Result:  ## {#result}
Returns the P value of F statistic fstat with numerator degrees of freedom dfn and denominator degress of freedom dfd. Uses the incomplete Beta function.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_pValue_for_tStat)
<div class='gama-keyword-style' id ='413_30_1669_operator-pValue-for-tStat'></div>
### `pValue_for_tStat` ## {#pvalue-for-tstat}

#### Possible use:  ## {#possible-use}
  * `float` **`pValue_for_tStat`** `int` --->  `float` 

#### Result:  ## {#result}
Returns the P value of the T statistic tstat with df degrees of freedom. This is a two-tailed test so we just double the right tail which is given by studentT of -|tstat|.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_quantile)
<div class='gama-keyword-style' id ='413_31_1670_operator-quantile'></div>
### `quantile` ## {#quantile}

#### Possible use:  ## {#possible-use}
  * `container` **`quantile`** `float` --->  `float` 

#### Result:  ## {#result}
Returns the phi-quantile; that is, an element elem for which holds that phi percent of data elements are less than elem. The quantile need not necessarily be contained in the data sequence, it can be a linear interpolation.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_quantile_inverse)
<div class='gama-keyword-style' id ='413_32_1671_operator-quantile-inverse'></div>
### `quantile_inverse` ## {#quantile-inverse}

#### Possible use:  ## {#possible-use}
  * `container` **`quantile_inverse`** `float` --->  `float` 

#### Result:  ## {#result}
Returns how many percent of the elements contained in the receiver are <= element. Does linear interpolation if the element is not contained but lies in between two contained elements.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_rank_interpolated)
<div class='gama-keyword-style' id ='413_33_1672_operator-rank-interpolated'></div>
### `rank_interpolated` ## {#rank-interpolated}

#### Possible use:  ## {#possible-use}
  * `container` **`rank_interpolated`** `float` --->  `float` 

#### Result:  ## {#result}
Returns the linearly interpolated number of elements in a list less or equal to a given element. The rank is the number of elements <= element. Ranks are of the form {0, 1, 2,..., sortedList.size()}. If no element is <= element, then the rank is zero. If the element lies in between two contained elements, then linear interpolation is used and a non integer value is returned.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_rms)
<div class='gama-keyword-style' id ='413_34_1673_operator-rms'></div>
### `rms` ## {#rms}

#### Possible use:  ## {#possible-use}
  * `int` **`rms`** `float` --->  `float` 

#### Result:  ## {#result}
Returns the RMS (Root-Mean-Square) of a data sequence. The RMS of data sequence is the square-root of the mean of the squares of the elements in the data sequence. It is a measure of the average size of the elements of a data sequence.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_skew)
<div class='gama-keyword-style' id ='413_35_1674_operator-skew'></div>
### `skew` ## {#skew}

#### Possible use:  ## {#possible-use}
  *  **`skew`** (`container`) --->  `float`
  * `float` **`skew`** `float` --->  `float` 

#### Result:  ## {#result}
Returns the skew of a data sequence./nReturns the skew of a data sequence, which is moment(data,3,mean) / standardDeviation3

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_student_area)
<div class='gama-keyword-style' id ='413_36_1675_operator-student-area'></div>
### `student_area` ## {#student-area}

#### Possible use:  ## {#possible-use}
  * `float` **`student_area`** `int` --->  `float` 

#### Result:  ## {#result}
Returns the area to the left of x in the Student T distribution with the given degrees of freedom.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_student_t_inverse)
<div class='gama-keyword-style' id ='413_37_1676_operator-student-t-inverse'></div>
### `student_t_inverse` ## {#student-t-inverse}

#### Possible use:  ## {#possible-use}
  * `float` **`student_t_inverse`** `int` --->  `float` 

#### Result:  ## {#result}
Returns the value, t, for which the area under the Student-t probability density function (integrated from minus infinity to t) is equal to x.

[Top of the page](references#table-of-contents)
  	
    	
----
[//]: # (keyword|operator_variance)
<div class='gama-keyword-style' id ='413_38_547_operator-variance'></div>
### `variance` ## {#variance}

#### Possible use:  ## {#possible-use}
  *  **`variance`** (`float`) --->  `float`
  *  **`variance`** (`int`, `float`, `float`) --->  `float` 

#### Result:  ## {#result}
Returns the variance of a data sequence. That is (sumOfSquares - mean*sum) / size with mean = sum/size./nReturns the variance from a standard deviation.

[Top of the page](references#table-of-contents)
  	

----

## Skills ## {#skills}
	

----

## Statements ## {#statements}
		
	
----

## Species ## {#species}
	
	
----

## Architectures  ## {#architectures}
	
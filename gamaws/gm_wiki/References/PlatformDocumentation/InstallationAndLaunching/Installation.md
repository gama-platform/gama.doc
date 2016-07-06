
# Installation ## {#installation}

GAMA 1.7 comes in 5 different versions (32 & 64 bits for Windows & Linux, and 64 bits for MacOS X). You first need to determine which version to use (it depends on your computer, which may, or not, support 64 bits instructions, but also on the version of Java already installed, as the number of bits of the two versions must match).

You can then download the right version from the [Downloads page](wikionly#Download), expand the zip file wherever you want on your machine, and [launch GAMA](references#Launching).


## Table of contents  ## {#table-of-contents}

* [Installation](references#installation)
	* [System Requirements](references#system-requirements)
	* [Installation of Java](references#installation-of-java)
		* [On MacOS X](references#on-macos-x)
		* [On Windows](references#on-windows-7--8-64-bits)
		* [On Ubuntu & Linux](references#on-ubuntu--linux)


## System Requirements ## {#system-requirements}

GAMA 1.7 requires that Java 1.7 be installed on your machine, approximately 200MB of disk space and a minimum of 4GB of RAM (to increase the portion of memory usable by GAMA, please refer to [these instructions](references#Troubleshooting#Memory_problems){.internal-link-anchor}).

## Installation of Java ## {#installation-of-java}

On all environments, the recommended Java Virtual Machine under which GAMA has been tested is the one distributed by Oracle (http://www.java.com/en/download/manual.jsp). It may work with others — or not. For better performances, you may also want to install the JDK version of the JVM (and not the standard JRE), although is it not mandatory  (GAMA should run fine, but slower, under a JRE).

### On MacOS X  ## {#on-macos-x}
The latest version of GAMA requires a JVM (or JDK or JRE) compatible with Java 1.7 to run. 

_Note for GAMA 1.6.1 users: if you plan to keep a copy of GAMA 1.6.1, you will need to have both Java 1.6 (distributed by Apple) and Java 1.7 (distributed by Oracle) installed at the same time. Because of this bug in SWT (https://bugs.eclipse.org/bugs/show_bug.cgi?id=374199), GAMA 1.6.1 will not run correctly under Java 1.7 (all the displays will appear empty). To install the JDK 1.6 distributed by Apple, follow the instructions here : http://support.apple.com/kb/DL1572. Alternatively, you might want to go to https://developer.apple.com/downloads and, after a free registration step if you're not an Apple Developer, get the complete JDK from the list of downloads._

### On Windows ## {#on-windows}
Please notice that, by default, Internet Explorer and Chrome browsers will download a 32 bits version of the JRE. Running GAMA 32 bits for Windows is ok, but you may want to download the latest JDK instead, in order to both improve the performances of the simulator and be able to run GAMA 64 bits.

  * To download the appropriate java version, follow this link: http://www.java.com/en/download/manual.jsp
  * Execute the downloaded file
  * You can check that a **Java\\jre7** (or jre8) folder has been installed at the location **C:\\Program Files\\**

In order for Java to be found by Windows, you may have to modify environment variables:

  * Go to the **Control Panel**
  * In the new window, go to **System**
  * On the left, click on **Advanced System parameters**
  * In the bottom, click on **Environment Variables**
  * In System Variables, choose to modify the **Path** variable
  * At the end, add **;C:\\Program Files\\Java\\jre7\\bin** (or jre8\\bin)

### On Ubuntu & Linux ## {#on-ubuntu-linux}

To have a complete overview of java management on Ubuntu, have a look at:

  * [Ubuntu Java documentation](https://help.ubuntu.com/community/Java)
  * for French speaking users: http://doc.ubuntu-fr.org/java#installations_alternatives

Basically, you need to do:
```
sudo add-apt-repository ppa:webupd8team/java
sudo apt-get update
sudo apt-get install oracle-java7-installer (or oracle-java8-installer)
```

You can then switch between java version using:
```
sudo update-alternatives --config java
```

See [the troubleshooting page](references#Troubleshooting#Ubuntu){.internal-link-anchor} for more information on workaround for problems on Unbuntu.
### On Windows 7 & 8 64 bits ## {#on-windows-7-8-64-bits}
Please notice that, by default, Internet Explorer and Chrome browsers will download a 32 bits version of the JRE. Running GAMA 32 bits for Windows is ok, but you may want to download the latest JDK instead, in order to both improve the performances of the simulator and be able to run GAMA 64 bits.

  * To download the appropriate java version, follow this link: [Java download section](http://www.java.com/fr/download/manual.jsp)
  * Execute the downloaded file
  * You can check that a **Java\\jre7** folder has been installed at the location **C:\\Program Files\\**

In order for Java to be found by Windows, you may have to modify environment variables:

  * Go to the **Control Panel**
  * In the new window, go to **System**
  * On the left, click on **Advanced System parameters**
  * In the bottom, click on **Environment Variables**
  * In System Variables, choose to modify the **Path** variable
  * At the end, add **;C:\\Program Files\\Java\\jre7\\bin**
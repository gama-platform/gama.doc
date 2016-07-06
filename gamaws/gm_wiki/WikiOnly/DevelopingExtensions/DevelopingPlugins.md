# Developing Plugins ## {#developing-plugins}



This page details how to create a new plug-in in order to extend the GAML language with new skills, species, displays or operators.
It also details how to create a plug-in that can be  uploaded on an update site and can be installed into the GAMA release.
We consider here that the developer version of GAMA has been installed (as detailled in [this page](wikionly#InstallingGitVersion)).






## Creation of a plug-in ## {#creation-of-a-plug-in}

Here are detailled steps to create and configure a new GAMA plug-in.

  * File > New > Project > plug-in project
  * In the "New plug-in Project" / "Plug-in project" window:
    * Choose as **name** « name\_of\_the\_plugin » (or anything else)
    * Check "Use défaut location"
    * Check "Create a Java Project"
    * The project should be targeted to run with Eclipse
    * working set is unchecked
    * Click on "Next"
  * In the "New plug-in Project" / "Content" window:
    * Id : could contain the name of your institution and/or your project, e.g. « irit.maelia.gaml.additions »
    * version 1.0.0.qualifier (this latter mention is important if you plan on distributing the plugin on GAMA update site)
    * Name « Additions to GAML from Maelia project »
    * Uncheck "Generate an activator, a Java class that controls the plug-in's life cycle" ,
    * Uncheck "This plug-in will make contributions to the UI"
    * Check "No" when its asks "Would you like to create a rich client application ?"
    * Click on "Next"
  * In the "New plug-in Project" / "Templates" window:
    * Uncheck "Create a plug-in using one of the templates"
    * Click on "Finish"

Your plug-in has been created.

  * Edit the file "Manifest.MF":
    * Overview pane:
      * check « This plug-in is a singleton »
    * Dependencies pane:
      * add (at least minimum) the three plug-ins "msi.gama.core", "msi.gama.ext" and "msi.gama.processor" in the "Required Plug-ins". When you click on "Add", a new window will appear without any plug-in. Just write the beginning of the plug-in name in the text field under "Select a plug-in".
    * Runtime pane:
      * In exported Packages: nothing (but when you will have implemented new packages in the plug-in you should add them their)
      * Add in the classpath all the additional libraries (.jar files) used in the project.
    * Extensions pane:
      * "Add" "gaml.grammar.addition"
    * Save the file. This should create a "plugin.xml" file.

  * Select the project and in menu Project > Properties:
    * Java Compiler  > Annotation Processing: check "Enable project specific settings", then in "Generated Source Directory", change ".apt\_generated" in "gaml",
    * Java Compiler  > Annotation Processing > Factory path: check "Enable project specific settings", then "Add Jars" and choose "msi.gama.processor/processor/plugins/msi.gama.processor.1.4.0.jar"
    * Close the menu. It should compile the project and create the `gaml` directory.
    * Return in the Project > Properties Menu.
    * In Java Buildpath  > Source, check that the gaml directory has been added. Otherwise click on Add Folder and select the gaml directory


The plug-in is ready to accept any addition to the GAML language, e.g. skills, actions, operators.

Do not forget to export the created packages that could be used by "clients", especially the packages containing the code of the additions (in the plugin.xml of the new project, tab "Runtime").

To test the plug-in and use it into GAMA, developers have to define a new feature project containing your plugin and its dependencies, and adds this feature to the existing product (or a new .product file of your own).
The use of feature is also mandatory to define a plug-in that can be uploaded on the update site and can be installed in the release of GAMA.





## Creation of a feature ## {#creation-of-a-feature}

A feature is an Eclipse project dedicated to gather one or several plug-ins to integrate them into a product or to deploy them on the update site and install them from the GAMA release (a feature is mandatory in this case).

Here are detailled steps to create and configure a new feature.

  * File > New > Feature project (or File > New > Project... then  Plug-in Development > Feature Project)
  * In Feature properties
    * Choose a project name (e.g. "institution.gama.feature.pluginsName")
    * Click on "Next"
  * In Referenced Plug-ins and fragments
    * Check "Initialize from the plug-ins list:"
    * Choose the plug-ins that have to be gathered in the feature
    * Click on "Finish"
  * A new project has been created. The "feature.xml" file will configure the feature.
    * In "Information pane":
      * You can add description of the various plug-ins of the feature, define the copyright notice and the licence.
    * In "Plug-ins and Fragments"
      * In the Plug-ins and Fragments, additional plug-ins can be added.





## Addition of a feature to the product ## {#addition-of-a-feature-to-the-product}

In the product, e.g. `gama1.6.1.feature_based_Eclipse3_8_2_release.product` in the `msi.gama.application` project:
  * Dependencies pane
    * Click on Add button
    * In the window select the feature
    * Click on OK.

**Remark:** To check whether the new plug-in has been taken into account by GAMA, after GAMA launch, it should appear in the Eclipse console in a line beginning by ">> GAMA bundle loaded in ".






## How to make a plug-in available as an extension for the GAMA release ## {#how-to-make-a-plug-in-available-as-an-extension-for-the-gama-release}

Once the plug-in has been tested in the GAMA SVN version, it can be made available for GAMA release users.

First, the `update_site` should be checked out from the SVN repository:
  * File > New > Other... > SVN > Project from SVN
  * In Checkout Project from SVN repository
    * Use existing repository location (it is the same location as for the GAMA code)
    * Next
  * In Select resource:
    * Browse
      * choose svn > update\_site
    * Finish
  * Finish

Now the update\_site project is available in the project list (in Package Explorer).
The sequel describes how to add a new feature to the update site.
  * Open the `site.xml` file
  * In update site Map:
    * Click on Extensions
    * click on the Add Feature... button
      * Choose the feature to be added
      * It should appear in Extensions
    * Select the added feature and click on the Synchronize... button
      * Check Synchronize selected features only
      * Finish
    * Select the added feature and click on the Build button
  * All the files and folder of the update\_site project have been modified.
  * Commit all the modifications on the SVN repository
    * Richt-click on the project, Team > Update
    * Richt-click on the project, Team > Commit...

The plug-in is now available as an extension from the GAMA release.
More details about the update of the GAMA realease are available [on the dedicated page](references#Updating).
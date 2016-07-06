##git clone --mirror https://github.com/gama-platform/gama/wiki.git
sudo rm -r Tutorials
sudo rm -r References
sudo rm -r Community
sudo rm -r WikiOnly

cd ../gama_doc_17.wiki.git
git fetch
GIT_WORK_TREE=../gm_wiki/ git checkout -f master
git rev-parse --short master


cd ../gm_wiki
sudo cp ../keywords.xml ./
sudo mv WikiOnly/References.md WikiOnly/ReferencesWikiOnly.md
sudo mv Tutorials/Tutorials Tutorials/ThematicTutorials
sudo mv Tutorials/Tutorials.md Tutorials/ThematicTutorials.md
sudo mv References/ModelLibrary/Tutorials References/ModelLibrary/ModelLibraryTutorials
sudo mv References/ModelLibrary/Tutorials.md References/ModelLibrary/ModelLibraryTutorials.md
sudo mv Tutorials/LearnGAMLStepByStep/OptimizingModelsSection.md Tutorials/LearnGAMLStepByStep/OptimizingModels.md
sudo mv Tutorials/LearnGAMLStepByStep/OptimizingModels/OptimizingModels.md Tutorials/LearnGAMLStepByStep/OptimizingModels/OptimizingModelsSelection.md

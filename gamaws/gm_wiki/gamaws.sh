cp ../localPath.txt ./
cp ../push_wiki.sh ./
sudo sh push_wiki.sh 
sudo sh restore_some_files.sh
sudo java -jar GamaWSBuildDB-1.0.jar
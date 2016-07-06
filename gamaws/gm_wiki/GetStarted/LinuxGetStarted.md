### On Ubuntu & Linux ## {#on-ubuntu-linux}

To have a complete overview of java management on Ubuntu, have a look at:

  * [Ubuntu Java documentation](https://help.ubuntu.com/community/Java)
  * for French speaking users: http://doc.ubuntu-fr.org/java#installations_alternatives

Basically, you need to do:
```
sudo add-apt-repository ppa:webupd8team/java
sudo apt-get update
sudo apt-get install oracle-java7-installer
```

You can then switch between java version using:
```
sudo update-alternatives --config java
```

See [the troubleshooting page](references#Troubleshooting#on-ubuntu-linux-systems){.internal-link-anchor}{.internal-link-anchor} for more information on workaround for problems on Unbuntu.
subitizingOnline
================


Description
-----------

This is example code for a classic psychological experiment on subitizing. The code serves as an example of how to create a simple online experiment.


Requirements
------------

A server with a PHP installation


Installation
------------

Modify the ```$data_directory``` variable in ```index.php```, ```cf.php```, and ```mt.php``` to point to a directory on your server where data can be written to. Inside that directory, create two subdirectories called ```cf```, where the CrowdFlower data will be stored, and ```mt```, where the Mechanical Turk data will be stored. Then create empty log files in each directory with global write permissions, e.g.:

```
touch cf/log
touch mt/log
chmod 666 cf/log
chmod 666 mt/log
```

Upload the code to your server. Then visit ```yourserver.com/foo/bar/index.php?pf=mt``` for Mechanical Turk or ```index.php?pf=cf``` for CrowdFlower. The only difference between the two is the wording displayed in the instruction and experiment complete pages.


License
-------

This repository is licensed under the terms of the MIT License.

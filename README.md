subitizingOnline
================


Description
-----------

This is example code for a classic psychological experiment on subitizing. The code serves as an example of how to create a simple online experiment.


Installation
------------

Modify the ```$data_directory``` variable in ```index.php```, ```cf.php```, and ```mt.php``` to point to a directory on your server where data can be written to.

Upload the code to a server that has a PHP installation. Then visit ```yourserver.com/foo/bar/index.php?pf=mt``` for Mechanical Turk or ```index.php?pf=cf``` for CrowdFlower. The CrowdFlower example generates and displays a code at the end that participants can use to claim payment.


License
-------

This repository is licensed under the terms of the MIT License.

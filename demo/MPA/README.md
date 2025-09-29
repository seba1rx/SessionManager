# MPA: Multi Page Application demo

In a MPA website you have multiple pages, for instance:

index.php -> public
products.php -> public
contact_us.php -> public
admin_pannel.php -> private

In this demo you have 3 "app" pages:

+ index.php -> public
+ pade2.php -> public
+ private.php -> private


You can see an implementation of the SessionAdmin class in the file MyMPASessionAdmin.php

Each "app" page needs to include the "required.php" file as it has the file that will instantiate the session
1) composer install
2) ./vendor/bin/doctrine orm:schema-tool:create
3) php ./index.php

This code is not reproducing the issue I'm looking for yet. The result I'm trying to achieve is the creation of
duplicate Books - instead of creating 5, there should be 10. Currently, the code creates:

1 Student
5 Books
3 Gadgets

Expected Result to reproduce the issue we're seeing at work:
1 Student
10 Books
3 Gadgets
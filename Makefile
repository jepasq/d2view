default: check

# NoGameFiles : mainly for CI purpose. See PaginationTest class for more.
check-ngf:
	phpunit --group NoGameFiles test/ 

check:
	phpunit -d memory_limit=-1 test/ 

check-pag:
	phpunit -d memory_limit=-1 test/PaginationTest.php

check-ptree:
	phpunit --filter testPrintTree test/D2viewTest.php

check-bread:
	phpunit test/BreadcrumbTest.php

check-path:
	phpunit test/PathTest.php



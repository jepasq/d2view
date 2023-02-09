default: check

check:
	phpunit -d memory_limit=-1 test/ 

check-pag:
	phpunit -d memory_limit=-1 test/PaginationTest.php

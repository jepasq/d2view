default: check

check:
	phpunit -d memory_limit=-1 test/ 

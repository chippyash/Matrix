#!/bin/bash
cd ~/Projects/chippyash/source/Matrix
vendor/bin/phpunit -c test/phpunit.xml --testdox-html contract.html test/
tdconv -t "Chippyash Matrix" contract.html docs/Test-Contract.md
rm contract.html


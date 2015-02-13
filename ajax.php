<?php

$login = (new \util\Request())->getPostValue('userLogin');
echo $login;
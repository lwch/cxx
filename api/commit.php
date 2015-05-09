<?php
require __DIR__.'/common.php';

redis()->incr($_REQUEST['id']);

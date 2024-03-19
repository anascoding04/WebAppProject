<?php

$hash = hash("sha256", $_POST['hash_input']);
echo $hash;
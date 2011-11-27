--TEST--
Check for eio_chown function basic behaviour
--FILE--
<?php 
error_reporting(E_WARNING);
$temp_filename = "eio-temp-file.tmp";

touch($temp_filename);

function my_eio_chown_cb($data, $result) {
	var_dump($result);
}

eio_chown($temp_filename);
eio_event_loop();
eio_chown($temp_filename, -1, -1);
eio_event_loop();
eio_chown($temp_filename, posix_getuid(), -1, EIO_PRI_DEFAULT, "my_eio_chown_cb");
eio_event_loop();
?>
--CLEAN--
<?php
@unlink($temp_filename);
?>
--EXPECTF--
Warning: eio_chown() expects at least 2 parameters, 1 given in %s on line %a
Warning: eio_chown(): invalid uid and/or gid in %s on line %a
int(0)

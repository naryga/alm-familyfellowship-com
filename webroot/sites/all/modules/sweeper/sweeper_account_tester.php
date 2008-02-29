<?php
	include_once("sweeper_account.php");
	$sweep = new SweeperAccount;
	$expiredate=(date("Y")+1)."-".date("m")."-".(date("d"))."+".date(H).":".date(i).":00";
	$added = $sweep->addAccount("biby3","test123","biby2@jivy.com","bi","by");
	echo "<h1>$added</h1>";
	$deleted = $sweep->deleteAccount("biby3");
	echo "<h1>$deleted</h1>";
	$sweep->destruct();
	unset($sweep);
?>
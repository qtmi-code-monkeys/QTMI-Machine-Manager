<?php
include_once 'global_includes.php';

$customer = new Customer($dbLink);
$customer->getCustomers();
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<HTML>
<HEAD>
<TITLE>A simple frameset document</TITLE>
</HEAD>
<FRAMESET cols="20%, 80%">
  <FRAMESET rows="100, 200">
      <FRAME src="homepage.php">
      <FRAME src="http://10.10.10.10">
  </FRAMESET>
  <NOFRAMES>
      <P>This frameset document contains:
      <UL>
         <LI><A href="contents_of_frame1.html">Some neat contents</A>
         <LI><IMG src="contents_of_frame2.gif" alt="A neat image">
      </UL>
  </NOFRAMES>
</FRAMESET>
</HTML>
<?php 
class JSWidgets extends QtmiBaseClass {

   function __construct() {
      // print "In SubClass constructor\n";
   }

   function __destruct() {
      // parent::__destruct();
      // print "In SubClass deconstructor\n";
   }

   function getCustomerContactsPopupWindow() {
?>   
	<script language="javascript">
	var myWindow;

	function openCustomerContactsWin(c1_name, c1_number, c1_email,
						c2_name, c2_number, c2_email,
						c3_name, c3_number, c3_email) {
	    myWindow = window.open("", "myWindow", "width=200, height=300");
	    if(c1_email != "None Specified") c1_email = "<a href='mailto:"+c1_email+"' >"+c1_email+"</a>";
	    if(c2_email != "None Specified") c2_email = "<a href='mailto:"+c2_email+"' >"+c2_email+"</a>";
	    if(c3_email != "None Specified") c3_email = "<a href='mailto:"+c3_email+"' >"+c3_email+"</a>";
	    
	    output1 = "<p>1. <br/> Name: "+c1_name+"</br> Number: "+c1_number+"</br> Email: "+c1_email+"</br></p>";
	    output1 += "<p>2. <br/> Name: "+c2_name+"</br> Number: "+c2_number+"</br> Email: "+c2_email+"</br></p>";
	    output1 += "<p>3. <br/> Name: "+c3_name+"</br> Number: "+c3_number+"</br> Email: "+c3_email+"</br></p>";
	    //alert(output1);
	    myWindow.document.write(output1);
	}

	function closeCustomerContactsWin() {
	    myWindow.close();
	}
	</script>
<?php
   }

}


?>
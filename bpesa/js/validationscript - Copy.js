// validate login form
function validateLoginForm() {
    var x = document.forms["myForm"]["fname"].value;
    if (x == null || x == "") {
        alert("Name must be filled out");
        return false;
    }
}
//New Provider Validate 
function validateForm(){

var x=document.forms["providerFrom"]["userName"].value;

if (x==null || x==""){
  alert("Please fill in a username.");
  return false;
}

var x=document.forms["providerFrom"]["password"].value;

if (x==null || x==""){

  alert("Please fill in a Password.");
  return false;
}

var x=document.forms["providerFrom"]["contactName"].value;

if (x==null || x==""){

  alert("Please fill in a Contact Persons Name.");
  return false;
}

var x=document.forms["providerFrom"]["email"].value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");

if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
  alert("Please Enter a valid email address");
  return false;
  }
}

//Provider Add course validate 
function validateForm2()
{
   if(document.AddCourse.courseName.value == "")
   {
     alert( "Please provide the course name." );
     document.AddCourse.courseName.focus() ;
     return false;
   }
   
   if(document.AddCourse.courseDescription.value == "")
   {
     alert( "Please provide the course description." );
     document.AddCourse.courseDescription.focus() ;
     return false;
   }
   
   if(document.AddCourse.courseStartDate.value === "")
   {
     alert( "Please enter the course Start Date. If the course runs for a full year, simply enter 1 Jan" );
     document.AddCourse.courseStartDate.focus();
     return false;
   }
   
   if(document.AddCourse.courseEndDate.value === "")
   {
     alert( "Please enter the course End Date. If the course runs for a full year, simply enter 31 Dec" );
     document.AddCourse.courseEndDate.focus();
     return false;
   }

   if(document.AddCourse.courseCapacity.value === "")
   {
	 alert( "Please enter the number of users per course" );
     document.AddCourse.courseCapacity.focus();
     return false;    
	 
   }else {
	var value = document.AddCourse.courseCapacity.value;
    var isNumber = parseInt(Number(value));
	   if(!isNaN(isNumber)) {
		 alert( "Please enter the number of users per course" );
		 document.AddCourse.courseCapacity.focus();
		 return false;     
	   }
   }
   
   if(document.AddCourse.coursePrice.value === "")
   {
     alert( "Please enter the price." );
     document.AddCourse.coursePrice.focus();
     return false;
   }
   
   if(document.AddCourse.online.value === ""){
	 alert( "Please select if course is online or not" );
     document.AddCourse.coursePrice.focus();
     return false;
	 
   }else{
	   //check the vale of the 
	   var onlinestatus = $('input[name="online"]:checked').val();
	   if(onlinestatus == 'N'){
		  if( document.AddCourse.courseLocation.value === "" )
		  {
			 alert( "Please enter the course location." );
			 document.AddCourse.courseLocation.focus();
			 return false;
		  }
		  if( document.AddCourse.province.value === "N/A" )
		  {
			 alert( "Please select your province." );
			 document.AddCourse.province.focus();
			 return false;
		  }
	   }
   }
  
}

//new providers register providerFrom
function validateForm3() {

  if(document.providerFrom.userName.value == "" ){
     alert( "Please enter your username." );
     document.providerFrom.userName.focus() ;
     return false;
  }

  if( document.providerFrom.password.value == "" ){
     alert( "Please enter your password." );
     document.providerFrom.password.focus() ;
     return false;
   }

  if( document.providerFrom.companyName.value == "" ){
     alert( "Please enter your company name." );
     document.providerFrom.companyName.focus() ;
     return false;
   }

  if( document.providerFrom.contactName.value == "" ){
     alert( "Please enter a contact person." );
     document.providerFrom.contactName.focus() ;
     return false;
  }

   var x=document.forms["providerFrom"]["email"].value;
   var atpos=x.indexOf("@");
   var dotpos=x.lastIndexOf(".");
  if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length){

     alert("Please Enter a valid email address");
     return false;
  }

  if( document.providerFrom.contactNumber.value == "" ){
     alert( "Please enter a telephone number." );
     document.providerFrom.contactNumber.focus() ;
     return false;
   }
}

//new leaner register userForm
function validateForm4() {

  if( document.userForm.userName.value == "" ){
    alert( "Please enter a username" );
    document.userForm.userName.focus() ;
    return false;
  }

  if( document.userForm.password.value == "" ){
    alert( "Please enter a password" );
    document.userForm.password.focus() ;
    return false;
  }

  if( document.userForm.name.value == "" ){
    alert( "Please enter your name" );
    document.userForm.name.focus() ;
    return false;
  }

  if( document.userForm.surName.value == "" ){
    alert( "Please enter your surname" );
    document.userForm.surName.focus() ;
    return false;
  }

  if( document.userForm.idNumber.value == "" ){
    alert( "Please enter your ID number" );
    document.userForm.idNumber.focus() ;
    return false;
  }

  if( document.userForm.ContactNumber.value == "" ){
    alert( "Please enter your contact number" );
    document.userForm.ContactNumber.focus() ;
    return false;
  }

  var x=document.forms["userForm"]["userEmail"].value;
  var atpos=x.indexOf("@");
  var dotpos=x.lastIndexOf(".");
  if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length){
    alert("Please Enter a valid email address");
    return false;
  }

  if( document.userForm.userContactNumber.value == "" ){
    alert( "Please enter a contact number");
    document.userForm.userContactNumber.focus() ;
    return false;
  }

}

//new vendors register vendorForm
function validateForm5()
{
  if( document.vendorForm.userName.value == "" ){
    alert( "Please enter a username" );
    document.vendorForm.userName.focus() ;
    return false;
  }

  if( document.vendorForm.password.value == "" ){
    alert( "Please enter a password" );
    document.vendorForm.password.focus() ;
    return false;
  }

  if( document.vendorForm.realName.value == "" ){
    alert( "Please enter your actual name" );
    document.vendorForm.realName.focus() ;
    return false;
  }

  var x=document.forms["vendorForm"]["userEmail"].value;
  var atpos=x.indexOf("@");
  var dotpos=x.lastIndexOf(".");
  if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
    alert("Please Enter a valid email address");
    document.vendorForm.userEmail.focus() ;
    return false;
  }

  if( document.vendorForm.userContactNumber.value == "" ){
    alert( "Please enter a contact number");
    document.vendorForm.userContactNumber.focus() ;
    return false;
  }

}

//Provider Add venue 
function validateForm8()
{
   if( document.providerAddVenue.venueName.value == "" )
   {
     alert( "Please provide the venue name.");
     document.providerAddVenue.venueName.focus() ;
     return false;
   }

  var x=document.forms["providerAddVenue"]["venueEmail"].value;
  var atpos=x.indexOf("@");
  var dotpos=x.lastIndexOf(".");
  if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
    alert("Please Enter a valid email address");
    document.providerAddVenue.venueEmail.focus() ;
    return false;
  }

  if( document.providerAddVenue.venueTel.value == "" )
  {
     alert( "Please provide a venue telephone number." );
     document.providerAddVenue.venueTel.focus();
     return false;
  }

  if( document.providerAddVenue.venueLocation.value == "" )
  {
     alert( "Please provide venue location." );
     document.providerAddVenue.venueLocation.focus();
     return false;
  }
      
   var isNumber = document.providerAddVenue.venueCapacity.value;
   if (isNaN(isNumber)) {
     alert( "Please enter a valid number of venue capacity" );
     document.providerAddVenue.venueCapacity.focus();
     return false;     
   } 
   else if(  document.providerAddVenue.venueCapacity.value == "" ) {
     alert( "Please enter a valid number of venue capacity" );
     document.providerAddVenue.venueCapacity.focus();
     return false;
   } else {
     return true;  
   }

  if( document.providerAddVenue.province.value == "N/A" )
  {
     alert( "Please select your province." );
     document.providerAddVenue.province.focus();
     return false;
  }else{

    return true;
  }

}

function validateForgotPassword() {
var x=document.forgotForm.userEmail.value;
  var atpos=x.indexOf("@");
  var dotpos=x.lastIndexOf(".");
  if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
    alert("Please Enter a valid email address");
    document.forgotForm.userEmail.focus() ;
    return false;
  }
}

function validateFormBooking() {
if( document.bookForm.numberOfbookings.value == "" )
  {
    alert( "Please enter the number of attendees");
    document.bookForm.numberOfbookings.focus() ;
    return false;
  } 
}

function validateForm6() {
   if( document.operatorForm.userName.value == "" )
   {
     alert( "Please enter your user name." );
     document.operatorForm.userName.focus() ;
     return false;
   }

   if( document.operatorForm.password.value == "" )
   {
     alert( "Please enter your password." );
     document.operatorForm.password.focus() ;
     return false;
   }

   if( document.operatorForm.companyName.value == "" )
   {
     alert( "Please enter your company name." );
     document.operatorForm.companyName.focus() ;
     return false;
   }

   if( document.operatorForm.companyProfile.value == "" )
   {
     alert( "Please enter a company profile." );
     document.operatorForm.companyProfile.focus() ;
     return false;
   }

   if( document.operatorForm.companyWebsite.value == "" )
   {
     alert( "Please enter a company website." );
     document.operatorForm.companyWebsite.focus() ;
     return false;
   }

   if( document.operatorForm.name.value == "" )
   {
     alert( "Please enter a contact person name." );
     document.operatorForm.name.focus() ;
     return false;
   }

   if( document.operatorForm.surName.value == "" )
   {
     alert( "Please enter a contact person surname." );
     document.operatorForm.surName.focus() ;
     return false;
   }

   if( document.operatorForm.contactNumber.value == "" )
   {
     alert( "Please enter a contact number." );
     document.operatorForm.contactNumber.focus() ;
     return false;
   }

   var x=document.forms["operatorForm"]["email"].value;
   var atpos=x.indexOf("@");
   var dotpos=x.lastIndexOf(".");
   if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
   {
     alert("Please enter a valid email address");
     return false;
   }
}

function validateForm7()
{
   if( document.operatorForm.userName.value == "" )
   {
     alert( "Please enter your user name." );
     document.operatorForm.userName.focus() ;
     return false;
   }
}

//operator add contact person
function validateForm9() {
  if( document.operatorAddContactForm.name.value == "" )
  {
    alert( "Please enter your name" );
    document.operatorAddContactForm.name.focus() ;
    return false;
  }
  if( document.operatorAddContactForm.surName.value == "" )
  {
    alert( "Please enter your surname" );
    document.operatorAddContactForm.surName.focus() ;
    return false;
  }
  if( document.operatorAddContactForm.contactNumber.value == "" )
  {
    alert( "Please enter a contact number" );
    document.operatorAddContactForm.contactNumber.focus() ;
    return false;
  }
  var x=document.forms["operatorAddContactForm"]["email"].value;
  var atpos=x.indexOf("@");
  var dotpos=x.lastIndexOf(".");
  if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
    alert("Please enter a valid email address");
    return false;
  }

}
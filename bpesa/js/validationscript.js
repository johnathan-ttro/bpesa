// validate login form
function validateLoginForm() {
    var userName = document.forms["loginForm"]["userName"].value;
    if (userName === null || userName === "") {
        alert("Please provide your username");
        return false;
    }
    var passwd = document.forms["loginForm"]["password"].value;
    if (passwd === null || passwd === "") {
        alert("Please provide your password");
        return false;
    }
}
// validate training provider form
function validateTrainingProviderForm() {
    var userName = document.forms["trainingProviderForm"]["userName"].value;
    if (userName === null || userName === "") {
        alert("Please provide your username");
        return false;
    }

    var passwd = document.forms["trainingProviderForm"]["password"].value;
    if (passwd === null || passwd === "") {
        alert("Please provide your password");
        return false;
    }

    var companyName = document.forms["trainingProviderForm"]["companyName"].value;
    if (companyName === null || companyName === "") {
        alert("Please provide company name");
        return false;
    }

    var trainingCatergory = document.forms["trainingProviderForm"]["trainingCatergory"].value;
    if (trainingCatergory === "other") {
        alert("Please select your category");
        return false;
    }
    var contactName = document.forms["trainingProviderForm"]["contactName"].value;
    if (contactName === null || contactName === "") {
        alert("Please select contact name");
        return false;
    }

    var email = document.forms["trainingProviderForm"]["email"].value;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 

    
     if (email === null || email === "") {
        alert("Please provide email address");
        return false;
    }else {
      if(email.match(mailformat)) {
        
      }else{
        alert("You have entered an invalid email address!");
        return false;
      }
    }//End of email check

    var contactNumber = document.forms["trainingProviderForm"]["contactNumber"].value;
    if (contactNumber === null || contactNumber === "") {
        alert("Please select contact number");
        return false;
    }

    var location = document.forms["trainingProviderForm"]["location"].value;
    if (location === null || location === "") {
        alert("Please provide your location");
        return false;
    }

    var companyProfile = document.forms["trainingProviderForm"]["companyProfile"].value;
    if (companyProfile === null || companyProfile === "") {
        alert("Please provide company profile");
        return false;
    }

    var companyWebsite = document.forms["trainingProviderForm"]["companyWebsite"].value;
    if (companyWebsite === null || companyWebsite === "") {
        alert("Please provide company website");
        return false;
    }

}

//validate learner form
function validateLearnerForm() {
    var userName = document.forms["learnerForm"]["userName"].value;
    if (userName === null || userName === "") {
        alert("Please provide your username");
        return false;
    }

    var passwd = document.forms["learnerForm"]["password"].value;
    if (passwd === null || passwd === "") {
        alert("Please provide your password");
        return false;
    }

    var firstname = document.forms["learnerForm"]["name"].value;
    if (firstname === null || firstname === "") {
        alert("Please provide firstname");
        return false;
    }

    var lastname = document.forms["learnerForm"]["surName"].value;
    if (lastname === null || lastname === "") {
        alert("Please provide your lastname");
        return false;
    }
    var idNumber = document.forms["learnerForm"]["idNumber"].value;
    if (idNumber === null || idNumber === "") {
        alert("Please provide your ID number");
        return false;
    }

    var employmentStatus = document.forms["learnerForm"]["employmentStatus"].value;
    if (employmentStatus === null || employmentStatus === "") {
        alert("Please select your employment status");
        return false;

    }else{
      if(employmentStatus === "yes"){
        var employmentCompany = document.forms["learnerForm"]["employmentCompany"].value;
        if (employmentCompany === null || employmentCompany === "") {
            alert("Please provide your employment company");
            return false;
        }
        var position = document.forms["learnerForm"]["position"].value;
        if (position === null || position === "") {
            alert("Please provide your company position");
            return false;
        }
      }
    }//End of employment status
    var contactNumber = document.forms["learnerForm"]["ContactNumber"].value;
    if (contactNumber === null || contactNumber === "") {
        alert("Please provide your contact number");
        return false;
    }
    var email = document.forms["learnerForm"]["email"].value;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 

    if (email === null || email === "") {
        alert("Please provide your email address");
        return false;
    }else{
       if(email.match(mailformat)) {
        
       }else{
        alert("You have entered an invalid email address!");
        return false;
       }
    }
    var highestEducation = document.forms["learnerForm"]["highestEducation"].value;
    if (highestEducation === 'other') {
        alert("Please select your highest level of education");
        return false;
    }

}

//validate facilities provider form
function validateFacilityproviderForm() {
    var userName = document.forms["facilityproviderForm"]["userName"].value;
    if (userName === null || userName === "") {
        alert("Please provide your username");
        return false;
    }

    var passwd = document.forms["facilityproviderForm"]["password"].value;
    if (passwd === null || passwd === "") {
        alert("Please provide your password");
        return false;
    }

    var fullname = document.forms["facilityproviderForm"]["realName"].value;
    if (fullname === null || fullname === "") {
        alert("Please provide your fullname");
        return false;
    }

    var companyName = document.forms["facilityproviderForm"]["userCompany"].value;
    if (companyName === null || companyName === "") {
        alert("Please provide your company name");
        return false;
    }

    var email = document.forms["facilityproviderForm"]["userEmail"].value;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 

    if (email === null || email === "") {
        alert("Please provide your email");
        return false;
    }else{
      if(email.match(mailformat)) {
        
       }else{
        alert("You have entered an invalid email address");
        return false;
       }
    }

    var contactNumber = document.forms["facilityproviderForm"]["userContactNumber"].value;
    if (contactNumber === null || contactNumber === "") {
        alert("Please provide your contact number");
        return false;
    }

    var websiteurl = document.forms["facilityproviderForm"]["userWebsite"].value;
    if (websiteurl === null || websiteurl === "") {
        alert("Please provide your website address");
        return false;
    }

}
//validate facilities operator form
function validateOperatorForm() {
    var userName = document.forms["operatorForm"]["userName"].value;
    if (userName === null || userName === "") {
        alert("Please provide your username");
        return false;
    }

    var passwd = document.forms["operatorForm"]["password"].value;
    if (passwd === null || passwd === "") {
        alert("Please provide your password");
        return false;
    }

    var companyName = document.forms["operatorForm"]["companyName"].value;
    if (companyName === null || companyName === "") {
        alert("Please provide your company name");
        return false;
    }
    var companyWebsite = document.forms["operatorForm"]["companyWebsite"].value;
    if (companyWebsite === null || companyWebsite === "") {
        alert("Please provide your company website");
        return false;
    }

    var firstname = document.forms["operatorForm"]["name"].value;
    if (firstname === null || firstname === "") {
        alert("Please provide your firstname");
        return false;
    }

    var lastname = document.forms["operatorForm"]["surName"].value;
    if (lastname === null || lastname === "") {
        alert("Please provide your lastname");
        return false;
    }

    var contactNumber = document.forms["operatorForm"]["contactNumber"].value;
    if (contactNumber === null || contactNumber === "") {
        alert("Please provide your contact number");
        return false;
    }

    var email = document.forms["operatorForm"]["email"].value;    
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 

    if (email === null || email === "") {
        alert("Please provide your email");
        return false;
    }else{
       if(email.match(mailformat)) {
        
       }else{
        alert("You have entered an invalid email address");
        return false;
       }
    }

    var regionNames = document.forms["operatorForm"]["regionNames[]"].value;
    var checked = false;
    for(var i=0; i < regionNames.length; i++){
      if(regionNames[i].checked){
        checked = true;
      }
    }

    if(checked=false) {
      alert('Please provide your regional area');
      return false;
    }

}

// Edit forms
function validateEditLearnerForm() {

    var firstname = document.forms["editLearnerForm"]["name"].value;
    if (firstname === null || firstname === "") {
        alert("Please provide firstname");
        return false;
    }

    var lastname = document.forms["editLearnerForm"]["surName"].value;
    if (lastname === null || lastname === "") {
        alert("Please provide your lastname");
        return false;
    }
    var idNumber = document.forms["editLearnerForm"]["idNumber"].value;
    if (idNumber === null || idNumber === "") {
        alert("Please provide your ID number");
        return false;
    }

    var employmentStatus = document.forms["editLearnerForm"]["employmentStatus"].value;
    if (employmentStatus === null || employmentStatus === "") {
        alert("Please select your employment status");
        return false;

    }else{
      if(employmentStatus === "yes"){
        var employmentCompany = document.forms["editLearnerForm"]["employmentCompany"].value;
        if (employmentCompany === null || employmentCompany === "") {
            alert("Please provide your employment company");
            return false;
        }
        var position = document.forms["editLearnerForm"]["position"].value;
        if (position === null || position === "") {
            alert("Please provide your company position");
            return false;
        }
      }
    }//End of employment status
    var contactNumber = document.forms["editLearnerForm"]["ContactNumber"].value;
    if (contactNumber === null || contactNumber === "") {
        alert("Please provide your contact number");
        return false;
    }
    var email = document.forms["editLearnerForm"]["email"].value;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 

    if (email === null || email === "") {
        alert("Please provide your email address");
        return false;
    }else{
       if(!(email.match(mailformat))){
        alert("You have entered an invalid email address");
        return false;
       }
    }
    var highestEducation = document.forms["editLearnerForm"]["highestEducation"].value;
    if (highestEducation === 'other') {
        alert("Please select your highest level of education");
        return false;
    }
}
//Edit provider form
function validateEditOperatorForm() {

    var companyName = document.forms["editOperatorForm"]["companyName"].value;
    if (companyName === null || companyName === "") {
        alert("Please provide your company name");
        return false;
    }

    var content = tinyMCE.get('companyProfile').getContent();

    if (content === null || content === "") {
        alert("Please provide your company profile");
        return false;
    }
    var companyName = document.forms["editOperatorForm"]["companyName"].value;
    if (companyName === null || companyName === "") {
        alert("Please provide your company name");
        return false;
    }

}
//Add contact personform
function validateAddContactForm() {
    var firstname = document.forms["addContactForm"]["name"].value;
    if (firstname === null || firstname === "") {
        alert("Please provide your firstname");
        return false;
    }
    var lastname = document.forms["addContactForm"]["surName"].value;
    if (lastname === null || lastname === "") {
        alert("Please provide your lastname");
        return false;
    }
    var contactNumber = document.forms["addContactForm"]["contactNumber"].value;
    if (contactNumber === null || contactNumber === "") {
        alert("Please provide your contact number");
        return false;
    }
    var email = document.forms["addContactForm"]["email"].value;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 

    if (email === null || email === "") {
        alert("Please provide your email address");
        return false;
    }else{
       if(!(email.match(mailformat))){
        alert("You have entered an invalid email address");
        return false;
       }
    }
}

//Add venue
function validateAddVenueForm() {
    var venueName = document.forms["addVenueForm"]["venueName"].value;
    if (venueName === null || venueName === "") {
        alert("Please provide your venue name");
        return false;
    }
    var email = document.forms["addVenueForm"]["venueEmail"].value;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 

    if (email === null || email === "") {
        alert("Please provide your email address");
        return false;
    }else{
       if(!(email.match(mailformat))){
        alert("You have entered an invalid email address");
        return false;
       }
    }
    var venueTelephone = document.forms["addVenueForm"]["venueTel"].value;
    if (venueTelephone === null || venueTelephone === "") {
        alert("Please provide your venue telephone number");
        return false;
    }
    var venueLocation = document.forms["addVenueForm"]["venueLocation"].value;
    if (venueLocation === null || venueLocation === "") {
        alert("Please provide your venue location");
        return false;
    }
    var content = tinyMCE.get('venueAddress').getContent();
    if (content === null || content === "") {
        alert("Please provide your venue address");
        return false;
    }
    var venueCapacity = document.forms["addVenueForm"]["venueCapacity"].value;
    if (venueCapacity === null || venueCapacity === "") {
        alert("Please provide your venue capacity");
        return false;
    }else{
        if(!isInt(venueCapacity)){
            alert("Please provide a valid number");
            return false;
        }
    }
}

function isInt(value) {
  return !isNaN(value) && 
         parseInt(Number(value)) == value && 
         !isNaN(parseInt(value, 10));
}

//Payment gateway
function validatePaymentGatewayForm() {
    var merchantId = document.forms["paymentgatewayForm"]["merchantId"].value;
    if (merchantId === null || merchantId === "") {
        alert("Please provide your merchant ID");
        return false;
    }
    var merchantKey = document.forms["paymentgatewayForm"]["merchantKey"].value;
    if (merchantKey === null || merchantKey === "") {
        alert("Please provide your merchant key");
        return false;
    }

}
//Payment gateway
function validateFormBooking() {
    var numberOfBookings= document.forms["formBooking"]["numberOfbookings"].value;
    if (numberOfBookings === null || numberOfBookings === "") {
        alert("Please provide the number of bookings");
        return false;
    }
}
//Payment gateway
function validateContactProviderForm() {
    var content = tinyMCE.get('message').getContent();
    if (content === null || content === "") {
        alert("Please write your message before you send");
        return false;
    }
}
//Reply form
function validateReplyForm() {
    var content = tinyMCE.get('message').getContent();
    if (content === null || content === "") {
        alert("Please write your message before you send");
        return false;
    }
}

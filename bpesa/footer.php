 		</div>
  </div>
</div><!-- End of container -->

<footer class="footer">
  <div class="container"></div>
</footer>
<script src="<?php echo HOSTNAME . 'js/jquery.min.js'; ?>"></script>
<script src="<?php echo HOSTNAME . 'js/bootstrap.min.js'; ?>"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="<?php echo HOSTNAME . 'js/validationscript.js'; ?>"></script>

<script>
var CaptchaCallback = function(){
    grecaptcha.render('RecaptchaField1', {'sitekey' : '6Lc36g0TAAAAAHJSq1K6D24krnzhyDrHQXqWCk2e'});
    grecaptcha.render('RecaptchaField2', {'sitekey' : '6Lc36g0TAAAAAHJSq1K6D24krnzhyDrHQXqWCk2e'});
};

$('#defaultId').show();
$('.ItemId').hide();

$( document ).ready(function() {
		
$('#hidden').click('fast', function(){
   $('.ItemId').show();
   $('#defaultId').hide();
});

$('[data-toggle="tooltip"]').tooltip();

$(function(){
$("#otherTrainingCategory").hide();
});

$(function(){
$("#courseStartDate").datepicker();
});

var date = $('#datepicker').datepicker({ dateFormat: 'dd/mm/yy' }).val();
var date2 = $('#datepicker2').datepicker({ dateFormat: 'dd/mm/yy' }).val();
var date3 = $('#courseEndDate').datepicker({ dateFormat: 'dd/mm/yy' }).val();
var date4 = $('#courseStartDate').datepicker({ dateFormat: 'dd/mm/yy' }).val();

$(function(){
$("#datepicker").datepicker();
});

$(function(){
$("#datepicker2").datepicker();
});

$(function(){
$("#courseEndDate").datepicker();
});

$( "#hideOther" ).click(function() {
$( "#hideOther" ).hide();
$( "#otherTrainingCategory").show();
$( "#hideSelectOption" ).hide();
});

$("#profileDatePicker").click(function() {
$( "#datepicker" ).datepicker();
});

$("#courseStartDate").click(function() {
 $("#courseStartDate" ).datepicker();
});

$("#courseEndDate").click(function() {
$( "#courseEndDate" ).datepicker();
});

$("#showFormButton").click(function(){
$("#showEmailForm").toggle("slow");
});

$("#showFormButtonForm").click(function(){
$("#showEmailForm2").toggle("slow");
});

$("#showreportButton1").click(function(){
$("#showreportForm1").toggle("slow");
});

$("#showreportButton2").click(function(){
$("#showreportForm2").toggle("slow");
});

$("#showCommentButton").click(function(){
$("#showCommentForm").toggle("slow");
});

$(".showEmploymentfields").hide();

$("#employedstatus").click(function(){
    $(".showEmploymentfields").show("slow");
});

$("#unemployedstatus").click(function(){
    $(".showEmploymentfields").hide("slow");
}); 

//learners edit       
if($('#showEmployed').checked){
  $(".showfields").show("slow");
}

$("#showEmployed").change(function(){
    $(".showfields").show("slow");
}); 

$("#hideEmployed").change(function(){
    $(".showfields").hide("slow");
}); 

$("#showFormButton").click(function(){
$("#showContactForm").toggle("slow");
});

$("#location").show("slow");
$("#province").show("slow");

$("input:radio[name=online]").click(function() {
var value = $(this).val();
if(value=='Y'){
   $("#location").hide("slow");
   $("#province").hide("slow");
}else{
   $("#location").show("slow");
   $("#province").show("slow");
}

});

tinymce.init({
    selector: "textarea",
    width: "150",
    height: "50"
 });
 
$('#hidden').show('fast', function(){
   $('#hideitem').hide();
});
 
$('#profileImage').change(function(e){
  var fileName = e.target.files[0].name;
  $("#upload-file-info").text(fileName);
});

});

</script>
</body>
</html>

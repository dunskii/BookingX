/*----------------------------------------------------------*/

/**
 * DHTML phone number validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */

// Declaring required variables
var digits = "0123456789";
// non-digit characters which are allowed in phone numbers
var phoneNumberDelimiters = "()- ";
// characters which are allowed in international phone numbers
// (a leading + is OK)
var validWorldPhoneChars = phoneNumberDelimiters + "+";
// Minimum no of digits in an international phone no.
var minDigitsInIPhoneNumber = 10;

function isInteger(s)
{   var i;
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}
function trim(s)
{   var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not a whitespace, append to returnString.
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character isn't whitespace.
        var c = s.charAt(i);
        if (c != " ") returnString += c;
    }
    return returnString;
}
function stripCharsInBag(s, bag)
{   var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character isn't whitespace.
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function checkInternationalPhone(strPhone){
var bracket=3
strPhone=trim(strPhone)
if(strPhone.indexOf("+")>1) return false
if(strPhone.indexOf("-")!=-1)bracket=bracket+1
if(strPhone.indexOf("(")!=-1 && strPhone.indexOf("(")>bracket)return false
var brchr=strPhone.indexOf("(")
if(strPhone.indexOf("(")!=-1 && strPhone.charAt(brchr+2)!=")")return false
if(strPhone.indexOf("(")==-1 && strPhone.indexOf(")")!=-1)return false
s=stripCharsInBag(strPhone,validWorldPhoneChars);
return (isInteger(s) && s.length >= minDigitsInIPhoneNumber);
}

function ValidateForm(){
	var Phone=document.frmSample.txtPhone
	
	if ((Phone.value==null)||(Phone.value=="")){
		alert("Please Enter your Phone Number")
		Phone.focus()
		return false
	}
	if (checkInternationalPhone(Phone.value)==false){
		alert("Please Enter a Valid Phone Number")
		Phone.value=""
		Phone.focus()
		return false
	}
	return true
 }
/**
 *method disableMonths
 *This function is used to disable the particular days of weeks based on seat selected
 *@params date
 *@return boolean true or false
 */
function disableMonths(date)
{
		var month = date.getMonth();
		var monthsToDisable = new Array();
		monthsToDisable = [1,2];
		for (i = 0; i < monthsToDisable.length; i++) {
		            if ($.inArray(month, monthsToDisable) == -1) {
		                return [false];
		            }
		        }
		return [true];

}
/**
 *method zeroPad
 *This method returns the number in input after leading zero padding upto the given places in the second parameters specified
 *@params num, places 
 *@return number after padding
 */
function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}

/**
 *method disableSpecificWeekDays
 *This function checks wether the date of the datepicker should be disabled or not,
 *based on the months and  days avaialability of selected seat
 *@params date 
 *@return boolean True or False with current input date and class to be applied to the current date cell
 */
function disableSpecificWeekDays(date) {
		var x=new Date();
		x.setFullYear(2014,0,27);
		//var comp = dates.compare(x,date)
		//alert(date);
		if(date.getTime() == x.getTime())
		{
			//alert(x);
			return [false];
		}
		//alert(date.getDay()+"Hii"+date.getMonth()+"year"+date.getYear());
		/*
		var prevDate = new Date('1/25/2011');
		var currDate = new Date('1/26/2011');
		var newDate = new Date('1/27/2011');
		var arr_date = new Array();
		arr_date.push(prevDate);
		arr_date.push(currDate);
		if ($.inArray(newDate, arr_date) == -1) {
			alert("true");
		}
		else
		{
			alert("false");
		}
		*/
		var flag_val = $("#id_days_availability_certain").val();
		var option_val = $("#id_days_availability").val();
		var flag_month_val = $("#id_months_availability").val();
		var option_month_val = $("#id_months_availability_certain").val();
		//alert($("#id_days_availability").val());
		var daysToDisable = new Array();
		var temp_option_val = option_val.split(",");
		//console.log(option_val);alert(option_val);
		for (x in temp_option_val)
		{
			if(temp_option_val[x]=="Monday")
			{
			daysToDisable.push(1);	
			}
			if(temp_option_val[x]=="Tuesday")
			{
			daysToDisable.push(2);	
			}
			if(temp_option_val[x]=="Wednesday")
			{
			daysToDisable.push(3);	
			}
			if(temp_option_val[x]=="Thursday")
			{
			daysToDisable.push(4);	
			}
			if(temp_option_val[x]=="Friday")
			{
			daysToDisable.push(5);	
			}
			if(temp_option_val[x]=="Saturday")
			{
			daysToDisable.push(6);	
			}
			if(temp_option_val[x]=="Sunday")
			{
			daysToDisable.push(0);	
			}

		}

		var temp_option_month_val = option_month_val.split(",");
		var monthsToDisable = new Array();

		for (x in temp_option_month_val)
		{
			if(temp_option_month_val[x]=="January")
			{
			monthsToDisable.push(0);	
			}
			if(temp_option_month_val[x]=="February")
			{
			monthsToDisable.push(1);	
			}
			if(temp_option_month_val[x]=="March")
			{
			monthsToDisable.push(2);	
			}
			if(temp_option_month_val[x]=="April")
			{
			monthsToDisable.push(3);	
			}
			if(temp_option_month_val[x]=="May")
			{
			monthsToDisable.push(4);	
			}
			if(temp_option_month_val[x]=="June")
			{
			monthsToDisable.push(5);	
			}
			if(temp_option_month_val[x]=="July")
			{
			monthsToDisable.push(6);	
			}
			if(temp_option_month_val[x]=="August")
			{
			monthsToDisable.push(7);	
			}
			if(temp_option_month_val[x]=="September")
			{
			monthsToDisable.push(8);	
			}
			if(temp_option_month_val[x]=="October")
			{
			monthsToDisable.push(9);	
			}
			if(temp_option_month_val[x]=="November")
			{
			monthsToDisable.push(10);	
			}
			if(temp_option_month_val[x]=="December")
			{
			monthsToDisable.push(11);	
			}
		}
	
		 var day = date.getDay();
	
		if(flag_month_val=="Y")
		{
			var day = date.getDay();

			var month = date.getMonth();
	
			for (i = 0; i < monthsToDisable.length; i++)
			{
					 if ($.inArray(month, monthsToDisable) == -1)
					{
							return [false];
					}
					else
					{
						for (i = 0; i < daysToDisable.length; i++) {
							if ($.inArray(day, daysToDisable) == -1) {
							return [false];
							}
						}
						
						var temp_date = zeroPad(date.getMonth()+1, 2)+"/"+zeroPad(date.getDate(),2)+"/"+date.getFullYear();
						var classname = '';
						/*$.post(url_obj.plugin_url+'/if_date_booked.php',{'bookigndate':temp_date}, function(data) {
							///$("#booking_details_value").html(data);
							//alert(data);
							classname = data;
						 });*/
						return [true];
						
					}
		      }
			
			/*
		        for (i = 0; i < daysToDisable.length; i++) {
		            if ($.inArray(day, daysToDisable) == -1) {
		                return [false];
		            }
		        }
		        return [true];
			*/
		}
		else
		{
			//alert('else');alert(daysToDisable);console.log(daysToDisable);
			//alert(day);alert(date);
			for (i = 0; i < daysToDisable.length; i++) {
				    if ($.inArray(day, daysToDisable) == -1) {
					return [false];
				    }
			}
			
			var temp_date = zeroPad(date.getMonth()+1, 2)+"/"+zeroPad(date.getDate(),2)+"/"+date.getFullYear();
			var classname = '';
			/*$.post(url_obj.plugin_url+'/if_date_booked.php',{'bookigndate':temp_date}, function(data) {
				///$("#booking_details_value").html(data);
				//alert(data);
				classname = data;
			 });*/
			return [true];
		
		}
		//var temp_date= new date(Y-m-d);
		

   }
/**
 *method change_timepicker_val
 *This function is triggered after timepicked valu changed
 *@params date
 *@return void
 */
function change_timepicker_val(date)
{
	$("#booking_details_value").css("display","block");

	$("#booking_details_value").html("<img src='"+url_obj.plugin_url+"/images/loading.gif' width='200px;'>");
	//$("#booking_details_value").html("hello");
	$("#id_input_date").val(date);
	//get time display options
	$.post(url_obj.plugin_url+'/displaytimeoptions.php',{'bookigndate':date,service_id:$('#id_base_selector').val(),'seatid': $('#myInputSeat').val()}, function(data) {
		$("#booking_details_value").html(data);
	 });

	//unset all timepicker selected values
	$("#id_booking_time_from").val('');
	$("#id_display_success").html("");
	$("#id_can_proceed").val(0);

	$("#time_options").html("<option>Select a time</option>");
	var myTime=new Array("12:00AM","12:30AM","01:00AM", "01:30AM");
	var option_text = "";
	for(temp in myTime)
	{
		option_text = option_text+"<option>"+myTime[temp]+"</option>";
	}
	$("#time_options").append(option_text);
	
	
	var fromtime = $('#id_time_availability_certain_from').val();
	var tilltime = $('#id_time_availability_certain_till').val();
	//alert(fromtime+"And "+tilltime)
	if(fromtime!="" && tilltime!="")
	{
		$('#input_4_11_2').timepicker({minTime: fromtime, maxTime: tilltime, interval: 10});
	}
	else
	{
		$('#input_4_11_2').timepicker();
	}
}
/**
 *method displaySecondForm
 *This function is to display second step form for booking
 *@access public
 *@return void
 */
function displaySecondForm()
{
	//alert($("#id_booking_duration_insec").attr("display-date-picker"));
	if($("#id_booking_duration_insec").attr("display-date-picker") == "1")
	 {
		$( "#id_datepicker_extended" ).datepicker();
		var today = new Date();
		 var $today_date =$.datepicker.formatDate('mm/dd/yy', new Date());
		 $('#id_datepicker').datepicker('setDate', $today_date);
		$( "#id_datepicker" ).datepicker({minDate: today,setDate: $today_date,beforeShowDay: disableSpecificWeekDays, onSelect: function(date){change_timepicker_val(date);}});
	 }
	 else
	 {
		$("#id_display_success").html("You Can Diretly Contact Administrator and proceed with booking payment");
		$("#id_can_proceed").val(1);
	 }
}
/*--------------------------------------------------------------------------------------------------------*/
$(document).ready(function(){
		$(".fc-widget-content[data-date='20130105']").addClass("disabled-slot");
		
		$("#time_options").change(function(){
			alert("time selected");
		});


		
  $(function() {		
        $( "#gf_progressbar_wrapper_4" ).progressbar({
            value: 25
        });
	//alert("<?php echo "dfgfd"; ?>");
    });

		/*
		$('#display_calendar_full').once('calendar').fullCalendar({
			defaultView: 'agendaWeek',
			aspectRatio: 1.8,
			contentHeight: 400,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'agendaWeek'
			},
			 dayClick: function( date, allDay, jsEvent, view ) { 
                    var myDate = new Date();
                    
                    //How many days to add from today?
                    var daysToAdd = 0;
                    
                    myDate.setDate(myDate.getDate() + daysToAdd);
                
                    if (date <= myDate) {
                        //TRUE Clicked date smaller than today + daysToadd
						alert("You cannot book on this day!");  
                    }
                    else
                    {
                        //FLASE Clicked date larger than today + daysToadd
                        alert("Excellent choice! We can book today..");    
                     }   
                
                    
            }, 
			viewDisplay: function(view) {
			// maybe return false aborts action? 
			if (view.start > lastDayOfNextMonth) {
				return false;
			}
			// or disable next button if this is last valid month
			if (view.end + oneDay >= lastValidDate) {
				$("#calendar #fc-button-next").attr("disabled","disabled");
			}
			// or gotoDate if view.start is out of range
			if (view.start > lastValidDate) {
			   // gotoDate
			}
		},
		});
		*/
		//alert(url_obj.plugin_url);

		/*$('#input_4_11_2').timepicker({
		    showPeriod: true,
		    showLeadingZero: true,
		    minTime:'10:45:00'
		  });
		*/
		//$('#input_4_11_2').timepicker();
		 $(function() {
			 $("#gform_next_button_4_7").click(function(){

				 //alert($("#id_booking_duration_insec").attr("display-date-picker"));

			 });
		});
                if($('#id_selected_seat').val()!='' && $('#id_selected_seat').val()!='zero')
                {
                    var seat_temp = $('#id_selected_seat').val()
 
                    $("#id_seat_name").val($(this).find('option:selected').text());
                    if(seat_temp!=""){
                           $('#id_base_selector').attr('disabled',false);
                    }
                    if(seat_temp==""){
                           $('#id_base_selector').attr('disabled',true);
                    }
		 $.post(url_obj.plugin_url+'/get_base_on_seat.php', { seatid: seat_temp }, function(data) {

				if(data!="error")
				{
					//alert(data);
					//alert('<?php echo __("Error-login") ?>'); 
					var temp_obj = $.parseJSON(data);
					//console.log(temp_obj);
					var temp_option='<option value="">Select a '+url_obj.base+'</option>';
					var base_obj = temp_obj['base_list'];
					//console.log(base_obj);
					for(x in base_obj)
					{
						//console.log(base_obj[x]['seat_id']);
					  //console.log(temp_obj[x]['seat_id']+temp_obj[x]['seat_name']+temp_obj[x]['seat_price']);
						//if(x!="seat_is_certain_days" && x!="seat_days" && x!="seat_is_certain_month" && x!="seat_months" && x!='seat_is_certain_time' && x!='seat_time_from' && x!='seat_time_till')
						//{
						  temp_option += "<option value='"+base_obj[x]['base_id']+"'>"+base_obj[x]['base_name']+" - $"+base_obj[x]['base_price']+" - "+base_obj[x]['base_time']+"</option>";
						//}
					}
					/*  Updated By : Madhuri Rokade 
						Reason : To check the Prepayment process
					*/

					if(temp_obj['seat_is_booking_prepayment']=='N')
					{
							$("#flag_stop_redirect").val('stop');
					}
					else{
						
							$("#flag_stop_redirect").val('');
					}
					//alert(temp_option);
					$('#id_base_selector').empty().append(temp_option);
					$("#id_time_availability").val(temp_obj['seat_is_certain_time']);
					$("#id_time_availability_certain_from").val(temp_obj['seat_time_from']);
					$("#id_time_availability_certain_till").val(temp_obj['seat_time_till']);
					$("#id_days_availability").val(temp_obj['seat_days']);
					$("#id_days_availability_certain").val(temp_obj['seat_is_certain_days']);
					$("#id_months_availability").val(temp_obj['seat_is_certain_month']);
					$("#id_months_availability_certain").val(temp_obj['seat_months']);
					
				}
				else
				{	
					alert("Couldn't list bases");
				}
			});
                    }
                            $('#myInputSeat').bind('change', function(){
                                //var oldvalue = ???
                                     var seat_temp = $(this).val();
                                     var seat_temp_name = $(this).html();
                                     //alert(seat_temp);
                                     $("#id_seat_name").val($(this).find('option:selected').text());
                                     if(seat_temp!=""){
                                            $('#id_base_selector').attr('disabled',false);
                                     }
                                     if(seat_temp==""){
                                            $('#id_base_selector').attr('disabled',true);
                                     }


                                     $.post(url_obj.plugin_url+'/get_base_on_seat.php', { seatid: seat_temp }, function(data) {

                                                    if(data!="error")
                                                    {
                                                            //alert(data);
                                                            //alert('<?php echo __("Error-login") ?>'); 
                                                            var temp_obj = $.parseJSON(data);
                                                            //console.log(temp_obj);
                                                            var temp_option='<option value="">Select a '+url_obj.base+'</option>';
                                                            var base_obj = temp_obj['base_list'];
                                                            //console.log(base_obj);
                                                            for(x in base_obj)
                                                            {
                                                                    //console.log(base_obj[x]['seat_id']);
                                                              //console.log(temp_obj[x]['seat_id']+temp_obj[x]['seat_name']+temp_obj[x]['seat_price']);
                                                                    //if(x!="seat_is_certain_days" && x!="seat_days" && x!="seat_is_certain_month" && x!="seat_months" && x!='seat_is_certain_time' && x!='seat_time_from' && x!='seat_time_till')
                                                                    //{
                                                                      temp_option += "<option value='"+base_obj[x]['base_id']+"'>"+base_obj[x]['base_name']+" - $"+base_obj[x]['base_price']+" - "+base_obj[x]['base_time']+"</option>";
                                                                    //}
                                                            }
                                                            /*  Updated By : Madhuri Rokade 
                                                                    Reason : To check the Prepayment process
                                                            */

                                                            if(temp_obj['seat_is_booking_prepayment']=='N')
                                                            {
                                                                            $("#flag_stop_redirect").val('stop');
                                                            }
                                                            else{

                                                                            $("#flag_stop_redirect").val('');
                                                            }
                                                            //alert(temp_option);
                                                            $('#id_base_selector').empty().append(temp_option);
                                                            $("#id_time_availability").val(temp_obj['seat_is_certain_time']);
                                                            $("#id_time_availability_certain_from").val(temp_obj['seat_time_from']);
                                                            $("#id_time_availability_certain_till").val(temp_obj['seat_time_till']);
                                                            $("#id_days_availability").val(temp_obj['seat_days']);
                                                            $("#id_days_availability_certain").val(temp_obj['seat_is_certain_days']);
                                                            $("#id_months_availability").val(temp_obj['seat_is_certain_month']);
                                                            $("#id_months_availability_certain").val(temp_obj['seat_months']);

                                                    }
                                                    else
                                                    {	
                                                            alert("Couldn't list bases");
                                                    }
                                            });
                            });
                        
        

		$('#id_base_selector').bind('change', function(){
			var base_temp1 = $(this).val();
			
			$.post(url_obj.plugin_url+'/get_base_on_seat.php', {baseid1: base_temp1, mob: 'no' }, function(data) {
				if(data!="error")
				{
					if(data == 'N')
					{
						$('#field_4_18').remove();
						$('#mobile_only').css('display', 'block');
						$('#user_details').css('display', 'none');
						$('#gform_page_footer_details').css('display', 'none');
						
					}
				}
				else
				{	
					alert("Couldn't list bases");
				}
			});

			
			$("input[name=mobile_only_choice]:radio").change(function () {
				$('#user_details').css('display', 'block');
				$('#gform_page_footer_details').css('display', 'block');
				$('li#field_4_18').remove();
			
			var selected_radio = $("input[name='mobile_only_choice']:checked").val();
			if(selected_radio == "YES" )
			{	
			
				var x = $('ul#4_form_user_details');
				x.append('<li id="field_4_18" class="gfield"><label class="gfield_label" for="input_4_18_1">Address</label><div class="ginput_complex ginput_container" id="input_4_18"><span class="ginput_full" id="input_4_18_1_container"><input type="text" name="input_street" id="id_street" value="" tabindex="18"><label for="input_4_18_1" id="input_4_18_1_label">Street</label></span><br><span class="ginput_left" id="input_4_18_3_container"><input type="text" name="input_city" id="id_city" value="" tabindex="19"><label for="input_4_18_3" id="input_4_18.3_label">City</label></span><br><span class="ginput_right" id="input_4_18_4_container"><input type="text" name="input_state" id="id_state" value="" tabindex="21"><label for="input_4_18_4" id="input_4_18_4_label">State / Province / Region</label></span><br><span class="ginput_left" id="input_4_18_5_container"><input type="text" name="input_postcode" id="id_postcode" value="" tabindex="22"><label for="input_4_18_5" id="input_4_18_5_label">Zip / Postal Code</label></span><input type="hidden" class="gform_hidden" name="input_18.6" id="input_4_18_6" value=""></div></li>');
				
			}
			else 
			{
				$('li#field_4_18').remove();

			}
						
		});

		});

		

		

		$('#id_base_selector').bind('change', function(){
			var base_temp = $(this).val();
			
			$.post(url_obj.plugin_url+'/get_base_on_seat.php', {baseid: base_temp, loc: 'fixed' }, function(data) {
				if(data!="error")
				{
					if(data == 'Y')
					{
						//alert(data);
						$('#field_4_18').remove();
					}
				}
				else
				{	
					alert("Couldn't list bases");
				}
			});

			
		});
	
	var availableTags = 
		[
            "0",
            "1",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
            "10"
        ];
        $( "#id_input_extended_time" ).autocomplete({
            source: availableTags,
	    minLength: 0,
	    change: function( event, ui ) {
			//if($(this).val()!="")
			{
				$("#id_clear_extended_time").css('visibility','visible');
				//alert(event);
				get_total_price('');
			}		
		}
        }).focus(function(){
           	if (this.value == "")
                {
                    $(this).autocomplete("search");
                }
		//$(this).trigger('keydown.autocomplete');
        });

	
	//$("#id_clear_extended_time").css('position','relative');
	$("#id_clear_extended_time").css('left','0px');
	$("#id_clear_extended_time").click(function(){
		$( "#id_input_extended_time" ).val('');
		$("#id_clear_extended_time").css('visibility','hidden');
		get_total_price('');
	});
	$("#id_clear_extended_time").css('visibility','hidden');

	$('#id_base_selector').bind('change', function(){
		var base_temp = $(this).val();
		if(base_temp=="")
		{
			$('#extended_time').hide();
			$('#base_extended_calender').hide();
			$('#id_addition_checkbox').html('');
		}
		else
		{
			$.post(url_obj.plugin_url+'/get_if_base_extended.php', { baseid: base_temp }, function(data) {
			
				if(data=="Y")
				{
					$('#extended_time').show();
					$('#base_extended_calender').show();
				}
				else if(data == 'N')
				{
					$('#extended_time').hide();
					$('#base_extended_calender').hide();
				}
			});
		}
		get_total_price('');
		$.post(url_obj.plugin_url+'/get_addition_on_base.php', { baseid: base_temp }, function(data) {
			
			var temp_obj = $.parseJSON(data);
				//console.log(temp_obj[0].addition_alies);
			var temp_option='';
			if(temp_obj){
			temp_option='<label class="gchoice_5_2_1 gfield_label ">Select '+temp_obj[0].addition_alies+' you require</label>';
			}
			for (x in temp_obj)
			{
			  //console.log(temp_obj[x]['seat_id']+temp_obj[x]['seat_name']+temp_obj[x]['seat_price']);
			  temp_option += '<li class="gchoice_5_1"><input name="addition_name[]" class="addition_name_class" id="addition'+temp_obj[x]['addition_id']+'" type="checkbox" value="'+temp_obj[x]['addition_id']+'" id="choice_5_1" tabindex="4" onchange="get_total_price(this);"><label for="choice_5_1">'+temp_obj[x]['addition_name']+' - $'+temp_obj[x]['addition_price']+' - '+temp_obj[x]['addition_time']+'</label></li>';
			}
			//temp_option += "<script>$(".addition_name_class").change(function(){alert("hello");});</script>"; 
			$('#id_addition_checkbox').html(temp_option);
			
		});
		
		
	});

	/*$("input[type='checkbox',name='input_addition']").bind("click", function(event, ui) {
		alert('change detected');
	 });
	*/
	
	$(":checkbox").bind("click",function(event, ui){
		alert('clicked');
		
	});
	
    });//close document.ready function 

function get_total_price(thisval)
{
	var temp = $(thisval).val();
	var addition_list = new Array();


	$('.addition_name_class').each(function(index) {
		//alert($(this).val());
		if($(this).is(':checked')==true)
		{
			addition_list.push($(this).val());
		}
		else
		{
		//alert('not checked');
		}

	});
	var base_extended = 0;
	var x=document.getElementById("id_input_extended_time");
	base_extended = x.value;
	//alert(base_extended);
	var seat_temp = $('#myInputSeat').val();
	var base_temp = $('#id_base_selector').val();
	$.post(url_obj.plugin_url+'/get_total_price.php', { seatid : seat_temp, baseid: base_temp,additionid : addition_list,extended : base_extended}, 	function(data) {
		$('h4 span#total_price').html(data['total_price']);
		$('#hidden_total_price').val(data['total_price']);
		$('#deposit_price').val(data['deposit_price']);
		$('#seat_is_booking_prepayment').val(data['seat_is_booking_prepayment']);
	}, "json");
	
}

function validate_form(source_val,destination_val)
{
	var error_list = new Array();
	if(source_val==1 && destination_val == 2)
	{
		var addition_list =  new Array();
		if($('#myInputSeat').val()=="")
		{
			error_list.push("Please select a seat");
		}
		if($('#id_base_selector').val()=="")
		{
			error_list.push("Please select a base");
		}
		if($("#extended_time").is(":visible"))
		{
			var extended_time = $("#id_input_extended_time").val();
						
			if(extended_time== "" || extended_time== undefined)
			{
				error_list.push("Please enter extended base time");
			}
		}
		//alert($('.addition_name_class').length);
		if($('.addition_name_class').length>0)
		{
			$('.addition_name_class').each(function(index) {
				//alert($(this).is(':checked'));
				if($(this).is(':checked')==true)
				{
					addition_list.push($(this).val());
				}				

			});
			/*if(addition_list.length == 0)
			{
				error_list.push("Please select atleast one addition");
			}*/
		}
	}

	if(source_val==2 && destination_val == 3)
	{

		//alert($("#id_can_proceed").val());
		if($("#id_can_proceed").val() == "0")
		{
			if($("#id_datepicker").val()=="")
			{
				error_list.push("Please choose a date");
			}
			if($("#base_extended_calender").is(":visible"))
			{
				if($("#id_datepicker_extended").val()=="")
				{
					error_list.push("Please choose end date");		

				}
			}
			/*if($("#input_4_11_2").val()=="")
			{
				error_list.push("Please choose time");		
			}*/
			if($("#time_options").val()=="")
			{
				error_list.push("Please choose time");		
			}
			if($("#id_can_proceed").val()==0)
			{
				error_list.push("Please select appropriate date time");		
			}
		}


	}
	if(source_val==3 && destination_val == 4)
	{
		if($("#id_firstname").val()=="")
		{
			error_list.push("Please enter your first name");
		}
		if($("#id_lastname").val()=="")
		{
			error_list.push("Please enter your last name");
		}
		if($("#id_phonenumber").val()=="")
		{
			error_list.push("Please enter your phone");
		}
		else
		{
			if (checkInternationalPhone($("#id_phonenumber").val())==false)
			{
				error_list.push("Please Enter a Valid Phone Number");
			}
		}
		if($("#id_email").val()=="")
		{
			error_list.push("Please enter your email");
		}
		else
		{
			var temp_err = ValidateEmail($("#id_email").val());
			if(temp_err != true)
			{
				error_list.push(temp_err);
			}
		}
		if($("#id_postcode").val()== "")
		{
			error_list.push("Please enter your post code");
		}

	}

	temp_err='';
	for(var i=0; i<error_list.length; i++)
	{
		temp_err = temp_err+"<p><strong>"+error_list[i]+"</strong></p>";
	}
	if(temp_err!='')
	{
		$(".error").html(temp_err);
		$(".error").show();
		return false;
	}
	else
	{
		var seat_temp = $('#myInputSeat').val();
		var booking_date = $("#id_input_date").val();
		var start_time = $("#id_booking_time_from").val();
		var booking_duration = $("#id_booking_duration_insec").val();

		$(".error").html('');
		$( "#gf_progressbar_wrapper_4" ).progressbar({
			value: 25*destination_val
		});
		$('h3.gf_progressbar_title').html('Step '+destination_val+' of 4');
		//alert("writing html here");
		//start code for getting selected seat,base and additions			
			var addition_list = new Array();
			$('.addition_name_class').each(function(index) {
				//alert($(this).val());
				if($(this).is(':checked')==true)
				{
					addition_list.push($(this).val());
				}
				else
				{
				//alert('not checked');
				}

			});
		if(source_val==1 && destination_val == 2)
		{
			
			//alert(addition_list);
			//console.log(addition_list);
			var seat_temp = $('#myInputSeat').val();
			var base_temp = $('#id_base_selector').val();
			var mob_only = $('#id_selected_base').val();
			//end code for getting selected seat, base and addition

			
			$.post(url_obj.plugin_url+'/get_duration_booking.php', { seatid : seat_temp, baseid: base_temp,additionid : addition_list}, 	function(data) {
				//alert(data);
				var temp_data = $.parseJSON(data);
				//alert(temp_data);console.log(temp_data);
				//alert(data);alert(addition_list);console.log(addition_list);
				$("#display_total_duration").html(temp_data['time_output']);
				$("#id_booking_duration_insec").val(temp_data['totalduration_in_seconds']);
				var result = temp_data['result'];
				$("#id_booking_duration_insec").attr('display-date-picker', result);
				displaySecondForm();
				//$("#id_total_duration").val(temp_data['time_output']);
				//$("span#id_selected_addition").html(temp_data['addition_list']);
			});
			var $today_date =$.datepicker.formatDate('mm/dd/yy', new Date());
			change_timepicker_val($today_date);
		}
		$("span#id_selected_base").html($("#id_base_selector option:selected").text());
	//$("input.id_selected_base").val($("#id_base_selector option:selected").text());
		if(source_val==3 && destination_val == 4)
		{	
			//alert($("#myInputSeat option:selected").text());
			//alert("writing html");
			
			//start code for getting selected seat,base and additions			
			/*var addition_list = new Array();
			$('.addition_name_class').each(function(index) {
				//alert($(this).val());
				if($(this).attr('checked')=='checked')
				{
		
				addition_list.push($(this).val());
				}
				else
				{
				//alert('not checked');
				}

			});*/
			//alert(addition_list);
			//console.log(addition_list);
			var seat_temp = $('#myInputSeat').val();
			var base_temp = $('#id_base_selector').val();
			//alert($('#id_base_selector').val());
			//end code for getting selected seat, base and addition			
			
			$.post(url_obj.plugin_url+'/get_duration_booking.php', { seatid : seat_temp, baseid: base_temp,additionid : addition_list}, 	function(data) {
				var temp_data = $.parseJSON(data);
				//alert(temp_data);console.log(temp_data);
				//alert(data);alert(addition_list);console.log(addition_list);
				$("#id_estimated_time").html(temp_data['time_output']);
				$("#id_total_duration").val(temp_data['time_output']);
				$("span#id_selected_addition").html(temp_data['addition_list']);
				//$("span#id_selected_base11").html(temp_data['mob_only']);

			});

			$("span#id_selected_date").html($("#id_datepicker").val());
			//$("span#id_selected_time").html($("#input_4_11_2").val());
			$("span#id_selected_time").html($("#id_booking_time_from").val());
			$("span#id_selected_seat").html($("#myInputSeat option:selected").text());
			//$("span#id_selected_base").html($("#id_base_selector option:selected").text());
			//$("span#id_selected_addition").html($("#input_4_11_2").val());
			//alert("$"+$("#total_price").html());
			
			//alert($("#myInputSeat option:selected").val());
			$("#id_totalling").html("$"+$("#total_price").html());

			//$("#id_deposit_val").html("$"+$("#total_price").html());
			var seat_is_booking_prepayment = $("#seat_is_booking_prepayment").val();
			//console.log("payment: "+seat_is_booking_prepayment);
			if(seat_is_booking_prepayment == 'Y'){
				$("#id_deposit_val").html("Please Note a deposit of $"+$("#deposit_price").val()+" is required to process and confirm this booking.");
				$("#gform_submit_button_4").addClass("paypal_button");
				$("#gform_submit_button_4").val("");
			} else {
				$("#id_deposit_val").html("");
				if($("#gform_submit_button_4").hasClass("paypal_button"))
					$("#gform_submit_button_4").removeClass("paypal_button");
			}
		}
		check_slot_is_available(seat_temp,start_time,booking_duration,booking_date,source_val,destination_val);


	}
}

    function ValidateEmail(mail)   
    {  
     if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))  
      {  
        return (true)  
      }  
        var error = "You have entered an invalid email address!"; 
        return (error);  
    }  


$('div.app_timetable_cell.free').bind('click', function() {
    //alert("hii+++");
	return false;
});

//on click of any time slot
$("div").on("click", "div.app_timetable_cell.free", function() {
    //alert("hii+++");
	//get the clicked time
	$("#booking_details_value div").removeClass("selected-slot");
	var start_time = $(this).attr("id");
	var booking_duration = $("#id_booking_duration_insec").val();
	var seat_temp = $('#myInputSeat').val();
	var booking_date = $("#id_input_date").val();
	//alert(booking_date);
	$.post(url_obj.plugin_url+'/check_ifit_canbe_booked.php', { seatid: seat_temp, start:start_time, bookingduration: booking_duration,bookingdate:  booking_date}, function(data) {
		var temp_obj = $.parseJSON(data);
		var result = temp_obj['result'];
		var starting_slot = temp_obj['starting_slot'];
		var $process ;

		if(parseInt(result) == 1)
		{
			$("#id_booking_time_from").val(start_time);
			$("#id_display_success").html("You Can book this slot");
			$("#id_can_proceed").val(1);
			var selected_start = starting_slot + 1;
			var selected_end = starting_slot + temp_obj['no_of_slots']+1;

			/**
			 * Added functionality for Check Booking Dates and slot is Available or not
			 * Also check if slot get out of Range on displayed time then restrict
			 * By : Divyang Parekh
			 * Date : 23-11-2015
			 */

			//Highlight Selected Time Slots
			var good_ids = new Array();
			for (var i = selected_start; i <= selected_end; i++)
			{
				var $not_available = $("."+i+"-is-notavailable").val();
				var $check_date_available = $("."+i+"-is-free").val();
				var $full_date = $("."+i+"-is-full").val();
				 if($check_date_available == undefined)
				 {
					 $process = 0;
					 break;
				 }
				else
				 {
					 if($not_available == undefined && $full_date == undefined )
					 {
						 $process = 1;
						 good_ids.push(i);
					 }
					 else
					 {
						 $process = 0;
						 break;
					 }
				 }
			}
			//alert($process);
			//console.log(good_ids);
			if($process == 0)
			{
				alert("You Cannot book this slot.");
				$("#id_display_success").html("<span class='error_booking'>You Cannot book this slot</span>");
				$("#id_can_proceed").val(0);
			}
			else
			{
				for (var sel = 0; sel <= good_ids.length; sel++)
				{
					$("#booking_details_value ."+good_ids[sel]).addClass("selected-slot");
				}
			}

		}
		else
		{
			alert("You Cannot book this slot.");
			$("#id_display_success").html("<span class='error_booking'>You Cannot book this slot</span>");
			$("#id_can_proceed").val(0);
		}
	});
	
	return false;
});

function view_book(bid){
	
			$.post('http://booking.php-dev.in/wp-content/plugins/yfbizbooking/ajax-view-booking.php', { bid: bid }, function(data) {
				if(data!="error")
				{
					$('#'+bid).after(data);
				}
				else
				{	
					alert("Couldn't list bases");
				}	
			});
}

/**
 * Added function for Reassign Staff of Booking
 * By : Divyang Parekh
 * Date : 16-11-2015
 */
function check_staff_availability(seat_id,start_time,durations,booking_date,booking_record_id)
{

//seatid: seat_temp, start:start_time, bookingduration: booking_duration,bookingdate:  booking_date
	var seat_id 		= seat_id;
	var booking_date  	= booking_date;
	var start_time     	= start_time;
	var durations     	= durations;
	var booking_record_id = booking_record_id;

	$.post(url_obj.plugin_url+"/check_staff_availability.php",{seat_id: seat_id, start:start_time, bookingduration: durations,bookingdate:  booking_date ,booking_record_id : booking_record_id}, function(data) {
	
		var temp_obj = $.parseJSON(data);
			var result = temp_obj['data'];
			var result_staff = temp_obj['staff'];
			var booking_record_id = temp_obj['booking_record_id'];
			var name = temp_obj['name'];
			if(parseInt(result) == 1)
			{

				jQuery('#reassign_msg').addClass('updated');
				jQuery('#reassign_msg').show();
				jQuery('#reassign_msg').html('<b>Successfully Reassign.</b>');
				$("#reassign_msg").fadeOut(3000,function(){jQuery('#reassign_msg').removeClass('updated');});

				draw_rectangle(booking_record_id,name);
				if(result_staff.length)
				{
					var temp_option='<option value="">Reassign Booking: </option>';
					for(x in result_staff)
					{
						temp_option += "<option value='"+result_staff[x]['seat_id']+"'>"+result_staff[x]['name']+"</option>";
					}
					jQuery('#id_reassign_booking_'+booking_record_id).empty().append(temp_option);
				}
			}
			else{
				alert('Sorry ! Something went wrong , Please try again.');
			}
	});

}


function check_slot_is_available(seat_temp,start_time,booking_duration,booking_date,source_val,destination_val)
{
	if(booking_date!='') {
		$.post(url_obj.plugin_url + '/check_ifit_canbe_booked.php', {
			seatid: seat_temp,
			start: start_time,
			bookingduration: booking_duration,
			bookingdate: booking_date
		}, function (data) {
			var temp_obj = $.parseJSON(data);
			var result = temp_obj['result'];
			var starting_slot = temp_obj['starting_slot'];
			var $process;

			if (parseInt(result) == 1) {
				$("#id_booking_time_from").val(start_time);
				$("#id_display_success").html("You Can book this slot");
				$("#id_can_proceed").val(1);
				var selected_start = starting_slot + 1;
				var selected_end = starting_slot + temp_obj['no_of_slots'];

				/**
				 * Added functionality for Check Booking Dates and slot is Available or not
				 * Also check if slot get out of Range on displayed time then restrict
				 * By : Divyang Parekh
				 * Date : 23-11-2015
				 */

				//Highlight Selected Time Slots
				var good_ids = new Array();
				for (var i = selected_start; i <= selected_end; i++) {
					var $not_available = $("." + i + "-is-notavailable").val();
					var $check_date_available = $("." + i + "-is-free").val();
					var $full_date = $("." + i + "-is-full").val();
					if ($check_date_available == undefined) {
						$process = 0;
						break;
					}
					else {
						if ($not_available == undefined && $full_date == undefined) {
							$process = 1;
							good_ids.push(i);
						}
						else {
							$process = 0;
							break;
						}
					}
				}
				//alert($process);
				//console.log(good_ids);
				if ($process == 0) {
					alert("You Cannot book this slot.");
					$("#id_display_success").html("<span class='error_booking'>You Cannot book this slot</span>");
					$("#id_can_proceed").val(0);
				}
				else {
					for (var sel = 0; sel <= good_ids.length; sel++) {
						$("#booking_details_value ." + good_ids[sel]).addClass("selected-slot");
					}
				}
				$("#gform_page_4_"+source_val).css('display','none');
				$("#gform_page_4_"+destination_val).css('display','block');

			}
			else
			{

				alert("You Cannot book this slot.");
				$("#id_display_success").html("<span class='error_booking'>You Cannot book this slot</span>");
				$("#id_can_proceed").val(0);
				change_timepicker_val(booking_date);
				return false;
			}
		});
	}
	else
	{
		$("#gform_page_4_"+source_val).css('display','none');
		$("#gform_page_4_"+destination_val).css('display','block');
	}
}




function initialize(counter) {
    geocoder = new google.maps.Geocoder();
    //var latlng = new google.maps.LatLng(-34.397, 150.644);
    //var address = "A/5,Paradise,Godrej Hill,KalYan,Maharashtra,421301";
    var address = document.getElementById("address_val"+counter).value;

    geocoder.geocode( { 'address': address}, function(results, status) {
	
      if (status == google.maps.GeocoderStatus.OK) {
     		var latlng = new google.maps.LatLng(results[0].geometry.location.Ya,results[0].geometry.location.Za);
		    var mapOptions = {
		      zoom: 12,
		      center: latlng,
		      mapTypeId: google.maps.MapTypeId.ROADMAP
		    }
		    map = new google.maps.Map(document.getElementById("map_canvas_"+counter), mapOptions);
      } else {
       //alert("Geocode was not successful for the following reason: " + status);
      }
    });
}

function codeAddress(counter) {
    var address = document.getElementById("address_val"+counter).value;
    //address = "A/5,Paradise,Godrej Hill,KalYan,Maharashtra,421301";
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        //alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
function getContrast50(hexcolor){
    return (parseInt(hexcolor, 16) > 0xffffff/2) ? 'black':'black';
}

function draw_rectangle(id_temp, name)
{
		//alert("inside function call");
		jQuery.post(url_obj.plugin_url + '/get_booking_details.php', { booking_record_id: id_temp }, function(data) {	
		
		var temp_data =	jQuery.parseJSON(data);
		//console.log(temp_data);
		var temp_addition = temp_data.addition;
		//console.log(temp_data.booking);
		var base_time_option = temp_data.booking;
		//console.log(base_time_option);

			//console.log("addition data start");
			//console.log(temp_addition);
			var counter = 0;
			var addition_time_arr = new Array();
			var addition_minutes_arr = new Array();
			var addition_minutes = 0;
			var addition_minutes_total = 0;

			for(var x in temp_addition)
			{
				var addition_time = '';
				if(temp_addition[x].addition_time_option=="H")
				{
					addition_time = temp_addition[x].addition_hours;
					addition_minutes = parseInt(temp_addition[x].addition_hours)*60 + parseInt(temp_addition[x].addition_minutes);
					addition_time_display = temp_addition[x].addition_hours+" Hours "+ temp_addition[x].addition_minutes + "Minutes";
				}
				if(temp_addition[x].addition_time_option=="D")
				{
					addition_time = temp_addition[x].addition_days*24;
					addition_minutes = addition_time * 60;
					addition_time_display = temp_addition[x].addition_days+" Days";
				}
				if(temp_addition[x].addition_time_option=="Months")
				{
					addition_time = temp_addition[x].addition_months*24*30;
					addition_time_display = temp_addition[x].addition_months+" Months";
				}
				addition_minutes_total = addition_minutes_total + addition_minutes;
				addition_time_arr[temp_addition[x].addition_id] = addition_time;
				addition_minutes_arr[temp_addition[x].addition_id] = addition_minutes;
				
			}
			//console.log("addition");
			//console.log(base_time_minutes);
			//console.log(addition_minutes_total);
			/*end addition time calculation*/
		//console.log(base_time_option.seat_name);
		//for(x in base_time_option)
		//{
			jQuery(".seat_rectangle").html("");
			jQuery("#seat_rect_"+id_temp).css('background-color', "#"+base_time_option.seat_color);
			var divSeat = document.createElement("div");
			headerColor = getContrast50(base_time_option.seat_color);
			divSeat.innerHTML = name+ " - "+base_time_option.seat_name+" - From "+base_time_option.booking_start_date+" To "+base_time_option.booking_end_date+" - Duration:"+base_time_option.total_duration;
			divSeat.style.color = headerColor;
			//console.log(divSeat);
			document.getElementById('seat_rect_'+id_temp).appendChild(divSeat);
			var base_option = base_time_option.base_time_option;
			var base_time = '';
			var base_time_minutes = '';
			var base_time_display = "";
			if(parseInt(extended_base_time)>0)
			{
				//base_time_display = parseInt(base_time_display) + (base_time_display*parseInt(extended_base_time));
			}

			if(base_option=='H')
			{
				base_time = base_time_option.base_hours;
				base_mins = base_time_option.base_minutes;
				base_time_minutes = parseInt(base_time_option.base_hours)*60 + parseInt(base_time_option.base_minutes);
				base_time_display = (parseInt(base_time_option.base_hours)+parseInt(base_time_option.base_hours*base_time_option.extended_base_time))+" Hours "+ parseInt(base_time_option.base_minutes) + "Minutes";
			}
			if(base_option=='D')
			{
				base_time = base_time_option.base_day*24;
				base_time_minutes = parseInt(base_time) * 60;
				base_time_display = (parseInt(base_time_option.base_day)+parseInt(base_time_option.base_day*base_time_option.extended_base_time))+" Days"
			}
			if(base_option=="M")
			{
				base_time = base_time_option.base_month*24*30;
				base_time_display =(parseInt(base_time_option.base_month)+parseInt(base_time_option.base_month*base_time_option.extended_base_time))+" Months"
			}
			var extended_base_time = base_time_option.extended_base_time;

			///console.log(base_time_minutes);
			var ratioBase = base_time_minutes/parseInt(addition_minutes_total+base_time_minutes);
			var ratioAddition = addition_minutes_total/parseInt(addition_minutes_total+base_time_minutes);
			var total_width = 1000;
			var baseWidth = ratioBase * total_width;
			var additionWidth = ratioAddition * total_width;
			var divTag = document.createElement("div");
			divTag.id = "div1";
			divTag.setAttribute("align","center");
			divTag.style.border = "1px solid #ccc";
			divTag.style.height = "50px";
			divTag.style.width = baseWidth+"px";
			var expected_color = getContrast50(base_time_option.base_color);
			divTag.style.color = expected_color;			
			divTag.style.background = '#'+base_time_option.base_color;
			divTag.innerHTML = base_time_option.base_name+" - Duration: "+base_time_display;

			document.getElementById('seat_rect_'+id_temp).appendChild(divTag);

			//creating divAddition
			var divAddition = document.createElement("div");
			divAddition.setAttribute("align","center");
			divAddition.setAttribute("id","addition_container");
			divAddition.style.border = "0px solid #ccc";
			divAddition.style.height = "auto";
			divAddition.style.width = "300px";
			divAddition.style.background = 'Yellow';
			divAddition.style.position = 'relative';
			divAddition.style.left = +baseWidth+'px';
			
			document.getElementById('seat_rect_'+id_temp).appendChild(divAddition);
			jQuery("#seat_rect_"+id_temp).css('min-height','0');
		//}
		addition_time_arr.sort(function(a,b){return b-a});
		//console.log("addition time array");
		var temp_width_factor = 340/addition_time_arr[0];
		var leftAddition = 0;
		var topAddition = 0;
		for(var x in temp_addition)
		{			
			var addition_time = '';
			var addition_minute_current = 0;
			if(temp_addition[x].addition_time_option=="H")
			{
				addition_time = temp_addition[x].addition_hours;
				addition_minute_current = parseInt(temp_addition[x].addition_hours) * 60 + parseInt(temp_addition[x].addition_minutes);
				if(parseInt(temp_addition[x].addition_minutes) == 0)
				{
					addition_time_display = temp_addition[x].addition_hours+" Hours ";
				}
				else if(parseInt(temp_addition[x].addition_hours)==0)
				{
					addition_time_display = temp_addition[x].addition_minutes +" Minutes";
				}
				else
				{
					addition_time_display = temp_addition[x].addition_hours+" Hours "+temp_addition[x].addition_minutes +" Minutes";
				}
			}
			if(temp_addition[x].addition_time_option=="D")
			{
				addition_time = temp_addition[x].addition_days*24;
				addition_minute_current = parseInt(addition_time) * 60;
				addition_time_display = temp_addition[x].addition_days+" Days";
			}
			if(temp_addition[x].addition_time_option=="M")
			{
				addition_time = temp_addition[x].addition_months*24*30;
				addition_time_display = temp_addition[x].addition_months+" Months";
			}
			var ratioAdditionMinutes = addition_minute_current/addition_minutes_total;
			var currentWidthAddition = additionWidth * ratioAdditionMinutes;
			var divAddition = document.createElement("div");
			divAddition.style.border = "1px solid #ccc";
			divAddition.style.position = "";
			divAddition.style.float = "left";
			
			var add_overlap = temp_addition[x].addition_overlap;			

			if(add_overlap == 'Y'){
				divAddition.style.left = "none";
			}else{
				divAddition.style.left = leftAddition+"px";
			}
			
			//divAddition.style.left = leftAddition+"px";
			divAddition.style.top = topAddition+"px";
			var expected_color = getContrast50(temp_addition[x].addition_color);
			divAddition.style.color = expected_color;
			divAddition.style.height = "50px";
			divAddition.style.width = currentWidthAddition+"px";
			divAddition.style.background = "#"+temp_addition[x].addition_color;			
			divAddition.innerHTML = temp_addition[x].addition_name+"<br>"+addition_time_display;
			
			document.getElementById('addition_container').appendChild(divAddition);
			counter=counter+1;			
			leftAddition = parseInt(leftAddition) + currentWidthAddition;
			topAddition = parseInt(topAddition) + 50;
		}
	});
}
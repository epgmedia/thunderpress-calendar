$(document).ready(function(){

//global vars

	var enquiryfrm = $("#agt_mail_agent");

	var yourname = $("#agt_mail_name");

	var yournameInfo = $("#span_agt_mail_name");

	var youremail = $("#agt_mail_email");

	var youremailInfo = $("#span_agt_mail_email");

	var frnd_comments = $("#agt_mail_msg");

	var frnd_commentsInfo = $("#span_agt_mail_msg");

	

	//On blur

	yourname.blur(validate_yourname);

	youremail.blur(validate_youremail);

	frnd_comments.blur(validate_frnd_comments_author);

	//On key press

	yourname.keyup(validate_yourname);

	youremail.keyup(validate_youremail);

	frnd_comments.keyup(validate_frnd_comments_author);

	

	//On Submitting

	enquiryfrm.submit(function(){

		if(validate_yourname() & validate_youremail() & validate_frnd_comments_author())

		{
			//hideform();
			return true
		}
		else
		{
			return false;
		}
	});



	//validation functions

	function validate_yourname()

	{

		if($("#agt_mail_name").val() == '')

		{

			yourname.addClass("error");

			yournameInfo.text("Please Enter Your Name");

			yournameInfo.addClass("message_error2");

			return false;

		}

		else{

			yourname.removeClass("error");

			yournameInfo.text("");

			yournameInfo.removeClass("message_error2");

			return true;

		}

	}

	function validate_youremail()

	{

		var isvalidemailflag = 0;

		if($("#agt_mail_email").val() == '')

		{

			isvalidemailflag = 1;

		}else

		if($("#agt_mail_email").val() != '')

		{

			var a = $("#agt_mail_email").val();

			var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;

			//if it's valid email

			if(filter.test(a)){

				isvalidemailflag = 0;

			}else{

				isvalidemailflag = 1;	

			}

		}

		if(isvalidemailflag)

		{

			youremail.addClass("error");

			youremailInfo.text("Please Enter valid Email Address");

			youremailInfo.addClass("message_error2");

			return false;

		}else

		{

			youremail.removeClass("error");

			youremailInfo.text("");

			youremailInfo.removeClass("message_error");

			return true;

		}

		

	}

	

	function validate_frnd_comments_author()
	{				
		if($("#agt_mail_msg").val() == '')
		{
			frnd_comments.addClass("error");
			frnd_commentsInfo.text("Please Enter Comments");
			frnd_commentsInfo.addClass("message_error2");
			return false;
		}else{
			frnd_comments.removeClass("error");
			frnd_commentsInfo.text("");
			frnd_commentsInfo.removeClass("message_error2");
			return true;
		}

	}	
function reset_email_agent_form()
{
	document.getElementById('agt_mail_name').value = '';
	document.getElementById('agt_mail_email').value = '';
	document.getElementById('agt_mail_phone').value = '';
	document.getElementById('agt_mail_msg').value = '';	
}
});
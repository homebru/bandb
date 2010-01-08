// JavaScript Document
$(document).ready(function(){
						   
	$("#btnAddSite").click(function(){
		$(".error").hide();
		var hasError = false;

		var a_value = $("#txtWebsite").val();
		if(a_value == "") {
			$("#txtWebsite").after('<span class="error">Website Name is required.</span>');
			hasError = true;
		}
		
		var a_value = $("#txtContact").val();
		if(a_value == "") {
			$("#txtContact").after('<span class="error">Contact Name is required.</span>');
			hasError = true;
		}
		
		var a_value = $("#txtEmail").val();
		if(a_value == "") {
			$("#txtEmail").after('<span class="error">Email Address is required.</span>');
			hasError = true;
		}
		else {
			if(validate_email(a_value) == false) {
				$("#txtEmail").after('<span class="error">Please enter valid email address for Email Sales.</span>');
			}
		}

		if(hasError == false) {
			$("#btnAddSite").after('<img src="<?php echo base_url(); ?>images/ajax-loader.gif" alt="Loading..." id="loader_gif" />');
			$("#btnAddSite").hide();
			$.post("<?php echo base_url(); ?>index.php/publishers/add", { txtWebsite: $("#txtWebsite").val(), txtPricingURL: $("#txtPricingURL").val(), txtLogonURL: $("#txtLogonURL").val(), rblUserReview: $("#rblUserReview").val(), rblBBListSpecials: $("#rblBBListSpecials").val(), rblQuantified: $("#rblQuantified").val(), txtContact: $("#txtContact").val(), txtTitle: $("#txtTitle").val(), txtEmail: $("#txtEmail").val(), txtPhone: $("#txtPhone").val(), txtTollFree: $("#txtTollFree").val(), txtNotes: $("#txtNotes").val() }, function (data) {
				if(data == "1") {
					$("#View2").show();
					$("#AddPanel").hide();
					$("#View4").hide();
				}
			});
		}
		$("#loader_gif").remove();
		$(this).show();
		return false;
	});
	
	
	$("#search").click(function(){
		$(".error").hide();
		var hasError = false;

		var searchToVal = $("#txtSearch").val();
		if(searchToVal == "") {
			$("#txtSearch").after('<span class="error">You forgot to enter a web URL</span>');
			hasError = true;
		}
		
		if(validate_url('http://www.'+searchToVal) == false) {
			$("#txtSearch").after('<span class="error">Your entry does not appear to be a valid web URL. If we are incorrect please <a href="mailto:<?= $this->config->item('email_from'); ?>?subject=Invalid URL - ' + $("#txtSearch").val() + '">let us know</a>.</span>');
			hasError = true;
		}
		
		if(hasError == false) {
			var re = /^www./;
			var replacementpattern = "";
			$("#txtSearch").val($("#txtSearch").val().replace(re, replacementpattern));

			$(this).hide();
			$("#search").after('<img src="<?php echo base_url(); ?>images/ajax-loader.gif" alt="Loading..." id="loader_gif" />');

			$.post("<?php echo base_url(); ?>index.php/publishers/find", { website: $("#txtSearch").val() }, function (data) {
				if(data == "") {
					$("#View4").show();
					$("#View4").html("<br />No, <strong>"+$("#txtSearch").val()+"</strong> is not in our system.<br />Please make sure you entered .com, .net, etc. Also do not include www., we have done it for you. Only exact matches are displayed.<br /><br />");
					$("#AddPanel").show();
					$('#txtWebsite').val($('#txtSearch').val()); //Preset the website to be added otherwise they could add 6,000 duplicates by searching for one web site but adding a different one!
				} else {
					$("#View3").show();
					$("#View3").html(data);
				}
			});
		}
		$("#loader_gif").remove();
		$(this).show();
		return false;
	});
});

function validate_email(value)
{
	var regExp = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix;
	var valid = value.match(regExp);
	if (valid) {
		return true;
	}
	
	return false;
}

function validateIP(value, format)
{
	var validIPv6Addresses = [
		//preferred
		/^(?:[a-f0-9]{1,4}:){7}[a-f0-9]{1,4}(?:\/\d{1,3})?$/i,

		//various compressed
		/^[a-f0-9]{0,4}::(?:\/\d{1,3})?$/i,
		/^:(?::[a-f0-9]{1,4}){1,6}(?:\/\d{1,3})?$/i,
		/^(?:[a-f0-9]{1,4}:){1,6}:(?:\/\d{1,3})?$/i,
		/^(?:[a-f0-9]{1,4}:)(?::[a-f0-9]{1,4}){1,6}(?:\/\d{1,3})?$/i,
		/^(?:[a-f0-9]{1,4}:){2}(?::[a-f0-9]{1,4}){1,5}(?:\/\d{1,3})?$/i,
		/^(?:[a-f0-9]{1,4}:){3}(?::[a-f0-9]{1,4}){1,4}(?:\/\d{1,3})?$/i,
		/^(?:[a-f0-9]{1,4}:){4}(?::[a-f0-9]{1,4}){1,3}(?:\/\d{1,3})?$/i,
		/^(?:[a-f0-9]{1,4}:){5}(?::[a-f0-9]{1,4}){1,2}(?:\/\d{1,3})?$/i,
		/^(?:[a-f0-9]{1,4}:){6}(?::[a-f0-9]{1,4})(?:\/\d{1,3})?$/i,


		//IPv6 mixes with IPv4
		/^(?:[a-f0-9]{1,4}:){6}(?:\d{1,3}\.){3}\d{1,3}(?:\/\d{1,3})?$/i,
		/^:(?::[a-f0-9]{1,4}){0,4}:(?:\d{1,3}\.){3}\d{1,3}(?:\/\d{1,3})?$/i,
		/^(?:[a-f0-9]{1,4}:){1,5}:(?:\d{1,3}\.){3}\d{1,3}(?:\/\d{1,3})?$/i,
		/^(?:[a-f0-9]{1,4}:)(?::[a-f0-9]{1,4}){1,4}:(?:\d{1,3}\.){3}\d{1,3}(?:\/\d{1,3})?$/i,
		/^(?:[a-f0-9]{1,4}:){2}(?::[a-f0-9]{1,4}){1,3}:(?:\d{1,3}\.){3}\d{1,3}(?:\/\d{1,3})?$/i,	
		/^(?:[a-f0-9]{1,4}:){3}(?::[a-f0-9]{1,4}){1,2}:(?:\d{1,3}\.){3}\d{1,3}(?:\/\d{1,3})?$/i,
		/^(?:[a-f0-9]{1,4}:){4}(?::[a-f0-9]{1,4}):(?:\d{1,3}\.){3}\d{1,3}(?:\/\d{1,3})?$/i
	];
	var validIPv4Addresses = [
		//IPv4
		/^(\d{1,3}\.){3}\d{1,3}$/i
	];
	var validAddresses = [];
	if (format == 'ipv6' || format == 'ipv6_ipv4') {
		validAddresses = validAddresses.concat(validIPv6Addresses);
	}
	if (format == 'ipv4' || format == 'ipv6_ipv4') {
		validAddresses = validAddresses.concat(validIPv4Addresses);
	}

	var ret = false;
	for (var i=0; i<validAddresses.length; i++) {
		if (validAddresses[i].test(value)) {
			ret = true;
			break;
		}
	}

	if (ret && value.indexOf(".") != -1) {
		//if address contains IPv4 fragment, it must be valid; all 4 groups must be less than 256
		var ipv4 = value.match(/:?(?:\d{1,3}\.){3}\d{1,3}/i);
		if(!ipv4) {
			return false;
		}
		ipv4 = ipv4[0].replace(/^:/, '');
		var pieces = ipv4.split('.');
		if (pieces.length != 4) {
			return false;
		}
		var regExp = /^[\-\+]?\d*$/;
		for (var i=0; i< pieces.length; i++) {
			if (pieces[i] == '') {
				return false;
			}
			var piece = parseInt(pieces[i], 10);
			if (isNaN(piece) || piece > 255 || !regExp.test(pieces[i]) || pieces[i].length>3 || /^0{2,3}$/.test(pieces[i])) {
				return false;
			}
		}
	}
	if (ret && value.indexOf("/") != -1) {
		// if prefix-length is specified must be in [1-128]
		var prefLen = value.match(/\/\d{1,3}$/);
		if (!prefLen) return false;
		var prefLenVal = parseInt(prefLen[0].replace(/^\//,''), 10);
		if (isNaN(prefLenVal) || prefLenVal > 128 || prefLenVal < 1) {
			return false;
		}
	}
	return ret;
};

function validate_url(value)
{
	//the following validates an URL using ABNF rules as defined in http://tools.ietf.org/html/rfc3986 , Appendix A., page 49
	//except host which is extracted by match[1] and validated separately
	/*
	 * userinfo=	(?:(?:[a-z0-9\-\._~\!\$\&\'\(\)\*\+\,\;\=:]|%[0-9a-f]{2,2})*\@)?
	 * host=			(?:((?:(?:[a-z0-9][a-z0-9\-]*[a-z0-9]|[a-z0-9])\.)*(?:[a-z][a-z0-9\-]*[a-z0-9]|[a-z])|(?:\[[^\]]*\]))
	 * pathname=	(?:\/(?:[a-z0-9\-\._~\!\$\&\'\(\)\*\+\,\;\=\:\@]|%[0-9a-f]{2,2})*)*
	 * query=			(?:\?(?:[a-z0-9\-\._~\!\$\&\'\(\)\*\+\,\;\=\:\@\/\?]|%[0-9a-f]{2,2})*)?
	 * anchor=		(?:\#(?:[a-z0-9\-\._~\!\$\&\'\(\)\*\+\,\;\=\:\@\/\?]|%[0-9a-f]{2,2})*)?
	 */
	var regExp = /^(?:https?|ftp)\:\/\/(?:(?:[a-z0-9\-\._~\!\$\&\'\(\)\*\+\,\;\=:]|%[0-9a-f]{2,2})*\@)?(?:((?:(?:[a-z0-9][a-z0-9\-]*[a-z0-9]|[a-z0-9])\.)*(?:[a-z][a-z0-9\-]*[a-z0-9]|[a-z])|(?:\[[^\]]*\]))(?:\:[0-9]*)?)(?:\/(?:[a-z0-9\-\._~\!\$\&\'\(\)\*\+\,\;\=\:\@]|%[0-9a-f]{2,2})*)*(?:\?(?:[a-z0-9\-\._~\!\$\&\'\(\)\*\+\,\;\=\:\@\/\?]|%[0-9a-f]{2,2})*)?(?:\#(?:[a-z0-9\-\._~\!\$\&\'\(\)\*\+\,\;\=\:\@\/\?]|%[0-9a-f]{2,2})*)?$/i;

	var valid = value.match(regExp);
	if (valid) {
		//extract the  address from URL
		var address = valid[1];

		if (address) {
			if (address == '[]') {
				return false;
			}
			if (address.charAt(0) == '[' ) {
				//IPv6 address or IPv4 enclosed in square brackets
				address = address.replace(/^\[|\]$/gi, '');
				return validateIP(address, 'ipv6_ipv4');
			} else {
				if (/[^0-9\.]/.test(address)) {
					return true;
				} else {
					//check if hostname is all digits and dots and then check for IPv4
					return validateIP(address, 'ipv4');
				}
			}
		} else {
			return true;
		}
	} else {
		return false;
	}
}

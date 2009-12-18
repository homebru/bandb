// JavaScript Document

var theForm = document.forms['aspnetForm'];
if (!theForm) {
    theForm = document.aspnetForm;
}
function __doPostBack(eventTarget, eventArgument) {
    if (!theForm.onsubmit || (theForm.onsubmit() != false)) {
        theForm.__EVENTTARGET.value = eventTarget;
        theForm.__EVENTARGUMENT.value = eventArgument;
        theForm.submit();
    }
}

function CheckboxTrigger(obj)
{
        
       
      // alert(obj.name);
        var chkval = 0;
       
        if (obj.name == "chkClass$0")
        {
         var chkBoxList = document.getElementById("chkClass");
         var chkBoxCount= chkBoxList.getElementsByTagName("input");
           for(var i=0;i<chkBoxCount.length;i++)
            { 
            if (chkBoxCount[i].name != "chkClass$0")  {
            chkBoxCount[i].checked = false;}
            
             if (chkBoxCount[i].checked == true)  
                    {
                    chkval = 1;
                    }
             }
        }
        else if (obj.name == "chkClass$1")
        {
         var chkBoxList = document.getElementById("chkClass");
         var chkBoxCount= chkBoxList.getElementsByTagName("input");
           for(var i=0;i<chkBoxCount.length;i++)
            { 
            if (chkBoxCount[i].name != "chkClass$1")  {
            chkBoxCount[i].checked = false;}
            
             if (chkBoxCount[i].checked == true)  
                    {
                    chkval = 1;
                    }
             }
        }
        else
        {
         var chkBoxList = document.getElementById("chkClass");
         var chkBoxCount= chkBoxList.getElementsByTagName("input");
    
           for(var i=0;i<chkBoxCount.length;i++)
            { 
            if (chkBoxCount[i].name == "chkClass$0" || chkBoxCount[i].name == "chkClass$1"  )  {
            chkBoxCount[i].checked = false;}
            
              if (chkBoxCount[i].checked == true)  
                    {
                    chkval = 1;
                    }
            
             }
        }
        
        if ( chkval == 0 ){
        chkBoxCount[0].checked = true;
        }
        
        
        return false; 

}
 
function mRating(id)
{
var chkBox = document.getElementById(id);
var chkAll = document.getElementById('chkAll');
var chkOne = document.getElementById('chk1');
var chkTwo = document.getElementById('chk2');
var chkThree = document.getElementById('chk3');
var chkFour = document.getElementById('chk4');
var chkNR = document.getElementById('chk0');
var chkNull = document.getElementById('chkNR');
if (id == 'chkAll')
{
   chkOne.checked = false;
   chkTwo.checked = false;
   chkThree.checked = false;
   chkFour.checked = false;
   chkNR.checked = false;
   chkNull.checked = false;
}
if (id != 'chkAll')
{
  chkAll.checked = false;
}
}

 
function confApprove(id, imageButton)
{

  var ok = confirm('Are you sure you want to remove this?');    
    if (ok)                        
    {   
        //change the trashcan icon into an animated  ajax loading icon     
        imageButton.src = 'Images/icon-save.gif';
        //call the webservice execute the delete action
    }
    else
    {
        imageButton.src = 'Images/icon-cancel.gif';
    }            


}

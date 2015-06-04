function validateForm()
{
var appName=document.forms["form"]["appName"].value;
var description=document.forms["form"]["description"].value;
var platform=document.forms["form"]["platform"].value;
var downloadURL=document.forms["form"]["downloadURL"].value;
var iconURL=document.forms["form"]["iconURL"].value;

  if (appName==null || appName=="") {
  alert("Application name must be completed.");
  return false;
  }
  if (description==null || description=="") {
  alert("Application Description must be completed.");
  return false;
  }
  if (platform==null || platform=="") {
  alert("Platform must be completed.");
  return false;
  }
  if (downloadURL==null || downloadURL=="") {
  alert("Download URL must be completed.");
  return false;
  }
  if (iconURL == null || iconURL == "") {
  alert("Icon URL must be completed.");
  return false;
  }
}
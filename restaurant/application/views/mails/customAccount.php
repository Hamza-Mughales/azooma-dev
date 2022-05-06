<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" background-color:#00A2B1; width:100% !important; margin-top:30px;">
<tr>
<td height="1px">&nbsp;&nbsp;</td>
</tr>
<tr>
<td>

<table align="center" width="600px" style=" background-color:#FFFFFF;">
			<tr>
            <td colspan="2" align="left" style="padding-left:10px; padding-top:10px;" valign="top">
            <img src="http://www.sufrati.com/saudi-arabian-dining/images/<?php echo $logo; ?>" alt="Sufrati.com" /></td>
            </tr>
            
            <tr>
			<td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px; padding-top:12px;" colspan="2"><h1>Welcome To Sufrati.com</h1></td>
			</tr> 
            
            <tr>
			<td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;padding-left:10px; padding-right:10px;" colspan="2"><h2>Dear Sufrati.com</h2></td>
			</tr> 
            
            <tr>
            <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px;" >
           <?php echo ucwords($restname);?> Resturant wants to upgrade their account to a custom account for a duration of <?php echo $duration; ?> months.
            </td>
            </tr>
           <?php if($msg!=""){ ?> 
            <tr>
            <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px;">
            <h4>Additional Note from <?php echo ucwords($restname);?> Restaurant</h4>
            </td>
            </tr>
            <tr>
            <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px;">
           <?php echo $msg; ?>
            </td>
            </tr>
            <?php } ?>
                       
            <tr>
            <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px;">
            Please perpare invoice and membership form and contact <?php echo ucwords(restname);?> Resturant to upgrade their account.<br/>
            Their account subscription details are:<br/>
			Reference No: <?php echo $referenceNo; ?><br/>
			Request Date: <?php echo Date("Y-m-d");?><br/>
            </td>
            </tr>
            <tr><td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px;"><h4>Account Features</h4></td></tr>
            <tr><td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px;"><?php echo $features; ?></td></tr>
            
            <tr>
            <td colspan="2" height="10px"><h4><?php echo ucwords(restname);?> Contact Info</h4></td>
            </tr>
            
            <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px; color:#00A2B1;" width="35%"><strong>Manager Name: </strong></td>
    <td width="65%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;color:#00A2B1; padding-left:10px; padding-right:10px;">
    <strong><?php echo $fullname; ?></strong></td>
    </tr>
    
            
			<tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px;color:#00A2B1;" width="35%"><strong>Mobile Number: </strong></td>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px;color:#00A2B1;" width="65%"><strong><?php echo $phone;?></strong></td>
    		</tr>
            
            <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px;color:#00A2B1; padding-left:10px; padding-right:10px;" width="35%"><strong>Email: </strong></td>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px;color:#00A2B1; padding-left:10px; padding-right:10px;" width="65%"><strong><?php foreach ($emailList as $em) { echo $em." , ";}?></strong></td>
    		</tr>
			
               <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
<tr>
<td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px;">
Feel free to contact us for any information at info@azooma.co</td>
</tr> 
<tr><td colspan="2" height="20px"></td></tr>
<tr>
<td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px;">
Best regards
</td>
</tr>

<tr><td colspan="2" height="20px"></td></tr>
<tr>
				<td align="left" valign="top" height="160px" colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-top:10px; color:#FFFFFF; background-color:#000000;">
                                
                                <strong>Sufrati.Com Team<br />
                                </strong>P.O.Box 15780<br />
                                Jeddah 21454<br />
                                Kingdom of Saudi Arabia<br />
                                <br />
                                Telephone: <a rel="nofollow" style="color:#FFFFFF;">+966 2 6687892</a><br />
                                Fax: <a rel="nofollow" style="color:#FFFFFF;">+966 2 6687893</a><br />
                                Email:<a rel="nofollow" style="color:#FFFFFF;">info@azooma.co</a>
                                </td>
		</tr>

            
            </table>

</td>
</tr>

                        
<tr>
<td height="50px;">&nbsp;&nbsp;</td>
</tr>			   									  
</table>
</body>
</html>

<link href="style.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]> <html prefix="og: http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" class="ie7"> <![endif]-->  
<!--[if IE 8]>     <html prefix="og: http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" class="ie8"> <![endif]-->  
<!--[if IE 9]>     <html prefix="og: http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" class="ie9"> <![endif]-->



    <form name="login_form" method="post" class="main-login">
    
    <table width="335" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td><span class="login-error"><?php if (isset($logerror)) echo $logerror; ?></span></td>
    </tr>
    <tr>
    <td>User Name</td>
    </tr>
    <tr>
    <td><input type="text" name="loginfo[username]" id="username" size="30"/></td>
    </tr>
    <tr>
    <td>Password</td>
    </tr>
    <tr>
      <td><input type="password" name="loginfo[password]" id="password" size="30"/></td>
    </tr>
    <tr>
      <td style="text-align:right !important;"><input type="submit" name="submit_btn" value="Login" class="log-bgbtn"/></td>
    </tr>
    </table>


  </form>    


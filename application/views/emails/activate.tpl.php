<html>
<body style="text-align: center;">
<table width="500" cellspacing="0" cellpadding="0" style="border:1px solid #ccc; font-family: Arial, Helvetica, sans-serif; color: #6d7a83; text-align: center; margin: 0 auto;">
  <tr >
    <td width="500" style="border-bottom:1px solid #ccc; padding: 20px; text-align: center;"><img src="http://emplayo.com/emplayo.png" alt="Emplayo" /></td>
  </tr>
  <tr>
    <td><div style="color:#258CD1; font-weight: bold; font-size:20px; margin-top:15px;">Welcome to Emplayo!</div>
      <p>Click below to confirm your email address:</p>
      <?php echo anchor('auth/activate/'. $id .'/'. $activation, 'Confirm Email', 'style="display: block; width: 150px; height: 20px; background-color: #258CD1; color: #fff; padding: 10px; font-weight: bold; text-align: center; text-decoration: none; margin: 0 auto;"');?>
    <p>Or paste the following into your browser:</p>
    <div style="margin-bottom:15px;"><?php echo anchor('auth/activate/'. $id .'/'. $activation, base_url().'auth/activate/'. $id .'/'. $activation);?></div>
    </td>
  </tr>
  <tr>
    <td style="background-color: #6d7a83; padding:5px 30px; color: #fff; font-size: 11px; text-align: center;">&copy;2014 Emplayo, Inc. | All Rights Reserved</td>
  </tr>
</table>
</body>
</html>
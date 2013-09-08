<html>
<body style="text-align: center;">
<table width="500" cellspacing="0" cellpadding="0" style="border:1px solid #ccc; font-family: Arial, Helvetica, sans-serif; color: #6d7a83; text-align: center; margin: 0 auto;">
  <tr >
    <td width="500" style="border-bottom:1px solid #ccc; padding: 20px; text-align: center;" colspan="2"><img src="http://emplayo.com/emplayo.png" alt="Emplayo" /></td>
  </tr>
  <tr>
    <td colspan="2" style="padding: 0 20px;"><div style="color:#258CD1; font-weight: bold; font-size:20px; margin-top:15px;">Welcome to Emplayo!</div>
      <p>We're glad to see you here and we can't wait to match you <br/>with the companies that fit you best.</p>
      </td>
  </tr>
  <tr>
	<td width="250" style="border-right: dotted 1px #ccc;">
		<p>Get started now with the Work.Life.Play preferences:</p>
		<?php echo anchor('inquire', 'Get Started', 'style="display: block; width: 150px; height: 20px; background-color: #258CD1; color: #fff; padding: 10px; font-weight: bold; text-align: center; text-decoration: none; margin: 0 auto;"');?>
		<p>Or paste the following into your browser:</p>
		<div style="margin-bottom:15px;"><?php echo anchor('inquire', base_url().'inquire');?></div>
	</td>
	<td width="250">
		<p>To see the list of companies that fit you best, click below:</p>
		<?php echo anchor('login', 'Matches', 'style="display: block; width: 150px; height: 20px; background-color: #258CD1; color: #fff; padding: 10px; font-weight: bold; text-align: center; text-decoration: none; margin: 0 auto;"');?>
		<p>Or paste the following into your browser:</p>
		<div style="margin-bottom:15px;"><?php echo anchor('login', base_url().'login');?></div>
		</p>
	</td>
</tr>
  <tr>
    <td style="background-color: #6d7a83; padding:5px 30px; color: #fff; font-size: 11px; text-align: center;" colspan="2">&copy;2013 Emplayo, Inc. | All Rights Reserved</td>
  </tr>
</table>
</body>
</html>
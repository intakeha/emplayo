<script>

  $(function() {
    $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 400,
      width: 800,
      modal: true,
      buttons: {
        "Change Password": function() {
            $('#errors').html('');
            $('#success').html('');            
          //send to controller using ajax
          var $form = $( this ),
              old = $form.find( 'input[name="old"]' ).val(),
              new_p = $form.find( 'input[name="new_p"]' ).val(),
              new_confirm = $form.find( 'input[name="new_confirm"]' ).val();          
          
            $.post("/user/change_password_ajax", { old: old, new_p: new_p, new_confirm: new_confirm })
            .done(function(data) {
                var obj = jQuery.parseJSON(data);
                if (obj.success == 0){
                    $('#errors').html(obj.message);
                }else {
                    $('#success').html(obj.message);                  
                }
            }); 

        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        //allFields.val( "" ).removeClass( "ui-state-error" );
      }
    });
 
    $( "#change_password" )
      .button()
      .click(function() {
        $('#errors').html('');
        $('#success').html('');
        $('input[name="old"]').val('');
        $('input[name="new_p"]').val('');
        $('input[name="new_confirm"]').val('');
        $( "#dialog-form" ).dialog( "open" );
      });
  });    
    
</script>

<div id="profile">
	<div class="content">
            <?php if(!empty($message)){echo '<div id="message">'.$message.'</div>';} ?>
            <div id="intro"><p>Account Settings</p></div>
            
                <div><a href="#">Change your password</a><button style="font-size: 14px;" id="change_password">Change</button></div>
                <!--<div>Change your notification preferences:</div>-->
                <div>Update your work and education history:</div>
               <div>Update what you want to do next:</div>
               <div>Update where you want to work:</div>
               <div>Retake the Work-Life-Play survey...</div>
           
               
		<ul>

		</ul> 
<div id="dialog-form" title="Change your password">
  <div id="errors" style="color: red; font-size: 80%;"></div>
  <div id="success" style="color: blue; font-size: 80%;"></div>
 
  <form>
  <fieldset>
    <label for="old">Old Password</label>
    <input type="password" name="old" id="old"  />
    <br>
    <label for="new_p">New Password</label>
    <input type="password" name="new_p" id="new_p"  />
    <br>
    <label for="new_confirm">Confirm New Password</label>
    <input type="password" name="new_confirm" id="new_confirm"  /> 
    <br>
  </fieldset>
  </form>
</div>               
               
	</div>
</div>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo isset($title) ? "Emplayo - $title" : "Emplayo"; ?></title>
	<meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/select2.css" type="text/css"/>
	
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>	

        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/select2.min.js"></script>

        

        <script>
$(document).ready(function(){
    
   $('#location').select2({
    multiple: true,
    minimumInputLength: 1,
    width: 300,
    createSearchChoice:function(term, data) {
        if ($(data).filter(function() {         
            return this.text.localeCompare(term)===0; }).length===0) {
            return {id:term, text:term};          
        } 
    },
    ajax: {
      url: "/inquire/location_search",
      dataType: 'json',
      data: function (term, page) {
        return {
          searchterm: term
        };
      },
      results: function (data, page) {
        return { results: data };
        
      }
    }
  });
  $("#location")
    .on("change", function(e) {
        console.log(e);
        if (e.added.id==e.added.text){
            $('#location').val("user_"+e.added.id+"," + $(this).val());
        }else {
            
        };
    })  
  
   $('#industry').select2({
    multiple: true,
    minimumInputLength: 1,
    width: 300,
    createSearchChoice:function(term, data) {
        if ($(data).filter(function() {         
            return this.text.localeCompare(term)===0; }).length===0) {
            return {id:term, text:term};          
        } 
    },
    ajax: {
      url: "/inquire/industry_search2",
      dataType: 'json',
      data: function (term, page) {
        return {
          searchterm: term
        };
      },
      results: function (data, page) {
        return { results: data };
        
      }
    }
  });
  $("#industry")
    .on("change", function(e) {
        console.log(e);
        if (e.added.id==e.added.text){
            $('#industry').val("user_"+e.added.id+"," + $(this).val());
        }else {
            
        };
    })    
    
   $('#college').select2({
    multiple: true,
    minimumInputLength: 1,
    width: 300,
    createSearchChoice:function(term, data) {
        if ($(data).filter(function() {         
            return this.text.localeCompare(term)===0; }).length===0) {
            return {id:term, text:term};          
        } 
    },
    ajax: {
      url: "/inquire/college_search",
      dataType: 'json',
      data: function (term, page) {
        return {
          searchterm: term
        };
      },
      results: function (data, page) {
        return { results: data };
        
      }
    }
  });
  $("#college")
    .on("change", function(e) {
        console.log(e);
        if (e.added.id==e.added.text){
            $('#college').val("user_"+e.added.id+"," + $(this).val());
        }else {
            
        };
    })  

$("#degree").select2({
    width: 300,
    placeholder: "Select a Degree"
});
$("#tester").select2({
    width: 300,
    placeholder: "Select a State"
});    
    
});            
            
</script>

</head>
<body>

<!--
<div id="19" class="questions q19"  name="textChoice">
        <div>Where would you like to work?</div>
        <div id="location" >
                <input id="q19_0" class="location" type="text" value="" name="user_location[]" />
        </div>
</div>-->
<form id="logo_crop_form" action="/inquire/blah" method="POST"> 
<label>Location :</label>
<input type="hidden" name="user_location[]" id="location" data-placeholder="Choose A Location.." />    
<input type="submit" name="submit" value="Submit" />
</form>

<form id="logo_crop_form2" action="/inquire/blah" method="POST"> 
<label>Industry :</label>
<input type="hidden" name="user_industry[]" id="industry" data-placeholder="Choose An Industry.." />    
<input type="submit" name="submit" value="Submit" />
</form>

<form action="/inquire/blah" method="POST"> 
<label>College :</label>
<input type="hidden" name="user_college[]" id="college" data-placeholder="Choose A College.." />    
<input type="submit" name="submit" value="Submit" />
</form>

<form action="/inquire/blah" method="POST"> 
    <select name="degree" id="degree">
        <option></option>
        <?php
        if (!empty($degree_array)){
            foreach ($degree_array as $value) {
                echo "<option value='{$value['id']}'>{$value['degree']} - {$value['short']}</option>";          
            }   
        }
        ?>
    </select>
    <input type="submit" name="submit" value="Submit" />
</form>



    </body>
</html>
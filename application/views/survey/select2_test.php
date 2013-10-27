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
   //LOCATION - Multi
   $('#location').select2({
    multiple: true,
    minimumInputLength: 1,
    maximumSelectionSize: 5,
    width: 300,
    formatSearching: function() {
        return "Searching...";
    },
    ajax: {
      url: "/survey/location_search",
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
  //The following function is optional...Select2 will automatically add additional values
  //to the value param using commas
  $("#location")
    .on("change", function(e) {
        $('#q19').append('<input id="q19_1_0" type="text" name="user_location[]"  value="'+e.added.id+'">');
       // console.log(e);
       // if (e.added.id==e.added.text){
            //If the id and text of an added term are the same. 
            //$('#location').val();
            //console.log(e);
        //}else {
            //console.log(e);
       // };
    });  
  
  //INDUSTRY - Multi
   $('#industry').select2({
    multiple: true,
    minimumInputLength: 0,
    maximumSelectionSize: 5,
    width: 300,
    ajax: {
      url: "/survey/industry_search",
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
            //$('#industry').val("user_"+e.added.id+"," + $(this).val());
            $('#industry').$(this).val();
        }else {
            
        };
    })    
    
   //EDUCATION - COLLEGE NAME
   $('#college_name').select2({
    multiple: false,
    minimumInputLength: 1,
    maximumSelectionSize: 1,
    width: 300,
    createSearchChoice:function(term, data) {
        if ($(data).filter(function() {         
            return this.text.localeCompare(term)===0; }).length===0) {
            return {id:term, text:term};          
        } 
    },
    ajax: {
      url: "/survey/college_name_search",
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
  $("#college_name")
    .on("change", function(e) {
        console.log(e);
        if (e.added.id==e.added.text){
            //$('#college_name').val("user_"+e.added.id+"," + $(this).val());
            $('#college_name').val($(this).val());            
        }else {
            
        };
    })      
 
   //EDUCATION - DEGREE
   $('#college_degree').select2({
    multiple: false,
    minimumInputLength: 0,
    maximumSelectionSize: 1,
    width: 300,
    createSearchChoice:function(term, data) {
        if ($(data).filter(function() {         
            return this.text.localeCompare(term)===0; }).length===0) {
            return {id:term, text:term};          
        } 
    },
    ajax: {
      url: "/survey/college_degree_search",
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
  $("#college_degree")
    .on("change", function(e) {
        console.log(e);
        if (e.added.id==e.added.text){
            $('#college_degree').val("user_"+e.added.id+"," + $(this).val());
        }else {
            
        };
    })  

   //EDUCATION - FIELD / MAJOR
   $('#field_id').select2({
    multiple: false,
    minimumInputLength: 0,
    maximumSelectionSize: 1,
    width: 300,
    createSearchChoice:function(term, data) {
        if ($(data).filter(function() {         
            return this.text.localeCompare(term)===0; }).length===0) {
            return {id:term, text:term};          
        } 
    },
    ajax: {
      url: "/survey/college_major_search",
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
  $("#field_id")
    .on("change", function(e) {
        console.log(e);
        if (e.added.id==e.added.text){
            $('#field_id').val("user_"+e.added.id+"," + $(this).val());
        }else {
            
        };
    })  

   //WORK - COMPANY NAME
   $('#company_name').select2({
    multiple: false,
    minimumInputLength: 0,
    maximumSelectionSize: 1,
    width: 300,
    createSearchChoice:function(term, data) {
        if ($(data).filter(function() {         
            return this.text.localeCompare(term)===0; }).length===0) {
            return {id:term, text:term};          
        } 
    },
    ajax: {
      url: "/survey/company_name_search",
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
  $("#company_name")
    .on("change", function(e) {
        console.log(e);
        if (e.added.id==e.added.text){
            $('#company_name').val("user_"+e.added.id+"," + $(this).val());
        }else {
            
        };
    }) 

   //WORK - JOB TYPE
   $('#job_type').select2({
    multiple: false,
    minimumInputLength: 0,
    maximumSelectionSize: 1,
    width: 300,
    createSearchChoice:function(term, data) {
        if ($(data).filter(function() {         
            return this.text.localeCompare(term)===0; }).length===0) {
            return {id:term, text:term};          
        } 
    },
    ajax: {
      url: "/survey/job_type_search",
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
  $("#job_type")
    .on("change", function(e) {
        console.log(e);
        if (e.added.id==e.added.text){
            $('#job_type').val("user_"+e.added.id+"," + $(this).val());
        }else {
            
        };
    }) 

    
});            
            
</script>

</head>
<body>

<div id="q19">
    <form id="my_form5" action="/survey/select2_post_loc" method="POST"> 
    <div><input type="hidden" name="user_location[]" id="location" data-placeholder="Choose A Location.." /></div>   
    <input type="submit" name="submit" value="Submit" />
    </form>
</div>
    
<form id="my_form6" action="/survey/select2_post" method="POST"> 
<div><input type="hidden" name="user_industry[]" id="industry" data-placeholder="Choose An Industry.." /></div>
<input type="submit" name="submit" value="Submit" />
</form>

<div><input type="hidden" name="user_education[][school_name]" id="college_name" data-placeholder="Choose A College Name..." /></div> 

<div><input type="hidden" name="user_education[][degree_name]" id="college_degree" data-placeholder="Choose A Degree..." /></div>

<div><input type="hidden" name="user_education[][field_id]" id="field_id" data-placeholder="Choose A Field/Major..." /></div>    

<div><input type="hidden" name="user_work[][company_name]" id="company_name" data-placeholder="Choose A Company Name..." /></div>

<div><input type="hidden" name="user_work[][job_type]" id="job_type" data-placeholder="Choose A Job Type..." /></div>




<!-- to test submitting values, use the following template:
<form id="my_form6" action="/survey/select2_post" method="POST"> 
<label>Job Type:</label>
<input type="hidden" name="user_work[][job_type]" id="job_typex" data-placeholder="Choose A Job Type..." />    
<input type="submit" name="submit" value="Submit" />
</form>
-->

</body>
</html>
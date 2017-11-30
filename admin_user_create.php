<script>
function showUserName()
{
	
	alert("Hi git");
}

function userValidation() {
    var validator = jQuery("#userform").bootstrapValidator({
        feedbackIcons: {
            valid: "glyphicon glyphicon-ok",
            invalid: "glyphicon glyphicon-remove",
            validating: "glyphicon glyphicon-refresh"
        },
        fields: {
            name: {
                message: "First Name is required",
                validators: {
                    notEmpty: {
                        message: "Please enter first name"
                    },
                    stringLength: {
                        min:2,
                        max: 30,
                        message: 'The Search keyword must be more than 2 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The Search keyword can only consist of alphabetical, number and underscore'
                    }
                }
            },
			   last_name: {
                message: "Last Name is required",
                validators: {
                    notEmpty: {
                        message: "Please enter last name"
                    },
                    stringLength: {
                        min:2,
                        max: 30,
                        message: 'The Search keyword must be more than 2 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The Search keyword can only consist of alphabetical, number and underscore'
                    }
                }
            },
			 email: {
                message: "Email address is required",
                validators: {
                    notEmpty: {
                        message: "Please provide Email address"
                    },
                    emailAddress: {
                        message: "Email address was invalid"
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: "Password is required"
                    },
                    stringLength: {
                        min: 6,
                        message: "Password must be at least 6 characters long"
                    },
                    different: {
                        field: "email",
                        message: "Email and Password cannot match"
                    }
                }
            },
           
            contact_no: {
                validators: {
                    notEmpty: {
                        message: "Contact number is Required"
                    },
					stringLength: {
                        min: 10,
                        max: 10,
                        message: 'The phone must be more than 10 and less than 30 characters long'
                    },
					regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'The Search keyword can only consist of alphabetical, number and underscore'
                    }
                }
            },
			 address: {
                message: "Address is required",
                validators: {
                    notEmpty: {
                        message: "Please enter your address"
                    },
                    stringLength: {
                        min:25,
                        max: 250,
                        message: 'Address must be 25 characters long'
                    },
                    
                }
            },
			country: {
                message: "Country is required",
                validators: {
                    notEmpty: {
                        message: "Please select your country"
                    },
                                       
                }
            },
			vehicle: {
                message: "Organization is required",
                validators: {
                    notEmpty: {
                        message: "Please select your organization"
                    },
                                       
                }
            },
			categories: {
                message: "User role is required",
                validators: {
                    notEmpty: {
                        message: "Please select your role"
                    },
                                       
                }
            },
			application: {
                message: "Application is required",
                validators: {
                    notEmpty: {
                        message: "Please select your application"
                    },
                                       
                }
            },
        }
    });
}
jQuery(function() {
jQuery("#county_id").autocomplete({
					source: function(request, response) {
					jQuery.getJSON("<?php echo base_url();?>admin/geographical/countryAtoCompletebox/", { term: jQuery('#county_id').val()}, 
							  response);
				  },				
               minLength: 1,
			   select: function(event, ui) {
				   jQuery("#county_id").val(ui.item.country);
		           document.getElementById('county_id').value=ui.item.country;      
		           //jQuery("#country_code").val( ui.item.country_code );
		           //jQuery("#timezome_name").val( ui.item.timezome_name );
				 
				 
                }			   
            });
});
</script>



<script>
var roleChecked = [];
var applicationChecked = [];
function createUser()
		{
			
		    userValidation();
			var validator = jQuery('#userform').data('bootstrapValidator');
          validator.validate();
        if (validator.isValid()) {
			
				var selectBox = document.getElementById('categories');
				var role=GetSelectValues(selectBox );			 
			   var selectBox = document.getElementById('application');
			   var application=GetSelectValues(selectBox );
			
			
				//var username=document.getElementById("uname").value;
				var name=document.getElementById("name").value;
				var last_name=document.getElementById("last_name").value;
				var email=document.getElementById("email").value;
				var country=document.getElementById("county_id").value;
				var password=document.getElementById("pw").value;
				var address=document.getElementById("address").value;
				var contact_no=document.getElementById("contact_no").value;
				var description=document.getElementById("description").value;
				//var age=document.getElementById("age").value;
				var id=document.getElementById("id").value;
			
			
			var dataString = "name=" + name + "&last_name=" + last_name +	"&email=" + email + "&country=" + country + "&password=" + password + "&address=" + address + "&description=" + description	+  "&contact_no="+ contact_no +"&userrole="+ role+"&application="+application+"&id="+id; 			
			//alert(dataString);
			
			
			jQuery.ajax
			({
				type: "POST",
				url: "<?= base_url();?>admin/user/create",
				data: dataString,
				cache: false,
				success: function(html)
				{
					
					document.getElementById('messageDivId').style.display="block";
					
					var obj = eval('('+html+')');                     					 
					if(jQuery.trim(obj[0]['responce_code'])==200 || jQuery.trim(obj[0]['responce_code'])==201)
					{
						//alert("Hello"+obj[2]['responce_api']);
						if(obj[1]['responce_message']=="" && obj[2]['responce_api']=='Done')
						{
						  jQuery(".alert").addClass("alert-success");
                          jQuery(".alert").removeClass("alert-danger");
						  //jQuery("#outputID").html(obj[1]['responce_message']);	
						   jQuery("#outputID").html("Record updated successfully."); 
							
						}else{
							jQuery(".alert").addClass("alert-success");
							jQuery(".alert").removeClass("alert-danger");
							jQuery("#outputID").html("User has been created successfully.");	
						}
                    }else if(jQuery.trim(obj[0]['responce_code'])==401)
					{
						window.location.href = "<?= base_url();?>admin/dashboard/logout";
						
					}else{
						
						jQuery(".alert").addClass("alert-danger");
                        jQuery(".alert").removeClass("alert-success");
						jQuery("#outputID").html("Access has not been created successfully.");	
					}					
					
				} 
			});
		  }
			
		}

</script>

<script language='JavaScript'>

function GetSelectValues(select) {
  var result = [];
  var options = select && select.options;
  var opt;

  for (var i=0, iLen=options.length; i<iLen; i++) {
    opt = options[i];

    if (opt.selected) {
      result.push(opt.value || opt.text);
    }
  }
  return result;
}

		
		
	</script>
	<link href="<?php echo base_url();?>css/jquery-ui.css" rel="Stylesheet"></link>
<script src="<?php echo base_url();?>js/jquery-ui.min.js" type="text/javascript"></script>
<input type="hidden" name="id" id="id" value="<?php echo $admin['user']?>">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
	  <?php //print_r($admin);
	//  echo $admin['organization'];
	  ?>
	  
        <i class="fa fa-users"></i> <?php echo $title; ?>
        
		<?php
$byttonLabel=($admin['user']>0) ? "Update User": "Create User";
?>
<small> <?php echo $byttonLabel;?> </small>
      </h1>
    </section>
    
    <section class="content">
	<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter User Details</h3>
						
						<div class="alert alert-success alert-dismissable" id="messageDivId" style="display:none;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<div id="outputID"></div>
						</div>
						
						
                    </div><!-- /.box-header -->
                    <!-- form start -->

<?php 
$attributes = array('class' => 'form', 'id' => 'userform','method' => 'POST');

echo form_open('admin/user/create',$attributes);?>
 <div class="box-body">
 
  <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">First Name</label>
                                        <?php 
										$data = array('name'=>'name','id'=>'name','size'=>25, 'class'=>'form-control' ,'value'=>$admin['first_name']);
                                          echo form_input($data)
										?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="uname">Last Name</label>
                                      <?php $data = array('name'=>'last_name','id'=>'last_name','size'=>25, 'class'=>'form-control','value'=>$admin['last_name']);
                                        echo form_input($data)?>
                                    </div>
                                    
                                </div>
  </div>
  <div class="row">
                                
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="uname">Username</label>
                           <?php $data = array('name'=>'username','id'=>'uname','size'=>25, 'class'=>'form-control','value'=>$admin['username'],'readonly'=>'readonly');
                                        echo form_input($data)?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">
				<div class="form-group">
					<label for='pw'>Password</label>
					<?php
					$id=$admin['user'];
				    if($id>0)
		            {
					$data = array('name'=>'password','id'=>'pw','class'=>'form-control', 'size'=>25, 'value'=>'xxxxxx','readonly'=>'readonly');
					echo form_password($data);
										
					}
					else
					{
					$data = array('name'=>'password','id'=>'pw','class'=>'form-control', 'size'=>25, 'value'=>$admin['password']);
					echo form_password($data);
					}
					?>
				</div>
			</div>
								
  </div>
		<div class="row">
		<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Contact Number</label>
                                        <?php 
						$data = array('name'=>'contact_no','id'=>'contact_no','size'=>25,'maxlength'=>'10', 'class'=>'form-control' ,'value'=>$admin['contact_no']);
                                          echo form_input($data)
										?>
                                    </div>
                                </div>
			<div class="col-md-6">                                
				<div class="form-group">
					<label for='email'>Email</label>
					<?php 
					$data = array('name'=>'email','id'=>'email','size'=>25, 'class'=>'form-control email','value'=>$admin['email']);
					echo form_input($data);
					?>
				</div>
			</div>
			
		</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for='address'>Address</label><br/>
							<?php 
							$data = array('name'=>'address','id'=>'address',"rows"=>3,'class'=>'form-control',"cols"=>30);
							echo form_textarea($data);
							?>
						</div>
					</div>
					
					<div class="col-md-6">                                
						<div class="form-group">
							<label for='description'>Description</label><br/>
							<?php 
							$data = array('name'=>'description','id'=>'description','class'=>'form-control', 'cols'=>30, 'rows'=>3);
							echo form_textarea($data) ;
							?>
						</div>
					</div>
					
				</div>
				
				

                        <div class="row">
							<div class="col-md-6">                                
								<div class="form-group">
								<label for='country'>Country</label>
								<?php 
								//echo form_dropdown('country',$country,$admin['country'],'class="form-control",');    //country->country_id
								
								$data = array('name'=>'country','id'=>'county_id','size'=>25, 'class'=>'form-control email','value'=>$admin['country']);
					             echo form_input($data);
								?>
								</div>
							</div>
							<div class="col-md-6">
							<div class="form-group">
							<label for='parent'>User Organization</label>
							<?php 
							$vehicle=array(""=>"Please select organization","CONCORD MOTORS"=>"Tata Motors","TTL"=>"TTL");
							//echo form_dropdown('vehicle',$vehicle,'default','class="form-control"');
							echo form_dropdown('vehicle',$vehicle,$admin['organization'],'class="form-control"');
										
							?>
						</div>
					</div>
							</div>
			        
				
			<div class="row">
						<div class="col-md-6">                                
								<div class="form-group">
                                 <label for='reports_to'>Reporting</label>
                                 <?php
                                 echo form_dropdown('reports_to',$user_list,'default','class="form-control" id="reports_to"');       //region->region_id
                                 ?>
                                 </div>
							</div>
							<div class="col-md-6">                                
								<div class="form-group">
								<label for='reports_alternative'>Alternate Reporting</label>
								<?php 
								echo form_dropdown('reports_alternative',$user_list,'default','class="form-control" id="reports_alternative"');    //country->country_id
								?>
								</div>
							</div>
			</div>   
			<div class="row">
				        <div class="col-md-6">
								<div class="form-group">
								<label for='parent'>User Role</label><br/>
								<?php 
								//echo form_multiselect('parentid',$categories,$admin['role'],'class="form-control roleClass" id="parentid"');
								?>
								<?php 
								$categories=json_decode($categories);
								$categories_array=array();
								$categories_array[]="Please select role";
								foreach($categories->role_list as $list)
								{									
								
									$categories_array[$list->name]=$list->name;
									
								}
								//print_r($application_array);
								echo form_multiselect('categories',$categories_array,$admin['role'],'class="form-control categories" id="categories"');
								?>
								</div>
							</div>

					<div class="col-md-6">                                
							<div class="form-group">
							<label for='status'>Status</label>
								<?php 
								$options = array('active' => 'Active', 'inactive' => 'Inactive');
								echo form_dropdown('status',$options, 'default','class="form-control"') ;
								
								?>
							</div>
					</div>
				</div>
				<div class="row">
				        <div class="col-md-6">
								<div class="form-group">
								<label for='parent'>Applications</label><br/>
								<?php 
								$application=json_decode($application);
								$application_array=array();
								$application_array[]="Please select application";
								foreach($application as $list)
								{									
								
									$application_array[$list->app_name]=$list->app_name;
									
								}
								//print_r($application_array);
								echo form_multiselect('application',$application_array,$admin['apps'],'class="form-control application" id="application"');
								?>
								</div>

							</div>

					<div class="col-md-6">                                
							
					</div>
				</div>
				<?php
				$byttonLabel=($admin['user']>0) ? "Update User": "Create User";
				?>
					<div class="box-footer">
							<input type="button" class="btn btn-primary" value="<?php echo $byttonLabel;?>" onclick="createUser()"/>
							<input type="reset" class="btn btn-default" value="Reset" />
					</div>
					<?php echo form_close();?>
						
						 </div>
 </div>
            </div>
			
            </div>
</section>
    
</div>












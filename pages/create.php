
<?php include_once('./header.php') ?>
<?php include_once('./models/fetch_business_type.php') ?>
<?php 
    session_start();
?>
<style>
    .star{
      color:red;
    }
    .btn a{
        color: white;
    }

</style>
<script>
    function updateSubType(){ 
        var business_type = document.getElementById('business_type').value;
        var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.getElementById('business_subtype').innerHTML = xhttp.responseText;
            }
         };
        xhttp.open("GET", "/ShopInfo/pages/models/fetch_business_subtype.php?business_type="+ business_type, true);
        xhttp.send();
       
    }

    function toggleManagerInput(){
        if(document.getElementById('managedBy').value == "Mangager"){
            document.getElementById('managerName').style.visibility = "hidden";
        }

    }

 
</script>
<div class="container">
    <h3 class="text-primary my-3">Create Your shop</h3>
    <form action='./models/verify_application.php' method="post">

        <div class="row">
            <div class="col-md-6">
            <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">Company/Shop name<span class="star">*</span></span>
            </div>
            <input type="text" class="form-control" name="shop_name">
        </div>
            </div>
        </div>

        <div class="table-title my-3">
            <h6>Company/Shop address:<h6>
        </div>
        
        <div class="row">
            <div class="col-md-6">
            <div class="input-group mb-1">
        
        <div class="input-group-prepend">
            <span class="input-group-text">street<span class="star">*</span></span>
        </div> 
        <input type="text" class="form-control" name="address_street">            
         </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
            <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">suburb<span class="star">*</span></span>
            </div> 
            <input type="text" class="form-control" name="address_suburb">

                     
        </div>
            </div>
            <div class="col-md-6">
            <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text">postcode<span class="star">*</span></span>
            </div>            
            <input type="text" class="form-control" name="address_postcode"> 
                     
        </div>
            </div>
        </div>


        <div class="table-title my-3">
            <h6>Company/Shop Business Info:<h6>
        </div>
        <div class="row">
            <div class="col-md-6">
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">bussiness type<span class="star">*</span></label>
                </div>
                <select class="custom-select" id="business_type" name="business_type" onchange="updateSubType()">
                    <option selected>--None--</option>
                    <?php
                        foreach($business_types as $business_type){
                            echo "<option value=".$business_type['business_type'].">".$business_type['business_type']."</option>";
                        }
                    ?>
                </select>
                </div>
            </div>
            <div class="col-md-6">
            <div class="input-group mb-1">    
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Subtype<span class="star">*</span></label>
            </div>
            <select class="custom-select" id="business_subtype" name="business_subtype">
   
            </select>
        </div> 
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
            <div class="input-group mb-1">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">nationality<span class="star">*</span></label>
            </div>
            <select class="custom-select" id="inputGroupSelect01" name="nationality">
                <option selected>--None--</option>
                <option value="Chinese">Chinese</option>
                <option value="Thai">Thai</option>
                <option value="japan">japan</option>
                <option value="Aussie">Aussie</option>
                <option value="Italy">Italy</option>
            </select>
        </div>  
            </div>
        </div>




        <div class="table-title my-3">
            <h6>Director info:<h6>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Owner name<span class="star">*</span></label>
                </div>
                <input type="text" class="form-control" name="owner_name">  
                </div>     
            </div>
        </div>    

        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">mobile number<span class="star">*</span></label>
                </div>
                <input type="text" class="form-control" name="owner_mobile">
              </div>   
            </div>
            <div class="col-md-6">
                <div class="input-group mb-1">       
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">shop phone number</label>
                </div>
                <input type="text" class="form-control" name="shop_number">     
               </div>  
             </div>
        </div>



 

 

        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">managed by<span class="star">*</span></label>
                </div>
                <select class="custom-select" id="managedBy" name="managed_by" onchange="toggleManagerInput()">
                    <option value="Owner">Owner</option>
                    <option value="Manager">Manager</option>
                </select>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01" id="managerName">manager name</span></label>
                    </div>
                    <input type="text" class="form-control" name="manager_name">  
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">manager phone</span></label>
                    </div>
                    <input type="text" class="form-control" name="manager_phone">       
                 </div>
            </div>
        </div>


        <div class="table-title my-3">
            <h6>POS & payment method:<h6>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">POS</label>
                    </div>
                    <input type="text" class="form-control"  value="AUPOS" name="pos">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">QR payment</label>
                    </div>
                    <input type="text" class="form-control"  value="Red payment" name="QR_payment">     
                 </div>
            </div>
        </div>
   


        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Satisfaction</label>
                </div>
                <select class="custom-select" id="inputGroupSelect01" name="satisfaction">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                </div> 
            </div>
        </div>


        <div class="table-title my-3">
            <h6>Comment:</h6>  
        </div>
        <div class="form-group"> 
                   
            <textarea class="form-control" name="comment"></textarea> 
        </div>
      

        <div class="row">
            <button class="btn btn-primary mx-3 my-3" type="submit">Create Shop</button>
            <div class="btn btn-primary my-3 mx-3 ml-auto"><a href="/ShopInfo/pages/main.php">Back</a></div>
            
        </div>
    

    </form>
</div>
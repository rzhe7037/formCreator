<?php include_once('./header.php') ?>
<?php include_once('./models/search_all_users.php') ?>

<div class="container">
    <h3 class="text-primary my-3">View all shops</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Shop/Company name</th>
                <th>Shop/Company address</th>
                <th>Business type</th>
                <th>Owner</th>
                <th>mobile number</th>
                <th>POS</th>
                <th>QR payment</th>
                <th>Creator</th>
            </tr>
        </thead>
        <tbody>
            <?php 
               foreach ($rows as $row){
                    echo "<tr>
                            <td>".$row['company_name']."</td>
                            <td>".$row['address_street']." ".$row['address_suburb'].", ".$row['address_postcode']."</td>
                            <td>".$row['business_type']."</td>
                            <td>".$row['owner_name']."</td>
                            <td>".$row['owner_mobile']."</td>
                            <td>".$row['pos']."</td>
                            <td>".$row['QR_payment']."</td>
                            <td>".$row['creator']."</td>
                        </tr>";
                                
               }
            ?>
        </tbody>
</div>